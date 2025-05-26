<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    $_SESSION['error'] = "Please login to edit your profile";
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

// Fetch the student data from MongoDB
$studentData = $studentsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);

// If student data not found, redirect to create profile page
if (!$studentData) {
    $_SESSION['info'] = "You need to set up your profile first";
    header('Location: Student_Profile_Create.php');
    exit();
}

// Convert MongoDB document to an array
$student = json_decode(json_encode($studentData), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Edit Profile</h1>
                    <a href="Student_Profile.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Profile
                    </a>
                </div>

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

                <form action="src/controller/update_student_profile.php" method="POST" enctype="multipart/form-data">
                    <!-- Personal Information Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="section-title">Personal Information</h2>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= htmlspecialchars($student['name'] ?? '') ?>" required>
                                        <label for="name">Name</label>
                                    </div>
                                    
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($student['email'] ?? '') ?>" required>
                                        <label for="email">Email</label>
                                    </div>
                                    
                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?= htmlspecialchars($student['phone'] ?? '') ?>">
                                        <label for="phone">Phone (optional)</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <?php if(isset($student['profile_image']) && !empty($student['profile_image'])): ?>
                                            <div class="mb-2">
                                                <img src="<?= htmlspecialchars($student['profile_image']) ?>" alt="Current Profile Image" class="img-thumbnail" style="max-height: 150px;">
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                        <div class="form-text">Upload a new image (optional)</div>
                                    </div>
                                    
                                    <div class="form-floating">
                                        <textarea class="form-control" id="bio" name="bio" style="height: 100px;" placeholder="Bio"><?= htmlspecialchars($student['bio'] ?? '') ?></textarea>
                                        <label for="bio">Bio</label>
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
                                        <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="LinkedIn" value="<?= htmlspecialchars($student['linkedin'] ?? '') ?>">
                                        <label for="linkedin">LinkedIn Profile</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="url" class="form-control" id="github" name="github" placeholder="GitHub" value="<?= htmlspecialchars($student['github'] ?? '') ?>">
                                        <label for="github">GitHub Profile</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="url" class="form-control" id="twitter" name="twitter" placeholder="Twitter" value="<?= htmlspecialchars($student['twitter'] ?? '') ?>">
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
                                <?php if(isset($student['education']) && is_array($student['education']) && count($student['education']) > 0): ?>
                                    <?php foreach($student['education'] as $index => $education): ?>
                                        <div class="dynamic-form-item education-item">
                                            <button type="button" class="remove-btn" onclick="removeEducation(this)">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="education[<?= $index ?>][degree]" placeholder="Degree" value="<?= htmlspecialchars($education['degree'] ?? '') ?>" required>
                                                        <label>Degree</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="education[<?= $index ?>][institution]" placeholder="Institution" value="<?= htmlspecialchars($education['institution'] ?? '') ?>" required>
                                                        <label>Institution</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="education[<?= $index ?>][field]" placeholder="Field of Study" value="<?= htmlspecialchars($education['field'] ?? '') ?>">
                                                        <label>Field of Study</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="education[<?= $index ?>][year]" placeholder="Year" value="<?= htmlspecialchars($education['year'] ?? '') ?>">
                                                        <label>Year</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary add-btn" onclick="addEducation()">
                                <i class="bi bi-plus-circle"></i> Add Education
                            </button>
                        </div>
                    </div>
                    
                    <!-- Projects Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="section-title">Projects</h2>
                            
                            <div id="projects-container">
                                <?php if(isset($student['projects']) && is_array($student['projects']) && count($student['projects']) > 0): ?>
                                    <?php foreach($student['projects'] as $index => $project): ?>
                                        <div class="dynamic-form-item project-item">
                                            <button type="button" class="remove-btn" onclick="removeProject(this)">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="projects[<?= $index ?>][title]" placeholder="Title" value="<?= htmlspecialchars($project['title'] ?? '') ?>" required>
                                                <label>Project Title</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="projects[<?= $index ?>][description]" placeholder="Description" style="height: 100px;" required><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
                                                <label>Project Description</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="url" class="form-control" name="projects[<?= $index ?>][link]" placeholder="Link" value="<?= htmlspecialchars($project['link'] ?? '') ?>">
                                                <label>Project Link (optional)</label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary add-btn" onclick="addProject()">
                                <i class="bi bi-plus-circle"></i> Add Project
                            </button>
                        </div>
                    </div>
                    
                    <!-- Skills Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="section-title">Skills</h2>
                            
                            <div class="mb-3">
                                <label for="skills-input" class="form-label">Skills (comma separated)</label>
                                <input type="text" class="form-control" id="skills-input" name="skills" placeholder="e.g. JavaScript, Python, React, MongoDB" 
                                    value="<?= htmlspecialchars(isset($student['skills']) && is_array($student['skills']) ? implode(', ', $student['skills']) : '') ?>">
                                <div class="form-text">Enter your skills separated by commas</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Save Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Variables to track the current index for dynamic fields
        let educationIndex = <?= isset($student['education']) && is_array($student['education']) ? count($student['education']) : 0 ?>;
        let projectIndex = <?= isset($student['projects']) && is_array($student['projects']) ? count($student['projects']) : 0 ?>;
        
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
            button.parentElement.remove();
        }
        
        // Function to add a new project field
        function addProject() {
            const container = document.getElementById('projects-container');
            const newItem = document.createElement('div');
            newItem.className = 'dynamic-form-item project-item';
            newItem.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeProject(this)">
                    <i class="bi bi-x-circle"></i>
                </button>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="projects[${projectIndex}][title]" placeholder="Title" required>
                    <label>Project Title</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="projects[${projectIndex}][description]" placeholder="Description" style="height: 100px;" required></textarea>
                    <label>Project Description</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="url" class="form-control" name="projects[${projectIndex}][link]" placeholder="Link">
                    <label>Project Link (optional)</label>
                </div>
            `;
            container.appendChild(newItem);
            projectIndex++;
        }
        
        // Function to remove a project field
        function removeProject(button) {
            button.parentElement.remove();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 