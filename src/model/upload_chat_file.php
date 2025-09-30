<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/FileUploadHandler.php';
require_once __DIR__ . '/FileConfig.php';

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use UIURP\Model\FileUploadHandler;
use UIURP\Model\FileConfig;

// Start session to capture user data
session_start();

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'fileInfo' => null
];

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_data'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit;
}

// Set user ID
$userId = null;
if (isset($_SESSION['user_id'])) {
    // Convert MongoDB ObjectId to string if needed
    if (is_object($_SESSION['user_id']) && get_class($_SESSION['user_id']) === 'MongoDB\BSON\ObjectId') {
        $userId = (string)$_SESSION['user_id'];
    } else {
        $userId = $_SESSION['user_id'];
    }
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id']) && isset($_SESSION['user_data']['_id']['$oid'])) {
    $userId = $_SESSION['user_data']['_id']['$oid'];
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id'])) {
    $userId = (string)$_SESSION['user_data']['_id'];
}

// Check if required data is provided
if (!isset($_POST['projectId']) || !isset($_FILES['file'])) {
    $response['message'] = 'Missing required fields';
    echo json_encode($response);
    exit;
}

$projectId = $_POST['projectId'];
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$userType = isset($_POST['userType']) ? $_POST['userType'] : null;
$userName = isset($_POST['userName']) ? $_POST['userName'] : null;

// If userName isn't provided, try to get it from session
if (!$userName && isset($_SESSION['user_data']) && isset($_SESSION['user_data']['name'])) {
    $userName = $_SESSION['user_data']['name'];
} elseif (!$userName && isset($_SESSION['name'])) {
    $userName = $_SESSION['name'];
}

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    
    // Determine user type and get profile data if not provided
    if (!$userType || !$userName) {
        // Check if user is faculty
        $faculty = $db->faculties->findOne(['_id' => new ObjectId($userId)]);
        if ($faculty) {
            $userType = 'faculty';
            if (!$userName) {
                $userName = $faculty['name'] ?? $faculty['full_name'] ?? 'Faculty User';
            }
        } else {
            // Check if user is student
            $student = $db->students->findOne(['_id' => new ObjectId($userId)]);
            if ($student) {
                $userType = 'student';
                if (!$userName) {
                    // Check all possible locations for student name
                    $possibleNameFields = [
                        $student['name'] ?? null,
                        $student['full_name'] ?? null,
                        $student['basic_info']['name'] ?? null,
                        $student['basic_info']['full_name'] ?? null,
                        $student['profile']['name'] ?? null,
                        $student['personal_info']['name'] ?? null,
                        $student['personal_info']['full_name'] ?? null
                    ];
                    
                    foreach ($possibleNameFields as $nameField) {
                        if (!empty($nameField) && is_string($nameField)) {
                            $userName = $nameField;
                            break;
                        }
                    }
                    
                    // If no name found in any field, use default
                    if (empty($userName)) {
                        $userName = 'Student User';
                    }
                }
            } else {
                $userType = 'unknown';
                if (!$userName) {
                    $userName = 'Unknown User';
                }
            }
        }
    }
    
    // Process uploaded file using new FileUploadHandler
    $file = $_FILES['file'];
    
    // Initialize upload handler
    $uploadHandler = new FileUploadHandler();
    
    // Upload directory for chat files
    $uploadDir = FileConfig::DIR_CHAT_FILES . $projectId . '/';
    
    // Upload options
    $options = [
        'prefix' => 'chat_file',
        'maxSize' => FileConfig::MAX_FILE_SIZE_DEFAULT
    ];
    
    // Handle upload
    $uploadResult = $uploadHandler->handleUpload($file, $uploadDir, $options);
    
    if (!$uploadResult['success']) {
        $response['message'] = $uploadResult['message'];
        echo json_encode($response);
        exit;
    }
    
    // Get uploaded file data
    $uploadedFile = $uploadResult['fileData'];
    $fileName = $uploadedFile['name'];
    $fileType = $uploadedFile['type'];
    $fileSize = $uploadedFile['size'];
    $fileExtension = $uploadedFile['extension'];
    $relativeFilePath = ltrim($uploadedFile['path'], '/');
    
    // Continue with existing logic
    {
        // Current UTC timestamp
        $currentTime = new UTCDateTime(time() * 1000);
        
        // Use file category and icon from upload handler
        $fileTypeCategory = $uploadedFile['category'];
        $iconClass = $uploadedFile['iconClass'];
        
        // File details
        $fileInfo = [
            'fileName' => $fileName,
            'fileSize' => $fileSize,
            'fileType' => $fileType,
            'fileExtension' => $fileExtension,
            'filePath' => $relativeFilePath,
            'fileCategory' => $fileTypeCategory,
            'iconClass' => $iconClass,
            'uploadedAt' => $currentTime
        ];
        
        // Default message if none provided
        if (empty($message)) {
            $message = "Shared a file: $fileName";
        }
        
        // Create message document with file attachment
        $messageDoc = [
            'projectId' => new ObjectId($projectId),
            'sender' => [
                'userId' => new ObjectId($userId),
                'name' => $userName,
                'userType' => $userType
            ],
            'message' => $message,
            'timestamp' => $currentTime,
            'isSystemMessage' => false,
            'attachment' => $fileInfo
        ];
        
        // Insert message
        $result = $db->project_chat_messages->insertOne($messageDoc);
        
        // Update project's lastUpdated timestamp
        $db->projectsV2->updateOne(
            ['_id' => new ObjectId($projectId)],
            ['$set' => ['updatedAt' => $currentTime]]
        );
        
        if ($result->getInsertedCount()) {
            $response['success'] = true;
            $response['message'] = 'File uploaded successfully';
            $response['fileInfo'] = $fileInfo;
            $response['messageId'] = (string)$result->getInsertedId();
        } else {
            $response['message'] = 'Failed to save message';
        }
    }
    
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

echo json_encode($response);
?> 