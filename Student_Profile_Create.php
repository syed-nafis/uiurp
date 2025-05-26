<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    $_SESSION['error'] = "Please login to create your profile";
    header('Location: login.php');
    exit();
}

// Include MongoDB connection
require __DIR__ . '/vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$studentsCollection = $db->students;

// Get the current user's ID from the session
$userId = $_SESSION['user_id'];

// Check if a profile already exists
$existingProfile = $studentsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
if ($existingProfile) {
    // Profile already exists, redirect to edit page
    header('Location: Student_Profile_Edit.php');
    exit();
}

// Get basic user data from session
$userData = $_SESSION['user_data'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        .form-section {
            margin-bottom: 30px;
        }
        .section-title {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .add-btn {
            margin-top: 10px;
        }
        .form-floating {
            margin-bottom: 15px;
        }
        .welcome-banner {
            background: linear-gradient(135deg, #4cc9f0, #7209b7);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .dynamic-form-item {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            position: relative;
        }
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #dc3545;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <div class="container py-5 mt-5">
        <div class="welcome-banner">
            <h1 class="display-4">Welcome to UIURP!</h1>
            <p class="lead">Let's set up your profile to help you get the most out of our research platform. Your profile will showcase your skills, education, and projects to the community.</p>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['info'])): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?= $_SESSION['info'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['info']); ?>
                <?php endif; ?>

                <form action="src/controller/create_student_profile.php" method="POST" enctype="multipart/form-data">
                    <!-- Personal Information Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="section-title">Personal Information</h2>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= htmlspecialchars($userData['name'] ?? '') ?>" required>
                                        <label for="name">Name</label>
                                    </div>
                                    
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($userData['email'] ?? '') ?>" required>
                                        <label for="email">Email</label>
                                    </div>
                                    
                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
                                        <label for="phone">Phone (optional)</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                        <div class="form-text">Upload a profile picture (optional)</div>
                                    </div>
                                    
                                    <div class="form-floating">
                                        <textarea class="form-control" id="bio" name="bio" style="height: 100px;" placeholder="Bio"></textarea>
                                        <label for="bio">Bio</label>
                                        <div class="form-text">Tell us about yourself, your research interests, and goals.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="section-title">Social Links</h2>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="LinkedIn">
                                        <label for="linkedin">LinkedIn Profile</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="url" class="form-control" id="github" name="github" placeholder="GitHub">
                                        <label for="github">GitHub Profile</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="url" class="form-control" id="twitter" name="twitter" placeholder="Twitter">
                                        <label for="twitter">Twitter Profile</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Education Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="section-title">Education</h2>
                            
                            <div id="education-container">
                                <div class="dynamic-form-item education-item">
                                    <button type="button" class="remove-btn" onclick="removeEducation(this)">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="education[0][degree]" placeholder="Degree" required>
                                                <label>Degree</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="education[0][institution]" placeholder="Institution" required>
                                                <label>Institution</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="education[0][field]" placeholder="Field of Study">
                                                <label>Field of Study</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="education[0][year]" placeholder="Year">
                                                <label>Year</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary add-btn" onclick="addEducation()">
                                <i class="bi bi-plus-circle"></i> Add Education
                            </button>
                        </div>
                    </div>
                    
                    <!-- Skills Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="section-title">Skills</h2>
                            
                            <div class="mb-3">
                                <label for="skills-input" class="form-label">Skills (comma separated)</label>
                                <input type="text" class="form-control" id="skills-input" name="skills" placeholder="e.g. JavaScript, Python, React, MongoDB">
                                <div class="form-text">Enter your skills separated by commas</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Create Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Variables to track the current index for dynamic fields
        let educationIndex = 1;
        
        // Function to add a new education field
        function addEducation() {
            const container = document.getElementById('education-container');
            const newItem = document.createElement('div');
            newItem.className = 'dynamic-form-item education-item';
            newItem.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeEducation(this)">
                    <i class="bi bi-x-circle"></i>
                </button>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="education[${educationIndex}][degree]" placeholder="Degree" required>
                            <label>Degree</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="education[${educationIndex}][institution]" placeholder="Institution" required>
                            <label>Institution</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="education[${educationIndex}][field]" placeholder="Field of Study">
                            <label>Field of Study</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="education[${educationIndex}][year]" placeholder="Year">
                            <label>Year</label>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            educationIndex++;
        }
        
        // Function to remove an education field
        function removeEducation(button) {
            // Don't remove if it's the last item
            if (document.querySelectorAll('.education-item').length <= 1) {
                alert('You must have at least one education entry');
                return;
            }
            button.parentElement.remove();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 