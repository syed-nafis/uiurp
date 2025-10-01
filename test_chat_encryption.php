<?php
/**
 * Test Script for Chat Encryption Implementation
 * 
 * This script tests the encryption functionality to ensure it works correctly
 */

require_once 'src/model/db_connect.php';
require_once 'src/model/ChatEncryption.php';
require_once 'src/model/ProjectKeyManager.php';
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\BSON\ObjectId;

echo "<h1>Chat Encryption Test</h1>\n";

// Test 1: Validate encryption configuration
echo "<h2>Test 1: Encryption Configuration</h2>\n";
if (ChatEncryption::validateConfiguration()) {
    echo "✅ Encryption configuration is valid<br>\n";
} else {
    echo "❌ Encryption configuration is invalid<br>\n";
    exit;
}

// Test 2: Generate and test encryption keys
echo "<h2>Test 2: Key Generation and Encryption</h2>\n";
try {
    $testKey = ChatEncryption::generateProjectKey();
    echo "✅ Project key generated successfully<br>\n";
    
    $testMessage = "This is a test message for encryption!";
    $encryptedData = ChatEncryption::encryptMessage($testMessage, $testKey);
    echo "✅ Message encrypted successfully<br>\n";
    
    $decryptedMessage = ChatEncryption::decryptMessage($encryptedData, $testKey);
    if ($decryptedMessage === $testMessage) {
        echo "✅ Message decrypted successfully and matches original<br>\n";
    } else {
        echo "❌ Decrypted message does not match original<br>\n";
    }
} catch (Exception $e) {
    echo "❌ Encryption test failed: " . $e->getMessage() . "<br>\n";
}

// Test 3: Test with MongoDB connection
echo "<h2>Test 3: MongoDB Integration</h2>\n";
try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Create a test project
    $testProjectId = new ObjectId();
    $testUserId = new ObjectId();
    
    // First, create the project in the database
    $projectDoc = [
        '_id' => $testProjectId,
        'title' => 'Test Project for Encryption',
        'createdBy' => (string)$testUserId,
        'members' => [
            [
                'userId' => (string)$testUserId,
                'name' => 'Test User',
                'userType' => 'student'
            ]
        ],
        'supervisor' => [
            'userId' => (string)$testUserId,
            'name' => 'Test Supervisor',
            'userType' => 'faculty'
        ],
        'createdAt' => new MongoDB\BSON\UTCDateTime(),
        'updatedAt' => new MongoDB\BSON\UTCDateTime()
    ];
    
    $db->projectsV2->insertOne($projectDoc);
    echo "✅ Test project created in database<br>\n";
    
    // Initialize encryption for test project
    $result = ProjectKeyManager::initializeProjectEncryption((string)$testProjectId, $db);
    if ($result['success']) {
        echo "✅ Project encryption initialized successfully<br>\n";
        
        // Test getting the project key
        $keyResult = ProjectKeyManager::getProjectKey((string)$testProjectId, (string)$testUserId, $db);
        if ($keyResult['success']) {
            echo "✅ Project key retrieved successfully<br>\n";
            
            // Test encrypting and storing a message
            $testMessage = "Test encrypted message for project";
            $encryptedData = ChatEncryption::encryptMessage($testMessage, $keyResult['key']);
            
            $messageDoc = [
                'projectId' => $testProjectId,
                'sender' => [
                    'userId' => $testUserId,
                    'name' => 'Test User',
                    'userType' => 'student'
                ],
                'message' => $encryptedData['ciphertext'],
                'timestamp' => new MongoDB\BSON\UTCDateTime(),
                'isSystemMessage' => false,
                'encrypted' => true,
                'iv' => $encryptedData['iv'],
                'tag' => $encryptedData['tag']
            ];
            
            $insertResult = $db->project_chat_messages->insertOne($messageDoc);
            if ($insertResult->getInsertedCount() > 0) {
                echo "✅ Encrypted message stored in database successfully<br>\n";
                
                // Test retrieving and decrypting the message
                $storedMessage = $db->project_chat_messages->findOne(['_id' => $insertResult->getInsertedId()]);
                if ($storedMessage) {
                    $decryptedMessage = ChatEncryption::decryptMessage([
                        'ciphertext' => $storedMessage['message'],
                        'iv' => $storedMessage['iv'],
                        'tag' => $storedMessage['tag']
                    ], $keyResult['key']);
                    
                    if ($decryptedMessage === $testMessage) {
                        echo "✅ Message retrieved and decrypted successfully<br>\n";
                    } else {
                        echo "❌ Decrypted message does not match original<br>\n";
                    }
                }
            }
        } else {
            echo "❌ Failed to get project key: " . $keyResult['message'] . "<br>\n";
        }
        
        // Clean up test data
        $db->project_chat_messages->deleteMany(['projectId' => $testProjectId]);
        $db->projectsV2->deleteOne(['_id' => $testProjectId]);
        echo "✅ Test data cleaned up<br>\n";
        
    } else {
        echo "❌ Failed to initialize project encryption: " . $result['message'] . "<br>\n";
    }
    
} catch (Exception $e) {
    echo "❌ MongoDB integration test failed: " . $e->getMessage() . "<br>\n";
}

// Test 4: Test key rotation
echo "<h2>Test 4: Key Rotation</h2>\n";
try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Create a test project with encryption
    $testProjectId = new ObjectId();
    $testUserId = new ObjectId();
    
    // First, create the project in the database
    $projectDoc = [
        '_id' => $testProjectId,
        'title' => 'Test Project for Key Rotation',
        'createdBy' => (string)$testUserId,
        'members' => [
            [
                'userId' => (string)$testUserId,
                'name' => 'Test User',
                'userType' => 'student'
            ]
        ],
        'supervisor' => [
            'userId' => (string)$testUserId,
            'name' => 'Test Supervisor',
            'userType' => 'faculty'
        ],
        'createdAt' => new MongoDB\BSON\UTCDateTime(),
        'updatedAt' => new MongoDB\BSON\UTCDateTime()
    ];
    
    $db->projectsV2->insertOne($projectDoc);
    echo "✅ Test project created in database<br>\n";
    
    // Initialize encryption
    $initResult = ProjectKeyManager::initializeProjectEncryption((string)$testProjectId, $db);
    if ($initResult['success']) {
        echo "✅ Test project created with encryption<br>\n";
        
        // Get original key
        $originalKeyResult = ProjectKeyManager::getProjectKey((string)$testProjectId, (string)$testUserId, $db);
        $originalKey = $originalKeyResult['key'];
        
        // Rotate key
        $rotateResult = ProjectKeyManager::rotateProjectKey((string)$testProjectId, (string)$testUserId, $db);
        if ($rotateResult['success']) {
            echo "✅ Key rotated successfully<br>\n";
            
            // Get new key
            $newKeyResult = ProjectKeyManager::getProjectKey((string)$testProjectId, (string)$testUserId, $db);
            $newKey = $newKeyResult['key'];
            
            if ($newKey !== $originalKey) {
                echo "✅ New key is different from original key<br>\n";
            } else {
                echo "❌ New key is the same as original key<br>\n";
            }
        } else {
            echo "❌ Key rotation failed: " . $rotateResult['message'] . "<br>\n";
        }
        
        // Clean up
        $db->projectsV2->deleteOne(['_id' => $testProjectId]);
        echo "✅ Test data cleaned up<br>\n";
    }
    
} catch (Exception $e) {
    echo "❌ Key rotation test failed: " . $e->getMessage() . "<br>\n";
}

// Test 5: Test message migration
echo "<h2>Test 5: Message Migration</h2>\n";
try {
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Create a test project
    $testProjectId = new ObjectId();
    $testUserId = new ObjectId();
    
    // First, create the project in the database
    $projectDoc = [
        '_id' => $testProjectId,
        'title' => 'Test Project for Migration',
        'createdBy' => (string)$testUserId,
        'members' => [
            [
                'userId' => (string)$testUserId,
                'name' => 'Test User',
                'userType' => 'student'
            ]
        ],
        'supervisor' => [
            'userId' => (string)$testUserId,
            'name' => 'Test Supervisor',
            'userType' => 'faculty'
        ],
        'createdAt' => new MongoDB\BSON\UTCDateTime(),
        'updatedAt' => new MongoDB\BSON\UTCDateTime()
    ];
    
    $db->projectsV2->insertOne($projectDoc);
    echo "✅ Test project created in database<br>\n";
    
    // Create unencrypted message
    $unencryptedMessage = [
        'projectId' => $testProjectId,
        'sender' => [
            'userId' => $testUserId,
            'name' => 'Test User',
            'userType' => 'student'
        ],
        'message' => 'This is an unencrypted test message',
        'timestamp' => new MongoDB\BSON\UTCDateTime(),
        'isSystemMessage' => false
    ];
    
    $insertResult = $db->project_chat_messages->insertOne($unencryptedMessage);
    echo "✅ Unencrypted message created<br>\n";
    
    // Initialize encryption
    $initResult = ProjectKeyManager::initializeProjectEncryption((string)$testProjectId, $db);
    if ($initResult['success']) {
        echo "✅ Encryption initialized for project<br>\n";
        
        // Migrate messages
        $migratedCount = ChatEncryption::migrateMessagesToEncrypted((string)$testProjectId, $db);
        echo "✅ Migrated $migratedCount messages to encrypted format<br>\n";
        
        // Verify migration
        $migratedMessage = $db->project_chat_messages->findOne(['_id' => $insertResult->getInsertedId()]);
        if ($migratedMessage && isset($migratedMessage['encrypted']) && $migratedMessage['encrypted']) {
            echo "✅ Message successfully migrated to encrypted format<br>\n";
        } else {
            echo "❌ Message migration failed<br>\n";
        }
    }
    
    // Clean up
    $db->project_chat_messages->deleteMany(['projectId' => $testProjectId]);
    $db->projectsV2->deleteOne(['_id' => $testProjectId]);
    echo "✅ Test data cleaned up<br>\n";
    
} catch (Exception $e) {
    echo "❌ Message migration test failed: " . $e->getMessage() . "<br>\n";
}

echo "<h2>Test Summary</h2>\n";
echo "All encryption tests completed. Check the results above for any failures.<br>\n";
echo "<p><strong>Note:</strong> This test script creates temporary test data that is automatically cleaned up.</p>\n";
?>
