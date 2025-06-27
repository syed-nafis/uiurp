<?php
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = new MongoDB\BSON\ObjectId($_POST['id']);
    $updateData = [];

    // Support both full and single-field updates
    if (isset($_POST['interested_fields'])) {
        // Accept comma separated string or array
        if (is_array($_POST['interested_fields'])) {
            $updateData['interested_fields_of_research'] = array_map('trim', $_POST['interested_fields']);
        } else {
            $updateData['interested_fields_of_research'] = array_map('trim', explode(',', $_POST['interested_fields']));
        }
    }
    if (isset($_POST['prerequisites'])) {
        if (is_array($_POST['prerequisites'])) {
            $updateData['prerequisites'] = array_map('trim', $_POST['prerequisites']);
        } else {
            $updateData['prerequisites'] = array_map('trim', explode(',', $_POST['prerequisites']));
        }
    }
    if (isset($_POST['resources'])) {
        // Accept JSON string or array
        $resources = $_POST['resources'];
        if (is_string($resources)) {
            $resources = json_decode($resources, true);
        }
        if (is_array($resources)) {
            $updateData['resources_to_learn_prerequisites'] = $resources;
        }
    }
    if (isset($_POST['projects'])) {
        $projects = $_POST['projects'];
        if (is_string($projects)) {
            $projects = json_decode($projects, true);
        }
        if (is_array($projects)) {
            $updateData['projects'] = $projects;
        }
    }
    // Fallback for full form update (legacy)
    if (isset($_POST['name'])) $updateData['name'] = $_POST['name'];
    if (isset($_POST['bio'])) $updateData['bio'] = $_POST['bio'];
    // handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = "assets/resources/profile_images/" . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $imagePath);
        $updateData['profile_image'] = $imagePath;
    }
    if (!empty($updateData)) {
        $collection->updateOne(['_id' => $id], ['$set' => $updateData]);
        // If AJAX, return JSON
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();

        // Otherwise, redirect (legacy)
        header("Location: faculty_profile.php?id=" . $_POST['id']);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();

        header("Location: faculty_profile.php?id=" . $_POST['id']);
        exit();
    }
}
