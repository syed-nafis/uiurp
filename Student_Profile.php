<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    $_SESSION['error'] = "Please login to view your profile";
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

// Default profile image if not set
$profileImage = isset($student['profile_image']) && !empty($student['profile_image']) 
    ? $student['profile_image'] 
    : 'assets/resources/student.jpeg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        .profile-section {
            padding: 30px 0;
        }
        .profile-header {
            padding: 40px 0;
            position: relative;
        }
        .edit-profile-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .social-icons a {
            margin-right: 15px;
            font-size: 24px;
            color: #495057;
            transition: color 0.3s;
        }
        .social-icons a:hover {
            color: #0d6efd;
        }
        .skills-tag {
            display: inline-block;
            background-color: #e9ecef;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
  <?php include 'src/includes/navbar.php'; ?>

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
    
  <div class="container profile-header">
    <a href="Student_Profile_Edit.php" class="btn btn-primary edit-profile-btn">
        <i class="bi bi-pencil-square"></i> Edit Profile
    </a>
    
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4">Hi, I'm <strong><?= htmlspecialchars($student['name'] ?? 'Student') ?></strong></h1>
            <p class="lead"><?= htmlspecialchars($student['bio'] ?? 'Welcome to my profile! I\'m a student passionate about learning new skills and building projects.') ?></p>
            
            <div class="social-icons mb-3">
                <?php if(isset($student['linkedin'])): ?>
                    <a href="<?= htmlspecialchars($student['linkedin']) ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
                <?php endif; ?>
                
                <?php if(isset($student['github'])): ?>
                    <a href="<?= htmlspecialchars($student['github']) ?>" target="_blank"><i class="bi bi-github"></i></a>
                <?php endif; ?>
                
                <?php if(isset($student['twitter'])): ?>
                    <a href="<?= htmlspecialchars($student['twitter']) ?>" target="_blank"><i class="bi bi-twitter-x"></i></a>
                <?php endif; ?>
            </div>
            
            <p><i class="bi bi-envelope"></i> <?= htmlspecialchars($student['email'] ?? 'email@example.com') ?></p>
            
            <?php if(isset($student['phone'])): ?>
                <p><i class="bi bi-telephone"></i> <?= htmlspecialchars($student['phone']) ?></p>
            <?php endif; ?>
        </div>
        
        <div class="col-md-6 text-center">
            <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="max-height: 300px; max-width: 300px;">
        </div>
    </div>
  </div>

  <!-- Education Section -->
  <section class="profile-section bg-light py-5">
    <div class="container">
        <h2 class="mb-4">Education</h2>
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($student['education']) && is_array($student['education']) && count($student['education']) > 0): ?>
                    <?php foreach($student['education'] as $education): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($education['degree'] ?? 'Degree') ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($education['institution'] ?? 'Institution') ?></h6>
                                <p class="card-text">
                                    <?= htmlspecialchars($education['year'] ?? 'Year') ?> - 
                                    <?= htmlspecialchars($education['field'] ?? 'Field of Study') ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="text-muted">No education information added yet.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
  </section>

  <!-- Projects Section -->
  <section class="profile-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Projects</h2>
        <div class="row">
            <?php if(isset($student['projects']) && is_array($student['projects']) && count($student['projects']) > 0): ?>
                <?php foreach($student['projects'] as $project): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($project['title'] ?? 'Project Title') ?></h5>
                                <p class="card-text"><?= htmlspecialchars($project['description'] ?? 'Project Description') ?></p>
                                <?php if(isset($project['link'])): ?>
                                    <a href="<?= htmlspecialchars($project['link']) ?>" class="btn btn-sm btn-primary" target="_blank">View Project</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No projects added yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
  </section>

  <!-- Skills Section -->
  <section class="profile-section bg-light py-5">
    <div class="container">
        <h2 class="mb-4">Skills</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <?php if(isset($student['skills']) && is_array($student['skills']) && count($student['skills']) > 0): ?>
                            <?php foreach($student['skills'] as $skill): ?>
                                <span class="skills-tag"><?= htmlspecialchars($skill) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No skills added yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-light py-4">
    <div class="container text-center">
        <p>© <?= date('Y') ?> UIURP - University Research Platform</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
