<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

// Start session to capture user data
session_start();

// Initialize response
$response = [
    'success' => false,
    'message' => ''
];

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_data'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit;
}

// Set user ID
$userId = null;
if (isset($_SESSION['user_id'])) {
    // Convert MongoDB ObjectId to string if needed
    if (is_object($_SESSION['user_id']) && get_class($_SESSION['user_id']) === 'MongoDB\BSON\ObjectId') {
        $userId = (string)$_SESSION['user_id'];
    } else {
        $userId = $_SESSION['user_id'];
    }
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id']) && isset($_SESSION['user_data']['_id']['$oid'])) {
    $userId = $_SESSION['user_data']['_id']['$oid'];
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id'])) {
    $userId = (string)$_SESSION['user_data']['_id'];
}

// Check if required data is provided
if (!isset($_POST['projectId']) || !isset($_POST['message']) || trim($_POST['message']) === '') {
    $response['message'] = 'Missing required fields';
    echo json_encode($response);
    exit;
}

$projectId = $_POST['projectId'];
$messageText = trim($_POST['message']);
$userType = isset($_POST['userType']) ? $_POST['userType'] : null;
$userName = isset($_POST['userName']) ? $_POST['userName'] : null;

// If userName isn't provided, try to get it from session
if (!$userName && isset($_SESSION['user_data']) && isset($_SESSION['user_data']['name'])) {
    $userName = $_SESSION['user_data']['name'];
} elseif (!$userName && isset($_SESSION['name'])) {
    $userName = $_SESSION['name'];
}

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Determine user type and get profile data if not provided
    if (!$userType || !$userName) {
        // Check if user is faculty
        $faculty = $db->faculties->findOne(['_id' => new ObjectId($userId)]);
        if ($faculty) {
            $userType = 'faculty';
            if (!$userName) {
                $userName = $faculty['name'] ?? $faculty['full_name'] ?? 'Faculty User';
            }
        } else {
            // Check if user is student
            $student = $db->students->findOne(['_id' => new ObjectId($userId)]);
            if ($student) {
                $userType = 'student';
                if (!$userName) {
                    // Check all possible locations for student name
                    $possibleNameFields = [
                        $student['name'] ?? null,
                        $student['full_name'] ?? null,
                        $student['basic_info']['name'] ?? null,
                        $student['basic_info']['full_name'] ?? null,
                        $student['profile']['name'] ?? null,
                        $student['personal_info']['name'] ?? null,
                        $student['personal_info']['full_name'] ?? null
                    ];
                    
                    foreach ($possibleNameFields as $nameField) {
                        if (!empty($nameField) && is_string($nameField)) {
                            $userName = $nameField;
                            break;
                        }
                    }
                    
                    // If no name found in any field, use default
                    if (empty($userName)) {
                        $userName = 'Student User';
                    }
                }
            } else {
                $userType = 'unknown';
                if (!$userName) {
                    $userName = 'Unknown User';
                }
            }
        }
    }
    
    // Current UTC timestamp
    $currentTime = new UTCDateTime(time() * 1000);
    
    // Create message document
    $message = [
        'projectId' => new ObjectId($projectId),
        'sender' => [
            'userId' => new ObjectId($userId),
            'name' => $userName,
            'userType' => $userType
        ],
        'message' => $messageText,
        'timestamp' => $currentTime,
        'isSystemMessage' => false
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
        $response['message'] = 'Message sent successfully';
        $response['messageId'] = (string)$result->getInsertedId();
        $response['timestamp'] = $currentTime->toDateTime()->format('Y-m-d H:i:s');
    } else {
        $response['message'] = 'Failed to send message';
    }
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?> 