<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

// Import MongoDB BSON types
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;

// Start session to capture user data if available
session_start();

// Log session data for debugging
$log_path = __DIR__ . '/../../logs/project_create_debug.log';
file_put_contents($log_path, date('Y-m-d H:i:s') . " - SESSION: " . print_r($_SESSION, true) . "\n", FILE_APPEND);

// Set user ID and username (null if not logged in)
$userId = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id']) && isset($_SESSION['user_data']['_id']['$oid'])) {
    // Try to get ID from user_data if available
    $userId = $_SESSION['user_data']['_id']['$oid'];
} elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id'])) {
    // Fall back to string representation of ID if present
    $userId = (string)$_SESSION['user_data']['_id'];
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 
           (isset($_SESSION['user_data']['name']) ? $_SESSION['user_data']['name'] : 'Anonymous User');

file_put_contents($log_path, date('Y-m-d H:i:s') . " - UserId extracted: $userId, Username: $username\n", FILE_APPEND);

// Set dates
if (!empty($_POST['createdAt'])) {
    $createdDate = new UTCDateTime(strtotime($_POST['createdAt']) * 1000);
} else {
    $createdDate = new UTCDateTime();
}

if (!empty($_POST['updatedAt'])) {
    $updatedDate = new UTCDateTime(strtotime($_POST['updatedAt']) * 1000);
} else {
    $updatedDate = new UTCDateTime();
}

// Validate required fields
if (empty($_POST['title']) || empty($_POST['abstract']) || empty($_POST['field'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Required fields are missing'
    ]);
    exit;
}

// Get members data
$members = [];
if (!empty($_POST['members'])) {
    $membersData = json_decode($_POST['members'], true);
    
    // Add current user as a member if logged in and not already included
    if ($userId !== null) {
        $userIncluded = false;
        foreach ($membersData as $member) {
            if (isset($member['userId']) && $member['userId']['$oid'] === $userId) {
                $userIncluded = true;
                break;
            }
        }
        
        if (!$userIncluded) {
            // Add current user as the first member
            array_unshift($membersData, [
                'userId' => ['$oid' => $userId],
                'name' => $username,
                'role' => 'Author',
                'contribution' => 100
            ]);
        }
    }
    
    $members = $membersData;
}

// Process keywords
$keywords = [];
if (!empty($_POST['keywords'])) {
    $keywords = json_decode($_POST['keywords'], true);
}

// Handle image upload
$coverImage = [
    'url' => '',
    'alt' => $_POST['title'],
    'fallback' => '/assets/resources/research_picture/pub_' . rand(1, 10) . '.jpg'
];

if (!empty($_FILES['coverImage']['tmp_name'])) {
    $uploadDir = __DIR__ . '/../../storage/images/';
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileExtension = pathinfo($_FILES['coverImage']['name'], PATHINFO_EXTENSION);
    $fileName = 'project_' . time() . '_' . uniqid() . '.' . $fileExtension;
    $targetFile = $uploadDir . $fileName;
    
    if (move_uploaded_file($_FILES['coverImage']['tmp_name'], $targetFile)) {
        $coverImage['url'] = '/storage/images/' . $fileName;
    }
}

// Process timeline data
$timeline = [];
if (!empty($_POST['timeline'])) {
    $timelineData = json_decode($_POST['timeline'], true);
    if (is_array($timelineData)) {
        $timeline = $timelineData;
    }
}

// Process supervisor
$supervisor = null;
if (!empty($_POST['supervisor'])) {
    // In the JSON file, supervisor is an object with userId, name, and role
    $supervisorValue = $_POST['supervisor'];
    if (preg_match('/^[a-f\d]{24}$/i', $supervisorValue)) {
        $supervisor = [
            'userId' => ['$oid' => $supervisorValue],
            'name' => $_POST['supervisor'],
            'role' => 'Supervisor'
        ];
    } else {
        $supervisor = [
            'name' => $supervisorValue,
            'role' => 'Supervisor'
        ];
        
        // If user is logged in, add their ID
        if ($userId) {
            $supervisor['userId'] = ['$oid' => $userId];
        }
    }
} else if ($userId) {
    $supervisor = [
        'userId' => ['$oid' => $userId],
        'name' => $username,
        'role' => 'Supervisor'
    ];
}

// Process stats (randomly generated if not provided)
$stats = [
    'views' => !empty($_POST['viewsCount']) ? (int)$_POST['viewsCount'] : rand(10, 1000),
    'downloads' => !empty($_POST['downloadsCount']) ? (int)$_POST['downloadsCount'] : rand(10, 1000),
    'favorites' => !empty($_POST['favoritesCount']) ? (int)$_POST['favoritesCount'] : rand(10, 1000)
];

// Process references - format as an array of objects
$referencesArray = [];
if (!empty($_POST['references'])) {
    $referencesText = $_POST['references'];
    $referencesLines = explode("\n", $referencesText);
    
    foreach ($referencesLines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        // Split by pipes if they exist (for title | link format)
        if (strpos($line, '|') !== false) {
            list($title, $link) = array_map('trim', explode('|', $line, 2));
            $referencesArray[] = [
                'title' => $title,
                'link' => $link
            ];
        } else {
            // If no pipe, use the entire line as both title and link
            $referencesArray[] = [
                'title' => $line,
                'link' => $line
            ];
        }
    }
}

// Handle additional media uploads - format each media item as {type, url, caption}
$media = [];
if (!empty($_FILES['mediaFiles']['name'][0])) {
    $uploadDir = __DIR__ . '/../../storage/media/';
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileCount = count($_FILES['mediaFiles']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        if ($_FILES['mediaFiles']['error'][$i] === 0) {
            $filename = $_FILES['mediaFiles']['name'][$i];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            $newFilename = 'media_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $targetFile = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['mediaFiles']['tmp_name'][$i], $targetFile)) {
                $mediaType = strpos($_FILES['mediaFiles']['type'][$i], 'image/') === 0 ? 'image' : 'video';
                
                $media[] = [
                    'type' => $mediaType,
                    'url' => '/storage/media/' . $newFilename,
                    'caption' => $filename
                ];
            }
        }
    }
}

// Handle project files uploads - format as {name, path, type, size, uploadedAt}
$files = [];
if (!empty($_FILES['projectFiles']['name'][0])) {
    $uploadDir = __DIR__ . '/../../storage/files/';
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $fileCount = count($_FILES['projectFiles']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        if ($_FILES['projectFiles']['error'][$i] === 0) {
            $filename = $_FILES['projectFiles']['name'][$i];
            $fileType = $_FILES['projectFiles']['type'][$i];
            $fileSize = $_FILES['projectFiles']['size'][$i];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            $newFilename = 'file_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $targetFile = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['projectFiles']['tmp_name'][$i], $targetFile)) {
                $files[] = [
                    'name' => $filename,
                    'path' => '/storage/files/' . $newFilename,
                    'type' => $fileType,
                    'size' => $fileSize,
                    'uploadedAt' => new UTCDateTime()
                ];
            }
        }
    }
}

// Process links data
$links = [
    'github' => $_POST['github'] ?? '',
    'website' => $_POST['website'] ?? '',
    'paper' => $_POST['paper'] ?? '',
    'doi' => $_POST['doi'] ?? '',
    'youtube' => $_POST['youtube'] ?? ''
];

// If links data was passed as JSON, use that instead
if (!empty($_POST['links'])) {
    $linksData = json_decode($_POST['links'], true);
    if (is_array($linksData)) {
        $links = $linksData;
    }
}

// Create project document
$project = [
    'title' => $_POST['title'],
    'abstract' => $_POST['abstract'],
    'description' => $_POST['description'] ?? '',
    'coverImage' => $coverImage,
    'field' => $_POST['field'],
    'keywords' => $keywords,
    'institution' => $_POST['institution'] ?? 'United International University',
    'createdAt' => $createdDate,
    'updatedAt' => $updatedDate,
    'privacy' => (int) ($_POST['privacy'] ?? 0),
    'members' => $members,
    'timeline' => $timeline,
    'supervisor' => $supervisor,
    'links' => $links,
    'files' => $files,
    'media' => $media,
    'references' => $referencesArray,
    'stats' => $stats,
    'comments' => [], // Initialize with empty array
    'createdBy' => $userId // Store the creator's user ID
];

try {
    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $collection = $db->projectsV2;
    
    // Insert the project
    $result = $collection->insertOne($project);
    
    if ($result->getInsertedCount() === 1) {
        echo json_encode([
            'success' => true,
            'message' => 'Project created successfully',
            'projectId' => (string) $result->getInsertedId()
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create project'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error creating project: ' . $e->getMessage()
    ]);
}
?> 