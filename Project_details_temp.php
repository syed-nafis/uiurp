<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Performance optimization styles -->
    <link rel="stylesheet" href="assets/styles/performance.css">
    
    <!-- Performance optimization script - Load early for immediate optimizations -->
    <script src="assets/js/performance-optimizer.js" defer></script>
    
    <!-- Prevent Theme Flash Script - Must run immediately -->
    <script>
    (function() {
        // Get saved theme immediately to prevent flash
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        }
    })();
    </script>
    
    <style>
        :root {
            /* Darker Professional Color Palette */
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary-color: #7c3aed;
            --accent-color: #0284c7;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            
            /* Darker Background Colors */
            --dark-bg: #020617;
            --card-bg: rgba(15, 23, 42, 0.9);
            --glass-bg: rgba(30, 41, 59, 0.2);
            --light-bg: #f1f5f9;
            
            /* Darker Text Colors */
            --text-primary: #e2e8f0;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --text-dark: #0f172a;
            
            /* Effects */
            --transition-speed: 0.3s;
            --transition-ease: cubic-bezier(0.4, 0, 0.2, 1);
            --card-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
            --card-shadow-hover: 0 20px 40px -4px rgba(0, 0, 0, 0.4), 0 8px 16px -4px rgba(0, 0, 0, 0.3);
            --glow-primary: 0 0 20px rgba(30, 64, 175, 0.2);
            --glow-accent: 0 0 20px rgba(2, 132, 199, 0.2);
            
            /* Spacing */
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --spacing-xl: 32px;
            --spacing-2xl: 48px;
            --spacing-3xl: 64px;
        }
        
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, #0f172a 50%, #1e293b 100%);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.6;
            font-weight: 400;
            overflow-x: hidden;
            position: relative;
        }
        
        /* Enhanced background with animated gradient */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(30, 64, 175, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(124, 58, 237, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(2, 132, 199, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            animation: backgroundShift 20s ease-in-out infinite;
        }
        
        @keyframes backgroundShift {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        /* Futuristic glowing elements */
        .glow-effect {
            position: relative;
            overflow: hidden;
        }
        
        .glow-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, 
                rgba(76, 201, 240, 0.15) 0%, 
                rgba(76, 201, 240, 0) 70%);
            opacity: 0;
            transition: opacity 1s ease;
            pointer-events: none;
            z-index: 0;
        }
        
        .glow-effect:hover::after {
            opacity: 1;
            animation: pulse-subtle 3s infinite ease-in-out;
        }
        
        @keyframes pulse-subtle {
            0% { opacity: 0.1; }
            50% { opacity: 0.3; }
            100% { opacity: 0.1; }
        }
        
        /* Enhanced focus effect for interactive elements */
        a:focus, button:focus, input:focus, textarea:focus, select:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(58, 134, 255, 0.5), 0 0 15px rgba(76, 201, 240, 0.3);
        }
        
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Animated text link underlines */
        a.text-link {
            position: relative;
            color: var(--primary-color);
            text-decoration: none;
            padding-bottom: 2px;
        }
        
        a.text-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transition: width 0.3s cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        a.text-link:hover::after {
            width: 100%;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            color: #e2e8f0;
            letter-spacing: -0.02em;
        }
        
        .project-header {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            margin-bottom: var(--spacing-xl);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) var(--transition-ease);
            position: relative;
            overflow: hidden;
        }
        
        .project-header:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateY(-8px);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        .project-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(30, 64, 175, 0.03) 0%, 
                rgba(124, 58, 237, 0.03) 50%,
                rgba(2, 132, 199, 0.03) 100%);
            z-index: 0;
            transition: opacity var(--transition-speed) var(--transition-ease);
        }
        
        .project-header:hover::before {
            opacity: 1.5;
        }
        
        /* Animated border effect */
        .project-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, 
                var(--primary-color), 
                var(--accent-color), 
                var(--secondary-color));
            background-size: 200% 100%;
            animation: borderFlow 3s ease-in-out infinite;
            z-index: 1;
        }
        
        @keyframes borderFlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .project-header h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            background: linear-gradient(135deg, 
                var(--text-primary) 0%, 
                var(--primary-color) 50%, 
                var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: titleGradient 4s ease-in-out infinite;
            margin-bottom: var(--spacing-md);
            position: relative;
            z-index: 2;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        
        @keyframes titleGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .project-header .meta-item {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
            position: relative;
            z-index: 2;
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        .project-header .meta-item i {
            color: var(--accent-color);
            margin-right: var(--spacing-sm);
            font-size: 1.2rem;
            filter: drop-shadow(0 0 4px rgba(2, 132, 199, 0.3));
        }
        
        .project-header .status-badge {
            position: relative;
            z-index: 2;
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 50px;
            font-weight: 600;
            box-shadow: var(--card-shadow);
            display: inline-flex;
            align-items: center;
            margin-right: var(--spacing-md);
            font-size: 0.875rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all var(--transition-speed) var(--transition-ease);
            backdrop-filter: blur(10px);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .project-header .status-badge i {
            margin-right: var(--spacing-xs);
            font-size: 1rem;
        }
        
        .project-header .status-badge.bg-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1)) !important;
            border-color: var(--success-color);
            color: var(--success-color) !important;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }
        
        .project-header .status-badge.bg-warning {
            background: linear-gradient(135deg, rgba(217, 119, 6, 0.2), rgba(217, 119, 6, 0.1)) !important;
            border-color: rgba(217, 119, 6, 0.4);
            color: #fbbf24 !important;
        }
        
        .project-header .status-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .project-header .privacy-toggle {
            border-radius: 4px;
            font-weight: 500;
            padding: 0.35rem 0.8rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
            display: inline-flex;
            align-items: center;
            font-size: 0.85rem;
            position: relative;
            overflow: hidden;
            border: 1px solid;
            z-index: 1;
        }
        
        .project-header .privacy-toggle:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0), 
                rgba(255, 255, 255, 0.1), 
                rgba(255, 255, 255, 0));
            transition: transform 0.8s ease;
            z-index: -1;
        }
        
        .project-header .privacy-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .project-header .privacy-toggle:hover:before {
            transform: translateX(100%);
        }
        
        .project-header .privacy-toggle i {
            margin-right: 0.4rem;
            font-size: 0.9rem;
        }
        
        .btn-outline-warning {
            color: #fbbf24 !important;
            border-color: rgba(217, 119, 6, 0.4);
            background: rgba(217, 119, 6, 0.1);
        }
        
        .btn-outline-success {
            color: #10b981 !important;
            border-color: rgba(5, 150, 105, 0.4);
            background: rgba(5, 150, 105, 0.1);
        }
        
        .project-header .divider {
            height: 1px;
            background: linear-gradient(to right, rgba(0,0,0,0.05), rgba(0,0,0,0.1), rgba(0,0,0,0.05));
            margin: 1.5rem 0;
            position: relative;
            z-index: 1;
        }
        
        .project-header .section-row {
            position: relative;
            z-index: 1;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
        }
        }
        
        .metadata-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: var(--spacing-xl);
            margin-bottom: var(--spacing-lg);
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) var(--transition-ease);
            position: relative;
            overflow: hidden;
        }
        
        .metadata-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            z-index: 1;
        }
        
        .metadata-card:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateY(-6px);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        .metadata-card h4 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: var(--spacing-lg);
            position: relative;
            z-index: 2;
        }
        
        .metadata-card p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: var(--spacing-sm);
            position: relative;
            z-index: 2;
        }
        
        .metadata-card i {
            color: var(--accent-color);
            filter: drop-shadow(0 0 4px rgba(2, 132, 199, 0.3));
        }
        
        .abstract-box {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            margin-bottom: var(--spacing-xl);
            font-style: normal;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
            line-height: 1.7;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed) var(--transition-ease);
            color: var(--text-secondary);
        }
        
        .abstract-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
            z-index: 1;
        }
        
        .abstract-box:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-accent);
            transform: translateY(-8px);
            border-color: rgba(124, 58, 237, 0.3);
        }
        
        .abstract-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                rgba(var(--primary-color), 0), 
                rgba(76, 201, 240, 0.5), 
                rgba(var(--primary-color), 0));
            z-index: 0;
        }
        
        .abstract-box::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, transparent 50%, rgba(var(--secondary-color-rgb, 102, 16, 242), 0.05) 100%);
            border-radius: 0 0 var(--border-radius) 0;
            z-index: 0;
        }
        
        .abstract-box h3 {
            position: relative;
            z-index: 2;
            margin-bottom: var(--spacing-lg);
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .abstract-box p {
            position: relative;
            z-index: 2;
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: var(--spacing-md);
            line-height: 1.7;
        }
        
        .abstract-highlight {
            color: var(--accent-color);
            font-weight: 600;
            text-shadow: 0 0 8px rgba(76, 201, 240, 0.5);
            padding: 0 2px;
        }
        
        /* Enhanced timeline styling with more polish */
        .timeline-container {
            position: relative;
            max-width: 100%;
            margin: 0;
            padding: var(--spacing-2xl) var(--spacing-md) var(--spacing-2xl) var(--spacing-2xl); /* Added right padding */
            overflow-x: hidden; /* Prevent horizontal overflow only */
            overflow-y: visible; /* Allow vertical effects like shadows */
            min-height: 200px;
        }
        
        /* Timeline central line with enhanced gradient and progress indicator - moved to left */
        .timeline-container::before {
            content: '';
            position: absolute;
            width: 6px;
            background: linear-gradient(to bottom, 
                var(--primary-color) 0%, 
                var(--accent-color) 30%,
                var(--secondary-color) 70%,
                var(--success-color) 100%);
            top: 0;
            bottom: 0;
            left: var(--spacing-lg);
            margin-left: 0;
            opacity: 1;
            box-shadow: 
                0 0 20px rgba(76, 201, 240, 0.8),
                0 0 40px rgba(76, 201, 240, 0.4),
                inset 0 0 5px rgba(255, 255, 255, 0.3);
            animation: timeline-glow 4s ease infinite;
            background-size: 100% 200%;
            border-radius: 3px;
            z-index: 1;
        }
        
        /* Add a progress line that fills as user scrolls - moved to left */
        .timeline-progress {
            position: absolute;
            width: 6px;
            background: linear-gradient(to bottom, 
                rgba(76, 201, 240, 0.9) 0%,
                rgba(14, 165, 233, 0.9) 50%,
                rgba(124, 58, 237, 0.9) 100%);
            top: 0;
            left: var(--spacing-lg);
            margin-left: 0;
            border-radius: 3px;
            z-index: 2;
            height: 0%;
            transition: height 0.3s ease;
            box-shadow: 0 0 30px rgba(76, 201, 240, 1);
        }
        
        .timeline-container::after {
            content: '';
            display: block;
            clear: both;
            height: 0;
        }
        
        @keyframes timeline-glow {
            0% {
                box-shadow: 0 0 15px rgba(76, 201, 240, 0.6), 0 0 30px rgba(76, 201, 240, 0.2);
            }
            50% {
                box-shadow: 0 0 25px rgba(76, 201, 240, 0.9), 0 0 50px rgba(76, 201, 240, 0.4);
            }
            100% {
                box-shadow: 0 0 15px rgba(76, 201, 240, 0.6), 0 0 30px rgba(76, 201, 240, 0.2);
            }
        }
        
        /* Animate gradient background of timeline */
        @keyframes gradient-flow {
            0% {
                background-position: 0% 0%;
                opacity: 0.8;
            }
            25% {
                opacity: 1;
            }
            50% {
                background-position: 100% 100%;
                opacity: 1;
            }
            75% {
                opacity: 0.9;
            }
            100% {
                background-position: 0% 0%;
                opacity: 0.8;
            }
        }
        
        /* Timeline item entry animations - all from right since they're all on right side */
        .timeline-left,
        .timeline-right {
            animation: slide-from-right 0.8s cubic-bezier(0.19, 1, 0.22, 1) both;
            animation-play-state: paused;
        }
        
        .timeline-item.aos-animate {
            animation-play-state: running;
        }
        
        @keyframes slide-from-right {
            from {
                opacity: 0;
                transform: translateX(80px) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }
        
        .timeline-item {
            padding: var(--spacing-md) var(--spacing-lg);
            position: relative;
            width: calc(100% - var(--spacing-2xl) - var(--spacing-lg) - var(--spacing-md)); /* Adjusted to account for container padding and margins */
            box-sizing: border-box;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: calc(var(--spacing-md) * 1.5);
        }
        
        .timeline-item:hover {
            transform: translateY(-8px) scale(1.02);
            z-index: 10;
        }
        
        .timeline-item:hover .timeline-content {
            transform: translateY(-3px);
        }
        
        /* Enhanced timeline nodes with status-based colors - positioned on left line */
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: 4px solid rgba(255, 255, 255, 1);
            border-radius: 50%;
            top: calc(var(--spacing-lg) + 8px);
            left: calc(-1 * var(--spacing-2xl) - var(--spacing-lg) - 12px);
            z-index: 10;
            box-shadow: 
                0 0 25px rgba(76, 201, 240, 0.9), 
                0 0 50px rgba(76, 201, 240, 0.3),
                inset 0 0 8px rgba(255, 255, 255, 0.4);
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        /* Status-based node colors */
        .timeline-item[data-status="completed"]::after {
            background: linear-gradient(135deg, var(--success-color), #10b981);
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.9), 0 0 50px rgba(16, 185, 129, 0.3);
        }
        
        .timeline-item[data-status="in-progress"]::after {
            background: linear-gradient(135deg, var(--warning-color), #f59e0b);
            box-shadow: 0 0 25px rgba(245, 158, 11, 0.9), 0 0 50px rgba(245, 158, 11, 0.3);
            animation: pulse-progress 2s infinite ease-in-out;
        }
        
        .timeline-item[data-status="pending"]::after {
            background: linear-gradient(135deg, var(--text-muted), #64748b);
            box-shadow: 0 0 25px rgba(100, 116, 139, 0.6), 0 0 50px rgba(100, 116, 139, 0.2);
        }
        
        @keyframes pulse-progress {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }
        
        .timeline-left::after {
            left: calc(-1 * var(--spacing-2xl) - var(--spacing-lg) - 12px);
        }
        
        .timeline-right::after {
            left: calc(-1 * var(--spacing-2xl) - var(--spacing-lg) - 12px);
        }
        
        .timeline-item:hover::after {
            transform: scale(1.3);
            box-shadow: 
                0 0 35px rgba(76, 201, 240, 1), 
                0 0 70px rgba(76, 201, 240, 0.6), 
                inset 0 0 12px rgba(255, 255, 255, 0.6);
            background: linear-gradient(135deg, var(--accent-color), var(--secondary-color));
            border-width: 3px;
            animation: intense-pulse 1.5s infinite ease-in-out;
        }
        
        @keyframes intense-pulse {
            0% { 
                box-shadow: 0 0 20px var(--primary-color), 0 0 40px rgba(76, 201, 240, 0.4); 
                transform: scale(1.3);
            }
            50% { 
                box-shadow: 0 0 40px var(--primary-color), 0 0 80px rgba(76, 201, 240, 0.7); 
                transform: scale(1.4);
            }
            100% { 
                box-shadow: 0 0 20px var(--primary-color), 0 0 40px rgba(76, 201, 240, 0.4); 
                transform: scale(1.3);
            }
        }
        
        /* Enhanced timeline connector lines with animations - all from left */
        .timeline-content::before {
            content: '';
            position: absolute;
            top: calc(var(--spacing-lg) + 4px);
            width: 0;
            height: 3px;
            left: calc(-1 * var(--spacing-2xl) - 8px);
            z-index: 5;
            transform: translateY(8px);
            transition: width 0.6s ease-out 0.3s;
            background: linear-gradient(to right, var(--primary-color), rgba(30, 64, 175, 0.3));
            box-shadow: 0 0 10px rgba(30, 64, 175, 0.6);
        }
        
        .timeline-item.aos-animate .timeline-content::before {
            width: var(--spacing-xl);
        }
        
        .timeline-left .timeline-content::before {
            left: calc(-1 * var(--spacing-2xl) - 8px);
            background: linear-gradient(to right, var(--primary-color), rgba(30, 64, 175, 0.3));
            box-shadow: 0 0 10px rgba(30, 64, 175, 0.6);
        }
        
        .timeline-right .timeline-content::before {
            left: calc(-1 * var(--spacing-2xl) - 8px);
            background: linear-gradient(to right, var(--secondary-color), rgba(124, 58, 237, 0.3));
            box-shadow: 0 0 10px rgba(124, 58, 237, 0.6);
        }
        
        /* Enhanced timeline content styling */
        .timeline-content {
            padding: var(--spacing-xl) var(--spacing-2xl);
            background: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
            position: relative;
            overflow: visible;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: var(--spacing-md);
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            max-width: none; /* Remove any max-width constraints */
            box-sizing: border-box;
            cursor: pointer;
            text-align: left;
            align-items: flex-start;
            border-left: 5px solid var(--primary-color);
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(30, 64, 175, 0.05) 100%);
        }
        
        .timeline-content:hover {
            box-shadow: 
                var(--card-shadow-hover), 
                var(--glow-primary),
                0 0 40px rgba(76, 201, 240, 0.2);
            transform: translateY(-6px) scale(1.02);
            border-left-width: 6px;
            background: var(--card-bg);
        }
        
        /* Enhanced timeline content layout */
        .timeline-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: var(--spacing-md);
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }
        
        .timeline-left .timeline-title-row {
            flex-direction: row-reverse;
        }
        
        /* Add a subtle glow effect behind content */
        .timeline-content::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, 
                rgba(76, 201, 240, 0.1) 0%,
                rgba(124, 58, 237, 0.1) 50%,
                rgba(76, 201, 240, 0.1) 100%);
            border-radius: var(--border-radius-lg);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .timeline-content:hover::after {
            opacity: 1;
        }
        
        /* Enhanced timeline title styling */
        .timeline-title {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: var(--spacing-xs);
            transition: all 0.3s ease;
            flex-direction: row;
            text-align: left;
        }
        
        .timeline-title:hover {
            color: var(--accent-color);
            text-shadow: 0 0 8px rgba(76, 201, 240, 0.5);
        }
        
        .timeline-title .timeline-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            color: white;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.5);
            order: -1;
        }
        
        .timeline-title-text {
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        
        .timeline-content:hover .timeline-icon {
            transform: scale(1.2) rotate(10deg);
            box-shadow: 0 0 25px rgba(76, 201, 240, 0.8);
            background: linear-gradient(135deg, var(--accent-color), var(--secondary-color));
        }
        
        /* Enhanced timeline description text and date */
        .timeline-content p {
            margin: 0;
            color: var(--text-secondary);
            line-height: 1.6;
            font-size: 0.95rem;
            font-weight: 400;
            transition: color 0.3s ease;
            flex-grow: 1;
        }
        
        .timeline-content:hover p {
            color: var(--text-primary);
        }
        
        .timeline-date {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: var(--spacing-sm);
            padding: var(--spacing-xs) var(--spacing-sm);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            width: fit-content;
            margin-left: 0;
        }
        
        .timeline-content:hover .timeline-date {
            background: rgba(76, 201, 240, 0.15);
            color: var(--accent-color);
            border-color: rgba(76, 201, 240, 0.3);
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.2);
        }
        
        .timeline-date i {
            font-size: 0.8rem;
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        
        .timeline-content:hover .timeline-date i {
            opacity: 1;
            transform: scale(1.1);
        }
        
        /* Enhanced status badges */
        .timeline-status {
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .timeline-status::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .timeline-content:hover .timeline-status::before {
            left: 100%;
        }
        
        .timeline-content:hover .timeline-status {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(76, 201, 240, 0.3);
        }
        
        /* Timeline marker label enhancements */
        .timeline-marker-label {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--card-bg), rgba(15, 23, 42, 0.95));
            padding: var(--spacing-sm) var(--spacing-lg);
            border-radius: var(--border-radius);
            font-size: 0.85rem;
            color: var(--text-secondary);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            box-shadow: var(--card-shadow);
            z-index: 20;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .timeline-marker-label:hover {
            background: var(--card-bg);
            color: var(--text-primary);
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateX(-50%) translateY(-2px);
        }
        
        .timeline-left .timeline-content {
            text-align: right;
        }
        
        .timeline-right .timeline-content {
            text-align: left;
        }
        
        /* Professional spacing for timeline items */
        .timeline-item:first-child {
            margin-top: var(--spacing-xl);
        }
        
        .timeline-item:last-child {
            margin-bottom: var(--spacing-xl);
        }
        
        /* Enhanced start/end labels */
        .timeline-start-label {
            top: -10px;
            color: var(--success-color);
        }
        
        .timeline-start-label strong {
            color: var(--success-color);
        }
        
        .timeline-end-label {
            bottom: -10px;
            color: var(--warning-color);
        }
        
        .timeline-end-label strong {
            color: var(--warning-color);
        }
        
        /* Progress percentage indicator */
        .timeline-progress-indicator {
            position: sticky;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--card-bg), rgba(15, 23, 42, 0.95));
            border: 2px solid rgba(76, 201, 240, 0.3);
            border-radius: 50px;
            padding: var(--spacing-sm) var(--spacing-lg);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent-color);
            backdrop-filter: blur(15px);
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.2),
                0 0 20px rgba(76, 201, 240, 0.2);
            z-index: 30;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .timeline-progress-indicator:hover {
            background: var(--card-bg);
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.3),
                0 0 30px rgba(76, 201, 240, 0.4);
            transform: translateX(-50%) scale(1.05);
        }
        
        /* Mobile responsiveness improvements */
        @media (max-width: 768px) {
            .timeline-container {
                padding: var(--spacing-lg) var(--spacing-xs) var(--spacing-lg) var(--spacing-lg); /* Added right padding */
            }
            
            .timeline-container::before {
                left: var(--spacing-md);
            }
            
            .timeline-progress {
                left: var(--spacing-md);
            }
            
            .timeline-item {
                width: calc(100% - var(--spacing-xl) - var(--spacing-xs)); /* Account for right padding */
                margin-left: calc(var(--spacing-lg) + var(--spacing-md));
            }
            
            .timeline-item::after {
                left: calc(-1 * var(--spacing-lg) - var(--spacing-md) - 12px);
            }
            
            .timeline-content {
                padding: var(--spacing-lg);
            }
            
            .timeline-content::before {
                left: calc(-1 * var(--spacing-lg) - 8px);
            }
            
            .timeline-progress-indicator {
                position: relative;
                right: auto;
                top: auto;
                margin-bottom: var(--spacing-lg);
                transform: none;
            }
            
            .timeline-marker-label {
                left: var(--spacing-md);
                transform: translateX(0);
                font-size: 0.75rem;
                padding: var(--spacing-xs) var(--spacing-sm);
            }
        
            .timeline-start-label {
                top: 5px;
            }
        
            .timeline-end-label {
                bottom: 5px;
            }
        }
        
        /* Extra small screens */
        @media (max-width: 576px) {
            .timeline-container {
                padding: var(--spacing-md) var(--spacing-xs) var(--spacing-md) var(--spacing-sm); /* Added right padding */
            }
            
            .timeline-container::before {
                left: var(--spacing-sm);
            }
            
            .timeline-progress {
                left: var(--spacing-sm);
            }
        
            .timeline-item {
                width: calc(100% - var(--spacing-lg) - var(--spacing-xs)); /* Account for right padding */
                margin-left: calc(var(--spacing-md) + var(--spacing-sm));
            }
        
            .timeline-item::after {
                left: calc(-1 * var(--spacing-md) - var(--spacing-sm) - 12px);
            }
        
            .timeline-content {
                padding: var(--spacing-md);
            }
        
            .timeline-content::before {
                left: calc(-1 * var(--spacing-md) - 8px);
            }
            
            .timeline-marker-label {
                left: var(--spacing-sm);
            }
        }
        
        /* Add completion celebration animation */
        .timeline-item[data-status="completed"] {
            animation: completion-glow 3s ease-in-out infinite;
        }
        
        @keyframes completion-glow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.1); }
        }
        
        /* Timeline connector lines */
        .timeline-left .timeline-content::before,
        .timeline-right .timeline-content::before {
            content: '';
            position: absolute;
            top: var(--spacing-lg);
            width: var(--spacing-lg);
            height: 2px;
            z-index: 5;
            transform: translateY(6px);
        }
        
        .timeline-left .timeline-content::before {
            right: -24px;
            background: linear-gradient(to right, var(--primary-color), transparent);
        }
        
        .timeline-right .timeline-content::before {
            left: -24px;
            background: linear-gradient(to left, var(--secondary-color), transparent);
        }
        
        /* Enhanced timeline content styling */
        .timeline-content {
            padding: var(--spacing-lg) var(--spacing-xl);
            background: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
            position: relative;
            overflow: visible;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: var(--spacing-md);
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            box-sizing: border-box;
        }
        
        .timeline-left .timeline-content {
            text-align: right;
            border-left: 4px solid var(--primary-color);
            margin-right: 0; /* Remove right margin to extend to edge */
            margin-left: 0;
            align-items: flex-end;
        }
        
        .timeline-right .timeline-content {
            text-align: left;
            border-left: 4px solid var(--secondary-color);
            margin-left: 0; /* Remove left margin conflicts */
            margin-right: 0; /* Remove right margin to extend to edge */
            align-items: flex-start;
        }
        
        .timeline-content:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateY(-4px);
            border-left-width: 5px;
        }
        
        /* Timeline content layout */
        .timeline-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: var(--spacing-sm);
            flex-wrap: wrap;
            gap: var(--spacing-xs);
        }
        
        .timeline-left .timeline-title-row {
            flex-direction: row-reverse;
        }
        
        .timeline-content::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.4) 100%);
            pointer-events: none;
        }
        
        /* Timeline title styling */
        .timeline-title {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff !important;
            position: relative;
            line-height: 1.4;
            width: 100%;
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }
        
        .timeline-left .timeline-title {
            justify-content: flex-end;
            text-align: right;
        }
        
        .timeline-right .timeline-title {
            justify-content: flex-start;
            text-align: left;
        }
        
        .timeline-title .timeline-icon {
            font-size: 1.1rem;
            color: var(--accent-color);
            transition: all var(--transition-speed) ease;
            filter: drop-shadow(0 0 4px rgba(76, 201, 240, 0.5));
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(76, 201, 240, 0.1);
            border-radius: 50%;
            border: 1px solid rgba(76, 201, 240, 0.3);
        }
        
        .timeline-title-text {
            flex: 1;
            min-width: 0;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .timeline-content:hover .timeline-icon {
            transform: scale(1.1) rotate(5deg);
            filter: drop-shadow(0 0 8px rgba(76, 201, 240, 0.8));
        }
        
        .timeline-right .timeline-title .timeline-icon {
            color: var(--secondary-color);
            filter: drop-shadow(0 0 4px rgba(124, 58, 237, 0.5));
        }
        
        /* Enhanced timeline description text and date */
        .timeline-content p {
            font-size: 0.95rem;
            line-height: 1.6;
            margin: var(--spacing-sm) 0;
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0;
            flex-grow: 1;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }
        
        .timeline-date {
            display: inline-flex;
            align-items: center;
            margin-top: var(--spacing-xs);
            font-size: 0.8rem;
            color: #ffffff !important;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.3), rgba(2, 132, 199, 0.2));
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: 15px;
            position: relative;
            font-weight: 600;
            transition: all var(--transition-speed) ease;
            border: 1px solid rgba(76, 201, 240, 0.3);
            backdrop-filter: blur(10px);
            align-self: flex-start;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .timeline-left .timeline-date {
            align-self: flex-end;
        }
        
        .timeline-content:hover .timeline-date {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.5), rgba(2, 132, 199, 0.4));
            color: #ffffff !important;
            box-shadow: 0 0 10px rgba(76, 201, 240, 0.4);
            transform: translateY(-1px);
        }
        
        .timeline-date i {
            margin-right: var(--spacing-xs);
            font-size: 0.8rem;
            color: var(--accent-color);
            filter: drop-shadow(0 0 2px rgba(76, 201, 240, 0.5));
            flex-shrink: 0;
        }
        
        /* Status badge improvements */
        .timeline-status {
            display: inline-flex;
            align-items: center;
            padding: var(--spacing-xs) var(--spacing-sm);
            font-size: 0.7rem;
            border-radius: 12px;
            font-weight: 600;
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all var(--transition-speed) ease;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .timeline-content:hover .timeline-status {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        
        /* Timeline marker label enhancements */
        .timeline-marker-label {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: var(--card-bg);
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: 10px;
            font-size: 0.75rem;
            box-shadow: var(--card-shadow);
            z-index: 15;
            text-align: center;
            white-space: nowrap;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
            font-weight: 600;
            color: #ffffff !important;
            backdrop-filter: blur(20px);
        }
        
        .timeline-marker-label:hover {
            transform: translateX(-50%) translateY(-2px);
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            border-color: rgba(76, 201, 240, 0.4);
        }
        
        /* Ensure consistent alignment and spacing */
        .timeline-left .timeline-content {
            max-width: none; /* Remove max-width constraint to allow full width */
        }
        
        .timeline-right .timeline-content {
            max-width: none; /* Remove max-width constraint to allow full width */
        }
        
        /* Professional spacing for timeline items */
        .timeline-item:first-child {
            margin-top: var(--spacing-2xl);
        }
        
        .timeline-item:last-child {
            margin-bottom: var(--spacing-2xl);
        }
        

        
        .timeline-start-label {
            top: 5px;
            border-left: 2px solid var(--primary-color);
        }
        
        .timeline-start-label strong {
            color: var(--primary-color);
        }
        
        .timeline-end-label {
            bottom: 20px; /* Position it farther from the end of the timeline line */
            border-left: 2px solid var(--accent-color);
            padding-bottom: 6px; /* Add a bit more padding for visual spacing */
        }
        
        .timeline-end-label strong {
            color: var(--accent-color);
        }
        
        /* Improved responsive layout for mobile */
        @media (max-width: 768px) {
            .timeline-container::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-left::after, 
            .timeline-right::after {
                left: 16px;
            }
            
            .timeline-right {
                left: 0;
            }
            
            .timeline-left::before,
            .timeline-right::before {
                width: 25px;
                top: 30px;
            }
            
            .timeline-left::before {
                left: 31px;
                background: linear-gradient(to right, var(--primary-color), transparent);
            }
            
            .timeline-right::before {
                left: 31px;
                background: linear-gradient(to right, var(--secondary-color), transparent);
            }
            
            .timeline-left .timeline-content,
            .timeline-right .timeline-content {
                text-align: left;
                transform: none;
            }
            
            .timeline-left .timeline-title {
                justify-content: flex-start;
            }
            
            .timeline-left .timeline-title .timeline-icon {
                order: 0;
                margin-left: 0;
                margin-right: 8px;
            }
            
            .timeline-left .timeline-status {
                margin-right: 0;
                margin-left: 8px;
            }
            
            .timeline-left .timeline-content:hover,
            .timeline-right .timeline-content:hover {
                transform: translateY(-3px);
            }
            
            .timeline-marker-label {
                left: 31px;
                transform: translateX(0);
                padding: 4px 10px;
            }
            
            .timeline-marker-label:hover {
                transform: translateX(0) translateY(-3px);
            }
            
            .timeline-start-label {
                top: 45px;
            }
            
            .timeline-end-label {
                bottom: 20px;
                left: 60px; /* Move it even further to the right to avoid overlapping */
                transform: translateX(0);
            }
            
            .timeline-container::before {
                left: 31px;
                margin-left: 0;
            }
            
            .timeline-end-marker {
                left: 31px;
                margin-left: 0;
            }
        }
        
        .timeline-end-marker {
            display: none; /* Hide the end marker instead of removing it completely to avoid breaking code */
        }
        
        /* Pulsing animation for timeline markers */
        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 10px rgba(var(--primary-color-rgb, 13, 110, 253), 0.5);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 0 20px rgba(var(--primary-color-rgb, 13, 110, 253), 0.8);
                transform: scale(1.1);
            }
            100% {
                box-shadow: 0 0 10px rgba(var(--primary-color-rgb, 13, 110, 253), 0.5);
                transform: scale(1);
            }
        }
        
        .timeline-item {
            padding: var(--spacing-md) var(--spacing-lg);
            position: relative;
            width: calc(100% - var(--spacing-xl)); /* Changed from 50% to utilize full available width */
            box-sizing: border-box;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: calc(var(--spacing-md) * 1.5);
        }
        
        .timeline-item:hover {
            transform: scale(1.03) translateY(-5px);
            z-index: 2;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 28px;
            height: 28px;
            background: #ffffff;
            border: 4px solid;
            border-color: var(--primary-color);
            border-radius: 50%;
            top: 20px;
            z-index: 1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: all var(--transition-speed) ease;
        }
        
        .timeline-left::after {
            border-color: var(--primary-color);
            right: -14px;
        }
        
        .timeline-right::after {
            border-color: var(--secondary-color);
            left: -14px;
        }
        
        .timeline-item:hover::after {
            transform: scale(1.3);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            background: radial-gradient(circle at center, white 60%, rgba(var(--primary-color-rgb, 13, 110, 253), 0.2) 100%);
        }
        
        .timeline-left:hover::after {
            background-color: rgba(var(--primary-color-rgb, 13, 110, 253), 0.1);
        }
        
        .timeline-right:hover::after {
            background-color: rgba(var(--secondary-color-rgb, 102, 16, 242), 0.1);
        }
        
        /* Timeline connector lines */
        .timeline-left::before,
        .timeline-right::before {
            content: '';
            position: absolute;
            top: var(--spacing-lg);
            width: var(--spacing-lg);
            height: 2px;
            z-index: 5;
            transform: translateY(6px);
        }
        
        .timeline-left::before {
            right: -24px;
            background: linear-gradient(to right, var(--primary-color), transparent);
        }
        
        .timeline-right::before {
            left: -24px;
            background: linear-gradient(to left, var(--secondary-color), transparent);
        }
        
        .timeline-content {
            padding: var(--spacing-md) var(--spacing-md);
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
            border-top: 4px solid;
            position: relative;
            overflow: hidden;
        }
        
        .timeline-left .timeline-content {
            border-top-color: var(--primary-color);
        }
        
        .timeline-right .timeline-content {
            border-top-color: var(--secondary-color);
        }
        
        .timeline-content:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
        }
        
        .timeline-content::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0) 0%, 
                rgba(255, 255, 255, 0.4) 100%);
            pointer-events: none;
        }
        
        .timeline-title {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-lg);
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--text-primary);
            position: relative;
            z-index: 2;
        }
        
        .timeline-title .timeline-icon {
            margin-right: var(--spacing-md);
            font-size: 1.3rem;
            color: var(--primary-color);
            filter: drop-shadow(0 0 8px rgba(30, 64, 175, 0.4));
            transition: all var(--transition-speed) ease;
            padding: var(--spacing-sm);
            background: rgba(30, 64, 175, 0.1);
            border-radius: 50%;
            border: 2px solid rgba(30, 64, 175, 0.3);
        }
        
        .timeline-right .timeline-title .timeline-icon {
            color: var(--secondary-color);
            filter: drop-shadow(0 0 8px rgba(124, 58, 237, 0.4));
            background: rgba(124, 58, 237, 0.1);
            border-color: rgba(124, 58, 237, 0.3);
        }
        
        .timeline-content:hover .timeline-title .timeline-icon {
            transform: scale(1.1) rotate(10deg);
            filter: drop-shadow(0 0 12px rgba(30, 64, 175, 0.6));
        }
        
        .timeline-date {
            display: inline-flex;
            align-items: center;
            margin-top: var(--spacing-lg);
            font-size: 0.875rem;
            color: var(--text-secondary);
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.15), rgba(2, 132, 199, 0.1));
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 25px;
            border: 1px solid rgba(30, 64, 175, 0.3);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
            transition: all var(--transition-speed) ease;
            position: relative;
            z-index: 2;
        }
        
        .timeline-date i {
            margin-right: var(--spacing-sm);
            font-size: 1.1rem;
            color: var(--accent-color);
            filter: drop-shadow(0 0 4px rgba(14, 165, 233, 0.3));
        }
        
        .timeline-content:hover .timeline-date {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(30, 64, 175, 0.3);
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.25), rgba(2, 132, 199, 0.2));
        }
        
        /* Status badge positioning and styling */
        .timeline-status {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            font-size: 0.7rem;
            border-radius: 3px;
            margin-left: 8px;
            font-weight: 500;
            position: relative;
            top: -1px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        .badge.bg-success {
            background-color: rgba(5, 150, 105, 0.2) !important;
            color: #10b981 !important;
            border-color: rgba(5, 150, 105, 0.4) !important;
        }
        
        .badge.bg-primary {
            background-color: rgba(30, 64, 175, 0.2) !important;
            color: #3b82f6 !important;
            border-color: rgba(30, 64, 175, 0.4) !important;
        }
        
        .badge.bg-warning {
            background-color: rgba(217, 119, 6, 0.2) !important;
            color: #fbbf24 !important;
            border-color: rgba(217, 119, 6, 0.4) !important;
        }
        
        .badge.bg-danger {
            background-color: rgba(220, 38, 38, 0.2) !important;
            color: #ef4444 !important;
            border-color: rgba(220, 38, 38, 0.4) !important;
        }
        
        .badge.bg-secondary {
            background-color: rgba(71, 85, 105, 0.2) !important;
            color: #94a3b8 !important;
            border-color: rgba(71, 85, 105, 0.4) !important;
        }
        
        /* For mobile layout */
        @media (max-width: 768px) {
            .timeline-container::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-left::after, 
        .timeline-right::after {
                left: 15px;
            }
            
            .timeline-right {
                left: 0;
            }
            
            .timeline-left::before,
            .timeline-right::before {
                width: 25px;
                top: 30px;
        }
            
            .timeline-left::before {
                left: 31px;
                background: linear-gradient(to right, var(--primary-color), transparent);
            }
            
            .timeline-right::before {
                left: 31px;
                background: linear-gradient(to right, var(--secondary-color), transparent);
            }
        }
        
        .timeline-content {
            padding: var(--spacing-xl);
            background: var(--card-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) var(--transition-ease);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--text-secondary);
            position: relative;
            overflow: hidden;
        }
        
        .timeline-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, 
                var(--primary-color) 0%, 
                var(--accent-color) 50%, 
                var(--secondary-color) 100%);
            background-size: 200% 100%;
            animation: timelineContentGradient 3s ease-in-out infinite;
        }
        
        .timeline-content::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, 
                transparent 0%, 
                var(--accent-color) 50%, 
                transparent 100%);
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
        }
        
        .timeline-content:hover::after {
            opacity: 1;
        }
        
        .timeline-content:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateY(-4px);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        @keyframes timelineContentGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .timeline-content p {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: var(--spacing-sm);
        }
        
        .reference-item {
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-md);
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) var(--transition-ease);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .reference-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-color), var(--accent-color));
            z-index: 1;
        }
        
        .reference-item:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-accent);
            transform: translateY(-6px);
            border-color: rgba(124, 58, 237, 0.3);
        }
        
        .reference-item h5 {
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
            font-size: 1.1rem;
            font-weight: 700;
        }
        
        .reference-item a {
            color: var(--accent-color);
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            padding-bottom: 2px;
        }
        
        .reference-item a:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        .reference-item a:hover {
            color: #fff;
            text-shadow: 0 0 8px rgba(76, 201, 240, 0.5);
        }
        
        .reference-item a:hover:after {
            width: 100%;
        }
        
        .member-card {
            padding: var(--spacing-md);
            border-radius: var(--border-radius);
            margin-bottom: var(--spacing-sm);
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) var(--transition-ease);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .member-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--secondary-color));
            background-size: 200% 100%;
            animation: gradientShift 3s ease-in-out infinite;
            z-index: 1;
        }
        
        .member-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, 
                transparent 0%, 
                var(--accent-color) 50%, 
                transparent 100%);
            opacity: 0;
            transition: opacity var(--transition-speed) ease;
            z-index: 1;
        }
        
        .member-card:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(30, 64, 175, 0.4);
        }
        
        .member-card:hover::after {
            opacity: 1;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        

        
        .member-name {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: var(--spacing-sm);
            color: #ffffff !important;
            position: relative;
            z-index: 2;
        }
        
        .member-name i {
            font-size: 1.2rem;
            margin-right: var(--spacing-sm);
            color: var(--accent-color);
            filter: drop-shadow(0 0 8px rgba(14, 165, 233, 0.4));
            transition: all var(--transition-speed) ease;
        }
        
        .member-card:hover .member-name i {
            transform: scale(1.1) rotate(5deg);
            filter: drop-shadow(0 0 12px rgba(14, 165, 233, 0.6));
        }
        
        .member-role {
            display: inline-flex;
            align-items: center;
            padding: 2px var(--spacing-sm);
            border-radius: 15px;
            font-size: 0.75rem;
            margin-bottom: var(--spacing-sm);
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.2), rgba(2, 132, 199, 0.15));
            color: #ffffff !important;
            font-weight: 600;
            border: 1px solid rgba(30, 64, 175, 0.4);
            box-shadow: 0 2px 6px rgba(30, 64, 175, 0.2);
            transition: all var(--transition-speed) ease;
            position: relative;
            z-index: 2;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .member-role i {
            font-size: 0.9rem;
            margin-right: var(--spacing-sm);
            filter: drop-shadow(0 0 4px rgba(30, 64, 175, 0.3));
        }
        
        .member-card:hover .member-role {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(30, 64, 175, 0.3);
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.3), rgba(2, 132, 199, 0.25));
        }
        
        .progress {
            height: 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            margin-bottom: var(--spacing-sm);
            overflow: hidden;
            box-shadow: 
                inset 0 2px 8px rgba(0, 0, 0, 0.3),
                0 2px 8px rgba(30, 64, 175, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }
        
        .progress::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(255, 255, 255, 0.1) 50%, 
                transparent 100%);
            animation: progressShimmer 2s infinite;
            pointer-events: none;
        }
        
        .progress-bar {
            background: linear-gradient(135deg, 
                var(--primary-color) 0%, 
                var(--accent-color) 50%, 
                var(--secondary-color) 100%);
            background-size: 200% 100%;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            transition: all 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            animation: progressGradient 3s ease-in-out infinite;
            box-shadow: 0 0 15px rgba(30, 64, 175, 0.4);
        }
        
        @keyframes progressShimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        @keyframes progressGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Color progression for contribution levels */
        .progress-bar[aria-valuenow^="1"], 
        .progress-bar[aria-valuenow^="2"],
        .progress-bar[aria-valuenow^="3"] {
            background: linear-gradient(to right, #6c757d, #17a2b8);
        }
        
        .progress-bar[aria-valuenow^="4"], 
        .progress-bar[aria-valuenow^="5"],
        .progress-bar[aria-valuenow^="6"] {
            background: linear-gradient(to right, #17a2b8, #0d6efd);
        }
        
        .progress-bar[aria-valuenow^="7"], 
        .progress-bar[aria-valuenow^="8"],
        .progress-bar[aria-valuenow^="9"],
        .progress-bar[aria-valuenow="100"] {
            background: linear-gradient(to right, #0d6efd, #198754);
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.2) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            animation: shimmer 2s infinite;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-xs);
            font-size: 0.75rem;
            color: #ffffff !important;
        }
        
        .progress-label > div:first-child {
            color: #ffffff !important;
        }
        
        .progress-label strong {
            color: #ffffff !important;
            font-weight: 700;
        }
        
        .progress-percentage {
            font-weight: 700;
            color: var(--accent-color);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }
        
        .contribution-level {
            font-size: 0.65rem;
            display: inline-flex;
            align-items: center;
            padding: 1px var(--spacing-xs);
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.2), rgba(2, 132, 199, 0.15));
            color: #ffffff !important;
            border: 1px solid rgba(30, 64, 175, 0.4);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            box-shadow: 0 1px 4px rgba(30, 64, 175, 0.2);
            transition: all var(--transition-speed) ease;
        }
        
        .member-card:hover .contribution-level {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.3), rgba(2, 132, 199, 0.25));
        }
        
        .contribution-section {
            margin-bottom: var(--spacing-lg);
        }
        
        .contribution-text {
            color: #ffffff !important;
            font-weight: 500;
        }
        
        .contribution-text strong {
            color: #ffffff !important;
            font-weight: 700;
        }
        
        .member-id {
            display: flex;
            align-items: center;
            margin-top: var(--spacing-sm);
            padding: 2px var(--spacing-sm);
            background: rgba(15, 23, 35, 0.6);
            border-radius: 15px;
            font-size: 0.75rem;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all var(--transition-speed) ease;
            position: relative;
            z-index: 2;
        }
        
        .member-id i {
            margin-right: var(--spacing-sm);
            font-size: 1.1rem;
            color: var(--accent-color);
            filter: drop-shadow(0 0 6px rgba(14, 165, 233, 0.4));
        }
        
        .member-card:hover .member-id {
            background: rgba(15, 23, 35, 0.8);
            border-color: rgba(14, 165, 233, 0.3);
            transform: translateY(-2px);
        }
        
        .member-id span {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--accent-color);
            text-shadow: 0 0 4px rgba(14, 165, 233, 0.3);
        }
        
        .badge-custom {
            font-size: 0.75rem;
            padding: 2px var(--spacing-sm);
            margin-right: var(--spacing-xs);
            margin-bottom: var(--spacing-xs);
            border-radius: 15px;
            transition: all var(--transition-speed) var(--transition-ease);
            background: rgba(30, 64, 175, 0.15);
            border: 1px solid rgba(30, 64, 175, 0.3);
            box-shadow: var(--card-shadow);
            font-weight: 600;
            color: #ffffff !important;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .badge-custom:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0), 
                rgba(255, 255, 255, 0.1), 
                rgba(255, 255, 255, 0));
            transform: translateX(-100%);
            transition: transform 0.8s ease;
        }
        
        .badge-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(76, 201, 240, 0.3);
            background: rgba(76, 201, 240, 0.2);
            border-color: rgba(76, 201, 240, 0.5);
        }
        
        .badge-custom:hover:after {
            transform: translateX(100%);
        }
        
        #project-not-found {
            display: none;
            padding: 50px 0;
            text-align: center;
        }
        
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }
        
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) var(--transition-ease);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: var(--spacing-md);
            position: relative;
        }
        
        .card:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateY(-8px);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            background-size: 200% 100%;
            padding: var(--spacing-sm) var(--spacing-md);
            border-bottom: none;
            position: relative;
            overflow: hidden;
            animation: headerGradient 4s ease-in-out infinite;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, 
                transparent 30%, 
                rgba(255, 255, 255, 0.1) 50%, 
                transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.8s var(--transition-ease);
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, 
                var(--accent-color), 
                var(--text-primary), 
                var(--accent-color));
            background-size: 200% 100%;
            animation: headerUnderline 3s ease-in-out infinite;
        }
        
        .card:hover .card-header::before {
            transform: translateX(100%);
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #ffffff !important;
            font-size: 1rem;
            text-transform: uppercase;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        @keyframes headerGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes headerUnderline {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .card-body {
            padding: var(--spacing-sm);
        }
        
        .progress {
            height: 12px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            margin-bottom: var(--spacing-md);
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .progress-bar {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 6px;
            position: relative;
            overflow: hidden;
            transition: width 1.2s ease;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.2) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            animation: shimmer 2s infinite;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }
        
        .progress-label strong {
            color: var(--primary-color);
        }
        
        .progress-percentage {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .contribution-level {
            font-size: 0.75rem;
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 8px;
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .list-group-item {
            background: var(--card-bg);
            border-color: rgba(30, 64, 175, 0.2);
            transition: all var(--transition-speed) var(--transition-ease);
            padding: var(--spacing-sm) var(--spacing-md);
            color: #ffffff !important;
            margin-bottom: var(--spacing-xs);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .list-group-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
            transform: scaleY(0);
            transition: transform var(--transition-speed) ease;
            transform-origin: bottom;
        }
        
        .list-group-item:hover::before {
            transform: scaleY(1);
        }
        
        .list-group-item:hover {
            background: rgba(30, 64, 175, 0.15);
            transform: translateX(12px) translateY(-4px);
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            border-color: rgba(30, 64, 175, 0.4);
        }
        
        .list-group-item a {
            color: var(--accent-color);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            font-weight: 600;
            position: relative;
        }
        
        .list-group-item a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-color), var(--secondary-color));
            transition: width var(--transition-speed) ease;
        }
        
        .list-group-item a:hover {
            color: var(--text-primary);
            text-shadow: 0 0 8px rgba(14, 165, 233, 0.5);
        }
        
        .list-group-item a:hover::after {
            width: 100%;
        }
        
        .list-group-item i {
            color: var(--accent-color);
            margin-right: var(--spacing-md);
            filter: drop-shadow(0 0 6px rgba(14, 165, 233, 0.4));
            font-size: 1.2rem;
            transition: all var(--transition-speed) ease;
        }
        
        .list-group-item:hover i {
            transform: scale(1.1) rotate(5deg);
            filter: drop-shadow(0 0 10px rgba(14, 165, 233, 0.6));
        }
        
        .list-group-item .btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 20px;
            padding: var(--spacing-xs) var(--spacing-md);
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }
        
        .list-group-item .btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 16px rgba(30, 64, 175, 0.4);
        }
        
        .download-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color)) !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 15px !important;
            padding: 2px var(--spacing-sm) !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            gap: var(--spacing-xs) !important;
            transition: all var(--transition-speed) ease !important;
            box-shadow: 0 2px 6px rgba(30, 64, 175, 0.3) !important;
            text-decoration: none !important;
            font-size: 0.75rem !important;
        }
        
        .download-btn:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.5) !important;
            color: #ffffff !important;
        }
        
        .download-btn i {
            font-size: 0.8rem !important;
            color: #ffffff !important;
        }
        
        .download-btn .btn-text {
            font-size: 0.75rem !important;
            color: #ffffff !important;
        }
        
        .file-info {
            flex: 1;
        }
        
        .file-name {
            color: #ffffff !important;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: var(--spacing-xs);
            display: flex;
            align-items: center;
        }
        
        .file-details {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 0.75rem;
            font-weight: 500;
            display: block;
        }
        
        /* Ensure all text elements have proper colors */
        .list-group-item .file-name {
            color: #ffffff !important;
        }
        
        .list-group-item .file-details {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .member-card .member-name {
            color: #ffffff !important;
        }
        
        .member-card .member-role {
            color: #ffffff !important;
        }
        
        .member-card .member-id {
            color: #ffffff !important;
        }
        
        .member-card .contribution-text {
            color: #ffffff !important;
        }
        
        .member-card .contribution-text strong {
            color: #ffffff !important;
        }
        
        .btn {
            border-radius: 50px;
            padding: var(--spacing-sm) var(--spacing-lg);
            transition: all var(--transition-speed) var(--transition-ease);
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
            text-transform: uppercase;
            border: 2px solid transparent;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(255, 255, 255, 0), 
                rgba(255, 255, 255, 0.2), 
                rgba(255, 255, 255, 0));
            transition: transform 0.6s var(--transition-ease);
            z-index: -1;
        }
        
        .btn:hover::before {
            transform: translateX(200%);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: 2px solid transparent;
            color: var(--text-primary);
            box-shadow: var(--glow-primary);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary-color));
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            color: var(--text-primary);
        }
        
        .btn-primary:active, .btn-primary:focus {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary-color));
            box-shadow: var(--glow-primary);
            color: var(--text-primary);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: rgba(30, 64, 175, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--text-primary);
            border-color: transparent;
            box-shadow: var(--glow-primary);
        }
        
        .toast-container {
            z-index: 1080;
        }
        
        .toast {
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border: none;
        }
        
        /* Custom floating animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .float-animation {
            animation: float 5s ease-in-out infinite;
        }
        
        /* Section titles */
        .section-title {
            font-weight: 700;
            font-size: 1.75rem;
            position: relative;
            margin-bottom: var(--spacing-xl);
            padding-bottom: var(--spacing-md);
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
            transition: all var(--transition-speed) var(--transition-ease);
        }
        
        .section-title:hover::after {
            width: 120px;
            box-shadow: var(--glow-primary);
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, 
                rgba(30, 64, 175, 0.3), 
                transparent 50%);
        }
        
        /* Media hover effects */
        .media-card {
            overflow: hidden;
            border-radius: var(--border-radius);
            position: relative;
        }
        
        .media-card img {
            transition: transform 0.5s ease;
        }
        
        .media-card:hover img {
            transform: scale(1.05);
        }
        
        /* Link hover effects */
        .link-hover {
            position: relative;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .link-hover::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            transition: width 0.3s ease;
        }
        
        .link-hover:hover {
            color: var(--secondary-color);
        }
        
        .link-hover:hover::after {
            width: 100%;
        }
        
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
            background: radial-gradient(circle at 30% 40%, rgba(58, 134, 255, 0.08), transparent 30%),
                        radial-gradient(circle at 70% 70%, rgba(114, 9, 183, 0.06), transparent 35%),
                        radial-gradient(circle at 80% 10%, rgba(76, 201, 240, 0.07), transparent 25%);
            transition: opacity 1.5s cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        /* Add subtle grid lines to enhance futuristic feel */
        body:after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(58, 134, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(58, 134, 255, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
            pointer-events: none;
            z-index: -1;
        }
        
        /* Pulsing glow effect for particles */
        @keyframes pulse-glow {
            0% { filter: blur(0px); }
            50% { filter: blur(2px); }
            100% { filter: blur(0px); }
        }

        body.loaded #particles-js {
            opacity: 0.7;
        }

        /* Ensure content appears above particles */
        .search-container,
        .container,
        section,
        footer {
            position: relative;
            z-index: 1;
        }
        
        /* Loading animation */
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            flex-direction: column;
        }
        
        .spinner-border {
            width: 4rem;
            height: 4rem;
            border-width: 0.3rem;
            animation: spinner-border 1s linear infinite, pulse 2s ease-in-out infinite;
            border-color: var(--primary-color) transparent var(--accent-color) transparent;
            filter: drop-shadow(var(--glow-primary));
        }
        
        .loading-spinner .visually-hidden {
            margin-top: var(--spacing-lg);
            color: var(--text-secondary);
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 35, 0.5);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(58, 134, 255, 0.3);
            border-radius: 2px;
            border: 1px solid rgba(58, 134, 255, 0.1);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(76, 201, 240, 0.5);
            box-shadow: inset 0 0 6px rgba(76, 201, 240, 0.2);
        }
        
        ::-webkit-scrollbar-thumb:active {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }
        
        /* Footer styling */
        footer {
            background: rgba(15, 23, 35, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            position: relative;
            overflow: hidden;
            margin-top: 50px;
            border-top: 1px solid rgba(58, 134, 255, 0.2);
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, 
                rgba(58, 134, 255, 0), 
                rgba(58, 134, 255, 0.5), 
                rgba(58, 134, 255, 0));
        }
        
        footer::after {
            content: '';
            position: absolute;
            top: 1px;
            left: 0;
            width: 100%;
            height: 30px;
            background: linear-gradient(to bottom, 
                rgba(58, 134, 255, 0.08), 
                transparent);
            pointer-events: none;
        }
        
        /* Container styling */
        .container.my-5 {
            padding-top: var(--spacing-2xl);
            padding-bottom: var(--spacing-2xl);
            max-width: 1400px;
        }
        
        /* Enhanced responsive design */
        @media (max-width: 1200px) {
            .container.my-5 {
                padding-left: var(--spacing-lg);
                padding-right: var(--spacing-lg);
            }
        }
        
        /* Modern hero background */
        .hero-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -2;
            overflow: hidden;
        }
        
        .hero-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(30, 64, 175, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(30, 64, 175, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }
        
        .hero-glow {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 400px;
            background: radial-gradient(ellipse at center, 
                rgba(30, 64, 175, 0.15) 0%, 
                rgba(124, 58, 237, 0.1) 50%, 
                transparent 70%);
            animation: heroGlow 8s ease-in-out infinite;
        }
        
        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        @keyframes heroGlow {
            0%, 100% { 
                opacity: 0.6; 
                transform: translateX(-50%) scale(1);
            }
            50% { 
                opacity: 0.9; 
                transform: translateX(-50%) scale(1.1);
            }
        }
        
        @media (max-width: 768px) {
            .timeline-container::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-left::after, .timeline-right::after {
                left: 15px;
            }
            
            .timeline-right {
                left: 0;
            }
            
            .container {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
        
        /* Ripple effect */
        .btn {
            position: relative;
            overflow: hidden;
        }
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
        @keyframes ripple {
            to {
                transform: scale(2.5);
                opacity: 0;
            }
        }
        
        /* Smooth transition for text-primary */
        .text-primary {
            transition: color 0.3s ease;
        }
        
        /* Media Gallery Improvements */
        .media-container {
            position: relative;
        }
        
        .media-card {
            overflow: hidden;
            border-radius: var(--border-radius);
            position: relative;
            margin-bottom: var(--spacing-md);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
            height: 100%;
        }
        
        .media-card:hover {
            transform: translateY(-7px);
            box-shadow: var(--card-shadow-hover);
        }
        
        .media-card img {
            transition: transform 0.7s ease;
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        
        .media-card:hover img {
            transform: scale(1.08);
        }
        
        .media-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, 
                rgba(15, 23, 35, 0.8) 0%, 
                rgba(15, 23, 35, 0.1) 60%);
            opacity: 0.7;
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        .media-card:hover .media-overlay {
            opacity: 0.9;
            background: linear-gradient(to top, 
                rgba(15, 23, 35, 0.9) 0%, 
                rgba(15, 23, 35, 0.3) 70%);
        }
        
        .media-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.9rem;
            transform: translateY(10px);
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }
        
        .media-card:hover .media-caption {
            transform: translateY(0);
            color: #fff;
        }
        
        .media-caption:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        .media-card:hover .media-caption:before {
            width: 60px;
        }
        
        .media-type-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(15, 23, 35, 0.8);
            backdrop-filter: blur(8px);
            color: var(--accent-color);
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 0.7rem;
            font-weight: 500;
            z-index: 1;
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
            border: 1px solid rgba(76, 201, 240, 0.3);
            letter-spacing: 0.3px;
        }
        
        .media-card:hover .media-type-badge {
            background: rgba(15, 23, 35, 0.9);
            box-shadow: 0 0 10px rgba(76, 201, 240, 0.3);
            transform: translateY(-1px);
        }
        
        .media-type-badge i {
            font-size: 0.7rem;
            margin-right: 3px;
        }
        
        .media-zoom-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.5rem;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 2;
            cursor: pointer;
        }
        
        .media-card:hover .media-zoom-icon {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
        
        .media-zoom-icon:hover {
            background: rgba(255, 255, 255, 0.95);
            color: var(--secondary-color);
        }
        
        /* Video card specific styles */
        .video-card .ratio {
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            overflow: hidden;
        }
        
        .video-caption {
            padding: 15px;
            text-align: center;
            font-weight: 500;
            color: #495057;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }
        
        /* Lightbox styles */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 15, 25, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        .lightbox.active {
            opacity: 1;
            pointer-events: auto;
        }
        
        .lightbox-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            transform: scale(0.9) translateY(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }
        
        .lightbox.active .lightbox-content {
            transform: scale(1) translateY(0);
        }
        
        .lightbox-image {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 5px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
        }
        
        .lightbox-caption {
            position: absolute;
            bottom: -40px;
            left: 0;
            right: 0;
            text-align: center;
            color: white;
            font-size: 1rem;
            padding: 10px;
        }
        
        .lightbox-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 36px;
            height: 36px;
            background: rgba(15, 23, 35, 0.8);
            border: 1px solid rgba(76, 201, 240, 0.3);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
            backdrop-filter: blur(8px);
        }
        
        .lightbox-close:hover {
            background: rgba(76, 201, 240, 0.2);
            transform: rotate(90deg);
            color: white;
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.4);
        }
        
        .lightbox-navigation {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            padding: 0 20px;
            z-index: 20;
        }
        
        .lightbox-nav-btn {
            width: 40px;
            height: 40px;
            background: rgba(15, 23, 35, 0.8);
            border: 1px solid rgba(76, 201, 240, 0.3);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
            backdrop-filter: blur(8px);
            opacity: 0.7;
        }
        
        .lightbox-nav-btn:hover {
            background: rgba(76, 201, 240, 0.2);
            color: white;
            opacity: 1;
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.4);
            transform: scale(1.05);
        }
        
        /* Media counter badge */
        .media-counter {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(15, 23, 35, 0.8);
            backdrop-filter: blur(8px);
            color: var(--accent-color);
            border-radius: 3px;
            padding: 4px 8px;
            font-size: 0.7rem;
            font-weight: 500;
            z-index: 2;
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
            border: 1px solid rgba(76, 201, 240, 0.3);
            letter-spacing: 0.3px;
        }
        
        .media-card:hover .media-counter {
            background: rgba(15, 23, 35, 0.9);
            box-shadow: 0 0 10px rgba(76, 201, 240, 0.3);
        }
        
        @media (max-width: 768px) {
            .media-card img {
                height: 180px;
            }
        }
        
        /* Updated media card styling for placeholders */
        .media-card {
            overflow: hidden;
            border-radius: var(--border-radius);
            position: relative;
            margin-bottom: var(--spacing-md);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) cubic-bezier(0.19, 1, 0.22, 1);
            height: 100%;
            background-color: rgba(25, 33, 46, 0.8);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            border-left: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .media-card img {
            transition: transform 0.7s cubic-bezier(0.19, 1, 0.22, 1);
            width: 100%;
            height: 220px;
            object-fit: cover;
            object-position: center;
            opacity: 0.9;
            filter: brightness(1.05) contrast(1.05);
        }
        
        /* Placeholder image specific styling */
        .media-card img[src*="Research_Card_Placeholder.png"] {
            object-fit: contain;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        /* Lightbox placeholder styling */
        .lightbox-image[src*="Research_Card_Placeholder.png"] {
            max-height: 70vh;
            object-fit: contain;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
        }
        
        /* Placeholder for videos */
        .ratio.placeholder-bg {
            background-image: url('assets/images/Research_Card_Placeholder.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        /* Add CSS for the ripple effect */
        .custom-btn, .toggle-btn {
            position: relative;
            overflow: hidden;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        /* Enhanced futuristic effects */
        .futuristic-border {
            position: relative;
        }
        
        .futuristic-border:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 1px solid rgba(76, 201, 240, 0);
            transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            pointer-events: none;
            z-index: 2;
        }
        
        .futuristic-border:hover:before {
            border-color: rgba(76, 201, 240, 0.5);
            box-shadow: 0 0 20px rgba(76, 201, 240, 0.3);
        }
        
        /* Typing cursor effect for project title */
        .typing-cursor {
            display: inline-block;
            width: 2px;
            height: 1em;
            background-color: var(--accent-color);
            margin-left: 5px;
            vertical-align: text-bottom;
            animation: blink 1s infinite step-end;
        }
        
        @keyframes blink {
            from, to { opacity: 1; }
            50% { opacity: 0; }
        }
        
        /* Data loading indicator */
        .data-loading {
            position: relative;
        }
        
        .data-loading:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            animation: data-loading 2s infinite linear;
        }
        
        @keyframes data-loading {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Text glow effect */
        .text-glow {
            text-shadow: 0 0 8px rgba(76, 201, 240, 0.5);
            color: #fff;
        }
        
        /* Terminal effect */
        .terminal-text {
            font-family: 'Courier New', monospace;
            color: #10b981;
            background-color: rgba(2, 6, 23, 0.8);
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.85em;
        }

        /* Add styling for the description section */
        .description-box {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            margin-bottom: var(--spacing-xl);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
            line-height: 1.7;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed) var(--transition-ease);
            color: var(--text-secondary);
        }

        .description-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            z-index: 1;
        }
        
        .description-box:hover {
            box-shadow: var(--card-shadow-hover), var(--glow-primary);
            transform: translateY(-8px);
            border-color: rgba(30, 64, 175, 0.3);
        }

        .description-box h3 {
            position: relative;
            z-index: 2;
            margin-bottom: var(--spacing-lg);
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .description-box p {
            position: relative;
            z-index: 2;
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: var(--spacing-md);
            line-height: 1.7;
        }

        .description-highlight {
            color: var(--accent-color);
            font-weight: 600;
            filter: drop-shadow(0 0 4px rgba(14, 165, 233, 0.3));
        }

        .description-section {
            margin-bottom: var(--spacing-lg);
        }

        .description-section:last-child {
            margin-bottom: 0;
        }

        .description-section-title {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--text-primary);
            margin-bottom: var(--spacing-md);
            display: flex;
            align-items: center;
        }

        .description-section-title i {
            margin-right: var(--spacing-sm);
            color: var(--accent-color);
            filter: drop-shadow(0 0 4px rgba(14, 165, 233, 0.3));
        }

        /* Add styles for timeline marker labels */
        .timeline-marker-label {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 20px;
            font-size: 0.875rem;
            box-shadow: var(--card-shadow);
            z-index: 15;
            text-align: center;
            white-space: nowrap;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-secondary);
            font-weight: 600;
        }

        .timeline-start-label {
            top: -10px;
            border-left: 2px solid var(--primary-color);
        }
        
        .timeline-start-label strong {
            color: var(--primary-color);
        }

        .timeline-end-label {
            bottom: -10px;
            border-left: 2px solid var(--accent-color);
            padding-bottom: var(--spacing-sm);
        }
        
        .timeline-end-label strong {
            color: var(--accent-color);
        }

        /* Improved responsive layout for mobile */
        @media (max-width: 768px) {
            .timeline-container::after {
                left: 31px;
            }
            
            .timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }
            
            .timeline-left::after, 
            .timeline-right::after {
                left: 16px;
            }
            
            .timeline-right {
                left: 0;
            }
            
            .timeline-left::before,
            .timeline-right::before {
                width: 25px;
                top: 30px;
            }
            
            .timeline-left::before {
                left: 31px;
                background: linear-gradient(to right, var(--primary-color), transparent);
            }
            
            .timeline-right::before {
                left: 31px;
                background: linear-gradient(to right, var(--secondary-color), transparent);
            }
            
            .timeline-left .timeline-content,
            .timeline-right .timeline-content {
                text-align: left;
                transform: none;
            }
            
            .timeline-left .timeline-title {
                justify-content: flex-start;
            }
            
            .timeline-left .timeline-title .timeline-icon {
                order: 0;
                margin-left: 0;
                margin-right: 8px;
            }
            
            .timeline-left .timeline-status {
                margin-right: 0;
                margin-left: 8px;
            }
            
            .timeline-left .timeline-content:hover,
            .timeline-right .timeline-content:hover {
                transform: translateY(-3px);
            }
            
            .timeline-marker-label {
                left: 31px;
                transform: translateX(0);
                padding: 4px 10px;
            }
            
            .timeline-marker-label:hover {
                transform: translateX(0) translateY(-3px);
            }
            
            .timeline-start-label {
                top: 10px;
                left: 31px;
                transform: translateX(0);
            }
            
            .timeline-end-label {
                bottom: 10px;
                left: 31px;
                transform: translateX(0);
            }
            
            .timeline-container::before {
                left: 31px;
                margin-left: 0;
            }
            
            .timeline-end-marker {
                left: 31px;
                margin-left: 0;
            }
        }

        /* Mobile timeline connector fix */
        @media (max-width: 768px) {
            .timeline-left .timeline-content::before,
            .timeline-right .timeline-content::before {
                display: none;
            }
            
            .timeline-left .timeline-content,
            .timeline-right .timeline-content {
                align-items: flex-start;
                margin-left: 0;
                margin-right: 0;
                max-width: none; /* Remove max-width constraint to allow full width */
                padding: var(--spacing-md);
            }
            
            .timeline-left .timeline-title,
            .timeline-right .timeline-title {
                justify-content: flex-start;
            }
            
            .timeline-left .timeline-title-row {
                flex-direction: row;
            }
            
            .timeline-left .timeline-date {
                align-self: flex-start;
            }
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

        /* ===== LIGHT MODE STYLES ===== */
        [data-theme="light"] {
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary-color: #7c3aed;
            --accent-color: #0284c7;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            
            /* Light Background Colors */
            --dark-bg: #ffffff;
            --card-bg: rgba(255, 255, 255, 0.95);
            --glass-bg: rgba(248, 250, 252, 0.8);
            --light-bg: #f8fafc;
            
            /* Dark Text Colors for Light Mode */
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --text-dark: #0f172a;
            
            /* Light Mode Effects */
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --glow-primary: 0 0 20px rgba(30, 64, 175, 0.1);
            --glow-accent: 0 0 20px rgba(2, 132, 199, 0.1);
        }

        [data-theme="light"] body {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
            color: var(--text-primary);
        }

        [data-theme="light"] body::before {
            background: 
                radial-gradient(circle at 20% 80%, rgba(30, 64, 175, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(124, 58, 237, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(2, 132, 199, 0.01) 0%, transparent 50%);
        }

        [data-theme="light"] h1, 
        [data-theme="light"] h2, 
        [data-theme="light"] h3, 
        [data-theme="light"] h4, 
        [data-theme="light"] h5, 
        [data-theme="light"] h6 {
            color: var(--text-primary);
        }

        [data-theme="light"] .project-header {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .project-header:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .project-header::before {
            background: linear-gradient(135deg, 
                rgba(30, 64, 175, 0.02) 0%, 
                rgba(124, 58, 237, 0.02) 50%,
                rgba(2, 132, 199, 0.02) 100%);
        }

        [data-theme="light"] .project-header h1 {
            background: linear-gradient(135deg, 
                var(--text-primary) 0%, 
                var(--primary-color) 50%, 
                var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        [data-theme="light"] .project-header .meta-item {
            color: var(--text-secondary);
        }

        [data-theme="light"] .project-header .meta-item i {
            color: var(--accent-color);
        }

        [data-theme="light"] .abstract-box {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .abstract-box:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .abstract-box::before {
            background: linear-gradient(135deg, 
                rgba(30, 64, 175, 0.02) 0%, 
                rgba(124, 58, 237, 0.02) 100%);
        }

        [data-theme="light"] .abstract-box h3 {
            color: var(--text-primary);
        }

        [data-theme="light"] .section-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .section-title::after {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        [data-theme="light"] .card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .card:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .card-header {
            background: rgba(248, 250, 252, 0.8);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .card-header h5 {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .card-body {
            color: var(--text-primary);
        }

        [data-theme="light"] .metadata-card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .metadata-card:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .metadata-card h4 {
            color: var(--text-primary);
        }

        [data-theme="light"] .member-card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .member-card:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .member-card .member-name {
            color: var(--text-primary);
        }

        [data-theme="light"] .member-card .member-role {
            color: var(--text-secondary);
        }

        [data-theme="light"] .timeline-container {
            color: var(--text-primary);
        }

        [data-theme="light"] .timeline-item {
            background: transparent;
            border: none;
            color: var(--text-primary);
        }

        [data-theme="light"] .timeline-item:hover {
            background: rgba(248, 250, 252, 0.3);
            border-radius: 8px;
        }

        [data-theme="light"] .timeline-item h5 {
            color: var(--text-primary);
        }

        [data-theme="light"] .timeline-item p {
            color: var(--text-secondary);
        }

        [data-theme="light"] .timeline-item .timeline-date {
            color: var(--text-muted);
        }

        [data-theme="light"] .timeline-line {
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
        }

        [data-theme="light"] .timeline-icon {
            background: var(--card-bg);
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        [data-theme="light"] .media-card {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .media-card:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .media-card .media-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .media-card .media-description {
            color: var(--text-secondary);
        }

        [data-theme="light"] .keyword-tag {
            background: rgba(30, 64, 175, 0.1);
            color: var(--primary-color);
            border: 1px solid rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .keyword-tag:hover {
            background: rgba(30, 64, 175, 0.2);
            border-color: var(--primary-color);
        }

        [data-theme="light"] .resource-item {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .resource-item:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .resource-item .resource-name {
            color: var(--text-primary);
        }

        [data-theme="light"] .resource-item .resource-type {
            color: var(--text-secondary);
        }

        [data-theme="light"] .link-item {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .link-item:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .link-item .link-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .link-item .link-url {
            color: var(--text-secondary);
        }

        [data-theme="light"] .stat-item {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .stat-item:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .stat-item .stat-value {
            color: var(--primary-color);
        }

        [data-theme="light"] .stat-item .stat-label {
            color: var(--text-secondary);
        }

        [data-theme="light"] .reference-item {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .reference-item:hover {
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .reference-item .reference-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .reference-item .reference-authors {
            color: var(--text-secondary);
        }

        [data-theme="light"] .reference-item .reference-journal {
            color: var(--text-muted);
        }

        [data-theme="light"] .lightbox {
            background: rgba(255, 255, 255, 0.95);
        }

        [data-theme="light"] .lightbox-content {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .lightbox-caption {
            color: var(--text-primary);
        }

        [data-theme="light"] .lightbox-close {
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .lightbox-nav-btn {
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .lightbox-nav-btn:hover {
            background: rgba(248, 250, 252, 0.9);
            border-color: rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .loading-spinner {
            color: var(--text-primary);
        }

        [data-theme="light"] .alert {
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .alert-warning {
            background: rgba(217, 119, 6, 0.1);
            border-color: rgba(217, 119, 6, 0.2);
            color: #92400e;
        }

        [data-theme="light"] .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        [data-theme="light"] .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        [data-theme="light"] .text-link {
            color: var(--primary-color);
        }

        [data-theme="light"] .floating-accent {
            background: radial-gradient(circle, rgba(30, 64, 175, 0.05) 0%, transparent 70%);
        }

        [data-theme="light"] .hero-background {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.6) 100%);
        }

        [data-theme="light"] .hero-grid {
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.02) 1px, transparent 1px);
        }

        [data-theme="light"] .hero-glow {
            background: radial-gradient(circle at center, rgba(30, 64, 175, 0.03) 0%, transparent 70%);
        }

        /* Status badges in light mode */
        [data-theme="light"] .status-badge.bg-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05)) !important;
            border-color: rgba(16, 185, 129, 0.3);
            color: #059669 !important;
        }

        [data-theme="light"] .status-badge.bg-warning {
            background: linear-gradient(135deg, rgba(217, 119, 6, 0.1), rgba(217, 119, 6, 0.05)) !important;
            border-color: rgba(217, 119, 6, 0.3);
            color: #d97706 !important;
        }

        [data-theme="light"] .status-badge.bg-info {
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.1), rgba(2, 132, 199, 0.05)) !important;
            border-color: rgba(2, 132, 199, 0.3);
            color: #0284c7 !important;
        }

        [data-theme="light"] .status-badge.bg-danger {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(220, 38, 38, 0.05)) !important;
            border-color: rgba(220, 38, 38, 0.3);
            color: #dc2626 !important;
        }

        [data-theme="light"] .privacy-toggle.btn-outline-warning {
            color: #d97706 !important;
            border-color: rgba(217, 119, 6, 0.3);
            background: rgba(217, 119, 6, 0.05);
        }

        [data-theme="light"] .privacy-toggle.btn-outline-success {
            color: #059669 !important;
            border-color: rgba(5, 150, 105, 0.3);
            background: rgba(5, 150, 105, 0.05);
        }

        /* Particles.js canvas in light mode */
        [data-theme="light"] #particles-js {
            opacity: 0.3;
        }

        [data-theme="light"] #particles-js canvas {
            filter: invert(1) opacity(0.2);
        }

        /* ===== ADDITIONAL LIGHT MODE FIXES ===== */
        
        /* Timeline specific text fixes */
        [data-theme="light"] .timeline-title {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .timeline-content p {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .timeline-date {
            color: var(--text-primary) !important;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(2, 132, 199, 0.1));
            border: 1px solid rgba(30, 64, 175, 0.2);
        }

        [data-theme="light"] .timeline-content:hover .timeline-date {
            color: var(--text-primary) !important;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.2), rgba(2, 132, 199, 0.2));
        }

        [data-theme="light"] .timeline-marker-label {
            color: var(--text-primary) !important;
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .timeline-marker-label:hover {
            border-color: rgba(30, 64, 175, 0.3);
        }

        /* Team member card text fixes */
        [data-theme="light"] .member-card .member-name,
        [data-theme="light"] .member-card .member-role,
        [data-theme="light"] .member-card .member-email,
        [data-theme="light"] .member-card .member-department,
        [data-theme="light"] .member-card .member-contribution,
        [data-theme="light"] .member-card .member-bio,
        [data-theme="light"] .member-card p,
        [data-theme="light"] .member-card span,
        [data-theme="light"] .member-card div {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .member-card .text-muted,
        [data-theme="light"] .member-card .member-role {
            color: var(--text-secondary) !important;
        }

        /* Keywords container text fixes */
        [data-theme="light"] .keyword-tag,
        [data-theme="light"] .keyword-item,
        [data-theme="light"] #keywords-container .badge,
        [data-theme="light"] #keywords-container span,
        [data-theme="light"] #keywords-container p {
            color: var(--primary-color) !important;
        }

        /* Files & Resources text fixes */
        [data-theme="light"] .resource-item .resource-name,
        [data-theme="light"] .resource-item .resource-type,
        [data-theme="light"] .resource-item .resource-size,
        [data-theme="light"] .resource-item .resource-date,
        [data-theme="light"] .resource-item p,
        [data-theme="light"] .resource-item span,
        [data-theme="light"] .resource-item div,
        [data-theme="light"] #resources-container p,
        [data-theme="light"] #resources-container span,
        [data-theme="light"] #resources-container div {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .resource-item .text-muted,
        [data-theme="light"] .resource-item .resource-type {
            color: var(--text-secondary) !important;
        }

        /* External Links text fixes */
        [data-theme="light"] .link-item .link-title,
        [data-theme="light"] .link-item .link-url,
        [data-theme="light"] .link-item .link-description,
        [data-theme="light"] .link-item p,
        [data-theme="light"] .link-item span,
        [data-theme="light"] .link-item div,
        [data-theme="light"] #links-container p,
        [data-theme="light"] #links-container span,
        [data-theme="light"] #links-container div {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .link-item .text-muted,
        [data-theme="light"] .link-item .link-url {
            color: var(--text-secondary) !important;
        }

        /* Project Stats text fixes */
        [data-theme="light"] .stat-item .stat-value,
        [data-theme="light"] .stat-item .stat-label,
        [data-theme="light"] .stat-item .stat-description,
        [data-theme="light"] .stat-item p,
        [data-theme="light"] .stat-item span,
        [data-theme="light"] .stat-item div,
        [data-theme="light"] #stats-container p,
        [data-theme="light"] #stats-container span,
        [data-theme="light"] #stats-container div {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .stat-item .stat-label,
        [data-theme="light"] .stat-item .text-muted {
            color: var(--text-secondary) !important;
        }

        /* General white text overrides for light mode */
        [data-theme="light"] .text-white,
        [data-theme="light"] .text-light {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .text-white-50 {
            color: var(--text-secondary) !important;
        }

        /* Inline style overrides for dynamically generated content */
        [data-theme="light"] [style*="color: #ffffff"],
        [data-theme="light"] [style*="color: white"],
        [data-theme="light"] [style*="color:#ffffff"],
        [data-theme="light"] [style*="color:white"] {
            color: var(--text-primary) !important;
        }

        /* Footer light mode styles */
        [data-theme="light"] .enhanced-footer {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .enhanced-footer::before {
            background: linear-gradient(90deg, 
                transparent, 
                rgba(30, 64, 175, 0.3), 
                rgba(124, 58, 237, 0.3), 
                rgba(20, 184, 166, 0.3), 
                transparent);
        }

        [data-theme="light"] .footer-title {
            background: linear-gradient(135deg, var(--text-primary), var(--primary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        [data-theme="light"] .footer-description {
            color: var(--text-secondary);
        }

        [data-theme="light"] .footer-section-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .footer-section-title::after {
            background: var(--primary-color);
        }

        [data-theme="light"] .footer-links a {
            color: var(--text-secondary);
        }

        [data-theme="light"] .footer-links a:hover {
            color: var(--primary-color);
        }

        [data-theme="light"] .footer-links a::after {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        [data-theme="light"] .social-link {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-secondary);
        }

        [data-theme="light"] .social-link:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        [data-theme="light"] .footer-bottom {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .copyright-text {
            color: var(--text-muted);
        }

        /* Additional specific element fixes */
        [data-theme="light"] .project-info p,
        [data-theme="light"] .project-info span,
        [data-theme="light"] .project-info div {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .project-info .text-muted {
            color: var(--text-secondary) !important;
        }

        /* Media card content fixes */
        [data-theme="light"] .media-card .media-title,
        [data-theme="light"] .media-card .media-description,
        [data-theme="light"] .media-card p,
        [data-theme="light"] .media-card span {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .media-card .text-muted {
            color: var(--text-secondary) !important;
        }

        /* Reference items fixes */
        [data-theme="light"] .reference-item .reference-title,
        [data-theme="light"] .reference-item .reference-authors,
        [data-theme="light"] .reference-item .reference-journal,
        [data-theme="light"] .reference-item .reference-year,
        [data-theme="light"] .reference-item p,
        [data-theme="light"] .reference-item span {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .reference-item .text-muted,
        [data-theme="light"] .reference-item .reference-journal {
            color: var(--text-secondary) !important;
        }

        /* Abstract box content fixes */
        [data-theme="light"] .abstract-box p,
        [data-theme="light"] .abstract-box span,
        [data-theme="light"] .abstract-box div {
            color: var(--text-primary) !important;
        }

        /* Project description fixes */
        [data-theme="light"] #project-description p,
        [data-theme="light"] #project-description span,
        [data-theme="light"] #project-description div {
            color: var(--text-primary) !important;
        }

        /* Last updated text fixes */
        [data-theme="light"] .fst-italic {
            color: var(--text-muted) !important;
        }

        /* ===== SPECIFIC COLOR CORRECTIONS ===== */
        
        /* Media counter and type badge - make white in light mode */
        [data-theme="light"] .media-counter {
            color: #ffffff !important;
        }

        [data-theme="light"] .media-type-badge {
            color: #ffffff !important;
        }

        /* Abstract highlight - restore previous color (keep colorful) */
        [data-theme="light"] .abstract-highlight {
            color: var(--accent-color) !important;
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.1), rgba(2, 132, 199, 0.05));
        }

        /* Footer title - restore gradient color */
        [data-theme="light"] .footer-title {
            background: linear-gradient(135deg, #ffffff, #2563eb) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            color: transparent !important;
        }

        /* Float animation display-4 - restore previous color */
        [data-theme="light"] .float-animation.display-4 {
            background: linear-gradient(135deg, 
                var(--text-primary) 0%, 
                var(--primary-color) 50%, 
                var(--accent-color) 100%) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            color: transparent !important;
        }

        /* File details - make black in light mode */
        [data-theme="light"] .file-details,
        [data-theme="light"] .file-details p,
        [data-theme="light"] .file-details span,
        [data-theme="light"] .file-details div {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .file-details .text-muted {
            color: var(--text-secondary) !important;
        }

        /* ===== FIX FOR FILES & RESOURCES DOWNLOAD BUTTON CLIPPING ===== */
        
        /* Improved file list layout to prevent download button clipping */
        #resources-container .list-group-item {
            display: flex !important;
            flex-direction: column !important;
            gap: 12px !important;
            padding: 16px !important;
            background: rgba(65, 89, 128, 0) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            margin-bottom: 12px !important;
        }
        
        /* File info and download button container */
        .file-item-container {
            display: flex !important;
            justify-content: space-between !important;
            align-items: flex-start !important;
            gap: 16px !important;
            width: 100% !important;
        }
        
        /* File info section - allow it to take available space but not overflow */
        .file-info {
            flex: 1 !important;
            min-width: 0 !important; /* Allow shrinking */
            max-width: calc(100% - 120px) !important; /* Reserve space for download button */
        }
        
        /* File name with proper text truncation */
        .file-name {
            color: #ffffff !important;
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            margin-bottom: 4px !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            line-height: 1.4 !important;
        }
        
        /* File name text that can wrap */
        .file-name-text {
            flex: 1 !important;
            min-width: 0 !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }
        
        /* File details with better spacing */
        .file-details {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.75rem !important;
            font-weight: 400 !important;
            display: block !important;
            margin-top: 4px !important;
            line-height: 1.3 !important;
        }
        
        /* Download button - fixed width to prevent clipping */
        .download-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color)) !important;
            border: none !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(30, 64, 175, 0.3) !important;
            text-decoration: none !important;
            font-size: 0.75rem !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important; /* Prevent shrinking */
            min-width: 100px !important; /* Minimum width */
            justify-content: center !important;
        }
        
        .download-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.5) !important;
            color: #ffffff !important;
            background: linear-gradient(135deg, var(--primary-dark), var(--accent-color)) !important;
        }
        
        .download-btn i {
            font-size: 0.8rem !important;
            color: #ffffff !important;
        }
        
        .download-btn .btn-text {
            font-size: 0.75rem !important;
            color: #ffffff !important;
        }
        
        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            .file-item-container {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
            }
            
            .file-info {
                max-width: 100% !important;
            }
            
            .download-btn {
                align-self: flex-end !important;
                min-width: 120px !important;
            }
        }
        
        /* Ensure file icons don't interfere with layout */
        .file-name i {
            flex-shrink: 0 !important;
            width: 16px !important;
            text-align: center !important;
        }
    </style>
    
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    
    <!-- Inject PHP session data into JavaScript -->
    <script>
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['user_id'])): ?>
        var currentUserId = "<?php echo $_SESSION['user_id']; ?>";
        <?php else: ?>
        var currentUserId = null;
        <?php endif; ?>
    </script>

    <!-- Background particles -->
    <div id="particles-js"></div>

    <!-- Special accent elements -->
    <div class="floating-accent"></div>
    <div class="floating-accent"></div>
    <div class="floating-accent"></div>
    
    <!-- Modern hero background -->
    <div class="hero-background">
        <div class="hero-grid"></div>
        <div class="hero-glow"></div>
    </div>

    <div class="container my-5">
        <!-- Loading spinner -->
        <div id="loading-spinner" class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Project not found message -->
        <div id="project-not-found">
            <div class="alert alert-warning shadow" role="alert">
                <h4 class="alert-heading">Project Not Found!</h4>
                <p>The research project you're looking for could not be found. It may have been removed or the link might be incorrect.</p>
                <hr>
                <a href="Research_page.php" class="btn btn-primary">Back to Research Projects</a>
            </div>
        </div>

        <!-- Project details container -->
        <div id="project-details" style="display: none;">
            <!-- Project header section -->
            <div id="project-header" class="project-header mb-4" data-aos="fade-up"></div>
            
            <!-- Main content -->
            <div class="row">
                <!-- Left column: Description and content -->
                <div class="col-lg-8">
                    <div id="project-abstract" class="abstract-box" data-aos="fade-up" data-aos-delay="100"></div>
                    
                    <div id="project-description" class="mb-4" data-aos="fade-up" data-aos-delay="200"></div>
                    
                    <div id="project-media" class="mb-5" data-aos="fade-up" data-aos-delay="300">
                        <h3 class="section-title">Media</h3>
                        <div class="row" id="media-container">
                            <!-- Media items will be loaded here -->
                        </div>
                    </div>
                    
                    <div id="project-timeline" class="mb-5" data-aos="fade-up" data-aos-delay="400">
                        <h3 class="section-title">Project Timeline</h3>
                        <div class="timeline-container" id="timeline-container">
                            <!-- Timeline items will be loaded here -->
                        </div>
                    </div>
                    
                    <div id="project-references" class="mb-5" data-aos="fade-up" data-aos-delay="500">
                        <h3 class="section-title">References</h3>
                        <div id="references-container">
                            <!-- References will be loaded here -->
                        </div>
                    </div>
                </div>
                
                <!-- Right column: Metadata and sidebar info -->
                <div class="col-lg-4">
                    <div class="metadata-card mb-4" data-aos="fade-left" data-aos-delay="100">
                        <h4 class="mb-3">Project Information</h4>
                        <div id="project-info">
                            <!-- Project info will be loaded here -->
                        </div>
                    </div>
                    
                    <div class="card mb-4" data-aos="fade-left" data-aos-delay="200">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">Team Members</h5>
                        </div>
                        <div class="card-body" id="team-members">
                            <!-- Team members will be loaded here -->
                        </div>
                    </div>
                    
                    <div class="card mb-4" data-aos="fade-left" data-aos-delay="300">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">Keywords</h5>
                        </div>
                        <div class="card-body" id="keywords-container">
                            <!-- Keywords will be loaded here -->
                        </div>
                    </div>
                    
                    <div class="card mb-4" data-aos="fade-left" data-aos-delay="400">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">Files & Resources</h5>
                        </div>
                        <div class="card-body" id="resources-container">
                            <!-- Resources will be loaded here -->
                        </div>
                    </div>
                    
                    <div class="card mb-4" data-aos="fade-left" data-aos-delay="500">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">External Links</h5>
                        </div>
                        <div class="card-body" id="links-container">
                            <!-- Links will be loaded here -->
                        </div>
                    </div>
                    
                    <div class="card mb-4" data-aos="fade-left" data-aos-delay="600">
                        <div class="card-header">
                            <h5 class="mb-0 text-white">Project Stats</h5>
                        </div>
                        <div class="card-body" id="stats-container">
                            <!-- Stats will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'src/includes/footer.php'; ?>

    <!-- Add lightbox container -->
    <div class="lightbox" id="lightbox">
        <div class="lightbox-content">
            <img src="" alt="" class="lightbox-image" id="lightbox-image">
            <div class="lightbox-caption" id="lightbox-caption"></div>
        </div>
        <div class="lightbox-close" id="lightbox-close">
            <i class="bi bi-x-lg"></i>
        </div>
        <div class="lightbox-navigation">
            <div class="lightbox-nav-btn" id="lightbox-prev">
                <i class="bi bi-chevron-left"></i>
            </div>
            <div class="lightbox-nav-btn" id="lightbox-next">
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        // Initialize AOS animations with performance optimization
        document.addEventListener('DOMContentLoaded', function() {
            // Use performance optimizer for AOS if available
            if (window.performanceOptimizer) {
                window.performanceOptimizer.optimizeAOS();
            } else {
                // Fallback optimized AOS configuration
                const isMobile = window.innerWidth <= 768;
                
                AOS.init({
                    duration: isMobile ? 300 : 600,
                    easing: 'ease-out',
                    once: true, // Only animate once for better performance
                    mirror: false, // Disable mirror for better performance
                    anchorPlacement: 'top-bottom',
                    offset: 50,
                    disable: isMobile ? 'mobile' : false
                });
            }
        });
        
        // Add futuristic effects to the page
        document.addEventListener('DOMContentLoaded', function() {
            // Add glow effect class to cards and interactive elements
            const glowElements = document.querySelectorAll(
                '.project-header, .card, .abstract-box, .metadata-card, .timeline-content, .member-card, .btn-primary'
            );
            
            glowElements.forEach(el => {
                el.classList.add('glow-effect');
            });
            
            // Add text-link class to appropriate links
            document.querySelectorAll('.link-hover').forEach(link => {
                link.classList.add('text-link');
            });
            
            // Add futuristic border effect to media cards
            document.querySelectorAll('.media-card').forEach(card => {
                card.classList.add('futuristic-border');
            });
            
            // Add typing cursor effect to project title
            const projectTitle = document.querySelector('.project-header h1');
            if (projectTitle) {
                const cursor = document.createElement('span');
                cursor.className = 'typing-cursor';
                projectTitle.appendChild(cursor);
            }
            
            // Add data loading effect to stats
            document.querySelectorAll('.progress-bar').forEach(bar => {
                bar.classList.add('data-loading');
            });
            
            // Add text glow effect to important items
            document.querySelectorAll('.status-badge, .timeline-title, .member-name').forEach(item => {
                item.classList.add('text-glow');
            });
            
            // Add terminal effect to tech-related text
            document.querySelectorAll('.member-id span').forEach(item => {
                item.classList.add('terminal-text');
            });
        });

            // Get project ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const projectId = urlParams.get('id');

        // Function to create ripple effect on buttons
        function createRipple(event) {
            const button = event.currentTarget;
            
            // Remove any existing ripple elements
            const ripples = button.getElementsByClassName("ripple");
            for (let i = 0; i < ripples.length; i++) {
                button.removeChild(ripples[i]);
            }
            
            const circle = document.createElement("span");
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;
            
            // Calculate position of ripple based on click coordinates
            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - button.getBoundingClientRect().left - radius}px`;
            circle.style.top = `${event.clientY - button.getBoundingClientRect().top - radius}px`;
            circle.classList.add("ripple");
            
            button.appendChild(circle);
        }
        
        // Apply ripple effect to buttons when DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // We already initialized AOS above, so removing this duplicate initialization
            /* 
            AOS.init({
                duration: 1000,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
            */
            
            // Setup ripple effect for buttons
            const buttons = document.querySelectorAll('.custom-btn, .toggle-btn');
            buttons.forEach(button => {
                button.addEventListener('click', createRipple);
            });
            
            // Animate project title if available
            if (projectId) {
                animateProjectTitle();
            }
        });
        
        // Function to animate project title with shimmer effect
        function animateProjectTitle() {
            const projectTitle = document.querySelector('.project-title');
            if (projectTitle) {
                // Add shimmer class for the effect
                projectTitle.classList.add('shimmer-text');
                
                // Use GSAP to animate the title
                gsap.to(projectTitle, {
                    backgroundPosition: '200% center',
                    color: '#333333',
                    duration: 3,
                    ease: "power1.inOut",
                    repeat: -1,
                    yoyo: true
                });
            }
        }

        // Function to fetch and display project details
        document.addEventListener('DOMContentLoaded', function() {
            // We already initialized AOS above, so removing this duplicate initialization
            /* 
            AOS.init({
                duration: 1000,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
            */

            // Setup ripple effect for buttons
            const buttons = document.querySelectorAll('.custom-btn, .toggle-btn');
            buttons.forEach(button => {
                button.addEventListener('click', createRipple);
            });

            // Function to create ripple effect on button click
            function createRipple(event) {
                const button = event.currentTarget;
                const circle = document.createElement('span');
                const diameter = Math.max(button.clientWidth, button.clientHeight);
                const radius = diameter / 2;

                circle.style.width = circle.style.height = `${diameter}px`;
                circle.style.left = `${event.clientX - button.getBoundingClientRect().left - radius}px`;
                circle.style.top = `${event.clientY - button.getBoundingClientRect().top - radius}px`;
                circle.classList.add('ripple');

                const ripple = button.querySelector('.ripple');
                if (ripple) {
                    ripple.remove();
                }

                button.appendChild(circle);
            }

            // Function to animate project title with shimmer effect
            function animateProjectTitle() {
                const projectTitle = document.querySelector('.project-title');
                if (!projectTitle) return;

                // Initial entrance animation
                gsap.fromTo(projectTitle, 
                    { opacity: 0, y: -20 }, 
                    { opacity: 1, y: 0, duration: 1, ease: "power2.out" }
                );

                // Create shimmer effect
                const shimmer = document.createElement('div');
                shimmer.classList.add('shimmer');
                projectTitle.appendChild(shimmer);

                // Continuous shimmer animation
                gsap.to(shimmer, {
                    x: "100%", 
                    duration: 2.5, 
                    repeat: -1, 
                    ease: "power1.inOut",
                    delay: 1
                });
            }

            // Add CSS for shimmer effect
            const style = document.createElement('style');
            style.textContent = `
                .project-title {
                    position: relative;
                    overflow: hidden;
                }
                .shimmer {
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 50%;
                    height: 100%;
                    background: linear-gradient(
                        90deg, 
                        rgba(255,255,255,0) 0%, 
                        rgba(255,255,255,0.3) 50%, 
                        rgba(255,255,255,0) 100%
                    );
                    pointer-events: none;
                }
            `;
            document.head.appendChild(style);

            // Get the project ID from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const projectId = urlParams.get('id');
            
            if (!projectId) {
                showProjectNotFound();
                return;
            }
            
            // Fetch project details
            fetch(`src/model/fetch_project_by_id.php?id=${projectId}`)
                .then(response => response.json())
                .then(project => {
                    if (project.error) {
                        showProjectNotFound();
                        return;
                    }
                    
                    // Hide loading spinner and show project details with nice fade effect
                    const loadingSpinner = document.getElementById('loading-spinner');
                    const projectDetails = document.getElementById('project-details');
                    
                    fadeOut(loadingSpinner, 400, function() {
                        fadeIn(projectDetails, 600);
                    
                    // Render project details
                    renderProjectHeader(project);
                    renderProjectAbstract(project);
                    renderProjectDescription(project);
                    renderProjectInfo(project);
                    renderTeamMembers(project);
                    renderKeywords(project);
                    renderResources(project);
                    renderExternalLinks(project);
                    renderTimeline(project);
                    renderReferences(project);
                    renderMedia(project);
                    renderStats(project);
                        
                        // Add title animation effect
                        animateProjectTitle();
                        
                        // Handle video iframe errors
                        handleVideoPlaceholders();
                        
                        // Refresh AOS after content is loaded
                        setTimeout(() => {
                            AOS.refresh();
                        }, 500);
                    });
                })
                .catch(error => {
                    console.error('Error fetching project:', error);
                    showProjectNotFound();
                });
        });
        
        // Function to handle video iframe loading errors
        function handleVideoPlaceholders() {
            const placeholderImage = 'assets/images/Research_Card_Placeholder.png';
            const iframes = document.querySelectorAll('.ratio iframe');
            
            iframes.forEach(iframe => {
                // Check if iframe is loaded correctly
                iframe.addEventListener('error', function() {
                    this.style.display = 'none';
                    this.parentNode.classList.add('placeholder-bg');
                });
                
                // Also try to detect if iframe src is invalid or doesn't load
                setTimeout(() => {
                    try {
                        if (!iframe.contentWindow || iframe.contentWindow.document.body.innerHTML === '') {
                            iframe.style.display = 'none';
                            iframe.parentNode.classList.add('placeholder-bg');
                        }
                    } catch (e) {
                        // If we can't access the iframe (cross-origin), assume it's working
                        // This is a limitation, but at least we tried
                    }
                }, 1000);
            });
        }
        
        // Custom fade functions for smoother transitions
        function fadeOut(element, duration, callback) {
            if (!element) return;
            
            element.style.opacity = 1;
            element.style.transition = `opacity ${duration}ms ease`;
            
            setTimeout(() => {
                element.style.opacity = 0;
                
                setTimeout(() => {
                    element.style.display = 'none';
                    if (typeof callback === 'function') callback();
                }, duration);
            }, 10);
        }
        
        function fadeIn(element, duration, callback) {
            if (!element) return;
            
            element.style.opacity = 0;
            element.style.display = 'block';
            element.style.transition = `opacity ${duration}ms ease`;
            
            setTimeout(() => {
                element.style.opacity = 1;
                
                setTimeout(() => {
                    if (typeof callback === 'function') callback();
                }, duration);
            }, 10);
        }
        
        function showProjectNotFound() {
            const loadingSpinner = document.getElementById('loading-spinner');
            const projectNotFound = document.getElementById('project-not-found');
            
            fadeOut(loadingSpinner, 400, function() {
                fadeIn(projectNotFound, 600);
            });
        }
        
        function renderProjectHeader(project) {
            const headerEl = document.getElementById('project-header');
            const isPublic = project.privacy === 0;
            
            const supervisorInfo = project.supervisor ? 
                `<div class="meta-item"><i class="bi bi-person-badge"></i><strong>Supervisor:</strong> ${project.supervisor.name || (typeof project.supervisor === 'string' ? project.supervisor : (project.supervisor.$oid || 'Unknown'))}</div>` : '';
            
            // Check if the current user is part of the project team (member or supervisor)
            // We need to fetch the current logged-in user information from PHP session
            let isAuthorized = false;
            let currentUser = null;
            
            // Fetch the current user ID from a PHP variable injected into the page
            if (typeof currentUserId !== 'undefined') {
                currentUser = currentUserId;
            }
            
            // Check if the current user is authorized to edit the project
            if (currentUser) {
                // Check if user is in members list (team members)
                if (project.members && project.members.length > 0) {
                    isAuthorized = project.members.some(member => 
                        (member.userId && member.userId.$oid === currentUser) || 
                        (member.userId === currentUser)
                    );
                }
                
                // Also check if user is the supervisor
                if (!isAuthorized && project.supervisor && project.supervisor.userId) {
                    isAuthorized = (project.supervisor.userId.$oid === currentUser) || 
                                  (project.supervisor.userId === currentUser);
                }
            }
            
            // Only show edit button if user is a team member or supervisor
            const editBtn = isAuthorized ? `
                <button id="editProjectBtn" class="btn btn-outline-primary ms-2" data-project-id="${project._id.$oid}">
                    <i class="bi bi-pencil-square"></i>Edit Project
                </button>
            ` : '';
            
            headerEl.innerHTML = `
                <div class="d-flex justify-content-between align-items-start position-relative z-1">
                    <div>
                        <h1 class="float-animation display-4">${project.title}</h1>
                        <div class="mb-3 d-flex align-items-center mt-3">
                            ${editBtn}
                        </div>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <div class="row section-row">
                    <div class="col-md-6">
                        <div class="meta-item">
                            <i class="bi bi-mortarboard-fill"></i>
                            <div><strong>Field:</strong> ${project.field || 'Not specified'}</div>
                    </div>
                        <div class="meta-item">
                            <i class="bi bi-building"></i>
                            <div><strong>Institution:</strong> ${project.institution || 'United International University'}</div>
                        </div>
                        ${supervisorInfo ? `<div class="meta-item">
                            <i class="bi bi-person-badge"></i>
                            <div><strong>Supervisor:</strong> ${project.supervisor.name || (typeof project.supervisor === 'string' ? project.supervisor : (project.supervisor.$oid || 'Unknown'))}</div>
                        </div>` : ''}
                    </div>
                    <div class="col-md-6">
                        <div class="meta-item">
                            <i class="bi bi-calendar-plus"></i>
                            <div><strong>Created:</strong> ${formatDate(project.createdAt)}</div>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar-check"></i>
                            <div><strong>Last Updated:</strong> ${formatDate(project.updatedAt)}</div>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-eye"></i>
                            <div><strong>Views:</strong> ${project.stats?.views || '0'}</div>
                        </div>
                    </div>
                </div>
            `;
            
            // Add event listener for the edit button
            const editButton = document.getElementById('editProjectBtn');
            if (editButton) {
                editButton.addEventListener('click', function() {
                    const projectId = this.getAttribute('data-project-id');
                    window.location.href = `edit_project.php?id=${projectId}`;
                });
                
                // Add ripple effect to the button
                editButton.addEventListener('mousedown', createRipple);
            }
            
            // Update page title
            document.title = `${project.title} | UIU Research Platform`;
            
            // Add animation for the title to make it stand out
            animateProjectTitle();
        }
        
        function renderProjectAbstract(project) {
            if (project.abstract) {
                const abstractEl = document.getElementById('project-abstract');
                
                // Wrap important keywords with highlight span
                // This makes key terms stand out in the abstract
                let enhancedAbstract = project.abstract;
                
                // Get keywords from project if available
                if (project.keywords && project.keywords.length > 0) {
                    // Sort keywords by length (longest first) to avoid partial replacements
                    const sortedKeywords = [...project.keywords].sort((a, b) => b.length - a.length);
                    
                    // Replace keywords with highlighted versions, but only the first occurrence
                    sortedKeywords.forEach(keyword => {
                        // Use case-insensitive regex but preserve original case in replacement
                        const regex = new RegExp(`(${keyword})`, 'i');
                        // Only replace if found and not already highlighted
                        if (regex.test(enhancedAbstract) && !enhancedAbstract.includes(`<span class="abstract-highlight">${keyword}</span>`)) {
                            enhancedAbstract = enhancedAbstract.replace(regex, `<span class="abstract-highlight">$1</span>`);
                        }
                    });
                }
                
                abstractEl.innerHTML = `
                    <h3 class="section-title">Abstract</h3>
                    <p>${enhancedAbstract}</p>
                    <div class="d-flex justify-content-end mt-3">
                        <small class="fst-italic" style="color: #ffffff !important;">Last updated: ${formatDate(project.updatedAt)}</small>
                    </div>
                `;
                
                // Ensure the abstract is visible before animation
                const abstractText = abstractEl.querySelector('p');
                if (abstractText) {
                    abstractText.style.opacity = 1;
                    
                    // Simpler, more reliable animation
                    setTimeout(() => {
                        abstractText.classList.add('animated');
                    }, 500);
                }
            }
        }
        
        function renderProjectDescription(project) {
            if (project.description) {
                const descriptionEl = document.getElementById('project-description');
                
                // Enhance description with keyword highlighting
                let enhancedDescription = project.description;
                
                // Get keywords from project if available
                if (project.keywords && project.keywords.length > 0) {
                    // Sort keywords by length (longest first) to avoid partial replacements
                    const sortedKeywords = [...project.keywords].sort((a, b) => b.length - a.length);
                    
                    // Replace keywords with highlighted versions
                    sortedKeywords.forEach(keyword => {
                        // Use case-insensitive regex but preserve original case in replacement
                        const regex = new RegExp(`(${keyword})`, 'gi');
                        enhancedDescription = enhancedDescription.replace(regex, 
                            `<span class="description-highlight">$1</span>`);
                    });
                }
                
                // Format content - identify and format sections based on common patterns
                // This tries to identify sections in the description and format them
                let formattedDescription = enhancedDescription;
                
                // Try to identify sections by looking for patterns like "Objectives:" or "Methodology:"
                const sectionRegex = /(?:<br>|<p>|^)([\w\s]+):\s*(?=<br>|<p>|$)/g;
                formattedDescription = formattedDescription.replace(sectionRegex, 
                    `<div class="description-section">
                        <div class="description-section-title">
                            <i class="bi bi-bookmark-fill"></i>$1
                        </div>`);
                
                // Close any opened section divs
                if (formattedDescription.includes('description-section-title')) {
                    formattedDescription += '</div>';
                }
                
                // Wrap content in a description box
                descriptionEl.innerHTML = `
                    <div class="description-box">
                        <h3 class="section-title">Description</h3>
                        <div>${formattedDescription}</div>
                        <div class="d-flex justify-content-end mt-3">
                            <small class="fst-italic" style="color: #ffffff !important;">Last updated: ${formatDate(project.updatedAt)}</small>
                        </div>
                    </div>
                `;
                
                // Ensure the description is visible
                const descriptionContent = descriptionEl.querySelector('.description-box > div');
                if (descriptionContent) {
                    descriptionContent.style.opacity = 1;
                    
                    // Apply subtle entrance animation
                    setTimeout(() => {
                        descriptionContent.classList.add('animated');
                    }, 700);
                }
            }
        }
        
        function renderProjectInfo(project) {
            const infoEl = document.getElementById('project-info');
            
            // Format the created and updated dates
            const createdDate = formatDate(project.createdAt);
            const updatedDate = formatDate(project.updatedAt);
            
            // Generate supervisor info if available
            const supervisorInfo = project.supervisor ? 
                `<p><i class="bi bi-person-badge me-2"></i><strong>Supervisor:</strong> ${project.supervisor.name || (typeof project.supervisor === 'string' ? project.supervisor : (project.supervisor.$oid || 'Unknown'))}</p>` : '';
            
            infoEl.innerHTML = `
                <p><i class="bi bi-mortarboard-fill me-2"></i><strong>Field:</strong> ${project.field || 'Not specified'}</p>
                <p><i class="bi bi-building me-2"></i><strong>Institution:</strong> ${project.institution || 'United International University'}</p>
                ${supervisorInfo}
                <p><i class="bi bi-calendar-plus me-2"></i><strong>Created:</strong> ${createdDate}</p>
                <p><i class="bi bi-calendar-check me-2"></i><strong>Last Updated:</strong> ${updatedDate}</p>
                <p><i class="bi bi-shield-lock me-2"></i><strong>Status:</strong> ${project.privacy === 0 ? 'Public' : 'Private'}</p>
            `;
        }
        
        function renderTeamMembers(project) {
            const membersEl = document.getElementById('team-members');
            
            if (!project.members || project.members.length === 0) {
                membersEl.innerHTML = '<p style="color: var(--text-secondary);">No team members listed</p>';
                return;
            }
            
            let membersHTML = '';
            
            // Sort members by contribution percentage (if available)
            const sortedMembers = [...project.members].sort((a, b) => 
                (b.contribution || 0) - (a.contribution || 0)
            );
            
            sortedMembers.forEach(member => {
                const name = member.name || 'Unnamed Member';
                const role = member.role || 'Team Member';
                
                // Get contribution level label and icon
                let contributionLabel = '';
                let roleIcon = 'bi-person';
                
                if (member.contribution) {
                    if (member.contribution >= 70) {
                        contributionLabel = 'Lead Contributor';
                        roleIcon = 'bi-star-fill';
                    }
                    else if (member.contribution >= 40) {
                        contributionLabel = 'Major Contributor';
                        roleIcon = 'bi-star-half';
                    }
                    else if (member.contribution >= 20) {
                        contributionLabel = 'Contributor';
                        roleIcon = 'bi-star';
                    }
                    else {
                        contributionLabel = 'Supporting Member';
                        roleIcon = 'bi-person-check';
                    }
                }
                
                // Create progress bar with label
                const contribution = member.contribution ? `
                    <div class="contribution-section">
                        <div class="progress-label">
                            <div class="contribution-text">Contribution <strong>${member.contribution}%</strong></div>
                            <div class="progress-percentage">
                                ${contributionLabel ? `<span class="contribution-level">${contributionLabel}</span>` : ''}
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" 
                            aria-valuenow="${member.contribution}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>` : '';
                
                membersHTML += `
                    <div class="member-card" data-contribution="${member.contribution || 0}" data-aos="fade-up">
                        <div class="member-name">
                            <i class="bi bi-person-circle me-2"></i>${name}
                        </div>
                        <div class="member-role">
                            <i class="bi ${roleIcon} me-2"></i>${role}
                        </div>
                        ${contribution}
                    </div>
                `;
            });
            
            membersEl.innerHTML = membersHTML;
            
            // Animate progress bars with a delay
            setTimeout(() => {
                const progressBars = document.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const contribution = bar.getAttribute('aria-valuenow');
                    bar.style.width = `${contribution}%`;
                });
            }, 500);
        }
        
        function renderKeywords(project) {
            const keywordsEl = document.getElementById('keywords-container');
            
            if (!project.keywords || project.keywords.length === 0) {
                keywordsEl.innerHTML = '<p style="color: var(--text-secondary);">No keywords listed</p>';
                return;
            }
            
            let keywordsHTML = '<div>';
            
            project.keywords.forEach(keyword => {
                keywordsHTML += `<span class="badge badge-custom">${keyword}</span> `;
            });
            
            keywordsHTML += '</div>';
            keywordsEl.innerHTML = keywordsHTML;
        }
        
        function renderResources(project) {
            const resourcesEl = document.getElementById('resources-container');
            
            if (!project.files || project.files.length === 0) {
                resourcesEl.innerHTML = '<p style="color: var(--text-secondary);">No files available</p>';
                return;
            }
            
            let resourcesHTML = '<ul class="list-group list-group-flush">';
            
            project.files.forEach(file => {
                const icon = getFileIcon(file.type);
                const size = formatFileSize(file.size);
                const date = formatDate(file.uploadedAt);
                
                resourcesHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="file-info">
                            <div class="file-name">
                                <i class="${icon} me-2"></i> ${file.name}
                            </div>
                            <small class="file-details">${size} - Uploaded on ${date}</small>
                        </div>
                        <a href="${file.path}" class="btn btn-sm download-btn" download>
                            <i class="bi bi-download"></i>
                            <span class="btn-text">Download</span>
                        </a>
                    </li>
                `;
            });
            
            resourcesHTML += '</ul>';
            resourcesEl.innerHTML = resourcesHTML;
        }
        
        function renderExternalLinks(project) {
            const linksEl = document.getElementById('links-container');
            
            if (!project.links || Object.keys(project.links).length === 0) {
                linksEl.innerHTML = '<p style="color: var(--text-secondary);">No external links available</p>';
                return;
            }
            
            let linksHTML = '<ul class="list-group list-group-flush">';
            
            if (project.links.github) {
                linksHTML += `
                    <li class="list-group-item">
                        <i class="bi bi-github me-2"></i>
                        <a href="${project.links.github}" target="_blank" rel="noopener" class="link-hover">GitHub Repository</a>
                    </li>
                `;
            }
            
            if (project.links.paper) {
                linksHTML += `
                    <li class="list-group-item">
                        <i class="bi bi-file-text me-2"></i>
                        <a href="${project.links.paper}" target="_blank" rel="noopener" class="link-hover">Research Paper</a>
                    </li>
                `;
            }
            
            if (project.links.doi) {
                linksHTML += `
                    <li class="list-group-item">
                        <i class="bi bi-diagram-3 me-2"></i>
                        <a href="${project.links.doi}" target="_blank" rel="noopener" class="link-hover">DOI Reference</a>
                    </li>
                `;
            }
            
            if (project.links.youtube) {
                linksHTML += `
                    <li class="list-group-item">
                        <i class="bi bi-youtube me-2"></i>
                        <a href="${project.links.youtube}" target="_blank" rel="noopener" class="link-hover">YouTube Video</a>
                    </li>
                `;
            }
            
            if (project.links.website) {
                linksHTML += `
                    <li class="list-group-item">
                        <i class="bi bi-globe me-2"></i>
                        <a href="${project.links.website}" target="_blank" rel="noopener" class="link-hover">Project Website</a>
                    </li>
                `;
            }
            
            linksHTML += '</ul>';
            linksEl.innerHTML = linksHTML;
        }
        
        function renderTimeline(project) {
            const timelineEl = document.getElementById('timeline-container');
            
            if (!project.timeline || project.timeline.length === 0) {
                document.getElementById('project-timeline').style.display = 'none';
                return;
            }
            
            let timelineHTML = '';
            
            // Sort timeline items by date
            const sortedTimeline = [...project.timeline].sort((a, b) => {
                // Convert dates to comparable values, defaulting to 0 for invalid dates
                let dateA, dateB;
                
                try {
                    dateA = a.date ? new Date(typeof a.date === 'object' && a.date.$date ? a.date.$date : a.date).getTime() : 0;
                } catch (e) {
                    dateA = 0;
                }
                
                try {
                    dateB = b.date ? new Date(typeof b.date === 'object' && b.date.$date ? b.date.$date : b.date).getTime() : 0;
                } catch (e) {
                    dateB = 0;
                }
                
                return dateA - dateB;
            });
            
            // Calculate progress statistics
            const completedItems = sortedTimeline.filter(item => 
                item.status && item.status.toLowerCase().includes('completed')).length;
            const totalItems = sortedTimeline.length;
            const progressPercentage = totalItems > 0 ? Math.round((completedItems / totalItems) * 100) : 0;
            
            // Add progress indicator
            timelineHTML += `
                <div class="timeline-progress" id="timeline-progress"></div>
                <div class="timeline-progress-indicator" id="progress-indicator">
                    <i class="bi bi-graph-up me-2"></i>
                    <span id="progress-text">${progressPercentage}% Complete</span>
                    <span class="ms-2 text-muted">(${completedItems}/${totalItems})</span>
                </div>
            `;
            
            // Display timeline items
            sortedTimeline.forEach((item, index) => {
                const date = formatDate(item.date);
                const status = getStatusBadge(item.status);
                const delay = 100 * (index + 1);
                
                // Determine status for styling
                let statusClass = 'pending';
                if (item.status) {
                    const statusLower = item.status.toLowerCase();
                    if (statusLower.includes('completed') || statusLower.includes('done') || statusLower.includes('finished')) {
                        statusClass = 'completed';
                    } else if (statusLower.includes('progress') || statusLower.includes('active') || statusLower.includes('ongoing')) {
                        statusClass = 'in-progress';
                    }
                }
                
                // Get appropriate icon based on title or status
                let icon = 'bi-calendar-event';
                const titleLower = item.title.toLowerCase();
                if (titleLower.includes('research') || titleLower.includes('study')) icon = 'bi-search';
                if (titleLower.includes('design') || titleLower.includes('plan')) icon = 'bi-pencil-square';
                if (titleLower.includes('development') || titleLower.includes('build') || titleLower.includes('code')) icon = 'bi-code-slash';
                if (titleLower.includes('test') || titleLower.includes('validation')) icon = 'bi-check-circle';
                if (titleLower.includes('review') || titleLower.includes('evaluation')) icon = 'bi-eye';
                if (titleLower.includes('presentation') || titleLower.includes('demo')) icon = 'bi-easel';
                if (titleLower.includes('publication') || titleLower.includes('report')) icon = 'bi-journal-text';
                if (titleLower.includes('meeting') || titleLower.includes('discussion')) icon = 'bi-people';
                if (titleLower.includes('analysis') || titleLower.includes('analyze')) icon = 'bi-graph-up-arrow';
                if (titleLower.includes('implementation') || titleLower.includes('deploy')) icon = 'bi-gear';
                if (titleLower.includes('documentation') || titleLower.includes('document')) icon = 'bi-file-text';
                
                // Add enhanced description if available
                const description = item.description || 'No description available';
                const truncatedDescription = description.length > 150 ? 
                    description.substring(0, 150) + '...' : description;
                
                // Add duration if available
                let durationInfo = '';
                if (item.duration) {
                    durationInfo = `<div class="timeline-duration mt-2">
                        <i class="bi bi-stopwatch me-1"></i>
                        <span class="text-muted">${item.duration}</span>
                    </div>`;
                }
                
                // Add team members if available
                let teamInfo = '';
                if (item.team && item.team.length > 0) {
                    const teamMembers = item.team.slice(0, 3).join(', ');
                    const moreMembers = item.team.length > 3 ? ` +${item.team.length - 3} more` : '';
                    teamInfo = `<div class="timeline-team mt-2">
                        <i class="bi bi-people-fill me-1"></i>
                        <span class="text-muted small">${teamMembers}${moreMembers}</span>
                    </div>`;
                }
                
                timelineHTML += `
                    <div class="timeline-item timeline-right" 
                         data-status="${statusClass}"
                         data-aos="fade-left" 
                         data-aos-delay="${delay}"
                         data-timeline-index="${index}"
                         onclick="highlightTimelineItem(${index})">
                        <div class="timeline-content">
                            <div class="timeline-title-row">
                                <div class="timeline-title">
                                    <i class="bi ${icon} timeline-icon"></i>
                                    <span class="timeline-title-text">${item.title}</span>
                                </div>
                                <span class="timeline-status">${status}</span>
                            </div>
                            <p class="timeline-description mb-2" title="${description}">
                                ${truncatedDescription}
                                ${description.length > 150 ? 
                                    `<button class="btn btn-link btn-sm p-0 ms-1" onclick="expandDescription(event, ${index})">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>` : ''
                                }
                            </p>
                            <div class="timeline-date">
                                <i class="bi bi-clock"></i>${date}
                            </div>
                            ${durationInfo}
                            ${teamInfo}
                        </div>
                    </div>
                `;
            });
            
            // Set the HTML content before adding the date labels
            timelineEl.innerHTML = timelineHTML;
            
            // Add labels for start and end dates if available
            if (sortedTimeline.length > 0) {
                const firstItem = sortedTimeline[0];
                const lastItem = sortedTimeline[sortedTimeline.length - 1];
                
                if (firstItem.date && lastItem.date) {
                    const startDate = formatDate(firstItem.date);
                    const endDate = formatDate(lastItem.date);
                    
                    // Calculate total project duration
                    const startDateObj = new Date(typeof firstItem.date === 'object' && firstItem.date.$date ? 
                        firstItem.date.$date : firstItem.date);
                    const endDateObj = new Date(typeof lastItem.date === 'object' && lastItem.date.$date ? 
                        lastItem.date.$date : lastItem.date);
                    const durationDays = Math.ceil((endDateObj - startDateObj) / (1000 * 60 * 60 * 24));
                    const durationText = durationDays > 0 ? ` (${durationDays} days)` : '';
                    
                    // Add a tooltip or label for the start marker
                    const startMarker = document.createElement('div');
                    startMarker.className = 'timeline-marker-label timeline-start-label';
                    startMarker.innerHTML = `
                        <i class="bi bi-play-circle me-1"></i>
                        <strong>Project Started:</strong> ${startDate}
                    `;
                    timelineEl.insertBefore(startMarker, timelineEl.firstChild);
                    
                    // Add a tooltip or label for the end marker
                    const endMarker = document.createElement('div');
                    endMarker.className = 'timeline-marker-label timeline-end-label';
                    endMarker.innerHTML = `
                        <i class="bi bi-flag-fill me-1"></i>
                        <strong>Last Update:</strong> ${endDate}${durationText}
                    `;
                    timelineEl.appendChild(endMarker);
                }
            }
            
            // Initialize timeline enhancements
            initTimelineEnhancements();
        }
        
        // Add timeline enhancement functions
        function initTimelineEnhancements() {
            // Add scroll-based progress animation
            function updateTimelineProgress() {
                const timelineContainer = document.getElementById('timeline-container');
                const progressLine = document.getElementById('timeline-progress');
                const progressIndicator = document.getElementById('progress-indicator');
                
                if (!timelineContainer || !progressLine) return;
                
                const containerRect = timelineContainer.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                const containerTop = containerRect.top;
                const containerHeight = containerRect.height;
                
                // Calculate scroll progress
                let scrollProgress = 0;
                if (containerTop < windowHeight && containerTop + containerHeight > 0) {
                    const visibleHeight = Math.min(windowHeight - Math.max(containerTop, 0), 
                        containerHeight - Math.max(0, -containerTop));
                    scrollProgress = Math.max(0, Math.min(1, visibleHeight / containerHeight));
                }
                
                // Update progress line
                progressLine.style.height = `${scrollProgress * 100}%`;
                
                // Update progress indicator visibility
                if (progressIndicator) {
                    progressIndicator.style.opacity = scrollProgress > 0.1 ? '1' : '0';
                    progressIndicator.style.transform = `translateX(-50%) translateY(${scrollProgress < 0.1 ? '-20px' : '0'})`;
                }
            }
            
            // Add event listeners
            window.addEventListener('scroll', updateTimelineProgress, { passive: true });
            window.addEventListener('resize', updateTimelineProgress, { passive: true });
            
            // Initial call
            setTimeout(updateTimelineProgress, 100);
            
            // Add intersection observer for timeline items
            const timelineItems = document.querySelectorAll('.timeline-item');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('timeline-visible');
                        // Add a subtle pulse effect when item comes into view
                        setTimeout(() => {
                            const icon = entry.target.querySelector('.timeline-icon');
                            if (icon) {
                                icon.style.animation = 'pulse-once 0.6s ease-out';
                                setTimeout(() => {
                                    icon.style.animation = '';
                                }, 600);
                            }
                        }, 200);
                    }
                });
            }, {
                threshold: 0.3,
                rootMargin: '0px 0px -50px 0px'
            });
            
            timelineItems.forEach(item => observer.observe(item));
        }
        
        // Function to highlight a timeline item when clicked
        function highlightTimelineItem(index) {
            // Remove previous highlights
            document.querySelectorAll('.timeline-item').forEach(item => {
                item.classList.remove('timeline-highlighted');
            });
            
            // Add highlight to clicked item
            const clickedItem = document.querySelector(`[data-timeline-index="${index}"]`);
            if (clickedItem) {
                clickedItem.classList.add('timeline-highlighted');
                
                // Add temporary highlight class
                setTimeout(() => {
                    clickedItem.classList.remove('timeline-highlighted');
                }, 2000);
                
                // Scroll item into view smoothly
                clickedItem.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }
        }
        
        // Function to expand/collapse timeline descriptions
        function expandDescription(event, index) {
            event.stopPropagation();
            const item = document.querySelector(`[data-timeline-index="${index}"]`);
            const description = item.querySelector('.timeline-description');
            const button = event.target.closest('button');
            const icon = button.querySelector('i');
            
            if (description.classList.contains('expanded')) {
                // Collapse
                description.classList.remove('expanded');
                icon.className = 'bi bi-chevron-down';
                // Restore truncated text (you'd need to store original text)
            } else {
                // Expand
                description.classList.add('expanded');
                icon.className = 'bi bi-chevron-up';
                // Show full text (you'd need to store original text)
            }
        }
        
        // Add CSS for timeline enhancements
        const timelineCSS = `
            <style>
                .timeline-visible {
                    opacity: 1 !important;
                }
                
                .timeline-highlighted {
                    transform: translateY(-10px) scale(1.03) !important;
                    z-index: 100 !important;
                }
                
                .timeline-highlighted .timeline-content {
                    box-shadow: 
                        0 25px 50px rgba(0, 0, 0, 0.3),
                        0 0 50px rgba(76, 201, 240, 0.5),
                        0 0 100px rgba(76, 201, 240, 0.2) !important;
                    border-left-width: 8px !important;
                }
                
                .timeline-duration,
                .timeline-team {
                    font-size: 0.8rem;
                    opacity: 0.8;
                    transition: opacity 0.3s ease;
                }
                
                .timeline-content:hover .timeline-duration,
                .timeline-content:hover .timeline-team {
                    opacity: 1;
                }
                
                .timeline-description.expanded {
                    max-height: none !important;
                    overflow: visible !important;
                }
                
                @keyframes pulse-once {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.3); }
                    100% { transform: scale(1); }
                }
            </style>
        `;
        
        // Inject the CSS
        if (!document.querySelector('#timeline-enhancements-css')) {
            const styleElement = document.createElement('div');
            styleElement.id = 'timeline-enhancements-css';
            styleElement.innerHTML = timelineCSS;
            document.head.appendChild(styleElement);
        }
        
        function renderReferences(project) {
            const referencesEl = document.getElementById('references-container');
            
            if (!project.references || project.references.length === 0) {
                document.getElementById('project-references').style.display = 'none';
                return;
            }
            
            let referencesHTML = '';
            
            project.references.forEach((ref, index) => {
                referencesHTML += `
                    <div class="reference-item" data-aos="fade-up" data-aos-delay="${100 * (index + 1)}">
                        <h5 class="mb-2">${ref.title}</h5>
                        <a href="${ref.link}" target="_blank" rel="noopener" class="small link-hover">
                            <i class="bi bi-link-45deg me-1"></i>${ref.link}
                        </a>
                    </div>
                `;
            });
            
            referencesEl.innerHTML = referencesHTML;
        }
        
        function renderMedia(project) {
            const mediaEl = document.getElementById('media-container');
            
            if (!project.media || project.media.length === 0) {
                document.getElementById('project-media').style.display = 'none';
                return;
            }
            
            let mediaHTML = '';
            
            // Store media items for lightbox functionality
            window.projectMedia = project.media;
            
            project.media.forEach((item, index) => {
                // Set placeholder image path
                const placeholderImage = 'assets/images/Research_Card_Placeholder.png';
                
                if (item.type === 'image') {
                    // Use the actual image URL with fallback to placeholder
                    const imageUrl = item.url || placeholderImage;
                    
                    mediaHTML += `
                        <div class="col-sm-6 col-lg-4 mb-4" data-aos="zoom-in" data-aos-delay="${100 * (index + 1)}">
                            <div class="media-card image-card" data-media-index="${index}">
                                <div class="media-counter">${index + 1}/${project.media.length}</div>
                                <div class="media-type-badge">
                                    <i class="bi bi-image me-1"></i> Image
                                </div>
                                <img src="${imageUrl}" alt="${item.caption || 'Project image'}" class="media-image" 
                                     onerror="this.onerror=null; this.src='${placeholderImage}';">
                                <div class="media-overlay"></div>
                                <div class="media-caption">${item.caption || 'Project image'}</div>
                                <div class="media-zoom-icon" onclick="openLightbox(${index})">
                                    <i class="bi bi-zoom-in"></i>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (item.type === 'video') {
                    // For videos, we'll need special handling for the iframe
                    const videoUrl = item.url || '';
                    const videoCaption = item.caption || 'Project video';
                    
                    mediaHTML += `
                        <div class="col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="${100 * (index + 1)}">
                            <div class="media-card video-card">
                                <div class="media-counter">${index + 1}/${project.media.length}</div>
                                <div class="media-type-badge">
                                    <i class="bi bi-film me-1"></i> Video
                                </div>
                                <div class="ratio ratio-16x9" id="video-container-${index}">
                                    ${videoUrl ? 
                                        `<iframe src="${videoUrl}" title="${videoCaption}" allowfullscreen
                                            onerror="handleVideoError(this, '${placeholderImage}')"></iframe>` : 
                                        `<div class="placeholder-bg" style="background-image: url('${placeholderImage}')"></div>`
                                    }
                                </div>
                                <div class="video-caption">${videoCaption}</div>
                            </div>
                        </div>
                    `;
                }
            });
            
            mediaEl.innerHTML = mediaHTML;
            
            // Initialize lightbox functionality
            initLightbox();
        }
        
        // Handler for video loading errors
        function handleVideoError(iframe, placeholderUrl) {
            if (iframe) {
                iframe.style.display = 'none';
                const container = iframe.parentNode;
                container.classList.add('placeholder-bg');
                container.style.backgroundImage = `url('${placeholderUrl}')`;
            }
        }
        
        // Lightbox functionality
        function initLightbox() {
            const lightbox = document.getElementById('lightbox');
            const lightboxClose = document.getElementById('lightbox-close');
            const lightboxPrev = document.getElementById('lightbox-prev');
            const lightboxNext = document.getElementById('lightbox-next');
            
            // Close lightbox when clicking the close button
            lightboxClose.addEventListener('click', closeLightbox);
            
            // Close lightbox when clicking outside the image
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
            
            // Navigation buttons
            lightboxPrev.addEventListener('click', showPrevImage);
            lightboxNext.addEventListener('click', showNextImage);
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (!lightbox.classList.contains('active')) return;
                
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') showPrevImage();
                if (e.key === 'ArrowRight') showNextImage();
            });
            
            // Make image cards clickable
            const imageCards = document.querySelectorAll('.image-card');
            imageCards.forEach(card => {
                card.addEventListener('click', function() {
                    const index = parseInt(card.getAttribute('data-media-index'));
                    openLightbox(index);
                });
            });
        }
        
        // Current image index in lightbox
        let currentImageIndex = 0;
        
        // Updated lightbox function for placeholder handling
        function openLightbox(index) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            const lightboxCaption = document.getElementById('lightbox-caption');
            
            currentImageIndex = index;
            
            // Get media item
            const media = window.projectMedia[index];
            const placeholderImage = 'assets/images/Research_Card_Placeholder.png';
            
            // Set image source and caption
            lightboxImage.src = media.url || placeholderImage;
            lightboxCaption.textContent = media.caption || '';
            
            // Add error handling for the lightbox image
            lightboxImage.onerror = function() {
                this.onerror = null;
                this.src = placeholderImage;
            };
            
            // Show lightbox
            lightbox.classList.add('active');
            
            // Disable body scrolling
            document.body.style.overflow = 'hidden';
        }
        
        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('active');
            
            // Re-enable body scrolling
            document.body.style.overflow = '';
        }
        
        function showPrevImage() {
            if (!window.projectMedia) return;
            
            // Find previous image (skip videos)
            let index = currentImageIndex;
            do {
                index = (index - 1 + window.projectMedia.length) % window.projectMedia.length;
            } while (window.projectMedia[index].type !== 'image' && index !== currentImageIndex);
            
            if (window.projectMedia[index].type === 'image') {
                openLightbox(index);
            }
        }
        
        function showNextImage() {
            if (!window.projectMedia) return;
            
            // Find next image (skip videos)
            let index = currentImageIndex;
            do {
                index = (index + 1) % window.projectMedia.length;
            } while (window.projectMedia[index].type !== 'image' && index !== currentImageIndex);
            
            if (window.projectMedia[index].type === 'image') {
                openLightbox(index);
            }
        }
        
        function renderStats(project) {
            const statsEl = document.getElementById('stats-container');
            
            if (!project.stats) {
                statsEl.innerHTML = '<p class="text-muted">No statistics available</p>';
                return;
            }
            
            let statsHTML = '<ul class="list-group list-group-flush">';
            
            if (project.stats.views) {
                statsHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-eye me-2"></i>Views</span>
                        <span class="badge bg-primary rounded-pill">${project.stats.views}</span>
                    </li>
                `;
            }
            
            if (project.stats.downloads) {
                statsHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-download me-2"></i>Downloads</span>
                        <span class="badge bg-primary rounded-pill">${project.stats.downloads}</span>
                    </li>
                `;
            }
            
            if (project.stats.favorites) {
                statsHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-star me-2"></i>Favorites</span>
                        <span class="badge bg-primary rounded-pill">${project.stats.favorites}</span>
                    </li>
                `;
            }
            
            statsHTML += '</ul>';
            statsEl.innerHTML = statsHTML;
        }
        
        // Helper functions
        function formatDate(dateString) {
            if (!dateString) return 'Not specified';
            
            try {
                // MongoDB dates can come as objects with $date property or as ISO strings
                const dateValue = typeof dateString === 'object' && dateString.$date 
                    ? dateString.$date 
                    : dateString;
                    
                const date = new Date(dateValue);
                
                // Check if date is valid
                if (isNaN(date.getTime())) {
                    return 'Invalid date';
                }
                
                return date.toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric'
                });
            } catch (error) {
                console.error('Error formatting date:', error);
                return 'Date format error';
            }
        }
        
        function getFileIcon(fileType) {
            if (!fileType) return 'bi bi-file';
            
            if (fileType.includes('pdf')) return 'bi bi-file-pdf';
            if (fileType.includes('word') || fileType.includes('document')) return 'bi bi-file-word';
            if (fileType.includes('excel') || fileType.includes('sheet')) return 'bi bi-file-excel';
            if (fileType.includes('powerpoint') || fileType.includes('presentation')) return 'bi bi-file-ppt';
            if (fileType.includes('image')) return 'bi bi-file-image';
            if (fileType.includes('video')) return 'bi bi-file-play';
            if (fileType.includes('audio')) return 'bi bi-file-music';
            if (fileType.includes('zip') || fileType.includes('rar') || fileType.includes('7z')) return 'bi bi-file-zip';
            if (fileType.includes('code') || fileType.includes('text')) return 'bi bi-file-code';
            
            return 'bi bi-file';
        }
        
        function formatFileSize(bytes) {
            if (!bytes || bytes === 0) return 'Unknown size';
            
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            
            return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        function getStatusBadge(status) {
            if (!status) return '';
            
            const statusLower = status.toLowerCase();
            let badgeClass = 'bg-secondary text-white';
            let icon = 'bi-question-circle';
            
            if (statusLower === 'completed') {
                badgeClass = 'bg-success text-white';
                icon = 'bi-check-circle';
            }
            else if (statusLower === 'in progress') {
                badgeClass = 'bg-primary text-white';
                icon = 'bi-play-fill';
            }
            else if (statusLower === 'pending') {
                badgeClass = 'bg-warning text-dark';
                icon = 'bi-hourglass-split';
            }
            else if (statusLower === 'delayed') {
                badgeClass = 'bg-danger text-white';
                icon = 'bi-exclamation-triangle';
            }
            
            return `<span class="badge ${badgeClass}"><i class="bi ${icon} me-1"></i>${status}</span>`;
        }

        /**
         * Toggle project privacy between public and private
         * @param {string} projectId - The ID of the project to toggle
         */
        function toggleProjectPrivacy(projectId) {
            if (!projectId) {
                console.error('Missing project ID');
                return;
            }
            
            // Disable the button during the API call
            const toggleButton = document.getElementById('privacyToggleBtn');
            toggleButton.disabled = true;
            toggleButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
            
            // Call the API to toggle privacy
            fetch('src/model/toggle_project_privacy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ projectId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showToast('Privacy setting updated successfully', 'success');
                    
                    // Reload the page to reflect the new privacy setting
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error message
                    showToast(data.error || 'Failed to update privacy setting', 'danger');
                    
                    // Re-enable the button
                    toggleButton.disabled = false;
                    const isCurrentlyPublic = toggleButton.classList.contains('btn-outline-warning');
                    const btnText = isCurrentlyPublic ? 'Make Private' : 'Make Public';
                    const iconClass = isCurrentlyPublic ? 'bi-lock-fill' : 'bi-unlock-fill';
                    toggleButton.innerHTML = `<i class="bi ${iconClass} me-1"></i>${btnText}`;
                }
            })
            .catch(error => {
                console.error('Error toggling privacy:', error);
                showToast('An error occurred. Please try again.', 'danger');
                
                // Re-enable the button
                toggleButton.disabled = false;
                const isCurrentlyPublic = toggleButton.classList.contains('btn-outline-warning');
                const btnText = isCurrentlyPublic ? 'Make Private' : 'Make Public';
                const iconClass = isCurrentlyPublic ? 'bi-lock-fill' : 'bi-unlock-fill';
                toggleButton.innerHTML = `<i class="bi ${iconClass} me-1"></i>${btnText}`;
            });
        }

        /**
         * Show a toast notification
         * @param {string} message - The message to display
         * @param {string} type - The type of toast (success, danger, warning, info)
         */
        function showToast(message, type = 'info') {
            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
                toastContainer.style.zIndex = '1080';
                document.body.appendChild(toastContainer);
            }
            
            // Create toast element
            const toastId = 'toast-' + Date.now();
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.id = toastId;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.setAttribute('data-aos', 'fade-left');
            
            // Get appropriate icon
            let icon = 'bi-info-circle';
            if (type === 'success') icon = 'bi-check-circle';
            if (type === 'danger') icon = 'bi-exclamation-circle';
            if (type === 'warning') icon = 'bi-exclamation-triangle';
            
            // Create toast content
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi ${icon} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            // Add toast to container
            toastContainer.appendChild(toast);
            
            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();
            
            // Add entrance animation
            toast.style.transform = 'translateX(100%)';
            toast.style.transition = 'transform 0.3s ease';
            
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 50);
            
            // Remove toast from DOM after it's hidden
            toast.addEventListener('hidden.bs.toast', function() {
                // Add exit animation
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                toast.remove();
                }, 300);
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize particles.js with more optimized settings
      particlesJS('particles-js', {
          "particles": {
              "number": {
                  "value": 100,
                  "density": {
                      "enable": true,
                      "value_area": 1200
                  }
              },
              "color": {
                  "value": ["#3a86ff", "#4cc9f0", "#7209b7", "#2cb2f5", "#4361ee"]
              },
              "shape": {
                  "type": ["circle", "edge"],
                  "stroke": {
                      "width": 0,
                      "color": "#000000"
                  },
                  "polygon": {
                      "nb_sides": 6
                  }
              },
              "opacity": {
                  "value": 0.2,
                  "random": true,
                  "anim": {
                      "enable": true,
                      "speed": 0.5,
                      "opacity_min": 0.1,
                      "sync": false
                  }
              },
              "size": {
                  "value": 3,
                  "random": true,
                  "anim": {
                      "enable": true,
                      "speed": 1,
                      "size_min": 1,
                      "sync": false
                  }
              },
              "line_linked": {
                  "enable": true,
                  "distance": 150,
                  "color": "#3a86ff",
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
                  "bounce": false,
                  "attract": {
                      "enable": true,
                      "rotateX": 600,
                      "rotateY": 1200
                  }
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
                      "mode": "repulse"
                  },
                  "resize": true
              },
              "modes": {
                  "grab": {
                      "distance": 180,
                      "line_linked": {
                          "opacity": 0.5,
                          "color": "#4cc9f0"
                      }
                  },
                  "bubble": {
                      "distance": 200,
                      "size": 6,
                      "duration": 1.5,
                      "opacity": 0.6,
                      "speed": 3
                  },
                  "repulse": {
                      "distance": 200,
                      "duration": 1.5,
                      "speed": 2
                  },
                  "push": {
                      "particles_nb": 10
                  },
                  "remove": {
                      "particles_nb": 5
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
      
      // Create periodic wave effects through particles
      setInterval(() => {
          if (window.pJSDom && window.pJSDom[0] && window.pJSDom[0].pJS) {
              const particles = window.pJSDom[0].pJS.particles;
              
              // Only proceed if particles are moving
              if (!particles.move.enable) {
                  reinitializeParticlesIfNeeded();
                  return;
              }
              
              const centerX = window.innerWidth / 2;
              const centerY = window.innerHeight / 2;
              
              particles.array.forEach(particle => {
                  // Calculate distance from center
                  const dx = particle.x - centerX;
                  const dy = particle.y - centerY;
                  const distance = Math.sqrt(dx * dx + dy * dy);
                  
                  // Create a wave effect
                  const direction = distance > 0 ? (dx / distance) : 0;
                  
                  // Push particles slightly outward in a wave
                  particle.x += direction * 2;
                  
                  // Reset particles that go too far
                  if (particle.x > window.innerWidth) {
                      particle.x = 0;
                  } else if (particle.x < 0) {
                      particle.x = window.innerWidth;
                  }
              });
          } else {
              reinitializeParticlesIfNeeded();
          }
      }, 5000);
      
      // Ensure particles always stay active, check every 2 seconds
      setInterval(() => {
          reinitializeParticlesIfNeeded();
      }, 2000);
      
      // Make canvas and particles container un-clickable to prevent stopping animation
      const particlesContainer = document.getElementById('particles-js');
      if (particlesContainer) {
          particlesContainer.addEventListener('click', function(e) {
              e.stopPropagation();
              e.preventDefault();
              
              // Create burst effect without stopping the animation
              const burst = document.createElement('div');
              burst.classList.add('particle-burst');
              burst.style.left = e.pageX + 'px';
              burst.style.top = e.pageY + 'px';
              document.body.appendChild(burst);
              
              setTimeout(() => {
                  burst.remove();
              }, 1000);
              
              return false;
          }, true);
      }
      
      // Add global click handler for adding particles but prevent it from stopping animation
      document.addEventListener('click', function(e) {
          // Don't create particles for clicks on interactive elements
          if (e.target.closest('a, button, input, .search-box, .toggle-btn')) {
              return;
          }
          
          if (window.pJSDom && window.pJSDom[0] && window.pJSDom[0].pJS) {
              const pJS = window.pJSDom[0].pJS;
              
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
      
      // Add fade-in effect for particles
      setTimeout(() => {
          document.body.classList.add('loaded');
      }, 300);

    });

    // Function to improve file layout after rendering to prevent download button clipping
    function improveFileLayout() {
        const resourcesContainer = document.getElementById('resources-container');
        if (!resourcesContainer) return;
        
        // Find all file list items
        const fileItems = resourcesContainer.querySelectorAll('.list-group-item');
        
        fileItems.forEach(item => {
            // Update the structure to use the new layout
            const fileInfo = item.querySelector('.file-info');
            const downloadBtn = item.querySelector('.download-btn');
            const fileName = item.querySelector('.file-name');
            
            if (fileInfo && downloadBtn && fileName) {
                // Remove existing classes and add new ones
                item.className = 'list-group-item';
                
                // Wrap file info and download button in a container
                const container = document.createElement('div');
                container.className = 'file-item-container';
                
                // Update file name structure for better text wrapping
                const icon = fileName.querySelector('i');
                const fileNameText = fileName.textContent.replace(/^\s*/, '').trim();
                
                if (icon) {
                    fileName.innerHTML = '';
                    fileName.appendChild(icon);
                    
                    const textSpan = document.createElement('span');
                    textSpan.className = 'file-name-text';
                    textSpan.textContent = fileNameText;
                    fileName.appendChild(textSpan);
                }
                
                // Move elements to the new container
                container.appendChild(fileInfo);
                container.appendChild(downloadBtn);
                
                // Clear the item and add the new container
                item.innerHTML = '';
                item.appendChild(container);
            }
        });
    }

    // Call the improvement function after a short delay to ensure DOM is ready
    setTimeout(() => {
        improveFileLayout();
    }, 1000);
    </script>
    
</body>
</html> 
