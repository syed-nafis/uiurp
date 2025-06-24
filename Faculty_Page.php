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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/faculty_page.css">
    <style>
        /* Neo Faculty Card Styles */
        .neo-faculty-card {
            position: relative;
            background: rgba(30, 41, 59, 0.95);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            padding: 0;
            height: auto;
            min-height: 440px;
            width: 100%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3),
                        0 1px 3px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            cursor: pointer;
        }
        
        .neo-faculty-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2),
                        0 2px 6px rgba(0, 0, 0, 0.1);
            border-color: rgba(255, 255, 255, 0.12);
        }
        
        .card-border {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 16px;
            background: transparent;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 1;
        }
        
        .faculty-img-wrapper {
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .faculty-img-container {
            position: relative;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
            height: 280px;
            width: 100%;
            background: #2d3748;
        }
        
        .faculty-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition: transform 0.3s ease;
        }
        
        .neo-faculty-card:hover .faculty-img-container img {
            transform: scale(1.02);
        }
        
        .faculty-specialty-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 500;
            color: #e2e8f0;
            z-index: 3;
            transition: all 0.3s ease;
        }
        
        .neo-faculty-card:hover .faculty-specialty-badge {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
        }
        
        .faculty-info {
            padding: 1.25rem;
            position: relative;
            z-index: 3;
            flex: 1;
            display: flex;
            flex-direction: column;
            background: rgba(30, 41, 59, 0.95);
            min-height: 140px;
        }
        
        .faculty-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #f7fafc;
            line-height: 1.3;
            letter-spacing: -0.02em;
            transition: color 0.3s ease;
        }
        
        .faculty-position {
            font-size: 0.85rem;
            color: #a0aec0;
            margin-bottom: 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .faculty-quote {
            background: rgba(45, 55, 72, 0.5);
            border-left: 3px solid rgba(255, 255, 255, 0.2);
            border-radius: 0 8px 8px 0;
            padding: 12px 15px;
            font-style: italic;
            font-size: 0.85rem;
            color: #cbd5e0;
            margin-bottom: 0;
            margin-top: 1rem;
            position: relative;
            transition: all 0.3s ease;
            line-height: 1.4;
            flex: 1;
            min-height: 60px;
            display: flex;
            align-items: center;
        }
        
        .img-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, 
                        transparent 0%, 
                        transparent 60%,
                        rgba(30, 41, 59, 0.3) 100%);
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        /* Light theme overrides */
        [data-theme="light"] .neo-faculty-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(67, 97, 238, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .neo-faculty-card:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(67, 97, 238, 0.2);
            box-shadow: 0 8px 32px rgba(67, 97, 238, 0.12);
        }

        [data-theme="light"] .faculty-name {
            color: var(--text-primary);
        }

        [data-theme="light"] .faculty-position {
            color: var(--text-secondary);
        }

        [data-theme="light"] .faculty-quote {
            background: rgba(248, 250, 252, 0.8);
            border-left: 3px solid rgba(67, 97, 238, 0.3);
            color: var(--text-secondary);
        }

        [data-theme="light"] .faculty-info {
            background: rgba(255, 255, 255, 0.95);
        }

        [data-theme="light"] .faculty-specialty-badge {
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
            color: var(--neo-primary);
        }

        [data-theme="light"] .neo-faculty-card:hover .faculty-specialty-badge {
            background: rgba(67, 97, 238, 0.15);
            border-color: rgba(67, 97, 238, 0.3);
            box-shadow: 0 4px 16px rgba(67, 97, 238, 0.2);
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>

    <!-- Grid Background Effect -->
    <div class="grid-background"></div>
    
    <!-- Floating Elements for Ambient Animation -->
    <div class="floating-elements">
        <div class="floating-element element1"></div>
        <div class="floating-element element2"></div>
        <div class="floating-element element3"></div>
    </div>

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

    <!-- Faculty List Section -->
    <section class="faculty-section py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Meet Our Faculty</h2>
                <p class="section-subtitle">Explore the profiles of our distinguished faculty members</p>
            </div>
            <!-- Faculty cards will be loaded dynamically -->
            <div id="facultyList"></div>
        </div>
    </section>

    <?php include 'src/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/scripts/faculty_loader.js"></script>
    
    <!-- Scroll Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll reveal animation is now handled in faculty_loader.js
        });
    </script>
</body>
</html>