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
       

        // Fetch data from the corresponding collection
        if ($type === 'faculty') {
            $facultyCollection = $db->faculties;
            $facultyData = $facultyCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            if ($facultyData) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_type'] = 'faculty';
                $_SESSION['user_data'] = json_decode(json_encode($facultyData),true);
                header('Location: /../../index.php'); // Redirect to faculty dashboard
                exit();
            }
        } elseif ($type === 'student') {
            echo "<script>console.log('" . $id . "');</script>";
            $studentCollection = $db->students;
            $studentData = $studentCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
            echo "<script>console.log('" . json_encode($studentData) . "');</script>"; // Log the data for debugging
            if ($studentData) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_type'] = 'student';
                $_SESSION['user_data'] = json_decode(json_encode($studentData),true);
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
