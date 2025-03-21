<?php
// Get all images from the Resources folder
$imageFolder = "Resources/research_picture/";
$images = glob($imageFolder . "*.{jpg,png,jpeg,gif}", GLOB_BRACE);

// Start the session (if not already started)
session_start();

// Include the MongoDB PHP library
require 'vendor/autoload.php';

// Create a MongoDB client
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) { // Corrected from '_id' to 'id'
    try {
        // Convert the 'id' parameter to a MongoDB ObjectId
        $faculty_id = new MongoDB\BSON\ObjectId($_GET['id']);

        // Find the faculty member by _id
        $faculty = $collection->findOne(['_id' => $faculty_id]);

        // Check if the faculty member exists
        if ($faculty) {
            // Convert MongoDB BSON document to an associative array
            $faculty = iterator_to_array($faculty);
        } else {
            // If no faculty member is found, redirect or show an error
            header("Location: faculty_page.php");
            exit();
        }
    } catch (Exception $e) {
        // Handle invalid ObjectId or other errors
        header("Location: faculty_page.php");
        exit();
    }
} else {
    // If no 'id' parameter is provided, redirect or show an error
    header("Location: faculty_page.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile - <?= $faculty['name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <header>
        <div class="container py-5 text-left">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 id="facultyName" style="font-size: 60px;">Hello, I'm <strong><?= $faculty['name']; ?></strong></h1>
                    <p id="facultyBio"><?= $faculty['bio']; ?></p>
                    <div class="py-3">
                        <a href="#" class="btn btn-primary me-2 mb-2">Say Hello!</a>
                        <a href="#" class="btn btn-primary me-2 mb-2">My Projects</a>
                        <a href="#" class="btn btn-secondary mb-2">Current Schedule</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <img src="<?= $faculty['profile_image'] ?? 'Resources/imgPlaceholder.png'; ?>" alt="Profile Picture" class="img-fluid rounded" id="facultyImage">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Interested Fields Section -->
    <section class="py-5 bg-light">
        <h2 class="text-center mb-4">Interested Fields</h2>
        <div class="container p-3 text-center align-items-center">
            <div class="row text-center align-items-center justify-content-center">
                <?php foreach ($faculty['interested_fields_of_research'] as $field): ?>
                    <div class="col-md-3">
                        <div class="p-3 border rounded">
                            <h3><?= $field; ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Publications Section -->
    <section class="container py-5">
    <h2 class="text-center mb-4">Publications</h2>
    <div class="row">
        <?php foreach ($faculty['projects'] as $project): ?>
            <div class="col-md-4 p-3">
                <div class="card p-3">
                    <?php 
                        // Select a random image from the folder
                        $randomImage = $images[array_rand($images)]; 
                    ?>
                    <img src="<?= $randomImage; ?>" class="card-img-top" alt="Project Image" style="width: 100%; height: auto;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $project['title']; ?></h5>
                        <p class="card-text"><?= $project['description']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

    <!-- Contact Section -->
    <section class="bg-dark text-light py-5">
        <div class="container">
            <h2 class="text-center">Do you have a Project Idea? Let's discuss!</h2>
            <div class="row mt-4">
                <div class="col-md-6">
                    <h4>Need help accessing research papers?</h4>
                    <p>Address: <?= $faculty['office_number'] ?? 'N/A'; ?></p>
                    <p>Email: <?= $faculty['email'] ?? 'N/A'; ?></p>
                    <p>Call: <?= $faculty['phone'] ?? 'N/A'; ?></p>
                </div>
                <div class="col-md-6">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Enter your message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>