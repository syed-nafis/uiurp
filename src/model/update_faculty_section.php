<?php
session_start();
require_once '../../vendor/autoload.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in and is a faculty member
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'faculty') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit();
}

// Validate required fields
if (!isset($input['faculty_id']) || !isset($input['section']) || !isset($input['data'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

$faculty_id = $input['faculty_id'];
$section = $input['section'];
$data = $input['data'];

// Validate that the user is editing their own profile
if ($_SESSION['user_id'] !== $faculty_id) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

try {
    // Create MongoDB client
    $client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
    $collection = $client->uiurp->faculties;
    
    // Convert faculty_id to ObjectId
    $objectId = new MongoDB\BSON\ObjectId($faculty_id);
    
    // Validate section and prepare update data
    $updateData = [];
    
    switch ($section) {
        case 'interested_fields_of_research':
            if (!is_array($data)) {
                echo json_encode(['success' => false, 'message' => 'Research fields must be an array']);
                exit();
            }
            $updateData['interested_fields_of_research'] = $data;
            break;
            
        case 'projects':
            if (!is_array($data)) {
                echo json_encode(['success' => false, 'message' => 'Projects must be an array']);
                exit();
            }
            // Validate each project has required fields
            foreach ($data as $project) {
                if (!isset($project['title']) || empty(trim($project['title']))) {
                    echo json_encode(['success' => false, 'message' => 'Each project must have a title']);
                    exit();
                }
            }
            $updateData['projects'] = $data;
            break;
            
        case 'prerequisites':
            if (!is_array($data)) {
                echo json_encode(['success' => false, 'message' => 'Prerequisites must be an array']);
                exit();
            }
            $updateData['prerequisites'] = $data;
            break;
            
        case 'resources_to_learn_prerequisites':
            if (!is_array($data)) {
                echo json_encode(['success' => false, 'message' => 'Resources must be an array']);
                exit();
            }
            // Validate each resource has required fields
            foreach ($data as $resource) {
                if (!isset($resource['topic']) || empty(trim($resource['topic']))) {
                    echo json_encode(['success' => false, 'message' => 'Each resource must have a topic']);
                    exit();
                }
            }
            $updateData['resources_to_learn_prerequisites'] = $data;
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid section']);
            exit();
    }
    
    // Update the faculty document
    $result = $collection->updateOne(
        ['_id' => $objectId],
        ['$set' => $updateData]
    );
    
    if ($result->getModifiedCount() > 0 || $result->getMatchedCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Section updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No changes made or faculty not found']);
    }
    
} catch (Exception $e) {
    error_log("Error updating faculty section: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error occurred']);
}
?> 