<?php
/**
 * update_timeline.php - Update project timeline items
 * 
 * This script processes AJAX requests to update timeline items for a project
 */

// Start session if not already started
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
    exit;
}

// Include database connection
require_once 'db_connect.php';

// Get JSON data from request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Check if data is valid
if (!$data || !isset($data['project_id']) || !isset($data['timeline'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Invalid data received'
    ]);
    exit;
}

// Extract data
$projectId = $data['project_id'];
$timeline = $data['timeline'];
$currentUserId = $_SESSION['user_id'];

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $projectsCollection = $db->projectsV2; // Use projectsV2 collection
    
    // Get the project to check permissions
    $project = $projectsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);
    
    // Check if project exists
    if (!$project) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Project not found'
        ]);
        exit;
    }
    
    // Check permissions
    $userIsOwner = false;
    $userIsMember = false;
    $userIsSupervisor = false;
    
    // Check if user is project creator
    if (isset($project['createdBy'])) {
        if (is_array($project['createdBy']) && isset($project['createdBy']['$oid']) && $project['createdBy']['$oid'] === $currentUserId) {
            $userIsOwner = true;
        } elseif (is_string($project['createdBy']) && $project['createdBy'] === $currentUserId) {
            $userIsOwner = true;
        }
    }
    
    // Check if user is supervisor
    if (isset($project['supervisor'])) {
        if (isset($project['supervisor']['userId']['$oid']) && $project['supervisor']['userId']['$oid'] === $currentUserId) {
            $userIsSupervisor = true;
        } elseif (isset($project['supervisor']['userId']) && $project['supervisor']['userId'] === $currentUserId) {
            $userIsSupervisor = true;
        }
    }
    
    // Check if user is team member
    if (isset($project['members']) && is_array($project['members'])) {
        foreach ($project['members'] as $member) {
            if (isset($member['userId']['$oid']) && $member['userId']['$oid'] === $currentUserId) {
                $userIsMember = true;
                break;
            } elseif (isset($member['userId']) && $member['userId'] === $currentUserId) {
                $userIsMember = true;
                break;
            }
        }
    }
    
    // Only allow updates if user is owner, supervisor, or team member
    if (!$userIsOwner && !$userIsSupervisor && !$userIsMember) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'You do not have permission to update this project'
        ]);
        exit;
    }
    
    // Prepare update data
    $updateData = [
        'timeline' => $timeline,
        'updatedAt' => new MongoDB\BSON\UTCDateTime(time() * 1000)
    ];
    
    // Update the project in the database
    $result = $projectsCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($projectId)],
        ['$set' => $updateData]
    );
    
    // Send system chat message about the update if chat feature is enabled
    try {
        if (file_exists(__DIR__ . '/send_system_chat_message_helper.php')) {
            require_once __DIR__ . '/send_system_chat_message_helper.php';
            
            // Get user name
            $userName = isset($_SESSION['username']) ? $_SESSION['username'] : 
                        (isset($_SESSION['user_data']['name']) ? $_SESSION['user_data']['name'] : 
                        (isset($_SESSION['name']) ? $_SESSION['name'] : 'A user'));
            
            // Create message
            $message = "$userName updated the project timeline.";
            
            // Send system message
            sendSystemChatMessage($projectId, $message);
        }
    } catch (Exception $e) {
        // Just log the error but continue with the timeline update
        error_log('Error sending system chat message: ' . $e->getMessage());
    }
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Timeline updated successfully',
        'updated' => $result->getModifiedCount() > 0
    ]);
    
} catch (Exception $e) {
    // Handle errors
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error updating timeline: ' . $e->getMessage()
    ]);
    
    // Log error
    error_log('Timeline update error: ' . $e->getMessage());
}
?> 