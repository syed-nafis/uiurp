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
    $projectsCollection = $db->projects;
    
    // Get current user ID
    $userId = $_SESSION['user_id'];
    
    // Fetch projects where the user is a team member
    $projects = $projectsCollection->find([
        'members.userId' => $userId
    ], [
        'sort' => ['createdAt' => -1],
        'limit' => 10 // Limit to 10 most recent projects
    ]);
    
    $projectsArray = [];
    foreach ($projects as $project) {
        $projectsArray[] = $project;
    }
    
    // Return as JSON
    header('Content-Type: application/json');
    echo json_encode($projectsArray);
    
} catch (Exception $e) {
    error_log("Error fetching user projects: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch projects']);
} 