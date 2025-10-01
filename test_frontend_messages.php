<?php
/**
 * Test Frontend Message Loading
 * 
 * This script simulates what the frontend receives from load_chat_messages.php
 */

require_once 'src/model/db_connect.php';
require_once 'src/model/ChatEncryption.php';
require_once 'src/model/ProjectKeyManager.php';
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

// Get project ID from command line or use the test project
$projectId = $argv[1] ?? '685551a4793d650a9900a57f';

echo "🔍 Testing Frontend Message Loading\n";
echo "==================================\n\n";

try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Simulate the load_chat_messages.php logic
    $collection = $db->project_chat_messages;
    
    // Prepare filter
    $filter = ['projectId' => new ObjectId($projectId)];
    
    // Options for the query
    $options = [
        'sort' => ['timestamp' => -1], // Sort by timestamp descending (newest first)
        'limit' => 5
    ];
    
    // Execute query
    $cursor = $collection->find($filter, $options);
    
    // Get project encryption key if needed
    $projectKey = null;
    $project = $db->projectsV2->findOne(
        ['_id' => new ObjectId($projectId)],
        ['projection' => ['encryptionEnabled' => 1]]
    );
    
    if ($project && isset($project['encryptionEnabled']) && $project['encryptionEnabled']) {
        $keyResult = ProjectKeyManager::getProjectKey($projectId, '6833436be5c16779b409aa42', $db);
        if ($keyResult['success']) {
            $projectKey = $keyResult['key'];
        }
    }
    
    // Load messages
    $messages = [];
    
    foreach ($cursor as $document) {
        $senderId = null;
        $userType = null;
        
        if (isset($document['sender']['userId'])) {
            if (is_object($document['sender']['userId'])) {
                $senderId = (string)$document['sender']['userId'];
            } elseif (isset($document['sender']['userId']['$oid'])) {
                $senderId = $document['sender']['userId']['$oid'];
            } else {
                $senderId = (string)$document['sender']['userId'];
            }
            
            $userType = $document['sender']['userType'] ?? null;
        }
        
        $senderName = $document['sender']['name'] ?? 'Unknown User';
        
        // Decrypt message if it's encrypted
        $messageText = $document['message'];
        $isEncrypted = false;
        
        if (ChatEncryption::isEncrypted($document) && $projectKey && !$document['isSystemMessage']) {
            try {
                $encryptedData = [
                    'ciphertext' => $document['message'],
                    'iv' => $document['iv'] ?? '',
                    'tag' => $document['tag'] ?? ''
                ];
                $messageText = ChatEncryption::decryptMessage($encryptedData, $projectKey);
                $isEncrypted = true;
            } catch (Exception $e) {
                // If decryption fails, show error message
                error_log("Message decryption failed: " . $e->getMessage());
                $messageText = '[Encrypted message - unable to decrypt]';
                $isEncrypted = true;
            }
        }
        
        // Format message
        $message = [
            'id' => (string)$document['_id'],
            'message' => $messageText,
            'sender' => [
                'id' => $senderId,
                'name' => $senderName,
                'userType' => $userType
            ],
            'timestamp' => $document['timestamp']->toDateTime()->getTimestamp(),
            'formattedTime' => $document['timestamp']->toDateTime()->format('h:i A'),
            'formattedDate' => $document['timestamp']->toDateTime()->format('M d, Y'),
            'profileImage' => 'assets/resources/user_avatar.png',
            'isSystem' => $document['isSystemMessage'] ?? false,
            'isCurrentUser' => ($senderId === '6833436be5c16779b409aa42'),
            'isEncrypted' => $isEncrypted
        ];
        
        $messages[] = $message;
    }
    
    // Reverse to get chronological order (oldest to newest)
    $messages = array_reverse($messages);
    
    echo "📝 Messages that would be sent to frontend:\n\n";
    
    foreach ($messages as $i => $message) {
        echo "Message " . ($i + 1) . ":\n";
        echo "  ID: " . $message['id'] . "\n";
        echo "  Sender: " . $message['sender']['name'] . "\n";
        echo "  Time: " . $message['formattedTime'] . "\n";
        echo "  Encrypted: " . ($message['isEncrypted'] ? 'YES' : 'NO') . "\n";
        echo "  System: " . ($message['isSystem'] ? 'YES' : 'NO') . "\n";
        echo "  Message: " . $message['message'] . "\n";
        echo "\n";
    }
    
    echo "📊 Summary:\n";
    echo "  Total messages: " . count($messages) . "\n";
    echo "  Encrypted messages: " . count(array_filter($messages, function($m) { return $m['isEncrypted']; })) . "\n";
    echo "  System messages: " . count(array_filter($messages, function($m) { return $m['isSystem']; })) . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
