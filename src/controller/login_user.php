<?php
session_start();
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

// Update the MongoDB connection string and database name
$mongoClient = new Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $mongoClient->uiurp;

$loginInfoCollection = $db->login_info;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['Password'];
    
    

    // Check if username and password match
    $user = $loginInfoCollection->findOne(['username' => $username]);

    if ($user && $password === $user['password']) {
        $type = $user['type'];
        $id = $user['id'];
       

        // Fetch data from the corresponding collection
        if ($type === 'faculty') {
            $facultyCollection = $db->faculties;
            $facultyData = $facultyCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($facultyData) {
                $_SESSION['user'] = $facultyData;
                header('Location: /../../index.php'); // Redirect to faculty dashboard
                exit();
            }
        } elseif ($type === 'student') {
            echo "<script>console.log('" . $id . "');</script>";
            $studentCollection = $db->students;
            $studentData = $studentCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            echo "<script>console.log('" . json_encode($studentData) . "');</script>"; // Log the data for debugging
            if ($studentData) {
                $_SESSION['user'] = $studentData;
                header('Location: /../../index.php'); // Redirect to student dashboard
                exit();
            }
        }
    }

    // If login fails
    $_SESSION['error'] = 'Invalid username or password';
    header('Location: /../../login.php'); // Redirect back to login page
    exit();
}
?>
