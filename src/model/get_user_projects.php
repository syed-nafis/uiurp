<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Start session to capture user data if available
session_start();

// Debug session variables
$log_path = __DIR__ . '/../../logs/session_debug.log';
file_put_contents($log_path, date('Y-m-d H:i:s') . " - SESSION: " . print_r($_SESSION, true) . "\n", FILE_APPEND);

// Set user ID (null if not logged in)
$userId = null;
if (isset($_SESSION['user_id'])) {
    // Convert MongoDB ObjectId to string if needed
    if (is_object($_SESSION['user_id']) && get_class($_SESSION['user_id']) === 'MongoDB\BSON\ObjectId') {
        $userId = (string)$_SESSION['user_id'];
    } else {
        $userId = $_SESSION['user_id'];
    }
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id']) && isset($_SESSION['user_data']['_id']['$oid'])) {
    // Try to get ID from user_data if available
    $userId = $_SESSION['user_data']['_id']['$oid'];
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id'])) {
    // Fall back to string representation of ID if present
    $userId = (string)$_SESSION['user_data']['_id'];
}

$isLoggedIn = ($userId !== null);
file_put_contents($log_path, date('Y-m-d H:i:s') . " - UserId extracted: $userId, isLoggedIn: " . ($isLoggedIn ? 'true' : 'false') . "\n", FILE_APPEND);

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $collection = $db->projectsV2;
    
    // Define query based on user login status
    if ($isLoggedIn) {
        // For logged-in users, show only their projects
        // Note: Many imported projects don't have createdBy field, so we focus on members array and supervisor
        $filter = [
            '$or' => [
                ['createdBy' => $userId],  // Direct creator ID field (for new projects)
                ['createdBy.$oid' => $userId],  // MongoDB ObjectId format (for new projects)
                ['members' => ['$elemMatch' => ['userId' => $userId]]],  // String format
                ['members' => ['$elemMatch' => ['userId.$oid' => $userId]]],  // MongoDB ObjectId format
                ['members.userId' => $userId],  // Direct string match in members array
                ['members.userId.$oid' => $userId],  // Direct ObjectId match in members array
                ['supervisor.userId.$oid' => $userId],  // MongoDB ObjectId format
                ['supervisor.userId' => $userId]  // String format
            ]
        ];
        
        file_put_contents($log_path, date('Y-m-d H:i:s') . " - Filter: " . json_encode($filter) . "\n", FILE_APPEND);
        
        if ($userId === 'admin' || (isset($_SESSION['user_data']['role']) && $_SESSION['user_data']['role'] === 'admin')) {
            // If user is admin, no filter (show all projects)
            $filter = [];
            file_put_contents($log_path, date('Y-m-d H:i:s') . " - Admin user, showing all projects\n", FILE_APPEND);
        }
    } else {
        // For non-logged in users, show recent public projects
        $filter = ['privacy' => 0]; // Only public projects
        file_put_contents($log_path, date('Y-m-d H:i:s') . " - Not logged in, showing public projects\n", FILE_APPEND);
    }
    
    $options = [
        'sort' => ['updatedAt' => -1],
        'limit' => 50  // Limit results to prevent excessive loading
    ];
    
    $cursor = $collection->find($filter, $options);
    $projects = [];
    
    foreach ($cursor as $project) {
        $projects[] = $project;
    }
    
    file_put_contents($log_path, date('Y-m-d H:i:s') . " - Found " . count($projects) . " projects\n", FILE_APPEND);
    
    // Add debug info to response if needed
    $debug = [
        'userId' => $userId,
        'isLoggedIn' => $isLoggedIn,
        'filter' => $filter,
        'sessionData' => isset($_SESSION) ? $_SESSION : null
    ];
    
    echo json_encode([
        'success' => true,
        'projects' => $projects,
        'isLoggedIn' => $isLoggedIn,
        'debug' => $debug
    ]);
} catch (Exception $e) {
    file_put_contents($log_path, date('Y-m-d H:i:s') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
    
    echo json_encode([
        'success' => false,
        'message' => 'Error retrieving projects: ' . $e->getMessage()
    ]);
}
?> 