<?php
// Remove debug statements and error reporting
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIU Research Portal</title>
    
    <!-- Core styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Animation libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="assets/styles/home.css">
    <!-- Preload fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #7209b7;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --warning: #f72585;
            --gradient-primary: linear-gradient(135deg, #4361ee, #3a0ca3);
            --gradient-accent: linear-gradient(135deg, #7209b7, #f72585);
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: var(--dark);
            overflow-x: hidden;
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 80px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 3rem;
            max-width: 800px;
        }

        /* Custom animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 5px rgba(67, 97, 238, 0.5), 0 0 10px rgba(114, 9, 183, 0.3); }
            50% { box-shadow: 0 0 15px rgba(67, 97, 238, 0.7), 0 0 20px rgba(114, 9, 183, 0.5); }
            100% { box-shadow: 0 0 5px rgba(67, 97, 238, 0.5), 0 0 10px rgba(114, 9, 183, 0.3); }
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 30px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .min-vh-90 {
            min-height: 90vh;
        }
        
        /* Enhanced Hero Section Styles */
        .hero-section {
            position: relative;
            overflow: hidden;
            min-height: 60vh;
            padding-top: 80px;
            padding-bottom: 10px;
            margin-top: 0px;
            background-color: rgba(248, 249, 250, 0.8);
        }

        /* Update row padding for better vertical spacing */
        .hero-section .row.align-items-center {
            padding-top: 0;
            padding-bottom: 1rem;
        }
        
        /* Add responsive padding adjustments */
        @media (max-width: 991px) {
            .hero-section {
                min-height: 70vh;
                padding-top: 0;
            }
            
            .hero-section .row {
                padding-top: 0;
                padding-bottom: 0;
            }
        }
        
        .hero-bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 30%, rgba(67, 97, 238, 0.05), transparent 40%),
                        radial-gradient(circle at 70% 60%, rgba(114, 9, 183, 0.05), transparent 50%),
                        radial-gradient(circle at 90% 20%, rgba(247, 37, 133, 0.05), transparent 30%);
            z-index: -1;
        }
        
        .hero-content {
            position: relative;
            z-index: 5;
            padding: 0.5rem 0;
            border-radius: 20px;
        }
        
        .hero-heading {
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.15;
            margin-bottom: 1.5rem;
            font-size: 3.25rem;
            color: #212529;
            position: relative;
        }
        
        .gradient-text {
            background: var(--gradient-primary);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            position: relative;
            display: inline-block;
            padding-right: 10px;
            font-weight: 900;
        }
        
        .gradient-text::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 6px;
            background: none;
            border-radius: 3px;
            opacity: 0.2;
            z-index: -1;
        }
        
        .hero-subheading {
            font-size: 1.2rem;
            font-weight: 400;
            line-height: 1.7;
            color: rgba(33, 37, 41, 0.8);
            max-width: 540px;
            margin-bottom: 2rem;
        }
        
        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
            padding: 10px 20px;
            border-radius: 30px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(67, 97, 238, 0.15);
            margin-bottom: 0;
        }
        
        .hero-badge::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 30px;
            z-index: -1;
        }
        
        .hero-badge::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
            animation: badge-shine 3s ease-in-out infinite;
        }
        
        @keyframes badge-shine {
            0% { left: -100%; }
            100% { left: 200%; }
        }
        
        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }
        
        .btn-icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 1.1rem;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.75rem;
            color: white;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid var(--primary);
            border-radius: 50px;
            padding: 0.7rem 1.7rem;
            color: var(--primary);
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-secondary:hover {
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.15);
        }
        
        .research-stats {
            position: relative;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }
        
        .stats-label {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: var(--secondary);
            font-size: 1rem;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }
        
        .stats-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 50%;
            margin-right: 8px;
            color: var(--primary);
            font-size: 0.9rem;
        }
        
        .stat-circle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        
        .stat-circle::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 50%;
            background: var(--gradient-primary);
            z-index: -1;
            opacity: 0.4;
        }
        
        .stat-item:hover .stat-circle {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.2);
        }
        
        .stat-number {
            font-weight: 800;
            font-size: 1.4rem;
            background: var(--gradient-primary);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }
        
        .stat-label {
            margin-top: 0.3rem;
            font-weight: 600;
            color: var(--secondary);
            font-size: 0.7rem;
        }
        
        .hero-image-container {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .hero-image {
            position: relative;
            z-index: 2;
            max-width: 100%;
            filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.15));
            animation: float 8s ease-in-out infinite;
        }
        
        .hero-decoration {
            position: absolute;
            border-radius: 50%;
            z-index: 1;
        }
        
        .hero-decoration-1 {
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.2), transparent 70%);
            top: 15%;
            right: 10%;
            animation: float 8s ease-in-out infinite;
        }
        
        .hero-decoration-2 {
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(114, 9, 183, 0.15), transparent 70%);
            bottom: 15%;
            left: 5%;
            animation: float 6s ease-in-out infinite alternate;
        }
        
        .hero-decoration-3 {
            width: 80px;
            height: 80px;
            border: 3px solid rgba(67, 97, 238, 0.1);
            top: 30%;
            left: 20%;
            animation: float 4s ease-in-out infinite reverse;
        }
        
        .floating-dots {
            position: absolute;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background-image: radial-gradient(circle, rgba(67, 97, 238, 0.2) 1px, transparent 1px);
            background-size: 18px 18px;
            z-index: 1;
            opacity: 0.7;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: rotate 60s linear infinite;
        }
        
        .glowing-circle {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(114, 9, 183, 0.08) 0%, transparent 70%);
            z-index: 0;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: pulse-subtle 4s ease infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes pulse-subtle {
            0% { transform: translate(-50%, -50%) scale(0.95); opacity: 0.7; }
            50% { transform: translate(-50%, -50%) scale(1.05); opacity: 0.9; }
            100% { transform: translate(-50%, -50%) scale(0.95); opacity: 0.7; }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse {
            animation: pulse 4s ease-in-out infinite;
        }

        /* Custom button styles */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
            transition: var(--transition);
        }

        .btn-primary:hover {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .search-button-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: translateX(-100%);
        }
        
        .search-button:hover .search-button-effect {
            animation: search-button-effect 1s ease;
        }
        
        @keyframes search-button-effect {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .tag-cloud {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .tag-cloud span {
            background-color: #f0f0f0;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .tag-cloud span:hover {
            background-color: white;
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        .popular-searches {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }
        
        .popular-label {
            font-weight: 500;
            font-size: 14px;
            color: #666;
            margin-right: 10px;
            background: none !important;
            border: none !important;
            padding: 0 !important;
        }
        
        /* Enhanced Featured Projects Section */
        .section-tag {
            display: inline-block;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 20px;
            margin-bottom: 1rem;
        }
        
        .project-filter-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .filter-btn {
            background: transparent;
            border: 1px solid #dee2e6;
            border-radius: 30px;
            padding: 8px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .filter-btn.active, .filter-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .card-img-container {
            position: relative;
            overflow: hidden;
        }
        
        .card-img-container img {
            transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .custom-card:hover .card-img-container img {
            transform: scale(1.1);
        }
        
        .card-img-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .custom-card:hover .card-img-overlay {
            opacity: 1;
        }
        
        .view-project {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .custom-card:hover .view-project {
            transform: translateY(0);
            opacity: 1;
        }
        
        .card-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 12px;
        }
        
        .card-tags span {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
        }
        
        .card-meta {
            display: flex;
            gap: 15px;
            margin-top: 15px;
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .card-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .card-link i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }
        
        .card-link:hover i {
            transform: translateX(5px);
        }
        
        /* Research Impact Section */
        .impact-bg-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .impact-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }
        
        .impact-shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -150px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
        }
        
        .impact-shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            right: -100px;
            background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
        }
        
        .progress-animated .progress-bar {
            position: relative;
            overflow: hidden;
            background: var(--gradient-primary);
        }
        
        .progress-animated .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: progress-animation 2s ease infinite;
        }
        
        @keyframes progress-animation {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }
        
        .progress-title {
            font-weight: 600;
            color: #495057;
        }
        
        .progress-value {
            font-weight: 700;
            color: var(--primary);
        }
        
        .impact-chart-container {
            position: relative;
            height: 400px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 20px;
        }
        
        .impact-overlay {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 15px;
            box-shadow: var(--shadow-sm);
        }
        
        .impact-stat h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0;
            color: var(--accent);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .impact-stat p {
            font-size: 0.9rem;
            margin: 0;
            color: #6c757d;
        }
        
        .impact-highlights {
            position: absolute;
            left: 20px;
            bottom: 20px;
            right: 20px;
            display: flex;
            justify-content: space-between;
        }
        
        .highlight-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 10px;
            background: rgba(248, 249, 250, 0.8);
        }
        
        .highlight-icon {
            width: 45px;
            height: 45px;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: white;
            font-size: 1.2rem;
        }
        
        .highlight-content h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: var(--dark);
        }
        
        .highlight-content p {
            font-size: 0.8rem;
            margin: 0;
            color: #6c757d;
        }
        
        /* Faculty Spotlight Section */
        .faculty-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(30deg, rgba(67, 97, 238, 0.03) 12%, transparent 12.5%, transparent 87%, rgba(67, 97, 238, 0.03) 87.5%, rgba(67, 97, 238, 0.03)),
                linear-gradient(150deg, rgba(67, 97, 238, 0.03) 12%, transparent 12.5%, transparent 87%, rgba(67, 97, 238, 0.03) 87.5%, rgba(67, 97, 238, 0.03)),
                linear-gradient(30deg, rgba(67, 97, 238, 0.03) 12%, transparent 12.5%, transparent 87%, rgba(67, 97, 238, 0.03) 87.5%, rgba(67, 97, 238, 0.03)),
                linear-gradient(150deg, rgba(67, 97, 238, 0.03) 12%, transparent 12.5%, transparent 87%, rgba(67, 97, 238, 0.03) 87.5%, rgba(67, 97, 238, 0.03));
            background-size: 80px 140px;
            background-position: 0 0, 0 0, 40px 70px, 40px 70px;
            opacity: 0.5;
            z-index: 0;
        }
        
        .faculty-card {
            position: relative;
            border-radius: var(--border-radius);
            background: white;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
        }
        
        .faculty-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-md);
        }
        
        .faculty-img-container {
            position: relative;
            overflow: hidden;
        }
        
        .faculty-img-container img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .faculty-card:hover .faculty-img-container img {
            transform: scale(1.1);
        }
        
        .faculty-social {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(58, 12, 163, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .faculty-card:hover .faculty-social {
            opacity: 1;
        }
        
        .faculty-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.1rem;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .faculty-social a:nth-child(1) { transition-delay: 0.1s; }
        .faculty-social a:nth-child(2) { transition-delay: 0.2s; }
        .faculty-social a:nth-child(3) { transition-delay: 0.3s; }
        
        .faculty-card:hover .faculty-social a {
            transform: translateY(0);
            opacity: 1;
        }
        
        .faculty-social a:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }
        
        .faculty-info {
            padding: 20px;
        }
        
        .faculty-info h5 {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .faculty-position {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 6px;
        }
        
        .faculty-specialty {
            display: inline-block;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            font-size: 0.8rem;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 15px;
        }
        
        .faculty-quote {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            font-style: italic;
            color: #495057;
            font-size: 0.85rem;
            margin-bottom: 15px;
            position: relative;
        }
        
        .faculty-quote::before {
            content: '"';
            position: absolute;
            top: 0;
            left: 5px;
            font-size: 1.5rem;
            color: var(--primary);
            opacity: 0.3;
        }
        
        .faculty-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .faculty-link i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }
        
        .faculty-link:hover i {
            transform: translateX(5px);
        }
        
        .faculty-indicator {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            overflow: hidden;
        }
        
        .indicator-dot {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 4px;
            background: var(--primary);
            border-radius: 50%;
        }
        
        .indicator-line {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0%;
            background: var(--gradient-primary);
            transition: height 0.3s ease;
        }
        
        .faculty-card:hover .indicator-line {
            height: 100%;
        }
        
        /* Events Section */
        .events-bg-element {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.03) 0%, rgba(114, 9, 183, 0.03) 100%);
            z-index: -1;
        }
        
        .event-card {
            position: relative;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            display: flex;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-md);
        }
        
        .event-date {
            width: 80px;
            min-width: 80px;
            background: var(--gradient-primary);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 0;
            position: relative;
            overflow: hidden;
        }
        
        .event-date-decoration {
            position: absolute;
            top: -10px;
            left: -10px;
            width: 100px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(45deg);
        }
        
        .event-day {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }
        
        .event-month {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .event-content {
            flex-grow: 1;
            padding: 20px;
            position: relative;
        }
        
        .event-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 10px;
        }
        
        .event-tags span {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
        }
        
        .event-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }
        
        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .event-description {
            font-size: 0.9rem;
            color: #495057;
            margin-bottom: 15px;
        }
        
        .event-link {
            display: inline-flex;
            align-items: center;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .event-link i {
            margin-left: 5px;
            transition: transform 0.3s ease;
        }
        
        .event-link:hover i {
            transform: translateX(5px);
        }
        
        .event-indicator {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 4px;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }
        
        .event-card:hover .event-indicator {
            width: 100%;
        }
        
        /* FAQ Section */
        .custom-accordion .accordion-item {
            border: none;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 15px;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        
        .custom-accordion .accordion-item:hover {
            box-shadow: var(--shadow-md);
        }
        
        .custom-accordion .accordion-button {
            padding: 20px;
            font-weight: 600;
            color: var(--dark);
            background: white;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .custom-accordion .accordion-button:not(.collapsed) {
            color: var(--primary);
            background: rgba(67, 97, 238, 0.05);
            box-shadow: none;
        }
        
        .custom-accordion .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234361ee'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transition: transform 0.3s ease;
        }
        
        .custom-accordion .accordion-body {
            padding: 0 20px 20px;
            color: #6c757d;
        }
        
        /* Footer Styles */
        .footer {
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(114, 9, 183, 0.1));
            opacity: 0.1;
            z-index: 0;
        }
        
        .footer-logo {
            height: 60px;
        }
        
        .footer-tagline {
            font-size: 1rem;
            opacity: 0.8;
        }
        
        .footer-social {
            display: flex;
            gap: 10px;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: var(--primary);
            transform: translateY(-5px);
            color: white;
        }
        
        .footer-heading {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }
        
        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 40px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 3px;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .footer-links a::before {
            content: '›';
            margin-right: 8px;
            color: var(--accent);
            font-size: 1.2rem;
            line-height: 0;
            transition: transform 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .footer-links a:hover::before {
            transform: translateX(3px);
        }
        
        .footer-newsletter .input-group {
            overflow: hidden;
            border-radius: var(--border-radius);
        }
        
        .footer-newsletter .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 15px;
        }
        
        .footer-newsletter .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        
        .footer-newsletter .btn {
            padding: 0 20px;
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .footer-bottom {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        .footer-bottom-links {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 20px;
        }
        
        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .footer-bottom-links a:hover {
            color: white;
        }
        
        /* Media Queries */
        @media (max-width: 991px) {
            .section-padding {
                padding: 80px 0;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .hero-section .row {
                min-height: 70vh;
            }
            
            .hero-heading {
                font-size: 2.5rem;
                letter-spacing: -0.03em;
            }
            
            .hero-content {
                padding: 1.5rem 0;
                text-align: center;
            }
            
            .hero-buttons {
                justify-content: center;
            }
            
            .hero-subheading {
                margin-left: auto;
                margin-right: auto;
            }
            
            .stats-label {
                justify-content: center;
            }
            
            .research-stats {
                margin-top: 2.5rem;
            }
            
            .stat-circle {
                width: 70px;
                height: 70px;
            }
            
            .stat-number {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 767px) {
            .section-padding {
                padding: 60px 0;
            }
            
            .hero-section .row {
                min-height: auto;
                padding: 6rem 0 3rem;
            }
            
            .hero-heading {
                font-size: 2.25rem;
            }
            
            .hero-subheading {
                font-size: 1.1rem;
                line-height: 1.6;
            }
            
            .hero-buttons {
                gap: 0.75rem;
            }
            
            .hero-buttons .btn {
                width: 100%;
                display: flex;
                justify-content: center;
            }
            
            .stat-circle {
                width: 65px;
                height: 65px;
            }
            
            .stat-number {
                font-size: 1.6rem;
            }
            
            .stat-label {
                font-size: 0.8rem;
                margin-top: 0.5rem;
            }
        }
        
        /* New Hero Decorative Elements */
        .hero-decorations {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }
        
        .hero-decor-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.3;
        }
        
        .hero-decor-circle-1 {
            top: 15%;
            left: 5%;
            width: 250px;
            height: 250px;
            border: 2px solid var(--primary);
            animation: rotate 30s linear infinite;
        }
        
        .hero-decor-circle-2 {
            bottom: 10%;
            right: 5%;
            width: 180px;
            height: 180px;
            border: 2px dashed var(--accent);
            animation: rotate 25s linear infinite reverse;
        }
        
        .hero-decor-dots {
            position: absolute;
            top: 25%;
            right: 15%;
            width: 200px;
            height: 200px;
            background-image: radial-gradient(circle, var(--primary) 1px, transparent 1px);
            background-size: 15px 15px;
            opacity: 0.2;
            border-radius: 50%;
            animation: float 15s ease-in-out infinite alternate;
        }
        
        .hero-decor-line {
            position: absolute;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            height: 1px;
            opacity: 0.15;
        }
        
        .hero-decor-line-1 {
            width: 20%;
            top: 30%;
            left: 0;
            transform: rotate(-15deg);
        }
        
        .hero-decor-line-2 {
            width: 15%;
            bottom: 25%;
            right: 5%;
            transform: rotate(30deg);
        }
        
        /* Research Impact Section Styles */
        .research-impact {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #f8f9fa;
        }
        
        .impact-bg-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        
        .impact-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }
        
        .impact-shape-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #4361ee, transparent);
            top: -250px;
            left: -100px;
            filter: blur(60px);
        }
        
        .impact-shape-2 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #7209b7, transparent);
            bottom: -300px;
            right: -150px;
            filter: blur(80px);
        }
        
        .grid-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: 1;
        }
        
        .glowing-orb {
            position: absolute;
            border-radius: 50%;
            animation: pulse-glow 5s infinite ease-in-out;
            filter: blur(20px);
        }
        
        .orb-1 {
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.3), transparent 70%);
            top: 20%;
            left: 15%;
            animation-delay: 0s;
        }
        
        .orb-2 {
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(114, 9, 183, 0.3), transparent 70%);
            bottom: 30%;
            right: 25%;
            animation-delay: 1s;
        }
        
        .orb-3 {
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(247, 37, 133, 0.3), transparent 70%);
            top: 60%;
            left: 40%;
            animation-delay: 2s;
        }
        
        .futuristic-title {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 1.5rem;
        }
        
        .futuristic-badge {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(114, 9, 183, 0.1));
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #f8f9fa;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #4361ee, #7209b7);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            position: relative;
            display: inline-block;
            padding: 0 5px;
        }
        
        .title-underline {
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #4361ee, #7209b7);
            border-radius: 2px;
            margin-top: 1.5rem;
        }
        
        .impact-chart-container {
            position: relative;
            height: 450px;
            padding: 1.75rem;
            border-radius: var(--border-radius);
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25), 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.4s ease;
        }
        
        .impact-chart-container:hover {
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: rgba(76, 201, 240, 0.2);
        }
        
        .impact-chart-container.updating {
            border-color: rgba(76, 201, 240, 0.4);
            box-shadow: 0 0 40px rgba(76, 201, 240, 0.2);
            animation: chart-pulse 0.7s ease-in-out;
        }
        
        @keyframes chart-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.01); }
            100% { transform: scale(1); }
        }
        
        .chart-wrapper {
            position: relative;
            height: 350px;
            width: 100%;
            overflow: hidden;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.3);
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .chart-glow-effect {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background: radial-gradient(circle at 50% 50%, rgba(76, 201, 240, 0.05) 0%, rgba(15, 23, 42, 0) 60%);
            z-index: 1;
        }
        
        .chart-header {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.5rem;
        }
        
        .chart-header h4 {
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0 0 15px 0;
            background: linear-gradient(135deg, #ffffff, #a6c1ee);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .chart-controls {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .chart-control-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 6px 15px;
            font-size: 0.8rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .chart-control-btn:hover {
            background: rgba(76, 201, 240, 0.1);
            border-color: rgba(76, 201, 240, 0.2);
            color: rgba(255, 255, 255, 0.9);
        }
        
        .chart-control-btn.active {
            background: rgba(76, 201, 240, 0.2);
            border-color: rgba(76, 201, 240, 0.3);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.2);
        }
        
        .chart-legend {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .chart-legend span {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.05);
            padding: 5px 10px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .chart-legend span:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .legend-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 6px;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }
        
        .publications-dot {
            background-color: #4361ee;
            box-shadow: 0 0 8px rgba(67, 97, 238, 0.8);
        }
        
        .citations-dot {
            background-color: #7209b7;
            box-shadow: 0 0 8px rgba(114, 9, 183, 0.8);
        }
        
        .funding-dot {
            background-color: #4cc9f0;
            box-shadow: 0 0 8px rgba(76, 201, 240, 0.8);
        }
        
        /* Counter styles for the highlight items */
        .counter-value {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            text-shadow: 0 0 10px rgba(76, 201, 240, 0.5);
            line-height: 1;
            margin-bottom: 0.25rem;
        }
        
        .counter-suffix {
            display: inline-block;
            font-size: 1.2rem;
            font-weight: 700;
            color: #4cc9f0;
            text-shadow: 0 0 8px rgba(76, 201, 240, 0.6);
            margin-left: 2px;
            vertical-align: text-top;
        }
        
        .impact-highlights {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .highlight-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 1.25rem;
            border-radius: var(--border-radius);
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
        }
        
        .highlight-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.3);
            background: rgba(25, 33, 52, 0.7);
            border-color: rgba(76, 201, 240, 0.3);
        }
        
        /* Add responsive adjustments */
        @media (max-width: 767px) {
            .impact-highlights {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .impact-highlights {
                grid-template-columns: 1fr;
            }
        }
        
        .highlight-icon {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            color: #fff;
            font-size: 1.6rem;
            margin-bottom: 1.25rem;
            position: relative;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
            transition: all 0.4s ease;
        }
        
        .highlight-icon::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 50%;
            border: 1px solid rgba(76, 201, 240, 0.3);
            opacity: 0.5;
            animation: pulse 2s infinite ease-in-out;
        }
        
        .highlight-item:hover .highlight-icon {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .highlight-content {
            text-align: center;
        }
        
        .highlight-content h4 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            background: linear-gradient(135deg, #ffffff, #a6c1ee);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-top: 0.5rem;
        }
        
        .highlight-content p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0.5rem 0 0;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        /* Progress bars styling */
        .progress-item {
            margin-bottom: 1.5rem;
        }
        
        .progress-title {
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .progress-value {
            font-size: 1rem;
            font-weight: 700;
        }
        
        .glow-text {
            text-shadow: 0 0 10px rgba(67, 97, 238, 0.7);
        }
        
        .progress {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 0.5rem;
        }
        
        .progress-glow {
            background: linear-gradient(90deg, #4361ee, #7209b7);
            box-shadow: 0 0 20px rgba(67, 97, 238, 0.6);
        }
        
        .glassmorphism {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }
        
        /* Research Stats Design (Hero Section) */
        .research-stats {
            position: relative;
        }
        
        .stats-label {
            display: inline-flex;
            align-items: center;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .stats-icon {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            color: #fff;
            font-size: 0.7rem;
            margin-right: 0.5rem;
        }
        
        .pulse-anim {
            animation: pulse 2s infinite ease-in-out;
        }
        
        .stats-container {
            border-radius: var(--border-radius);
            padding: 1.5rem;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .stats-grid {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }
        
        .stat-item {
            flex: 1;
        }
        
        .stat-hexagon {
            position: relative;
            width: 100px;
            height: 110px;
            margin-bottom: 1rem;
            background: rgba(15, 23, 42, 0.5);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .hexagon-inner {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 90px;
            height: 100px;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.3), rgba(114, 9, 183, 0.3));
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }
        
        .stat-icon-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            opacity: 0.15;
            color: #fff;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 0 10px rgba(67, 97, 238, 0.7);
            z-index: 1;
        }
        
        .stat-label {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .stat-item:hover .stat-hexagon {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
        }
        
        /* Button glow effect */
        .btn-glow {
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(67, 97, 238, 0.7);
            transform: translateY(-3px);
        }
        
        .btn-icon-wrapper {
            display: inline-flex;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loading-animation"></div>
    </div>

    <!-- Background elements -->
    <div class="bg-gradient"></div>
    <div class="floating-shape shape-1 animate-float"></div>
    <div class="floating-shape shape-2 animate-float"></div>
    <div class="floating-shape shape-3 animate-float"></div>

  <?php 
        // Include navbar
        $navbar_path = 'src/includes/navbar.php';
        if (file_exists($navbar_path)) {
            include $navbar_path; 
        } else {
            echo "<div class='alert alert-danger'>Navigation menu file not found at: $navbar_path</div>";
        }
    ?>
    

    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <div class="hero-bg-animation"></div>
        <div class="hero-decorations">
            <div class="hero-decor-circle hero-decor-circle-1"></div>
            <div class="hero-decor-circle hero-decor-circle-2"></div>
            <div class="hero-decor-dots"></div>
            <div class="hero-decor-line hero-decor-line-1"></div>
            <div class="hero-decor-line hero-decor-line-2"></div>
        </div>
        <div class="container h-100">
            <div class="row align-items-center justify-content-between py-4 pb-2">
                <div class="col-lg-6 py-1" data-aos="fade-right" data-aos-duration="1000">
                    <div class="hero-content pe-lg-4">
                        <div class="badge-container mb-3" data-aos="fade-down" data-aos-delay="200">
                            <span class="hero-badge">UIU Research Portal <i class="bi bi-stars ms-2"></i></span>
                        </div>
                        <h1 class="hero-heading display-3 fw-bold mb-3" data-aos="fade-up" data-aos-delay="300">
                            Discover groundbreaking <span class="gradient-text">research</span> at UIU
                        </h1>
                        <p class="hero-subheading lead mb-4" data-aos="fade-up" data-aos-delay="400">
                            Connect with innovative researchers, explore cutting-edge projects, and collaborate on ideas that shape the future.
                        </p>
                        <div class="hero-buttons d-flex flex-wrap gap-3 mb-4" data-aos="fade-up" data-aos-delay="500">
                            <a href="Research_page.php" class="btn btn-primary btn-shine">
                                <span class="btn-icon-wrapper"><i class="bi bi-search"></i></span>
                                <span>Explore Projects</span>
                            </a>
                            <a href="project_management.php#new-project" class="btn btn-secondary btn-glow">
                                <span class="btn-icon-wrapper"><i class="bi bi-plus-circle"></i></span>
                                <span>Start Research</span>
                            </a>
                        </div>
                        
                        <!-- Research Stats -->
                        <div class="research-stats mt-24 pt-12" data-aos="fade-up" data-aos-delay="600">
                            <h6 class="stats-label futuristic-badge mb-12">
                                <span class="stats-icon pulse-anim"><i class="bi bi-graph-up-arrow"></i></span>
                                Research Impact
                            </h6>
                            <div class="stats-container glassmorphism">
                                <div class="stats-grid">
                                    <div class="stat-item text-center">
                                        <div class="stat-hexagon mx-auto">
                                            <div class="hexagon-inner">
                                                <div class="stat-icon-bg">
                                                    <i class="bi bi-folder-fill"></i>
                                                </div>
                                                <h2 class="stat-number counter-value" data-count="250">0</h2>
                                            </div>
                                        </div>
                                        <p class="stat-label glow-text mb-1">Projects</p>
                                    </div>
                                    <div class="stat-item text-center">
                                        <div class="stat-hexagon mx-auto">
                                            <div class="hexagon-inner">
                                                <div class="stat-icon-bg">
                                                    <i class="bi bi-people-fill"></i>
                                                </div>
                                                <h2 class="stat-number counter-value" data-count="120">0</h2>
                                            </div>
                                        </div>
                                        <p class="stat-label glow-text mb-1">Researchers</p>
                                    </div>
                                    <div class="stat-item text-center">
                                        <div class="stat-hexagon mx-auto">
                                            <div class="hexagon-inner">
                                                <div class="stat-icon-bg">
                                                    <i class="bi bi-journal-text"></i>
                                                </div>
                                                <h2 class="stat-number counter-value" data-count="85">0</h2>
                                            </div>
                                        </div>
                                        <p class="stat-label glow-text mb-1">Publications</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 position-relative d-none d-lg-block" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="300">
                    <div class="hero-image-container">
                        <div class="floating-dots"></div>
                        <div class="glowing-circle"></div>
                        <img src="assets/resources/hero-research.png" alt="Research Visualization" class="img-fluid hero-image animate-float">
                        <div class="hero-decoration hero-decoration-1"></div>
                        <div class="hero-decoration hero-decoration-2"></div>
                        <div class="hero-decoration hero-decoration-3"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search Wave -->
        <div class="search-wave">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,208C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>
    
    <!-- Futuristic Search Section -->
    <section class="search-section py-5 bg-gradient-dark position-relative">
        <div class="search-particles" id="search-particles"></div>
        <div class="search-blur-effect"></div>
        <div class="search-glow"></div>
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-container" data-aos="fade-up">
                        <div class="search-header text-center mb-4">
                            <h3 class="text-light mb-2 fw-bold">Find Your Research Interests</h3>
                            <p class="text-light opacity-75">Discover projects aligned with your academic pursuits</p>
                        </div>
                        <div class="futuristic-search-bar">
                            <div class="search-icon-container">
                                <i class="bi bi-search"></i>
                            </div>
                            <input type="text" placeholder="Search for research topics, keywords, or faculty..." id="search-bar" class="form-control">
                            <button id="search-bttn" class="search-button">
                                <span>Search</span>
                                <div class="search-button-effect"></div>
                                <div class="search-button-glow"></div>
                            </button>
                            <div class="search-bar-glow"></div>
                        </div>
                        <div class="interactive-tag-cloud mt-4" id="keywordsList">
        <!-- Keywords will be dynamically added here -->
                            <div class="popular-searches">
                                <span class="popular-label">Popular Searches:</span>
    </div>
                            <!-- Placeholder tags that will be replaced by dynamic content -->
                            <span class="keyword-tag">Machine Learning</span>
                            <span class="keyword-tag">Blockchain</span>
                            <span class="keyword-tag">Cybersecurity</span>
  </div>
        </div>
        </div>
        </div>
      </div>
        <div class="search-grid-overlay"></div>
    </section>
    
    <style>
        /* Futuristic Search Section Styles */
        .search-section {
            background: linear-gradient(135deg, #121729 0%, #1a2151 100%);
            position: relative;
            overflow: hidden;
            padding: 60px 0;
        }
        
        .search-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .search-blur-effect {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 300px;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.15), transparent 70%);
            border-radius: 50%;
            filter: blur(30px);
            z-index: 1;
            animation: pulse-slow 6s ease-in-out infinite alternate;
        }
        
        .search-glow {
            position: absolute;
            bottom: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 400px;
            background: radial-gradient(ellipse at center, rgba(114, 9, 183, 0.2), transparent 70%);
            border-radius: 50%;
            z-index: 1;
        }
        
        .search-grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(to right, rgba(76, 201, 240, 0.03) 1px, transparent 1px), 
                              linear-gradient(to bottom, rgba(76, 201, 240, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 2;
            opacity: 0.4;
        }
        
        .search-container {
            position: relative;
            z-index: 10;
        }
        
        .futuristic-search-bar {
            position: relative;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 30px;
            padding: 8px 8px 8px 20px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s ease;
            overflow: hidden;
        }
        
        .futuristic-search-bar:focus-within {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 40px rgba(76, 201, 240, 0.2);
            transform: translateY(-2px);
        }
        
        .search-icon-container {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            margin-right: 15px;
        }
        
        .futuristic-search-bar .form-control {
            background: transparent;
            border: none;
            color: white;
            flex-grow: 1;
            font-size: 1.05rem;
            padding: 12px 5px;
            box-shadow: none;
        }
        
        .futuristic-search-bar .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .futuristic-search-bar .form-control:focus {
            outline: none;
            box-shadow: none;
        }
        
        .search-button {
            background: linear-gradient(135deg, #4361ee, #4cc9f0);
            border: none;
            border-radius: 24px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.17, 0.67, 0.83, 0.67);
            z-index: 1;
        }
        
        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 201, 240, 0.3);
        }
        
        .search-button-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
        }
        
        .search-button:hover .search-button-effect {
            animation: search-button-shine 1.5s ease infinite;
        }
        
        .search-button-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(76, 201, 240, 0.8), transparent);
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }
        
        .search-button:active .search-button-glow {
            opacity: 0.3;
        }
        
        .search-bar-glow {
            position: absolute;
            bottom: -5px;
            left: 10%;
            width: 80%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(76, 201, 240, 0.6), transparent);
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .futuristic-search-bar:focus-within .search-bar-glow {
            opacity: 1;
            animation: search-bar-glow 2s ease infinite;
        }
        
        @keyframes search-button-shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        @keyframes search-bar-glow {
            0% { opacity: 0.3; left: 10%; }
            50% { opacity: 0.6; left: 15%; }
            100% { opacity: 0.3; left: 10%; }
        }
        
        @keyframes pulse-slow {
            0% { opacity: 0.4; transform: translate(-50%, -50%) scale(0.8); }
            50% { opacity: 0.6; transform: translate(-50%, -50%) scale(1.1); }
            100% { opacity: 0.4; transform: translate(-50%, -50%) scale(0.8); }
        }
        
        .interactive-tag-cloud {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
            animation: fade-in-up 1s ease forwards;
        }
        
        .interactive-tag-cloud span,
        #keywordsList span:not(.popular-label) {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            position: relative;
            overflow: hidden;
            display: inline-block;
            margin: 4px;
        }
        
        .interactive-tag-cloud span::before,
        #keywordsList span:not(.popular-label)::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .interactive-tag-cloud span:hover,
        #keywordsList span:not(.popular-label):hover {
            background: rgba(76, 201, 240, 0.2);
            color: white;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 5px 15px rgba(76, 201, 240, 0.2);
        }
        
        .interactive-tag-cloud span:hover::before,
        #keywordsList span:not(.popular-label):hover::before {
            opacity: 1;
        }
        
        .popular-searches {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }
        
        .popular-label {
            font-weight: 500;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-right: 10px;
            background: none !important;
            border: none !important;
            padding: 0 !important;
            backdrop-filter: none !important;
            box-shadow: none !important;
            cursor: default !important;
            transform: none !important;
        }
        
        /* Add specific class for keyword tags */
        .keyword-tag {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            margin: 4px;
        }
        
        .keyword-tag:hover {
            background: rgba(76, 201, 240, 0.2) !important;
            color: white !important;
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 5px 15px rgba(76, 201, 240, 0.2) !important;
        }
        
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .futuristic-search-bar {
                flex-direction: column;
                padding: 10px 15px;
                gap: 10px;
            }
            
            .search-icon-container {
                display: none;
            }
            
            .futuristic-search-bar .form-control {
                width: 100%;
                padding: 10px 5px;
            }
            
            .search-button {
                width: 100%;
                margin-top: 5px;
            }
        }
    </style>
    
    <script>
         document.addEventListener('DOMContentLoaded', function() {
         // Apply keyword style and hover effects to dynamically added elements
         const applyKeywordStyles = function() {
             const keywordSpans = document.querySelectorAll('#keywordsList span:not(.popular-label)');
             keywordSpans.forEach(span => {
                 // Add the keyword-tag class if not already present
                 if (!span.classList.contains('keyword-tag')) {
                     span.classList.add('keyword-tag');
                     
                     // Add click handler if not already added
                     if (!span._hasClickHandler) {
                         span._hasClickHandler = true;
                         span.addEventListener('click', function() {
                             const searchBar = document.getElementById('search-bar');
                             if (searchBar) {
                                 searchBar.value = this.textContent.trim();
                                 searchBar.focus();
                             }
                         });
                     }
                 }
             });
         };
         
         // Run initially
         setTimeout(applyKeywordStyles, 500);
         
         // Run periodically to catch dynamically added keywords
         setInterval(applyKeywordStyles, 2000);
         
         // Initialize particles for search background
         if (typeof particlesJS !== 'undefined') {
            particlesJS('search-particles', {
                "particles": {
                    "number": {
                        "value": 40,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#4cc9f0"
                    },
                    "shape": {
                        "type": "circle"
                    },
                    "opacity": {
                        "value": 0.3,
                        "random": true
                    },
                    "size": {
                        "value": 2,
                        "random": true
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#4cc9f0",
                        "opacity": 0.2,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.5
                            }
                        }
                    }
                },
                "retina_detect": true
            });
        }
        
        // Add hover animation to search input
        const searchBar = document.getElementById('search-bar');
        if (searchBar) {
            searchBar.addEventListener('focus', function() {
                document.querySelector('.futuristic-search-bar').classList.add('focused');
            });
            
            searchBar.addEventListener('blur', function() {
                document.querySelector('.futuristic-search-bar').classList.remove('focused');
            });
        }
        
        // Add ripple effect to search button
        const searchButton = document.getElementById('search-bttn');
        if (searchButton) {
            searchButton.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }
    });
    </script>

    <!-- Futuristic Projects Section -->
    <section class="featured-projects section-padding position-relative">
        <div class="projects-bg-gradient"></div>
        <div class="projects-grid-overlay"></div>
        <div class="projects-glow-sphere"></div>
        
        <div class="container position-relative">
            <!-- Section header -->
            <div class="row mb-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="800">
                    <div class="section-header">
                        <span class="futuristic-badge">Featured Research</span>
                        <h2 class="section-title futuristic-title">Innovative <span class="text-gradient">Projects</span></h2>
                        <p class="section-subtitle">Explore some of our most groundbreaking research projects from across the university, pushing the boundaries of knowledge and technology.</p>
                        <div class="title-underline"></div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center justify-content-lg-end" data-aos="fade-left" data-aos-duration="800">
                    <div class="futuristic-filter-tabs">
                        <button class="filter-btn active" data-filter="all">
                            <span class="btn-content">All Projects</span>
                            <span class="btn-glow"></span>
      </button>
                        <button class="filter-btn" data-filter="technology">
                            <span class="btn-content">Technology</span>
                            <span class="btn-glow"></span>
                        </button>
                        <button class="filter-btn" data-filter="science">
                            <span class="btn-content">Science</span>
                            <span class="btn-glow"></span>
                        </button>
                        <button class="filter-btn" data-filter="engineering">
                            <span class="btn-content">Engineering</span>
                            <span class="btn-glow"></span>
                        </button>
                        <button class="filter-btn" data-filter="medical">
                            <span class="btn-content">Medical</span>
                            <span class="btn-glow"></span>
      </button>
                    </div>
                </div>
            </div>
            
            <!-- Projects grid -->
            <div class="row g-4 project-grid">
                <!-- Project Item 1 -->
                <div class="col-md-6 col-lg-4 project-item" data-category="technology" data-aos="fade-up" data-aos-duration="800">
                    <div class="futuristic-card">
                        <div class="card-glow"></div>
                        <div class="card-badge technology">Technology</div>
                        <div class="card-img-container">
                            <img src="assets/resources/research_picture/pub_1.jpg" class="card-img-top" alt="AI Research">
                            <div class="card-img-overlay">
                                <div class="view-project-wrapper">
                                    <span class="view-project"><i class="bi bi-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-tags">
                                <span>Machine Learning</span>
                                <span>Climate Science</span>
                            </div>
                            <h5 class="card-title">Machine Learning for Climate Prediction</h5>
                            <p class="card-text">Developing advanced neural networks to improve climate change prediction models.</p>
                            <div class="card-meta">
                                <span><i class="bi bi-person"></i> Dr. Sarah Johnson</span>
                                <span><i class="bi bi-calendar"></i> 2023</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="Project_details.php?id=1" class="card-link">
                                <span>View Details</span> 
                                <i class="bi bi-arrow-right"></i>
                                <span class="link-hover-effect"></span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Project Item 2 -->
                <div class="col-md-6 col-lg-4 project-item" data-category="science" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="futuristic-card">
                        <div class="card-glow"></div>
                        <div class="card-badge science">Science</div>
                        <div class="card-img-container">
                            <img src="assets/resources/research_picture/pub_2.jpg" class="card-img-top" alt="Science Research">
                            <div class="card-img-overlay">
                                <div class="view-project-wrapper">
                                    <span class="view-project"><i class="bi bi-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-tags">
                                <span>Quantum</span>
                                <span>Computing</span>
                            </div>
                            <h5 class="card-title">Quantum Computing Applications</h5>
                            <p class="card-text">Exploring practical applications of quantum computing in cryptography and database management.</p>
                            <div class="card-meta">
                                <span><i class="bi bi-person"></i> Prof. Michael Chen</span>
                                <span><i class="bi bi-calendar"></i> 2023</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="Project_details.php?id=2" class="card-link">
                                <span>View Details</span>
                                <i class="bi bi-arrow-right"></i>
                                <span class="link-hover-effect"></span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Project Item 3 -->
                <div class="col-md-6 col-lg-4 project-item" data-category="engineering" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="futuristic-card">
                        <div class="card-glow"></div>
                        <div class="card-badge engineering">Engineering</div>
                        <div class="card-img-container">
                            <img src="assets/resources/research_picture/pub_3.jpg" class="card-img-top" alt="Engineering Research">
                            <div class="card-img-overlay">
                                <div class="view-project-wrapper">
                                    <span class="view-project"><i class="bi bi-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-tags">
                                <span>Sustainability</span>
                                <span>Materials</span>
                            </div>
                            <h5 class="card-title">Sustainable Building Materials</h5>
                            <p class="card-text">Developing eco-friendly building materials from recycled plastics and agricultural waste.</p>
                            <div class="card-meta">
                                <span><i class="bi bi-person"></i> Dr. Robert Park</span>
                                <span><i class="bi bi-calendar"></i> 2023</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="Project_details.php?id=3" class="card-link">
                                <span>View Details</span>
                                <i class="bi bi-arrow-right"></i>
                                <span class="link-hover-effect"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- More projects button -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-duration="800">
                <a href="Research_page.php" class="futuristic-button">
                    <span class="button-content">Discover All Research Projects</span>
                    <i class="bi bi-arrow-right ms-2"></i>
                    <span class="button-glow"></span>
                </a>
            </div>
        </div>
    </section>
    
    <style>
    /* Futuristic Projects Section Styling */
    .featured-projects {
        background: linear-gradient(135deg, #0f1428 0%, #121a33 100%);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    
    .projects-bg-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 30% 50%, rgba(76, 201, 240, 0.03) 0%, transparent 60%), 
                    radial-gradient(circle at 70% 20%, rgba(114, 9, 183, 0.03) 0%, transparent 60%);
        z-index: 1;
    }
    
    .projects-grid-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: linear-gradient(to right, rgba(76, 201, 240, 0.03) 1px, transparent 1px), 
                            linear-gradient(to bottom, rgba(76, 201, 240, 0.03) 1px, transparent 1px);
        background-size: 30px 30px;
        z-index: 2;
        opacity: 0.4;
    }
    
    .projects-glow-sphere {
        position: absolute;
        top: 20%;
        left: 75%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(76, 201, 240, 0.1), transparent 70%);
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
        opacity: 0.6;
        animation: float 15s ease-in-out infinite alternate;
    }
    
    .featured-projects .container {
        position: relative;
        z-index: 10;
    }
    
    .futuristic-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(76, 201, 240, 0.1);
        color: #4cc9f0;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 16px;
        border-radius: 20px;
        letter-spacing: 1px;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
        border: 1px solid rgba(76, 201, 240, 0.2);
    }
    
    .futuristic-title {
        font-size: 3rem;
        font-weight: 700;
        letter-spacing: -0.5px;
        margin-bottom: 1.5rem;
        color: #fff;
        position: relative;
        display: inline-block;
    }
    
    .text-gradient {
        background: linear-gradient(135deg, #4cc9f0, #7209b7);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .title-underline {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #4cc9f0, transparent);
        margin-top: 20px;
        border-radius: 2px;
    }
    
    .section-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.7);
        max-width: 600px;
        line-height: 1.7;
    }
    
    .futuristic-filter-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: flex-end;
    }
    
    .filter-btn {
        position: relative;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        padding: 10px 20px;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
    
    .filter-btn .btn-content {
        position: relative;
        z-index: 2;
    }
    
    .filter-btn .btn-glow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.5), rgba(114, 9, 183, 0.5));
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
        border-radius: 30px;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        color: white;
        border-color: rgba(76, 201, 240, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 201, 240, 0.2);
    }
    
    .filter-btn:hover .btn-glow,
    .filter-btn.active .btn-glow {
        opacity: 0.2;
    }
    
    .filter-btn.active {
        background: rgba(76, 201, 240, 0.2);
    }
    
    .futuristic-card {
        position: relative;
        background: rgba(20, 30, 60, 0.5);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.17, 0.84, 0.44, 1);
        border: 1px solid rgba(76, 201, 240, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transform: translateY(0);
        height: 100%;
    }
    
    .futuristic-card .card-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at center, rgba(76, 201, 240, 0.3), transparent 70%);
        opacity: 0;
        transition: opacity 0.5s ease;
        pointer-events: none;
        z-index: 1;
    }
    
    .futuristic-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border-color: rgba(76, 201, 240, 0.2);
    }
    
    .futuristic-card:hover .card-glow {
        opacity: 0.1;
        animation: rotate-slow 10s linear infinite;
    }
    
    @keyframes rotate-slow {
        from {
            transform: rotate(0deg) scale(1);
        }
        to {
            transform: rotate(360deg) scale(1.2);
        }
    }
    
    .futuristic-card .card-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 10;
    }
    
    .card-badge.technology {
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.2), rgba(67, 97, 238, 0.2));
        color: #4cc9f0;
        border: 1px solid rgba(76, 201, 240, 0.3);
    }
    
    .card-badge.science {
        background: linear-gradient(135deg, rgba(114, 9, 183, 0.2), rgba(247, 37, 133, 0.2));
        color: #7209b7;
        border: 1px solid rgba(114, 9, 183, 0.3);
    }
    
    .card-badge.engineering {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.2), rgba(58, 12, 163, 0.2));
        color: #4361ee;
        border: 1px solid rgba(67, 97, 238, 0.3);
    }
    
    .card-badge.medical {
        background: linear-gradient(135deg, rgba(247, 37, 133, 0.2), rgba(114, 9, 183, 0.2));
        color: #f72585;
        border: 1px solid rgba(247, 37, 133, 0.3);
    }
    
    .futuristic-card .card-img-container {
        position: relative;
        overflow: hidden;
    }
    
    .futuristic-card .card-img-container img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.17, 0.84, 0.44, 1);
    }
    
    .futuristic-card:hover .card-img-container img {
        transform: scale(1.1);
    }
    
    .futuristic-card .card-img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(20, 30, 60, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    
    .futuristic-card:hover .card-img-overlay {
        opacity: 1;
    }
    
    .view-project-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .futuristic-card .view-project {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #121a33;
        font-size: 1.2rem;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.17, 0.84, 0.44, 1);
        z-index: 2;
    }
    
    .futuristic-card:hover .view-project {
        transform: translateY(0);
        opacity: 1;
    }
    
    .futuristic-card .view-project::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.5);
        animation: ripple 2s infinite ease-out;
        z-index: -1;
    }
    
    @keyframes ripple {
        0% {
            transform: scale(1);
            opacity: 0.5;
        }
        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }
    
    .futuristic-card .card-body {
        padding: 20px;
    }
    
    .futuristic-card .card-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }
    
    .futuristic-card .card-tags span {
        background: rgba(76, 201, 240, 0.1);
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.7rem;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid rgba(76, 201, 240, 0.2);
    }
    
    .futuristic-card .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: white;
    }
    
    .futuristic-card .card-text {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 15px;
        line-height: 1.6;
    }
    
    .futuristic-card .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 10px;
    }
    
    .futuristic-card .card-meta i {
        color: #4cc9f0;
        margin-right: 5px;
    }
    
    .futuristic-card .card-footer {
        padding: 15px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .card-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        color: #4cc9f0;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .card-link i {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }
    
    .card-link:hover {
        color: white;
    }
    
    .card-link:hover i {
        transform: translateX(5px);
    }
    
    .card-link .link-hover-effect {
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #4cc9f0, transparent);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }
    
    .card-link:hover .link-hover-effect {
        transform: scaleX(1);
    }
    
    .futuristic-button {
        position: relative;
        display: inline-flex;
        align-items: center;
        padding: 12px 30px;
        background: rgba(76, 201, 240, 0.1);
        border: 1px solid rgba(76, 201, 240, 0.3);
        border-radius: 30px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        overflow: hidden;
        transition: all 0.3s ease;
        z-index: 1;
    }
    
    .futuristic-button .button-content {
        position: relative;
        z-index: 2;
    }
    
    .futuristic-button .button-glow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.5), rgba(114, 9, 183, 0.5));
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    
    .futuristic-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(76, 201, 240, 0.3);
        color: white;
    }
    
    .futuristic-button:hover .button-glow {
        opacity: 0.2;
    }
    
    @media (max-width: 991px) {
        .futuristic-title {
            font-size: 2.5rem;
        }
        
        .futuristic-filter-tabs {
            justify-content: flex-start;
            margin-top: 20px;
        }
    }
    
    @media (max-width: 576px) {
        .featured-projects {
            padding: 70px 0;
        }
        
        .futuristic-title {
            font-size: 2rem;
        }
        
        .filter-btn {
            padding: 8px 15px;
            font-size: 0.8rem;
        }
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Project filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const projectItems = document.querySelectorAll('.project-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filterValue = this.getAttribute('data-filter');
                
                // Filter projects
                projectItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 100);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Add hover effect to cards
        const cards = document.querySelectorAll('.futuristic-card');
        
        cards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Calculate rotation based on mouse position
                const rotateY = ((x / rect.width) - 0.5) * 5; // -2.5 to 2.5 degrees
                const rotateX = ((y / rect.height) - 0.5) * -5; // 2.5 to -2.5 degrees
                
                // Apply subtle 3D rotation
                this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px)`;
            });
            
            card.addEventListener('mouseleave', function() {
                // Reset transformation
                this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
            });
        });
    });
    </script>

    <!-- Research Impact Section -->
    <section class="research-impact section-padding">
        <div class="impact-bg-elements">
            <div class="impact-shape impact-shape-1"></div>
            <div class="impact-shape impact-shape-2"></div>
            <div class="grid-overlay"></div>
            <div class="glowing-orb orb-1"></div>
            <div class="glowing-orb orb-2"></div>
            <div class="glowing-orb orb-3"></div>
        </div>
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="section-header">
                        <span class="futuristic-badge"><i class="bi bi-bar-chart-line-fill me-2"></i>Our Impact</span>
                        <h2 class="section-title futuristic-title">Research That <span class="text-gradient">Transforms</span></h2>
                        <p class="section-subtitle">Our cutting-edge research is revolutionizing industries and communities, advancing knowledge and driving innovation for the future.</p>
                        <div class="title-underline"></div>
                    </div>
                    
                    <div class="impact-progress mt-5">
                        <div class="progress-item">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-title"><i class="bi bi-journal-text me-2"></i>Academic Publications</span>
                                <span class="progress-value glow-text">82%</span>
                            </div>
                            <div class="progress progress-animated" style="height: 8px;">
                                <div class="progress-bar progress-glow" role="progressbar" style="width: 82%;" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div class="progress-item mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-title"><i class="bi bi-quote me-2"></i>Research Citations</span>
                                <span class="progress-value glow-text">91%</span>
                            </div>
                            <div class="progress progress-animated" style="height: 8px;">
                                <div class="progress-bar progress-glow" role="progressbar" style="width: 91%;" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div class="progress-item mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-title"><i class="bi bi-cash-coin me-2"></i>Research Grants Awarded</span>
                                <span class="progress-value glow-text">75%</span>
                            </div>
                            <div class="progress progress-animated" style="height: 8px;">
                                <div class="progress-bar progress-glow" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div class="progress-item mt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="progress-title"><i class="bi bi-building me-2"></i>Industry Partnerships</span>
                                <span class="progress-value glow-text">88%</span>
                            </div>
                            <div class="progress progress-animated" style="height: 8px;">
                                <div class="progress-bar progress-glow" role="progressbar" style="width: 88%;" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <a href="Research_page.php" class="btn btn-primary btn-glow">
                            <span class="btn-icon-wrapper"><i class="bi bi-file-earmark-bar-graph"></i></span>
                            <span>View Detailed Impact Reports</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
                    <div class="impact-chart-container glassmorphism">
                        <div class="chart-header">
                            <h4>Research Growth Trends</h4>
                            <div class="chart-controls">
                                <button class="chart-control-btn active" data-view="all">All Data</button>
                                <button class="chart-control-btn" data-view="publications">Publications</button>
                                <button class="chart-control-btn" data-view="citations">Citations</button>
                                <button class="chart-control-btn" data-view="funding">Funding</button>
                            </div>
                            <div class="chart-legend">
                                <span><i class="legend-dot publications-dot"></i> Publications</span>
                                <span><i class="legend-dot citations-dot"></i> Citations</span>
                                <span><i class="legend-dot funding-dot"></i> Funding</span>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="researchImpactChart"></canvas>
                            <div class="chart-glow-effect"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 mt-5" data-aos="fade-up" data-aos-delay="400">
                    <div class="impact-highlights">
                        <div class="highlight-item glassmorphism">
                            <div class="highlight-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div class="highlight-content">
                                <h4 class="counter-value" data-count="85">0</h4>
                                <p>Publications</p>
                            </div>
                        </div>
                        <div class="highlight-item glassmorphism">
                            <div class="highlight-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="highlight-content">
                                <h4 class="counter-value" data-count="36">0</h4>
                                <p>Industry Partners</p>
                            </div>
                        </div>
                        <div class="highlight-item glassmorphism">
                            <div class="highlight-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="highlight-content">
                                <h4 class="counter-value" data-count="42">0</h4>
                                <p>Awards Received</p>
                            </div>
                        </div>
                        <div class="highlight-item glassmorphism">
                            <div class="highlight-icon">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div class="highlight-content">
                                <h4 class="counter-value" data-count="12.5">0</h4>
                                <span class="counter-suffix">M</span>
                                <p>Research Funding</p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Faculty Spotlight Section -->
    <section class="faculty-spotlight section-padding bg-light position-relative">
        <div class="faculty-bg-pattern"></div>
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-header text-center">
                    <span class="section-tag">Meet Our Researchers</span>
                    <h2 class="section-title">Faculty Spotlight</h2>
                    <p class="section-subtitle mx-auto">Meet the brilliant minds behind our ground-breaking research projects driving innovation and discovery.</p>
                </div>
            </div>
            
            <div class="faculty-slider" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <!-- Faculty Member 1 -->
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <div class="faculty-card">
                            <div class="faculty-img-container">
                                <img src="assets/resources/faculty1.jpg" alt="Dr. Emily Chen" class="img-fluid">
                                <div class="faculty-social">
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-google"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                </div>
                            </div>
                            <div class="faculty-info">
                                <h5>Dr. Emily Chen</h5>
                                <p class="faculty-position">Professor of Computer Science</p>
                                <p class="faculty-specialty">AI & Machine Learning</p>
                                <div class="faculty-quote">
                                    <q>Our research aims to make AI accessible and beneficial for real-world applications.</q>
                                </div>
                                <a href="Faculty_Page.php" class="faculty-link">View Profile <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="faculty-indicator">
                                <span class="indicator-dot"></span>
                                <span class="indicator-line"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Faculty Member 2 -->
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <div class="faculty-card">
                            <div class="faculty-img-container">
                                <img src="assets/resources/faculty2.jpg" alt="Dr. James Wilson" class="img-fluid">
                                <div class="faculty-social">
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-google"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                </div>
                            </div>
                            <div class="faculty-info">
                                <h5>Dr. James Wilson</h5>
                                <p class="faculty-position">Associate Professor</p>
                                <p class="faculty-specialty">Quantum Computing</p>
                                <div class="faculty-quote">
                                    <q>Quantum computing will revolutionize how we process complex data and solve once impossible problems.</q>
                                </div>
                                <a href="Faculty_Page.php" class="faculty-link">View Profile <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="faculty-indicator">
                                <span class="indicator-dot"></span>
                                <span class="indicator-line"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Faculty Member 3 -->
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <div class="faculty-card">
                            <div class="faculty-img-container">
                                <img src="assets/resources/faculty3.jpg" alt="Dr. Sophia Rahman" class="img-fluid">
                                <div class="faculty-social">
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-google"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                </div>
                            </div>
                            <div class="faculty-info">
                                <h5>Dr. Sophia Rahman</h5>
                                <p class="faculty-position">Research Director</p>
                                <p class="faculty-specialty">Biotechnology</p>
                                <div class="faculty-quote">
                                    <q>Our biotech research focuses on sustainable solutions to global health challenges.</q>
                                </div>
                                <a href="Faculty_Page.php" class="faculty-link">View Profile <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="faculty-indicator">
                                <span class="indicator-dot"></span>
                                <span class="indicator-line"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Faculty Member 4 -->
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <div class="faculty-card">
                            <div class="faculty-img-container">
                                <img src="assets/resources/faculty4.jpg" alt="Dr. Michael Baker" class="img-fluid">
                                <div class="faculty-social">
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                    <a href="#"><i class="bi bi-google"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                </div>
                            </div>
                            <div class="faculty-info">
                                <h5>Dr. Michael Baker</h5>
                                <p class="faculty-position">Assistant Professor</p>
                                <p class="faculty-specialty">Renewable Energy</p>
                                <div class="faculty-quote">
                                    <q>Our energy research aims to develop scalable solutions for a sustainable future.</q>
                                </div>
                                <a href="Faculty_Page.php" class="faculty-link">View Profile <i class="bi bi-arrow-right"></i></a>
                            </div>
                            <div class="faculty-indicator">
                                <span class="indicator-dot"></span>
                                <span class="indicator-line"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="Faculty_Page.php" class="btn btn-outline-primary">Meet All Faculty Members <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="events-section section-padding">
        <div class="events-bg-element"></div>
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="section-header">
                        <span class="section-tag">Upcoming Events</span>
                        <h2 class="section-title">Research Events & Opportunities</h2>
                        <p class="section-subtitle">Stay informed about research symposiums, conferences, workshops, and networking opportunities.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end d-flex align-items-center justify-content-lg-end" data-aos="fade-left">
                    <a href="#" class="btn btn-outline-primary">View Full Calendar <i class="bi bi-calendar-event ms-2"></i></a>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Event 1 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="event-card">
                        <div class="event-date">
                            <span class="event-day">15</span>
                            <span class="event-month">DEC</span>
                            <div class="event-date-decoration"></div>
                        </div>
                        <div class="event-content">
                            <div class="event-tags">
                                <span>Conference</span>
                                <span>Research</span>
                            </div>
                            <h5 class="event-title">Annual Research Symposium</h5>
                            <div class="event-meta">
                                <span><i class="bi bi-clock"></i> 10:00 AM - 4:00 PM</span>
                                <span><i class="bi bi-geo-alt"></i> UIU Main Auditorium</span>
                            </div>
                            <p class="event-description">Join us for presentations from leading researchers across multiple disciplines, networking opportunities, and research showcases.</p>
                            <a href="#" class="event-link">
                                Register Now <i class="bi bi-arrow-right"></i>
                            </a>
                            <div class="event-indicator"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Event 2 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="event-card">
                        <div class="event-date">
                            <span class="event-day">22</span>
                            <span class="event-month">DEC</span>
                            <div class="event-date-decoration"></div>
                        </div>
                        <div class="event-content">
                            <div class="event-tags">
                                <span>Workshop</span>
                                <span>AI</span>
                            </div>
                            <h5 class="event-title">AI Research Workshop</h5>
                            <div class="event-meta">
                                <span><i class="bi bi-clock"></i> 2:00 PM - 5:00 PM</span>
                                <span><i class="bi bi-geo-alt"></i> Virtual Event</span>
                            </div>
                            <p class="event-description">A practical workshop on applying machine learning to research problems with hands-on training sessions and expert guidance.</p>
                            <a href="#" class="event-link">
                                Join Online <i class="bi bi-arrow-right"></i>
                            </a>
                            <div class="event-indicator"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Event 3 -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="event-card">
                        <div class="event-date">
                            <span class="event-day">10</span>
                            <span class="event-month">JAN</span>
                            <div class="event-date-decoration"></div>
                        </div>
                        <div class="event-content">
                            <div class="event-tags">
                                <span>Workshop</span>
                                <span>Funding</span>
                            </div>
                            <h5 class="event-title">Grant Writing Workshop</h5>
                            <div class="event-meta">
                                <span><i class="bi bi-clock"></i> 9:00 AM - 1:00 PM</span>
                                <span><i class="bi bi-geo-alt"></i> Science Building, Room 305</span>
                            </div>
                            <p class="event-description">Learn strategies for writing successful research grant proposals with feedback from experienced researchers and grant reviewers.</p>
                            <a href="#" class="event-link">
                                Register Now <i class="bi bi-arrow-right"></i>
                            </a>
                            <div class="event-indicator"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
  </section>

  <section class="bg-light py-5" id="faq-section">
    <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-tag">FAQ</span>
                <h2 class="section-title">Research Guidance</h2>
                <p class="section-subtitle mx-auto">Find answers to common questions about conducting research at UIU</p>
            </div>
      <div class="row mt-4">
        <div class="col-md-6">
                    <div class="accordion custom-accordion" id="faqAccordionLeft">
            <!-- FAQs will be dynamically added here -->
          </div>
        </div>
        <div class="col-md-6">
                    <div class="accordion custom-accordion" id="faqAccordionRight">
            <!-- FAQs will be dynamically added here -->
          </div>
        </div>
      </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary">Ask a Question <i class="bi bi-question-circle ms-2"></i></a>
      </div>
    </div>
  </section>

    <footer class="footer bg-dark text-light py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-brand mb-4">
                        <img src="assets/resources/UIURP.png" alt="UIU Research Portal" class="footer-logo">
                    </div>
                    <p class="footer-tagline">Advancing knowledge through innovative research</p>
                    <div class="footer-social mt-4">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="Research_page.php">Research Projects</a></li>
                        <li><a href="Faculty_Page.php">Faculty</a></li>
                        <li><a href="#">Publications</a></li>
                        <li><a href="#">Resources</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h5 class="footer-heading">Resources</h5>
                    <ul class="footer-links">
                        <li><a href="#">Research Guidelines</a></li>
                        <li><a href="#">Funding Opportunities</a></li>
                        <li><a href="#">Labs & Facilities</a></li>
                        <li><a href="#">Research Ethics</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="footer-heading">Stay Updated</h5>
                    <p>Subscribe to our newsletter for the latest research news and events</p>
                    <div class="footer-newsletter">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email address" aria-label="Email address">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </div>
                    <p class="mt-3 small">By subscribing, you agree to our Privacy Policy</p>
                </div>
            </div>
            <div class="footer-bottom mt-4 pt-4 border-top border-secondary">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; 2025 UIU Research Portal. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <ul class="footer-bottom-links">
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    </div>
  </footer>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const searchBar = document.getElementById('search-bar');
      const keywordsList = document.getElementById('keywordsList');
      
      // Fetch and display the frequently searched keywords
      fetch('src/model/fetch_keywords.php')
          .then(response => response.json())
          .then(data => {
              // Save the popular label before clearing
              const popularLabel = keywordsList.querySelector('.popular-searches');
              keywordsList.innerHTML = '';
              
              // Re-add popular label
              if (popularLabel) {
                  keywordsList.appendChild(popularLabel);
              }
              
              data.forEach(keyword => {
                  const span = document.createElement('span');
                  span.textContent = keyword.name;
                  span.classList.add('keyword-tag');
                  span.addEventListener('click', () => {
                      searchBar.value = keyword.name;
                      handleSearch(keyword.name);
                  });
                  keywordsList.appendChild(span);
              });
          });

      // Handle search input
      searchBar.addEventListener('keypress', function(event) {
          if (event.key === 'Enter') {
              const searchString = searchBar.value.trim();
              if (searchString) {
                  handleSearch(searchString);
              }
          }
      });

      function handleSearch(searchString) {
          fetch('src/model/search_projects.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify({ searchString })
          })
          .then(response => response.json())
          .then(data => {
              // Redirect to Research_page.html with the search results
              localStorage.setItem('searchResults', JSON.stringify(data));
              window.location.href = 'Research_page.php';
          });
      }

      // Fetch and display the FAQs
      fetch('src/model/fetch_faqs.php')
          .then(response => response.json())
          .then(data => {
              const faqAccordionLeft = document.getElementById('faqAccordionLeft');
              const faqAccordionRight = document.getElementById('faqAccordionRight');
              faqAccordionLeft.innerHTML = '';
              faqAccordionRight.innerHTML = '';
              data.forEach((faq, index) => {
                  const accordionItem = document.createElement('div');
                  accordionItem.className = 'accordion-item m-4';
                  accordionItem.innerHTML = `
                      <h2 class="accordion-header" id="heading${index}">
                          <button class="accordion-button ${index !== 0 ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="${index === 0}" aria-controls="collapse${index}">
                              ${faq.question}
                          </button>
                      </h2>
                      <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" aria-labelledby="heading${index}">
                          <div class="accordion-body">
                              ${faq.answer}
                          </div>
                      </div>
                  `;
                  if (index % 2 === 0) {
                      faqAccordionLeft.appendChild(accordionItem);
                  } else {
                      faqAccordionRight.appendChild(accordionItem);
                  }
              });
          });

      // Fetch and apply the background image
      fetch('src/model/fetch_image.php?name=uiurp_homepage_background')
          .then(response => response.json())
          .then(data => {
              const searchSection = document.getElementById('search');
              if (data.url) {
                  searchSection.style.backgroundImage = `url('${data.url}')`;
                  searchSection.style.backgroundSize = 'cover';
                  searchSection.style.backgroundPosition = 'center';
              }
                });

            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: false,
                mirror: true,
                offset: 50
            });
            
            // Initialize stats counter
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const targetCount = parseInt(stat.getAttribute('data-count'), 10);
                let count = 0;
                const increment = Math.ceil(targetCount / 50);
                const interval = setInterval(() => {
                    count += increment;
                    if (count >= targetCount) {
                        count = targetCount;
                        clearInterval(interval);
                    }
                    stat.textContent = count;
                }, 30);
          });
  });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Preloader
        window.addEventListener('load', function() {
            document.querySelector('.preloader').classList.add('loaded');
            
            // Initialize particles.js
            if (typeof particlesJS !== 'undefined') {
                particlesJS('particles-js', {
                    "particles": {
                        "number": {
                            "value": 80,
                            "density": {
                                "enable": true,
                                "value_area": 800
                            }
                        },
                        "color": {
                            "value": "#4361ee"
                        },
                        "shape": {
                            "type": "circle"
                        },
                        "opacity": {
                            "value": 0.5,
                            "random": true
                        },
                        "size": {
                            "value": 3,
                            "random": true
                        },
                        "line_linked": {
                            "enable": true,
                            "distance": 150,
                            "color": "#7209b7",
                            "opacity": 0.4,
                            "width": 1
                        },
                        "move": {
                            "enable": true,
                            "speed": 2,
                            "direction": "none",
                            "random": true,
                            "straight": false,
                            "out_mode": "out",
                            "bounce": false
                        }
                    },
                    "interactivity": {
                        "detect_on": "canvas",
                        "events": {
                            "onhover": {
                                "enable": true,
                                "mode": "grab"
                            },
                            "onclick": {
                                "enable": true,
                                "mode": "push"
                            },
                            "resize": true
                        }
                    },
                    "retina_detect": true
                });
            }
        });

        // Initialize AOS animations
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 1000,
                    easing: 'ease-in-out',
                    once: true,
                    mirror: false
                });
            }
            
            // Initialize stats counter
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const targetCount = parseInt(stat.getAttribute('data-count'), 10);
                let count = 0;
                const increment = Math.ceil(targetCount / 50);
                const interval = setInterval(() => {
                    count += increment;
                    if (count >= targetCount) {
                        count = targetCount;
                        clearInterval(interval);
                    }
                    stat.textContent = count;
                }, 30);
            });
            
            // Initialize research impact chart
            if (typeof Chart !== 'undefined') {
                const ctx = document.getElementById('researchImpactChart');
                if (ctx) {
                    // Set Chart.js default options for futuristic look
                    Chart.defaults.font.family = "'Inter', 'Poppins', sans-serif";
                    Chart.defaults.color = "rgba(255, 255, 255, 0.8)";
                    
                    // Create advanced gradients with multiple color stops
                    const gradientPublication = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                    gradientPublication.addColorStop(0, 'rgba(67, 97, 238, 0.95)');
                    gradientPublication.addColorStop(0.5, 'rgba(67, 97, 238, 0.5)');
                    gradientPublication.addColorStop(1, 'rgba(67, 97, 238, 0.02)');
                    
                    const gradientCitation = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                    gradientCitation.addColorStop(0, 'rgba(114, 9, 183, 0.95)');
                    gradientCitation.addColorStop(0.5, 'rgba(114, 9, 183, 0.5)');
                    gradientCitation.addColorStop(1, 'rgba(114, 9, 183, 0.02)');
                    
                    const gradientFunding = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                    gradientFunding.addColorStop(0, 'rgba(76, 201, 240, 0.95)');
                    gradientFunding.addColorStop(0.5, 'rgba(76, 201, 240, 0.5)');
                    gradientFunding.addColorStop(1, 'rgba(76, 201, 240, 0.02)');
                    
                    // Glowing effects for points
                    const createPointStyles = (color) => {
                        return {
                            pointRadius: 6,
                            pointBackgroundColor: color,
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: color,
                            pointHoverBorderColor: '#ffffff',
                            pointHoverBorderWidth: 3,
                            pointShadowBlur: 10,
                            pointShadowColor: color
                        };
                    };
                    
                    // Dataset definitions with animation delays
                    const researchChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['2019', '2020', '2021', '2022', '2023'],
                            datasets: [
                                {
                                    label: 'Publications',
                                    data: [35, 45, 60, 75, 85],
                                    backgroundColor: gradientPublication,
                                    borderColor: 'rgba(67, 97, 238, 1)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    ...createPointStyles('#4361ee'),
                                    pointStyle: 'circle',
                                    cubicInterpolationMode: 'monotone',
                                    spanGaps: true
                                },
                                {
                                    label: 'Citations',
                                    data: [150, 210, 280, 350, 420],
                                    backgroundColor: gradientCitation,
                                    borderColor: 'rgba(114, 9, 183, 1)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    ...createPointStyles('#7209b7'),
                                    pointStyle: 'rectRounded',
                                    cubicInterpolationMode: 'monotone',
                                    spanGaps: true
                                },
                                {
                                    label: 'Research Funding ($M)',
                                    data: [2.5, 5.0, 7.5, 10.0, 12.5],
                                    backgroundColor: gradientFunding,
                                    borderColor: 'rgba(76, 201, 240, 1)',
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    ...createPointStyles('#4cc9f0'),
                                    pointStyle: 'star',
                                    cubicInterpolationMode: 'monotone',
                                    spanGaps: true
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: true,
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleFont: {
                                        size: 14,
                                        weight: 'bold',
                                        family: "'Inter', sans-serif"
                                    },
                                    bodyFont: {
                                        size: 13,
                                        family: "'Inter', sans-serif"
                                    },
                                    borderColor: 'rgba(255, 255, 255, 0.2)',
                                    borderWidth: 1,
                                    displayColors: true,
                                    boxPadding: 8,
                                    cornerRadius: 8,
                                    padding: 12,
                                    usePointStyle: true,
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                if (context.dataset.label === 'Research Funding ($M)') {
                                                    label += '$' + context.parsed.y + 'M';
                                                } else {
                                                    label += context.parsed.y;
                                                }
                                            }
                                            return label;
                                        },
                                        labelTextColor: function(context) {
                                            return context.dataset.borderColor;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.05)',
                                        borderDash: [5, 5],
                                        drawBorder: false,
                                        tickLength: 0
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        },
                                        padding: 10,
                                        color: 'rgba(255, 255, 255, 0.7)'
                                    },
                                    border: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(255, 255, 255, 0.05)',
                                        borderDash: [5, 5],
                                        drawBorder: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        },
                                        padding: 10,
                                        color: 'rgba(255, 255, 255, 0.7)',
                                        callback: function(value, index, values) {
                                            if (Math.floor(value) === value)
                                                return value;
                                        }
                                    },
                                    border: {
                                        display: false
                                    }
                                }
                            },
                            elements: {
                                line: {
                                    borderWidth: 3,
                                    borderCapStyle: 'rounded'
                                },
                                point: {
                                    hitRadius: 10,
                                    hoverRadius: 10
                                }
                            },
                            animation: {
                                duration: 2500,
                                easing: 'easeOutCirc',
                                delay: (context) => {
                                    return context.datasetIndex * 300 + context.dataIndex * 100;
                                }
                            },
                            layout: {
                                padding: {
                                    top: 20,
                                    right: 20,
                                    bottom: 20,
                                    left: 20
                                }
                            }
                        }
                    });
                }
            }
            
            // Initialize all counter animations
            const counterValues = document.querySelectorAll('.counter-value');
            counterValues.forEach(counter => {
                const targetCount = parseFloat(counter.getAttribute('data-count'));
                let count = 0;
                const suffix = counter.nextElementSibling?.classList.contains('counter-suffix') ? counter.nextElementSibling.textContent : '';
                const decimal = targetCount % 1 !== 0;
                const increment = decimal ? targetCount / 50 : Math.ceil(targetCount / 50);
                const duration = 2000; // 2 seconds
                const interval = duration / 50;
                
                const counterAnimation = setInterval(() => {
                    count += increment;
                    if (count >= targetCount) {
                        count = targetCount;
                        clearInterval(counterAnimation);
                    }
                    counter.textContent = decimal ? count.toFixed(1) : Math.floor(count);
                }, interval);
            });
            
            // Chart view controls functionality
            const chartControls = document.querySelectorAll('.chart-control-btn');
            if (chartControls.length && researchChart) {
                chartControls.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // Remove active class from all buttons
                        chartControls.forEach(b => b.classList.remove('active'));
                        
                        // Add active class to clicked button
                        btn.classList.add('active');
                        
                        // Get the view type
                        const viewType = btn.getAttribute('data-view');
                        
                        // Update chart based on view type
                        updateChartView(viewType);
                    });
                });
                
                // Function to update chart view
                function updateChartView(viewType) {
                    // Show all datasets by default
                    researchChart.data.datasets.forEach((dataset, index) => {
                        researchChart.setDatasetVisibility(index, true);
                    });
                    
                    // Apply specific view settings
                    if (viewType === 'publications') {
                        researchChart.setDatasetVisibility(1, false); // Hide citations
                        researchChart.setDatasetVisibility(2, false); // Hide funding
                    } else if (viewType === 'citations') {
                        researchChart.setDatasetVisibility(0, false); // Hide publications
                        researchChart.setDatasetVisibility(2, false); // Hide funding
                    } else if (viewType === 'funding') {
                        researchChart.setDatasetVisibility(0, false); // Hide publications
                        researchChart.setDatasetVisibility(1, false); // Hide citations
                    }
                    
                    // Apply animation
                    researchChart.update('active');
                    
                    // Add special visual effects
                    const chartContainer = document.querySelector('.impact-chart-container');
                    chartContainer.classList.add('updating');
                    setTimeout(() => {
                        chartContainer.classList.remove('updating');
                    }, 700);
                }
                
                // Add hover interaction to improve chart user experience
                const chartCanvas = document.getElementById('researchImpactChart');
                if (chartCanvas) {
                    chartCanvas.addEventListener('mousemove', (e) => {
                        const rect = chartCanvas.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        
                        // Create ripple effect on hover
                        const glowEffect = document.querySelector('.chart-glow-effect');
                        if (glowEffect) {
                            glowEffect.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(76, 201, 240, 0.1) 0%, rgba(15, 23, 42, 0) 70%)`;
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>