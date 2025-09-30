<?php
/**
 * Secure File Download Proxy
 * 
 * This proxy handles all file downloads with:
 * - User authentication
 * - Access control checks
 * - Audit logging
 * - Proper headers for security
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/model/db_connect.php';
require_once __DIR__ . '/src/model/FileAccessControl.php';
require_once __DIR__ . '/src/model/FileConfig.php';

use UIURP\Model\FileAccessControl;
use UIURP\Model\FileConfig;
use MongoDB\BSON\ObjectId;

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_data'])) {
    http_response_code(401);
    die('Unauthorized: Please log in to access files');
}

// Get user ID from session
$userId = null;
if (isset($_SESSION['user_id'])) {
    if (is_object($_SESSION['user_id']) && get_class($_SESSION['user_id']) === 'MongoDB\BSON\ObjectId') {
        $userId = (string)$_SESSION['user_id'];
    } else {
        $userId = $_SESSION['user_id'];
    }
} elseif (isset($_SESSION['user_data']['_id']['$oid'])) {
    $userId = $_SESSION['user_data']['_id']['$oid'];
} elseif (isset($_SESSION['user_data']['_id'])) {
    $userId = (string)$_SESSION['user_data']['_id'];
}

if (!$userId) {
    http_response_code(401);
    die('Unauthorized: Invalid session');
}

// Get requested file path
$filePath = $_GET['file'] ?? '';

if (empty($filePath)) {
    http_response_code(400);
    die('Bad Request: No file specified');
}

// Sanitize file path to prevent directory traversal attacks
$filePath = str_replace(['../', '..\\'], '', $filePath);
$filePath = ltrim($filePath, '/');

// Construct absolute file path
$absolutePath = __DIR__ . '/' . $filePath;

// Verify file exists
if (!file_exists($absolutePath) || !is_file($absolutePath)) {
    http_response_code(404);
    die('File not found');
}

try {
    // Connect to database
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Check access permissions
    $accessControl = new FileAccessControl($db);
    $accessResult = $accessControl->checkFileAccess($filePath, $userId);
    
    if (!$accessResult['authorized']) {
        // Log unauthorized access attempt
        $accessControl->logFileAccess($userId, $filePath, 'download', false);
        
        http_response_code(403);
        die('Forbidden: ' . $accessResult['message']);
    }
    
    // Log successful file access
    $accessControl->logFileAccess($userId, $filePath, 'download', true);
    
    // Get file information
    $fileSize = filesize($absolutePath);
    $fileName = basename($absolutePath);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $absolutePath);
    finfo_close($finfo);
    
    // Determine if file should be displayed inline or as download
    $disposition = 'attachment'; // Default to download
    
    // For certain file types, allow inline display
    $inlineTypes = [
        'application/pdf',
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'video/mp4',
        'video/webm',
        'text/plain'
    ];
    
    if (isset($_GET['inline']) && $_GET['inline'] === '1' && in_array($mimeType, $inlineTypes)) {
        $disposition = 'inline';
    }
    
    // Clear any previous output
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Set security headers
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    
    // Set content headers
    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . $fileSize);
    header('Content-Disposition: ' . $disposition . '; filename="' . $fileName . '"');
    
    // Cache control
    header('Cache-Control: private, max-age=3600');
    header('Pragma: private');
    
    // Support for partial content (range requests) - useful for video streaming
    $range = $_SERVER['HTTP_RANGE'] ?? '';
    
    if ($range && preg_match('/bytes=(\d+)-(\d*)/i', $range, $matches)) {
        $start = intval($matches[1]);
        $end = !empty($matches[2]) ? intval($matches[2]) : $fileSize - 1;
        
        if ($start > $end || $start >= $fileSize || $end >= $fileSize) {
            http_response_code(416);
            header('Content-Range: bytes */' . $fileSize);
            die();
        }
        
        $length = $end - $start + 1;
        
        http_response_code(206);
        header('Accept-Ranges: bytes');
        header('Content-Range: bytes ' . $start . '-' . $end . '/' . $fileSize);
        header('Content-Length: ' . $length);
        
        // Output partial content
        $file = fopen($absolutePath, 'rb');
        fseek($file, $start);
        
        $chunkSize = 8192; // 8KB chunks
        while (!feof($file) && ftell($file) <= $end) {
            $bytesToRead = min($chunkSize, $end - ftell($file) + 1);
            echo fread($file, $bytesToRead);
            flush();
        }
        
        fclose($file);
    } else {
        // Output full content
        header('Accept-Ranges: bytes');
        
        // For large files, output in chunks
        if ($fileSize > 1048576) { // > 1MB
            $file = fopen($absolutePath, 'rb');
            while (!feof($file)) {
                echo fread($file, 8192);
                flush();
            }
            fclose($file);
        } else {
            // For small files, output directly
            readfile($absolutePath);
        }
    }
    
} catch (Exception $e) {
    error_log('Download error: ' . $e->getMessage());
    http_response_code(500);
    die('Internal Server Error');
}
