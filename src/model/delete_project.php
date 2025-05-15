<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Start session to capture user data if available
session_start();

// Set user ID (null if not logged in)
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Get JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

// Check if project ID is provided
if (empty($data['projectId'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Project ID not provided'
    ]);
    exit;
}

$projectId = $data['projectId'];

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $collection = $db->projectsV2;
    
    // Find the project by ID
    $filter = ['_id' => new ObjectId($projectId)];
    
    // If user is logged in, check permissions (optional permission check)
    if ($userId) {
        $filter['$or'] = [
            ['members.userId.$oid' => $userId],
            ['supervisor.$oid' => $userId]
        ];
    }
    
    $existingProject = $collection->findOne($filter);
    
    if (!$existingProject) {
        echo json_encode([
            'success' => false,
            'message' => 'Project not found or permission denied'
        ]);
        exit;
    }
    
    // Delete the project
    $result = $collection->deleteOne(['_id' => new ObjectId($projectId)]);
    
    if ($result->getDeletedCount() === 1) {
        // If there was a cover image, delete it
        if (!empty($existingProject['coverImage']['url']) && strpos($existingProject['coverImage']['url'], '/storage/images/') === 0) {
            $imagePath = __DIR__ . '/../../' . ltrim($existingProject['coverImage']['url'], '/');
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Project deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete project'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting project: ' . $e->getMessage()
    ]);
}
?> 