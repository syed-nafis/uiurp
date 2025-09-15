<?php
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

// Update the MongoDB connection string and database name
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$loginInfoCollection = $db->login_info;

session_start(); // Start session to track user login status

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['Password'];

    // Check if username and password match
    $user = $loginInfoCollection->findOne(['username' => $username]);

    if ($user && $password === $user['password']) {
        $type = $user['type'];
        $id = $user['id'];

        // Regenerate session ID to prevent fixation
        session_regenerate_id(true);

        // Decide where to redirect after login (default: index.php)
        $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '../../index.php';

        // Fetch data from the corresponding collection
        if ($type === 'faculty') {
            $facultyCollection = $db->faculties;
            $facultyData = $facultyCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($facultyData) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_type'] = 'faculty';
                $_SESSION['user_data'] = json_decode(json_encode($facultyData), true);
                $_SESSION['username'] = $facultyData['name'];
                $_SESSION['profile_pic'] = $facultyData['profile_image'];
                $_SESSION['email'] = $facultyData['email'];
                $_SESSION['user_id'] = (string)$facultyData['_id'];

                header("Location: " . $redirect);
                exit();
            }
        } elseif ($type === 'student') {
            $studentCollection = $db->students;
            $studentData = $studentCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($studentData) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_type'] = 'student';
                $_SESSION['username'] = $studentData['basic_info']['name'];
                $_SESSION['profile_pic'] = $studentData['basic_info']['profile_image_url'];
                $_SESSION['email'] = $studentData['contact_info']['primary_email'];
                $_SESSION['user_data'] = json_decode(json_encode($studentData), true);
                $_SESSION['user_id'] = (string)$studentData['_id'];

                header("Location: " . $redirect);
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