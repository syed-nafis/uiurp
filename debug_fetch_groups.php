<?php
/**
 * Debug fetch_chat_groups.php
 */

// Start session
session_start();

// Set up session data to simulate logged in user
$_SESSION['user_id'] = '6833436be5c16779b409aa42';
$_SESSION['user_data'] = [
    '_id' => ['$oid' => '6833436be5c16779b409aa42'],
    'name' => 'Samin yeaser khan'
];

require_once 'src/model/db_connect.php';
require_once 'src/model/ChatEncryption.php';
require_once 'src/model/ProjectKeyManager.php';
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

echo "🔍 Debug fetch_chat_groups.php\n";
echo "==============================\n\n";

$userId = '6833436be5c16779b409aa42';

try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Get all projects where user is involved
    $filter = [
        '$or' => [
            ['createdBy' => $userId],
            ['createdBy.$oid' => $userId],
            ['members' => ['$elemMatch' => ['userId' => $userId]]],
            ['members' => ['$elemMatch' => ['userId.$oid' => $userId]]],
            ['members.userId' => $userId],
            ['members.userId.$oid' => $userId],
            ['supervisor.userId.$oid' => $userId],
            ['supervisor.userId' => $userId]
        ]
    ];
    
    $options = [
        'sort' => ['updatedAt' => -1],
        'projection' => [
            '_id' => 1,
            'title' => 1,
            'members' => 1,
            'supervisor' => 1,
            'coverImage' => 1
        ]
    ];
    
    $cursor = $db->projectsV2->find($filter, $options);
    $chatGroups = [];
    
    // Get chat messages collection for fetching latest messages
    $messagesCollection = $db->project_chat_messages;
    
    foreach ($cursor as $project) {
        echo "📝 Processing project: " . $project['title'] . "\n";
        
        // Get the latest message for this project
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
        
        $lastMessage = 'No messages yet';
        $lastSender = '';
        $lastTime = '';
        
        if ($latestMessage) {
            echo "   Raw message: " . $latestMessage['message'] . "\n";
            echo "   Is encrypted: " . (ChatEncryption::isEncrypted($latestMessage) ? 'YES' : 'NO') . "\n";
            
            // Decrypt message if it's encrypted
            $messageText = $latestMessage['message'];
            if (ChatEncryption::isEncrypted($latestMessage) && !$latestMessage['isSystemMessage']) {
                echo "   Attempting decryption...\n";
                try {
                    // Get project encryption key
                    $keyResult = ProjectKeyManager::getProjectKey((string)$project['_id'], $userId, $db);
                    echo "   Key result success: " . ($keyResult['success'] ? 'YES' : 'NO') . "\n";
                    if ($keyResult['success']) {
                        $encryptedData = [
                            'message' => $latestMessage['message'],
                            'iv' => $latestMessage['iv'] ?? '',
                            'tag' => $latestMessage['tag'] ?? ''
                        ];
                        $messageText = ChatEncryption::decryptMessage($encryptedData, $keyResult['key']);
                        echo "   ✅ Decrypted: " . $messageText . "\n";
                    } else {
                        echo "   ❌ Key retrieval failed: " . $keyResult['message'] . "\n";
                        $messageText = '[Encrypted message]';
                    }
                } catch (Exception $e) {
                    echo "   ❌ Decryption error: " . $e->getMessage() . "\n";
                    $messageText = '[Encrypted message]';
                }
            } else {
                echo "   ℹ️  Not encrypted or system message\n";
            }
            
            // Format the last message
            if (isset($latestMessage['isSystemMessage']) && $latestMessage['isSystemMessage']) {
                $lastMessage = $messageText;
                $lastSender = 'System';
            } elseif (isset($latestMessage['attachment'])) {
                $fileName = $latestMessage['attachment']['fileName'] ?? 'file';
                $senderName = $latestMessage['sender']['name'] ?? 'Someone';
                $lastMessage = "$senderName shared: $fileName";
                $lastSender = $senderName;
            } else {
                $lastMessage = $messageText;
                $lastSender = $latestMessage['sender']['name'] ?? 'Someone';
            }
            
            echo "   Final message: " . $lastMessage . "\n";
            echo "   Sender: " . $lastSender . "\n";
            
            // Truncate message if too long
            if (strlen($lastMessage) > 50) {
                $lastMessage = substr($lastMessage, 0, 47) . '...';
                echo "   Truncated to: " . $lastMessage . "\n";
            }
            
            // Format timestamp
            $timestamp = $latestMessage['timestamp']->toDateTime();
            $lastTime = $timestamp->format('H:i');
            
            // If message is from today, show time, otherwise show date
            $today = new DateTime();
            if ($timestamp->format('Y-m-d') === $today->format('Y-m-d')) {
                $lastTime = $timestamp->format('H:i');
            } else {
                $lastTime = $timestamp->format('M d');
            }
            
            echo "   Time: " . $lastTime . "\n\n";
        } else {
            echo "   No messages\n\n";
        }
        
        // Create a chat group object for each project
        $group = [
            'id' => $project['_id'],
            'name' => $project['title'],
            'lastMessage' => $lastMessage,
            'lastSender' => $lastSender,
            'lastTime' => $lastTime,
            'imageUrl' => isset($project['coverImage']) && isset($project['coverImage']['url']) ? 
                $project['coverImage']['url'] : null
        ];
        
        $chatGroups[] = $group;
    }
    
    echo "📊 Final Results:\n";
    echo "================\n";
    foreach ($chatGroups as $i => $group) {
        echo "Group " . ($i + 1) . ": " . $group['name'] . "\n";
        echo "  Last message: " . $group['lastMessage'] . "\n";
        echo "  Sender: " . $group['lastSender'] . "\n";
        echo "  Time: " . $group['lastTime'] . "\n\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
