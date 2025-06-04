<?php
// Get all images from the Resources folder
$imageFolder = "assets/resources/research_picture/";
$images = glob($imageFolder . "*.{jpg,png,jpeg,gif}", GLOB_BRACE);

// Start the session 
session_start();

// Include the MongoDB PHP library
require 'vendor/autoload.php';

// Create a MongoDB client
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$collection = $client->uiurp->faculties;

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) { 
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
    <link rel="stylesheet" href="assets/styles/faculty_profile.css">
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <!-- Hero Section -->
    <header>
    <div class="container py-5 text-left">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 id="facultyName" style="font-size: 60px;">Hello, I'm <strong><?= $faculty['name']; ?></strong></h1>
                <p id="facultyBio"><?= $faculty['bio']; ?></p>
                <div class="py-3">
                    <!-- <a href="#" class="btn btn-primary me-2 mb-2">Say Hello!</a> -->
                    <a href="#projects" class="btn btn-primary me-2 mb-2">My Projects</a>
                    <!-- Button to trigger the popup window -->
                    <button class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                        Current Schedule
                    </button>
                    <a href="#interested-fields" class="btn btn-primary me-2 mb-2">Interested Field</a>
                    <a href="#prerequisite" class="btn btn-primary me-2 mb-2">Prerequisite</a>
                    <a href="#resource" class="btn btn-primary me-2 mb-2">Learning Resource</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <img src="<?= $faculty['profile_image'] ?? 'assets/resources/imgPlaceholder.png'; ?>" alt="Profile Picture" class="img-fluid rounded" id="facultyImage">
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Bootstrap Modal (Popup Window) -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Current Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Embed the external website using an iframe -->
                <iframe src="https://now.nahid.org/" width="100%" height="500px" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>


<!-- Interested Fields Section -->
<section id="interested-fields" class="py-5 bg-light">
    <h2 class="text-center mb-5">Interested Fields
    <!--Only logged in faculty can see this option --> 
    <?php if (isset($_SESSION['user_id'], $_SESSION['user_type']) && $_SESSION['user_type'] === 'faculty' && $_SESSION['user_id'] === (string)$faculty['_id']): ?>
        <a href="edit_faculty.php?id=<?= $faculty['_id']; ?>#interested-fields" class="btn btn-sm btn-outline-secondary ms-2">Edit</a>
    <?php endif; ?>


    </h2>
    <div class="container">
        <div class="row justify-content-center">
            <?php foreach ($faculty['interested_fields_of_research'] as $field): ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="field-box p-4 shadow-sm rounded-4 bg-white h-100 d-flex align-items-center justify-content-center text-center">
                        <h5 class="mb-0 text-dark"><?= $field; ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- Publications Section -->
<section id="projects" class="container py-5">

    <!-- Centered heading + edit button -->
    <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
        <h2 class="mb-0">Publications</h2>
        <?php if (
            isset($_SESSION['user_id'], $_SESSION['user_type']) &&
            $_SESSION['user_type'] === 'faculty' &&
            $_SESSION['user_id'] === (string)$faculty['_id']
        ): ?>
            <a href="edit_faculty.php?id=<?= htmlspecialchars((string)$faculty['_id']); ?>#projects" class="btn btn-sm btn-outline-secondary">Edit</a>
        <?php endif; ?>
    </div>

    <!-- Projects grid -->
    <div class="row">
        <?php foreach ($faculty['projects'] as $project): ?>
            <div class="col-md-4 p-3">
                <a href="<?= htmlspecialchars($project['link'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit;">
                    <div class="card p-3">
                        <?php 
                            $randomImage = $images[array_rand($images)]; 
                        ?>
                        <img src="<?= htmlspecialchars($randomImage); ?>" class="card-img-top" alt="Project Image" style="width: 100%; height: auto;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($project['title']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($project['description']); ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</section>



<section id="prerequisite" class="prerequisites-section py-5 bg-white">
    <!-- Center heading and edit button together -->
    <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
        <h2 class="mb-0">Prerequisites</h2>
        <?php if (isset($_SESSION['user_id'], $_SESSION['user_type']) 
                  && $_SESSION['user_type'] === 'faculty' 
                  && $_SESSION['user_id'] === (string)$faculty['_id']): ?>
            <a href="edit_faculty.php?id=<?= $faculty['_id']; ?>#interested-fields" 
               class="btn btn-sm btn-outline-secondary">Edit</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <?php if (!empty($faculty['prerequisites']) && count($faculty['prerequisites']) > 0): ?>
            <div class="row justify-content-center">
                <?php foreach ($faculty['prerequisites'] as $prerequisite): ?>
                    <div class="col-md-5 col-lg-4 mb-4">
                        <div class="prerequisite-card p-4 shadow-sm rounded bg-light h-100">
                            <h5 class="text-dark mb-0"><?= htmlspecialchars($prerequisite); ?></h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No prerequisites available at the moment.</p>
        <?php endif; ?>
    </div>
</section>


<section id="resource" class="resources-section py-5 bg-light">
    <!-- Center heading and edit button together -->
    <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
        <h2 class="mb-0">Resources to Learn Prerequisites</h2>
        <?php if (isset($_SESSION['user_id'], $_SESSION['user_type']) 
                  && $_SESSION['user_type'] === 'faculty' 
                  && $_SESSION['user_id'] === (string)$faculty['_id']): ?>
            <a href="edit_faculty.php?id=<?= $faculty['_id']; ?>#interested-fields" 
               class="btn btn-sm btn-outline-secondary">Edit</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <?php if (!empty($faculty['resources_to_learn_prerequisites']) && count($faculty['resources_to_learn_prerequisites']) > 0): ?>
            <div class="row justify-content-center">
                <?php foreach ($faculty['resources_to_learn_prerequisites'] as $resource): ?>
                    <div class="col-md-5 col-lg-4 mb-4">
                        <a href="<?= htmlspecialchars($resource['link']); ?>" target="_blank" 
                            class="resource-card d-block p-4 text-decoration-none shadow-sm rounded bg-white h-100">
                            <h5 class="text-primary mb-1"><?= htmlspecialchars($resource['topic']); ?></h5>
                            <small class="text-muted">Click to learn more</small>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No resources available at the moment.</p>
        <?php endif; ?>
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