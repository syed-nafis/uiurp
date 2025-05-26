<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    $_SESSION['error'] = "Please login to update your profile";
    header('Location: /../../login.php');
    exit();
}

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method";
    header('Location: /../../Student_Profile.php');
    exit();
}

// Include MongoDB connection
require __DIR__ . '/../../vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$studentsCollection = $db->students;

// Get the current user's ID from the session
$userId = $_SESSION['user_id'];

// Initialize the update array with basic profile information
$updateData = [
    'name' => $_POST['name'] ?? '',
    'email' => $_POST['email'] ?? '',
    'bio' => $_POST['bio'] ?? '',
    'phone' => $_POST['phone'] ?? '',
    'linkedin' => $_POST['linkedin'] ?? '',
    'github' => $_POST['github'] ?? '',
    'twitter' => $_POST['twitter'] ?? ''
];

// Handle skills (convert comma-separated string to array)
if (isset($_POST['skills']) && !empty($_POST['skills'])) {
    $skillsString = $_POST['skills'];
    $skillsArray = array_map('trim', explode(',', $skillsString));
    // Remove empty skills
    $skillsArray = array_filter($skillsArray, function($skill) {
        return !empty($skill);
    });
    $updateData['skills'] = array_values($skillsArray); // Reset array keys
} else {
    $updateData['skills'] = [];
}

// Handle education
if (isset($_POST['education']) && is_array($_POST['education'])) {
    $educationData = [];
    foreach ($_POST['education'] as $education) {
        // Validate required fields
        if (!empty($education['degree']) && !empty($education['institution'])) {
            $educationData[] = [
                'degree' => $education['degree'],
                'institution' => $education['institution'],
                'field' => $education['field'] ?? '',
                'year' => $education['year'] ?? ''
            ];
        }
    }
    $updateData['education'] = $educationData;
} else {
    $updateData['education'] = [];
}

// Handle projects
if (isset($_POST['projects']) && is_array($_POST['projects'])) {
    $projectsData = [];
    foreach ($_POST['projects'] as $project) {
        // Validate required fields
        if (!empty($project['title']) && !empty($project['description'])) {
            $projectsData[] = [
                'title' => $project['title'],
                'description' => $project['description'],
                'link' => $project['link'] ?? ''
            ];
        }
    }
    $updateData['projects'] = $projectsData;
} else {
    $updateData['projects'] = [];
}

// Handle profile image upload
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $_FILES['profile_image']['tmp_name']);
    finfo_close($fileInfo);
    
    if (in_array($mimeType, $allowedTypes)) {
        // Create uploads directory if it doesn't exist
        $uploadDir = __DIR__ . '/../../uploads/profile_images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate a unique filename
        $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . $userId . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        
        // Move the uploaded file
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetPath)) {
            // URL path for the image (relative to document root)
            $profileImagePath = 'uploads/profile_images/' . $filename;
            $updateData['profile_image'] = $profileImagePath;
        } else {
            $_SESSION['error'] = "Failed to upload profile image";
            header('Location: /../../Student_Profile_Edit.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
        header('Location: /../../Student_Profile_Edit.php');
        exit();
    }
}

try {
    // Update the student record in MongoDB
    $result = $studentsCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($userId)],
        ['$set' => $updateData]
    );
    
    if ($result->getModifiedCount() > 0 || $result->getMatchedCount() > 0) {
        // Update the session data
        $updatedStudent = $studentsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
        $_SESSION['user_data'] = json_decode(json_encode($updatedStudent), true);
        
        $_SESSION['success'] = "Profile updated successfully";
    } else {
        $_SESSION['error'] = "No changes were made to your profile";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error updating profile: " . $e->getMessage();
}

// Redirect back to the profile page
header('Location: /../../Student_Profile.php');
exit();
?> 