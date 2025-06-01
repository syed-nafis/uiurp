<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    $_SESSION['error'] = "Please login to view profiles";
    header('Location: login.php');
    exit();
}

// Include MongoDB connection
require __DIR__ . '/vendor/autoload.php';

// Connect to MongoDB
$client = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
$db = $client->uiurp;
$studentsCollection = $db->students;

// Get user ID - either from URL parameter (viewing other profiles) or session (own profile)
$userId = null;
$isOwnProfile = false;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Viewing another student's profile
    try {
        $userId = new MongoDB\BSON\ObjectId($_GET['id']);
    } catch (Exception $e) {
        $_SESSION['error'] = "Invalid profile ID";
        header('Location: Research_page.php');
        exit();
    }
} else {
    // Viewing own profile
    $userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);
    $isOwnProfile = true;
}

// Fetch the student data from MongoDB
$studentData = $studentsCollection->findOne(['_id' => $userId]);

// If student data not found
if (!$studentData) {
    if ($isOwnProfile) {
        $_SESSION['info'] = "You need to set up your profile first";
        header('Location: Student_Profile_Create.php');
        exit();
    } else {
        $_SESSION['error'] = "Student profile not found";
        header('Location: Research_page.php');
        exit();
    }
}

// Convert MongoDB document to an array
$student = json_decode(json_encode($studentData), true);

// Default profile image if not set
$profileImage = $student['basic_info']['profile_image_url'] ?? $student['profile_image'] ?? $student['profile_image_url'] ?? null;
if (empty($profileImage)) {
    $profileImage = 'assets/resources/student.jpeg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - <?= htmlspecialchars($student['basic_info']['name'] ?? $student['name'] ?? 'Student') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-gradient: linear-gradient(135deg, #0c0c0c 0%, #1a1a2e 50%, #16213e 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --accent-blue: #00d4ff;
            --accent-purple: #8b5cf6;
            --accent-pink: #ec4899;
        }

        /* Light mode variables */
        [data-theme="light"] {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --dark-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            --glass-bg: rgba(0, 0, 0, 0.05);
            --glass-border: rgba(0, 0, 0, 0.1);
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --accent-blue: #0ea5e9;
            --accent-purple: #8b5cf6;
            --accent-pink: #ec4899;
        }

        /* Theme Toggle Button */
        /* REMOVED - Using navbar theme toggle instead */

        /* Light mode theme toggle adjustments */
        [data-theme="light"] .theme-toggle {
            background: linear-gradient(135deg, 
                rgba(0, 0, 0, 0.1) 0%, 
                rgba(0, 0, 0, 0.05) 100%);
            border: 2px solid rgba(0, 0, 0, 0.15);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.15),
                0 4px 16px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        [data-theme="light"] .theme-toggle::before {
            background: linear-gradient(135deg, 
                rgba(75, 85, 99, 0.4) 0%, 
                rgba(55, 65, 81, 0.4) 100%);
        }

        [data-theme="light"] .theme-toggle:hover {
            border-color: rgba(75, 85, 99, 0.4);
            box-shadow: 
                0 12px 40px rgba(75, 85, 99, 0.3),
                0 6px 20px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        /* Enhanced animation for theme toggle */
        .theme-toggle-animate {
            animation: themeToggleRotate 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes themeToggleRotate {
            0% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.2) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }

        /* Pulse effect for theme toggle */
        .theme-toggle::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            width: calc(100% + 20px);
            height: calc(100% + 20px);
            border: 2px solid rgba(14, 165, 233, 0.3);
            border-radius: 50%;
            opacity: 0;
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.1;
            }
            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        /* Light mode pulse ring */
        [data-theme="light"] .theme-toggle::after {
            border-color: rgba(75, 85, 99, 0.4);
        }

        /* Responsive adjustments for theme toggle */
        @media (max-width: 768px) {
            .theme-toggle {
                top: 15px;
                right: 15px;
                width: 55px;
                height: 55px;
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .theme-toggle {
                top: 10px;
                right: 10px;
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }

        /* Ensure theme toggle is above navbar */
        .theme-toggle {
            z-index: 1060 !important;
        }

        /* Light mode background adjustments */
        [data-theme="light"] body::before {
            background: 
                radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(236, 72, 153, 0.08) 0%, transparent 50%);
        }

        /* Light mode profile header adjustments */
        [data-theme="light"] .profile-header {
            background: linear-gradient(135deg, 
                rgba(248, 250, 252, 0.95) 0%, 
                rgba(226, 232, 240, 0.9) 50%, 
                rgba(203, 213, 225, 0.95) 100%);
        }

        [data-theme="light"] .profile-header::before {
            background: 
                radial-gradient(circle at 30% 30%, rgba(14, 165, 233, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 70% 70%, rgba(139, 92, 246, 0.1) 0%, transparent 40%);
        }

        /* Light mode section adjustments */
        [data-theme="light"] .profile-section:nth-child(even) {
            background: rgba(0, 0, 0, 0.02);
        }

        /* Light mode learning resources section */
        [data-theme="light"] .learning-resources-section {
            background: linear-gradient(135deg, 
                rgba(248, 250, 252, 0.8) 0%, 
                rgba(226, 232, 240, 0.6) 50%, 
                rgba(248, 250, 252, 0.8) 100%);
            border-top: 1px solid rgba(14, 165, 233, 0.2);
            border-bottom: 1px solid rgba(14, 165, 233, 0.2);
        }

        /* Light mode card adjustments */
        [data-theme="light"] .learning-resource-card {
            background: linear-gradient(135deg, 
                rgba(248, 250, 252, 0.9) 0%, 
                rgba(226, 232, 240, 0.8) 100%);
            border: 1px solid rgba(14, 165, 233, 0.2);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }

        [data-theme="light"] .learning-resource-card:hover {
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.15),
                0 0 40px rgba(14, 165, 233, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        /* Light mode project cards */
        [data-theme="light"] .research-project-card {
            background: linear-gradient(135deg, 
                rgba(248, 250, 252, 0.9) 0%, 
                rgba(226, 232, 240, 0.7) 100%);
            border: 1px solid rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .research-project-card::before {
            background: linear-gradient(135deg, 
                rgba(37, 99, 235, 0.05) 0%, 
                rgba(139, 92, 246, 0.05) 50%,
                rgba(20, 184, 166, 0.05) 100%);
        }

        [data-theme="light"] .research-card-image {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        [data-theme="light"] .research-card-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .research-card-description {
            color: var(--text-secondary);
        }

        [data-theme="light"] .research-meta-item {
            background: rgba(248, 250, 252, 0.6);
            color: var(--text-secondary);
            border-left: 3px solid #0ea5e9;
        }

        /* Light mode info items */
        [data-theme="light"] .info-item {
            background: rgba(0, 0, 0, 0.03);
            border-left: 3px solid var(--accent-blue);
        }

        [data-theme="light"] .info-item:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        /* Light mode publication items */
        [data-theme="light"] .publication-item {
            background: var(--glass-bg);
            border-left: 4px solid var(--accent-blue);
        }

        /* Light mode empty state */
        [data-theme="light"] .empty-state {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
        }

        /* Light mode skills tags */
        [data-theme="light"] .skills-tag {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(14, 165, 233, 0.3);
            color: var(--text-primary);
        }

        [data-theme="light"] .skills-tag:hover {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.2), rgba(139, 92, 246, 0.2));
            border-color: rgba(14, 165, 233, 0.5);
        }

        /* Light mode badges */
        [data-theme="light"] .learning-resource-card .badge {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.2), rgba(139, 92, 246, 0.2));
            border: 1px solid rgba(14, 165, 233, 0.4);
            color: var(--text-primary);
        }

        /* Light mode alert adjustments */
        [data-theme="light"] .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border-left: 4px solid #22c55e;
            color: var(--text-primary);
        }

        [data-theme="light"] .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
            color: var(--text-primary);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-gradient);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: 2rem;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
            z-index: -1;
            animation: floatingBackground 20s ease-in-out infinite;
        }

        @keyframes floatingBackground {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-10px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }

        /* Glass Card Effect */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.4),
                0 0 40px rgba(0, 212, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.9) 0%, 
                rgba(30, 41, 59, 0.8) 50%, 
                rgba(0, 0, 0, 0.9) 100%);
            position: relative;
            overflow: hidden;
            padding: 60px 0;
            margin-bottom: 0;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 30% 30%, rgba(0, 212, 255, 0.2) 0%, transparent 40%),
                radial-gradient(circle at 70% 70%, rgba(139, 92, 246, 0.2) 0%, transparent 40%);
            animation: headerGlow 8s ease-in-out infinite alternate;
        }

        @keyframes headerGlow {
            0% { opacity: 0.6; }
            100% { opacity: 1; }
        }

        .profile-header .container {
            position: relative;
            z-index: 2;
        }

        .profile-header h1 {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            animation: titleGlow 3s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% { filter: drop-shadow(0 0 10px rgba(0, 212, 255, 0.3)); }
            100% { filter: drop-shadow(0 0 20px rgba(139, 92, 246, 0.5)); }
        }

        .profile-header .lead {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border-left: 3px solid var(--accent-blue);
            transition: all 0.3s ease;
            animation: slideInLeft 0.6s ease-out;
        }

        .info-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
            border-left-color: var(--accent-purple);
        }

        .info-item i {
            color: var(--accent-blue);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .info-item:hover i {
            color: var(--accent-purple);
            transform: scale(1.1);
        }

        @keyframes slideInLeft {
            0% { transform: translateX(-30px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        /* Profile Image Container */
        .profile-image-container {
            position: relative;
            text-align: center;
            animation: fadeInUp 0.8s ease-out;
        }

        .profile-image-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .profile-image-wrapper::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9));
            border-radius: 50%;
            z-index: -1;
        }

        .profile-image-wrapper img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.2);
            object-fit: cover;
            transition: all 0.4s ease;
            position: relative;
            z-index: 1;
        }

        .profile-image-wrapper:hover img {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .profile-edit-btn {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .profile-edit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .profile-edit-btn:hover::before {
            left: 100%;
        }

        .profile-edit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
            color: white;
            text-decoration: none;
        }

        @keyframes fadeInUp {
            0% { transform: translateY(30px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Edit Profile Button (Top Right) */
        .edit-profile-btn {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border: none;
            border-radius: 15px;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .edit-profile-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .edit-profile-btn:hover::before {
            left: 100%;
        }

        .edit-profile-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Status Badge */
        .status-badge {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Section Styling */
        .profile-section {
            padding: 80px 0;
            position: relative;
        }

        .profile-section:nth-child(even) {
            background: rgba(255, 255, 255, 0.02);
        }

        .profile-section h2, .profile-section h3 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .profile-section h2::after, .profile-section h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-blue), var(--accent-purple));
            border-radius: 2px;
            animation: expandWidth 0.8s ease-out;
        }

        @keyframes expandWidth {
            0% { width: 0; }
            100% { width: 60px; }
        }

        /* Card Styling */
        .section-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }

        .section-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .section-card:hover::before {
            left: 100%;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.4),
                0 0 40px rgba(0, 212, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .section-card .card-body {
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .section-card .card-title {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-card .card-text, .section-card p {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .section-card .card-subtitle {
            color: var(--text-muted) !important;
        }

        .section-card strong {
            color: var(--text-primary);
        }

        /* Skills Tags */
        .skills-tag {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2), rgba(139, 92, 246, 0.2));
            color: var(--text-primary);
            border: 1px solid rgba(0, 212, 255, 0.3);
            padding: 8px 16px;
            margin: 6px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-block;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .skills-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .skills-tag:hover::before {
            left: 100%;
        }

        .skills-tag:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(139, 92, 246, 0.3));
            border-color: rgba(0, 212, 255, 0.5);
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.2);
        }

        /* Publication Items */
        .publication-item {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--accent-blue);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            animation: slideInRight 0.6s ease-out;
        }

        .publication-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transition: left 0.6s ease;
        }

        .publication-item:hover::before {
            left: 100%;
        }

        .publication-item:hover {
            transform: translateX(5px);
            border-left-color: var(--accent-purple);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        @keyframes slideInRight {
            0% { transform: translateX(30px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        .publication-item h5 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* Learning Resources Specific Styling */
        .learning-resource-card {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.8) 0%, 
                rgba(30, 41, 59, 0.7) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            height: 100%;
            animation: fadeInUp 0.6s ease-out;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .learning-resource-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .learning-resource-card:hover::before {
            left: 100%;
        }

        .learning-resource-card:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.5),
                0 0 40px rgba(0, 212, 255, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border-color: rgba(0, 212, 255, 0.4);
        }

        .learning-resource-card .card-body {
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .learning-resource-card .card-title {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .learning-resource-card .card-title i {
            color: var(--accent-blue);
            font-size: 1.2rem;
        }

        .learning-resource-card .card-text {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .learning-resource-card .badge {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.3), rgba(139, 92, 246, 0.3));
            color: var(--text-primary);
            border: 1px solid rgba(0, 212, 255, 0.4);
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 500;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .learning-resource-card .btn {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);
        }

        .learning-resource-card .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .learning-resource-card .btn:hover::before {
            left: 100%;
        }

        .learning-resource-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
            color: white;
        }

        /* Learning Resources Section Background */
        .learning-resources-section {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.6) 0%, 
                rgba(30, 41, 59, 0.4) 50%, 
                rgba(15, 23, 42, 0.6) 100%);
            border-top: 1px solid rgba(0, 212, 255, 0.1);
            border-bottom: 1px solid rgba(0, 212, 255, 0.1);
        }

        /* Empty State Styling */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            margin: 2rem 0;
            animation: fadeInUp 0.8s ease-out;
        }

        .empty-state i {
            color: var(--text-muted);
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .empty-state h4 {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .empty-state .btn {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }

        .empty-state .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
            color: white;
        }

        /* Buttons Styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border: none;
            border-radius: 15px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--accent-blue);
            color: var(--accent-blue);
            background: transparent;
            border-radius: 15px;
            padding: 10px 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            border-color: var(--accent-purple);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.3);
        }

        .btn-outline-secondary {
            border: 2px solid var(--text-muted);
            color: var(--text-muted);
            background: transparent;
            border-radius: 15px;
            padding: 10px 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: var(--text-muted);
            color: var(--dark-gradient);
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 3rem 0;
            margin-top: 4rem;
        }

        footer p {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        footer small {
            color: var(--text-muted);
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 15px;
            margin-bottom: 2rem;
            backdrop-filter: blur(20px);
            position: relative;
            overflow: hidden;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border-left: 4px solid #28a745;
            color: var(--text-primary);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border-left: 4px solid #dc3545;
            color: var(--text-primary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-header h1 {
                font-size: 2.5rem;
            }
            
            .profile-image-wrapper img {
                width: 200px;
                height: 200px;
            }
            
            .profile-section {
                padding: 40px 0;
            }
            
            .section-card .card-body {
                padding: 1.5rem;
            }
        }
        
        /* Project Cards Styling (keeping existing styles) */
        .user-project-card {
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }
        
        .user-project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: #007bff;
            text-decoration: none;
            color: inherit;
        }
        
        .project-card-image {
            height: 200px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .project-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .user-project-card:hover .project-card-image img {
            transform: scale(1.05);
        }
        
        .project-card-body {
            padding: 1.5rem;
        }
        
        .project-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            color: inherit;
        }
        
        .project-card-description {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }
        
        .project-card-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .project-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .project-meta-icon {
            color: #007bff;
            width: 16px;
        }
        
        .project-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-public {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .badge-private {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }
        
        .badge-member {
            background: linear-gradient(135deg, #6f42c1, #e83e8c);
            color: white;
            top: 50px !important;
        }
        
        /* Research-style Project Cards */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }
        
        .research-project-card {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.8) 0%, 
                rgba(30, 41, 59, 0.6) 100%);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(37, 99, 235, 0.2);
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            height: 100%;
            text-decoration: none;
            color: inherit;
        }
        
        .research-project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(37, 99, 235, 0.1) 0%, 
                rgba(139, 92, 246, 0.1) 50%,
                rgba(20, 184, 166, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }
        
        .research-project-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #007bff;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.3),
                0 0 40px rgba(37, 99, 235, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-decoration: none;
            color: inherit;
        }
        
        .research-project-card:hover::before {
            opacity: 1;
        }
        
        .research-card-image {
            height: 250px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        
        .research-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            filter: brightness(0.8) saturate(1.2);
        }
        
        .research-card-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.3) 0%, 
                rgba(30, 41, 59, 0.5) 100%);
            transition: opacity 0.4s ease;
        }
        
        .research-project-card:hover .research-card-image img {
            transform: scale(1.1);
            filter: brightness(1) saturate(1.4);
        }
        
        .research-project-card:hover .research-card-image::after {
            opacity: 0.3;
        }
        
        .research-card-content {
            padding: 2rem;
            position: relative;
            z-index: 5;
        }
        
        .research-project-badge {
            position: absolute;
            top: -15px;
            left: 25px;
            background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        .research-project-badge.owner {
            background: linear-gradient(135deg, #28a745, #20c997);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }
        
        .research-project-badge.member {
            background: linear-gradient(135deg, #6f42c1, #e83e8c);
            box-shadow: 0 8px 20px rgba(111, 66, 193, 0.4);
        }
        
        .research-project-badge.private {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        }
        
        .research-project-card:hover .research-project-badge {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.6);
        }
        
        .research-card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
            line-height: 1.3;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .research-card-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #007bff, #6f42c1);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }
        
        .research-project-card:hover .research-card-title {
            color: #007bff;
        }
        
        .research-project-card:hover .research-card-title::after {
            width: 100%;
        }
        
        .research-card-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        .research-project-meta {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .research-meta-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            padding: 8px 15px;
            background: rgba(15, 23, 42, 0.4);
            border-radius: 10px;
            border-left: 3px solid #007bff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .research-meta-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .research-project-card:hover .research-meta-item {
            transform: translateX(5px);
            border-left-color: #20c997;
        }
        
        .research-project-card:hover .research-meta-item::before {
            left: 100%;
        }
        
        .research-meta-icon {
            color: #007bff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .research-project-card:hover .research-meta-icon {
            color: #20c997;
            transform: scale(1.2);
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
    
  <div class="container-fluid profile-header">
    <div class="container">
      <div class="row align-items-center">
          <div class="col-md-8">
              <h1 class="display-4">Hi, I'm <strong><?= htmlspecialchars($student['basic_info']['name'] ?? $student['name'] ?? 'Student') ?></strong></h1>
              <p class="lead text-muted">Student ID: <?= htmlspecialchars($student['academic_info']['student_id'] ?? $student['student_id'] ?? 'N/A') ?></p>
              
              <div class="info-item">
                  <i class="bi bi-mortarboard-fill"></i> 
                  <strong><?= htmlspecialchars($student['academic_info']['department'] ?? $student['department'] ?? 'Department') ?></strong>
              </div>
              
              <div class="info-item">
                  <i class="bi bi-building"></i> 
                  <?= htmlspecialchars($student['academic_info']['faculty'] ?? $student['faculty'] ?? 'Faculty') ?>
              </div>
              
              <div class="info-item">
                  <i class="bi bi-calendar3"></i> 
                  <?= htmlspecialchars($student['academic_info']['current_year_trimester'] ?? $student['current_year_trimester'] ?? 'Year/Trimester') ?>
              </div>
              
              <div class="info-item">
                  <i class="bi bi-envelope"></i> 
                  <?= htmlspecialchars($student['contact_info']['primary_email'] ?? $student['email'] ?? 'email@example.com') ?>
              </div>
              
              <?php 
              $cgpa = $student['academic_info']['cgpa'] ?? $student['cgpa'] ?? null;
              if($cgpa !== null): ?>
              <div class="info-item">
                  <i class="bi bi-graph-up"></i> 
                  CGPA: <strong><?= htmlspecialchars($cgpa) ?></strong>
              </div>
              <?php endif; ?>
              
              <div class="mt-3">
                  <span class="badge bg-<?= ($student['academic_info']['current_status'] ?? $student['current_status'] ?? 'Active') === 'Active' ? 'success' : 'secondary' ?> status-badge">
                      <?= htmlspecialchars($student['academic_info']['current_status'] ?? $student['current_status'] ?? 'Active') ?>
                  </span>
              </div>
          </div>
          
          <div class="col-md-4 profile-image-container">
              <div class="profile-image-wrapper">
                  <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profile Picture" loading="lazy">
          </div>
              <?php if ($isOwnProfile): ?>
              <div class="mt-3">
                  <a href="Student_Profile_Edit.php" class="profile-edit-btn">
                      <i class="bi bi-pencil-square"></i> Edit Profile
                  </a>
              </div>
              <?php endif; ?>
          </div>
      </div>
    </div>
  </div>

  <!-- Academic Information Section -->
  <section class="profile-section py-5">
    <div class="container">
        <h2 class="mb-4">Academic Information</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="card section-card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($student['academic_info']['current_degree_info']['degree_name'] ?? $student['degree_name'] ?? $student['degree'] ?? 'Degree Information') ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($student['academic_info']['current_degree_info']['institution_name'] ?? $student['institution'] ?? 'United International University') ?></h6>
                        <p class="card-text">
                            <strong>Major:</strong> <?= htmlspecialchars($student['academic_info']['current_degree_info']['major_field_of_study'] ?? $student['major_field'] ?? $student['field'] ?? 'N/A') ?><br>
                            <strong>Enrollment:</strong> <?php 
                                // Handle MongoDB date format properly
                                if (isset($student['academic_info']['enrollment_date'])) {
                                    $enrollmentDate = $student['academic_info']['enrollment_date'];
                                    if (is_array($enrollmentDate) && isset($enrollmentDate['$date'])) {
                                        if (is_array($enrollmentDate['$date']) && isset($enrollmentDate['$date']['$numberLong'])) {
                                            // MongoDB format with $numberLong (milliseconds)
                                            $timestamp = intval($enrollmentDate['$date']['$numberLong']) / 1000;
                                            echo date('F Y', $timestamp);
                                        } elseif (is_string($enrollmentDate['$date'])) {
                                            // Direct date string format
                                            echo date('F Y', strtotime($enrollmentDate['$date']));
                                        } else {
                                            echo 'N/A';
                                        }
                                    } else {
                                        echo 'N/A';
                                    }
                                } elseif (isset($student['enrollment_date'])) {
                                    // Fallback to old structure
                                    $enrollmentDate = $student['enrollment_date'];
                                    if (is_array($enrollmentDate) && isset($enrollmentDate['$date'])) {
                                        if (is_array($enrollmentDate['$date']) && isset($enrollmentDate['$date']['$numberLong'])) {
                                            $timestamp = intval($enrollmentDate['$date']['$numberLong']) / 1000;
                                            echo date('F Y', $timestamp);
                                        } elseif (is_string($enrollmentDate['$date'])) {
                                            echo date('F Y', strtotime($enrollmentDate['$date']));
                                        } else {
                                            echo 'N/A';
                                        }
                                    } elseif (is_string($enrollmentDate)) {
                                        echo date('F Y', strtotime($enrollmentDate));
                                    } else {
                                        echo 'N/A';
                                    }
                                } else {
                                    echo 'N/A';
                                }
                            ?><br>
                            <strong>Expected Graduation:</strong> <?php 
                                // Handle MongoDB date format properly  
                                if (isset($student['academic_info']['expected_graduation_date'])) {
                                    $graduationDate = $student['academic_info']['expected_graduation_date'];
                                    if (is_array($graduationDate) && isset($graduationDate['$date'])) {
                                        if (is_array($graduationDate['$date']) && isset($graduationDate['$date']['$numberLong'])) {
                                            // MongoDB format with $numberLong (milliseconds)
                                            $timestamp = intval($graduationDate['$date']['$numberLong']) / 1000;
                                            echo date('F Y', $timestamp);
                                        } elseif (is_string($graduationDate['$date'])) {
                                            // Direct date string format
                                            echo date('F Y', strtotime($graduationDate['$date']));
                                        } else {
                                            echo 'N/A';
                                        }
                                    } else {
                                        echo 'N/A';
                                    }
                                } elseif (isset($student['expected_graduation_date'])) {
                                    // Fallback to old structure
                                    $graduationDate = $student['expected_graduation_date'];
                                    if (is_array($graduationDate) && isset($graduationDate['$date'])) {
                                        if (is_array($graduationDate['$date']) && isset($graduationDate['$date']['$numberLong'])) {
                                            $timestamp = intval($graduationDate['$date']['$numberLong']) / 1000;
                                            echo date('F Y', $timestamp);
                                        } elseif (is_string($graduationDate['$date'])) {
                                            echo date('F Y', strtotime($graduationDate['$date']));
                                        } else {
                                            echo 'N/A';
                                        }
                                    } elseif (is_string($graduationDate)) {
                                        echo date('F Y', strtotime($graduationDate));
                                    } else {
                                        echo 'N/A';
                                    }
                                } else {
                                    echo 'N/A';
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>

  <!-- Thesis Information Section (if exists) -->
  <?php if(isset($student['academic_info']['thesis_info']) && $student['academic_info']['thesis_info'] !== null): ?>
  <section class="profile-section bg-light py-5">
    <div class="container">
        <h2 class="mb-4">Thesis Information</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="card section-card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($student['academic_info']['thesis_info']['title'] ?? 'Thesis Title') ?></h5>
                        <p class="card-text">
                            <strong>Supervisor:</strong> <?= htmlspecialchars($student['academic_info']['thesis_info']['supervisor_name'] ?? 'N/A') ?><br>
                            <strong>Status:</strong> <span class="badge bg-info"><?= htmlspecialchars($student['academic_info']['thesis_info']['status'] ?? 'N/A') ?></span><br>
                            <strong>Description:</strong> <?= htmlspecialchars($student['academic_info']['thesis_info']['description'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- Research Interests & Skills Section -->
  <section class="profile-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-3">Research Interests</h3>
                <div class="card section-card">
                    <div class="card-body">
                        <?php 
                        $researchInterests = $student['university_research_profile']['research_interests'] ?? $student['research_interests'] ?? [];
                        if(is_array($researchInterests) && count($researchInterests) > 0): ?>
                            <?php foreach($researchInterests as $interest): ?>
                                <span class="skills-tag"><?= htmlspecialchars($interest) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No research interests added yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h3 class="mb-3">Skills & Expertise</h3>
                <div class="card section-card">
                    <div class="card-body">
                        <?php 
                        $skills = $student['university_research_profile']['skills_expertise'] ?? $student['skills'] ?? [];
                        if(is_array($skills) && count($skills) > 0): ?>
                            <?php foreach($skills as $skill): ?>
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

  <!-- My Research Projects Section -->
  <section class="profile-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Research Projects</h2>
            <div>
                <a href="project_management.php" class="btn btn-outline-primary me-2">
                    <i class="bi bi-eye"></i> View All Projects
                </a>
                <a href="project_management.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Manage Projects
                </a>
            </div>
        </div>
        
        <!-- Projects Loading -->
        <div class="text-center" id="projects-loading" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading projects...</span>
            </div>
            <p class="mt-2 text-muted">Loading your research projects...</p>
        </div>
        
        <!-- Projects Grid -->
        <div class="projects-grid" id="user-projects-grid">
            <!-- Projects will be loaded here via JavaScript -->
        </div>
        
        <!-- Random Selection Note -->
        <div class="text-center mt-3" id="projects-note" style="display: none;">
        </div>
        
        <!-- No Projects Message -->
        <div class="empty-state" id="no-projects" style="display: none;">
            <div class="mb-3">
                <i class="bi bi-folder2-open text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted">No Research Projects Yet</h4>
            <p class="text-muted">You haven't joined any research projects yet. Start by creating a new project or join an existing one!</p>
            <div class="mt-3">
                <a href="project_management.php" class="btn btn-primary me-2">
                    <i class="bi bi-plus-circle"></i> Create Your First Project
                </a>
                <a href="Research_page.php" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i> Browse Projects
                </a>
            </div>
        </div>
    </div>
  </section>

  <!-- Learning Resources Section -->
  <section class="profile-section learning-resources-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Learning Resources</h2>
            <?php if ($isOwnProfile): ?>
            <a href="Student_Profile_Edit.php#learning-resources" class="btn btn-outline-primary">
                <i class="bi bi-pencil-square"></i> Edit Resources
            </a>
            <?php endif; ?>
        </div>
        
        <?php 
        $learningResources = $student['learning_resources'] ?? [];
        if(is_array($learningResources) && count($learningResources) > 0): ?>
            <div class="row">
                <?php foreach($learningResources as $resource): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card learning-resource-card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-bookmark-star me-2"></i>
                                    <?= htmlspecialchars($resource['title']) ?>
                                </h5>
                                <?php if(!empty($resource['description'])): ?>
                                    <p class="card-text"><?= htmlspecialchars($resource['description']) ?></p>
                                <?php endif; ?>
                                <div class="mb-2">
                                    <span class="badge"><?= htmlspecialchars($resource['category']) ?></span>
                                    <span class="badge"><?= htmlspecialchars($resource['type']) ?></span>
                                </div>
                                <a href="<?= htmlspecialchars($resource['url']) ?>" target="_blank" class="btn btn-sm">
                                    <i class="bi bi-box-arrow-up-right"></i> Access Resource
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="mb-3">
                    <i class="bi bi-book text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted">No Learning Resources Added</h4>
                <p class="text-muted">Share useful resources, tutorials, and learning materials related to your skills and interests!</p>
                <?php if ($isOwnProfile): ?>
                <a href="Student_Profile_Edit.php#learning-resources" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Your First Resource
                </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
  </section>

  <!-- Publications Section -->
  <?php if(isset($student['university_research_profile']['university_publications']) && count($student['university_research_profile']['university_publications']) > 0): ?>
  <section class="profile-section bg-light py-5">
    <div class="container">
        <h2 class="mb-4">Publications</h2>
        <div class="row">
            <div class="col-md-12">
                <?php foreach($student['university_research_profile']['university_publications'] as $publication): ?>
                    <div class="publication-item">
                        <h5><?= htmlspecialchars($publication['title']) ?></h5>
                        <p class="text-muted mb-2">
                            <strong>Authors:</strong> <?= htmlspecialchars(implode(', ', $publication['authors'])) ?><br>
                            <strong>Type:</strong> <?= htmlspecialchars($publication['publication_type']) ?><br>
                            <strong>Venue:</strong> <?= htmlspecialchars($publication['venue_or_journal_name']) ?><br>
                            <strong>Date:</strong> <?php 
                                if (isset($publication['publication_date'])) {
                                    $pubDate = $publication['publication_date'];
                                    if (is_array($pubDate) && isset($pubDate['$date'])) {
                                        if (is_array($pubDate['$date']) && isset($pubDate['$date']['$numberLong'])) {
                                            // MongoDB format with $numberLong (milliseconds)
                                            $timestamp = intval($pubDate['$date']['$numberLong']) / 1000;
                                            echo date('F Y', $timestamp);
                                        } elseif (is_string($pubDate['$date'])) {
                                            // Direct date string format
                                            echo date('F Y', strtotime($pubDate['$date']));
                                        } else {
                                            echo 'N/A';
                                        }
                                    } else {
                                        echo 'N/A';
                                    }
                                } else {
                                    echo 'N/A';
                                }
                            ?><br>
                            <?php if(isset($publication['abstract'])): ?>
                                <strong>Abstract:</strong> <?= htmlspecialchars($publication['abstract']) ?>
                            <?php endif; ?>
                        </p>
                        <div>
                            <?php if(isset($publication['doi_url'])): ?>
                                <a href="<?= htmlspecialchars($publication['doi_url']) ?>" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="bi bi-link-45deg"></i> DOI
                                </a>
                            <?php endif; ?>
                            <?php if(isset($publication['paper_url'])): ?>
                                <a href="<?= htmlspecialchars($publication['paper_url']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-file-earmark-pdf"></i> View Paper
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- Footer -->
  <?php include 'src/includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Load user projects on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadUserProjects();
    });
    
    function loadUserProjects() {
        const projectsGrid = document.getElementById('user-projects-grid');
        const projectsLoading = document.getElementById('projects-loading');
        const noProjects = document.getElementById('no-projects');
        
        console.log('Loading user projects...');
        console.log('Elements found:', {
            projectsGrid: !!projectsGrid,
            projectsLoading: !!projectsLoading,
            noProjects: !!noProjects
        });
        
        // Show loading
        if (projectsLoading) projectsLoading.style.display = 'block';
        if (noProjects) noProjects.style.display = 'none';
        if (projectsGrid) projectsGrid.innerHTML = '';
        
        // Fetch all user projects (both owned and member projects)
        console.log('Making fetch request to: src/model/fetch_all_user_projects.php');
        fetch('src/model/fetch_all_user_projects.php')
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response OK:', response.ok);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    console.error('Response not OK. Status:', response.status, 'StatusText:', response.statusText);
                    throw new Error('Network response was not ok: ' + response.status + ' ' + response.statusText);
                }
                
                // Get response text first to see what we actually received
                return response.text();
            })
            .then(responseText => {
                console.log('Raw response text:', responseText);
                
                // Try to parse as JSON
                let projects;
                try {
                    projects = JSON.parse(responseText);
                    console.log('Parsed projects:', projects);
                } catch (jsonError) {
                    console.error('JSON parse error:', jsonError);
                    console.error('Response text that failed to parse:', responseText);
                    throw new Error('Invalid JSON response: ' + jsonError.message);
                }
                
                console.log('Projects received:', projects);
                console.log('Number of projects:', projects ? projects.length : 0);
                console.log('Type of projects:', typeof projects);
                console.log('Is array:', Array.isArray(projects));
                
                // Hide loading
                if (projectsLoading) projectsLoading.style.display = 'none';
                if (projectsGrid) projectsGrid.innerHTML = '';
                
                const projectsNote = document.getElementById('projects-note');
                
                if (projects && projects.length > 0) {
                    console.log('Displaying projects...');
                    
                    // Limit to first 3 projects for profile display
                    const displayProjects = projects.slice(0, 3);
                    const hasMoreProjects = projects.length > 3;
                    
                    // Display projects
                    displayProjects.forEach((project, index) => {
                        console.log(`Creating card for project ${index}:`, project.title || project._id);
                        try {
                            const projectCard = createProjectCard(project, index);
                            if (projectsGrid) projectsGrid.appendChild(projectCard);
                        } catch (cardError) {
                            console.error('Error creating project card:', cardError, 'Project data:', project);
                        }
                    });
                    
                    // Show note about displaying limited projects
                    if (projectsNote) {
                        if (hasMoreProjects) {
                            projectsNote.innerHTML = `
                                <p class="text-muted mb-2">
                                    <i class="bi bi-info-circle"></i> 
                                    Showing 3 of ${projects.length} research projects
                                </p>
                                <a href="project_management.php" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-arrow-right"></i> View All ${projects.length} Projects
                                </a>
                            `;
                        } else {
                            projectsNote.innerHTML = `
                                <p class="text-muted">
                                    <i class="bi bi-check-circle"></i> 
                                    Showing all ${projects.length} research project${projects.length === 1 ? '' : 's'}
                                </p>
                            `;
                        }
                        projectsNote.style.display = 'block';
                    }
                } else {
                    console.log('No projects found, showing empty state');
                    // Show no projects message
                    if (noProjects) noProjects.style.display = 'block';
                    if (projectsNote) projectsNote.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading projects:', error);
                console.error('Error stack:', error.stack);
                if (projectsLoading) projectsLoading.style.display = 'none';
                if (noProjects) noProjects.style.display = 'block';
                const projectsNote = document.getElementById('projects-note');
                if (projectsNote) projectsNote.style.display = 'none';
                
                // Update no projects message for error case
                const noProjectsTitle = noProjects ? noProjects.querySelector('h4') : null;
                const noProjectsText = noProjects ? noProjects.querySelector('p') : null;
                if (noProjectsTitle) noProjectsTitle.textContent = 'Error Loading Projects';
                if (noProjectsText) noProjectsText.textContent = 'There was an error loading your research projects. Please check the browser console for details.';
            });
    }
    
    function createProjectCard(project, index) {
        // Get project ID
        const projectId = project._id && project._id.$oid ? project._id.$oid : project._id;
        
        // Format date
        const formattedDate = formatProjectDate(project.createdAt);
        
        // Get project image
        const imageSrc = getProjectImage(project.coverImage);
        
        // Format supervisor
        const supervisor = formatSupervisor(project.supervisor);
        
        // Truncate description
        const description = truncateText(project.abstract || project.description || 'No description available', 120);
        
        // Format team members
        const teamMembers = project.members ? project.members.length + ' team member(s)' : '0 team members';
        
        // Determine badge based on user role and privacy
        let badgeClass = 'research-project-badge';
        let badgeText = 'Public';
        
        if (project.userRole === 'owner') {
            badgeClass += ' owner';
            badgeText = 'Owner';
        } else if (project.userRole === 'member') {
            badgeClass += ' member';
            badgeText = 'Member';
        }
        
        if (project.privacy === 1) {
            badgeClass += ' private';
            badgeText += ' (Private)';
        }
        
        const card = document.createElement('a');
        card.href = `Project_details.php?id=${projectId}`;
        card.className = 'research-project-card';
        card.style.textDecoration = 'none';
        card.innerHTML = `
            <div class="research-card-image">
                <img src="${imageSrc}" alt="${project.title}" loading="lazy" onerror="this.src='assets/resources/research_picture/pub_1.jpg'">
            </div>
            <div class="research-card-content">
                <div class="${badgeClass}">${badgeText}</div>
                <h3 class="research-card-title">${project.title}</h3>
                <p class="research-card-description">${description}</p>
                <div class="research-project-meta">
                    <div class="research-meta-item">
                        <i class="research-meta-icon far fa-calendar-alt"></i>
                        <span>${formattedDate}</span>
                    </div>
                    <div class="research-meta-item">
                        <i class="research-meta-icon fas fa-chalkboard-teacher"></i>
                        <span>Supervisor: ${supervisor}</span>
                    </div>
                    <div class="research-meta-item">
                        <i class="research-meta-icon fas fa-users"></i>
                        <span>${teamMembers}</span>
                    </div>
                    <div class="research-meta-item">
                        <i class="research-meta-icon fas fa-graduation-cap"></i>
                        <span>${project.field || 'Research'}</span>
                    </div>
                </div>
            </div>
        `;
        
        return card;
    }
    
    function formatProjectDate(dateInput) {
        if (!dateInput) return 'Not specified';
        
        try {
            let dateValue = dateInput;
            
            if (typeof dateInput === 'object' && dateInput.$date) {
                dateValue = dateInput.$date;
            }
            
            const date = new Date(dateValue);
            
            if (isNaN(date.getTime())) {
                return 'Date not available';
            }
            
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        } catch (error) {
            console.error('Date formatting error:', error);
            return 'Date not available';
        }
    }
    
    function getProjectImage(coverImage) {
        const defaultImages = [
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

        if (coverImage && coverImage.url && coverImage.url.trim()) {
            return coverImage.url;
        }
        
        return defaultImages[Math.floor(Math.random() * defaultImages.length)];
    }
    
    function formatSupervisor(supervisor) {
        if (!supervisor) return 'Not specified';
        
        if (typeof supervisor === 'string') return supervisor;
        if (typeof supervisor === 'object') {
            return supervisor.name || supervisor.userId || 'Not specified';
        }
        
        return 'Not specified';
    }
    
    function truncateText(text, maxLength) {
        if (!text || text.length <= maxLength) return text || '';
        return text.substring(0, maxLength) + '...';
    }
  </script>
</body>
</html>
