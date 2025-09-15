<?php
require __DIR__ . '/../../vendor/autoload.php'; // Updated path to Composer's autoloader

// Update the MongoDB connection string and database name
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$loginInfoCollection = $db->login_info;

session_start(); // Start session to track user login status

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrUsername = $_POST['username'];
    $password = $_POST['Password'];
    
    

    // Allow login by email primarily; fallback to username for legacy accounts
    $user = $loginInfoCollection->findOne(['email' => $emailOrUsername]);
    if (!$user) {
        $user = $loginInfoCollection->findOne(['username' => $emailOrUsername]);
    }

    // Primary: hashed password_verify. Fallback: legacy plaintext, then upgrade to hash.
    $authenticated = false;
    if ($user) {
        if (is_string($user['password']) && preg_match('/^\$2y\$/', (string)$user['password'])) {
            $authenticated = password_verify($password, $user['password']);
        } else if (isset($user['password']) && $password === $user['password']) {
            // Upgrade legacy plaintext to hash after successful auth
            $authenticated = true;
            try {
                $loginInfoCollection->updateOne(
                    ['_id' => $user['_id']],
                    ['$set' => ['password' => password_hash($password, PASSWORD_BCRYPT)]]
                );
            } catch (Exception $e) {
                // ignore upgrade errors
            }
        }
    }

    if ($authenticated) {
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
                $_SESSION['username'] = $facultyData['name']; // Store username in session
                $_SESSION['profile_pic'] = $facultyData['profile_image']; // Store user ID in session
                $_SESSION['email'] = $facultyData['email']; // Store user ID in session
                $_SESSION['user_id'] = (string)$facultyData['_id']; // Store user ID in session
                header('Location: ../../index.php'); // Redirect to faculty dashboard
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
                $_SESSION['username'] = $studentData['basic_info']['name'];
                $_SESSION['profile_pic'] = $studentData['basic_info']['profile_image_url'];// Store user ID in session
                $_SESSION['email'] = $studentData['contact_info']['primary_email']; // Store user ID in session
                $_SESSION['user_data'] = json_decode(json_encode($studentData),true);
                $_SESSION['user_id'] = (string)$studentData['_id']; // Store user ID in session
                header('Location: ../../index.php'); // Redirect to student dashboard
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
