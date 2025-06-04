<?php
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = new MongoDB\BSON\ObjectId($_POST['id']);

    $updateData = [
        'name' => $_POST['name'],
        'bio' => $_POST['bio'],
        'interested_fields_of_research' => array_map('trim', explode(',', $_POST['interested_fields'])),
        'prerequisites' => array_map('trim', explode(',', $_POST['prerequisites'])),
        'projects' => $_POST['projects'],
        'resources_to_learn_prerequisites' => $_POST['resources']
    ];

    // handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = "assets/resources/profile_images/" . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $imagePath);
        $updateData['profile_image'] = $imagePath;
    }

    $collection->updateOne(['_id' => $id], ['$set' => $updateData]);

    header("Location: faculty_profile.php?id=" . $_POST['id']);
    exit();
}
