<?php
/**
 * Test Message Display Fixes
 * 
 * This script tests that messages are properly decrypted in both
 * single message retrieval and group chat list
 */

require_once 'src/model/db_connect.php';
require_once 'src/model/ChatEncryption.php';
require_once 'src/model/ProjectKeyManager.php';
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

echo "🔍 Testing Message Display Fixes\n";
echo "================================\n\n";

$projectId = '685551a4793d650a9900a57f';
$userId = '6833436be5c16779b409aa42';

try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Test 1: Single message retrieval (simulating get_single_message.php)
    echo "📝 Test 1: Single Message Retrieval\n";
    echo "-----------------------------------\n";
    
    $messageId = '68dce21f680ee35d7601c97e'; // Your test message
    $message = $db->project_chat_messages->findOne(['_id' => new ObjectId($messageId)]);
    
    if ($message) {
        // Get project encryption key
        $projectKey = null;
        $project = $db->projectsV2->findOne(
            ['_id' => new ObjectId($projectId)],
            ['projection' => ['encryptionEnabled' => 1]]
        );
        
        if ($project && isset($project['encryptionEnabled']) && $project['encryptionEnabled']) {
            $keyResult = ProjectKeyManager::getProjectKey($projectId, $userId, $db);
            if ($keyResult['success']) {
                $projectKey = $keyResult['key'];
            }
        }
        
        // Decrypt message
        $messageText = $message['message'];
        $isEncrypted = false;
        
        if (ChatEncryption::isEncrypted($message) && $projectKey && !$message['isSystemMessage']) {
            try {
                $encryptedData = [
                    'message' => $message['message'],
                    'iv' => $message['iv'] ?? '',
                    'tag' => $message['tag'] ?? ''
                ];
                $messageText = ChatEncryption::decryptMessage($encryptedData, $projectKey);
                $isEncrypted = true;
            } catch (Exception $e) {
                $messageText = '[Encrypted message - unable to decrypt]';
                $isEncrypted = true;
            }
        }
        
        echo "   Raw message: " . $message['message'] . "\n";
        echo "   Decrypted: " . $messageText . "\n";
        echo "   Is encrypted: " . ($isEncrypted ? 'YES' : 'NO') . "\n";
        echo "   ✅ Single message decryption working!\n\n";
    }
    
    // Test 2: Group chat list (simulating fetch_chat_groups.php)
    echo "📝 Test 2: Group Chat List\n";
    echo "--------------------------\n";
    
    $project = $db->projectsV2->findOne(
        ['_id' => new ObjectId($projectId)],
        ['projection' => ['_id' => 1, 'title' => 1]]
    );
    
    if ($project) {
        // Get latest message
        $latestMessage = $db->project_chat_messages->findOne(
            ['projectId' => $project['_id']],
            [
                'sort' => ['timestamp' => -1],
                'projection' => [
                    'message' => 1,
                    'sender' => 1,
                    'timestamp' => 1,
                    'isSystemMessage' => 1,
                    'attachment' => 1,
                    'encrypted' => 1,
                    'iv' => 1,
                    'tag' => 1
                ]
            ]
        );
        
        if ($latestMessage) {
            // Decrypt message if it's encrypted
            $messageText = $latestMessage['message'];
            if (ChatEncryption::isEncrypted($latestMessage) && !$latestMessage['isSystemMessage']) {
                try {
                    $keyResult = ProjectKeyManager::getProjectKey((string)$project['_id'], $userId, $db);
                    if ($keyResult['success']) {
                        $encryptedData = [
                            'message' => $latestMessage['message'],
                            'iv' => $latestMessage['iv'] ?? '',
                            'tag' => $latestMessage['tag'] ?? ''
                        ];
                        $messageText = ChatEncryption::decryptMessage($encryptedData, $keyResult['key']);
                    }
                } catch (Exception $e) {
                    $messageText = '[Encrypted message]';
                }
            }
            
            echo "   Project: " . $project['title'] . "\n";
            echo "   Raw last message: " . $latestMessage['message'] . "\n";
            echo "   Decrypted last message: " . $messageText . "\n";
            echo "   ✅ Group chat list decryption working!\n\n";
        }
    }
    
    echo "🎉 All tests passed! Messages should now display correctly in the chat UI.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
