<?php
session_start();

// Define a constant to indicate this is the Project_details.php file
// This is used by included files like timeline_editor_overlay.php
define('INCLUDED_IN_PROJECT_DETAILS', true);

// Include MongoDB connection
require __DIR__ . '/vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$studentsCollection = $db->students;
$facultiesCollection = $db->faculties;

// Helper function to check if a user profile exists and get profile URL
function getUserProfileInfo($userId, $userType = null) {
    global $studentsCollection, $facultiesCollection;
    
    if (!$userId) {
        return null;
    }
    
    try {
        // If userType is specified, check only that collection
        if ($userType === 'student') {
            $student = $studentsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
            if ($student) {
                return [
                    'exists' => true,
                    'url' => "Student_Profile.php?id=" . $userId,
                    'type' => 'student'
                ];
            }
        } elseif ($userType === 'faculty') {
            $faculty = $facultiesCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
            if ($faculty) {
                return [
                    'exists' => true,
                    'url' => "Faculty_Profile.php?id=" . $userId,
                    'type' => 'faculty'
                ];
            }
        } else {
            // Check both collections if type is not specified
            $student = $studentsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
            if ($student) {
                return [
                    'exists' => true,
                    'url' => "Student_Profile.php?id=" . $userId,
                    'type' => 'student'
                ];
            }
            
            $faculty = $facultiesCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
            if ($faculty) {
                return [
                    'exists' => true,
                    'url' => "Faculty_Profile.php?id=" . $userId,
                    'type' => 'faculty'
                ];
            }
        }
    } catch (Exception $e) {
        // Invalid ObjectId or other error
        return null;
    }
    
    return null;
}

// Helper function to create clickable name with profile link
function createProfileLink($name, $userId, $userType = null) {
    $profileInfo = getUserProfileInfo($userId, $userType);
    
    if ($profileInfo && $profileInfo['exists']) {
        return "<a href='{$profileInfo['url']}' class='profile-link' title='View {$profileInfo['type']} profile'>{$name}</a>";
    }
    
    return $name;
}
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
            margin-bottom: var(--spacing-xl);
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
        
        /* Modern Timeline Redesign - Polished UI/UX */
        
        /* Timeline Empty State */
        .timeline-empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-3xl) var(--spacing-xl);
            text-align: center;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.4) 0%, rgba(30, 41, 59, 0.2) 100%);
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: var(--spacing-lg);
            box-shadow: 0 8px 32px rgba(30, 64, 175, 0.3);
        }
        
        .empty-state-icon i {
            font-size: 2rem;
            color: white;
        }
        
        .timeline-empty-state h4 {
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
            font-weight: 600;
        }
        
        .timeline-empty-state p {
            color: var(--text-secondary);
            margin: 0;
        }
        
        /* Enhanced Progress Header */
        .timeline-progress-header {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: var(--spacing-xl);
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--card-shadow);
            margin-bottom: var(--spacing-xl);
            position: relative;
            overflow: hidden;
        }
        
        .timeline-progress-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }
        
        .progress-stats {
            display: flex;
            align-items: center;
            gap: var(--spacing-xl);
        }
        
        .progress-circle {
            position: relative;
            flex-shrink: 0;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .progress-ring {
            transform: rotate(-90deg);
            filter: drop-shadow(0 0 8px rgba(30, 64, 175, 0.3));
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .progress-bar-circle {
            transition: stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            animation: progress-glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes progress-glow {
            0% { filter: drop-shadow(0 0 5px rgba(30, 64, 175, 0.3)); }
            100% { filter: drop-shadow(0 0 15px rgba(30, 64, 175, 0.6)); }
        }
        
        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            z-index: 10;
        }
        
        .progress-number {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary-color);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            line-height: 1;
            white-space: nowrap;
        }
        
        .progress-details {
            flex: 1;
        }
        
        .progress-details h4 {
            color: var(--text-primary);
            margin-bottom: var(--spacing-xs);
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .progress-details p {
            color: var(--text-secondary);
            margin-bottom: var(--spacing-md);
        }
        
        .progress-bar-container {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        
        .progress-bar-modern {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 4px;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .progress-bar-modern::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: progress-shimmer 2s infinite;
        }
        
        @keyframes progress-shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Modern Timeline Grid */
        .timeline-grid {
            display: grid;
            gap: var(--spacing-lg);
            padding: var(--spacing-lg) 0;
        }
        
        /* Timeline Milestone Cards - Optimized and Compact */
        .timeline-milestone {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--card-shadow);
            padding: var(--spacing-md);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            gap: var(--spacing-md);
            align-items: flex-start;
            will-change: transform;
        }
        
        .timeline-milestone::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transition: height 0.2s ease;
        }
        
        .timeline-milestone:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .timeline-milestone:hover::before {
            height: 4px;
        }
        
        /* Status-based styling */
        .timeline-milestone.completed::before {
            background: linear-gradient(90deg, var(--success-color), #10b981);
        }
        
        .timeline-milestone.in-progress::before {
            background: linear-gradient(90deg, var(--warning-color), #f59e0b);
        }
        
        .timeline-milestone.delayed::before {
            background: linear-gradient(90deg, var(--danger-color), #ef4444);
        }
        
        .timeline-milestone.pending::before {
            background: linear-gradient(90deg, var(--text-muted), #6b7280);
        }
        
        /* Milestone Icon - Left Side */
        .milestone-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
            transition: transform 0.2s ease;
            flex-shrink: 0;
            position: relative;
        }
        
        .milestone-icon::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: inherit;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            z-index: -1;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        
        .timeline-milestone:hover .milestone-icon {
            transform: scale(1.02);
        }
        
        .timeline-milestone:hover .milestone-icon::after {
            opacity: 0.3;
        }
        
        .milestone-status {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--border-radius);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            }
        
        .completed .milestone-status {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.2), rgba(16, 185, 129, 0.1));
            color: var(--success-color);
            border-color: rgba(5, 150, 105, 0.3);
            }
        
        .in-progress .milestone-status {
            background: linear-gradient(135deg, rgba(217, 119, 6, 0.2), rgba(245, 158, 11, 0.1));
            color: var(--warning-color);
            border-color: rgba(217, 119, 6, 0.3);
            }
        
        .delayed .milestone-status {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(239, 68, 68, 0.1));
            color: var(--danger-color);
            border-color: rgba(220, 38, 38, 0.3);
            }
        
        .pending .milestone-status {
            background: linear-gradient(135deg, rgba(107, 114, 128, 0.2), rgba(156, 163, 175, 0.1));
            color: var(--text-muted);
            border-color: rgba(107, 114, 128, 0.3);
        }
        
        /* Milestone Content - Right Side */
        .milestone-content {
            flex: 1;
            min-width: 0;
        }
        
        .milestone-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--spacing-sm);
            gap: var(--spacing-sm);
        }
        
        .milestone-title-section {
            flex: 1;
            min-width: 0;
        }
        
        .milestone-title {
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 var(--spacing-xs) 0;
            line-height: 1.3;
            word-wrap: break-word;
            }
        
        .milestone-description {
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: var(--spacing-sm);
            font-size: 0.9rem;
        }
        
        .milestone-meta {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-sm);
        }
        
        .milestone-date,
        .milestone-duration {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: var(--text-secondary);
            font-size: 0.8rem;
            padding: 4px var(--spacing-xs);
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
        }
        
        .milestone-date i,
        .milestone-duration i {
            color: var(--primary-color);
            font-size: 0.75rem;
        }
        
        /* Timeline Assignments - Clear Labels */
        .timeline-assignments {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-xs);
            margin-top: var(--spacing-xs);
        }
        
        .assignment-row {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        .assignment-label {
            font-weight: 600;
            min-width: 80px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.7rem;
        }
        
        .assignment-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px var(--spacing-xs);
            border-radius: var(--border-radius);
            font-size: 0.75rem;
            font-weight: 500;
            transition: transform 0.1s ease;
            white-space: nowrap;
        }
        
        .assignment-badge:hover {
            transform: translateY(-1px);
        }
        
        .assigned-by-badge {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.15), rgba(30, 64, 175, 0.1));
            color: #78a9ff; /* Lightened color for better visibility */
            border: 1px solid rgba(30, 64, 175, 0.2);
        }
        
        .assigned-to-badge {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.15), rgba(5, 150, 105, 0.1));
            color: #6ee7b7; /* Lightened color for better visibility */
            border: 1px solid rgba(5, 150, 105, 0.2);
        }
        
        .assignment-badge i {
            font-size: 0.7rem;
            opacity: 0.8;
        }
        
        /* Milestone Connector (decorative element) */
        .milestone-connector {
            position: absolute;
            bottom: -var(--spacing-lg);
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: var(--spacing-lg);
            background: linear-gradient(to bottom, var(--primary-color), transparent);
            opacity: 0.5;
        }
        
        .timeline-milestone:last-child .milestone-connector {
            display: none;
        }
        
        /* Timeline Summary */
        .timeline-summary {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: var(--spacing-lg);
            padding: var(--spacing-xl);
            margin-top: var(--spacing-xl);
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .summary-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
            padding: var(--spacing-sm) var(--spacing-md);
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .summary-item i {
            color: var(--primary-color);
        }
        
        /* Legacy Timeline Container - For backwards compatibility */
        .timeline-container {
            position: relative;
            max-width: 100%;
            margin: 0;
            padding: var(--spacing-lg);
        }
        
        /* Responsive Design for Timeline */
        @media (max-width: 768px) {
            .timeline-progress-header {
                padding: var(--spacing-md);
            }
            
            .progress-stats {
                flex-direction: column;
                gap: var(--spacing-md);
                text-align: center;
            }
            
            .progress-circle {
                align-self: center;
            }
            
            .timeline-grid {
                gap: var(--spacing-md);
                padding: var(--spacing-md) 0;
            }
            
            .timeline-milestone {
                padding: var(--spacing-md);
            }
            
            .milestone-header {
                flex-direction: column;
                gap: var(--spacing-sm);
                align-items: flex-start;
            }
            
            .milestone-meta {
                flex-direction: column;
                gap: var(--spacing-xs);
            }
            
            .timeline-summary {
                flex-direction: column;
                gap: var(--spacing-sm);
                padding: var(--spacing-md);
            }
            
            .summary-item {
                justify-content: center;
            }
        }
        
        /* Enhanced hover effects and interactions - Performance Optimized */
        .timeline-milestone.timeline-highlighted {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.2);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        .timeline-milestone.timeline-highlighted::before {
            height: 4px;
        }
        
        /* Performance optimizations */
        .timeline-milestone {
            contain: layout style;
        }
        
        .milestone-icon {
            contain: layout;
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
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(30, 64, 175, 0.1);
            border-radius: 50%;
            border: 2px solid rgba(30, 64, 175, 0.3);
            padding: 0;
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
            border: 2px solid #7293ff;
            color: #7293ff;
            background: rgba(30, 64, 175, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 8px;
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--primary-color), #2563eb);
            color: var(--text-primary);
            border-color: transparent;
            box-shadow: 0 0 20px rgba(30, 64, 175, 0.4);
            transform: translateY(-2px);
        }

        .btn-outline-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-outline-primary:hover::before {
            left: 100%;
        }

        .btn-outline-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-outline-primary:disabled:hover {
            transform: none;
            box-shadow: none;
            background: rgba(30, 64, 175, 0.1);
            color: #7293ff;
            border-color: #7293ff;
        }

        .btn-outline-primary i {
            transition: transform 0.3s ease;
        }
        
        .btn-outline-primary:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        .btn-outline-danger {
            border: 2px solid #ff4757;
            color: #ff4757;
            background: rgba(220, 38, 38, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 8px;
        }
        
        .btn-outline-danger:hover {
            background: linear-gradient(135deg, var(--danger-color), #ef4444);
            color: var(--text-primary);
            border-color: transparent;
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.4);
            transform: translateY(-2px);
        }

        .btn-outline-danger::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-outline-danger:hover::before {
            left: 100%;
        }

        .btn-outline-danger:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-outline-danger:disabled:hover {
            transform: none;
            box-shadow: none;
            background: rgba(220, 38, 38, 0.1);
            color: #ff4757;
            border-color: #ff4757;
        }

        .btn-outline-danger i {
            transition: transform 0.3s ease;
        }
        
        .btn-outline-danger:hover i {
            transform: scale(1.1) rotate(-5deg);
        }
        
        /* Timeline edit button styles */
        #editTimelineBtn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        #editTimelineBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3), var(--glow-primary);
        }
        
        #editTimelineBtn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        #editTimelineBtn:hover::before {
            left: 100%;
        }
        
        #editTimelineBtn i {
            transition: transform 0.3s ease;
        }
        
        #editTimelineBtn:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        /* Timeline Edit Overlay Styles - Enhanced for Dark/Light Mode */
        .timeline-edit-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999; /* Lower than timeline modal (10050) to ensure modal stays on top */
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease-out;
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.5);
        }

        .timeline-overlay-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }

        .timeline-overlay-content {
            position: relative;
            background: var(--card-bg);
            border: 1px solid rgba(76, 201, 240, 0.2);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--card-shadow-hover);
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            animation: slideInUp 0.3s ease-out;
        }

        .timeline-overlay-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(76, 201, 240, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .timeline-overlay-header h3 {
            margin: 0;
            color: var(--text-primary);
            font-size: 1.25rem;
            font-weight: 600;
            flex: 1;
        }

        .timeline-overlay-close {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            margin-left: auto;
        }

        .timeline-overlay-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            transform: rotate(90deg);
        }

        .timeline-overlay-body {
            padding: 1.5rem;
            flex: 1;
            overflow-y: auto;
        }

        .timeline-overlay-footer {
            padding: 1.5rem 2rem;
            border-top: 2px solid var(--glass-border);
            background: var(--surface);
            border-radius: 0 0 var(--border-radius-lg) var(--border-radius-lg);
        }
        
        .timeline-overlay-footer .text-muted {
            color: var(--text-muted) !important;
        }
        
        .timeline-overlay-footer .text-muted i {
            color: var(--accent) !important;
        }
        
        .timeline-overlay-footer .btn {
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            border: 2px solid transparent;
        }
        
        .timeline-overlay-footer .btn-primary {
            background: var(--gradient-primary);
            border: 2px solid var(--primary);
            color: white !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .timeline-overlay-footer .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            border-color: var(--accent);
        }
        
        .timeline-overlay-footer .btn-primary i {
            color: white !important;
        }
        
        .timeline-overlay-footer .btn-outline-secondary {
            border: 2px solid var(--border-light);
            color: var(--text-secondary) !important;
            background: transparent;
        }
        
        .timeline-overlay-footer .btn-outline-secondary:hover {
            background: var(--surface-light);
            border-color: var(--primary);
            color: var(--text-primary) !important;
            transform: translateY(-1px);
        }
        
        .timeline-overlay-footer .btn-outline-secondary i {
            color: inherit !important;
        }
        
        /* Light mode footer overrides */
        [data-theme="light"] .timeline-overlay-footer {
            background: rgba(248, 250, 252, 0.8);
        }
        
        [data-theme="light"] .timeline-overlay-footer .btn-primary {
            color: white !important;
        }
        
        [data-theme="light"] .timeline-overlay-footer .btn-primary i {
            color: white !important;
        }

        .timeline-items-list {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 1rem;
        }

        .timeline-edit-item {
            background: var(--glass-bg);
            border: 2px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .timeline-edit-item:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
        }

        .timeline-edit-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .timeline-edit-item-title {
            font-weight: 700;
            color: var(--text-primary) !important;
            margin: 0;
            flex: 1;
            font-size: 1.1rem;
        }

        .timeline-edit-item-controls {
            display: flex;
            gap: 0.75rem;
            margin-left: 1rem;
        }

        .timeline-edit-item-date {
            color: var(--text-secondary) !important;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .timeline-edit-item-description {
            color: var(--text-muted) !important;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        .timeline-edit-item-assignment {
            font-size: 0.85rem;
            color: var(--text-secondary) !important;
            font-weight: 500;
        }
        
        /* Light mode timeline edit items */
        [data-theme="light"] .timeline-edit-item {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 0, 0, 0.1);
        }
        
        [data-theme="light"] .timeline-edit-item:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--primary);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .status-badge-overlay {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-planned { background: rgba(107, 114, 128, 0.3); color: #9ca3af; }
        .status-in-progress { background: rgba(59, 130, 246, 0.3); color: #60a5fa; }
        .status-completed { background: rgba(16, 185, 129, 0.3); color: #34d399; }
        .status-delayed { background: rgba(239, 68, 68, 0.3); color: #f87171; }

        /* Timeline Item Edit Modal Styles - Enhanced for Dark/Light Mode */
        #timelineItemEditModal {
            z-index: 10050 !important; /* Higher than timeline overlay (9999) and other modals */
        }

        #timelineItemEditModal .modal-backdrop {
            z-index: 10049 !important; /* Just below the modal */
        }

        #timelineItemEditModal .modal-content {
            background: var(--glass-bg);
            border: 1px solid rgba(148, 163, 184, 0.1);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            color: var(--text-primary);
        }

        #timelineItemEditModal .modal-header {
            border-bottom: 1px solid rgba(148, 163, 184, 0.1);
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
            position: relative;
            overflow: hidden;
        }
        
        #timelineItemEditModal .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.9), rgba(124, 58, 237, 0.9));
            z-index: -1;
        }

        #timelineItemEditModal .modal-footer {
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            padding: 1.5rem 2rem;
            background: var(--card-bg);
            border-radius: 0 0 var(--border-radius-lg) var(--border-radius-lg);
        }
        
        /* Enhanced Modal Footer Styling for Dark/Light Mode */
        #timelineItemEditModal .modal-footer.bg-light {
            background: var(--card-bg) !important;
            border-top: 1px solid rgba(148, 163, 184, 0.1) !important;
        }
        
        #timelineItemEditModal .modal-footer.border-top-0 {
            border-top: 1px solid rgba(148, 163, 184, 0.1) !important;
        }
        
        #timelineItemEditModal .modal-footer.p-4 {
            padding: 1.5rem 2rem !important;
        }
        
        #timelineItemEditModal .modal-footer .text-muted.small {
            font-size: 0.85rem;
            opacity: 0.8;
        }
        
        #timelineItemEditModal .modal-footer .d-flex.gap-3 {
            gap: 1rem !important;
        }
        
        #timelineItemEditModal .modal-footer .d-flex.w-100 {
            align-items: center;
            justify-content: space-between;
        }
        
        #timelineItemEditModal .modal-title {
            color: white !important;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        #timelineItemEditModal .modal-header p {
            color: rgba(255, 255, 255, 0.85) !important;
            margin: 0;
        }
        
        #timelineItemEditModal .modal-header i {
            color: white !important;
        }
        
        /* Light mode header text overrides */
        [data-theme="light"] #timelineItemEditModal .modal-title {
            color: white !important;
        }
        
        [data-theme="light"] #timelineItemEditModal .modal-header p {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        [data-theme="light"] #timelineItemEditModal .modal-header i {
            color: white !important;
        }
        
        #timelineItemEditModal .btn-close {
            filter: invert(1);
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #timelineItemEditModal .btn-close span {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1;
        }
        
        #timelineItemEditModal .btn-close:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        #timelineItemEditModal .btn-close:hover span {
            color: white;
        }
        
        /* Form Labels */
        #timelineItemEditModal .form-label {
            color: var(--text-primary) !important;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }
        
        #timelineItemEditModal .form-label i {
            color: var(--primary-color) !important;
        }

        #timelineItemEditModal .form-control,
        #timelineItemEditModal .form-select {
            background: var(--card-bg) !important;
            border: 2px solid rgba(148, 163, 184, 0.1) !important;
            color: var(--text-primary) !important;
            border-radius: var(--border-radius);
            transition: var(--transition-speed) var(--transition-ease);
            font-size: 0.95rem;
        }

        #timelineItemEditModal .form-control:focus,
        #timelineItemEditModal .form-select:focus {
            background: var(--card-bg) !important;
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.25rem rgba(30, 64, 175, 0.15) !important;
            color: var(--text-primary) !important;
        }
        
        #timelineItemEditModal .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.7;
        }
        
        #timelineItemEditModal .form-control-lg {
            padding: 0.875rem 1.25rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        #timelineItemEditModal .form-select-lg {
            padding: 0.875rem 1.25rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        /* Section Headers in Modal */
        #timelineItemEditModal .section-header h6 {
            color: var(--primary-color) !important;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        #timelineItemEditModal .section-header h6::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        
        #timelineItemEditModal .section-header h6 i {
            color: var(--primary-color) !important;
            margin-right: 0.5rem;
        }
        
        /* Enhanced form styling */
        #timelineItemEditModal .form-text {
            font-size: 0.85rem;
            color: var(--text-muted) !important;
            margin-top: 0.5rem;
            font-style: italic;
        }
        
        #timelineItemEditModal .form-text i {
            color: var(--text-muted) !important;
        }
        
        #timelineItemEditModal .invalid-feedback {
            color: var(--error) !important;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            font-weight: 500;
        }
        
        /* Multi-select styling */
        #timelineItemEditModal select[multiple] {
            background: var(--card-bg) !important;
            border: 2px solid rgba(148, 163, 184, 0.1) !important;
            border-radius: var(--border-radius);
            padding: 0.75rem;
            color: var(--text-primary) !important;
        }
        
        #timelineItemEditModal select[multiple] option {
            background: var(--card-bg) !important;
            color: var(--text-primary) !important;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 4px;
            border: 1px solid rgba(148, 163, 184, 0.1);
            transition: all 0.2s ease;
        }
        
        #timelineItemEditModal select[multiple] option:hover {
            background: var(--glass-bg) !important;
            border-color: var(--primary-color);
        }
        
        #timelineItemEditModal select[multiple] option:checked {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color);
            font-weight: 600;
        }
        
        /* Light mode multi-select checked options */
        [data-theme="light"] #timelineItemEditModal select[multiple] option:checked {
            color: white !important;
        }
        
        /* Button enhancements */
        #timelineItemEditModal .d-flex .btn {
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition-speed) var(--transition-ease);
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            border: 2px solid transparent;
        }
        
        #timelineItemEditModal .btn.px-4 {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }
        
        #timelineItemEditModal .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: 2px solid var(--primary-color);
            color: white !important;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        #timelineItemEditModal .btn-primary.glow-effect {
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3), 0 0 20px rgba(30, 64, 175, 0.2);
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        
        #timelineItemEditModal .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.4);
            border-color: var(--accent-color);
        }
        
        #timelineItemEditModal .btn-primary.glow-effect:hover {
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.5), 0 0 30px rgba(30, 64, 175, 0.3);
            animation: none;
        }
        
        @keyframes pulse-glow {
            0% { box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3), 0 0 20px rgba(30, 64, 175, 0.2); }
            100% { box-shadow: 0 4px 15px rgba(30, 64, 175, 0.4), 0 0 25px rgba(30, 64, 175, 0.3); }
        }
        
        #timelineItemEditModal .btn-primary i {
            color: white !important;
        }
        
        /* Light mode primary button */
        [data-theme="light"] #timelineItemEditModal .btn-primary {
            color: white !important;
        }
        
        [data-theme="light"] #timelineItemEditModal .btn-primary i {
            color: white !important;
        }
        
        #timelineItemEditModal .btn-outline-secondary {
            border: 2px solid rgba(148, 163, 184, 0.3);
            color: var(--text-secondary) !important;
            background: transparent;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        #timelineItemEditModal .btn-outline-secondary.px-4 {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
        
        #timelineItemEditModal .btn-outline-secondary:hover {
            background: var(--glass-bg);
            border-color: var(--primary-color);
            color: var(--text-primary) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(148, 163, 184, 0.2);
        }
        
        #timelineItemEditModal .btn-outline-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.1), transparent);
            transition: left 0.5s;
        }
        
        #timelineItemEditModal .btn-outline-secondary:hover::before {
            left: 100%;
        }
        
        #timelineItemEditModal .btn-outline-secondary i {
            color: inherit !important;
        }
        
        /* Footer styling */
        #timelineItemEditModal .modal-footer .text-muted {
            color: var(--text-muted) !important;
        }
        
        #timelineItemEditModal .modal-footer .text-muted i {
            color: var(--accent-color) !important;
        }
        
        /* Light mode specific adjustments */
        [data-theme="light"] #timelineItemEditModal .modal-content {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(0, 0, 0, 0.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        [data-theme="light"] #timelineItemEditModal .modal-footer {
            background: rgba(248, 250, 252, 0.8);
        }
        
        [data-theme="light"] #timelineItemEditModal .modal-footer.bg-light {
            background: rgba(248, 250, 252, 0.8) !important;
            border-top: 1px solid rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Light mode button styling */
        [data-theme="light"] #timelineItemEditModal .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-color: var(--primary-color);
            color: white !important;
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.2);
        }
        
        [data-theme="light"] #timelineItemEditModal .btn-primary.glow-effect {
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.25), 0 0 20px rgba(30, 64, 175, 0.15);
        }
        
        [data-theme="light"] #timelineItemEditModal .btn-primary:hover {
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
        }
        
        [data-theme="light"] #timelineItemEditModal .btn-primary.glow-effect:hover {
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.4), 0 0 30px rgba(30, 64, 175, 0.25);
        }
        
        [data-theme="light"] #timelineItemEditModal .btn-outline-secondary {
            border: 2px solid rgba(0, 0, 0, 0.15);
            color: var(--text-secondary) !important;
            background: rgba(255, 255, 255, 0.6);
        }
        
        [data-theme="light"] #timelineItemEditModal .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.8);
            border-color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        [data-theme="light"] #timelineItemEditModal .form-control,
        [data-theme="light"] #timelineItemEditModal .form-select {
            background: white !important;
            border-color: rgba(0, 0, 0, 0.15) !important;
        }
        
        [data-theme="light"] #timelineItemEditModal .form-control:focus,
        [data-theme="light"] #timelineItemEditModal .form-select:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.25rem rgba(30, 64, 175, 0.1) !important;
        }
        
        [data-theme="light"] #timelineItemEditModal select[multiple] {
            background: white !important;
        }
        
        [data-theme="light"] #timelineItemEditModal select[multiple] option {
            background: white !important;
            border-color: rgba(0, 0, 0, 0.1);
        }
        
        [data-theme="light"] #timelineItemEditModal select[multiple] option:hover {
            background: rgba(30, 64, 175, 0.05) !important;
        }
        
        /* Light mode form select options */
        [data-theme="light"] #timelineItemEditModal .form-select option {
            background: white !important;
            color: var(--text-primary) !important;
        }
        
        [data-theme="light"] #timelineItemEditModal .form-select option:checked {
            background: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Responsive modal */
        @media (max-width: 768px) {
            #timelineItemEditModal .modal-dialog {
                margin: 1rem;
                max-width: calc(100vw - 2rem);
            }
            
            #timelineItemEditModal .modal-header,
            #timelineItemEditModal .modal-footer {
                padding: 1rem;
            }
            
            #timelineItemEditModal .modal-body {
                padding: 1.5rem 1rem;
            }
            
            #timelineItemEditModal .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }
            
            #timelineItemEditModal .d-flex.gap-3 {
                width: 100%;
            }
            
            #timelineItemEditModal .d-flex.gap-3 .btn {
                flex: 1;
            }
        }
            color: var(--text-primary);
        }

        #timelineItemEditModal .btn-close {
            filter: invert(1) brightness(0.8);
        }
        
        /* Enhanced Timeline Edit Container Styles - Dark/Light Mode */
        .timeline-edit-container {
            background: var(--glass-bg);
            border-radius: var(--border-radius-lg);
            padding: 2.5rem;
            max-width: 900px;
            width: 95%;
            max-height: 85vh;
            overflow-y: auto;
            border: 2px solid var(--glass-border);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            color: var(--text-primary);
        }
        
        .timeline-edit-container .timeline-item {
            background: var(--glass-bg);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
            border: 2px solid var(--glass-border);
            color: var(--text-primary);
            transition: var(--transition);
            cursor: grab;
            position: relative;
            overflow: hidden;
        }
        
        .timeline-edit-container .timeline-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0.3;
        }
        
        .timeline-edit-container .timeline-item.grabbing {
            cursor: grabbing;
            transform: scale(1.02);
        }
        
        .timeline-edit-container .timeline-item:hover {
            border-color: var(--primary);
            background: var(--surface-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
            border-left-color: var(--accent);
        }
        
        .timeline-edit-container .timeline-item.completed {
            border-left-color: var(--success);
        }
        
        .timeline-edit-container .timeline-item.completed:hover {
            border-left-color: var(--success);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
        }
        
        .timeline-edit-container .timeline-item.in-progress {
            border-left-color: var(--primary);
        }
        
        .timeline-edit-container .timeline-item.planned {
            border-left-color: var(--secondary);
        }
        
        .timeline-edit-container .timeline-item.planned:hover {
            border-left-color: var(--secondary);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.15);
        }
        
        .timeline-edit-container .timeline-item.delayed {
            border-left-color: var(--error);
        }
        
        .timeline-edit-container .timeline-item.delayed:hover {
            border-left-color: var(--error);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.15);
        }
        
        .timeline-edit-container .timeline-date {
            color: var(--primary) !important;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .timeline-edit-container .timeline-date i {
            margin-right: 0.75rem;
            color: var(--primary) !important;
            font-size: 1.1rem;
        }
        
        .timeline-edit-container .timeline-controls {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .timeline-edit-container .timeline-item h6 {
            color: var(--text-primary) !important;
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }
        
        .timeline-edit-container .timeline-item p {
            color: var(--text-secondary) !important;
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }
        
        /* Enhanced Timeline action buttons */
        .timeline-edit-container .timeline-controls .btn {
            padding: 0.25rem 0.5rem;
            border-radius: var(--border-radius);
            border: 1px solid rgba(148, 163, 184, 0.3);
            background: rgba(51, 65, 85, 0.6);
            color: var(--text-secondary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.8rem;
        }
        
        .timeline-edit-container .timeline-controls .btn:hover {
            transform: translateY(-1px);
            background: rgba(51, 65, 85, 0.8);
            border-color: var(--primary-color);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .timeline-edit-container .timeline-controls .btn-outline-primary:hover {
            color: var(--primary-color);
            background: rgba(30, 64, 175, 0.1);
        }
        
        .timeline-edit-container .timeline-controls .btn-outline-danger:hover {
            color: var(--danger-color);
            background: rgba(220, 38, 38, 0.1);
            border-color: var(--danger-color);
        }
        
        /* Timeline section highlight effect for updates */
        @keyframes highlight-pulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4); }
            70% { box-shadow: 0 0 0 12px rgba(37, 99, 235, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }
        
        .highlight-update {
            animation: highlight-pulse 1.5s ease-out;
        }
        
        .timeline-edit-container .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 500;
            border-radius: 1rem;
            margin-left: 0.5rem;
            position: relative;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .timeline-edit-container .status-completed {
            background: rgba(5, 150, 105, 0.2);
            color: var(--success-color);
            border-color: rgba(5, 150, 105, 0.3);
        }
        
        .timeline-edit-container .status-in-progress {
            background: rgba(30, 64, 175, 0.2);
            color: var(--primary-color);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        .timeline-edit-container .status-planned {
            background: rgba(124, 58, 237, 0.2);
            color: var(--secondary-color);
            border-color: rgba(124, 58, 237, 0.3);
        }
        
        .timeline-edit-container .status-delayed {
            background: rgba(220, 38, 38, 0.2);
            color: var(--danger-color);
            border-color: rgba(220, 38, 38, 0.3);
        }
        
        /* Enhanced Assignment information styling */
        .timeline-edit-container .assignment-info {
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 2px solid var(--glass-border);
        }
        
        .timeline-edit-container .assignment-info .bi {
            margin-right: 0.5rem;
            opacity: 0.8;
            color: var(--primary) !important;
        }
        
        .timeline-edit-container .assignment-info span {
            display: inline-block;
            margin-right: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-muted) !important;
            font-weight: 500;
        }
        
        .timeline-edit-container .assignment-info strong {
            color: var(--primary) !important;
            font-weight: 700;
        }
        
        /* Light mode adjustments for timeline container */
        [data-theme="light"] .timeline-edit-container {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(0, 0, 0, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        [data-theme="light"] .timeline-edit-container .timeline-item {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 0, 0, 0.1);
        }
        
        [data-theme="light"] .timeline-edit-container .timeline-item:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--primary);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Ensure modal backdrop doesn't interfere with timeline overlay */
        .modal-backdrop.show {
            opacity: 0.3;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* Light theme styles for inline assignment layout */
        [data-theme="light"] .timeline-assignments-bottom {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        [data-theme="light"] .assignment-label {
            color: #666;
        }
        
        [data-theme="light"] .assigned-by-badge {
            background-color: rgba(30, 64, 175, 0.1);
            color: #2563eb; /* Adjusted for light theme but still visible */
            border: 1px solid rgba(30, 64, 175, 0.2);
        }
        
        [data-theme="light"] .assigned-to-badge {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981; /* Adjusted for light theme but still visible */
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Light theme progress circle */
        [data-theme="light"] .progress-number {
            color: var(--primary-color);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Light theme assigned by name */
        [data-theme="light"] .assigned-by-name {
            color: #666;
        }

        [data-theme="light"] .timeline-line {
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
        }

        [data-theme="light"] .timeline-icon {
            background: var(--card-bg);
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
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

        [data-theme="light"] .btn-outline-primary {
            color: var(--primary-color) !important;
            border-color: rgba(30, 64, 175, 0.4);
            background: rgba(30, 64, 175, 0.05);
        }

        [data-theme="light"] .btn-outline-primary:hover {
            background: rgba(30, 64, 175, 0.1);
            border-color: rgba(30, 64, 175, 0.6);
            color: var(--primary-color) !important;
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

        [data-theme="light"] .btn-outline-danger {
            color: #dc2626 !important;
            border-color: rgba(220, 38, 38, 0.4);
            background: rgba(220, 38, 38, 0.05);
        }

        [data-theme="light"] .btn-outline-danger:hover {
            background: rgba(220, 38, 38, 0.1);
            border-color: rgba(220, 38, 38, 0.6);
            color: #dc2626 !important;
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
        
        /* Timeline assignment styling in light mode */
        [data-theme="light"] .timeline-assignment {
            border-left-color: rgba(30, 64, 175, 0.3);
        }
        
        [data-theme="light"] .timeline-assignment .text-primary {
            color: #1e40af !important;
        }
        
        [data-theme="light"] .timeline-assignment .text-success {
            color: #059669 !important;
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
            background: linear-gradient(135deg, var(--text-primary), var(--modern-blue));
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

        /* Enhanced spacing for specific sections */
        .metadata-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: var(--spacing-xl);
            margin-bottom: var(--spacing-xl) !important; /* Increased from spacing-lg */
            margin-top: var(--spacing-xl) !important; /* Added top spacing */
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) var(--transition-ease);
            position: relative;
            overflow: hidden;
        }
        
        /* Enhanced spacing for sidebar card sections */
        .col-lg-4 .card.mb-4 {
            margin-bottom: var(--spacing-xl) !important; /* Increased from default mb-4 */
            margin-top: var(--spacing-xl) !important; /* Added top spacing */
        }
        
        /* First section should have reduced top margin to avoid too much space from top */
        .metadata-card:first-child,
        .col-lg-4 .card.mb-4:first-child {
            margin-top: var(--spacing-lg) !important;
        }
        
        /* Last section should have additional bottom spacing */
        .col-lg-4 .card.mb-4:last-child {
            margin-bottom: var(--spacing-2xl) !important;
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
        
        .team-members-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            z-index: 1;
        }
        
        /* Profile Link Styles */
        .profile-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all var(--transition-speed) var(--transition-ease);
            position: relative;
            padding: 2px 4px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .profile-link:hover {
            color: var(--accent-color);
            background: rgba(30, 64, 175, 0.1);
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(30, 64, 175, 0.3);
        }
        
        .profile-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transition: width var(--transition-speed) var(--transition-ease);
        }
        
        .profile-link:hover::after {
            width: 100%;
        }
        
        /* Supervisor link styling */
        .supervisor-link {
            color: var(--text-muted) !important;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: all var(--transition-speed) var(--transition-ease);
            padding: 2px 4px;
            border-radius: 4px;
            background: linear-gradient(135deg, transparent 0%, rgba(30, 64, 175, 0.05) 100%);
        }
        
        .supervisor-link:hover {
            color: var(--text-muted) !important;
            text-decoration: none;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(30, 64, 175, 0.15) 100%);
            box-shadow: 0 2px 8px rgba(30, 64, 175, 0.2);
            transform: translateY(-1px);
        }
        
        /* Member link styling for consistency */
        .member-link {
            color: #00bcf7 !important;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: all var(--transition-speed) var(--transition-ease);
            padding: 2px 4px;
            border-radius: 4px;
            background: linear-gradient(135deg, transparent 0%, rgba(2, 132, 199, 0.05) 100%);
        }
        
        .member-link:hover {
            color: #00bcf7  !important;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.2);
            transform: translateY(-1px);
        }
    </style>
    
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    
    <?php 
    // Initialize variables for project permissions
    $canEditProject = false;
    $projectId = isset($_GET['id']) ? $_GET['id'] : null;
    
    // Check if user is logged in and can edit this project
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['user_id']) && $projectId) {
        $currentUserId = $_SESSION['user_id'];
        
        // Try to get the project from database to check permissions
        try {
            $projectsCollection = $db->projectsV2;
            $project = $projectsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($projectId)]);
            
            if ($project) {
                // Check if user is project creator
                if (isset($project['createdBy'])) {
                    if (is_array($project['createdBy']) && isset($project['createdBy']['$oid']) && $project['createdBy']['$oid'] === $currentUserId) {
                        $canEditProject = true;
                    } elseif (is_string($project['createdBy']) && $project['createdBy'] === $currentUserId) {
                        $canEditProject = true;
                    }
                }
                
                // Check if user is supervisor
                if (!$canEditProject && isset($project['supervisor'])) {
                    if (isset($project['supervisor']['userId']['$oid']) && $project['supervisor']['userId']['$oid'] === $currentUserId) {
                        $canEditProject = true;
                    } elseif (isset($project['supervisor']['userId']) && $project['supervisor']['userId'] === $currentUserId) {
                        $canEditProject = true;
                    }
                }
                
                // Check if user is team member
                if (!$canEditProject && isset($project['members']) && is_array($project['members'])) {
                    foreach ($project['members'] as $member) {
                        if (isset($member['userId']['$oid']) && $member['userId']['$oid'] === $currentUserId) {
                            $canEditProject = true;
                            break;
                        } elseif (isset($member['userId']) && $member['userId'] === $currentUserId) {
                            $canEditProject = true;
                            break;
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // If there's an error, default to no editing permissions
            error_log("Error checking project permissions: " . $e->getMessage());
            $canEditProject = false;
        }
    }
    ?>
    
    <!-- Inject PHP session data into JavaScript -->
    <script>
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_SESSION['user_id'])): ?>
        var currentUserId = "<?php echo $_SESSION['user_id']; ?>";
        var currentUserName = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
        var currentUserType = "<?php echo isset($_SESSION['user_type']) ? $_SESSION['user_type'] : ''; ?>";
        <?php else: ?>
        var currentUserId = null;
        var currentUserName = null;
        var currentUserType = null;
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title mb-0">Project Timeline</h3>
                            <?php if ($canEditProject && $projectId): ?>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#timelineEditorModal" data-project-id="<?php echo htmlspecialchars($projectId); ?>">
                                    <i class="bi bi-pencil me-1"></i> Edit Timeline
                                </button>
                            <?php endif; ?>
                        </div>
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

    <!-- Timeline Editor Overlay -->
    <?php include 'timeline_editor_overlay.php'; ?>

    <!-- Add the refreshProjectTimeline function in the JavaScript section -->
    <script>
        /**
         * Refresh the project timeline display after edits
         */
        function refreshProjectTimeline() {
            // Reload the project data and update the timeline display
            fetchProjectData(currentProjectId);
        }
    </script>

</body>
</html>

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
            fetch(`src/model/get_project.php?id=${projectId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success || data.error) {
                        showProjectNotFound();
                        return;
                    }
                    
                    const project = data.project;
                    
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
        
        // Helper function to create clickable profile links
        async function createProfileLink(name, userId, userType = null) {
            if (!name) return 'Unknown';
            
            // Primary method: Use userId if available
            if (userId) {
                try {
                    const response = await fetch('src/model/check_profile_exists.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ userId: userId, userType: userType })
                    });
                    
                    if (response.ok) {
                        const result = await response.json();
                        if (result.exists) {
                            const profileType = result.type === 'faculty' ? 'Faculty_Profile.php' : 'Student_Profile.php';
                            return `<a href="${profileType}?id=${userId}" class="profile-link ${result.type === 'faculty' ? 'supervisor-link' : 'member-link'}" title="View ${result.type} profile">${name}</a>`;
                        }
                    }
                } catch (error) {
                    console.log('Profile check failed for user:', userId);
                }
            }
            
            // Fallback method: Try to find supervisor by name in global faculty data
            if (userType === 'faculty' || !userType) {
                try {
                    // Check if global faculty data is available
                    if (window.facultyData && Array.isArray(window.facultyData)) {
                        const matchingFaculty = window.facultyData.find(faculty => 
                            faculty.name && faculty.name.toLowerCase().trim() === name.toLowerCase().trim()
                        );
                        
                        if (matchingFaculty && matchingFaculty._id) {
                            console.log(`Found faculty by name: ${name} -> ${matchingFaculty._id}`);
                            return `<a href="Faculty_Profile.php?id=${matchingFaculty._id}" class="profile-link supervisor-link" title="View faculty profile">${name}</a>`;
                        }
                    }
                    
                    // If global faculty data is not available, try to fetch it
                    if (!window.facultyData) {
                        const facultyResponse = await fetch('src/model/load_faculty.php');
                        if (facultyResponse.ok) {
                            const facultyData = await facultyResponse.json();
                            window.facultyData = facultyData; // Cache for future use
                            
                            const matchingFaculty = facultyData.find(faculty => 
                                faculty.name && faculty.name.toLowerCase().trim() === name.toLowerCase().trim()
                            );
                            
                            if (matchingFaculty && matchingFaculty._id) {
                                console.log(`Found faculty by name (from fetch): ${name} -> ${matchingFaculty._id}`);
                                return `<a href="Faculty_Profile.php?id=${matchingFaculty._id}" class="profile-link supervisor-link" title="View faculty profile">${name}</a>`;
                            }
                        }
                    }
                } catch (error) {
                    console.log('Faculty name lookup failed:', error);
                }
            }
            
            // Return original name if no profile found
            return name;
        }
        
        function renderProjectHeader(project) {
            const headerEl = document.getElementById('project-header');
            const isPublic = project.privacy === 0;
            
            // Create supervisor info with potential link
            let supervisorInfo = '';
            if (project.supervisor) {
                const supervisorName = project.supervisor.name || (typeof project.supervisor === 'string' ? project.supervisor : (project.supervisor.$oid || 'Unknown'));
                const supervisorId = project.supervisor.userId ? (project.supervisor.userId.$oid || project.supervisor.userId) : null;
                
                // Initially show supervisor name (will be updated to clickable link if profile exists)
                supervisorInfo = `<div class="meta-item"><i class="bi bi-person-badge"></i><strong>Supervisor:</strong> <span class="supervisor-display">${supervisorName}</span></div>`;
                
                // Try to make supervisor clickable (with or without userId)
                createProfileLink(supervisorName, supervisorId, 'faculty').then(linkedName => {
                    // Update all supervisor displays with clickable link
                    document.querySelectorAll('.supervisor-display').forEach(el => {
                        if (el.textContent.trim() === supervisorName) {
                            el.innerHTML = linkedName;
                        }
                    });
                }).catch(error => {
                    console.log('Failed to create supervisor profile link:', error);
                    // Keep the original name if profile check fails
                });
            }
            
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
                
                // Enhanced supervisor authorization check - comprehensive patterns
                if (!isAuthorized && project.supervisor) {
                    // Check various supervisor data formats
                    
                    // Format 1: supervisor.userId with ObjectId
                    if (project.supervisor.userId && project.supervisor.userId.$oid) {
                        isAuthorized = (project.supervisor.userId.$oid === currentUser);
                    }
                    
                    // Format 2: supervisor.userId as string
                    if (!isAuthorized && project.supervisor.userId) {
                        isAuthorized = (project.supervisor.userId === currentUser);
                    }
                    
                    // Format 3: Direct supervisor field (for simple projects)
                    if (!isAuthorized && typeof project.supervisor === 'string') {
                        isAuthorized = (project.supervisor === currentUser);
                    }
                    
                    // Format 4: supervisor.$oid (direct ObjectId)
                    if (!isAuthorized && project.supervisor.$oid) {
                        isAuthorized = (project.supervisor.$oid === currentUser);
                    }
                    
                    // Format 5: Name-based matching for faculty users
                    if (!isAuthorized && currentUserType === 'faculty' && currentUserName && project.supervisor.name) {
                        isAuthorized = (project.supervisor.name === currentUserName);
                    }
                    
                    // Debug logging for troubleshooting
                    console.log('Supervisor check debug:', {
                        currentUser: currentUser,
                        currentUserName: currentUserName,
                        currentUserType: currentUserType,
                        supervisor: project.supervisor,
                        isAuthorized: isAuthorized
                    });
                }
                
                // Check if user is the project creator
                if (!isAuthorized && project.createdBy) {
                    if (typeof project.createdBy === 'object' && project.createdBy.$oid) {
                        isAuthorized = (project.createdBy.$oid === currentUser);
                    } else if (typeof project.createdBy === 'string') {
                        isAuthorized = (project.createdBy === currentUser);
                    }
                }
            }
            
            // Only show edit and leave buttons if user is a team member or supervisor
            const editBtn = isAuthorized ? `
                <button id="editProjectBtn" class="btn btn-outline-primary ms-2" data-project-id="${project._id.$oid}">
                    <i class="bi bi-pencil-square"></i>Edit Project
                </button>
            ` : '';

            const leaveBtn = isAuthorized ? `
                <button id="leaveProjectBtn" class="btn btn-outline-danger ms-2" data-project-id="${project._id.$oid}" data-project-name="${project.title}" title="Leave this project and group chat">
                    <i class="bi bi-box-arrow-left"></i>Leave Project
                </button>
            ` : '';
            
            headerEl.innerHTML = `
                <div class="d-flex justify-content-between align-items-start position-relative z-1">
                    <div>
                        <h1 class="float-animation display-4">${project.title}</h1>
                        <div class="mb-3 d-flex align-items-center mt-3">
                            ${editBtn}
                            ${leaveBtn}
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
                        ${supervisorInfo}
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
                            <i class="bi bi-calendar-event"></i>
                            <div><strong>Estimated Completion:</strong> ${project.estimatedCompletionDate ? formatDate(project.estimatedCompletionDate) : 'Not specified'}</div>
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

            // Add event listener for the leave button
            const leaveButton = document.getElementById('leaveProjectBtn');
            if (leaveButton) {
                leaveButton.addEventListener('click', function() {
                    const projectId = this.getAttribute('data-project-id');
                    const projectName = this.getAttribute('data-project-name');
                    
                    // Show confirmation dialog
                    const confirmMessage = `Are you sure you want to leave "${projectName}"?\n\nThis will:\n• Remove you from the project team\n• Remove you from the group chat\n• You will lose access to all project discussions\n\nThis action cannot be undone.`;
                    
                    if (!confirm(confirmMessage)) {
                        return;
                    }
                    
                    // Disable the button to prevent multiple clicks
                    this.disabled = true;
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-hourglass-split"></i>Leaving...';
                    
                    // Send leave request to server
                    const formData = new FormData();
                    formData.append('projectId', projectId);
                    
                    fetch('src/model/leave_project.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            if (typeof showToast === 'function') {
                                showToast('success', 'Left Project', data.message || 'You have successfully left the project.');
                            } else {
                                alert('You have successfully left the project.');
                            }
                            
                            // Redirect to projects page after a short delay
                            setTimeout(() => {
                                window.location.href = 'Research_page.php';
                            }, 1500);
                            
                        } else {
                            // Show error message
                            if (typeof showToast === 'function') {
                                showToast('error', 'Failed to Leave', data.message || 'Failed to leave the project. Please try again.');
                            } else {
                                alert(data.message || 'Failed to leave the project. Please try again.');
                            }
                            
                            // Re-enable the button
                            this.disabled = false;
                            this.innerHTML = originalContent;
                        }
                    })
                    .catch(error => {
                        console.error('Error leaving project:', error);
                        
                        // Show error message
                        if (typeof showToast === 'function') {
                            showToast('error', 'Error', 'An error occurred while trying to leave the project. Please try again.');
                        } else {
                            alert('An error occurred while trying to leave the project. Please try again.');
                        }
                        
                        // Re-enable the button
                        this.disabled = false;
                        this.innerHTML = originalContent;
                    });
                });
                
                // Add ripple effect to the button
                leaveButton.addEventListener('mousedown', createRipple);
            }
            
            // Show/hide timeline edit button based on authorization
            const timelineEditBtn = document.getElementById('editTimelineBtn');
            if (timelineEditBtn) {
                if (isAuthorized) {
                    timelineEditBtn.style.display = 'inline-block';
                    timelineEditBtn.addEventListener('click', function() {
                        // Open timeline edit overlay instead of redirecting
                        openTimelineEditOverlay(project);
                    });
                    
                    // Add ripple effect to the timeline edit button
                    timelineEditBtn.addEventListener('mousedown', createRipple);
                } else {
                    timelineEditBtn.style.display = 'none';
                }
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
            let supervisorInfo = '';
            if (project.supervisor) {
                const supervisorName = project.supervisor.name || (typeof project.supervisor === 'string' ? project.supervisor : (project.supervisor.$oid || 'Unknown'));
                const supervisorId = project.supervisor.userId ? (project.supervisor.userId.$oid || project.supervisor.userId) : null;
                
                if (supervisorId) {
                    // Create clickable supervisor link
                    createProfileLink(supervisorName, supervisorId, 'faculty').then(linkedName => {
                        const supervisorInfoEl = document.querySelector('.supervisor-info-display');
                        if (supervisorInfoEl) {
                            supervisorInfoEl.innerHTML = linkedName;
                        }
                    });
                }
                
                supervisorInfo = `<p><i class="bi bi-person-badge me-2"></i><strong>Supervisor:</strong> <span class="supervisor-info-display">${supervisorName}</span></p>`;
            }
            
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
            
            sortedMembers.forEach((member, index) => {
                const name = member.name || 'Unnamed Member';
                const role = member.role || 'Team Member';
                const memberId = member.userId ? (member.userId.$oid || member.userId) : null;
                
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
                            <i class="bi bi-person-circle me-2"></i><span class="member-name-display" data-member-id="${memberId || ''}">${name}</span>
                        </div>
                        <div class="member-role">
                            <i class="bi ${roleIcon} me-2"></i>${role}
                        </div>
                        ${contribution}
                    </div>
                `;
                
                // Check if member has a profile and make it clickable
                if (memberId) {
                    setTimeout(() => {
                        createProfileLink(name, memberId, 'student').then(linkedName => {
                            const memberNameEl = document.querySelector(`[data-member-id="${memberId}"]`);
                            if (memberNameEl) {
                                memberNameEl.innerHTML = linkedName;
                            }
                        });
                    }, index * 100); // Stagger the profile checks
                }
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
                // Show a polished empty state instead of hiding
                timelineEl.innerHTML = `
                    <div class="timeline-empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <h4>No Timeline Available</h4>
                        <p>This project doesn't have a timeline yet. Check back later for updates!</p>
                    </div>
                `;
                return;
            }
            
            // Sort timeline items by date
            const sortedTimeline = [...project.timeline].sort((a, b) => {
                let dateA, dateB;
                try {
                    dateA = a.date ? new Date(typeof a.date === 'object' && a.date.$date ? a.date.$date : a.date).getTime() : 0;
                } catch (e) { dateA = 0; }
                try {
                    dateB = b.date ? new Date(typeof b.date === 'object' && b.date.$date ? b.date.$date : b.date).getTime() : 0;
                } catch (e) { dateB = 0; }
                return dateA - dateB;
            });
            
            // Calculate progress statistics
            const completedItems = sortedTimeline.filter(item => 
                item.status && item.status.toLowerCase().includes('completed')).length;
            const totalItems = sortedTimeline.length;
            const progressPercentage = totalItems > 0 ? Math.round((completedItems / totalItems) * 100) : 0;
            
            // Create the modern timeline HTML
            let timelineHTML = `
                <!-- Enhanced Progress Header -->
                <div class="timeline-progress-header">
                    <div class="progress-stats">
                        <div class="progress-circle" data-progress="${progressPercentage}">
                            <svg class="progress-ring" width="60" height="60">
                                <circle cx="30" cy="30" r="25" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="3"/>
                                <circle cx="30" cy="30" r="25" fill="none" stroke="var(--primary-color)" stroke-width="3" 
                                        stroke-dasharray="157" stroke-dashoffset="${157 - (progressPercentage * 157 / 100)}" 
                                        stroke-linecap="round" class="progress-bar-circle"/>
                            </svg>
                            <div class="progress-text">
                                <span class="progress-number">${progressPercentage}%</span>
                </div>
                        </div>
                        <div class="progress-details">
                            <h4>Project Progress</h4>
                            <p>${completedItems} of ${totalItems} milestones completed</p>
                            <div class="progress-bar-container">
                                <div class="progress-bar-modern" style="width: ${progressPercentage}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Timeline Grid -->
                <div class="timeline-grid">
            `;
            
            // Display timeline items in a modern grid format
            sortedTimeline.forEach((item, index) => {
                const date = formatDate(item.date);
                const delay = 100 * (index + 1);
                
                // Determine status for styling
                let statusClass = 'pending';
                let statusIcon = 'bi-clock';
                let statusText = 'Pending';
                
                if (item.status) {
                    const statusLower = item.status.toLowerCase();
                    if (statusLower.includes('completed') || statusLower.includes('done') || statusLower.includes('finished')) {
                        statusClass = 'completed';
                        statusIcon = 'bi-check-circle-fill';
                        statusText = 'Completed';
                    } else if (statusLower.includes('progress') || statusLower.includes('active') || statusLower.includes('ongoing')) {
                        statusClass = 'in-progress';
                        statusIcon = 'bi-play-circle-fill';
                        statusText = 'In Progress';
                    } else if (statusLower.includes('delayed') || statusLower.includes('overdue')) {
                        statusClass = 'delayed';
                        statusIcon = 'bi-exclamation-triangle-fill';
                        statusText = 'Delayed';
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
                
                const description = item.description || 'No description available';
                
                // Build assigned by name for below title
                let assignedByNameForTitle = '';
                if (item.assignedBy) {
                    // Handle both new and legacy format
                    if (typeof item.assignedBy === 'object' && item.assignedBy !== null) {
                        const name = item.assignedBy.name || 'Unknown';
                        const userId = item.assignedBy.id;
                        const userType = 'faculty'; // Set explicit faculty type for assignedBy
                        
                        // Create a unique placeholder for this assigned by name
                        const placeholderClass = `assigned-by-placeholder-${index}`;
                        
                        // Initialize with just the name, will be replaced with link via createProfileLink
                        assignedByNameForTitle = `<div class="assigned-by-name ${placeholderClass}">by ${name}</div>`;
                        
                        // Attempt to create a profile link asynchronously
                        if (name && (name !== 'Unknown')) {
                            // Use the async createProfileLink function to fetch faculty profile
                            createProfileLink(name, userId, userType).then(linkedName => {
                                // Update all instances of this placeholder with the linked name
                                document.querySelectorAll(`.${placeholderClass}`).forEach(el => {
                                    el.innerHTML = `by ${linkedName}`;
                                });
                            }).catch(error => {
                                console.log('Failed to create faculty profile link:', error);
                            });
                        }
                    } else {
                        // Legacy format - use async method for this too
                        const assignedByMember = findMemberById(item.assignedBy, project);
                        const assignedByName = assignedByMember ? assignedByMember.name : item.assignedBy;
                        
                        // Create a unique placeholder for this assigned by name
                        const placeholderClass = `assigned-by-placeholder-${index}`;
                        
                        // Initialize with just the name
                        assignedByNameForTitle = `<div class="assigned-by-name ${placeholderClass}">by ${assignedByName}</div>`;
                        
                        // Try to make it a link if it's a faculty member
                        if (assignedByName && (assignedByName !== 'Unknown')) {
                            createProfileLink(assignedByName, item.assignedBy, 'faculty').then(linkedName => {
                                // Update all instances of this placeholder with the linked name
                                document.querySelectorAll(`.${placeholderClass}`).forEach(el => {
                                    el.innerHTML = `by ${linkedName}`;
                                });
                            }).catch(error => {
                                console.log('Failed to create faculty profile link:', error);
                            });
                        }
                    }
                }
                
                // Build assigned to info for bottom (only assigned to, no assigned by)
                let teamAssignmentInfo = '';
                if (item.assignedTo && Array.isArray(item.assignedTo) && item.assignedTo.length > 0) {
                    teamAssignmentInfo = '<div class="timeline-assignments-bottom">';
                    
                    // Create placeholders for all assignees
                    const assigneeData = item.assignedTo.map((assignee, idx) => {
                        if (typeof assignee === 'object' && assignee !== null) {
                            // New format
                            const name = assignee.name || 'Unknown';
                            const userId = assignee.id;
                            // Default to student but allow override if specified
                            const userType = assignee.type || 'student'; 
                            
                            return {
                                name,
                                userId,
                                userType,
                                placeholder: `assignee-${index}-${idx}`
                            };
                        } else {
                            // Legacy format
                            const assignedToMember = findMemberById(assignee, project);
                            const name = assignedToMember ? assignedToMember.name : assignee;
                            
                            return {
                                name,
                                userId: assignee,
                                userType: null, // Will be determined automatically
                                placeholder: `assignee-${index}-${idx}`
                            };
                        }
                    });
                    
                    // Generate initial placeholder HTML
                    const assignedToNames = assigneeData.map(data => data.name);
                    
                    let assignmentRow = '<div class="assignment-row-inline">';
                    assignmentRow += `
                        <div class="assignment-inline">
                            <span class="assignment-label">Assigned to:</span>
                            <div class="assignment-badges-inline">
                    `;
                    
                    assigneeData.forEach((data, idx) => {
                        assignmentRow += `
                            <span class="assignment-badge assigned-to-badge ${data.placeholder}">
                                <i class="bi bi-person-check-fill"></i> ${data.name}
                            </span>
                        `;
                        
                        // Asynchronously update with profile links
                        if (data.name && (data.name !== 'Unknown')) {
                            createProfileLink(data.name, data.userId, data.userType).then(linkedName => {
                                // Update all instances of this placeholder with the linked name
                                document.querySelectorAll(`.${data.placeholder}`).forEach(el => {
                                    el.innerHTML = `<i class="bi bi-person-check-fill"></i> ${linkedName}`;
                                });
                            }).catch(error => {
                                console.log(`Failed to create profile link for ${data.name}:`, error);
                            });
                        }
                    });
                    
                    assignmentRow += '</div></div>';
                    assignmentRow += '</div>';
                    teamAssignmentInfo += assignmentRow + '</div>';
                }
                
                timelineHTML += `
                    <div class="timeline-milestone ${statusClass}" 
                         data-aos="fade-up" 
                         data-aos-delay="${delay}"
                         data-timeline-index="${index}"
                         onclick="highlightTimelineItem(${index})">
                        <div class="milestone-icon">
                            <i class="bi ${icon}"></i>
                                </div>
                        <div class="milestone-content">
                            <div class="milestone-header">
                                <div class="milestone-title-section">
                                    <h5 class="milestone-title">${item.title}</h5>
                                    ${assignedByNameForTitle}
                            </div>
                                <div class="milestone-date">
                                    <i class="bi bi-calendar3"></i>
                                    <span>${date}</span>
                                </div>
                                <div class="milestone-status">
                                    <i class="bi ${statusIcon}"></i>
                                    <span>${statusText}</span>
                            </div>
                        </div>
                            <p class="milestone-description">${description}</p>
                            <div class="milestone-meta">
                                ${item.duration ? `
                                    <div class="milestone-duration">
                                        <i class="bi bi-stopwatch"></i>
                                        <span>${item.duration}</span>
                                    </div>
                                ` : ''}
                            </div>
                            ${teamAssignmentInfo}
                        </div>
                        <div class="milestone-connector"></div>
                    </div>
                `;
            });
            
            timelineHTML += '</div>'; // Close timeline-grid
            
            // Add project duration summary
            if (sortedTimeline.length > 0) {
                const firstItem = sortedTimeline[0];
                const lastItem = sortedTimeline[sortedTimeline.length - 1];
                
                if (firstItem.date && lastItem.date) {
                    const startDate = formatDate(firstItem.date);
                    const endDate = formatDate(lastItem.date);
                    
                    const startDateObj = new Date(typeof firstItem.date === 'object' && firstItem.date.$date ? 
                        firstItem.date.$date : firstItem.date);
                    const endDateObj = new Date(typeof lastItem.date === 'object' && lastItem.date.$date ? 
                        lastItem.date.$date : lastItem.date);
                    const durationDays = Math.ceil((endDateObj - startDateObj) / (1000 * 60 * 60 * 24));
                    
                    timelineHTML += `
                        <div class="timeline-summary">
                            <div class="summary-item">
                                <i class="bi bi-play-circle"></i>
                                <span>Started: ${startDate}</span>
                            </div>
                            <div class="summary-item">
                                <i class="bi bi-flag-checkered"></i>
                                <span>Latest: ${endDate}</span>
                            </div>
                            ${durationDays > 0 ? `
                                <div class="summary-item">
                                    <i class="bi bi-hourglass-split"></i>
                                    <span>Duration: ${durationDays} days</span>
                                </div>
                            ` : ''}
                        </div>
                    `;
                }
            }
            
            timelineEl.innerHTML = timelineHTML;
            
            // Initialize timeline enhancements
            initTimelineEnhancements();
        }
        
        // Helper function to find member by ID
        function findMemberById(memberId, projectData) {
            if (!memberId || !projectData) return null;
            
            // Handle the new format (object with id and name)
            if (typeof memberId === 'object' && memberId !== null) {
                if (memberId.id) {
                    // If we have an ID, try to find the actual member object for additional info
                    const foundMember = findMemberByActualId(memberId.id, projectData);
                    if (foundMember) return foundMember;
                }
                
                // If member not found by ID or no ID, return the object itself as it has name
                return memberId;
            }
            
            // Legacy format - check project members first
            if (projectData.members) {
                const member = projectData.members.find(member => {
                    const memberUserId = member.userId ? 
                        (member.userId.$oid || member.userId) : null;
                    return memberUserId === memberId || member.name === memberId;
                });
                
                if (member) return member;
            }
            
            // Check supervisor
            if (projectData.supervisor) {
                const supervisorUserId = projectData.supervisor.userId ? 
                    (projectData.supervisor.userId.$oid || projectData.supervisor.userId) : null;
                
                if (supervisorUserId === memberId || projectData.supervisor.name === memberId) {
                    return projectData.supervisor;
                }
            }
            
            return null;
        }
        
        // Helper function to find member by their actual ID
        function findMemberByActualId(memberId, projectData) {
            if (!memberId || !projectData) return null;
            
            // Check project members first
            if (projectData.members) {
                const member = projectData.members.find(member => {
                    const memberUserId = member.userId ? 
                        (member.userId.$oid || member.userId) : null;
                    return memberUserId === memberId;
                });
                
                if (member) return member;
            }
            
            // Check supervisor
            if (projectData.supervisor) {
                const supervisorUserId = projectData.supervisor.userId ? 
                    (projectData.supervisor.userId.$oid || projectData.supervisor.userId) : null;
                
                if (supervisorUserId === memberId) {
                    return projectData.supervisor;
                }
            }
            
            return null;
        }
        
        // Helper function to create a client-side profile link
        function createClientSideProfileLink(name, userId, userType) {
            if (!userId) return name;
            
            let profileUrl = '';
            if (userType === 'student') {
                profileUrl = `Student_Profile.php?id=${userId}`;
            } else if (userType === 'faculty') {
                profileUrl = `Faculty_Profile.php?id=${userId}`;
            } else {
                // Try to determine the type based on the project data
                const profileInfo = getUserProfileInfo(userId);
                if (profileInfo && profileInfo.exists) {
                    profileUrl = profileInfo.url;
                } else {
                    return name; // No profile link possible
                }
            }
            
            return `<a href="${profileUrl}" class="profile-link" title="View profile">${name}</a>`;
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
                
                // Debug: Log scroll progress (remove this in production)
                if (scrollProgress > 0) {
                    console.log('Timeline scroll progress:', scrollProgress);
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
                
                        .timeline-assignment {
            font-size: 0.8rem;
            opacity: 0.8;
            transition: opacity 0.3s ease;
            border-left: 2px solid rgba(76, 201, 240, 0.3);
            padding-left: 8px;
            margin-top: 8px;
        }
        
        /* New CSS for inline assignment layout */
        .timeline-assignments-bottom {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .assignment-row-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
        }
        
        .assignment-inline {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .assignment-badges-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }
        
        .assignment-label {
            font-size: 0.8rem;
            opacity: 0.8;
            font-weight: 500;
        }
        
        .assignment-badge {
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 12px;
            white-space: nowrap;
        }
        
        .assigned-by-badge {
            background-color: rgba(76, 201, 240, 0.2);
            color: var(--accent-color);
            border: 1px solid rgba(76, 201, 240, 0.3);
        }
        
        .assigned-to-badge {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        /* Assigned by name below title */
        .assigned-by-name {
            font-size: 0.75rem;
            font-weight: 300;
            color: var(--text-muted);
            margin-top: 4px;
            opacity: 0.8;
            font-style: italic;
        }
                }
                
                .timeline-assignment .assignment-by {
                    margin-bottom: 4px;
                }
                
                .timeline-assignment .assignment-to {
                    /* Styling handled by Bootstrap classes in JavaScript */
                }
                
                .timeline-assignment .text-primary {
                    color: #2563eb !important;
                }
                
                .timeline-assignment .text-success {
                    color: #10b981 !important;
                }
                
                .timeline-assignment i {
                    font-size: 0.75rem;
                }
                
                .timeline-content:hover .timeline-duration,
                .timeline-content:hover .timeline-team,
                .timeline-content:hover .timeline-assignment {
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
            
            // Initialize stats if they don't exist
            if (!project.stats || typeof project.stats !== 'object') {
                project.stats = { views: 0, downloads: 0, favorites: 0 };
            }
            
            // Ensure numeric values
            const views = parseInt(project.stats.views) || 0;
            const downloads = parseInt(project.stats.downloads) || 0;
            const favorites = parseInt(project.stats.favorites) || 0;
            
            let statsHTML = '<ul class="list-group list-group-flush">';
            
            // Always show views (most basic stat)
            statsHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-eye me-2"></i>Views</span>
                    <span class="badge bg-primary rounded-pill">${views}</span>
                </li>
            `;
            
            // Show downloads if greater than 0 or if files exist
            if (downloads > 0 || (project.files && project.files.length > 0)) {
                statsHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-download me-2"></i>Downloads</span>
                        <span class="badge bg-primary rounded-pill">${downloads}</span>
                    </li>
                `;
            }
            
            // Always show favorites
            statsHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-star me-2"></i>Favorites</span>
                    <span class="badge bg-primary rounded-pill">${favorites}</span>
                </li>
            `;
            
            // Add team size as a stat
            const teamSize = (project.members ? project.members.length : 0) + (project.supervisor ? 1 : 0);
            if (teamSize > 0) {
                statsHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-people me-2"></i>Team Members</span>
                        <span class="badge bg-success rounded-pill">${teamSize}</span>
                    </li>
                `;
            }
            
            // Add file count if files exist
            if (project.files && project.files.length > 0) {
                statsHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark me-2"></i>Files</span>
                        <span class="badge bg-info rounded-pill">${project.files.length}</span>
                    </li>
                `;
            }
            
            statsHTML += '</ul>';
            statsEl.innerHTML = statsHTML;
            
            // Add fade-in animation for stats
            const statItems = statsEl.querySelectorAll('.list-group-item');
            statItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }
        
        // Helper functions
        function formatDate(dateString) {
            if (!dateString) return 'Not specified';
            
            try {
                let dateValue = dateString;
                
                // Handle MongoDB UTCDateTime objects
                if (typeof dateString === 'object') {
                    // MongoDB UTCDateTime format: { "$date": "2024-01-01T00:00:00.000Z" }
                    if (dateString.$date) {
                        dateValue = dateString.$date;
                    }
                    // MongoDB BSON UTCDateTime format with $numberLong
                    else if (dateString.$date && dateString.$date.$numberLong) {
                        dateValue = parseInt(dateString.$date.$numberLong);
                    }
                    // Direct timestamp (milliseconds)
                    else if (typeof dateString === 'object' && dateString.toString && !isNaN(new Date(dateString).getTime())) {
                        dateValue = dateString.toString();
                    }
                    // Try extracting timestamp if it's a complex object
                    else if (dateString.sec) {
                        // MongoDB internal timestamp format
                        dateValue = dateString.sec * 1000; // Convert seconds to milliseconds
                    }
                }
                
                // Create Date object
                const date = new Date(dateValue);
                
                // Check if date is valid
                if (isNaN(date.getTime())) {
                    console.warn('Invalid date value:', dateString);
                    return 'Date unavailable';
                }
                
                return date.toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric'
                });
            } catch (error) {
                console.error('Error formatting date:', error, 'Input:', dateString);
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

        // Timeline Edit Overlay Functions
        let currentProject = null;
        let editingTimelineItems = [];
        let currentEditingItemIndex = -1;

        /**
         * Open the timeline edit overlay
         * @param {Object} project - The project object containing timeline data
         */
        function openTimelineEditOverlay(project) {
            currentProject = project;
            editingTimelineItems = project.timeline ? [...project.timeline] : [];
            
            const overlay = document.getElementById('timelineEditOverlay');
            overlay.style.display = 'flex';
            
            // Populate the timeline items
            populateTimelineItems();
            
            // Add event listener for adding new timeline items
            const addBtn = document.getElementById('addTimelineItemBtn');
            addBtn.onclick = addNewTimelineItem;
            
            // Prevent body scroll when overlay is open
            document.body.style.overflow = 'hidden';
        }

        /**
         * Close the timeline edit overlay
         */
        function closeTimelineEditOverlay() {
            const overlay = document.getElementById('timelineEditOverlay');
            overlay.style.display = 'none';
            
            // Restore body scroll
            document.body.style.overflow = 'auto';
            
            // Clear current editing data
            currentProject = null;
            editingTimelineItems = [];
            currentEditingItemIndex = -1;
        }

        /**
         * Populate the timeline items in the overlay
         */
        function populateTimelineItems() {
            const container = document.getElementById('timelineItemsList');
            container.innerHTML = '';
            
            if (editingTimelineItems.length === 0) {
                container.innerHTML = '<p class="text-center text-muted">No timeline items yet. Click "Add Timeline Item" to get started.</p>';
                return;
            }
            
            editingTimelineItems.forEach((item, index) => {
                const itemEl = createTimelineItemElement(item, index);
                container.appendChild(itemEl);
            });
        }

        /**
         * Create a timeline item element for the overlay
         * @param {Object} item - Timeline item data
         * @param {number} index - Item index
         * @returns {HTMLElement} - The timeline item element
         */
        function createTimelineItemElement(item, index) {
            const div = document.createElement('div');
            div.className = `timeline-item ${(item.status || 'planned').toLowerCase().replace(' ', '-')}`;
            div.dataset.index = index;
            
            const statusClasses = {
                'Completed': 'completed status-completed',
                'In Progress': 'in-progress status-in-progress',
                'Planned': 'planned status-planned',
                'Delayed': 'delayed status-delayed'
            };
            
            const statusClass = statusClasses[item.status] || 'planned status-planned';
            const formattedDate = formatDisplayDate(item.date);
            
            // Generate assignment display text
            let assignmentInfo = '';
            
            // Ensure backward compatibility - handle undefined assignment fields
            const assignedBy = item.assignedBy || '';
            const assignedTo = item.assignedTo || [];
            
            if (assignedBy || (Array.isArray(assignedTo) && assignedTo.length > 0)) {
                assignmentInfo = '<div class="assignment-info mt-2">';
                
                if (assignedBy) {
                    const assignedByMember = findMemberById(assignedBy);
                    const assignedByName = assignedByMember ? assignedByMember.name : assignedBy;
                    assignmentInfo += `<span class="text-muted small me-3"><i class="bi bi-person-plus"></i> Assigned by: <strong>${assignedByName}</strong></span>`;
                }
                
                if (Array.isArray(assignedTo) && assignedTo.length > 0) {
                    const assignedToNames = assignedTo.map(id => {
                        const member = findMemberById(id);
                        return member ? member.name : id;
                    }).join(', ');
                    assignmentInfo += `<span class="text-muted small"><i class="bi bi-person-check"></i> Assigned to: <strong>${assignedToNames}</strong></span>`;
                }
                
                assignmentInfo += '</div>';
            }
            
            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="timeline-date">
                        <i class="bi bi-calendar3"></i>
                        ${formattedDate}
                        <span class="status-badge ${statusClass}">${item.status || 'Planned'}</span>
                    </div>
                    <div class="timeline-controls">
                        <button type="button" class="btn btn-sm btn-outline-primary edit-timeline" onclick="editTimelineItem(${index})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger delete-timeline" onclick="deleteTimelineItem(${index})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </div>
                <h6 class="mb-2">${item.title || 'Untitled'}</h6>
                <p class="mb-2 small text-muted">${item.description || 'No description'}</p>
                ${assignmentInfo}
            `;
            
            return div;
        }

        /**
         * Add a new timeline item
         */
        function addNewTimelineItem() {
            const now = new Date();
            const formattedDate = now.toISOString().split('T')[0]; // YYYY-MM-DD format
            
            const newItem = {
                title: '',
                description: '',
                date: formattedDate,
                status: 'Planned',
                assignedBy: '',
                assignedTo: []
            };
            
            editingTimelineItems.push(newItem);
            currentEditingItemIndex = editingTimelineItems.length - 1;
            
            // Open the edit modal for the new item
            openTimelineItemEditModal(currentEditingItemIndex);
        }
        
        /**
         * Helper function to get current project members
         */
        function getMembersData() {
            const members = [];
            
            // Get members from the current project
            if (currentProject && currentProject.members) {
                currentProject.members.forEach(member => {
                    if (member.name) {
                        members.push({
                            name: member.name,
                            role: member.role || 'Team Member',
                            userId: member.userId || null
                        });
                    }
                });
            }
            
            return members;
        }
        
        /**
         * Helper function to find member by ID or name
         */
        function findMemberById(memberId, projectData) {
            if (!memberId || !projectData) return null;
            
            // Handle the new format (object with id and name)
            if (typeof memberId === 'object' && memberId !== null) {
                if (memberId.id) {
                    // If we have an ID, try to find the actual member object for additional info
                    const foundMember = findMemberByActualId(memberId.id, projectData);
                    if (foundMember) return foundMember;
                }
                
                // If member not found by ID or no ID, return the object itself as it has name
                return memberId;
            }
            
            // Legacy format - check project members first
            if (projectData.members) {
                const member = projectData.members.find(member => {
                    const memberUserId = member.userId ? 
                        (member.userId.$oid || member.userId) : null;
                    return memberUserId === memberId || member.name === memberId;
                });
                
                if (member) return member;
            }
            
            // Check supervisor
            if (projectData.supervisor) {
                const supervisorUserId = projectData.supervisor.userId ? 
                    (projectData.supervisor.userId.$oid || projectData.supervisor.userId) : null;
                
                if (supervisorUserId === memberId || projectData.supervisor.name === memberId) {
                    return projectData.supervisor;
                }
            }
            
            return null;
        }
        
        // Helper function to find member by their actual ID
        function findMemberByActualId(memberId, projectData) {
            if (!memberId || !projectData) return null;
            
            // Check project members first
            if (projectData.members) {
                const member = projectData.members.find(member => {
                    const memberUserId = member.userId ? 
                        (member.userId.$oid || member.userId) : null;
                    return memberUserId === memberId;
                });
                
                if (member) return member;
            }
            
            // Check supervisor
            if (projectData.supervisor) {
                const supervisorUserId = projectData.supervisor.userId ? 
                    (projectData.supervisor.userId.$oid || projectData.supervisor.userId) : null;
                
                if (supervisorUserId === memberId) {
                    return projectData.supervisor;
                }
            }
            
            return null;
        }
        
        // Helper function to create a client-side profile link
        function createClientSideProfileLink(name, userId, userType) {
            if (!userId) return name;
            
            let profileUrl = '';
            if (userType === 'student') {
                profileUrl = `Student_Profile.php?id=${userId}`;
            } else if (userType === 'faculty') {
                profileUrl = `Faculty_Profile.php?id=${userId}`;
            } else {
                // Try to determine the type based on the project data
                const profileInfo = getUserProfileInfo(userId);
                if (profileInfo && profileInfo.exists) {
                    profileUrl = profileInfo.url;
                } else {
                    return name; // No profile link possible
                }
            }
            
            return `<a href="${profileUrl}" class="profile-link" title="View profile">${name}</a>`;
        }

        /**
         * Edit a timeline item
         * @param {number} index - Item index
         */
        function editTimelineItem(index) {
            currentEditingItemIndex = index;
            openTimelineItemEditModal(index);
        }

        /**
         * Delete a timeline item
         * @param {number} index - Item index
         */
        function deleteTimelineItem(index) {
            if (confirm('Are you sure you want to delete this timeline item?')) {
                editingTimelineItems.splice(index, 1);
                populateTimelineItems();
            }
        }

                 /**
          * Open the timeline item edit modal
          * @param {number} index - Item index
          */
         function openTimelineItemEditModal(index) {
             const item = editingTimelineItems[index];
             const modalElement = document.getElementById('timelineItemEditModal');
             
             // Ensure the modal has the correct z-index to stay above timeline overlay
             modalElement.style.zIndex = '10050';
             
             const modal = new bootstrap.Modal(modalElement, {
                 backdrop: true,
                 keyboard: true,
                 focus: true
             });
             
             // Populate form fields
             document.getElementById('timelineItemTitle').value = item.title || '';
             document.getElementById('timelineItemDescription').value = item.description || '';
             document.getElementById('timelineItemDate').value = formatMongoDate(item.date) || new Date().toISOString().split('T')[0];
             document.getElementById('timelineItemStatus').value = item.status || 'Planned';
             
             // Populate assignment dropdowns
             populateAssignmentDropdowns();
             
             // Set assignment values - if no assignedBy exists, try to auto-select current user
             let assignedByValue = item.assignedBy || '';
             if (!assignedByValue) {
                 // Try to find current user in the dropdown options
                 const assignedBySelect = document.getElementById('timelineItemAssignedBy');
                 const currentUserOption = Array.from(assignedBySelect.options).find(option => 
                     option.value && option.value !== ''
                 );
                 if (currentUserOption) {
                     assignedByValue = currentUserOption.value;
                 }
             }
             document.getElementById('timelineItemAssignedBy').value = assignedByValue;
             
             // Handle multiple assignees for "Assigned To" with backward compatibility
             const assignedToSelect = document.getElementById('timelineItemAssignedTo');
             const assignedToArray = Array.isArray(item.assignedTo) ? item.assignedTo : (item.assignedTo ? [item.assignedTo] : []);
             
             if (Array.isArray(assignedToArray)) {
                 Array.from(assignedToSelect.options).forEach(option => {
                     option.selected = assignedToArray.includes(option.value);
                 });
             } else if (assignedToArray) {
                 // Handle single value (backward compatibility)
                 Array.from(assignedToSelect.options).forEach(option => {
                     option.selected = option.value === assignedToArray;
                 });
             }
             
             // Show the modal
             modal.show();
             
             // After modal is shown, ensure backdrop has correct z-index to stay above timeline overlay
             modalElement.addEventListener('shown.bs.modal', function() {
                 const backdrop = document.querySelector('.modal-backdrop:last-child');
                 if (backdrop) {
                     backdrop.style.zIndex = '10049';
                 }
             }, { once: true });
         }

                 /**
          * Populate assignment dropdowns with project members
          */
         function populateAssignmentDropdowns() {
             const assignedBySelect = document.getElementById('timelineItemAssignedBy');
             const assignedToSelect = document.getElementById('timelineItemAssignedTo');
             
             if (!assignedBySelect || !assignedToSelect) return;
             
             // Clear existing options (except the first default option)
             assignedBySelect.innerHTML = '<option value="">Select member (optional)</option>';
             assignedToSelect.innerHTML = '<option value="">Select members (optional)</option>';
             
             // Get current project members
             const members = getMembersData();
             
             // Add all team members to "Assigned By" dropdown, but only students to "Assigned To"
             members.forEach(member => {
                 if (member.name && member.name.trim()) {
                     // Use student ID if available, otherwise use member name
                     const optionValue = (member.userId && member.userId.$oid) ? member.userId.$oid : member.name;
                     const optionText = `${member.name}${member.role ? ' (' + member.role + ')' : ''}`;
                     
                     // Add all members to "Assigned By" dropdown
                     const assignedByOption = new Option(optionText, optionValue);
                     assignedBySelect.add(assignedByOption);
                     
                     // Check if the member is a student (not supervisor/faculty) for "Assigned To"
                     const isStudent = !member.role || 
                                      (member.role.toLowerCase() !== 'supervisor' && 
                                       member.role.toLowerCase() !== 'faculty' &&
                                       member.role.toLowerCase() !== 'creator/supervisor');
                     
                     // Only add students to "Assigned To" dropdown
                     if (isStudent) {
                         const assignedToOption = new Option(optionText, optionValue);
                         assignedToSelect.add(assignedToOption);
                     }
                 }
             });
             
             // Add supervisor to "Assigned By" dropdown
             if (currentProject && currentProject.supervisor && currentProject.supervisor.name) {
                 const supervisor = currentProject.supervisor;
                 const supervisorValue = supervisor.userId ? 
                     (supervisor.userId.$oid || supervisor.userId) : supervisor.name;
                 const supervisorText = `${supervisor.name} (Supervisor)`;
                 
                 const supervisorByOption = new Option(supervisorText, supervisorValue);
                 assignedBySelect.add(supervisorByOption);
             }
         }

         /**
          * Save the current timeline item being edited
          */
                  function saveTimelineItem() {
             const index = currentEditingItemIndex;
             if (index === -1) return;
             
             const title = document.getElementById('timelineItemTitle').value.trim();
             const description = document.getElementById('timelineItemDescription').value.trim();
             const date = document.getElementById('timelineItemDate').value;
             const status = document.getElementById('timelineItemStatus').value;
             const assignedBy = document.getElementById('timelineItemAssignedBy').value;
             
             // Get multiple selected values for "Assigned To"
             const assignedToSelect = document.getElementById('timelineItemAssignedTo');
             const assignedTo = Array.from(assignedToSelect.selectedOptions).map(option => option.value).filter(val => val !== '');
             
             // Validation
             if (!title || !date) {
                 if (!title) document.getElementById('timelineItemTitle').classList.add('is-invalid');
                 if (!date) document.getElementById('timelineItemDate').classList.add('is-invalid');
                 return;
             }
             
             // Remove validation classes
             document.getElementById('timelineItemTitle').classList.remove('is-invalid');
             document.getElementById('timelineItemDate').classList.remove('is-invalid');
             
             // Update the item with proper date format
             editingTimelineItems[index] = {
                 title,
                 description,
                 date,
                 status,
                 assignedBy,
                 assignedTo
             };
             
             // Close modal and refresh display
             const modal = bootstrap.Modal.getInstance(document.getElementById('timelineItemEditModal'));
            modal.hide();
            populateTimelineItems();
            
            currentEditingItemIndex = -1;
        }

        /**
         * Helper function to get current project members data
         */
        function getMembersData() {
            const members = [];
            
            // Get members from the current project
            if (currentProject && currentProject.members) {
                currentProject.members.forEach(member => {
                    if (member.name) {
                        members.push({
                            name: member.name,
                            role: member.role || 'Team Member',
                            userId: member.userId || null
                        });
                    }
                });
            }
            
            return members;
        }

        /**
         * Helper function to find member by ID or name - Enhanced version from edit_project.php
         */
        function findMemberById(memberId, projectData) {
            if (!memberId || !projectData) return null;
            
            // Handle the new format (object with id and name)
            if (typeof memberId === 'object' && memberId !== null) {
                if (memberId.id) {
                    // If we have an ID, try to find the actual member object for additional info
                    const foundMember = findMemberByActualId(memberId.id, projectData);
                    if (foundMember) return foundMember;
                }
                
                // If member not found by ID or no ID, return the object itself as it has name
                return memberId;
            }
            
            // Legacy format - check project members first
            if (projectData.members) {
                const member = projectData.members.find(member => {
                    const memberUserId = member.userId ? 
                        (member.userId.$oid || member.userId) : null;
                    return memberUserId === memberId || member.name === memberId;
                });
                
                if (member) return member;
            }
            
            // Check supervisor
            if (projectData.supervisor) {
                const supervisorUserId = projectData.supervisor.userId ? 
                    (projectData.supervisor.userId.$oid || projectData.supervisor.userId) : null;
                
                if (supervisorUserId === memberId || projectData.supervisor.name === memberId) {
                    return projectData.supervisor;
                }
            }
            
            return null;
        }
        
        // Helper function to find member by their actual ID
        function findMemberByActualId(memberId, projectData) {
            if (!memberId || !projectData) return null;
            
            // Check project members first
            if (projectData.members) {
                const member = projectData.members.find(member => {
                    const memberUserId = member.userId ? 
                        (member.userId.$oid || member.userId) : null;
                    return memberUserId === memberId;
                });
                
                if (member) return member;
            }
            
            // Check supervisor
            if (projectData.supervisor) {
                const supervisorUserId = projectData.supervisor.userId ? 
                    (projectData.supervisor.userId.$oid || projectData.supervisor.userId) : null;
                
                if (supervisorUserId === memberId) {
                    return projectData.supervisor;
                }
            }
            
            return null;
        }
        
        // Helper function to create a client-side profile link
        function createClientSideProfileLink(name, userId, userType) {
            if (!userId) return name;
            
            let profileUrl = '';
            if (userType === 'student') {
                profileUrl = `Student_Profile.php?id=${userId}`;
            } else if (userType === 'faculty') {
                profileUrl = `Faculty_Profile.php?id=${userId}`;
            } else {
                // Try to determine the type based on the project data
                const profileInfo = getUserProfileInfo(userId);
                if (profileInfo && profileInfo.exists) {
                    profileUrl = profileInfo.url;
                } else {
                    return name; // No profile link possible
                }
            }
            
            return `<a href="${profileUrl}" class="profile-link" title="View profile">${name}</a>`;
        }

        /**
         * Populate assignment dropdowns with project members
         */
        function populateAssignmentDropdowns() {
            const assignedBySelect = document.getElementById('timelineItemAssignedBy');
            const assignedToSelect = document.getElementById('timelineItemAssignedTo');
            
            if (!assignedBySelect || !assignedToSelect) return;
            
            // Clear existing options (except the first default option)
            assignedBySelect.innerHTML = '<option value="">Select member (optional)</option>';
            assignedToSelect.innerHTML = '<option value="">Select members (optional)</option>';
            
            // Get current project members
            const members = getMembersData();
            
            // Add all team members to "Assigned By" dropdown, but only students to "Assigned To"
            members.forEach(member => {
                if (member.name && member.name.trim()) {
                    // Use member ID if available, otherwise use member name
                    const optionValue = (member.userId && member.userId.$oid) ? member.userId.$oid : member.name;
                    const optionText = `${member.name}${member.role ? ' (' + member.role + ')' : ''}`;
                
                    // Add all members to "Assigned By" dropdown
                    const assignedByOption = new Option(optionText, optionValue);
                    assignedBySelect.add(assignedByOption);
                
                    // Check if the member is a student (not supervisor/faculty) for "Assigned To"
                    const isStudent = !member.role || 
                                     (member.role.toLowerCase() !== 'supervisor' && 
                                      member.role.toLowerCase() !== 'faculty' &&
                                      member.role.toLowerCase() !== 'creator/supervisor');
                    
                    // Only add students to "Assigned To" dropdown
                    if (isStudent) {
                        const assignedToOption = new Option(optionText, optionValue);
                        assignedToSelect.add(assignedToOption);
                    }
                }
            });
            
            // Add supervisor to "Assigned By" dropdown
            if (currentProject && currentProject.supervisor && currentProject.supervisor.name) {
                const supervisorValue = (currentProject.supervisor.userId && currentProject.supervisor.userId.$oid) ? 
                                       currentProject.supervisor.userId.$oid : currentProject.supervisor.name;
                const supervisorText = `${currentProject.supervisor.name} (Supervisor)`;
                
                const supervisorByOption = new Option(supervisorText, supervisorValue);
                assignedBySelect.add(supervisorByOption);
            }
        }

        /**
         * Save all timeline changes back to the server
         */
        async function saveTimelineChanges() {
            if (!currentProject) return;
            
            // Show loading state
            const saveBtn = document.querySelector('.timeline-overlay-footer .btn-primary');
            const originalText = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            
            try {
                const formData = new FormData();
                formData.append('project_id', currentProject._id.$oid);
                formData.append('timeline', JSON.stringify(editingTimelineItems));
                
                const response = await fetch('src/model/update_timeline.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Update the current project's timeline
                    currentProject.timeline = editingTimelineItems;
                    
                    // Refresh the timeline display on the page
                    renderTimeline(currentProject);
                    
                    // Close the overlay
                    closeTimelineEditOverlay();
                    
                    // Show success message
                    showToast('Timeline updated successfully!', 'success');
                } else {
                    throw new Error(result.message || 'Failed to update timeline');
                }
            } catch (error) {
                console.error('Error saving timeline:', error);
                showToast('Error saving timeline: ' + error.message, 'danger');
                
                // Reset button state
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
            }
        }

        /**
         * Helper function to format MongoDB date for display
         * @param {Object|string} dateObj - MongoDB date object or ISO string
         * @returns {string} - Formatted date string
         */
        function formatDisplayDate(dateObj) {
            if (!dateObj) return 'No date';
            
            let dateStr;
            if (typeof dateObj === 'object' && dateObj.$date) {
                dateStr = dateObj.$date;
            } else if (typeof dateObj === 'string') {
                dateStr = dateObj;
            } else {
                return 'Invalid date';
            }
            
            try {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            } catch (error) {
                return 'Invalid date';
            }
        }

        /**
         * Helper function to format MongoDB date for input field
         * @param {Object|string} dateObj - MongoDB date object or ISO string
         * @returns {string} - Date string in YYYY-MM-DD format
         */
        function formatMongoDate(dateObj) {
            if (!dateObj) return '';
            
            let dateStr;
            if (typeof dateObj === 'object' && dateObj.$date) {
                dateStr = dateObj.$date;
            } else if (typeof dateObj === 'string') {
                dateStr = dateObj;
            } else {
                return '';
            }
            
            try {
                const date = new Date(dateStr);
                return date.toISOString().split('T')[0];
            } catch (error) {
                return '';
            }
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
    
    // Function to refresh the project timeline after edits
    function refreshProjectTimeline() {
        // Reload the project data and update the timeline display
        if (currentProjectId) {
            fetchProjectData(currentProjectId);
            
            // Show a subtle notification
            const timelineSection = document.getElementById('timeline-section');
            if (timelineSection) {
                timelineSection.classList.add('highlight-update');
                setTimeout(() => {
                    timelineSection.classList.remove('highlight-update');
                }, 2000);
            }
        }
    }
    </script>
    
    <!-- Timeline Editor Overlay -->
    <?php include 'timeline_editor_overlay.php'; ?>
    
</body>
</html> 