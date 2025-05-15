<?php
// Comment out session start to allow anyone to edit
// session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project | UIU Research Portal</title>
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
            min-height: 20vh;
            display: flex;
            align-items: center;
            position: relative;
            border-radius: 0 0 30% 70% / 30%;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            padding: 30px 0;
            overflow: hidden;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .header-container h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
        }
        
        .header-container p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
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
        
        /* References styling */
        #references-container {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 10px;
            margin-top: 15px;
            background: var(--light-color);
        }
        
        .reference-item {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            border-left: 3px solid var(--primary-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }
        
        .reference-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .reference-item .reference-content {
            flex-grow: 1;
        }
        
        .reference-item .reference-title {
            font-weight: 500;
            margin-bottom: 4px;
            color: var(--dark-color);
        }
        
        .reference-item .reference-link {
            font-size: 0.85rem;
            color: var(--primary-color);
            word-break: break-all;
        }
        
        .reference-item .remove-reference {
            color: #dc3545;
            cursor: pointer;
            margin-left: 10px;
            padding: 4px;
            border-radius: 50%;
            transition: all 0.2s;
        }
        
        .reference-item .remove-reference:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }
        
        @media (max-width: 992px) {
            .header-container {
                min-height: 20vh;
                text-align: center;
            }
            
            .header-container h1 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                min-height: 15vh;
                border-radius: 0 0 20% 50% / 20%;
            }
            
            .header-container h1 {
                font-size: 1.8rem;
            }
            
            .header-container p {
                font-size: 0.9rem;
            }
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
            <h1 data-aos="fade-down" data-aos-duration="1000">Edit Project</h1>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">Update your research project details</p>
        </div>
    </div>
    
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-pencil-square me-2"></i>Edit Project Details
                    </div>
                    <div class="card-body">
                        <div id="projectLoadingState">
                            <div class="text-center p-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3">Loading project details...</p>
                            </div>
                        </div>
                        
                        <div id="projectNotFound" style="display: none;">
                            <div class="text-center p-5">
                                <i class="bi bi-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                                <h4 class="mt-3">Project Not Found</h4>
                                <p class="text-muted">The project you're looking for doesn't exist or you don't have permission to edit it.</p>
                                <a href="project_management.php" class="btn btn-primary mt-3">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Projects
                                </a>
                            </div>
                        </div>

                        <form id="editProjectForm" enctype="multipart/form-data" style="display: none;">
                            <!-- Form fields will be added here through JavaScript -->
                        </form>
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
        // Debug mode for troubleshooting
        const DEBUG = true;
        
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
            once: true
        });
        
        // Elements
        const editProjectForm = document.getElementById('editProjectForm');
        const projectLoadingState = document.getElementById('projectLoadingState');
        const projectNotFound = document.getElementById('projectNotFound');
        const spinnerOverlay = document.getElementById('spinner');
        const toastContainer = document.getElementById('toastContainer');
        
        // Helper function to safely format dates from MongoDB format
        function formatMongoDate(mongoDate) {
            try {
                if (!mongoDate) return '';
                
                // Handle different MongoDB date formats
                let date;
                
                // Case 1: Object with $date property (MongoDB BSON Date)
                if (mongoDate.$date) {
                    // Handle ISO string or millisecond timestamp
                    if (typeof mongoDate.$date === 'string') {
                        date = new Date(mongoDate.$date);
                    } else if (typeof mongoDate.$date === 'number') {
                        date = new Date(mongoDate.$date);
                    } else {
                        return '';
                    }
                } 
                // Case 2: Direct ISO string (like "2023-09-15T08:30:00.000Z")
                else if (typeof mongoDate === 'string' && mongoDate.includes('T')) {
                    date = new Date(mongoDate);
                }
                // Case 3: Regular date object
                else if (mongoDate instanceof Date) {
                    date = mongoDate;
                }
                // Case 4: Try to parse as string
                else {
                    date = new Date(mongoDate);
                }
                
                // Check if date is valid
                if (isNaN(date.getTime())) {
                    console.warn('Invalid date:', mongoDate);
                    return '';
                }
                
                // Return in YYYY-MM-DD format
                return date.toISOString().split('T')[0];
            } catch (error) {
                console.error('Error formatting date:', error, mongoDate);
                return '';
            }
        }
        
        // Get project ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const projectId = urlParams.get('id');
        
        // If no project ID is provided, show error
        if (!projectId) {
            projectLoadingState.style.display = 'none';
            projectNotFound.style.display = 'block';
            return;
        }
        
        // Fetch project details
        loadProjectDetails(projectId);
        
        // Functions
        function loadProjectDetails(id) {
            showSpinner();
            
            if (DEBUG) console.log('Loading project with ID:', id);
            
            // First try to load from MongoDB
            fetch(`src/model/get_project.php?id=${id}`)
                .then(response => {
                    if (DEBUG) console.log('Database server response:', response);
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.project) {
                        // Project found in database, use it
                        if (DEBUG) console.log('Project found in database:', data.project);
                        hideSpinner();
                        buildEditForm(data.project);
                        projectLoadingState.style.display = 'none';
                        editProjectForm.style.display = 'block';
                    } else {
                        // Project not found in database, try JSON file as fallback
                        if (DEBUG) console.log('Project not found in database, trying JSON file...');
                        return fetch(`src/model/get_project_from_json.php?id=${id}`)
                            .then(response => {
                                if (DEBUG) console.log('JSON file server response:', response);
                                return response.json();
                            })
                            .then(jsonData => {
                                hideSpinner();
                                
                                if (jsonData.success && jsonData.project) {
                                    // Project found in JSON file
                                    if (DEBUG) console.log('Project found in JSON file:', jsonData.project);
                                    buildEditForm(jsonData.project);
                                    projectLoadingState.style.display = 'none';
                                    editProjectForm.style.display = 'block';
                                    
                                    // Show a warning that we're using JSON data
                                    showToast('Using JSON Data', 'Project loaded from JSON file instead of database.', 'warning');
                                } else {
                                    // Project not found anywhere
                                    if (DEBUG) console.error('Project not found in database or JSON file');
                                    projectLoadingState.style.display = 'none';
                                    projectNotFound.style.display = 'block';
                                    
                                    // Add error details to the UI
                                    const errorDetails = document.createElement('p');
                                    errorDetails.className = 'text-danger mt-2';
                                    errorDetails.textContent = jsonData.message || 'Project not found in database or JSON file';
                                    projectNotFound.querySelector('p').after(errorDetails);
                                }
                            });
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Error:', error);
                    projectLoadingState.style.display = 'none';
                    projectNotFound.style.display = 'block';
                    
                    // Add error details to the UI for debugging
                    const errorDetails = document.createElement('p');
                    errorDetails.className = 'text-danger mt-2';
                    errorDetails.textContent = 'Network error: ' + (error.message || 'Unknown error');
                    projectNotFound.querySelector('p').after(errorDetails);
                });
        }
        
        function buildEditForm(project) {
            // Create a hidden input for project ID
            const projectId = project._id.$oid;
            
            // Build the form HTML
            let formHTML = `
                <input type="hidden" id="projectId" name="projectId" value="${projectId}">
                
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Project Title*</label>
                            <input type="text" class="form-control" id="title" name="title" required value="${project.title || ''}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="abstract" class="form-label">Abstract*</label>
                            <textarea class="form-control" id="abstract" name="abstract" rows="3" required>${project.abstract || ''}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5">${project.description || ''}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="coverImage" class="form-label">Cover Image</label>
                            <div class="file-upload">
                                <div class="file-upload-btn" id="coverImageBtn">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <p>Click or drag to upload a new image</p>
                                </div>
                                <input type="file" class="form-control" id="coverImage" name="coverImage" accept="image/*">
                            </div>
                            <div id="imagePreviewContainer" class="mt-3 text-center" ${project.coverImage && project.coverImage.url ? '' : 'style="display: none;"'}>
                                <img id="imagePreview" class="preview-image" src="${project.coverImage && project.coverImage.url ? project.coverImage.url : ''}">
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
                            <input type="text" class="form-control" id="field" name="field" required value="${project.field || ''}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="institution" class="form-label">Institution</label>
                            <input type="text" class="form-control" id="institution" name="institution" value="${project.institution || 'United International University'}">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="createdAt" class="form-label">Created At</label>
                            <input type="date" class="form-control" id="createdAt" name="createdAt" value="${formatMongoDate(project.createdAt)}">
                            <small class="text-muted">Leave empty for current date</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="updatedAt" class="form-label">Updated At</label>
                            <input type="date" class="form-control" id="updatedAt" name="updatedAt" value="${formatMongoDate(project.updatedAt)}">
                            <small class="text-muted">Leave empty for current date</small>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="privacy" class="form-label">Privacy Setting</label>
                            <select class="form-select" id="privacy" name="privacy" required>
                                <option value="0" ${(project.privacy === 0 || project.privacy === '0' || project.privacy === undefined) ? 'selected' : ''}>Public - Visible to everyone</option>
                                <option value="1" ${(project.privacy === 1 || project.privacy === '1') ? 'selected' : ''}>Private - Visible only to you and collaborators</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a privacy setting.
                            </div>
                        </div>
                    </div>
                    
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
                                ${buildKeywordsBadges(project.keywords || [])}
                            </div>
                            <input type="hidden" id="keywordsList" name="keywords">
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
                                            <input type="url" class="form-control" id="github" name="github" placeholder="https://github.com/yourusername/your-repo" value="${project.links && project.links.github ? project.links.github : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="website" class="form-label">Project Website URL</label>
                                            <input type="url" class="form-control" id="website" name="website" placeholder="https://yourproject.example.com" value="${project.links && project.links.website ? project.links.website : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="paper" class="form-label">Research Paper URL</label>
                                            <input type="url" class="form-control" id="paper" name="paper" placeholder="https://journal.example.com/your-paper" value="${project.links && project.links.paper ? project.links.paper : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="doi" class="form-label">DOI</label>
                                            <input type="text" class="form-control" id="doi" name="doi" placeholder="10.xxxx/xxxxx" value="${project.links && project.links.doi ? project.links.doi : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="youtube" class="form-label">YouTube Video URL</label>
                                            <input type="url" class="form-control" id="youtube" name="youtube" placeholder="https://youtube.com/watch?v=xxxx" value="${project.links && project.links.youtube ? project.links.youtube : ''}">
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
                                    <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Supervisor Name" 
                                        value="${project.supervisor ? (project.supervisor.name || '') : ''}">
                                </div>
                                
                                <label class="form-label">Team Members</label>
                                <div id="membersContainer">
                                    <!-- Team members will be added here -->
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
                                    <div id="filesPreview" class="mt-2">
                                        <!-- Existing files will be displayed here -->
                                    </div>
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
                                    <div id="mediaPreview" class="mt-2 row g-2">
                                        <!-- Existing media will be displayed here -->
                                    </div>
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
                                    <label class="form-label">Project References</label>
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" id="referenceTitle" placeholder="Title/Author">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" id="referenceLink" placeholder="URL (optional)">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary w-100" id="addReference">
                                                <i class="bi bi-plus-lg"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div id="references-container">
                                        <!-- References will appear here -->
                                    </div>
                                    <input type="hidden" id="referencesList" name="references">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Section (Hidden from user but will store/update random stats) -->
                <input type="hidden" id="viewsCount" name="viewsCount" value="${project.stats ? project.stats.views || '' : ''}">
                <input type="hidden" id="downloadsCount" name="downloadsCount" value="${project.stats ? project.stats.downloads || '' : ''}">
                <input type="hidden" id="favoritesCount" name="favoritesCount" value="${project.stats ? project.stats.favorites || '' : ''}">
                
                <!-- Comments Section (Hidden, will be initialized as empty array if not present) -->
                <input type="hidden" id="commentsArray" name="commentsArray" value="${JSON.stringify(project.comments || [])}">
            `;
            
            // Additional form sections will be added in separate functions
            
            // Add action buttons at the bottom
            formHTML += `
                <div class="text-end mt-4">
                    <a href="project_management.php" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
            `;
            
            // Set form HTML
            editProjectForm.innerHTML = formHTML;
            
            // Initialize form elements
            initializeForm(project);
        }
        
        function buildKeywordsBadges(keywords) {
            if (!keywords || keywords.length === 0) return '';
            
            return keywords.map((keyword, index) => {
                return `<span class="keyword-badge">${keyword} <i class="bi bi-x-circle" data-index="${index}"></i></span>`;
            }).join('');
        }
        
        function formatReferencesForTextarea(references) {
            if (!references || references.length === 0) return '';
            
            // If references is already a string, return as is
            if (typeof references === 'string') return references;
            
            // If it's an array of reference objects, convert to text format
            if (Array.isArray(references)) {
                // Check if references have the format from our new UI
                if (references.length > 0 && (references[0].title || references[0].link)) {
                    return references.map(ref => {
                        if (ref.link) {
                            return `${ref.title} | ${ref.link}`;
                        }
                        return ref.title;
                    }).join('\n');
                }
                
                // Handle old format with 'cite' property
                return references.map(ref => ref.cite || '').join('\n');
            }
            
            return '';
        }
        
        function initializeForm(project) {
            // Initialize keywords
            window.keywords = project.keywords || [];
            document.getElementById('keywordsList').value = JSON.stringify(window.keywords);
            
            // Add keyword functionality
            const addKeywordBtn = document.getElementById('addKeyword');
            const keywordInput = document.getElementById('keyword');
            const keywordsContainer = document.getElementById('keywordsContainer');
            
            addKeywordBtn.addEventListener('click', function() {
                addKeyword();
            });
            
            keywordInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addKeyword();
                }
            });
            
            // Initialize click handlers for existing keyword badges
            document.querySelectorAll('.keyword-badge i').forEach(icon => {
                icon.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    window.keywords.splice(index, 1);
                    updateKeywordsDisplay();
                });
            });
            
            // Initialize references
            window.references = [];
            
            // Parse existing references from the project
            if (project.references) {
                if (Array.isArray(project.references)) {
                    // Check the format of the references
                    if (project.references.length > 0) {
                        if (project.references[0].title || project.references[0].link) {
                            // Already in the new format
                            window.references = project.references;
                        } else if (project.references[0].cite) {
                            // Old format with cite property
                            window.references = project.references.map(ref => {
                                // Check if the cite contains a URL
                                const parts = ref.cite.split('|').map(part => part.trim());
                                if (parts.length > 1) {
                                    return {
                                        title: parts[0],
                                        link: parts[1]
                                    };
                                }
                                return {
                                    title: ref.cite,
                                    link: ''
                                };
                            });
                        }
                    }
                } else if (typeof project.references === 'string') {
                    // Handle string format
                    const lines = project.references.split('\n');
                    window.references = lines.map(line => {
                        const parts = line.split('|').map(part => part.trim());
                        if (parts.length > 1) {
                            return {
                                title: parts[0],
                                link: parts[1]
                            };
                        }
                        return {
                            title: line,
                            link: ''
                        };
                    });
                }
            }
            
            // Update references display
            updateReferencesDisplay();
            
            // Setup reference form handlers
            const addReferenceBtn = document.getElementById('addReference');
            const referenceTitleInput = document.getElementById('referenceTitle');
            const referenceLinkInput = document.getElementById('referenceLink');
            
            addReferenceBtn.addEventListener('click', function() {
                addReference();
            });
            
            referenceTitleInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addReference();
                }
            });
            
            referenceLinkInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addReference();
                }
            });
            
            // Initialize cover image handling
            const coverImageInput = document.getElementById('coverImage');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const removeImageBtn = document.getElementById('removeImage');
            
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
            
            removeImageBtn.addEventListener('click', function() {
                coverImageInput.value = '';
                imagePreviewContainer.style.display = 'none';
                imagePreview.src = '';
            });
            
            // Initialize team members
            window.members = project.members || [];
            const membersContainer = document.getElementById('membersContainer');
            const addMemberBtn = document.getElementById('addMember');
            
            // Populate existing members
            if (window.members.length > 0) {
                window.members.forEach(member => {
                    addMemberRow(member);
                });
            } else {
                // Add at least one empty row
                addMemberRow();
            }
            
            // Add event listener for adding new members
            addMemberBtn.addEventListener('click', function() {
                addMemberRow();
            });
            
            // Initialize timeline items
            window.timelineItems = project.timeline || [];
            const timelineContainer = document.getElementById('timelineContainer');
            const addTimelineItemBtn = document.getElementById('addTimelineItem');
            
            // Populate existing timeline items
            if (window.timelineItems.length > 0) {
                updateTimelineDisplay();
            }
            
            // Add event listener for adding new timeline items
            addTimelineItemBtn.addEventListener('click', function() {
                addTimelineItem();
            });
            
            // Initialize files preview
            const filesPreviewContainer = document.getElementById('filesPreview');
            if (project.files && project.files.length > 0) {
                project.files.forEach(file => displayFilePreview(file, filesPreviewContainer));
            }
            
            // Initialize media preview
            const mediaPreviewContainer = document.getElementById('mediaPreview');
            if (project.media && project.media.length > 0) {
                project.media.forEach(media => displayMediaPreview(media, mediaPreviewContainer));
            }
            
            // Initialize form submission
            const editProjectForm = document.getElementById('editProjectForm');
            editProjectForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(project._id.$oid);
            });
        }
        
        function addMemberRow(member = null) {
            const membersContainer = document.getElementById('membersContainer');
            const row = document.createElement('div');
            row.className = 'row mb-2 member-row';
            
            const name = member ? member.name || '' : '';
            const role = member ? member.role || '' : '';
            const contribution = member ? member.contribution || 0 : '';
            const userId = member && member.userId && member.userId.$oid ? member.userId.$oid : '';
            
            row.innerHTML = `
                <div class="col-md-3">
                    <input type="text" class="form-control member-name" placeholder="Member Name" required value="${name}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control member-role" placeholder="Role (e.g., Author, Researcher)" value="${role}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control member-contribution" placeholder="Contribution %" min="0" max="100" value="${contribution}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control member-userid" placeholder="User ID (optional)" value="${userId}">
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
        
        function updateTimelineDisplay() {
            const timelineContainer = document.getElementById('timelineContainer');
            timelineContainer.innerHTML = '';
            
            if (window.timelineItems.length === 0) {
                timelineContainer.innerHTML = '<p class="text-muted text-center py-3">No timeline items added yet.</p>';
                return;
            }
            
            // Sort timeline items by date
            window.timelineItems.sort((a, b) => {
                const dateA = formatMongoDate(a.date);
                const dateB = formatMongoDate(b.date);
                return new Date(dateA || 0) - new Date(dateB || 0);
            });
            
            window.timelineItems.forEach((item, index) => {
                const statusClasses = {
                    'Completed': 'completed status-completed',
                    'In Progress': 'in-progress status-in-progress',
                    'Planned': 'planned status-planned',
                    'Delayed': 'delayed status-delayed'
                };
                
                const statusClass = statusClasses[item.status] || 'planned status-planned';
                
                const timelineItem = document.createElement('div');
                timelineItem.className = `timeline-item ${item.status ? item.status.toLowerCase().replace(' ', '-') : 'planned'}`;
                timelineItem.dataset.index = index;
                
                // Format date for display
                const formattedDate = formatMongoDate(item.date);
                const displayDate = formattedDate ? new Date(formattedDate) : new Date();
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
                            <span class="status-badge ${statusClass}">${item.status || 'Planned'}</span>
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
                    <h6 class="mb-2">${item.title || ''}</h6>
                    <p class="mb-0 small text-muted">${item.description || ''}</p>
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
        
        function addTimelineItem(item = null) {
            const now = new Date();
            const formattedDate = now.toISOString().split('T')[0]; // YYYY-MM-DD format
            
            const newItem = item || {
                title: '',
                description: '',
                date: { $date: now.toISOString() },
                status: 'Planned'
            };
            
            // Add to the array
            if (!item) {
                window.timelineItems.push(newItem);
            }
            
            // Update the display
            updateTimelineDisplay();
            
            // If it's a new item, open the edit dialog
            if (!item) {
                editTimelineItem(window.timelineItems.length - 1);
            }
        }
        
        function editTimelineItem(index) {
            const item = window.timelineItems[index];
            
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
            document.getElementById('timelineTitle').value = item.title || '';
            document.getElementById('timelineDescription').value = item.description || '';
            document.getElementById('timelineDate').value = formatMongoDate(item.date) || new Date().toISOString().split('T')[0];
            document.getElementById('timelineStatus').value = item.status || 'Planned';
            
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
                
                // Create a JavaScript Date object from the date string
                const dateObj = new Date(date);
                
                // Update timelineItems array
                window.timelineItems[index] = {
                    title,
                    description,
                    date: { $date: dateObj.toISOString() },
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
                window.timelineItems.splice(index, 1);
                updateTimelineDisplay();
            }
        }
        
        function displayFilePreview(file, container) {
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
            
            container.appendChild(filePreview);
        }
        
        function displayMediaPreview(media, container) {
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
            
            container.appendChild(mediaPreview);
        }
        
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
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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
        
        function submitForm(projectId) {
            // Show loading state
            const saveBtn = document.querySelector('button[type="submit"]');
            const originalText = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            
            // Get form values
            const title = document.getElementById('title').value.trim();
            const abstract = document.getElementById('abstract').value.trim();
            const description = document.getElementById('description').value.trim();
            const researchField = document.getElementById('field').value.trim();
            const institution = document.getElementById('institution').value.trim();
            const privacySelect = document.getElementById('privacy');
            const privacy = privacySelect.value;
            
            if (DEBUG) {
                console.log('Submitting form with values:', {
                    projectId,
                    title,
                    abstract,
                    description,
                    field: researchField,
                    institution,
                    privacy
                });
            }
            
            // Validate required fields
            let hasErrors = false;
            
            if (!title) {
                document.getElementById('title').classList.add('is-invalid');
                hasErrors = true;
            } else {
                document.getElementById('title').classList.remove('is-invalid');
            }
            
            if (!abstract) {
                document.getElementById('abstract').classList.add('is-invalid');
                hasErrors = true;
            } else {
                document.getElementById('abstract').classList.remove('is-invalid');
            }
            
            if (!researchField) {
                document.getElementById('field').classList.add('is-invalid');
                hasErrors = true;
            } else {
                document.getElementById('field').classList.remove('is-invalid');
            }
            
            // Validate privacy
            if (privacy === '' || privacy === null || privacy === undefined) {
                privacySelect.classList.add('is-invalid');
                hasErrors = true;
            } else {
                privacySelect.classList.remove('is-invalid');
            }
            
            if (hasErrors) {
                showToast('Error', 'Please fill in all required fields', 'error');
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
                return;
            }
            
            // Get keywords from global variable
            const keywords = window.keywords || [];
            
            // Get dates
            const createdDate = document.getElementById('createdAt').value;
            const updatedDate = document.getElementById('updatedAt').value || new Date().toISOString().split('T')[0];
            
            // Get links
            const githubUrl = document.getElementById('github').value.trim();
            const projectUrl = document.getElementById('website').value.trim();
            const paperUrl = document.getElementById('paper').value.trim();
            const doi = document.getElementById('doi').value.trim();
            const youtubeUrl = document.getElementById('youtube').value.trim();
            
            // Get supervisor
            const supervisor = document.getElementById('supervisor').value.trim();
            
            // Get team members
            const teamMembers = [];
            document.querySelectorAll('.member-row').forEach(row => {
                const name = row.querySelector('.member-name').value.trim();
                if (name) { // Only add if there's a name
                    const role = row.querySelector('.member-role').value.trim();
                    const contribution = parseInt(row.querySelector('.member-contribution').value) || 0;
                    const userId = row.querySelector('.member-userid').value.trim();
                    
                    teamMembers.push({
                        name: name,
                        role: role,
                        contribution: contribution,
                        userId: userId ? { $oid: userId } : null
                    });
                }
            });
            
            // Get timeline items (already in window.timelineItems)
            
            // Get references from the window.references array
            // Make sure the references input is updated with the latest data
            document.getElementById('referencesList').value = JSON.stringify(window.references);
            const references = window.references || [];
            
            if (DEBUG) {
                console.log('References data being submitted:', references);
            }
            
            // Get stats fields
            const views = parseInt(document.getElementById('viewsCount').value) || 0;
            const downloads = parseInt(document.getElementById('downloadsCount').value) || 0;
            const favorites = parseInt(document.getElementById('favoritesCount').value) || 0;
            
            // Get comments field
            const commentsValue = document.getElementById('commentsArray').value;
            const comments = commentsValue ? JSON.parse(commentsValue) : [];
            
            // Create FormData object for file uploads
            const formData = new FormData();
            
            // Add project ID
            formData.append('project_id', projectId);
            
            // Add basic information
            formData.append('title', title);
            formData.append('abstract', abstract);
            formData.append('description', description);
            formData.append('field', researchField);
            formData.append('institution', institution);
            formData.append('privacy', privacy);
            formData.append('keywords', JSON.stringify(keywords));
            
            // Add dates
            formData.append('created_date', createdDate);
            formData.append('updated_date', updatedDate);
            
            // Add links
            formData.append('github_url', githubUrl);
            formData.append('project_url', projectUrl);
            formData.append('paper_url', paperUrl);
            formData.append('doi', doi);
            formData.append('youtube_url', youtubeUrl);
            
            // Add supervisor
            formData.append('supervisor', supervisor);
            
            // Add team members
            formData.append('team_members', JSON.stringify(teamMembers));
            
            // Add timeline items
            formData.append('timeline', JSON.stringify(window.timelineItems));
            
            // Add references
            formData.append('references', JSON.stringify(references));
            
            // Add stats
            formData.append('views', views);
            formData.append('downloads', downloads);
            formData.append('favorites', favorites);
            
            // Add comments
            formData.append('comments', JSON.stringify(comments));
            
            // Add cover image if selected
            const coverImageInput = document.getElementById('coverImage');
            if (coverImageInput.files && coverImageInput.files[0]) {
                formData.append('cover_image', coverImageInput.files[0]);
            }
            
            // Add project files if selected
            const filesInput = document.getElementById('projectFiles');
            if (filesInput.files && filesInput.files.length > 0) {
                for (let i = 0; i < filesInput.files.length; i++) {
                    formData.append('project_files[]', filesInput.files[i]);
                }
            }
            
            // Add media files if selected
            const mediaInput = document.getElementById('mediaFiles');
            if (mediaInput.files && mediaInput.files.length > 0) {
                for (let i = 0; i < mediaInput.files.length; i++) {
                    formData.append('project_media[]', mediaInput.files[i]);
                }
            }
            
            // For debugging - log all form data
            if (DEBUG) {
                console.log('Submitting FormData:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
            }
            
            // Send the request
            fetch('src/model/update_project.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message and redirect to project details page
                    showToast('Success', 'Project updated successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = `Project_details.php?id=${projectId}`;
                    }, 1500);
                } else {
                    // Show error message
                    showToast('Error', data.message || 'Failed to update project', 'error');
                    
                    // Reset button state
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'An error occurred while updating the project', 'error');
                
                // Reset button state
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
            });
        }
        
        // Function to handle keywords
        function addKeyword() {
            const keywordInput = document.getElementById('keyword');
            const keyword = keywordInput.value.trim();
            
            if (keyword) {
                if (!window.keywords.includes(keyword)) {
                    window.keywords.push(keyword);
                    updateKeywordsDisplay();
                }
                keywordInput.value = '';
            }
        }
        
        function updateKeywordsDisplay() {
            const keywordsContainer = document.getElementById('keywordsContainer');
            const keywordsList = document.getElementById('keywordsList');
            
            keywordsContainer.innerHTML = '';
            keywordsList.value = JSON.stringify(window.keywords);
            
            if (window.keywords.length === 0) {
                keywordsContainer.innerHTML = '<p class="text-muted">No keywords added yet.</p>';
                return;
            }
            
            window.keywords.forEach((keyword, index) => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary keyword-badge me-2 mb-2';
                badge.innerHTML = `${keyword} <i class="bi bi-x-circle ms-1" data-index="${index}" role="button"></i>`;
                keywordsContainer.appendChild(badge);
                
                // Add event listener to remove icon
                badge.querySelector('i').addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    window.keywords.splice(index, 1);
                    updateKeywordsDisplay();
                });
            });
        }
        
        function updateReferencesDisplay() {
            const referencesContainer = document.getElementById('references-container');
            const referencesList = document.getElementById('referencesList');
            
            referencesContainer.innerHTML = '';
            referencesList.value = JSON.stringify(window.references);
            
            if (window.references.length === 0) {
                referencesContainer.innerHTML = '<p class="text-muted text-center py-3">No references added yet.</p>';
                return;
            }
            
            window.references.forEach((reference, index) => {
                const referenceItem = document.createElement('div');
                referenceItem.className = 'reference-item';
                
                let linkHtml = '';
                if (reference.link) {
                    linkHtml = `<div class="reference-link">
                        <a href="${reference.link}" target="_blank">${reference.link}</a>
                    </div>`;
                }
                
                referenceItem.innerHTML = `
                    <div class="reference-content">
                        <div class="reference-title">${reference.title}</div>
                        ${linkHtml}
                    </div>
                    <i class="bi bi-x-circle remove-reference" data-index="${index}"></i>
                `;
                
                referencesContainer.appendChild(referenceItem);
                
                // Add event listener to remove icon
                referenceItem.querySelector('.remove-reference').addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    window.references.splice(index, 1);
                    updateReferencesDisplay();
                });
            });
        }
        
        function addReference() {
            const titleInput = document.getElementById('referenceTitle');
            const linkInput = document.getElementById('referenceLink');
            
            const title = titleInput.value.trim();
            const link = linkInput.value.trim();
            
            if (title) {
                window.references.push({
                    title: title,
                    link: link
                });
                
                // Clear inputs
                titleInput.value = '';
                linkInput.value = '';
                
                // Update display
                updateReferencesDisplay();
                
                // Focus on title input for next entry
                titleInput.focus();
            }
        }
    });
    </script>
</body>
</html>
