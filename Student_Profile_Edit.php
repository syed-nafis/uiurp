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
    <title>Edit Profile - <?= htmlspecialchars($student['basic_info']['name'] ?? 'Student') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        :root {
            /* Dark mode (default) */
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --bg-card: rgba(30, 41, 59, 0.8);
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --border-color: rgba(203, 213, 225, 0.1);
            --accent-primary: #3b82f6;
            --accent-secondary: #8b5cf6;
            --accent-success: #10b981;
            --accent-danger: #ef4444;
            --accent-warning: #f59e0b;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            --glass-bg: rgba(30, 41, 59, 0.6);
            --glass-border: rgba(203, 213, 225, 0.1);
        }

        /* Light mode */
        [data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #e2e8f0;
            --bg-card: rgba(255, 255, 255, 0.9);
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: rgba(30, 41, 59, 0.1);
            --accent-primary: #3b82f6;
            --accent-secondary: #8b5cf6;
            --accent-success: #10b981;
            --accent-danger: #ef4444;
            --accent-warning: #f59e0b;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(30, 41, 59, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            line-height: 1.6;
            min-height: 100vh;
            padding-top: 2rem;
        }

        /* Light mode body background */
        [data-theme="light"] body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .container {
            max-width: 900px;
        }

        /* Page Header */
        .page-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%);
            opacity: 0.05;
            z-index: -1;
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-header .subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* Cards */
        .modern-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .modern-card:hover::before {
            left: 100%;
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: rgba(59, 130, 246, 0.2);
        }

        /* Section Titles */
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 2px;
        }

        /* Form Controls */
        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: var(--bg-tertiary);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            color: var(--text-primary);
        }

        .form-floating > label {
            color: var(--text-muted);
            padding: 1rem;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: var(--accent-primary);
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }

        /* Form labels - better contrast */
        .form-label {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Floating labels specific styling */
        .form-floating > label {
            color: var(--text-secondary);
            padding: 1rem;
            font-weight: 400;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: var(--accent-primary);
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            font-weight: 500;
        }

        /* Light mode label adjustments */
        [data-theme="light"] .form-label {
            color: var(--text-primary);
        }

        [data-theme="light"] .form-floating > label {
            color: var(--text-secondary);
        }

        /* File Input */
        .file-upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: var(--bg-tertiary);
        }

        .file-upload-area:hover {
            border-color: var(--accent-primary);
            background: rgba(59, 130, 246, 0.05);
        }

        .current-image {
            max-width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--accent-primary);
            margin-bottom: 1rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* Dynamic Form Items */
        .dynamic-form-item {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .dynamic-form-item:hover {
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .remove-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--accent-danger);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            z-index: 10;
        }

        .remove-btn:hover {
            background: #dc2626;
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .remove-btn i {
            color: white;
            font-size: 1rem;
            line-height: 1;
        }

        /* Buttons */
        .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--accent-primary);
            color: var(--accent-primary);
        }

        .btn-outline-primary:hover {
            background: var(--accent-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-outline-secondary:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--text-secondary);
        }

        .add-btn {
            background: linear-gradient(135deg, var(--accent-success), #059669);
            color: white;
            border: none;
            box-shadow: var(--shadow-sm);
            margin-top: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .add-btn i {
            font-size: 1rem;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent-success);
            border-left: 4px solid var(--accent-success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--accent-danger);
            border-left: 4px solid var(--accent-danger);
        }

        /* Form Text */
        .form-text {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Required Field Indicator */
        .required-field::after {
            content: "*";
            color: var(--accent-danger);
            margin-left: 5px;
            font-weight: bold;
        }

        /* Remove any conflicting label styles */
        .form-floating > .form-control:focus ~ label::after,
        .form-floating > .form-control:not(:placeholder-shown) ~ label::after {
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.75rem;
            }

            .modern-card {
                padding: 1.5rem;
            }

            .dynamic-form-item {
                padding: 1.5rem;
            }

            .remove-btn {
                top: 0.75rem;
                right: 0.75rem;
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }
        }

        /* Loading States */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Smooth Animations */
        * {
            scroll-behavior: smooth;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Focus Styles */
        .btn:focus,
        .form-control:focus {
            outline: none;
        }

        /* Custom Select Styling */
        select.form-control {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 3rem;
        }

        /* Section containers */
        .section-container {
            margin-bottom: 1rem;
        }

        .section-buttons {
            display: flex;
            justify-content: flex-start;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <!-- Page Header -->
                <div class="page-header fade-in">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1>Edit Profile</h1>
                            <p class="subtitle">Update your academic and research information</p>
                        </div>
                        <a href="Student_Profile.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Profile
                        </a>
                    </div>
                </div>

                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="src/controller/update_student_profile.php" method="POST" enctype="multipart/form-data">
                    <!-- Basic Information Section -->
                    <div class="modern-card fade-in">
                        <h2 class="section-title">
                            <i class="bi bi-person me-2"></i>Basic Information
                        </h2>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= htmlspecialchars($student['basic_info']['name'] ?? $student['name'] ?? '') ?>" required>
                                    <label for="name" class="required-field">Full Name</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="primary_email" name="primary_email" placeholder="Email" value="<?= htmlspecialchars($student['contact_info']['primary_email'] ?? $student['email'] ?? '') ?>" required>
                                    <label for="primary_email" class="required-field">Primary Email</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Profile Image</label>
                                <div class="file-upload-area">
                                    <?php 
                                    $currentImage = $student['basic_info']['profile_image_url'] ?? $student['profile_image'] ?? $student['profile_image_url'] ?? null;
                                    if(!empty($currentImage)): ?>
                                        <img src="<?= htmlspecialchars($currentImage) ?>" alt="Current Profile Image" class="current-image">
                                    <?php else: ?>
                                        <i class="bi bi-camera fs-1 text-muted mb-3 d-block"></i>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                                    <div class="form-text mt-2">Upload a new image to replace the current one</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Academic Information Section -->
                    <div class="modern-card fade-in">
                        <h2 class="section-title">
                            <i class="bi bi-mortarboard me-2"></i>Academic Information
                        </h2>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Student ID" value="<?= htmlspecialchars($student['academic_info']['student_id'] ?? $student['student_id'] ?? '') ?>" readonly>
                                    <label for="student_id">Student ID (Cannot be changed)</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" id="department" name="department">
                                        <option value="">Select Department</option>
                                        <option value="Computer Science and Engineering" <?= ($student['academic_info']['department'] ?? $student['department'] ?? '') == 'Computer Science and Engineering' ? 'selected' : '' ?>>Computer Science and Engineering</option>
                                        <option value="Electrical & Electronic Engineering" <?= ($student['academic_info']['department'] ?? $student['department'] ?? '') == 'Electrical & Electronic Engineering' ? 'selected' : '' ?>>Electrical & Electronic Engineering</option>
                                        <option value="Civil Engineering" <?= ($student['academic_info']['department'] ?? $student['department'] ?? '') == 'Civil Engineering' ? 'selected' : '' ?>>Civil Engineering</option>
                                        <option value="Business Administration" <?= ($student['academic_info']['department'] ?? $student['department'] ?? '') == 'Business Administration' ? 'selected' : '' ?>>Business Administration</option>
                                        <option value="Data Science" <?= ($student['academic_info']['department'] ?? $student['department'] ?? '') == 'Data Science' ? 'selected' : '' ?>>Data Science</option>
                                    </select>
                                    <label for="department">Department</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" id="current_status" name="current_status">
                                        <option value="Active" <?= ($student['academic_info']['current_status'] ?? $student['current_status'] ?? 'Active') == 'Active' ? 'selected' : '' ?>>Active</option>
                                        <option value="Graduated" <?= ($student['academic_info']['current_status'] ?? $student['current_status'] ?? '') == 'Graduated' ? 'selected' : '' ?>>Graduated</option>
                                        <option value="On Leave" <?= ($student['academic_info']['current_status'] ?? $student['current_status'] ?? '') == 'On Leave' ? 'selected' : '' ?>>On Leave</option>
                                    </select>
                                    <label for="current_status">Current Status</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="current_year_trimester" name="current_year_trimester" placeholder="Year/Trimester" value="<?= htmlspecialchars($student['academic_info']['current_year_trimester'] ?? $student['current_year_trimester'] ?? '') ?>">
                                    <label for="current_year_trimester">Current Year & Trimester</label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01" min="0" max="4" class="form-control" id="cgpa" name="cgpa" placeholder="CGPA" value="<?= htmlspecialchars($student['academic_info']['cgpa'] ?? $student['cgpa'] ?? '') ?>">
                                    <label for="cgpa">CGPA</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Research Profile Section -->
                    <div class="modern-card fade-in">
                        <h2 class="section-title">
                            <i class="bi bi-research me-2"></i>Research Profile
                        </h2>
                        
                        <div class="mb-3">
                            <label for="research-interests-input" class="form-label">Research Interests</label>
                            <input type="text" class="form-control" id="research-interests-input" name="research_interests" 
                                placeholder="e.g. Machine Learning, Cybersecurity, Data Science" 
                                value="<?= htmlspecialchars(isset($student['university_research_profile']['research_interests']) && is_array($student['university_research_profile']['research_interests']) ? implode(', ', $student['university_research_profile']['research_interests']) : '') ?>">
                            <div class="form-text">Enter your research interests separated by commas</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="skills-input" class="form-label">Skills & Expertise</label>
                            <input type="text" class="form-control" id="skills-input" name="skills" 
                                placeholder="e.g. Python, JavaScript, React, MongoDB" 
                                value="<?= htmlspecialchars(isset($student['university_research_profile']['skills_expertise']) && is_array($student['university_research_profile']['skills_expertise']) ? implode(', ', $student['university_research_profile']['skills_expertise']) : '') ?>">
                            <div class="form-text">Enter your skills separated by commas</div>
                        </div>
                    </div>
                    
                    <!-- Publications Section -->
                    <div class="modern-card fade-in">
                        <h2 class="section-title">
                            <i class="bi bi-book me-2"></i>Publications
                        </h2>
                        
                        <div class="section-container">
                            <div id="publications-container">
                                <?php if(isset($student['university_research_profile']['university_publications']) && is_array($student['university_research_profile']['university_publications']) && count($student['university_research_profile']['university_publications']) > 0): ?>
                                    <?php foreach($student['university_research_profile']['university_publications'] as $index => $publication): ?>
                                        <div class="dynamic-form-item">
                                            <button type="button" class="remove-btn" onclick="removePublication(this)">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" name="publications[<?= $index ?>][title]" placeholder="Title" value="<?= htmlspecialchars($publication['title'] ?? '') ?>" required>
                                                        <label>Publication Title</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" name="publications[<?= $index ?>][authors]" placeholder="Authors" value="<?= htmlspecialchars(isset($publication['authors']) ? implode(', ', $publication['authors']) : '') ?>" required>
                                                        <label>Authors (comma separated)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <select class="form-control" name="publications[<?= $index ?>][type]" required>
                                                            <option value="">Select Type</option>
                                                            <option value="Journal Article" <?= ($publication['publication_type'] ?? '') == 'Journal Article' ? 'selected' : '' ?>>Journal Article</option>
                                                            <option value="Conference Paper" <?= ($publication['publication_type'] ?? '') == 'Conference Paper' ? 'selected' : '' ?>>Conference Paper</option>
                                                            <option value="Book Chapter" <?= ($publication['publication_type'] ?? '') == 'Book Chapter' ? 'selected' : '' ?>>Book Chapter</option>
                                                        </select>
                                                        <label>Publication Type</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" name="publications[<?= $index ?>][venue]" placeholder="Venue" value="<?= htmlspecialchars($publication['venue_or_journal_name'] ?? '') ?>" required>
                                                        <label>Journal/Conference Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="date" class="form-control" name="publications[<?= $index ?>][date]" value="<?= isset($publication['publication_date']['$date']) ? date('Y-m-d', strtotime($publication['publication_date']['$date'])) : '' ?>">
                                                        <label>Publication Date</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <select class="form-control" name="publications[<?= $index ?>][status]">
                                                            <option value="Published" <?= ($publication['status'] ?? '') == 'Published' ? 'selected' : '' ?>>Published</option>
                                                            <option value="Accepted" <?= ($publication['status'] ?? '') == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                                                            <option value="Under Review" <?= ($publication['status'] ?? '') == 'Under Review' ? 'selected' : '' ?>>Under Review</option>
                                                        </select>
                                                        <label>Status</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="url" class="form-control" name="publications[<?= $index ?>][doi]" placeholder="DOI" value="<?= htmlspecialchars($publication['doi_url'] ?? '') ?>">
                                                        <label>DOI URL (optional)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="url" class="form-control" name="publications[<?= $index ?>][paper_url]" placeholder="Paper URL" value="<?= htmlspecialchars($publication['paper_url'] ?? '') ?>">
                                                        <label>Paper URL (optional)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="publications[<?= $index ?>][abstract]" style="height: 100px;" placeholder="Abstract"><?= htmlspecialchars($publication['abstract'] ?? '') ?></textarea>
                                                        <label>Abstract (optional)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="section-buttons">
                                <button type="button" class="btn add-btn" onclick="addPublication()">
                                    <i class="bi bi-plus-circle"></i>Add Publication
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Learning Resources Section -->
                    <div class="modern-card fade-in">
                        <h2 class="section-title">
                            <i class="bi bi-book-half me-2"></i>Learning Resources
                        </h2>
                        <p class="text-muted mb-4">Share useful resources, tutorials, documentation, and learning materials related to your skills and interests. Help other students discover valuable learning content!</p>
                        
                        <div class="section-container">
                            <div id="learning-resources-container">
                                <?php if(isset($student['learning_resources']) && is_array($student['learning_resources']) && count($student['learning_resources']) > 0): ?>
                                    <?php foreach($student['learning_resources'] as $index => $resource): ?>
                                        <div class="dynamic-form-item">
                                            <button type="button" class="remove-btn" onclick="removeLearningResource(this)">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" name="learning_resources[<?= $index ?>][title]" placeholder="Title" value="<?= htmlspecialchars($resource['title'] ?? '') ?>" required>
                                                        <label>Resource Title</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input type="url" class="form-control" name="learning_resources[<?= $index ?>][url]" placeholder="URL" value="<?= htmlspecialchars($resource['url'] ?? '') ?>" required>
                                                        <label>Resource URL</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <select class="form-control" name="learning_resources[<?= $index ?>][category]" required>
                                                            <option value="">Select Category</option>
                                                            <option value="Programming" <?= ($resource['category'] ?? '') == 'Programming' ? 'selected' : '' ?>>Programming</option>
                                                            <option value="Machine Learning" <?= ($resource['category'] ?? '') == 'Machine Learning' ? 'selected' : '' ?>>Machine Learning</option>
                                                            <option value="Data Science" <?= ($resource['category'] ?? '') == 'Data Science' ? 'selected' : '' ?>>Data Science</option>
                                                            <option value="Web Development" <?= ($resource['category'] ?? '') == 'Web Development' ? 'selected' : '' ?>>Web Development</option>
                                                            <option value="Mobile Development" <?= ($resource['category'] ?? '') == 'Mobile Development' ? 'selected' : '' ?>>Mobile Development</option>
                                                            <option value="Cybersecurity" <?= ($resource['category'] ?? '') == 'Cybersecurity' ? 'selected' : '' ?>>Cybersecurity</option>
                                                            <option value="Database" <?= ($resource['category'] ?? '') == 'Database' ? 'selected' : '' ?>>Database</option>
                                                            <option value="DevOps" <?= ($resource['category'] ?? '') == 'DevOps' ? 'selected' : '' ?>>DevOps</option>
                                                            <option value="Research Methods" <?= ($resource['category'] ?? '') == 'Research Methods' ? 'selected' : '' ?>>Research Methods</option>
                                                            <option value="Mathematics" <?= ($resource['category'] ?? '') == 'Mathematics' ? 'selected' : '' ?>>Mathematics</option>
                                                            <option value="Statistics" <?= ($resource['category'] ?? '') == 'Statistics' ? 'selected' : '' ?>>Statistics</option>
                                                            <option value="Other" <?= ($resource['category'] ?? '') == 'Other' ? 'selected' : '' ?>>Other</option>
                                                        </select>
                                                        <label>Category</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <select class="form-control" name="learning_resources[<?= $index ?>][type]" required>
                                                            <option value="">Select Type</option>
                                                            <option value="Tutorial" <?= ($resource['type'] ?? '') == 'Tutorial' ? 'selected' : '' ?>>Tutorial</option>
                                                            <option value="Documentation" <?= ($resource['type'] ?? '') == 'Documentation' ? 'selected' : '' ?>>Documentation</option>
                                                            <option value="Course" <?= ($resource['type'] ?? '') == 'Course' ? 'selected' : '' ?>>Online Course</option>
                                                            <option value="Video" <?= ($resource['type'] ?? '') == 'Video' ? 'selected' : '' ?>>Video</option>
                                                            <option value="Article" <?= ($resource['type'] ?? '') == 'Article' ? 'selected' : '' ?>>Article</option>
                                                            <option value="Book" <?= ($resource['type'] ?? '') == 'Book' ? 'selected' : '' ?>>Book</option>
                                                            <option value="Tool" <?= ($resource['type'] ?? '') == 'Tool' ? 'selected' : '' ?>>Tool/Software</option>
                                                            <option value="Repository" <?= ($resource['type'] ?? '') == 'Repository' ? 'selected' : '' ?>>Code Repository</option>
                                                            <option value="Dataset" <?= ($resource['type'] ?? '') == 'Dataset' ? 'selected' : '' ?>>Dataset</option>
                                                            <option value="Paper" <?= ($resource['type'] ?? '') == 'Paper' ? 'selected' : '' ?>>Research Paper</option>
                                                        </select>
                                                        <label>Resource Type</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" name="learning_resources[<?= $index ?>][description]" style="height: 80px;" placeholder="Description"><?= htmlspecialchars($resource['description'] ?? '') ?></textarea>
                                                        <label>Description (optional)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="section-buttons">
                                <button type="button" class="btn add-btn" onclick="addLearningResource()">
                                    <i class="bi bi-plus-circle"></i>Add Learning Resource
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                            <i class="bi bi-check-circle me-2"></i>Save Profile Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Variables to track the current index for dynamic fields
        let publicationIndex = <?= isset($student['university_research_profile']['university_publications']) && is_array($student['university_research_profile']['university_publications']) ? count($student['university_research_profile']['university_publications']) : 0 ?>;
        let learningResourceIndex = <?= isset($student['learning_resources']) && is_array($student['learning_resources']) ? count($student['learning_resources']) : 0 ?>;
        
        // Function to add a new publication field
        function addPublication() {
            const container = document.getElementById('publications-container');
            const newItem = document.createElement('div');
            newItem.className = 'dynamic-form-item';
            newItem.innerHTML = `
                <button type="button" class="remove-btn" onclick="removePublication(this)">
                    <i class="bi bi-x-circle"></i>
                </button>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="publications[${publicationIndex}][title]" placeholder="Title" required>
                            <label>Publication Title</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="publications[${publicationIndex}][authors]" placeholder="Authors" required>
                            <label>Authors (comma separated)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-control" name="publications[${publicationIndex}][type]" required>
                                <option value="">Select Type</option>
                                <option value="Journal Article">Journal Article</option>
                                <option value="Conference Paper">Conference Paper</option>
                                <option value="Book Chapter">Book Chapter</option>
                            </select>
                            <label>Publication Type</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="publications[${publicationIndex}][venue]" placeholder="Venue" required>
                            <label>Journal/Conference Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" class="form-control" name="publications[${publicationIndex}][date]">
                            <label>Publication Date</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-control" name="publications[${publicationIndex}][status]">
                                <option value="Published">Published</option>
                                <option value="Accepted">Accepted</option>
                                <option value="Under Review">Under Review</option>
                            </select>
                            <label>Status</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="url" class="form-control" name="publications[${publicationIndex}][doi]" placeholder="DOI">
                            <label>DOI URL (optional)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="url" class="form-control" name="publications[${publicationIndex}][paper_url]" placeholder="Paper URL">
                            <label>Paper URL (optional)</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" name="publications[${publicationIndex}][abstract]" style="height: 100px;" placeholder="Abstract"></textarea>
                            <label>Abstract (optional)</label>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            publicationIndex++;
        }
        
        // Function to remove a publication field
        function removePublication(button) {
            button.parentElement.remove();
        }
        
        // Function to add a new learning resource field
        function addLearningResource() {
            const container = document.getElementById('learning-resources-container');
            const newItem = document.createElement('div');
            newItem.className = 'dynamic-form-item';
            newItem.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeLearningResource(this)">
                    <i class="bi bi-x-circle"></i>
                </button>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="learning_resources[${learningResourceIndex}][title]" placeholder="Title" required>
                            <label>Resource Title</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="url" class="form-control" name="learning_resources[${learningResourceIndex}][url]" placeholder="URL" required>
                            <label>Resource URL</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-control" name="learning_resources[${learningResourceIndex}][category]" required>
                                <option value="">Select Category</option>
                                <option value="Programming">Programming</option>
                                <option value="Machine Learning">Machine Learning</option>
                                <option value="Data Science">Data Science</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Mobile Development">Mobile Development</option>
                                <option value="Cybersecurity">Cybersecurity</option>
                                <option value="Database">Database</option>
                                <option value="DevOps">DevOps</option>
                                <option value="Research Methods">Research Methods</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Statistics">Statistics</option>
                                <option value="Other">Other</option>
                            </select>
                            <label>Category</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-control" name="learning_resources[${learningResourceIndex}][type]" required>
                                <option value="">Select Type</option>
                                <option value="Tutorial">Tutorial</option>
                                <option value="Documentation">Documentation</option>
                                <option value="Course">Online Course</option>
                                <option value="Video">Video</option>
                                <option value="Article">Article</option>
                                <option value="Book">Book</option>
                                <option value="Tool">Tool/Software</option>
                                <option value="Repository">Code Repository</option>
                                <option value="Dataset">Dataset</option>
                                <option value="Paper">Research Paper</option>
                            </select>
                            <label>Resource Type</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" name="learning_resources[${learningResourceIndex}][description]" style="height: 80px;" placeholder="Description"></textarea>
                            <label>Description (optional)</label>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            learningResourceIndex++;
        }
        
        // Function to remove a learning resource field
        function removeLearningResource(button) {
            button.parentElement.remove();
        }

        // Initialize fade-in animations
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 