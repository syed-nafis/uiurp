<?php
require_once 'src/model/send_system_chat_message_helper.php';

// Test the system message functionality
$testProjectId = '64f8a1234567890123456789'; // Replace with a real project ID from your database

echo "Testing System Message Functions\n";
echo "=================================\n\n";

// Test 1: Basic system message
echo "1. Testing basic system message...\n";
$result1 = sendSystemChatMessage($testProjectId, "This is a test system message!");
echo "Result: " . ($result1['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "Message: " . $result1['message'] . "\n\n";

// Test 2: Welcome message
echo "2. Testing welcome message...\n";
$result2 = sendProjectWelcomeMessage($testProjectId, "Test Project", "John Doe");
echo "Result: " . ($result2['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "Message: " . $result2['message'] . "\n\n";

// Test 3: Leave message
echo "3. Testing leave message...\n";
$result3 = sendMemberLeaveMessage($testProjectId, "Jane Smith", "Test Project");
echo "Result: " . ($result3['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "Message: " . $result3['message'] . "\n\n";

// Test 4: Join message
echo "4. Testing join message...\n";
$result4 = sendMemberJoinMessage($testProjectId, "Bob Johnson", "Test Project");
echo "Result: " . ($result4['success'] ? 'SUCCESS' : 'FAILED') . "\n";
echo "Message: " . $result4['message'] . "\n\n";

echo "Testing complete!\n";
?> 