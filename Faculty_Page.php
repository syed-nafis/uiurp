<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/faculty_page.css">
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <div class="hero-section">
        <img src="assets/resources/faculty_hero.jpg" alt="Faculty Image" class="hero-image">
        <div class="overlay">
            <h1>Our Faculty</h1>
            <p>At the Head of the Class<br>UIU faculty are renowned leaders in their fields, extraordinary teachers, and dedicated mentors.</p>
            <!-- Search Bar -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <input type="text" id="facultySearch" class="form-control form-control-lg" placeholder="Search by faculty name...">
                </div>
            </div>
        </div>
    
    </div>

    <!-- Faculty List -->
    <div class="container mt-5">
        <div class="row" id="facultyList">
            <!-- Faculty members will be dynamically inserted here -->
        </div>
    </div>

    <?php include 'src/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/scripts/faculty_loader.js"></script>
</body>
</html>