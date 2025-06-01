<?php
require_once 'db_connect.php';
require_once __DIR__ . '/../../vendor/autoload.php';

// Import MongoDB BSON types
use MongoDB\BSON\UTCDateTime;
use MongoDB\BSON\ObjectId;

// Start session to capture user data if available
session_start();

// Enhanced logging
$log_path = __DIR__ . '/../../logs/project_create_detailed_debug.log';

function logDebug($message) {
    global $log_path;
    file_put_contents($log_path, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

// Log all incoming data
logDebug("=== NEW PROJECT CREATION REQUEST ===");
logDebug("SESSION: " . print_r($_SESSION, true));
logDebug("POST: " . print_r($_POST, true));
logDebug("FILES: " . print_r($_FILES, true));

// Set headers to ensure proper JSON response
header('Content-Type: application/json');

try {
    // Set user ID and username (null if not logged in)
    $userId = null;
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id']) && isset($_SESSION['user_data']['_id']['$oid'])) {
        $userId = $_SESSION['user_data']['_id']['$oid'];
    } elseif (isset($_SESSION['user_data']) && isset($_SESSION['user_data']['_id'])) {
        $userId = (string)$_SESSION['user_data']['_id'];
    }

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 
               (isset($_SESSION['user_data']['basic_info']['name']) ? $_SESSION['user_data']['basic_info']['name'] : 
                (isset($_SESSION['user_data']['name']) ? $_SESSION['user_data']['name'] : 'Anonymous User'));

    logDebug("UserId extracted: $userId, Username: $username");

    // Validate required fields
    if (empty($_POST['title']) || empty($_POST['abstract']) || empty($_POST['field'])) {
        $missing = [];
        if (empty($_POST['title'])) $missing[] = 'title';
        if (empty($_POST['abstract'])) $missing[] = 'abstract';
        if (empty($_POST['field'])) $missing[] = 'field';
        
        logDebug("Missing required fields: " . implode(', ', $missing));
        echo json_encode([
            'success' => false,
            'message' => 'Required fields are missing: ' . implode(', ', $missing)
        ]);
        exit;
    }

    // Process members
    $members = [];
    if (!empty($_POST['members'])) {
        $membersData = json_decode($_POST['members'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            logDebug("JSON error in members data: " . json_last_error_msg());
            echo json_encode([
                'success' => false,
                'message' => 'Invalid members data format'
            ]);
            exit;
        }
        
        // Add current user as a member if logged in and not already included
        if ($userId !== null) {
            $userIncluded = false;
            foreach ($membersData as $member) {
                if (isset($member['userId']) && 
                    ((isset($member['userId']['$oid']) && $member['userId']['$oid'] === $userId) || 
                     $member['userId'] === $userId)) {
                    $userIncluded = true;
                    break;
                }
            }
            
            if (!$userIncluded) {
                array_unshift($membersData, [
                    'userId' => ['$oid' => $userId],
                    'name' => $username,
                    'role' => 'Author',
                    'contribution' => 100
                ]);
            }
        }
        
        $members = $membersData;
    } else {
        // If no members provided but user is logged in, add them
        if ($userId !== null) {
            $members = [[
                'userId' => ['$oid' => $userId],
                'name' => $username,
                'role' => 'Author',
                'contribution' => 100
            ]];
        }
    }

    logDebug("Processed members: " . print_r($members, true));

    // Set dates
    $createdDate = new UTCDateTime();
    $updatedDate = new UTCDateTime();

    // Process other data with defaults
    $keywords = [];
    if (!empty($_POST['keywords'])) {
        $keywords = json_decode($_POST['keywords'], true) ?: [];
    }

    $timeline = [];
    if (!empty($_POST['timeline'])) {
        $timeline = json_decode($_POST['timeline'], true) ?: [];
    }

    $links = [];
    if (!empty($_POST['links'])) {
        $links = json_decode($_POST['links'], true) ?: [];
    }

    // Process supervisor information
    $supervisor = null;
    if (!empty($_POST['supervisor'])) {
        $supervisorName = $_POST['supervisor'];
        $supervisorId = !empty($_POST['supervisorId']) ? $_POST['supervisorId'] : null;
        
        logDebug("Processing supervisor - Name: $supervisorName, ID: $supervisorId");
        
        if ($supervisorId) {
            // Faculty supervisor with ID - fetch faculty details
            try {
                $client = connectToDatabase();
                $db = $client->uiurp;
                $facultyCollection = $db->faculties;
                $faculty = $facultyCollection->findOne(['_id' => new ObjectId($supervisorId)]);
                
                if ($faculty) {
                    $supervisor = [
                        'userId' => ['$oid' => $supervisorId],
                        'name' => $faculty['name'],
                        'role' => 'Supervisor'
                    ];
                    
                    // Add additional faculty info if available
                    if (isset($faculty['email'])) {
                        $supervisor['email'] = $faculty['email'];
                    }
                    if (isset($faculty['department'])) {
                        $supervisor['department'] = $faculty['department'];
                    }
                    
                    logDebug("Found faculty supervisor: " . print_r($supervisor, true));
                } else {
                    // Faculty ID provided but not found - treat as custom supervisor
                    $supervisor = [
                        'name' => $supervisorName,
                        'role' => 'Supervisor'
                    ];
                    logDebug("Faculty ID not found, using custom supervisor");
                }
            } catch (Exception $e) {
                // Error with faculty lookup - treat as custom supervisor
                logDebug("Error looking up faculty supervisor: " . $e->getMessage());
                $supervisor = [
                    'name' => $supervisorName,
                    'role' => 'Supervisor'
                ];
            }
        } else {
            // Custom supervisor (no ID provided)
            $supervisor = [
                'name' => $supervisorName,
                'role' => 'Supervisor'
            ];
            logDebug("Using custom supervisor without ID");
        }
    } else if ($userId) {
        // No supervisor specified, use logged-in user as supervisor
        $supervisor = [
            'userId' => ['$oid' => $userId],
            'name' => $username,
            'role' => 'Creator/Supervisor'
        ];
        logDebug("No supervisor specified, using current user as supervisor");
    }

    logDebug("Final supervisor data: " . print_r($supervisor, true));

    // Create basic project document
    $project = [
        'title' => $_POST['title'],
        'abstract' => $_POST['abstract'],
        'description' => $_POST['description'] ?? '',
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
        'stats' => [
            'views' => 0,
            'downloads' => 0,
            'favorites' => 0
        ],
        'comments' => [],
        'createdBy' => $userId
    ];

    logDebug("Project document to insert: " . print_r($project, true));

    // Connect to MongoDB
    $client = connectToDatabase();
    $db = $client->uiurp;
    $collection = $db->projectsV2;
    
    logDebug("Connected to MongoDB successfully");
    
    // Insert the project
    $result = $collection->insertOne($project);
    
    logDebug("Insert result: " . print_r($result, true));
    
    if ($result->getInsertedCount() === 1) {
        $response = [
            'success' => true,
            'message' => 'Project created successfully',
            'projectId' => (string) $result->getInsertedId()
        ];
        logDebug("SUCCESS: " . print_r($response, true));
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'message' => 'Failed to create project - insert count was ' . $result->getInsertedCount()
        ];
        logDebug("FAILURE: " . print_r($response, true));
        echo json_encode($response);
    }
    
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => 'Error creating project: ' . $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ];
    logDebug("EXCEPTION: " . print_r($response, true));
    echo json_encode($response);
}
?> 