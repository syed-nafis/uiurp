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

// Set default profile image if not present
$profileImage = $faculty['profile_image'] ?? 'assets/resources/imgPlaceholder.png';
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile - <?= $faculty['name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/faculty_profile_modern.css">
    <link rel="stylesheet" href="assets/styles/faculty_page.css">
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <!-- Hero Section -->
    <header>
        <div class="container py-5">
            <div class="row align-items-center pt-4">
                <div class="col-md-6">
                    <h1 id="facultyName">Hello, I'm <strong><?= $faculty['name']; ?></strong></h1>
                    <p id="facultyBio"><?= $faculty['bio']; ?></p>
                    <div class="action-buttons py-3">
                        <a href="#projects" class="btn btn-primary me-2 mb-2">
                            <i class="bi bi-journal-richtext me-1"></i> My Publications
                        </a>
                        <button class="btn btn-secondary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                            <i class="bi bi-calendar-week me-1"></i> Current Schedule
                        </button>
                        <a href="#interested-fields" class="btn btn-primary me-2 mb-2">
                            <i class="bi bi-stars me-1"></i> Research Fields
                        </a>
                        <a href="#prerequisite" class="btn btn-primary me-2 mb-2">
                            <i class="bi bi-list-check me-1"></i> Prerequisites
                        </a>
                        <a href="#resource" class="btn btn-primary me-2 mb-2">
                            <i class="bi bi-book me-1"></i> Resources
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <img src="<?= $profileImage; ?>" alt="Profile Picture" class="rounded shadow" id="facultyImage">
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
                    <h5 class="modal-title" id="scheduleModalLabel">
                        <i class="bi bi-calendar-week me-2"></i> Current Schedule
                    </h5>
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
    <section id="interested-fields" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center mb-5">
                <h2 class="text-center mb-0">Research Fields
                    <?php if (isset($_SESSION['user_id'], $_SESSION['user_type']) && $_SESSION['user_type'] === 'faculty' && $_SESSION['user_id'] === (string)$faculty['_id']): ?>
                        <a href="edit_faculty.php?id=<?= $faculty['_id']; ?>#interested-fields" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    <?php endif; ?>
                </h2>
            </div>
            
            <div class="row justify-content-center">
                <?php foreach ($faculty['interested_fields_of_research'] as $index => $field): ?>
                    <div class="col-md-3 col-sm-6 mb-4" style="--delay: <?= $index ?>;">
                        <div class="field-box p-4 shadow-sm h-100 d-flex align-items-center justify-content-center text-center">
                            <h5 class="mb-0"><?= $field; ?></h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Publications Section -->
    <section id="projects" class="py-5">
        <div class="container">
            <!-- Centered heading + edit button -->
            <div class="d-flex justify-content-center align-items-center gap-2 mb-5">
                <h2 class="mb-0">Publications</h2>
                <?php if (
                    isset($_SESSION['user_id'], $_SESSION['user_type']) &&
                    $_SESSION['user_type'] === 'faculty' &&
                    $_SESSION['user_id'] === (string)$faculty['_id']
                ): ?>
                    <a href="edit_faculty.php?id=<?= htmlspecialchars((string)$faculty['_id']); ?>#projects" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                <?php endif; ?>
            </div>

            <!-- Projects grid -->
            <div class="row">
                <?php foreach ($faculty['projects'] as $index => $project): ?>
                    <div class="col-md-4 p-3" style="--delay: <?= $index ?>;">
                        <a href="<?= htmlspecialchars($project['link'] ?? '#'); ?>" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit;">
                            <div class="card h-100">
                                <?php 
                                    $randomImage = $images[array_rand($images)]; 
                                ?>
                                <img src="<?= htmlspecialchars($randomImage); ?>" class="card-img-top" alt="Project Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($project['title']); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($project['description']); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Prerequisites Section -->
    <section id="prerequisite" class="py-5">
        <div class="container">
            <!-- Center heading and edit button together -->
            <div class="d-flex justify-content-center align-items-center gap-2 mb-5">
                <h2 class="mb-0">Prerequisites</h2>
                <?php if (isset($_SESSION['user_id'], $_SESSION['user_type']) 
                        && $_SESSION['user_type'] === 'faculty' 
                        && $_SESSION['user_id'] === (string)$faculty['_id']): ?>
                    <a href="edit_faculty.php?id=<?= $faculty['_id']; ?>#interested-fields" 
                    class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                <?php endif; ?>
            </div>

            <?php if (!empty($faculty['prerequisites']) && count($faculty['prerequisites']) > 0): ?>
                <div class="row justify-content-center">
                    <?php foreach ($faculty['prerequisites'] as $index => $prerequisite): ?>
                        <div class="col-md-5 col-lg-4 mb-4" style="--delay: <?= $index ?>;">
                            <div class="prerequisite-card p-4 h-100">
                                <h5 class="mb-0"><?= htmlspecialchars($prerequisite); ?></h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center glass-card p-5 mx-auto" style="max-width: 600px;">
                    <i class="bi bi-exclamation-circle" style="font-size: 3rem; color: var(--accent-blue);"></i>
                    <p class="mt-3">No prerequisites available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Resources Section -->
    <section id="resource" class="py-5">
        <div class="container">
            <!-- Center heading and edit button together -->
            <div class="d-flex justify-content-center align-items-center gap-2 mb-5">
                <h2 class="mb-0">Learning Resources</h2>
                <?php if (isset($_SESSION['user_id'], $_SESSION['user_type']) 
                        && $_SESSION['user_type'] === 'faculty' 
                        && $_SESSION['user_id'] === (string)$faculty['_id']): ?>
                    <a href="edit_faculty.php?id=<?= $faculty['_id']; ?>#interested-fields" 
                    class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                <?php endif; ?>
            </div>

            <?php if (!empty($faculty['resources_to_learn_prerequisites']) && count($faculty['resources_to_learn_prerequisites']) > 0): ?>
                <div class="row justify-content-center">
                    <?php foreach ($faculty['resources_to_learn_prerequisites'] as $index => $resource): ?>
                        <div class="col-md-5 col-lg-4 mb-4" style="--delay: <?= $index ?>;">
                            <a href="<?= htmlspecialchars($resource['link']); ?>" target="_blank" 
                                class="resource-card d-block p-4 text-decoration-none h-100">
                                <h5 class="mb-1">
                                    <i class="bi bi-link-45deg me-2"></i>
                                    <?= htmlspecialchars($resource['topic']); ?>
                                </h5>
                                <small class="text-muted">Click to learn more</small>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center glass-card p-5 mx-auto" style="max-width: 600px;">
                    <i class="bi bi-book" style="font-size: 3rem; color: var(--accent-blue);"></i>
                    <p class="mt-3">No resources available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Do you have a Project Idea? Let's discuss!</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="contact-info">
                        <h4>
                            <i class="bi bi-info-circle me-2"></i>
                            Contact Information
                        </h4>
                        <p>
                            <i class="bi bi-building"></i>
                            Office: <?= $faculty['office_number'] ?? 'N/A'; ?>
                        </p>
                        <p>
                            <i class="bi bi-envelope"></i>
                            Email: <?= $faculty['email'] ?? 'N/A'; ?>
                        </p>
                        <p>
                            <i class="bi bi-telephone"></i>
                            Phone: <?= $faculty['phone'] ?? 'N/A'; ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
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
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send me-1"></i> Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Check for user's theme preference
    document.addEventListener('DOMContentLoaded', function() {
        // Check for saved theme preference or default to 'dark'
        const savedTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
        
        // Listen for theme changes from navbar (if it has theme toggle functionality)
        window.addEventListener('themeChanged', function(e) {
            const newTheme = e.detail.theme;
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
        
        // Apply proper close button styling based on theme
        const btnClose = document.querySelector('.btn-close');
        if (btnClose) {
            btnClose.classList.add(savedTheme === 'dark' ? 'btn-close-white' : '');
        }
        
        // Add animation delay to cards for staggered animation
        document.querySelectorAll('.card, .field-box, .prerequisite-card, .resource-card').forEach(function(el, index) {
            if (!el.style.getPropertyValue('--delay')) {
                el.style.setProperty('--delay', index % 5); // Cycle through 0-4 delay values
            }
        });
    });
    </script>
</body>
</html>