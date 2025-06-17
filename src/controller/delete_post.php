<?php
require_once '../../vendor/autoload.php';
require_once '../model/db_connect.php';

use MongoDB\BSON\ObjectId;

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get JSON data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate input
if (!isset($data['postId']) || empty($data['postId'])) {
    echo json_encode(['success' => false, 'message' => 'Post ID is required']);
    exit;
}

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $forumPostsCollection = $db->forum_posts;
    
    // Try to convert the ID to ObjectId
    $postId = null;
    try {
        $postId = new ObjectId($data['postId']);
    } catch (Exception $e) {
        // If the ID is not a valid ObjectId, keep it as is (it might be a string ID)
        $postId = $data['postId'];
    }
    
    // Find post
    $post = $forumPostsCollection->findOne(['_id' => $postId]);
    
    // If post doesn't exist in forum_posts, try the old forum collection
    if (!$post) {
        $forumCollection = $db->forum;
        $post = $forumCollection->findOne(['_id' => $postId]);
        
        if (!$post) {
            echo json_encode(['success' => false, 'message' => 'Post not found']);
            exit;
        }
        
        // We found the post in the old collection, so we'll use that collection
        $collection = $forumCollection;
    } else {
        $collection = $forumPostsCollection;
    }
    
    // Verify the user owns the post or is an admin
    $userId = $_SESSION['user_id'];
    $isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
    
    if (!$isAdmin && (!isset($post['user_id']) || $post['user_id'] !== $userId)) {
        echo json_encode(['success' => false, 'message' => 'You can only delete your own posts']);
        exit;
    }
    
    // Delete any attachments if they exist
    if (isset($post['attachments']) && !empty($post['attachments'])) {
        foreach ($post['attachments'] as $attachment) {
            $filePath = $attachment['file_path'] ?? '';
            if (!empty($filePath) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $filePath)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $filePath);
            }
        }
    }
    
    // Delete the post
    $result = $collection->deleteOne(['_id' => $postId]);
    
    if ($result->getDeletedCount() > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete post'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 