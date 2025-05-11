<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');

try {
    // Read the JSON file
    $jsonPath = __DIR__ . '/../../assets/json/uiurp.projectsV2.json';
    $jsonContent = file_get_contents($jsonPath);
    
    if (!$jsonContent) {
        throw new Exception("Could not read JSON file: $jsonPath");
    }
    
    // Decode JSON
    $projects = json_decode($jsonContent, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON parse error: " . json_last_error_msg());
    }
    
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Insert projects into MongoDB
    $countInserted = 0;
    foreach ($projects as $project) {
        // Skip if _id is not in proper format
        if (!isset($project['_id']['$oid'])) {
            continue;
        }
        
        // Use the same _id from JSON
        $project['_id'] = new MongoDB\BSON\ObjectId($project['_id']['$oid']);
        
        // First try to find if project already exists to avoid duplicates
        $existingProject = $db->projectsV2->findOne(['_id' => $project['_id']]);
        
        if (!$existingProject) {
            // Insert the project
            $result = $db->projectsV2->insertOne($project);
            
            if ($result->getInsertedCount() > 0) {
                $countInserted++;
            }
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => "Successfully imported $countInserted projects from JSON",
        'total' => count($projects),
        'inserted' => $countInserted
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error importing projects: ' . $e->getMessage()
    ]);
}
?> 