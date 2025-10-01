<?php
/**
 * Debug Projection Issue
 */

require_once 'src/model/db_connect.php';
require_once 'src/model/ChatEncryption.php';
require_once 'src/model/ProjectKeyManager.php';
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

echo "🔍 Debug Projection Issue\n";
echo "========================\n\n";

$userId = '6833436be5c16779b409aa42';

try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Get the project
    $project = $db->projectsV2->findOne(
        ['_id' => new ObjectId('685551a4793d650a9900a57f')],
        ['projection' => ['_id' => 1, 'title' => 1]]
    );
    
    echo "Project: " . $project['title'] . "\n\n";
    
    // Get chat messages collection for fetching latest messages
    $messagesCollection = $db->project_chat_messages;
    
    // Test the exact same query as in fetch_chat_groups.php
    $latestMessage = $messagesCollection->findOne(
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
        echo "Latest message found:\n";
        echo "  ID: " . $latestMessage['_id'] . "\n";
        echo "  Message: " . $latestMessage['message'] . "\n";
        echo "  Encrypted: " . (isset($latestMessage['encrypted']) ? $latestMessage['encrypted'] : 'NOT_SET') . "\n";
        echo "  IV: " . (isset($latestMessage['iv']) ? 'SET' : 'NOT_SET') . "\n";
        echo "  Tag: " . (isset($latestMessage['tag']) ? 'SET' : 'NOT_SET') . "\n";
        echo "  Fields: " . implode(', ', array_keys(iterator_to_array($latestMessage))) . "\n\n";
        
        // Test isEncrypted
        echo "isEncrypted check: " . (ChatEncryption::isEncrypted($latestMessage) ? 'YES' : 'NO') . "\n";
        
        // Test decryption
        if (ChatEncryption::isEncrypted($latestMessage) && !$latestMessage['isSystemMessage']) {
            echo "Attempting decryption...\n";
            try {
                $keyResult = ProjectKeyManager::getProjectKey((string)$project['_id'], $userId, $db);
                if ($keyResult['success']) {
                    $encryptedData = [
                        'message' => $latestMessage['message'],
                        'iv' => $latestMessage['iv'] ?? '',
                        'tag' => $latestMessage['tag'] ?? ''
                    ];
                    $decrypted = ChatEncryption::decryptMessage($encryptedData, $keyResult['key']);
                    echo "✅ Decrypted: " . $decrypted . "\n";
                } else {
                    echo "❌ Key retrieval failed: " . $keyResult['message'] . "\n";
                }
            } catch (Exception $e) {
                echo "❌ Decryption error: " . $e->getMessage() . "\n";
            }
        }
    } else {
        echo "No messages found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
