<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $collection = $db->faculties;
    
    // Get all faculty members, but limit to essential fields
    $options = [
        'projection' => [
            'name' => 1,
            'email' => 1,
            'profile_image' => 1,
            'department' => 1,
            'title' => 1,
            'role' => 1
        ]
    ];
    
    $cursor = $collection->find([], $options);
    
    // Convert to array
    $faculty = [];
    foreach ($cursor as $document) {
        $faculty[] = $document;
    }
    
    // Return as JSON
    echo json_encode($faculty);
    
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Error loading faculty data: ' . $e->getMessage()
    ]);
}
?>
