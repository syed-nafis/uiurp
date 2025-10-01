<?php
/**
 * Debug Chat Message Decryption
 * 
 * This script helps debug why encrypted messages aren't being decrypted in the chat
 */

require_once 'src/model/db_connect.php';
require_once 'src/model/ChatEncryption.php';
require_once 'src/model/ProjectKeyManager.php';
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Get project ID from command line or use the test project
$projectId = $argv[1] ?? '685551a4793d650a9900a57f';

echo "🔍 Debugging Chat Message Decryption\n";
echo "====================================\n\n";

try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Check project encryption status
    echo "📋 Project Status:\n";
    $project = $db->projectsV2->findOne(
        ['_id' => new ObjectId($projectId)],
        ['projection' => ['title' => 1, 'encryptionEnabled' => 1, 'encryptionKey' => 1]]
    );
    
    if (!$project) {
        echo "❌ Project not found!\n";
        exit(1);
    }
    
    echo "   Project: " . ($project['title'] ?? 'Untitled') . "\n";
    echo "   Encryption enabled: " . (isset($project['encryptionEnabled']) && $project['encryptionEnabled'] ? 'YES' : 'NO') . "\n";
    echo "   Has encryption key: " . (isset($project['encryptionKey']) ? 'YES' : 'NO') . "\n\n";
    
    // Get recent messages
    echo "📝 Recent Messages:\n";
    $messages = $db->project_chat_messages->find(
        ['projectId' => new ObjectId($projectId)],
        ['projection' => ['message' => 1, 'encrypted' => 1, 'iv' => 1, 'tag' => 1, 'sender.name' => 1, 'timestamp' => 1, 'isSystemMessage' => 1]],
        ['sort' => ['timestamp' => -1], 'limit' => 5]
    );
    
    $messageCount = 0;
    foreach ($messages as $msg) {
        $messageCount++;
        $sender = $msg['sender']['name'] ?? 'Unknown';
        $isEncrypted = isset($msg['encrypted']) && $msg['encrypted'];
        $isSystem = isset($msg['isSystemMessage']) && $msg['isSystemMessage'];
        $timestamp = $msg['timestamp']->toDateTime()->format('Y-m-d H:i:s');
        
        echo "   Message $messageCount:\n";
        echo "     Sender: $sender\n";
        echo "     Time: $timestamp\n";
        echo "     Encrypted: " . ($isEncrypted ? 'YES' : 'NO') . "\n";
        echo "     System: " . ($isSystem ? 'YES' : 'NO') . "\n";
        echo "     Raw message: " . substr($msg['message'], 0, 50) . (strlen($msg['message']) > 50 ? '...' : '') . "\n";
        
        if ($isEncrypted && !$isSystem) {
            echo "     Decryption attempt:\n";
            
            // Try to get project key
            try {
                $keyResult = ProjectKeyManager::getProjectKey($projectId, '6833436be5c16779b409aa42', $db); // Using your user ID
                if ($keyResult['success']) {
                    echo "       ✅ Project key retrieved\n";
                    
                    // Try to decrypt
                    $encryptedData = [
                        'ciphertext' => $msg['message'],
                        'iv' => $msg['iv'] ?? '',
                        'tag' => $msg['tag'] ?? ''
                    ];
                    
                    $decryptedMessage = ChatEncryption::decryptMessage($encryptedData, $keyResult['key']);
                    echo "       ✅ Decrypted: " . substr($decryptedMessage, 0, 100) . (strlen($decryptedMessage) > 100 ? '...' : '') . "\n";
                } else {
                    echo "       ❌ Failed to get project key: " . $keyResult['message'] . "\n";
                }
            } catch (Exception $e) {
                echo "       ❌ Decryption error: " . $e->getMessage() . "\n";
            }
        }
        echo "\n";
    }
    
    if ($messageCount == 0) {
        echo "   No messages found for this project.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
