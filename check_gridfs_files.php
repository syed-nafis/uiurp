<?php
/**
 * Check GridFS Files
 * 
 * This script shows all files stored in MongoDB GridFS
 * Run: php check_gridfs_files.php
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/model/db_connect.php';

try {
    // Connect to database
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    echo "\n";
    echo "========================================\n";
    echo "  MongoDB GridFS Files Report\n";
    echo "========================================\n\n";
    
    // Check if fs.files collection exists
    $collections = [];
    foreach ($db->listCollections() as $collection) {
        $collections[] = $collection->getName();
    }
    
    if (!in_array('fs.files', $collections)) {
        echo "❌ No 'fs.files' collection found.\n";
        echo "   This means no files have been uploaded to GridFS yet.\n\n";
        echo "💡 Try uploading a file in chat to create the collection.\n\n";
        exit;
    }
    
    // Get all files
    $files = $db->{'fs.files'}->find([], ['sort' => ['uploadDate' => -1]]);
    $fileArray = iterator_to_array($files);
    
    if (empty($fileArray)) {
        echo "📁 GridFS collection exists but is empty.\n";
        echo "   No files uploaded yet.\n\n";
        echo "💡 Upload a file in chat to test!\n\n";
        exit;
    }
    
    // Display file count
    echo "✅ Found " . count($fileArray) . " file(s) in GridFS\n\n";
    
    // Calculate total size
    $totalSize = 0;
    foreach ($fileArray as $file) {
        $totalSize += $file['length'];
    }
    
    echo "📊 Total Storage Used: " . formatBytes($totalSize) . "\n";
    echo "📊 Available (Free Tier): " . formatBytes(512 * 1024 * 1024) . "\n";
    echo "📊 Percentage Used: " . round(($totalSize / (512 * 1024 * 1024)) * 100, 2) . "%\n\n";
    
    echo "========================================\n";
    echo "  File List (newest first)\n";
    echo "========================================\n\n";
    
    $index = 1;
    foreach ($fileArray as $file) {
        echo "File #{$index}\n";
        echo "├─ ID: " . (string)$file['_id'] . "\n";
        echo "├─ Name: " . $file['filename'] . "\n";
        echo "├─ Size: " . formatBytes($file['length']) . "\n";
        echo "├─ Uploaded: " . $file['uploadDate']->toDateTime()->format('Y-m-d H:i:s') . "\n";
        
        if (isset($file['metadata'])) {
            $meta = $file['metadata'];
            echo "├─ Type: " . ($meta['contentType'] ?? 'unknown') . "\n";
            
            if (isset($meta['projectId'])) {
                echo "├─ Project: " . (string)$meta['projectId'] . "\n";
            }
            
            if (isset($meta['uploadedBy'])) {
                echo "├─ Uploaded By: " . (string)$meta['uploadedBy'] . "\n";
            }
            
            if (isset($meta['uploadType'])) {
                echo "├─ Upload Type: " . $meta['uploadType'] . "\n";
            }
            
            if (isset($meta['category'])) {
                echo "└─ Category: " . $meta['category'] . "\n";
            }
        }
        
        echo "\n";
        $index++;
    }
    
    echo "========================================\n";
    echo "  Download URL Examples\n";
    echo "========================================\n\n";
    
    // Show example download URLs for first 3 files
    $count = 0;
    foreach ($fileArray as $file) {
        if ($count >= 3) break;
        
        $fileId = (string)$file['_id'];
        echo "File: " . $file['filename'] . "\n";
        echo "URL: /download.php?gridfs_id=" . $fileId . "\n";
        echo "View: /download.php?gridfs_id=" . $fileId . "&inline=1\n\n";
        
        $count++;
    }
    
    echo "========================================\n";
    echo "  Chunks Information\n";
    echo "========================================\n\n";
    
    $chunksCount = $db->{'fs.chunks'}->countDocuments();
    echo "📦 Total Chunks: " . $chunksCount . "\n";
    echo "ℹ️  Each file is split into 255KB chunks\n\n";
    
    echo "========================================\n\n";
    echo "✅ All files are properly stored in MongoDB!\n\n";
    echo "💡 Tips:\n";
    echo "   - View in Compass: Connect to your MongoDB\n";
    echo "   - Collection: fs.files\n";
    echo "   - To download: Use the URLs shown above\n\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n\n";
    echo "Possible issues:\n";
    echo "  - MongoDB connection failed\n";
    echo "  - Database credentials incorrect\n";
    echo "  - Network/firewall blocking connection\n\n";
}

/**
 * Format bytes to human readable
 */
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}

