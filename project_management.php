<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Projects | UIU Research Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/home.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #7209b7;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
        }
        
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        /* Background particles */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            opacity: 0;
            pointer-events: none;
            background: radial-gradient(circle at 30% 40%, rgba(76, 201, 240, 0.05), transparent 30%),
                        radial-gradient(circle at 70% 70%, rgba(114, 9, 183, 0.05), transparent 35%),
                        radial-gradient(circle at 80% 10%, rgba(247, 37, 133, 0.05), transparent 25%);
            transition: opacity 1.5s ease-in-out;
        }
        
        body.loaded #particles-js {
            opacity: 0.7;
        }
        
        /* Ensure content appears above particles */
        .container,
        .header-container,
        footer {
            position: relative;
            z-index: 1;
        }
        
        /* Special accent particles */
        .floating-accent {
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.15) 0%, rgba(76, 201, 240, 0) 70%);
            border-radius: 50%;
            filter: blur(20px);
            opacity: 0.7;
            animation: float-accent 25s infinite linear;
            pointer-events: none;
            z-index: 0;
        }
        
        .floating-accent:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(114, 9, 183, 0.12) 0%, rgba(114, 9, 183, 0) 70%);
            animation-duration: 30s;
        }
        
        .floating-accent:nth-child(2) {
            top: 70%;
            left: 80%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(247, 37, 133, 0.12) 0%, rgba(247, 37, 133, 0) 70%);
            animation-duration: 25s;
            animation-delay: 5s;
        }
        
        .floating-accent:nth-child(3) {
            top: 40%;
            left: 60%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.12) 0%, rgba(67, 97, 238, 0) 70%);
            animation-duration: 28s;
            animation-delay: 2s;
        }
        
        @keyframes float-accent {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-50px, 50px) rotate(90deg); }
            50% { transform: translate(0, 100px) rotate(180deg); }
            75% { transform: translate(50px, 50px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }
        
        /* Burst effect for click animation */
        .particle-burst {
            position: absolute;
            pointer-events: none;
            border-radius: 50%;
            z-index: 2;
            transform: translate(-50%, -50%);
            animation: burst-anim 1s forwards ease-out;
        }
        
        @keyframes burst-anim {
            0% {
                width: 0;
                height: 0;
                opacity: 0.7;
                background: radial-gradient(circle, rgba(114, 9, 183, 0.8) 0%, rgba(114, 9, 183, 0) 70%);
            }
            100% {
                width: 300px;
                height: 300px;
                opacity: 0;
                background: radial-gradient(circle, rgba(114, 9, 183, 0) 0%, rgba(114, 9, 183, 0) 70%);
            }
        }
        
        .header-container {
            background: linear-gradient(125deg, #4361ee, #3a0ca3, #7209b7, #f72585);
            background-size: 300% 300%;
            animation: gradientBG 12s ease infinite;
            min-height: 30vh;
            display: flex;
            align-items: center;
            position: relative;
            border-radius: 0 0 30% 70% / 30%;
            margin-bottom: 50px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 50px 0;
            overflow: hidden;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .header-container h1 {
            color: white;
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
        }
        
        .header-container p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .card {
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: none;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: linear-gradient(to right, rgba(67, 97, 238, 0.1), rgba(114, 9, 183, 0.1));
            border-bottom: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
            border-color: var(--primary-color);
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.2);
        }
        
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            margin-right: 10px;
            font-weight: 600;
            color: var(--dark-color);
            transition: all 0.3s;
        }
        
        .nav-tabs .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .nav-tabs .nav-link.active {
            color: white;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }
        
        .project-card {
            border-radius: 16px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .project-card .card-img {
            height: 200px;
            position: relative;
            overflow: hidden;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .project-card img {
            transition: all 0.3s ease;
            height: 100%;
            object-fit: cover;
            width: 100%;
            max-height: 200px;
        }
        
        .project-card:hover img {
            transform: scale(1.05);
        }
        
        .project-card .card-body {
            padding: 20px;
        }
        
        .project-card .card-title {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--dark-color);
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .project-card:hover .card-title {
            color: var(--primary-color);
        }
        
        .project-card .card-text {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .badge-public {
            background: linear-gradient(135deg, #4cc9f0, #56cfe1);
            color: white;
        }
        
        .badge-private {
            background: linear-gradient(135deg, #f72585, #ff758f);
            color: white;
        }
        
        .badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .action-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            display: flex;
            gap: 5px;
        }
        
        .action-button {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .action-button.edit:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .action-button.delete:hover {
            background: var(--warning-color);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .empty-state i {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 20px;
            opacity: 0.7;
        }
        
        .empty-state h3 {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #6c757d;
            max-width: 80%;
            margin: 0 auto 20px auto;
        }
        
        /* Custom file input */
        .file-upload {
            position: relative;
            overflow: hidden;
            margin-top: 10px;
            width: 100%;
        }
        
        .file-upload input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            cursor: inherit;
            display: block;
        }
        
        .file-upload-btn {
            width: 100%;
            border: 2px dashed rgba(67, 97, 238, 0.3);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            background: rgba(67, 97, 238, 0.05);
            transition: all 0.3s;
        }
        
        .file-upload-btn:hover {
            background: rgba(67, 97, 238, 0.1);
            border-color: rgba(67, 97, 238, 0.5);
        }
        
        .file-upload-btn i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            margin-top: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .keyword-badge {
            display: inline-block;
            padding: 5px 10px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-radius: 20px;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .keyword-badge i {
            cursor: pointer;
            margin-left: 5px;
        }
        
        .keyword-badge i:hover {
            color: var(--warning-color);
        }
        
        /* Loading spinner */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .spinner-overlay.show {
            visibility: visible;
            opacity: 1;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spinner 1s linear infinite;
        }
        
        @keyframes spinner {
            to { transform: rotate(360deg); }
        }
        
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            background: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            transition: all 0.3s;
            opacity: 0;
            transform: translateY(-20px);
        }
        
        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .toast.success {
            border-left: 4px solid var(--success-color);
        }
        
        .toast.error {
            border-left: 4px solid var(--warning-color);
        }
        
        .toast-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .toast-title {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .toast-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #6c757d;
        }
        
        .toast-body {
            color: #6c757d;
        }
        
        /* Timeline styles */
        .timeline-item {
            background-color: #f8f9fa;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            cursor: grab;
        }
        
        .timeline-item.grabbing {
            cursor: grabbing;
        }
        
        .timeline-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .timeline-item.completed {
            border-left-color: var(--success-color);
        }
        
        .timeline-item.in-progress {
            border-left-color: var(--primary-color);
        }
        
        .timeline-item.planned {
            border-left-color: var(--secondary-color);
        }
        
        .timeline-item.delayed {
            border-left-color: var(--warning-color);
        }
        
        .timeline-date {
            color: var(--secondary-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        
        .timeline-date i {
            margin-right: 5px;
        }
        
        .timeline-controls {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
            margin-left: 10px;
        }
        
        .status-completed {
            background-color: rgba(76, 201, 240, 0.15);
            color: var(--success-color);
        }
        
        .status-in-progress {
            background-color: rgba(67, 97, 238, 0.15);
            color: var(--primary-color);
        }
        
        .status-planned {
            background-color: rgba(58, 12, 163, 0.15);
            color: var(--secondary-color);
        }
        
        .status-delayed {
            background-color: rgba(247, 37, 133, 0.15);
            color: var(--warning-color);
        }
        
        @media (max-width: 992px) {
            .header-container {
                min-height: 25vh;
                text-align: center;
            }
            
            .header-container h1 {
                font-size: 2.2rem;
            }
        }
        
        @media (max-width: 768px) {
            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 10px;
            }
            
            .nav-tabs .nav-link {
                white-space: nowrap;
                padding: 10px 20px;
            }
            
            .header-container {
                min-height: 20vh;
                border-radius: 0 0 20% 50% / 20%;
            }
            
            .header-container h1 {
                font-size: 1.8rem;
            }
            
            .header-container p {
                font-size: 1rem;
            }
        }
        
        /* References styling */
        .reference-item {
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .reference-item:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        #references-container {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .reference-item a {
            word-break: break-all;
            color: #0d6efd;
            text-decoration: none;
        }
        
        .reference-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    
    <!-- Background Particles -->
    <div id="particles-js"></div>
    
    <!-- Special accent elements -->
    <div class="floating-accent"></div>
    <div class="floating-accent"></div>
    <div class="floating-accent"></div>
    
    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="spinner">
        <div class="spinner"></div>
    </div>
    
    <!-- Toast Notifications -->
    <div class="toast-container" id="toastContainer"></div>
    
    <div class="header-container">
        <div class="container text-center">
            <h1 data-aos="fade-down" data-aos-duration="1000">Edit Research Projects</h1>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">Create, edit, and share your groundbreaking research with the academic community.</p>
        </div>
    </div>
    
    <div class="container my-5">
        <ul class="nav nav-tabs" id="projectManagementTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="edit-projects-tab" data-bs-toggle="tab" data-bs-target="#edit-projects" type="button" role="tab" aria-controls="edit-projects" aria-selected="true">
                    <i class="bi bi-collection me-2"></i>Edit Projects
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="new-project-tab" data-bs-toggle="tab" data-bs-target="#new-project" type="button" role="tab" aria-controls="new-project" aria-selected="false">
                    <i class="bi bi-plus-circle me-2"></i>Create New Project
                </button>
            </li>
        </ul>
        
        <div class="tab-content" id="projectManagementTabContent">
            <!-- Edit Projects Tab -->
            <div class="tab-pane fade show active" id="edit-projects" role="tabpanel" aria-labelledby="edit-projects-tab">
                <div id="userProjectsList" class="row g-4">
                    <!-- User projects will be loaded here -->
                </div>
            </div>
            
            <!-- Create New Project Tab -->
            <div class="tab-pane fade" id="new-project" role="tabpanel" aria-labelledby="new-project-tab">
                <!-- Project Creation Form -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="bi bi-file-earmark-plus me-2"></i>New Research Project
                            </div>
                            <div class="card-body">
                                <form id="projectForm" enctype="multipart/form-data">
                                    <input type="hidden" id="projectId" name="projectId" value="">
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Project Title*</label>
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="abstract" class="form-label">Abstract*</label>
                                                <textarea class="form-control" id="abstract" name="abstract" rows="3" required></textarea>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Full Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="coverImage" class="form-label">Cover Image</label>
                                                <div class="file-upload">
                                                    <div class="file-upload-btn" id="coverImageBtn">
                                                        <i class="bi bi-cloud-arrow-up"></i>
                                                        <p>Click or drag to upload an image</p>
                                                    </div>
                                                    <input type="file" class="form-control" id="coverImage" name="coverImage" accept="image/*">
                                                </div>
                                                <div id="imagePreviewContainer" class="mt-3 text-center" style="display: none;">
                                                    <img id="imagePreview" class="preview-image">
                                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeImage">
                                                        <i class="bi bi-trash me-1"></i>Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="field" class="form-label">Research Field*</label>
                                                <input type="text" class="form-control" id="field" name="field" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="institution" class="form-label">Institution</label>
                                                <input type="text" class="form-control" id="institution" name="institution" value="United International University">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="keywords" class="form-label">Keywords</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="keyword" placeholder="Add keyword">
                                                    <button class="btn btn-outline-primary" type="button" id="addKeyword">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                                <div id="keywordsContainer" class="mt-2">
                                                    <!-- Keywords will appear here -->
                                                </div>
                                                <input type="hidden" id="keywordsList" name="keywords">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="privacy" class="form-label">Privacy Setting</label>
                                                <select class="form-select" id="privacy" name="privacy">
                                                    <option value="0">Public - Visible to everyone</option>
                                                    <option value="1">Private - Visible only to you and collaborators</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="createdAt" class="form-label">Created At</label>
                                                <input type="date" class="form-control" id="createdAt" name="createdAt">
                                                <small class="text-muted">Leave empty for current date</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="updatedAt" class="form-label">Updated At</label>
                                                <input type="date" class="form-control" id="updatedAt" name="updatedAt">
                                                <small class="text-muted">Leave empty for current date</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="bi bi-link-45deg me-2"></i>External Links
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="github" class="form-label">GitHub Repository URL</label>
                                                                <input type="url" class="form-control" id="github" name="github" placeholder="https://github.com/yourusername/your-repo">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="website" class="form-label">Project Website URL</label>
                                                                <input type="url" class="form-control" id="website" name="website" placeholder="https://yourproject.example.com">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="paper" class="form-label">Research Paper URL</label>
                                                                <input type="url" class="form-control" id="paper" name="paper" placeholder="https://journal.example.com/your-paper">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="doi" class="form-label">DOI</label>
                                                                <input type="text" class="form-control" id="doi" name="doi" placeholder="10.xxxx/xxxxx">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="youtube" class="form-label">YouTube Video URL</label>
                                                                <input type="url" class="form-control" id="youtube" name="youtube" placeholder="https://youtube.com/watch?v=xxxx">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="bi bi-people-fill me-2"></i>Project Team
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="supervisor" class="form-label">Project Supervisor</label>
                                                        <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Supervisor Name">
                                                    </div>
                                                    
                                                    <label class="form-label">Team Members</label>
                                                    <div id="membersContainer">
                                                        <div class="row mb-2 member-row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control member-name" placeholder="Member Name" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control member-role" placeholder="Role (e.g., Author, Researcher)">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="number" class="form-control member-contribution" placeholder="Contribution %" min="0" max="100">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control member-userid" placeholder="User ID (optional)">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-outline-danger remove-member" disabled>
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-primary mt-2" id="addMember">
                                                        <i class="bi bi-plus-circle me-2"></i>Add Team Member
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Project Timeline Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="bi bi-calendar-event me-2"></i>Project Timeline
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-muted mb-3">Add key milestones and events to track your project's progress.</p>
                                                    
                                                    <div id="timelineContainer">
                                                        <!-- Timeline items will be added here -->
                                                    </div>
                                                    
                                                    <button type="button" class="btn btn-outline-primary mt-3" id="addTimelineItem">
                                                        <i class="bi bi-plus-circle me-2"></i>Add Timeline Item
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Files Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="bi bi-file-earmark me-2"></i>Project Files
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="projectFiles" class="form-label">Upload Files (Reports, Papers, Data, etc.)</label>
                                                        <input class="form-control" type="file" id="projectFiles" name="projectFiles[]" multiple>
                                                        <div id="filesPreview" class="mt-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Media Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="bi bi-camera-video me-2"></i>Additional Media
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="mediaFiles" class="form-label">Upload Images or Videos</label>
                                                        <input class="form-control" type="file" id="mediaFiles" name="mediaFiles[]" multiple accept="image/*,video/*">
                                                        <div id="mediaPreview" class="mt-2 row g-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- References Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="bi bi-journal-text me-2"></i>References
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <div id="references-container">
                                                            <!-- Reference items will be added here -->
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-5">
                                                                <input type="text" class="form-control" id="reference-title" placeholder="Reference Title">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" class="form-control" id="reference-link" placeholder="Reference Link">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-primary w-100" id="add-reference-btn">
                                                                    <i class="bi bi-plus-circle"></i> Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="references" name="references">
                                                        <div class="form-text">
                                                            Add each reference with a title and a link. Example: "Deep Learning for Renewable Energy Forecasting" with link "https://doi.org/10.1016/j.rser.2020.109898"
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Stats Section (Hidden from user but will generate random stats) -->
                                    <input type="hidden" id="viewsCount" name="viewsCount">
                                    <input type="hidden" id="downloadsCount" name="downloadsCount">
                                    <input type="hidden" id="favoritesCount" name="favoritesCount">
                                    
                                    <!-- Comments Section (Hidden, will be initialized as empty array) -->
                                    <input type="hidden" id="commentsArray" name="commentsArray" value="[]">
                                    
                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-secondary me-2" id="resetForm">
                                            <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-2"></i>Save Project
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-light" style="background: linear-gradient(135deg, #212529, #141b24); padding: 60px 0 40px; margin-top: 100px; position: relative;">
        <div class="container text-center">
            <div data-aos="fade-up">
                <h4 class="mb-4">UIU Research Portal</h4>
                <p class="mb-4 opacity-75">Connecting innovative minds and groundbreaking research</p>
                <p class="mt-5 pt-3">&copy; 2025 UIU Research Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize particles.js
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 1000
                    }
                },
                "color": {
                    "value": ["#4361ee", "#3a0ca3", "#7209b7", "#4cc9f0", "#f72585"]
                },
                "shape": {
                    "type": ["circle", "triangle", "polygon"],
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.3,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 0.8,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 12,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 2,
                        "size_min": 3,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 180,
                    "color": "#7209b7",
                    "opacity": 0.25,
                    "width": 1.5
                },
                "move": {
                    "enable": true,
                    "speed": 1.8,
                    "direction": "none",
                    "random": true,
                    "straight": false,
                    "out_mode": "bounce",
                    "bounce": true,
                    "attract": {
                        "enable": true,
                        "rotateX": 500,
                        "rotateY": 1000
                    }
                }
            },
            "interactivity": {
                "detect_on": "window",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "bubble"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 0.8
                        }
                    },
                    "bubble": {
                        "distance": 150,
                        "size": 16,
                        "duration": 1.5,
                        "opacity": 0.8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 150,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 6
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
        
        // Function to reinitialize particles if they stop
        function reinitializeParticlesIfNeeded() {
            if (window.pJSDom && window.pJSDom[0] && window.pJSDom[0].pJS) {
                const pJS = window.pJSDom[0].pJS;
                if (!pJS.particles.move.enable || pJS.particles.array.length === 0) {
                    console.log("Reinitializing particles...");
                    pJS.particles.move.enable = true;
                    
                    // First try to refresh existing particles
                    try {
                        pJS.fn.particlesRefresh();
                    } catch (error) {
                        console.error("Error refreshing particles:", error);
                        
                        // If refreshing fails, destroy and recreate
                        try {
                            window.pJSDom[0].pJS.fn.vendors.destroypJS();
                            window.pJSDom = [];
                            particlesJS('particles-js', /* same config as above */);
                        } catch (err) {
                            console.error("Failed to reinitialize particles:", err);
                        }
                    }
                }
            } else {
                // If pJSDom is missing, reinitialize
                particlesJS('particles-js', /* same config as above */);
            }
        }
        
        // Keep particles active
        setInterval(() => {
            reinitializeParticlesIfNeeded();
        }, 2000);
        
        // Add fade-in effect for particles
        setTimeout(() => {
            document.body.classList.add('loaded');
        }, 300);
        
        // Add scroll effect to particles for depth
        let lastScrollY = window.scrollY;
        window.addEventListener('scroll', function() {
            const canvas = document.querySelector('#particles-js canvas');
            if (canvas) {
                const scrollDifference = window.scrollY - lastScrollY;
                lastScrollY = window.scrollY;
                
                // Apply enhanced parallax effect to particles
                const particles = window.pJSDom[0].pJS.particles;
                particles.array.forEach(particle => {
                    particle.y -= scrollDifference * 0.05;
                    
                    // Add slight horizontal movement for more dynamic effect
                    if (Math.random() > 0.5) {
                        particle.x += Math.random() * 0.2 - 0.1;
                    }
                });
            }
        });
        
        // Add global click handler for adding particles but prevent it from stopping animation
        document.addEventListener('click', function(e) {
            // Don't create particles for clicks on interactive elements
            if (e.target.closest('a, button, input, .card, .form-control, .toggle-btn')) {
                return;
            }
            
            if (window.pJSDom && window.pJSDom[0] && window.pJSDom[0].pJS) {
                const pJS = window.pJSDom[0].pJS;
                
                // Create burst effect
                const burst = document.createElement('div');
                burst.classList.add('particle-burst');
                burst.style.left = e.pageX + 'px';
                burst.style.top = e.pageY + 'px';
                document.body.appendChild(burst);
                
                setTimeout(() => {
                    burst.remove();
                }, 1000);
                
                // Use a safer method: create a new particle directly through pJS API
                try {
                    for (let i = 0; i < 8; i++) {
                        const posX = e.clientX + ((Math.random() - 0.5) * 20);
                        const posY = e.clientY + ((Math.random() - 0.5) * 20);
                        
                        // Use the particle creation method from particles.js
                        pJS.fn.modes.pushParticles(1, {x: posX, y: posY});
                    }
                } catch (error) {
                    console.error("Error adding particles on click:", error);
                    // If there's an error, ensure animation is still running
                    setTimeout(reinitializeParticlesIfNeeded, 200);
                }
            }
            
            // Don't stop propagation - just make sure particles keep running
            setTimeout(reinitializeParticlesIfNeeded, 500);
        });
        
        // Handle window focus/blur events to ensure particles keep moving
        window.addEventListener('blur', function() {
            // When window loses focus, set a timer to keep checking
            window.particleCheckInterval = setInterval(reinitializeParticlesIfNeeded, 1000);
        });
        
        window.addEventListener('focus', function() {
            // When window regains focus, clear the intensive check interval
            if (window.particleCheckInterval) {
                clearInterval(window.particleCheckInterval);
            }
            
            // Do a single check and reinitialize if needed
            reinitializeParticlesIfNeeded();
        });
        
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: false,
            mirror: true
        });
        
        // Elements
        const projectForm = document.getElementById('projectForm');
        const projectIdInput = document.getElementById('projectId');
        const addKeywordBtn = document.getElementById('addKeyword');
        const keywordInput = document.getElementById('keyword');
        const keywordsContainer = document.getElementById('keywordsContainer');
        const keywordsListInput = document.getElementById('keywordsList');
        const addMemberBtn = document.getElementById('addMember');
        const membersContainer = document.getElementById('membersContainer');
        const addTimelineItemBtn = document.getElementById('addTimelineItem');
        const timelineContainer = document.getElementById('timelineContainer');
        const coverImageInput = document.getElementById('coverImage');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const removeImageBtn = document.getElementById('removeImage');
        const resetFormBtn = document.getElementById('resetForm');
        const spinnerOverlay = document.getElementById('spinner');
        const toastContainer = document.getElementById('toastContainer');
        const userProjectsList = document.getElementById('userProjectsList');
        const projectFilesInput = document.getElementById('projectFiles');
        const filesPreviewContainer = document.getElementById('filesPreview');
        const mediaFilesInput = document.getElementById('mediaFiles');
        const mediaPreviewContainer = document.getElementById('mediaPreview');
        const viewsCountInput = document.getElementById('viewsCount');
        const downloadsCountInput = document.getElementById('downloadsCount');
        const favoritesCountInput = document.getElementById('favoritesCount');
        
        // State
        let keywords = [];
        let isEditing = false;
        let originalImageUrl = '';
        let timelineItems = [];
        let isLoggedIn = false;
        let uploadedFiles = [];
        let uploadedMedia = [];
        
        // Initialize - Load user's projects
        loadUserProjects();
        
        // Form submission
        projectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateForm()) {
                return;
            }
            
            // Generate random stats
            generateRandomStats();
            
            // Get form data
            const formData = new FormData(projectForm);
            
            // Add members data
            const members = getMembersData();
            formData.append('members', JSON.stringify(members));
            
            // Add timeline data
            const timeline = getTimelineData();
            formData.append('timeline', JSON.stringify(timeline));
            
            // Add links data
            const links = {
                github: formData.get('github') || '',
                website: formData.get('website') || '',
                paper: formData.get('paper') || '',
                doi: formData.get('doi') || '',
                youtube: formData.get('youtube') || ''
            };
            formData.append('links', JSON.stringify(links));
            
            // Show loading spinner
            showSpinner();
            
            // Send form data to server
            const url = isEditing ? 'src/model/update_project.php' : 'src/model/create_project.php';
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideSpinner();
                
                if (data.success) {
                    // Show success toast
                    showToast('Success', isEditing ? 'Project updated successfully!' : 'Project created successfully!', 'success');
                    
                    // Reset form
                    resetForm();
                    
                    // Reload user's projects
                    loadUserProjects();
                    
                    // Switch to Edit Projects tab
                    document.getElementById('edit-projects-tab').click();
                } else {
                    // Show error toast
                    showToast('Error', data.message || 'An error occurred. Please try again.', 'error');
                }
            })
            .catch(error => {
                hideSpinner();
                console.error('Error:', error);
                showToast('Error', 'An error occurred. Please try again.', 'error');
            });
        });
        
        // Generate random stats for the project
        function generateRandomStats() {
            // Generate random numbers from 10 to 1000
            viewsCountInput.value = Math.floor(Math.random() * 990) + 10;
            downloadsCountInput.value = Math.floor(Math.random() * 990) + 10;
            favoritesCountInput.value = Math.floor(Math.random() * 990) + 10;
        }
        
        // Handle file input change for project files
        projectFilesInput.addEventListener('change', function(e) {
            handleFilesUpload(this.files, filesPreviewContainer, 'files');
        });
        
        // Handle file input change for media files
        mediaFilesInput.addEventListener('change', function(e) {
            handleFilesUpload(this.files, mediaPreviewContainer, 'media');
        });
        
        // Handle files upload preview
        function handleFilesUpload(files, previewContainer, type) {
            if (!files || files.length === 0) return;
            
            previewContainer.innerHTML = '';
            
            // Process each file
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Check file size (max 25MB)
                if (file.size > 25 * 1024 * 1024) {
                    showToast('Error', `File ${file.name} is too large. Maximum size is 25MB.`, 'error');
                    continue;
                }
                
                const filePreview = document.createElement('div');
                filePreview.className = type === 'media' ? 'col-md-3 mb-2' : 'mb-2';
                
                // Different preview for media vs documents
                if (type === 'media' && file.type.startsWith('image/')) {
                    // Image preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        filePreview.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <p class="card-text small text-truncate">${file.name}</p>
                                </div>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                    
                    if (type === 'media') {
                        uploadedMedia.push(file);
                    }
                } else if (type === 'media' && file.type.startsWith('video/')) {
                    // Video preview
                    filePreview.innerHTML = `
                        <div class="card">
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="bi bi-film fs-1 text-primary"></i>
                            </div>
                            <div class="card-body p-2">
                                <p class="card-text small text-truncate">${file.name}</p>
                            </div>
                        </div>
                    `;
                    
                    if (type === 'media') {
                        uploadedMedia.push(file);
                    }
                } else {
                    // Document preview
                    const fileIcon = getFileIcon(file.name);
                    filePreview.innerHTML = `
                        <div class="alert alert-light d-flex align-items-center">
                            <i class="${fileIcon} me-2 text-primary"></i>
                            <span class="text-truncate">${file.name}</span>
                            <span class="ms-auto badge bg-secondary">${formatFileSize(file.size)}</span>
                        </div>
                    `;
                    
                    if (type === 'files') {
                        uploadedFiles.push(file);
                    }
                }
                
                previewContainer.appendChild(filePreview);
            }
        }
        
        // Helper function to get icon based on file extension
        function getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            
            switch (ext) {
                case 'pdf':
                    return 'bi bi-file-earmark-pdf';
                case 'doc':
                case 'docx':
                    return 'bi bi-file-earmark-word';
                case 'xls':
                case 'xlsx':
                    return 'bi bi-file-earmark-excel';
                case 'ppt':
                case 'pptx':
                    return 'bi bi-file-earmark-slides';
                case 'zip':
                case 'rar':
                case '7z':
                    return 'bi bi-file-earmark-zip';
                case 'txt':
                    return 'bi bi-file-earmark-text';
                case 'csv':
                    return 'bi bi-file-earmark-spreadsheet';
                default:
                    return 'bi bi-file-earmark';
            }
        }
        
        // Helper function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Handle file input change
        coverImageInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showToast('Error', 'Image size should be less than 5MB', 'error');
                    this.value = '';
                    return;
                }
                
                // Check file type
                const fileType = file.type;
                if (!fileType.match('image.*')) {
                    showToast('Error', 'Please select an image file', 'error');
                    this.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Remove image button
        removeImageBtn.addEventListener('click', function() {
            coverImageInput.value = '';
            imagePreviewContainer.style.display = 'none';
            imagePreview.src = '';
        });
        
        // Add keyword
        addKeywordBtn.addEventListener('click', function() {
            addKeyword();
        });
        
        keywordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addKeyword();
            }
        });
        
        // Add member
        addMemberBtn.addEventListener('click', function() {
            addMemberRow();
        });
        
        // Add timeline item
        addTimelineItemBtn.addEventListener('click', function() {
            addTimelineItem();
        });
        
        // Reset form
        resetFormBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
                resetForm();
            }
        });
        
        // Functions
        function validateForm() {
            // Validate required fields
            const requiredFields = ['title', 'abstract', 'field'];
            let valid = true;
            
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            // Validate at least one member
            const memberRows = document.querySelectorAll('.member-row');
            if (memberRows.length === 0) {
                showToast('Error', 'Please add at least one team member', 'error');
                valid = false;
            }
            
            // Validate member names
            let memberNamesValid = true;
            document.querySelectorAll('.member-name').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    memberNamesValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (!memberNamesValid) {
                showToast('Error', 'All team members must have a name', 'error');
                valid = false;
            }
            
            return valid;
        }
        
        function addKeyword() {
            const keyword = keywordInput.value.trim();
            if (keyword) {
                if (!keywords.includes(keyword)) {
                    keywords.push(keyword);
                    updateKeywordsDisplay();
                }
                keywordInput.value = '';
            }
        }
        
        function updateKeywordsDisplay() {
            keywordsContainer.innerHTML = '';
            keywordsListInput.value = JSON.stringify(keywords);
            
            keywords.forEach((keyword, index) => {
                const badge = document.createElement('span');
                badge.className = 'keyword-badge';
                badge.innerHTML = `${keyword} <i class="bi bi-x-circle" data-index="${index}"></i>`;
                keywordsContainer.appendChild(badge);
                
                // Add click event to remove keyword
                badge.querySelector('i').addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    keywords.splice(index, 1);
                    updateKeywordsDisplay();
                });
            });
        }
        
        function addMemberRow() {
            const row = document.createElement('div');
            row.className = 'row mb-2 member-row';
            row.innerHTML = `
                <div class="col-md-3">
                    <input type="text" class="form-control member-name" placeholder="Member Name" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control member-role" placeholder="Role (e.g., Author, Researcher)">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control member-contribution" placeholder="Contribution %" min="0" max="100">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control member-userid" placeholder="User ID (optional)">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger remove-member">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            
            membersContainer.appendChild(row);
            
            // Add event listener to remove button
            row.querySelector('.remove-member').addEventListener('click', function() {
                row.remove();
            });
        }
        
        function getMembersData() {
            const members = [];
            const memberRows = document.querySelectorAll('.member-row');
            
            memberRows.forEach(row => {
                const name = row.querySelector('.member-name').value.trim();
                const role = row.querySelector('.member-role').value.trim();
                const contribution = parseInt(row.querySelector('.member-contribution').value) || 0;
                const userId = row.querySelector('.member-userid').value.trim();
                
                if (name) {
                    const member = {
                        name: name,
                        role: role || 'Author',
                        contribution: contribution
                    };
                    
                    if (userId) {
                        member.userId = { '$oid': userId };
                    }
                    
                    members.push(member);
                }
            });
            
            return members;
        }
        
        function resetForm() {
            projectForm.reset();
            projectIdInput.value = '';
            keywords = [];
            updateKeywordsDisplay();
            
            // Reset members
            membersContainer.innerHTML = '';
            addMemberRow();
            
            // Reset timeline
            timelineContainer.innerHTML = '';
            timelineItems = [];
            
            // Reset image preview
            imagePreviewContainer.style.display = 'none';
            imagePreview.src = '';
            
            // Reset files and media previews
            filesPreviewContainer.innerHTML = '';
            mediaPreviewContainer.innerHTML = '';
            uploadedFiles = [];
            uploadedMedia = [];
            
            // Reset editing state
            isEditing = false;
            
            // Reset any validation styling
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
        }
        
        function showSpinner() {
            spinnerOverlay.classList.add('show');
        }
        
        function hideSpinner() {
            spinnerOverlay.classList.remove('show');
        }
        
        function showToast(title, message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <div class="toast-header">
                    <span class="toast-title">${title}</span>
                    <button type="button" class="toast-close">&times;</button>
                </div>
                <div class="toast-body">${message}</div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Show toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Hide toast after 5 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
            
            // Close button
            toast.querySelector('.toast-close').addEventListener('click', function() {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            });
        }
        
        // Project Management Functions
        function loadUserProjects() {
            showSpinner();
            
            fetch('src/model/get_user_projects.php')
                .then(response => response.json())
                .then(data => {
                    hideSpinner();
                    
                    if (data.success) {
                        // Update login status
                        isLoggedIn = data.isLoggedIn;
                        
                        // Display projects, either user's projects or public ones
                        if (data.projects && data.projects.length > 0) {
                            displayUserProjects(data.projects, !isLoggedIn);
                        } else {
                            const message = isLoggedIn ? 
                                'You haven\'t created any research projects yet. Click "Create New Project" to get started.' : 
                                'No public projects found. Create a new project to get started.';
                            displayEmptyState('No projects found', message);
                        }
                    } else {
                        // Show empty state or error
                        displayEmptyState('No projects found', 'You haven\'t created any research projects yet. Click "Create New Project" to get started.');
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Error:', error);
                    displayEmptyState('Error loading projects', 'An error occurred while loading projects. Please try again later.');
                });
        }
        
        function displayUserProjects(projects, isPublicView = false) {
            if (!projects || projects.length === 0) {
                const message = isPublicView ? 
                    'No public projects found.' : 
                    'You haven\'t created any research projects yet. Click "Create New Project" to get started.';
                    
                displayEmptyState('No projects found', message);
                return;
            }
            
            userProjectsList.innerHTML = '';
            
            projects.forEach(project => {
                const col = document.createElement('div');
                col.className = 'col-lg-4 col-md-6';
                col.setAttribute('data-aos', 'fade-up');
                
                // Determine badge class based on privacy
                const badgeClass = project.privacy === 0 ? 'badge-public' : 'badge-private';
                const badgeText = project.privacy === 0 ? 'Public' : 'Private';
                
                // Format the date with robust handling
                let formattedDate = 'Date not available';
                try {
                    let dateValue;
                    const dateInput = project.createdAt;
                    
                    // Handle different date formats
                    if (typeof dateInput === 'object') {
                        // MongoDB date object with $date property
                        if (dateInput.$date) {
                            if (typeof dateInput.$date === 'string') {
                                dateValue = dateInput.$date;
                            } else if (typeof dateInput.$date === 'object' && dateInput.$date.$numberLong) {
                                // Handle MongoDB long format
                                dateValue = parseInt(dateInput.$date.$numberLong);
                            } else {
                                dateValue = dateInput.$date;
                            }
                        } else {
                            dateValue = dateInput;
                        }
                    } else if (typeof dateInput === 'string') {
                        // Direct string date
                        dateValue = dateInput;
                    } else if (typeof dateInput === 'number') {
                        // Timestamp
                        dateValue = dateInput;
                    }
                    
                    // Create date object and format
                    const date = new Date(dateValue);
                    if (!isNaN(date.getTime())) {
                        formattedDate = date.toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        });
                    }
                } catch (error) {
                    console.error('Error formatting date:', error, 'Input:', project.createdAt);
                }
                
                // Get image path
                let imageSrc = getRandomResearchImage();
                if (project.coverImage && project.coverImage.url) {
                    imageSrc = project.coverImage.url;
                }
                
                // Determine if action buttons should be shown (only for logged-in users and their projects)
                const showActionButtons = isLoggedIn && !isPublicView;
                
                col.innerHTML = `
                    <div class="project-card position-relative">
                        ${showActionButtons ? `
                        <div class="action-buttons">
                            <div class="action-button edit" data-id="${project._id.$oid}" data-bs-toggle="tooltip" title="Edit Project">
                                <i class="bi bi-pencil-fill"></i>
                            </div>
                            <div class="action-button delete" data-id="${project._id.$oid}" data-bs-toggle="tooltip" title="Delete Project">
                                <i class="bi bi-trash-fill"></i>
                            </div>
                        </div>
                        ` : ''}
                        <div class="card-img">
                            <img src="${imageSrc}" alt="${project.title}" class="img-fluid" onerror="this.onerror=null; this.src='${getRandomResearchImage()}';">
                        </div>
                        <div class="card-body">
                            <span class="badge ${badgeClass}">${badgeText}</span>
                            <h5 class="card-title">${project.title}</h5>
                            <p class="card-text">${project.abstract ? (project.abstract.length > 100 ? project.abstract.substring(0, 100) + '...' : project.abstract) : 'No abstract available'}</p>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                <small>${formattedDate}</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-mortarboard-fill me-2 text-primary"></i>
                                <small>${project.field || 'Research'}</small>
                            </div>
                            <div class="mt-3">
                                <a href="edit_project.php?id=${project._id.$oid}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-fill me-1"></i>Edit
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                
                userProjectsList.appendChild(col);
                
                // Add event listeners for edit and delete buttons if shown
                if (showActionButtons) {
                    col.querySelector('.edit').addEventListener('click', function() {
                        const projectId = this.getAttribute('data-id');
                        editProject(projectId);
                    });
                    
                    col.querySelector('.delete').addEventListener('click', function() {
                        const projectId = this.getAttribute('data-id');
                        deleteProject(projectId, project.title);
                    });
                }
            });
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        function displayEmptyState(title, message) {
            userProjectsList.innerHTML = `
                <div class="col-12">
                    <div class="empty-state" data-aos="fade-up">
                        <i class="bi bi-journal-text"></i>
                        <h3>${title}</h3>
                        <p>${message}</p>
                        <button class="btn btn-primary" id="createProjectBtn">
                            <i class="bi bi-plus-circle me-2"></i>Create New Project
                        </button>
                    </div>
                </div>
            `;
            
            // Add event listener to the create project button
            document.getElementById('createProjectBtn').addEventListener('click', function() {
                document.getElementById('new-project-tab').click();
            });
        }
        
        function editProject(projectId) {
            showSpinner();
            
            fetch(`src/model/get_project.php?id=${projectId}`)
                .then(response => response.json())
                .then(data => {
                    hideSpinner();
                    
                    if (data.success && data.project) {
                        fillProjectForm(data.project);
                        document.getElementById('new-project-tab').click();
                    } else {
                        showToast('Error', data.message || 'Failed to load project details', 'error');
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Error:', error);
                    showToast('Error', 'An error occurred while loading project details', 'error');
                });
        }
        
        function fillProjectForm(project) {
            // Set editing state
            isEditing = true;
            projectIdInput.value = project._id.$oid;
            
            // Fill basic info
            document.getElementById('title').value = project.title || '';
            document.getElementById('abstract').value = project.abstract || '';
            document.getElementById('description').value = project.description || '';
            document.getElementById('field').value = project.field || '';
            document.getElementById('institution').value = project.institution || 'United International University';
            document.getElementById('privacy').value = project.privacy !== undefined ? project.privacy.toString() : '0';
            
            // Fill dates if they exist
            if (project.createdAt && project.createdAt.$date) {
                const createdDate = new Date(project.createdAt.$date);
                document.getElementById('createdAt').value = createdDate.toISOString().split('T')[0];
            }
            
            if (project.updatedAt && project.updatedAt.$date) {
                const updatedDate = new Date(project.updatedAt.$date);
                document.getElementById('updatedAt').value = updatedDate.toISOString().split('T')[0];
            }
            
            // Fill supervisor
            if (project.supervisor) {
                if (typeof project.supervisor === 'string') {
                    document.getElementById('supervisor').value = project.supervisor;
                } else if (typeof project.supervisor === 'object') {
                    // In the structured format, supervisor has name, role, and userId
                    if (project.supervisor.name) {
                        document.getElementById('supervisor').value = project.supervisor.name;
                    } else if (project.supervisor.userId && project.supervisor.userId.$oid) {
                        document.getElementById('supervisor').value = project.supervisor.userId.$oid;
                    }
                }
            }
            
            // Fill links
            if (project.links) {
                document.getElementById('github').value = project.links.github || '';
                document.getElementById('website').value = project.links.website || '';
                document.getElementById('paper').value = project.links.paper || '';
                document.getElementById('doi').value = project.links.doi || '';
                document.getElementById('youtube').value = project.links.youtube || '';
            }
            
            // Fill references
            if (project.references && Array.isArray(project.references)) {
                // Use the new function to fill references
                fillReferencesFromExisting(project.references);
            }
            
            // Fill keywords
            keywords = project.keywords || [];
            updateKeywordsDisplay();
            
            // Fill members
            membersContainer.innerHTML = '';
            if (project.members && project.members.length > 0) {
                project.members.forEach(member => {
                    const row = document.createElement('div');
                    row.className = 'row mb-2 member-row';
                    row.innerHTML = `
                        <div class="col-md-3">
                            <input type="text" class="form-control member-name" placeholder="Member Name" required value="${member.name || ''}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control member-role" placeholder="Role (e.g., Author, Researcher)" value="${member.role || ''}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control member-contribution" placeholder="Contribution %" min="0" max="100" value="${member.contribution || 0}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control member-userid" placeholder="User ID (optional)" value="${member.userId && member.userId.$oid ? member.userId.$oid : ''}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger remove-member">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                    
                    membersContainer.appendChild(row);
                    
                    // Add event listener to remove button
                    row.querySelector('.remove-member').addEventListener('click', function() {
                        row.remove();
                    });
                });
            } else {
                // Add at least one empty row
                addMemberRow();
            }
            
            // Fill timeline items
            timelineContainer.innerHTML = '';
            timelineItems = [];
            
            if (project.timeline && project.timeline.length > 0) {
                timelineItems = [...project.timeline];
                updateTimelineDisplay();
            }
            
            // Handle image preview
            if (project.coverImage && project.coverImage.url) {
                imagePreview.src = project.coverImage.url;
                imagePreviewContainer.style.display = 'block';
                originalImageUrl = project.coverImage.url;
            } else {
                imagePreviewContainer.style.display = 'none';
                originalImageUrl = '';
            }
            
            // Display files if they exist
            if (project.files && project.files.length > 0) {
                filesPreviewContainer.innerHTML = '';
                project.files.forEach(file => {
                    const filePreview = document.createElement('div');
                    filePreview.className = 'mb-2';
                    
                    // Extract the file name from either name or path
                    const fileName = file.name || (file.path ? file.path.split('/').pop() : '') || (file.url ? file.url.split('/').pop() : '');
                    const fileIcon = getFileIcon(fileName);
                    const fileSize = file.size ? formatFileSize(file.size) : '';
                    
                    filePreview.innerHTML = `
                        <div class="alert alert-light d-flex align-items-center">
                            <i class="${fileIcon} me-2 text-primary"></i>
                            <span class="text-truncate">${fileName}</span>
                            <span class="ms-auto badge bg-secondary">${fileSize}</span>
                        </div>
                    `;
                    
                    filesPreviewContainer.appendChild(filePreview);
                });
            }
            
            // Display media if they exist
            if (project.media && project.media.length > 0) {
                mediaPreviewContainer.innerHTML = '';
                project.media.forEach(media => {
                    const mediaPreview = document.createElement('div');
                    mediaPreview.className = 'col-md-3 mb-2';
                    
                    // Get the caption or extract from URL
                    const caption = media.caption || media.url.split('/').pop();
                    
                    if (media.type === 'image') {
                        mediaPreview.innerHTML = `
                            <div class="card">
                                <img src="${media.url}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <p class="card-text small text-truncate">${caption}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        mediaPreview.innerHTML = `
                            <div class="card">
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="bi bi-film fs-1 text-primary"></i>
                                </div>
                                <div class="card-body p-2">
                                    <p class="card-text small text-truncate">${caption}</p>
                                </div>
                            </div>
                        `;
                    }
                    
                    mediaPreviewContainer.appendChild(mediaPreview);
                });
            }
            
            // Fill stats (hidden fields)
            if (project.stats) {
                viewsCountInput.value = project.stats.views || '';
                downloadsCountInput.value = project.stats.downloads || '';
                favoritesCountInput.value = project.stats.favorites || '';
            }
        }
        
        function deleteProject(projectId, projectTitle) {
            if (confirm(`Are you sure you want to delete "${projectTitle}"? This action cannot be undone.`)) {
                showSpinner();
                
                fetch('src/model/delete_project.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ projectId: projectId })
                })
                .then(response => response.json())
                .then(data => {
                    hideSpinner();
                    
                    if (data.success) {
                        showToast('Success', 'Project deleted successfully', 'success');
                        loadUserProjects();
                    } else {
                        showToast('Error', data.message || 'Failed to delete project', 'error');
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Error:', error);
                    showToast('Error', 'An error occurred while deleting the project', 'error');
                });
            }
        }
        
        // Utility function to get a random research image
        function getRandomResearchImage() {
            const researchImages = [
                'assets/resources/research_picture/pub_1.jpg',
                'assets/resources/research_picture/pub_2.jpg',
                'assets/resources/research_picture/pub_3.jpg',
                'assets/resources/research_picture/pub_4.jpg',
                'assets/resources/research_picture/pub_5.jpg',
                'assets/resources/research_picture/pub_6.jpg',
                'assets/resources/research_picture/pub_7.jpg',
                'assets/resources/research_picture/pub_8.jpeg',
                'assets/resources/research_picture/pub_9.jpeg',
                'assets/resources/research_picture/pub_10.jpeg'
            ];
            
            return researchImages[Math.floor(Math.random() * researchImages.length)];
        }
        
        // Timeline management functions
        function addTimelineItem(item = null) {
            const now = new Date();
            const formattedDate = now.toISOString().split('T')[0]; // YYYY-MM-DD format
            
            const newItem = item || {
                title: '',
                description: '',
                date: formattedDate,
                status: 'Planned'
            };
            
            // Add to the array
            if (!item) {
                timelineItems.push(newItem);
            }
            
            // Create the DOM element
            updateTimelineDisplay();
        }
        
        function updateTimelineDisplay() {
            timelineContainer.innerHTML = '';
            
            if (timelineItems.length === 0) {
                timelineContainer.innerHTML = '<p class="text-muted text-center py-3">No timeline items added yet.</p>';
                return;
            }
            
            // Sort timeline items by date
            timelineItems.sort((a, b) => new Date(a.date) - new Date(b.date));
            
            timelineItems.forEach((item, index) => {
                const statusClasses = {
                    'Completed': 'completed status-completed',
                    'In Progress': 'in-progress status-in-progress',
                    'Planned': 'planned status-planned',
                    'Delayed': 'delayed status-delayed'
                };
                
                const statusClass = statusClasses[item.status] || 'planned status-planned';
                
                const timelineItem = document.createElement('div');
                timelineItem.className = `timeline-item ${item.status.toLowerCase().replace(' ', '-')}`;
                timelineItem.dataset.index = index;
                
                // Format date for display
                const displayDate = new Date(item.date);
                const formattedDisplayDate = displayDate.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                timelineItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="timeline-date">
                            <i class="bi bi-calendar3"></i>
                            ${formattedDisplayDate}
                            <span class="status-badge ${statusClass}">${item.status}</span>
                        </div>
                        <div class="timeline-controls">
                            <button type="button" class="btn btn-sm btn-outline-primary edit-timeline" data-index="${index}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger delete-timeline" data-index="${index}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                    <h6 class="mb-2">${item.title}</h6>
                    <p class="mb-0 small text-muted">${item.description}</p>
                `;
                
                timelineContainer.appendChild(timelineItem);
                
                // Add event listeners
                const editBtn = timelineItem.querySelector('.edit-timeline');
                const deleteBtn = timelineItem.querySelector('.delete-timeline');
                
                editBtn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    editTimelineItem(index);
                });
                
                deleteBtn.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    deleteTimelineItem(index);
                });
            });
        }
        
        function editTimelineItem(index) {
            const item = timelineItems[index];
            
            // Create a modal dialog for editing
            const modalId = 'timelineEditModal';
            let modal = document.getElementById(modalId);
            
            // If modal doesn't exist, create it
            if (!modal) {
                modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = modalId;
                modal.tabIndex = -1;
                modal.setAttribute('aria-labelledby', `${modalId}Label`);
                modal.setAttribute('aria-hidden', 'true');
                
                modal.innerHTML = `
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="${modalId}Label">Edit Timeline Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="timelineEditForm">
                                    <div class="mb-3">
                                        <label for="timelineTitle" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="timelineTitle" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="timelineDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="timelineDescription" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="timelineDate" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="timelineDate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="timelineStatus" class="form-label">Status</label>
                                        <select class="form-select" id="timelineStatus">
                                            <option value="Planned">Planned</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Delayed">Delayed</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveTimelineChanges">Save Changes</button>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
            }
            
            // Set form values
            document.getElementById('timelineTitle').value = item.title;
            document.getElementById('timelineDescription').value = item.description;
            document.getElementById('timelineDate').value = item.date;
            document.getElementById('timelineStatus').value = item.status;
            
            // Initialize and show the modal
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
            
            // Handle form submission
            const saveBtn = document.getElementById('saveTimelineChanges');
            
            // Remove any existing event listeners
            const newSaveBtn = saveBtn.cloneNode(true);
            saveBtn.parentNode.replaceChild(newSaveBtn, saveBtn);
            
            newSaveBtn.addEventListener('click', function() {
                const title = document.getElementById('timelineTitle').value.trim();
                const description = document.getElementById('timelineDescription').value.trim();
                const date = document.getElementById('timelineDate').value;
                const status = document.getElementById('timelineStatus').value;
                
                if (!title || !date) {
                    // Show validation error
                    if (!title) document.getElementById('timelineTitle').classList.add('is-invalid');
                    if (!date) document.getElementById('timelineDate').classList.add('is-invalid');
                    return;
                }
                
                // Update timelineItems array
                timelineItems[index] = {
                    title,
                    description,
                    date,
                    status
                };
                
                // Update the UI
                updateTimelineDisplay();
                
                // Close the modal
                modalInstance.hide();
            });
        }
        
        function deleteTimelineItem(index) {
            if (confirm('Are you sure you want to delete this timeline item?')) {
                timelineItems.splice(index, 1);
                updateTimelineDisplay();
            }
        }
        
        function getTimelineData() {
            return timelineItems;
        }
        
        // Initialize references array
        let referencesList = [];
        
        // Handle adding references
        const addReferenceBtn = document.getElementById('add-reference-btn');
        const referenceTitleInput = document.getElementById('reference-title');
        const referenceLinkInput = document.getElementById('reference-link');
        const referencesContainer = document.getElementById('references-container');
        const referencesInput = document.getElementById('references');
        
        addReferenceBtn.addEventListener('click', function() {
            const title = referenceTitleInput.value.trim();
            const link = referenceLinkInput.value.trim();
            
            if (title && link) {
                // Add to references array
                referencesList.push({ title, link });
                
                // Update hidden input
                updateReferencesInput();
                
                // Add to UI
                addReferenceToUI(title, link, referencesList.length - 1);
                
                // Clear inputs
                referenceTitleInput.value = '';
                referenceLinkInput.value = '';
                referenceTitleInput.focus();
            } else {
                alert('Please enter both a title and a link for the reference');
            }
        });
        
        // Function to add reference to UI
        function addReferenceToUI(title, link, index) {
            const referenceItem = document.createElement('div');
            referenceItem.className = 'reference-item mb-2 p-2 border rounded';
            referenceItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${title}</strong>
                        <div><a href="${link}" target="_blank" class="small">${link}</a></div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-reference" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            
            referencesContainer.appendChild(referenceItem);
            
            // Add event listener to remove button
            referenceItem.querySelector('.remove-reference').addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                removeReference(index);
            });
        }
        
        // Function to remove reference
        function removeReference(index) {
            referencesList.splice(index, 1);
            updateReferencesInput();
            
            // Rebuild UI
            referencesContainer.innerHTML = '';
            referencesList.forEach((ref, idx) => {
                addReferenceToUI(ref.title, ref.link, idx);
            });
        }
        
        // Function to update hidden input
        function updateReferencesInput() {
            // Convert references to the format expected by the server
            const referencesText = referencesList.map(ref => `${ref.title} | ${ref.link}`).join('\n');
            referencesInput.value = referencesText;
        }
        
        // Fill references when editing a project
        function fillReferencesFromExisting(references) {
            if (!references || !Array.isArray(references)) return;
            
            referencesList = [];
            referencesContainer.innerHTML = '';
            
            references.forEach((ref, index) => {
                // Handle both new and old format
                if (ref.title && ref.link) {
                    referencesList.push({ title: ref.title, link: ref.link });
                    addReferenceToUI(ref.title, ref.link, index);
                } else if (ref.cite) {
                    // Handle old format (try to extract title and link)
                    const parts = ref.cite.split('|').map(part => part.trim());
                    if (parts.length === 2) {
                        referencesList.push({ title: parts[0], link: parts[1] });
                        addReferenceToUI(parts[0], parts[1], index);
                    } else {
                        referencesList.push({ title: ref.cite, link: ref.cite });
                        addReferenceToUI(ref.cite, ref.cite, index);
                    }
                }
            });
            
            updateReferencesInput();
        }
        
        // Expose the function globally so it can be called when loading project data
        window.fillReferencesFromExisting = fillReferencesFromExisting;
    });
    </script>
</body>
</html> 
