<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

// Initialize response
$response = [
    'success' => false,
    'message' => ''
];

header('Content-Type: application/json');

// Check if API key is valid or if user is admin (this can be enhanced later)
$isAuthorized = false;

// Simple API key check (this should be improved in production)
$apiKey = isset($_SERVER['HTTP_X_API_KEY']) ? $_SERVER['HTTP_X_API_KEY'] : null;
if ($apiKey && $apiKey === 'system_message_api_key') {
    $isAuthorized = true;
}

// Or check if user is an admin via session
session_start();
if (!$isAuthorized && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    $isAuthorized = true;
}

// Check authorization
if (!$isAuthorized) {
    $response['message'] = 'Unauthorized access';
    echo json_encode($response);
    exit;
}

// Check if required data is provided
if (!isset($_POST['projectId']) || !isset($_POST['message']) || trim($_POST['message']) === '') {
    $response['message'] = 'Missing required fields';
    echo json_encode($response);
    exit;
}

$projectId = $_POST['projectId'];
$messageText = trim($_POST['message']);

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Current UTC timestamp
    $currentTime = new UTCDateTime(time() * 1000);
    
    // Create system message document
    $message = [
        'projectId' => new ObjectId($projectId),
        'sender' => [
            'name' => 'System',
            'userType' => 'system'
        ],
        'message' => $messageText,
        'timestamp' => $currentTime,
        'isSystemMessage' => true
    ];
    
    // Insert message
    $result = $db->project_chat_messages->insertOne($message);
    
    // Update project's lastUpdated timestamp
    $db->projectsV2->updateOne(
        ['_id' => new ObjectId($projectId)],
        ['$set' => ['updatedAt' => $currentTime]]
    );
    
    if ($result->getInsertedCount()) {
        $response['success'] = true;
        $response['message'] = 'System message sent successfully';
        $response['messageId'] = (string)$result->getInsertedId();
    } else {
        $response['message'] = 'Failed to send system message';
    }
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?> 