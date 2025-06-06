<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Start session to capture user data
session_start();

// Initialize response array
$response = [
    'success' => false,
    'chatGroups' => [],
    'message' => ''
];

// Log file for debugging
$log_path = __DIR__ . '/../../logs/chat_debug.log';

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

// Log user ID for debugging
file_put_contents($log_path, date('Y-m-d H:i:s') . " - Chat Groups - User ID: $userId\n", FILE_APPEND);

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $collection = $db->projectsV2;
    
    // Define query to find all projects where user is involved
    $filter = [
        '$or' => [
            ['createdBy' => $userId],  // Direct creator ID field
            ['createdBy.$oid' => $userId],  // MongoDB ObjectId format
            ['members' => ['$elemMatch' => ['userId' => $userId]]],  // String format
            ['members' => ['$elemMatch' => ['userId.$oid' => $userId]]],  // MongoDB ObjectId format
            ['members.userId' => $userId],  // Direct string match in members array
            ['members.userId.$oid' => $userId],  // Direct ObjectId match in members array
            ['supervisor.userId.$oid' => $userId],  // MongoDB ObjectId format
            ['supervisor.userId' => $userId]  // String format
        ]
    ];
    
    // Logging the filter for debugging
    file_put_contents($log_path, date('Y-m-d H:i:s') . " - Chat Groups - Filter: " . json_encode($filter) . "\n", FILE_APPEND);
    
    $options = [
        'sort' => ['updatedAt' => -1], // Sort by most recently updated
        'projection' => [
            '_id' => 1,
            'title' => 1,
            'members' => 1,
            'supervisor' => 1,
            'coverImage' => 1
        ]
    ];
    
    $cursor = $collection->find($filter, $options);
    $chatGroups = [];
    
    foreach ($cursor as $project) {
        // Create a chat group object for each project
        $group = [
            'id' => $project['_id'],
            'name' => $project['title'],
            'lastMessage' => 'No messages yet',
            'lastSender' => '',
            'lastTime' => '',
            'imageUrl' => isset($project['coverImage']) && isset($project['coverImage']['url']) ? 
                $project['coverImage']['url'] : null
        ];
        
        $chatGroups[] = $group;
    }
    
    // Log the result
    file_put_contents($log_path, date('Y-m-d H:i:s') . " - Chat Groups - Found " . count($chatGroups) . " groups\n", FILE_APPEND);
    
    $response['success'] = true;
    $response['chatGroups'] = $chatGroups;
    echo json_encode($response);
    
} catch (Exception $e) {
    $errorMsg = "Error fetching chat groups: " . $e->getMessage();
    file_put_contents($log_path, date('Y-m-d H:i:s') . " - Chat Groups - Error: " . $errorMsg . "\n", FILE_APPEND);
    
    $response['message'] = $errorMsg;
    echo json_encode($response);
}
?> 