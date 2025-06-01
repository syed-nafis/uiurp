<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated']);
    exit();
}

// Include MongoDB connection
require __DIR__ . '/../../vendor/autoload.php';

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $db = $client->uiurp;
    $projectsCollection = $db->projectsV2;
    
    // Get current user ID
    $userId = $_SESSION['user_id'];
    
    // Log debug info
    error_log("fetch_all_user_projects.php - User ID: " . $userId);
    
    // Fetch all projects where the user is involved (either as creator or member)
    // Using the same query format as get_user_projects.php for compatibility
    $filter = [
        '$or' => [
            ['createdBy' => $userId],  // Direct creator ID field
            ['createdBy.$oid' => $userId],  // MongoDB ObjectId format
            ['members' => ['$elemMatch' => ['userId' => $userId]]],  // String format
            ['members' => ['$elemMatch' => ['userId.$oid' => $userId]]],  // MongoDB ObjectId format
            ['supervisor.userId.$oid' => $userId],  // MongoDB ObjectId format
            ['supervisor.userId' => $userId]  // String format
        ]
    ];
    
    error_log("fetch_all_user_projects.php - Filter: " . json_encode($filter));
    
    $options = [
        'sort' => ['updatedAt' => -1]
        // Remove limit to get all projects first, then we'll randomly select 3
    ];
    
    $projects = $projectsCollection->find($filter, $options);
    
    $projectsArray = [];
    foreach ($projects as $project) {
        // Add a flag to indicate if user is owner or member
        $isOwner = ($project['createdBy'] ?? null) === $userId || 
                   (isset($project['createdBy']['$oid']) && $project['createdBy']['$oid'] === $userId);
        $projectArray = (array) $project;
        $projectArray['userRole'] = $isOwner ? 'owner' : 'member';
        $projectsArray[] = $projectArray;
    }
    
    error_log("fetch_all_user_projects.php - Found " . count($projectsArray) . " total projects");
    
    // Randomly select 3 projects if we have more than 3
    if (count($projectsArray) > 3) {
        $originalCount = count($projectsArray);
        // Shuffle the array and take the first 3 elements
        shuffle($projectsArray);
        $projectsArray = array_slice($projectsArray, 0, 3);
        error_log("fetch_all_user_projects.php - Randomly selected 3 projects from " . $originalCount . " total");
    }
    
    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($projectsArray);
    
} catch (Exception $e) {
    error_log("fetch_all_user_projects.php - Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch projects', 'details' => $e->getMessage()]);
} 