<?php
// Set upload limits at runtime
ini_set('upload_max_filesize', '25M');
ini_set('post_max_size', '26M');
ini_set('memory_limit', '256M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once 'db_connect.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

session_start();

// Log current PHP settings
error_log('Current PHP settings:');
error_log('upload_max_filesize: ' . ini_get('upload_max_filesize'));
error_log('post_max_size: ' . ini_get('post_max_size'));
error_log('memory_limit: ' . ini_get('memory_limit'));

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'filePath' => null,
    'debug_info' => [
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit')
    ]
];

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit;
}

// Check if required data is provided
if (!isset($_POST['projectId']) || !isset($_FILES['file'])) {
    $response['message'] = 'Missing required fields';
    echo json_encode($response);
    exit;
}

try {
    $projectId = $_POST['projectId'];
    $userId = $_POST['userId'];
    $userName = $_POST['userName'];
    $file = $_FILES['file'];

    // Check for upload errors with detailed messages
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_INI_SIZE:
            $max_size = ini_get('upload_max_filesize');
            $response['message'] = "File exceeds PHP's upload_max_filesize ($max_size)";
            echo json_encode($response);
            exit;
        case UPLOAD_ERR_FORM_SIZE:
            $response['message'] = 'File exceeds the form MAX_FILE_SIZE';
            echo json_encode($response);
            exit;
        case UPLOAD_ERR_PARTIAL:
            $response['message'] = 'File was only partially uploaded';
            echo json_encode($response);
            exit;
        case UPLOAD_ERR_NO_FILE:
            $response['message'] = 'No file was uploaded';
            echo json_encode($response);
            exit;
        case UPLOAD_ERR_NO_TMP_DIR:
            $response['message'] = 'Missing temporary folder';
            echo json_encode($response);
            exit;
        case UPLOAD_ERR_CANT_WRITE:
            $response['message'] = 'Failed to write file to disk';
            echo json_encode($response);
            exit;
        case UPLOAD_ERR_EXTENSION:
            $response['message'] = 'File upload stopped by extension';
            echo json_encode($response);
            exit;
        default:
            $response['message'] = 'Unknown upload error';
            echo json_encode($response);
            exit;
    }

    // Validate file size (max 25MB)
    $maxFileSize = 25 * 1024 * 1024; // 25MB in bytes
    if ($file['size'] > $maxFileSize) {
        $response['message'] = 'File size exceeds the limit (25MB). Your file size: ' . round($file['size'] / (1024 * 1024), 2) . 'MB';
        echo json_encode($response);
        exit;
    }

    // Validate file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if ($mimeType !== 'application/pdf') {
        $response['message'] = "Invalid file type. Expected PDF, got: $mimeType";
        echo json_encode($response);
        exit;
    }

    // Get file info
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileSize = $file['size'];
    $fileTmpPath = $file['tmp_name'];

    // Generate unique filename
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid('lit_') . '_' . time() . '.' . $fileExtension;

    // Create upload directory if it doesn't exist
    $uploadDir = __DIR__ . '/../../storage/files/literature review/' . $projectId;
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            throw new Exception('Failed to create upload directory');
        }
    }

    if (!is_writable($uploadDir)) {
        throw new Exception('Upload directory is not writable');
    }

    $uploadPath = $uploadDir . '/' . $uniqueFileName;
    $relativeFilePath = 'storage/files/literature review/' . $projectId . '/' . $uniqueFileName;

    // Move uploaded file
    if (move_uploaded_file($fileTmpPath, $uploadPath)) {
        $response['success'] = true;
        $response['message'] = 'File uploaded successfully';
        $response['filePath'] = $relativeFilePath;
    } else {
        $error = error_get_last();
        throw new Exception('Failed to move uploaded file: ' . ($error ? $error['message'] : 'Unknown error'));
    }

} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
    error_log('File upload error: ' . $e->getMessage());
}

echo json_encode($response);
?> 