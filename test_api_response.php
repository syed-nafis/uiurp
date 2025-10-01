<?php
/**
 * Test API Response
 * 
 * This script simulates a session and tests the actual API response
 */

// Start session
session_start();

// Set up session data to simulate logged in user
$_SESSION['user_id'] = '6833436be5c16779b409aa42';
$_SESSION['user_data'] = [
    '_id' => ['$oid' => '6833436be5c16779b409aa42'],
    'name' => 'Samin yeaser khan'
];

echo "🔍 Testing API Response\n";
echo "======================\n\n";

// Capture output
ob_start();

// Include the fetch_chat_groups.php
include 'src/model/fetch_chat_groups.php';

// Get the output
$output = ob_get_clean();

echo "📋 API Response:\n";
echo $output . "\n\n";

// Parse JSON response
$response = json_decode($output, true);

if ($response && isset($response['chatGroups'])) {
    echo "📝 Parsed Group List:\n";
    foreach ($response['chatGroups'] as $i => $group) {
        echo "   Group " . ($i + 1) . ": " . $group['name'] . "\n";
        echo "   Last message: " . $group['lastMessage'] . "\n";
        echo "   Sender: " . $group['lastSender'] . "\n\n";
    }
} else {
    echo "❌ Failed to parse response or no chat groups found\n";
}
?>
