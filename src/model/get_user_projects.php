<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Start session to capture user data if available
session_start();

// Set user ID (null if not logged in)
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $collection = $db->projectsV2;
    
    // Define query based on user login status
    if ($userId) {
        // For logged-in users, show their projects
        $filter = [
            '$or' => [
                ['members.userId.$oid' => $userId],
                ['supervisor.$oid' => $userId]
            ]
        ];
    } else {
        // For non-logged in users, show recent public projects
        $filter = ['privacy' => 0]; // Only public projects
    }
    
    $options = [
        'sort' => ['updatedAt' => -1],
        'limit' => 50  // Limit results to prevent excessive loading
    ];
    
    $cursor = $collection->find($filter, $options);
    $projects = [];
    
    foreach ($cursor as $project) {
        $projects[] = $project;
    }
    
    echo json_encode([
        'success' => true,
        'projects' => $projects,
        'isLoggedIn' => $userId ? true : false
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error retrieving projects: ' . $e->getMessage()
    ]);
}
?> 