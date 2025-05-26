<?php
header('Content-Type: application/json');

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
    
    // Find the project with matching ID
    $foundProject = null;
    foreach ($projects as $project) {
        if (isset($project['_id']['$oid']) && $project['_id']['$oid'] === $projectId) {
            $foundProject = $project;
            break;
        }
    }
    
    if ($foundProject) {
        echo json_encode([
            'success' => true,
            'project' => $foundProject,
            'source' => 'json_file'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Project not found in JSON file'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error retrieving project: ' . $e->getMessage()
    ]);
}
?> 