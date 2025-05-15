<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Comment out session-related code
// session_start();
// $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check if project ID is provided
if (!isset($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Project ID not provided'
    ]);
    exit;
}

$projectId = $_GET['id'];

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Try projectsV2 collection first, then fall back to projects if needed
    $project = null;
    $collections = ['projectsV2', 'projects'];
    
    foreach ($collections as $collectionName) {
        $collection = $db->$collectionName;
        
        // Find the project by ID without any permission checks
        $filter = ['_id' => new ObjectId($projectId)];
        
        // Find the project with all fields
        $options = [
            'projection' => [
                'title' => 1,
                'abstract' => 1,
                'description' => 1,
                'coverImage' => 1,
                'field' => 1,
                'keywords' => 1,
                'institution' => 1,
                'createdAt' => 1,
                'updatedAt' => 1,
                'privacy' => 1,
                'members' => 1,
                'timeline' => 1,
                'supervisor' => 1,
                'links' => 1,
                'files' => 1,
                'media' => 1,
                'references' => 1,
                'stats' => 1,
                'comments' => 1
            ]
        ];
        
        $project = $collection->findOne($filter, $options);
        
        if ($project) {
            // Increment view count if stats field exists
            if (isset($project['stats']) && is_array($project['stats'])) {
                $collection->updateOne(
                    ['_id' => new ObjectId($projectId)],
                    ['$inc' => ['stats.views' => 1]]
                );
            }
            
            // Project found, no need to check other collections
            break;
        }
    }
    
    if ($project) {
        echo json_encode([
            'success' => true,
            'project' => $project
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Project not found'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error retrieving project: ' . $e->getMessage()
    ]);
}
?> 