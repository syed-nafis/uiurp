<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    
    // Get all databases
    $databases = [];
    foreach ($client->listDatabases() as $db) {
        $databases[] = $db->getName();
    }
    
    // Get collections in the uiurp database
    $db = $client->uiurp;
    $collections = [];
    foreach ($db->listCollections() as $collection) {
        $collections[] = $collection->getName();
    }
    
    // Check if projectsV2 collection exists
    $projectsV2Exists = in_array('projectsV2', $collections);
    
    // Check if projects collection exists
    $projectsExists = in_array('projects', $collections);
    
    // Try to get the first project from projectsV2
    $projectFromV2 = null;
    if ($projectsV2Exists) {
        $projectFromV2 = $db->projectsV2->findOne();
    }
    
    // Try to get the first project from projects
    $projectFromProjects = null;
    if ($projectsExists) {
        $projectFromProjects = $db->projects->findOne();
    }
    
    echo json_encode([
        'success' => true,
        'databases' => $databases,
        'collections' => $collections,
        'projectsV2Exists' => $projectsV2Exists,
        'projectsExists' => $projectsExists,
        'firstProjectFromV2' => $projectFromV2 ? true : false,
        'firstProjectFromProjects' => $projectFromProjects ? true : false
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error connecting to database: ' . $e->getMessage()
    ]);
}
?> 