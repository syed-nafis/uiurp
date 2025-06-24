<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../model/db_connect.php';

// Import MongoDB classes
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set headers
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to edit a post']);
    exit;
}

// Get database connection
$client = connectToDatabase();
$db = $client->uiurp;
$forumPostsCollection = $db->forum_posts;
$forumCollection = $db->forum;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get input data
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            // Try to get form data if JSON parsing failed
            $data = $_POST;
        }
        
        $postId = $data['postId'] ?? null;
        $title = $data['title'] ?? null;
        $content = $data['content'] ?? null;
        $tags = $data['tags'] ?? [];
        
        // Validate input
        if (empty($postId) || empty($title) || empty($content) || empty($tags)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit;
        }
        
        // Try to find the post in forum_posts collection first
        $post = $forumPostsCollection->findOne(['_id' => new ObjectId($postId)]);
        $collectionToUse = $forumPostsCollection;
        
        // If not found, check the old forum collection
        if (!$post) {
            $post = $forumCollection->findOne(['_id' => new ObjectId($postId)]);
            $collectionToUse = $forumCollection;
            
            if (!$post) {
                echo json_encode(['success' => false, 'message' => 'Post not found']);
                exit;
            }
        }
        
        // Check if user is the post owner
        if (!isset($post['user_id']) || $post['user_id'] !== $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'You can only edit your own posts']);
            exit;
        }
        
        // Handle file uploads if present
        $attachments = $post['attachments'] ?? [];
        
        // Initialize attachments as empty array if it's not already an array
        if (!is_array($attachments)) {
            $attachments = [];
        }
        
        if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
            $uploadDir = '../../uploads/forum_attachments/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileCount = count($_FILES['files']['name']);
            
            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $_FILES['files']['name'][$i];
                $fileTmpName = $_FILES['files']['tmp_name'][$i];
                $fileSize = $_FILES['files']['size'][$i];
                $fileError = $_FILES['files']['error'][$i];
                $fileType = $_FILES['files']['type'][$i];
                
                // Generate unique filename
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $uniqueName = 'forum_' . time() . '_' . md5($fileName . microtime()) . '.' . $fileExt;
                $uploadPath = $uploadDir . $uniqueName;
                
                // Move uploaded file
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    $attachments[] = [
                        'original_name' => $fileName,
                        'stored_name' => $uniqueName,
                        'file_type' => $fileType,
                        'file_size' => $fileSize,
                        'file_path' => 'uploads/forum_attachments/' . $uniqueName
                    ];
                }
            }
        }
        
        // Handle attachment deletions if any
        if (isset($data['delete_attachments']) && is_array($data['delete_attachments'])) {
            $newAttachments = [];
            foreach ($attachments as $index => $attachment) {
                if (!in_array($index, $data['delete_attachments'])) {
                    $newAttachments[] = $attachment;
                } else {
                    // Delete the file from server
                    $filePath = '../../' . $attachment['file_path'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
            $attachments = $newAttachments;
        }
        
        // Set up update data
        $updateData = [
            'title' => $title,
            'content' => $content,
            'tags' => $tags,
            'attachments' => $attachments,
            'updated_at' => new UTCDateTime()
        ];
        
        // If it's an old post in the forum collection, also update timestamp for compatibility
        if ($collectionToUse === $forumCollection) {
            $updateData['timestamp'] = new UTCDateTime();
        }
        
        // Update post
        $result = $collectionToUse->updateOne(
            ['_id' => new ObjectId($postId)],
            ['$set' => $updateData]
        );
        
        if ($result->getModifiedCount() === 1) {
            echo json_encode(['success' => true, 'message' => 'Post updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No changes were made to the post']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 