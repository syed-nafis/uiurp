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

// Import MongoDB BSON classes for ObjectId
use MongoDB\BSON\ObjectId;

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
        
        /* Meeting Card Styles - Dark Mode (Default) */
        .meeting-card {
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid rgba(30, 64, 175, 0.2) !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .meeting-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        }
        
        .meeting-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.25);
            border-color: rgba(30, 64, 175, 0.4) !important;
            background: rgba(30, 41, 59, 0.95);
        }
        
        .meeting-card h6 {
            color: var(--text-primary);
            font-weight: 600;
        }
        
        .meeting-card .text-muted {
            color: var(--text-secondary) !important;
        }
        
        .meeting-card .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            background: rgba(30, 64, 175, 0.8);
            color: var(--text-primary);
            border: 1px solid rgba(30, 64, 175, 0.3);
        }
        
        .meeting-card .badge.bg-success {
            background: rgba(5, 150, 105, 0.8) !important;
            border-color: rgba(5, 150, 105, 0.3);
        }
        
        .meeting-card .badge.bg-warning {
            background: rgba(217, 119, 6, 0.8) !important;
            border-color: rgba(217, 119, 6, 0.3);
        }
        
        .meeting-card .badge.bg-danger {
            background: rgba(220, 38, 38, 0.8) !important;
            border-color: rgba(220, 38, 38, 0.3);
        }
        
        .meeting-card .badge.bg-info {
            background: rgba(2, 132, 199, 0.8) !important;
            border-color: rgba(2, 132, 199, 0.3);
        }
        
        /* Meeting Card Styles - Light Mode */
        [data-theme="light"] .meeting-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(30, 64, 175, 0.1) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        [data-theme="light"] .meeting-card::before {
            background: linear-gradient(135deg, #1e40af, #0284c7);
        }
        
        [data-theme="light"] .meeting-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.15);
            border-color: rgba(30, 64, 175, 0.3) !important;
            background: rgba(255, 255, 255, 1);
        }
        
        [data-theme="light"] .meeting-card h6 {
            color: #0f172a;
            font-weight: 600;
        }
        
        [data-theme="light"] .meeting-card .text-muted {
            color: #6c757d !important;
        }
        
        [data-theme="light"] .meeting-card .badge {
            background: #1e40af;
            color: white;
            border: 1px solid rgba(30, 64, 175, 0.2);
        }
        
        [data-theme="light"] .meeting-card .badge.bg-success {
            background: #059669 !important;
            border-color: rgba(5, 150, 105, 0.2);
        }
        
        [data-theme="light"] .meeting-card .badge.bg-warning {
            background: #d97706 !important;
            border-color: rgba(217, 119, 6, 0.2);
            color: white;
        }
        
        [data-theme="light"] .meeting-card .badge.bg-danger {
            background: #dc2626 !important;
            border-color: rgba(220, 38, 38, 0.2);
        }
        
        [data-theme="light"] .meeting-card .badge.bg-info {
            background: #0284c7 !important;
            border-color: rgba(2, 132, 199, 0.2);
        }
        
        /* Meetings Container Theme Support */
        #meetings-container {
            transition: all 0.3s ease;
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        #meetings-container::-webkit-scrollbar {
            display: none;
        }
        
        [data-theme="light"] #meetings-container {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 8px;
        }
        
        [data-theme="light"] #meetings-container .card-header {
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid rgba(30, 64, 175, 0.15);
        }
        
        [data-theme="light"] #meetings-container .card-header h5 {
            color: #0f172a !important;
        }
        
        [data-theme="light"] #no-meetings {
            color: #1e40af;
        }
        
        [data-theme="light"] #no-meetings i {
            color: #1e40af !important;
        }
        
        [data-theme="light"] #no-meetings p {
            color: #1e40af !important;
        }
        
        [data-theme="light"] #no-meetings small {
            color: #6c757d !important;
        }
        
        /* Loading states for light theme */
        [data-theme="light"] #meetings-loading .text-muted {
            color: #6c757d !important;
        }
        
        [data-theme="light"] #meetings-loading .spinner-border {
            color: #1e40af;
        }
        
        /* Dark mode styles for meetings container */
        [data-theme="dark"] #meetings-container {
            background: rgba(31, 41, 55, 0.6);
        }
        
        /* Meeting Modal Styles */
        #meetingModal .modal-content {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(30, 64, 175, 0.3);
            box-shadow: 0 0 30px rgba(30, 64, 175, 0.2);
        }
        
        #meetingModal .modal-header {
            border-bottom: 1px solid rgba(30, 64, 175, 0.2);
        }
        
        #meetingModal .modal-footer {
            border-top: 1px solid rgba(30, 64, 175, 0.2);
            position: relative !important;
            bottom: auto !important;
            left: auto !important;
            right: auto !important;
        }
        
        #meetingModal .form-label {
            color: var(--text-primary);
            font-weight: 500;
        }
        
        #meetingModal .form-control {
            background: rgba(30, 41, 59, 0.3);
            border: 1px solid rgba(30, 64, 175, 0.3);
            color: var(--text-primary);
        }
        
        #meetingModal .form-control:focus {
            background: rgba(30, 41, 59, 0.4);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25);
            color: var(--text-primary);
        }
        
        #meetingModal .form-control::placeholder {
            color: var(--text-muted);
        }
        
        /* Availability Results Styling */
        #availabilityResults {
            border-radius: 8px;
            border: none;
        }
        
        /* Single line availability status */
        .availability-status-inline {
            font-size: 0.85rem;
            padding: 4px 8px;
            border-radius: 4px;
            background: rgba(0, 0, 0, 0.05);
            border-left: 3px solid #6c757d;
            color: #6c757d;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .availability-status-inline.alert-success {
            background: rgba(25, 135, 84, 0.1);
            border-left-color: #198754;
            color: #198754;
        }
        
        .availability-status-inline.alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border-left-color: #ffc107;
            color: #b8860b;
        }
        
        .availability-status-inline.alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
            color: #dc3545;
        }
        
        .availability-status-inline.alert-info {
            background: rgba(13, 202, 240, 0.1);
            border-left-color: #0dcaf0;
            color: #087990;
        }
        
        #memberSchedules {
            background: rgba(30, 41, 59, 0);
            border-radius: 8px;
            padding: 1rem;
            /* Inherit height from team-overview-sidebar class */
            min-height: 400px !important;
            max-height: calc(80vh - 120px) !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }
        
        #memberSchedules h6 {
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }
        
        /* Custom Calendar Styles */
        .custom-calendar {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(30, 64, 175, 0.2);
            border-radius: 8px;
            padding: 15px;
            max-width: 320px;
            width: 100%;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .calendar-nav-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .calendar-nav-btn:hover {
            background: rgba(30, 64, 175, 0.1);
        }
        
        .calendar-month-year {
            font-weight: 600;
            color: var(--text-while);
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }
        
        .calendar-day-header {
            text-align: center;
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            padding: 8px 4px;
        }
        
        .calendar-day {
            text-align: center;
            padding: 8px 4px;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        
        .calendar-day:hover {
            background: rgba(30, 64, 175, 0.1);
        }
        
        .calendar-day.disabled {
            color: #ccc;
            cursor: not-allowed;
        }
        
        .calendar-day.disabled:hover {
            background: none;
        }
        
        .calendar-day.selected {
            background: var(--primary-color);
            color: white;
        }
        
        .calendar-day.today {
            background: rgba(30, 64, 175, 0.2);
            font-weight: 600;
        }
        
        .calendar-day.other-month {
            color: #ccc;
        }
        
        /* Time Suggestions Grid */
        .time-slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        /* Time Suggestion Cards */
        .time-suggestion-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(30, 64, 175, 0.2) !important;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
        }
        
        .time-suggestion-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.2);
            border-color: rgba(30, 64, 175, 0.4) !important;
        }
        
        .time-suggestion-card.selected {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 20px rgba(30, 64, 175, 0.3);
            background: rgba(30, 64, 175, 0.05);
        }
        
        .time-suggestion-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.15);
        }
        
        .time-suggestion-card.border-success {
            border-color: #198754 !important;
        }
        
        .time-suggestion-card.border-success:hover {
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.25);
        }
        
        .time-suggestion-card.border-warning {
            border-color: #ffc107 !important;
        }
        
        .time-suggestion-card.border-danger {
            border-color: #dc3545 !important;
        }
        
        /* Enhanced Time Suggestions Panel */
        .time-suggestions-panel {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(30, 64, 175, 0.1);
            border-radius: 16px;
            padding: 24px;
            height: 100%;
            max-height: 600px;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .panel-header {
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        
        .panel-header h6 {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
        }
        
        /* Enhanced Loading State */
        .loading-state {
            background: rgba(30, 64, 175, 0.02);
            border: 1px dashed rgba(30, 64, 175, 0.2);
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .loading-state p {
            color: var(--primary-color);
            margin: 0;
        }
        
        /* Enhanced Empty State */
        .empty-state {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.02) 0%, rgba(124, 58, 237, 0.02) 100%);
            border: 1px dashed rgba(30, 64, 175, 0.15);
            border-radius: 12px;
            margin: 20px 0;
        }
        
        .empty-icon i {
            font-size: 3rem;
            opacity: 0.6;
        }
        
        /* Availability Status */
        .availability-status {
            border-radius: 12px;
            border: none !important;
            font-weight: 500;
            padding: 16px 20px;
        }
        
        .availability-status.alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745 !important;
        }
        
        .availability-status.alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border-left: 4px solid #ffc107 !important;
        }
        
        .availability-status.alert-info {
            background: linear-gradient(135deg, #cce7ff 0%, #b3d9ff 100%);
            color: #0c5460;
            border-left: 4px solid #17a2b8 !important;
        }
        
        /* Quick Actions */
        .quick-actions {
            background: rgba(30, 64, 175, 0.03);
            border-radius: 10px;
            padding: 16px;
            border: 1px solid rgba(30, 64, 175, 0.08);
        }
        
        .quick-actions h6 {
            font-weight: 600;
        }
        
                 /* Enhanced Time Slots */
         .enhanced-time-slots {
             display: grid;
             gap: 16px;
             margin-bottom: 24px;
             max-height: calc(100% - 60px);
             overflow-y: auto;
             overflow-x: hidden;
             padding-right: 8px;
         }
         
         /* Meeting Details Section */
         .meeting-details-section {
             background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
             border: 1px solid rgba(30, 64, 175, 0.12);
             border-radius: 16px;
             padding: 24px;
             min-height: 400px;
             max-height: calc(80vh - 120px);
             overflow-y: auto;
             overflow-x: hidden;
             box-shadow: 0 4px 20px rgba(30, 64, 175, 0.08);
             backdrop-filter: blur(10px);
             position: relative;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         }

         .meeting-details-section::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             right: 0;
             height: 3px;
             background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), #20c997);
             opacity: 0.8;
         }

         .meeting-details-section:hover {
             transform: translateY(-2px);
             box-shadow: 0 8px 30px rgba(30, 64, 175, 0.15);
         }
         
         /* Recommendations Section */
         .recommendations-section {
             background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
             border: 1px solid rgba(30, 64, 175, 0.12);
             border-radius: 16px;
             padding: 24px;
             min-height: 400px;
             max-height: calc(80vh - 120px);
             overflow-y: auto;
             overflow-x: hidden;
             box-shadow: 0 4px 20px rgba(30, 64, 175, 0.08);
             backdrop-filter: blur(10px);
             position: relative;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
             margin-bottom: 16px;
         }
         
         /* Suggestions Container */
         .suggestions-container {
             min-height: 400px;
             max-height: calc(80vh - 120px);
             display: flex;
             flex-direction: column;
             overflow: visible;
         }
         
         /* Availability Results */
         .availability-status {
             background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 249, 235, 0.95) 100%);
             border: 1px solid rgba(255, 193, 7, 0.2);
             border-radius: 12px;
             padding: 20px;
             max-height: 150px;
             overflow-y: auto;
             overflow-x: hidden;
             box-shadow: 0 4px 15px rgba(255, 193, 7, 0.1);
             backdrop-filter: blur(5px);
             word-wrap: break-word;
             flex-shrink: 0;
         }
         
         /* Availability Results Alert Styling */
         #availabilityResults {
             margin-bottom: 16px;
             flex-shrink: 0;
             word-wrap: break-word;
             overflow-wrap: break-word;
         }
         
         /* Team Overview Sidebar */
         .team-overview-sidebar {
             background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
             border: 1px solid rgba(30, 64, 175, 0.12);
             border-radius: 16px;
             padding: 24px;
             min-height: 400px;
             max-height: calc(80vh - 120px);
             overflow-y: auto;
             overflow-x: hidden;
             box-shadow: 0 4px 20px rgba(30, 64, 175, 0.08);
             backdrop-filter: blur(10px);
             position: relative;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         }

         .recommendations-section::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             right: 0;
             height: 3px;
             background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), #20c997);
             opacity: 0.8;
         }

         .recommendations-section:hover {
             transform: translateY(-2px);
             box-shadow: 0 8px 30px rgba(30, 64, 175, 0.15);
         }
         
         .section-header {
             border-bottom: 1px solid rgba(30, 64, 175, 0.08);
             padding-bottom: 16px;
             margin-bottom: 20px;
             position: relative;
         }

         .section-header h6 {
             font-weight: 700;
             font-size: 1.1rem;
             margin-bottom: 4px;
             display: flex;
             align-items: center;
         }

         .section-header h6 i {
             font-size: 1.2rem;
             margin-right: 8px;
             padding: 6px;
             background: rgba(30, 64, 175, 0.1);
             border-radius: 8px;
         }

         .section-header small {
             color: #6c757d;
             font-weight: 500;
         }
         
         /* Three Column Layout */
         .modal-xl .row.g-4 > .col-lg-4 {
             padding: 0 8px;
         }
         
         /* Prevent text overflow and clipping */
         .suggestion-card,
         .member-card,
         .meeting-form-fields {
             word-wrap: break-word;
             overflow-wrap: break-word;
             hyphens: auto;
         }
         
         .member-name {
             max-width: 150px;
             overflow: hidden;
             text-overflow: ellipsis;
             white-space: nowrap;
         }
         
         .suggestion-card .time-display,
         .suggestion-card .card-title {
             word-break: normal;
             overflow-wrap: break-word;
         }
         
         /* Enhanced member cards for better content fitting */
         .member-card {
             min-height: auto;
             height: auto;
         }
         

         
         /* Ensure calendar fits properly */
         .custom-calendar {
             min-height: 250px;
             max-height: 350px;
             overflow: hidden;
         }
         
         .calendar-grid {
             overflow: hidden;
         }
         
                 /* Custom Calendar Styling */
        .custom-calendar {
            background: linear-gradient(135deg, rgba(248, 249, 250, 0.9) 0%, rgba(255, 255, 255, 0.9) 100%);
            border: 2px solid rgba(30, 64, 175, 0.08);
            border-radius: 12px;
            padding: 16px;
            min-height: 400px;
            backdrop-filter: blur(5px);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(30, 64, 175, 0.1);
        }

        .calendar-nav-btn {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(30, 64, 175, 0.05));
            border: 1px solid rgba(30, 64, 175, 0.2);
            color: var(--primary-color);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .calendar-nav-btn:hover {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.15), rgba(30, 64, 175, 0.1));
            transform: scale(1.05);
        }

        .calendar-day {
            text-align: center;
            padding: 10px 6px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .calendar-day:hover {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(30, 64, 175, 0.05));
            transform: scale(1.1);
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
            transform: scale(1.05);
        }

        .calendar-day.today {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.15), rgba(30, 64, 175, 0.1));
            font-weight: 700;
            border: 2px solid rgba(30, 64, 175, 0.3);
        }
        
        /* Team Meeting Suggestion Cards */
        .suggestion-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
            border: 2px solid rgba(30, 64, 175, 0.12);
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(5px);
        }
        
        .suggestion-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .suggestion-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 50px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(240, 248, 255, 1) 100%);
        }
        
        .suggestion-card:hover::before {
            opacity: 1;
        }

        .suggestion-card .time-display {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
            text-align: center;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .suggestion-card .duration-badge {
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(135deg, #10b981, #06d6a0);
            color: white;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .suggestion-card.border-success,
        .suggestion-card.border-warning,
        .suggestion-card.border-info {
            border-color: var(--primary-color) !important;
            background: rgba(30, 64, 175, 0.02) !important;
        }
        
        .suggestion-card.border-success::before,
        .suggestion-card.border-warning::before,
        .suggestion-card.border-info::before {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .suggestion-card.border-primary {
            border-color: var(--primary-color) !important;
            background: rgba(30, 64, 175, 0.04) !important;
            box-shadow: 0 8px 32px rgba(30, 64, 175, 0.15);
        }
        
        .suggestion-card.border-primary::before {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            opacity: 1;
        }
        
                 /* Time Card Content */
         .suggestion-card .card-title {
             font-size: 1.1rem;
             font-weight: 600;
             margin-bottom: 8px;
         }
         
         .suggestion-card .badge {
             font-size: 0.8rem;
             padding: 6px 10px;
             border-radius: 20px;
         }
         

        
                 /* Team Overview Sidebar */
         .team-overview-sidebar {
             background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
             border: 1px solid rgba(30, 64, 175, 0.12);
             border-radius: 16px;
             padding: 20px;
             height: 750px;
             max-height: 750px;
             overflow-y: auto;
             overflow-x: hidden;
             box-shadow: 0 4px 20px rgba(30, 64, 175, 0.08);
             backdrop-filter: blur(10px);
             position: relative;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         }

         .team-overview-sidebar::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             right: 0;
             height: 3px;
             background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), #20c997);
             opacity: 0.8;
         }

         .team-overview-sidebar:hover {
             transform: translateY(-2px);
             box-shadow: 0 8px 30px rgba(30, 64, 175, 0.15);
         }
         
         .sidebar-header {
             border-bottom: 1px solid rgba(30, 64, 175, 0.1);
             padding-bottom: 12px;
         }
         
         .sidebar-header h6 {
             color: var(--primary-color);
             font-weight: 600;
         }
         
         /* Member Cards in Sidebar */
         .member-card {
             background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
             border: 1px solid rgba(30, 64, 175, 0.08);
             border-radius: 12px;
             padding: 16px;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
             margin-bottom: 12px;
             position: relative;
             overflow: hidden;
         }

         .member-card::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             width: 3px;
             height: 100%;
             background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
             opacity: 0;
             transition: opacity 0.3s ease;
         }
         
         .member-card:hover {
             border-color: var(--primary-color);
             box-shadow: 0 8px 25px rgba(30, 64, 175, 0.12);
             transform: translateX(4px);
         }

         .member-card:hover::before {
             opacity: 1;
         }
         
         .member-avatar-small {
             display: flex;
             align-items: center;
             justify-content: center;
             width: 40px;
             height: 40px;
             background: linear-gradient(135deg, rgba(30, 64, 175, 0.1), rgba(30, 64, 175, 0.05));
             border-radius: 50%;
             font-size: 1.2rem;
             border: 2px solid rgba(30, 64, 175, 0.1);
         }
         
         .member-name {
             font-weight: 600;
             color: var(--text-dark);
             font-size: 0.95rem;
             margin-bottom: 4px;
         }
         
         .role-badge {
             font-size: 0.75rem;
             padding: 4px 10px;
             border-radius: 15px;
             font-weight: 600;
         }

         /* Enhanced Form Styling */
         .meeting-form-fields .form-label {
             font-weight: 600;
             color: var(--text-dark);
             margin-bottom: 8px;
             display: flex;
             align-items: center;
             font-size: 0.9rem;
         }

         .meeting-form-fields .form-label::before {
             content: '';
             width: 4px;
             height: 4px;
             background: var(--primary-color);
             border-radius: 50%;
             margin-right: 8px;
         }

         .meeting-form-fields .form-control,
         .meeting-form-fields .form-select {
             border: 2px solid rgba(30, 64, 175, 0.1);
             border-radius: 10px;
             padding: 12px 16px;
             font-size: 0.9rem;
             transition: all 0.3s ease;
             background: rgba(255, 255, 255, 0.8);
         }

         .meeting-form-fields .form-control:focus,
         .meeting-form-fields .form-select:focus {
             border-color: var(--primary-color);
             box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.15);
             background: rgba(255, 255, 255, 1);
             transform: translateY(-1px);
         }
         
         .status-indicator {
             font-size: 1.2rem;
             display: flex;
             align-items: center;
         }

         .status-indicator .bi-check-circle-fill {
             color: #10b981;
             filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.3));
         }

         .status-indicator .bi-exclamation-circle-fill {
             color: #f59e0b;
             filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.3));
         }
         
         /* Compact Conflicts */
         .conflicts-compact {
             background: linear-gradient(135deg, rgba(30, 64, 175, 0.06) 0%, rgba(30, 64, 175, 0.03) 100%);
             border-radius: 8px;
             padding: 12px;
             border-left: 3px solid var(--primary-color);
             border-top: 1px solid rgba(30, 64, 175, 0.2);
         }
         
         .conflicts-label {
             font-weight: 600;
             font-size: 0.8rem;
         }
         
         .conflict-compact {
             background: rgba(255, 255, 255, 0.9);
             border-radius: 6px;
             padding: 8px 10px;
             margin-bottom: 6px;
             border: 1px solid rgba(30, 64, 175, 0.15);
             transition: all 0.2s ease;
         }

         .conflict-compact:hover {
             background: rgba(255, 255, 255, 1);
             border-color: rgba(255, 193, 7, 0.3);
             transform: translateX(2px);
         }
         
         .conflict-compact:last-child {
             margin-bottom: 0;
         }
         
         .conflict-time-badge {
             font-size: 0.75rem;
             font-weight: 700;
             color: #92400e;
             background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
             padding: 3px 8px;
             border-radius: 12px;
             display: inline-block;
             margin-bottom: 4px;
             border: 1px solid rgba(255, 193, 7, 0.3);
         }
         
         .conflict-title-small {
             font-size: 0.8rem;
             font-weight: 500;
             color: var(--text-dark);
             margin-bottom: 1px;
         }
         
         .conflict-type {
             font-size: 0.7rem;
             color: #6c757d;
             font-style: italic;
         }
         
         /* Available Status Compact */
         .available-compact {
             background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(16, 185, 129, 0.04) 100%);
             border-radius: 8px;
             padding: 12px;
             border-left: 3px solid #10b981;
             border-top: 1px solid rgba(16, 185, 129, 0.2);
         }
        
                 /* Enhanced Member Schedule Cards */
         .member-schedule-card {
             border: 1px solid rgba(30, 64, 175, 0.1);
             border-radius: 12px;
             overflow: hidden;
             transition: all 0.3s ease;
         }
         
         .member-schedule-card:hover {
             border-color: var(--primary-color);
             box-shadow: 0 6px 20px rgba(30, 64, 175, 0.1);
             transform: translateY(-2px);
         }
         
         .member-avatar {
             display: flex;
             align-items: center;
             justify-content: center;
             width: 50px;
             height: 50px;
             background: rgba(30, 64, 175, 0.05);
             border-radius: 50%;
         }
         
         .member-info h6 {
             font-weight: 600;
             color: var(--text-dark);
             margin-bottom: 4px;
         }
         
         .availability-indicator {
             font-size: 1.2rem;
         }
         
         /* Schedule Conflicts */
         .schedule-conflicts {
             background: rgba(255, 193, 7, 0.05);
             border-radius: 8px;
             padding: 12px;
             border-left: 3px solid #ffc107;
         }
         
         .conflicts-header {
             font-weight: 600;
         }
         
         .conflict-item {
             background: rgba(255, 255, 255, 0.7);
             border-radius: 6px;
             padding: 10px;
             margin-bottom: 8px;
             border: 1px solid rgba(255, 193, 7, 0.2);
         }
         
         .conflict-item:last-child {
             margin-bottom: 0;
         }
         
         .conflict-title {
             font-weight: 500;
             color: var(--text-dark);
         }
         
         .conflict-time {
             font-size: 0.75rem;
             padding: 4px 8px;
         }
         
         /* Available Status */
         .available-status {
             background: rgba(40, 167, 69, 0.05);
             border-radius: 8px;
             padding: 12px;
             border-left: 3px solid #28a745;
         }
         
         /* Schedule Header */
         .schedule-header {
             padding: 16px 0;
             border-bottom: 1px solid rgba(30, 64, 175, 0.1);
         }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .time-suggestions-panel {
                padding: 16px;
                max-height: none;
            }
            
            .enhanced-time-slots {
                grid-template-columns: 1fr;
            }
            
            .suggestion-card {
                padding: 12px;
            }
        }
        
        /* Enhanced Modal */
        #meetingModal .modal-content {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
        }

        #meetingModal .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 24px;
            border: none;
        }

        #meetingModal .modal-title {
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
        }

        #meetingModal .modal-footer {
            border: none;
            padding: 20px 24px;
            background: rgba(248, 250, 252, 0.5);
            border-radius: 0 0 20px 20px;
            position: relative !important;
            bottom: auto !important;
            left: auto !important;
            right: auto !important;
            width: auto !important;
        }

        #meetingModal .modal-dialog {
            max-width: 1200px;
            width: 95%;
        }

                 #meetingModal .modal-body {
             max-height: 85vh;
             min-height: 60vh;
             padding: 20px 24px;
             overflow-y: auto;
             overflow-x: hidden;
         }
        
        /* Enhanced Buttons */

        #saveMeetingBtn {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            padding: 12px 24px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        #saveMeetingBtn:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }
        
                 /* Custom Scrollbar Styling for Sections */
         .meeting-details-section::-webkit-scrollbar,
         .recommendations-section::-webkit-scrollbar,
         .team-overview-sidebar::-webkit-scrollbar {
             width: 6px;
         }

         .meeting-details-section::-webkit-scrollbar-track,
         .recommendations-section::-webkit-scrollbar-track,
         .team-overview-sidebar::-webkit-scrollbar-track {
             background: rgba(255, 255, 255, 0.1);
             border-radius: 3px;
         }

         .meeting-details-section::-webkit-scrollbar-thumb {
             background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
             border-radius: 3px;
         }

         .recommendations-section::-webkit-scrollbar-thumb {
             background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
             border-radius: 3px;
         }

         .team-overview-sidebar::-webkit-scrollbar-thumb {
             background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
             border-radius: 3px;
         }

         .meeting-details-section::-webkit-scrollbar-thumb:hover,
         .recommendations-section::-webkit-scrollbar-thumb:hover,
         .team-overview-sidebar::-webkit-scrollbar-thumb:hover {
             opacity: 0.8;
         }

         /* Responsive Enhancements */
         @media (max-width: 992px) {
             .meeting-details-section,
             .team-overview-sidebar {
                 margin-bottom: 20px;
                 min-height: 350px;
                 max-height: calc(75vh - 100px);
             }

             .recommendations-section {
                 margin-bottom: 20px;
                 min-height: 350px;
                 max-height: calc(75vh - 100px);
             }
             
             #memberSchedules {
                 min-height: 350px !important;
                 max-height: calc(75vh - 100px) !important;
             }
             
             #meetingModal .modal-dialog {
                 max-width: 95%;
                 margin: 10px auto;
             }

             #meetingModal .modal-body {
                 max-height: 80vh;
                 min-height: 50vh;
             }
         }

                 @media (max-width: 768px) {
             #meetingModal .modal-dialog {
                 max-width: 98%;
                 width: 98%;
                 margin: 5px auto;
             }

             #meetingModal .modal-body {
                 max-height: 75vh;
                 min-height: 50vh;
                 padding: 15px;
             }

             .meeting-details-section,
             .team-overview-sidebar {
                 min-height: 300px;
                 max-height: calc(70vh - 80px);
                 margin-bottom: 15px;
                 padding: 16px;
             }

             .recommendations-section {
                 min-height: 300px;
                 max-height: calc(70vh - 80px);
                 margin-bottom: 15px;
                 padding: 16px;
             }
             
             #memberSchedules {
                 min-height: 300px !important;
                 max-height: calc(70vh - 80px) !important;
                 margin-bottom: 15px;
                 padding: 16px;
             }
             
             .section-header h6 {
                 font-size: 1rem;
             }
             
             .suggestion-card {
                 padding: 16px;
             }
             
             .suggestion-card .time-display {
                 font-size: 1.1rem;
             }
             
             .member-card {
                 padding: 12px;
             }
             
             .time-slots-grid {
                 grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                 gap: 8px;
             }

             /* Stack sections vertically on mobile */
             .modal-body .row.g-4 > .col-lg-4 {
                 flex: 0 0 100%;
                 max-width: 100%;
             }
         }

         /* ================================
            DARK MODE STYLES FOR MEETING MODAL
         ================================ */
         
         [data-theme="dark"] #meetingModal .modal-content {
             background: linear-gradient(135deg, rgba(17, 24, 39, 0.98) 0%, rgba(31, 41, 55, 0.98) 100%);
             border: 1px solid rgba(75, 85, 99, 0.4);
             box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
         }

         [data-theme="dark"] #meetingModal .modal-header {
             background: linear-gradient(135deg, #111827, #1f2937);
             border-bottom: 1px solid rgba(75, 85, 99, 0.3);
             color: #f9fafb;
         }

         [data-theme="dark"] #meetingModal .modal-footer {
             background: linear-gradient(135deg, rgba(17, 24, 39, 0.95), rgba(31, 41, 55, 0.9));
             border-top: 1px solid rgba(75, 85, 99, 0.3);
             position: relative !important;
             bottom: auto !important;
             left: auto !important;
             right: auto !important;
             width: auto !important;
         }

         [data-theme="dark"] .meeting-details-section {
             background: linear-gradient(135deg, rgba(17, 24, 39, 0.98) 0%, rgba(31, 41, 55, 0.95) 100%);
             border: 1px solid rgba(59, 130, 246, 0.25);
             color: #f3f4f6;
         }

         [data-theme="dark"] .recommendations-section {
             background: linear-gradient(135deg, rgba(17, 24, 39, 0.98) 0%, rgba(31, 41, 55, 0.95) 100%);
             border: 1px solid rgba(34, 197, 94, 0.25);
             color: #f3f4f6;
         }

         [data-theme="dark"] .team-overview-sidebar {
             background: linear-gradient(135deg, rgba(17, 24, 39, 0.98) 0%, rgba(31, 41, 55, 0.95) 100%);
             border: 1px solid rgba(168, 85, 247, 0.25);
             color: #f3f4f6;
         }

         [data-theme="dark"] .section-header {
             border-bottom: 1px solid rgba(75, 85, 99, 0.25);
         }

         [data-theme="dark"] .section-header h6 {
             color: #f9fafb;
         }

         [data-theme="dark"] .section-header h6 i {
             background: rgba(75, 85, 99, 0.3);
             color: #d1d5db;
         }

         [data-theme="dark"] .section-header small {
             color: #9ca3af;
         }

         [data-theme="dark"] .meeting-form-fields .form-label {
             color: #f3f4f6;
         }

         [data-theme="dark"] .meeting-form-fields .form-control,
         [data-theme="dark"] .meeting-form-fields .form-select {
             background: rgba(31, 41, 55, 0.9);
             border: 2px solid rgba(75, 85, 99, 0.4);
             color: #f3f4f6;
         }

         [data-theme="dark"] .meeting-form-fields .form-control:focus,
         [data-theme="dark"] .meeting-form-fields .form-select:focus {
             background: rgba(31, 41, 55, 1);
             border-color: #3b82f6;
             color: #f9fafb;
             box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.2);
         }

         [data-theme="dark"] .suggestion-card {
             background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(55, 65, 81, 0.95) 100%);
             border: 2px solid rgba(75, 85, 99, 0.4);
             color: #f3f4f6;
         }

         [data-theme="dark"] .suggestion-card:hover {
             background: linear-gradient(135deg, rgba(31, 41, 55, 1) 0%, rgba(59, 130, 246, 0.08) 100%);
             border-color: #3b82f6;
             box-shadow: 0 8px 32px rgba(59, 130, 246, 0.15);
         }

         [data-theme="dark"] .suggestion-card.border-primary {
             border-color: #3b82f6 !important;
             background: linear-gradient(135deg, rgba(59, 130, 246, 0.12) 0%, rgba(59, 130, 246, 0.06) 100%) !important;
             box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
         }

         [data-theme="dark"] .member-card {
             background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(55, 65, 81, 0.95) 100%);
             border: 1px solid rgba(75, 85, 99, 0.3);
             color: #f3f4f6;
         }

         [data-theme="dark"] .member-card:hover {
             border-color: #3b82f6;
             background: linear-gradient(135deg, rgba(31, 41, 55, 1) 0%, rgba(59, 130, 246, 0.06) 100%);
             box-shadow: 0 4px 16px rgba(59, 130, 246, 0.1);
         }

         [data-theme="dark"] .member-avatar-small {
             background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(168, 85, 247, 0.15));
             border: 2px solid rgba(75, 85, 99, 0.4);
             color: #d1d5db;
         }

         [data-theme="dark"] .member-name {
             color: #f9fafb;
         }

         [data-theme="dark"] .conflicts-compact {
             background: linear-gradient(135deg, rgba(15, 11, 245, 0.14) 0%, rgba(11, 46, 245, 0.08) 100%);
             border-left: 3px solidrgb(11, 34, 245);
             border-top: 1px solid rgba(245, 158, 11, 0.3);
         }

         [data-theme="dark"] .conflict-compact {
             background: rgba(30, 41, 59, 0.9);
             border: 1px solid rgba(27, 11, 245, 0.3);
             color: #e2e8f0;
         }

         [data-theme="dark"] .conflict-compact:hover {
             background: rgba(30, 41, 59, 1);
             border-color: rgba(27, 11, 245, 0.5);
         }

         [data-theme="dark"] .conflict-time-badge {
             background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2));
             color: #fbbf24;
             border: 1px solid rgba(245, 158, 11, 0.5);
         }

         [data-theme="dark"] .conflict-title-small {
             color: #e2e8f0;
         }

         [data-theme="dark"] .conflict-type {
             color: #94a3b8;
         }

         [data-theme="dark"] .available-compact {
             background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.08) 100%);
             border-left: 3px solid #10b981;
             border-top: 1px solid rgba(16, 185, 129, 0.3);
             color: #e2e8f0;
         }

         [data-theme="dark"] .availability-status.alert-success {
             background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
             color: #6ee7b7;
             border-left: 4px solid #10b981;
         }

         [data-theme="dark"] .availability-status.alert-warning {
             background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.1) 100%);
             color: #fbbf24;
             border-left: 4px solid #f59e0b;
         }

         [data-theme="dark"] .availability-status.alert-info {
             background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.1) 100%);
             color: #93c5fd;
             border-left: 4px solid #3b82f6;
         }

         [data-theme="dark"] .availability-status.alert-danger {
             background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.1) 100%);
             color: #fca5a5;
             border-left: 4px solid #ef4444;
         }

         [data-theme="dark"] .custom-calendar {
             background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(55, 65, 81, 0.95) 100%);
             border: 2px solid rgba(75, 85, 99, 0.4);
             color: #f3f4f6;
         }

         [data-theme="dark"] .calendar-header {
             border-bottom: 1px solid rgba(75, 85, 99, 0.3);
         }

         [data-theme="dark"] .calendar-nav-btn {
             background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.08));
             border: 1px solid rgba(59, 130, 246, 0.4);
             color: #3b82f6;
         }

         [data-theme="dark"] .calendar-nav-btn:hover {
             background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(59, 130, 246, 0.15));
             box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
         }

         [data-theme="dark"] .calendar-day {
             color: #f3f4f6;
         }

         [data-theme="dark"] .calendar-day:hover {
             background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.08));
         }

         [data-theme="dark"] .calendar-day.selected {
             background: linear-gradient(135deg, #3b82f6, #2563eb);
             color: white;
             box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
         }

         [data-theme="dark"] .calendar-day.today {
             background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.12));
             border: 2px solid rgba(59, 130, 246, 0.5);
             color: #f9fafb;
         }

         [data-theme="dark"] .calendar-day.disabled {
             color: #6b7280;
         }

         [data-theme="dark"] .calendar-day.other-month {
             color: #6b7280;
         }



         [data-theme="dark"] #saveMeetingBtn {
             background: linear-gradient(135deg, #22c55e, #16a34a);
             border: 1px solid rgba(34, 197, 94, 0.3);
             box-shadow: 0 4px 16px rgba(34, 197, 94, 0.2);
         }

         [data-theme="dark"] #saveMeetingBtn:hover {
             background: linear-gradient(135deg, #16a34a, #15803d);
             box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
             transform: translateY(-1px);
         }

         [data-theme="dark"] .loading-state {
             background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(55, 65, 81, 0.9) 100%);
             border: 2px dashed rgba(75, 85, 99, 0.5);
             color: #f3f4f6;
         }

         [data-theme="dark"] .empty-state {
             background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(55, 65, 81, 0.9) 100%);
             border: 2px dashed rgba(75, 85, 99, 0.4);
             color: #f3f4f6;
         }

         [data-theme="dark"] .empty-icon i {
             color: #9ca3af;
         }
         
         /* Dark mode styles for inline availability status */
         [data-theme="dark"] .availability-status-inline {
             background: rgba(75, 85, 99, 0.1);
             border-left-color: #9ca3af;
             color: #9ca3af;
         }
         
         [data-theme="dark"] .availability-status-inline.alert-success {
             background: rgba(34, 197, 94, 0.1);
             border-left-color: #22c55e;
             color: #22c55e;
         }
         
         [data-theme="dark"] .availability-status-inline.alert-warning {
             background: rgba(251, 191, 36, 0.1);
             border-left-color: #fbbf24;
             color: #fbbf24;
         }
         
         [data-theme="dark"] .availability-status-inline.alert-danger {
             background: rgba(239, 68, 68, 0.1);
             border-left-color: #ef4444;
             color: #ef4444;
         }
         
         [data-theme="dark"] .availability-status-inline.alert-info {
             background: rgba(59, 130, 246, 0.1);
             border-left-color: #3b82f6;
             color: #3b82f6;
         }

         /* Scrollbar styles for dark mode */
         [data-theme="dark"] .meeting-details-section::-webkit-scrollbar-track,
         [data-theme="dark"] .recommendations-section::-webkit-scrollbar-track,
         [data-theme="dark"] .team-overview-sidebar::-webkit-scrollbar-track {
             background: rgba(31, 41, 55, 0.6);
         }

         [data-theme="dark"] .meeting-details-section::-webkit-scrollbar-thumb {
             background: linear-gradient(180deg, #3b82f6, #2563eb);
             border-radius: 6px;
             border: 2px solid rgba(31, 41, 55, 0.6);
         }

         [data-theme="dark"] .recommendations-section::-webkit-scrollbar-thumb {
             background: linear-gradient(180deg, #22c55e, #16a34a);
             border-radius: 6px;
             border: 2px solid rgba(31, 41, 55, 0.6);
         }

         [data-theme="dark"] .team-overview-sidebar::-webkit-scrollbar-thumb {
             background: linear-gradient(180deg, #a855f7, #9333ea);
             border-radius: 6px;
             border: 2px solid rgba(31, 41, 55, 0.6);
         }

         [data-theme="dark"] .meeting-details-section::-webkit-scrollbar-thumb:hover,
         [data-theme="dark"] .recommendations-section::-webkit-scrollbar-thumb:hover,
         [data-theme="dark"] .team-overview-sidebar::-webkit-scrollbar-thumb:hover {
             background-opacity: 0.8;
         }
        
        .time-suggestion-card .time-display {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .time-suggestion-card .availability-info {
            color: #6c757d;
        }
        
        .time-suggestion-card .conflicts {
            border-top: 1px solid rgba(255, 193, 7, 0.3);
            padding-top: 0.5rem;
        }
        
        /* Suggested Times Section */
        #suggestedTimes {
            background: rgba(30, 41, 59, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid rgba(30, 64, 175, 0.1);
        }
        
        #suggestedTimes h6 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        
        /* Auto Suggest Button */
        #autoSuggestBtn {
            background: linear-gradient(45deg, #20c997, #198754);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        #autoSuggestBtn:hover {
            background: linear-gradient(45deg, #198754, #20c997);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(32, 201, 151, 0.3);
        }
        
        /* Futuristic glowing elements */
        .glow-effect {
            position: relative;
            overflow: hidden;
            margin-top: 0;
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
        
        /* Milestone Status Dropdown for Supervisors */
        .milestone-status-dropdown {
            background: rgba(14, 24, 39, 0) !important;
            border: 1px solid rgba(255, 255, 255, 0) !important;
            color: var(--text-primary) !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border-radius: 8px !important;
            padding: 2px 6px !important;
            min-height: unset !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease !important;
            cursor: pointer;
        }
        
        .milestone-status-dropdown:focus {
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0) !important;
            border-color: var(--primary-color) !important;
            outline: none !important;
        }
        
        .milestone-status-dropdown:hover {
            border-color: rgba(255, 255, 255, 0) !important;
        }
        
        .milestone-status-dropdown option {
            background: rgba(30, 41, 59, 0.45) !important;
            color: var(--text-primary) !important;
            padding: 4px 8px !important;
        }
        
        /* Remove focus effects from timeline cards */
        .timeline-milestone:focus {
            outline: none !important;
            box-shadow: none !important;
            filter: none !important;
            backdrop-filter: none !important;
        }
        
        .timeline-milestone:focus-visible {
            outline: none !important;
            box-shadow: none !important;
            filter: none !important;
            backdrop-filter: none !important;
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
            color: var(--primary-color);
            border: 1px solid rgba(30, 64, 175, 0.2);
        }
        
        .assigned-to-badge {
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.15), rgba(5, 150, 105, 0.1));
            color: var(--success-color);
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
            margin-left: auto !important;
            flex-shrink: 0 !important;
            justify-content: flex-start !important;
            min-width: 90px !important;
        }
        
        .download-btn:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.5) !important;
            color: #ffffff !important;
        }
        
        .download-btn i {
            font-size: 0.8rem !important;
            color: #ffffff !important;
            margin-right: 0 !important;
        }
        
        .download-btn .btn-text {
            font-size: 0.75rem !important;
            color: #ffffff !important;
            text-align: left !important;
        }
        
        .file-info {
            flex: 0 1 auto;
            margin-right: auto;
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
            color: var(--primary-color);
            border: 1px solid rgba(30, 64, 175, 0.2);
        }
        
        [data-theme="light"] .assigned-to-badge {
            background-color: rgba(16, 185, 129, 0.1);
            color: #059669;
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
            background: #07880030;
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

        /* Bootstrap bg-info override for consistent minimal design */
        .bg-info {
            --bs-bg-opacity: 1;
            background-color: rgba(30, 64, 175, 0.1) !important;
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
            align-items: flex-start !important;
            gap: 8px !important;
            padding: 16px !important;
            background: rgba(65, 89, 128, 0) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            margin-bottom: 12px !important;
        }
        
        /* File info and download button container */
        .file-item-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 8px !important;
            width: 100% !important;
        }
        
        /* File info section */
        .file-info {
            width: 100% !important;
        }
        
        /* Download button positioning */
        .download-btn {
            align-self: flex-start !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: var(--spacing-xs) !important;
            min-width: 90px !important;
            padding: 6px 12px !important;
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
        
        /* Download button positioning */
        .download-btn {
            margin-left: auto !important;
            flex-shrink: 0 !important;
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
            margin-top: 0 !important;
        }
        
        /* Last section should have additional bottom spacing */
        .col-lg-4 .card.mb-4:last-child {
            margin-bottom: var(--spacing-2xl) !important;
        }
        
        /* Override specifically for Project Information card */
        .col-lg-4 .metadata-card.mb-4.mt-0 {
            margin-top: 0 !important;
            padding-top: var(--spacing-lg);
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
            color: var(--muted-color) !important;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: all var(--transition-speed) var(--transition-ease);
            padding: 2px 4px;
            border-radius: 4px;
            background: linear-gradient(135deg, transparent 0%, rgba(30, 64, 175, 0.05) 100%);
        }
        
        .supervisor-link:hover {
            color: var(--muted-color) !important;
            text-decoration: none;
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(30, 64, 175, 0.15) 100%);
            box-shadow: 0 2px 8px rgba(30, 64, 175, 0.2);
            transform: translateY(-1px);
        }
        
        
        /* Member link styling for consistency */
        .member-link {
            color: #00b5bf !important;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: all var(--transition-speed) var(--transition-ease);
            padding: 2px 4px;
            border-radius: 4px;
            background: linear-gradient(135deg, transparent 0%, rgba(2, 132, 199, 0.05) 100%);
        }
        
        .member-link:hover {
            color: #00b5bf !important;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.2);
            transform: translateY(-1px);
        }
    </style>
    
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    
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
        <div id="loading-spinner">
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
                            <button id="editTimelineBtn" class="btn btn-outline-primary btn-sm" title="Edit Timeline">
                                <i class="bi bi-pencil-square me-1"></i>Edit Timeline
                            </button>
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
                <div class="col-lg-4" style="padding-top: 0;">
                    <div class="metadata-card mb-4 mt-0" style="margin-top: 0 !important;" data-aos="fade-left" data-aos-delay="100">
                        <h4 class="mb-3">Project Information</h4>
                        <div id="project-info">
                            <!-- Project info will be loaded here -->
                        </div>
                    </div>
                    
                    <!-- Project Meetings Section -->
                    <div class="card mb-4" data-aos="fade-left" data-aos-delay="150" id="project-meetings-section">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white">
                                <i class="bi bi-calendar-event me-2"></i>Project Meetings
                            </h5>
                            <button id="addMeetingBtn" class="btn btn-sm btn-primary" title="Schedule Meeting">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                        </div>
                        <div class="card-body" id="meetings-container" style="max-height: 300px; overflow-y: auto;">
                            <div id="meetings-loading" style="display: none;">
                                <div class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 mb-0 text-muted small">Loading meetings...</p>
                                </div>
                            </div>
                            <div id="meetings-list">
                                <!-- Meetings will be loaded here -->
                            </div>
                            <div id="no-meetings" class="text-center py-4">
                                <i class="bi bi-calendar-x text-primary" style="font-size: 2rem;"></i>
                                <p class="text-primary mt-2 mb-0">No meetings scheduled yet</p>
                                <small class="text-primary">Click the + button to schedule a meeting</small>
                            </div>
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

    <!-- Include Timeline Editor Overlay -->
    <?php include 'timeline_editor_overlay.php'; ?>
    
    <!-- Meeting Creation Modal -->
    <div class="modal fade" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meetingModalLabel">
                        <i class="bi bi-calendar-plus me-2"></i>Schedule Meeting
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Meeting Form -->
                    <form id="meetingForm">
                        <!-- Loading indicator for suggestions -->
                        <div id="timeSuggestionsLoading" class="loading-state" style="display: none;">
                            <div class="d-flex align-items-center justify-content-center py-4">
                                <div class="spinner-border spinner-border-sm text-primary me-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div>
                                    <p class="mb-1 fw-medium">Analyzing Team Schedules</p>
                                    <small class="text-muted">Finding optimal meeting times...</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- No Date Selected Message -->
                        <div id="noDateSelected" class="empty-state">
                            <div class="text-center py-4">
                                <div class="empty-icon mb-3">
                                    <i class="bi bi-calendar-date text-muted"></i>
                                </div>
                                <h6 class="text-muted mb-2">Select a Date First</h6>
                                <p class="text-muted small mb-0">Choose a meeting date from the calendar to see available time slots</p>
                            </div>
                        </div>
                        
                        <!-- Three Column Layout -->
                        <div class="row g-4">
                            <!-- Left Column: Meeting Details & Calendar -->
                                        <div class="col-lg-4">
                                            <div class="meeting-details-section">
                                                <div class="section-header mb-3">
                                                    <h6 class="text-primary mb-1">
                                                        <i class="bi bi-calendar3 me-2"></i>Meeting Details
                                </h6>
                                                    <small class="text-muted">Set up your team meeting</small>
                                                </div>
                                
                                                <!-- Meeting Form Fields -->
                                                <div class="meeting-form-fields">
                                <div class="mb-3">
                                                        <label for="meetingTitle" class="form-label fw-medium">Meeting Title</label>
                                                        <input type="text" class="form-control" id="meetingTitle" placeholder="Enter meeting title">
                                </div>
                                
                                <div class="mb-3">
                                                        <label for="meetingDescription" class="form-label fw-medium">Description</label>
                                                        <textarea class="form-control" id="meetingDescription" rows="3" placeholder="Meeting agenda or description"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                                        <label for="meetingLink" class="form-label fw-medium">Meeting Link</label>
                                                        <input type="url" class="form-control" id="meetingLink" placeholder="Zoom, Google Meet, etc.">
                                                        <div class="mt-2">
                                                            <button type="button" id="createGoogleMeetBtn" class="btn btn-outline-primary btn-sm w-100">
                                                                <i class="bi bi-camera-video me-2"></i>Create Google Meet Link
                                                            </button>
                                                            <button type="button" id="testMeetingBtn" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                                                <i class="bi bi-play-circle me-2"></i>Test Meeting (Current Time)
                                                            </button>
                                                        </div>
                                </div>
                                
                                <!-- Manual Time Selection for Testing -->
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-warning">
                                        <i class="bi bi-tools me-2"></i>Manual Time Selection (Testing)
                                    </label>
                                    <div class="border border-warning rounded p-3" style="background-color: #fff8e1;">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label for="manualStartTime" class="form-label">Start Time</label>
                                                <input type="time" class="form-control form-control-sm" id="manualStartTime">
                                            </div>
                                            <div class="col-6">
                                                <label for="manualEndTime" class="form-label">End Time</label>
                                                <input type="time" class="form-control form-control-sm" id="manualEndTime">
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-warning btn-sm w-100" onclick="setManualTime()">
                                                <i class="bi bi-clock me-2"></i>Set Manual Time
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="bi bi-info-circle me-1"></i>
                                            For testing: Bypass suggestions and set exact time
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                                        <label for="meetingDate" class="form-label fw-medium">Select Date</label>
                                                        <input type="date" class="form-control" id="meetingDate">
                                                    </div>
                                                    
                                                    <!-- Calendar Widget -->
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium">Calendar View</label>
                                    <div id="meetingCalendar" class="custom-calendar">
                                        <!-- Calendar will be rendered here -->
                                    </div>
                                                    </div>
                                                </div>
                                </div>
                            </div>
                            
                                        <!-- Middle Column: Time Suggestions -->
                                        <div class="col-lg-4">
                                            <div id="timeSuggestionsContainer" class="suggestions-container" style="display: none;">
                                                <div class="recommendations-section">
                                                    <div class="section-header mb-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="text-success mb-0">
                                                                <i class="bi bi-lightbulb-fill me-2"></i>Time Suggestions
                                                            </h6>
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="refreshTimeSuggestions()" title="Recalculate suggestions">
                                                                <i class="bi bi-arrow-clockwise"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <!-- Time Filter Buttons -->
                                                        <div class="mb-2">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Time filter">
                                                                <button type="button" class="btn btn-outline-secondary active" id="filterAll" onclick="filterSuggestions('all')">
                                                                    All
                                                                </button>
                                                                <button type="button" class="btn btn-outline-secondary" id="filterAM" onclick="filterSuggestions('am')">
                                                                    AM
                                                                </button>
                                                                <button type="button" class="btn btn-outline-secondary" id="filterPM" onclick="filterSuggestions('pm')">
                                                                    PM
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                        <small class="text-muted">When everyone is free</small>
                                                        
                                                        <!-- Availability Status moved below heading -->
                                                <div id="availabilityResults" class="availability-status-inline mb-2" style="display: none;">
                                                    <!-- Availability results will be shown here -->
                                                </div>
                                </div>
                                
                                                    <!-- Time Slots Grid -->
                                                    <div id="timeSlots" class="enhanced-time-slots">
                                                        <!-- Suggested time slots will be shown here -->
                                    </div>
                                </div>
                                </div>
                            </div>
                                
                            <!-- Right Column: Team Availability Overview -->
                            <div class="col-lg-4">
                                <div id="memberSchedules" class="team-overview-sidebar" style="display: none;">
                                    <!-- Member schedules will be shown here -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden fields for selected time -->
                        <input type="hidden" id="meetingStartTime">
                        <input type="hidden" id="meetingEndTime">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="saveMeetingBtn" class="btn btn-primary">
                        <i class="bi bi-calendar-check me-1"></i>Schedule Meeting
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="assets/js/timeline_debug.js"></script>
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
        
        // Handle edit timeline button click
        document.getElementById('editTimelineBtn').addEventListener('click', function() {
            // Open the timeline editor modal
            const timelineEditorModal = new bootstrap.Modal(document.getElementById('timelineEditorModal'));
            timelineEditorModal.show();
        });

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
                    
                    // Store project data globally for timeline editor
                    window.currentProject = project;
                    
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
                        
                        // Show Edit Timeline button only for project owners or admins
                        const editTimelineBtn = document.getElementById('editTimelineBtn');
                        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
                        const loggedInUserId = <?php echo isset($_SESSION['user_id']) ? "'" . $_SESSION['user_id'] . "'" : 'null'; ?>;
                        
                        // Check if the current user created this project or is a member
                        let canEditTimeline = false;
                        
                        if (isLoggedIn) {
                            // Project creator check
                            if (project.createdBy && (
                                (project.createdBy.$oid && project.createdBy.$oid === loggedInUserId) || 
                                project.createdBy === loggedInUserId
                            )) {
                                canEditTimeline = true;
                            }
                            
                            // Project member check (supervisor or team member)
                            if (!canEditTimeline && project.members && Array.isArray(project.members)) {
                                canEditTimeline = project.members.some(member => 
                                    member.userId && (
                                        (member.userId.$oid && member.userId.$oid === loggedInUserId) || 
                                        member.userId === loggedInUserId
                                    )
                                );
                            }
                            
                            // Supervisor check
                            if (!canEditTimeline && project.supervisor && project.supervisor.userId) {
                                if ((project.supervisor.userId.$oid && project.supervisor.userId.$oid === loggedInUserId) ||
                                    project.supervisor.userId === loggedInUserId) {
                                    canEditTimeline = true;
                                }
                            }
                        }
                        
                        editTimelineBtn.style.display = canEditTimeline ? 'inline-flex' : 'none';
                        
                        // Control visibility of Project Meetings section based on the same edit access
                        const projectMeetingsSection = document.getElementById('project-meetings-section');
                        if (projectMeetingsSection) {
                            projectMeetingsSection.style.display = canEditTimeline ? 'block' : 'none';
                        }
                        
                        // Show milestone status dropdowns for supervisors (with slight delay to ensure DOM is ready)
                        setTimeout(() => {
                            checkSupervisorAccess(project, loggedInUserId);
                        }, 100);
                        
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
                            <button id="literatureMatrixBtn" class="btn btn-outline-primary me-2" data-project-id="${project._id.$oid}">
                                <i class="bi bi-journal-text"></i> Literature Matrix
                            </button>
                            <button id="paperBtn" class="btn btn-outline-success me-2" data-project-id="${project._id.$oid}">
                                <i class="bi bi-file-earmark-text"></i> Paper
                            </button>
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
            
            // Add ripple effect to the timeline edit button
            const timelineEditBtn = document.getElementById('editTimelineBtn');
            if (timelineEditBtn) {
                timelineEditBtn.addEventListener('mousedown', createRipple);
            }
            
            // Update page title
            document.title = `${project.title} | UIU Research Platform`;
            
            // Add animation for the title to make it stand out
            animateProjectTitle();
            
            // Add event listeners for Literature Matrix button
            const litMatrixButton = document.getElementById('literatureMatrixBtn');
            if (litMatrixButton) {
                litMatrixButton.addEventListener('click', function() {
                    const projectId = this.getAttribute('data-project-id');
                    window.location.href = `literature_matrix.php?id=${projectId}`;
                });
                litMatrixButton.addEventListener('mousedown', createRipple);
            }

            // Add event listeners for Paper button
            const paperButton = document.getElementById('paperBtn');
            if (paperButton) {
                paperButton.addEventListener('click', async function() {
                    const projectId = this.getAttribute('data-project-id');
                    try {
                        const response = await fetch('src/model/create_etherpad.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                projectId: projectId
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            // Create modal for Etherpad
                            const modalHtml = `
                                <div class="modal fade" id="etherpadModal" tabindex="-1" aria-labelledby="etherpadModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="etherpadModalLabel">Collaborative Paper Writing</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <iframe src="${data.embedUrl}" style="width: 100%; height: 80vh; border: none;"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            // Add modal to body if it doesn't exist
                            if (!document.getElementById('etherpadModal')) {
                                document.body.insertAdjacentHTML('beforeend', modalHtml);
                            }
                            
                            // Show the modal
                            const modal = new bootstrap.Modal(document.getElementById('etherpadModal'));
                            modal.show();
                        } else {
                            throw new Error(data.message || 'Failed to create paper pad');
                        }
                    } catch (error) {
                        console.error('Error opening paper pad:', error);
                        alert('Failed to open paper pad. Please try again.');
                    }
                });
                paperButton.addEventListener('mousedown', createRipple);
            }
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
                    <li class="list-group-item">
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
                                <div class="milestone-status" data-milestone-index="${index}">
                                    <i class="bi ${statusIcon}"></i>
                                    <span class="status-display">${statusText}</span>
                                    <select class="milestone-status-dropdown form-select form-select-sm" style="display: none;" data-milestone-index="${index}">
                                        <option value="planned" ${statusClass === 'pending' || item.status?.toLowerCase().includes('planned') ? 'selected' : ''}>Planned</option>
                                        <option value="in-progress" ${statusClass === 'in-progress' || item.status?.toLowerCase().includes('progress') ? 'selected' : ''}>In Progress</option>
                                        <option value="completed" ${statusClass === 'completed' || item.status?.toLowerCase().includes('completed') ? 'selected' : ''}>Completed</option>
                                        <option value="delayed" ${statusClass === 'delayed' || item.status?.toLowerCase().includes('delayed') ? 'selected' : ''}>Delayed</option>
                                    </select>
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
        
        // Function to check supervisor access and enable milestone status editing
        function checkSupervisorAccess(project, loggedInUserId) {
            if (!loggedInUserId || !project) return;
            
            let isSupervisor = false;
            
            // Check if current user is the supervisor
            if (project.supervisor && project.supervisor.userId) {
                if ((project.supervisor.userId.$oid && project.supervisor.userId.$oid === loggedInUserId) ||
                    project.supervisor.userId === loggedInUserId) {
                    isSupervisor = true;
                }
            }
            
            // If user is supervisor, show dropdowns and hide status text
            if (isSupervisor) {
                const statusDisplays = document.querySelectorAll('.milestone-status .status-display');
                const statusDropdowns = document.querySelectorAll('.milestone-status-dropdown');
                
                statusDisplays.forEach(display => {
                    display.style.display = 'none';
                });
                
                statusDropdowns.forEach(dropdown => {
                    dropdown.style.display = 'inline-block';
                    
                    // Add change event listener
                    dropdown.addEventListener('change', function() {
                        const milestoneIndex = this.getAttribute('data-milestone-index');
                        const newStatus = this.value;
                        updateMilestoneStatus(milestoneIndex, newStatus);
                    });
                });
                
                // Store supervisor status globally for other functions
                window.currentUserIsSupervisor = true;
            }
        }
        
        // Function to update milestone status
        function updateMilestoneStatus(milestoneIndex, newStatus) {
            if (!currentProject || !currentProject._id) {
                console.error('No current project available');
                return;
            }
            
            // Show loading state
            const dropdown = document.querySelector(`[data-milestone-index="${milestoneIndex}"]`);
            if (dropdown) {
                dropdown.disabled = true;
            }
            
            // Update the milestone status in current project data
            if (currentProject.timeline && currentProject.timeline[milestoneIndex]) {
                currentProject.timeline[milestoneIndex].status = newStatus;
            }
            
            // Prepare FormData like timeline_editor_overlay.php does
            const data = new FormData();
            data.append('project_id', currentProject._id.$oid || currentProject._id);
            data.append('timeline', JSON.stringify(currentProject.timeline));
            data.append('action', 'update_timeline'); // Same action as timeline editor
            
            console.log('Sending milestone status update via timeline update');
            console.log('Request data:', {
                project_id: currentProject._id.$oid || currentProject._id,
                action: 'update_timeline',
                milestone_index: milestoneIndex,
                new_status: newStatus
            });
            
            // Determine correct path to update_project.php (same logic as timeline editor)
            let basePath = '';
            if (window.location.pathname.includes('/Project_details.php')) {
                basePath = 'src/model/update_project.php';
            } else {
                const pathParts = window.location.pathname.split('/');
                if (pathParts.length > 2) {
                    basePath = '../src/model/update_project.php';
                } else {
                    basePath = 'src/model/update_project.php';
                }
            }
            
            console.log('Using path for update_project.php:', basePath);
            
            // Send to server using same method as timeline editor
            fetch(basePath, {
                method: 'POST',
                body: data
            })
            .then(response => {
                console.log('Response received:', response.status);
                if (!response.ok) {
                    throw new Error(`Server responded with status ${response.status}`);
                }
                return response.json();
            })
            .then(result => {
                console.log('Response data:', result);
                
                if (result.success) {
                    // Fetch current user info and send system message like timeline editor does
                    fetch('src/model/get_current_user.php')
                    .then(response => response.json())
                    .then(userData => {
                        // Get user name from response or use fallback
                        let currentUserName = 'Someone';
                        if (userData && userData.success && userData.isLoggedIn && userData.user) {
                            currentUserName = userData.user.name || 'Someone';
                        }
                        
                        // Send system message based on assigned person and status
                        const milestone = currentProject.timeline[milestoneIndex];
                        const milestoneTitle = milestone?.title || 'a milestone';
                        

                        
                        // Get assigned person(s) for personalized message
                        let assignedPersonName = null;
                        
                        // Check if there are assigned people (assignedTo takes priority over assignedBy)
                        if (milestone?.assignedTo && Array.isArray(milestone.assignedTo) && milestone.assignedTo.length > 0) {
                            // Get first assigned person's name for the message
                            const firstAssignee = milestone.assignedTo[0];
                            if (typeof firstAssignee === 'object' && firstAssignee.name) {
                                assignedPersonName = firstAssignee.name;
                            } else if (typeof firstAssignee === 'string') {
                                // Try to find member by ID or use the string directly
                                const member = findMemberById(firstAssignee, currentProject);
                                assignedPersonName = member ? member.name : firstAssignee;
                            }
                            
                            // Handle multiple assignees
                            if (milestone.assignedTo.length > 1) {
                                assignedPersonName += " and " + (milestone.assignedTo.length - 1) + " other" + (milestone.assignedTo.length > 2 ? "s" : "");
                            }
                        } else if (milestone?.assignedBy) {
                            // Fall back to assignedBy if no assignedTo
                            if (typeof milestone.assignedBy === 'object' && milestone.assignedBy.name) {
                                assignedPersonName = milestone.assignedBy.name;
                            } else if (typeof milestone.assignedBy === 'string') {
                                const member = findMemberById(milestone.assignedBy, currentProject);
                                assignedPersonName = member ? member.name : milestone.assignedBy;
                            }
                        }
                        
                        // Create status-specific message
                        let systemMessage = '';
                        
                        if (assignedPersonName) {
                            switch (newStatus.toLowerCase()) {
                                case 'completed':
                                    systemMessage = `🎉 ${assignedPersonName} completed "${milestoneTitle}"!`;
                                    break;
                                case 'in-progress':
                                    // Handle grammar for multiple assignees
                                    const isPlural = assignedPersonName.includes(' and ') || assignedPersonName.includes(' others');
                                    systemMessage = `⚡ ${assignedPersonName} ${isPlural ? 'are' : 'is'} working on "${milestoneTitle}".`;
                                    break;
                                case 'delayed':
                                    systemMessage = `⏰ ${assignedPersonName} needs more time for "${milestoneTitle}".`;
                                    break;
                                case 'planned':
                                    systemMessage = `📋 "${milestoneTitle}" has been planned for ${assignedPersonName}.`;
                                    break;
                                default:
                                    systemMessage = `📝 ${assignedPersonName} updated "${milestoneTitle}" status to ${newStatus.charAt(0).toUpperCase() + newStatus.slice(1).replace('-', ' ')}.`;
                            }
                        } else {
                            // Fallback to original format if no assigned person
                            const statusDisplay = newStatus.charAt(0).toUpperCase() + newStatus.slice(1).replace('-', ' ');
                            systemMessage = `${currentUserName} updated milestone "${milestoneTitle}" status to ${statusDisplay}.`;
                        }
                        
                        const systemMessageData = new FormData();
                        systemMessageData.append('projectId', currentProject._id.$oid || currentProject._id);
                        systemMessageData.append('message', systemMessage);
                        
                        // Send the system message
                        return fetch('src/model/send_system_chat_message.php', {
                            method: 'POST',
                            body: systemMessageData
                        });
                    })
                    .then(response => response.json())
                    .then(msgResult => {
                        console.log('System message result:', msgResult);
                    })
                    .catch(error => {
                        console.error('Error sending system message:', error);
                    });
                    
                    // Re-render timeline to reflect changes
                    renderTimeline(currentProject);
                    
                    // Re-enable supervisor access after timeline re-render
                    setTimeout(() => {
                        const loggedInUserId = <?php echo isset($_SESSION['user_id']) ? "'" . $_SESSION['user_id'] . "'" : 'null'; ?>;
                        checkSupervisorAccess(currentProject, loggedInUserId);
                    }, 100);
                    
                    // Show success message
                    showStatusUpdateMessage('Milestone status updated successfully!', 'success');
                } else {
                    console.error('Error updating milestone status:', result.message);
                    showStatusUpdateMessage('Failed to update milestone status: ' + (result.message || 'Unknown error'), 'error');
                    
                    // Revert the change in local data
                    const originalStatus = getCurrentStatusFromTimeline(milestoneIndex);
                    if (currentProject.timeline && currentProject.timeline[milestoneIndex]) {
                        currentProject.timeline[milestoneIndex].status = originalStatus;
                    }
                    
                    // Revert dropdown value
                    if (dropdown) {
                        dropdown.value = originalStatus;
                    }
                }
            })
            .catch(error => {
                console.error('Error updating milestone status:', error);
                
                // Revert the change in local data
                const originalStatus = getCurrentStatusFromTimeline(milestoneIndex);
                if (currentProject.timeline && currentProject.timeline[milestoneIndex]) {
                    currentProject.timeline[milestoneIndex].status = originalStatus;
                }
                
                let errorMessage = 'An error occurred while updating the milestone status';
                if (error.message) {
                    errorMessage += ': ' + error.message;
                }
                
                showStatusUpdateMessage(errorMessage, 'error');
                
                // Revert dropdown value
                if (dropdown) {
                    dropdown.value = originalStatus;
                }
            })
            .finally(() => {
                // Re-enable dropdown
                if (dropdown) {
                    dropdown.disabled = false;
                }
            });
        }
        
        // Helper function to get current status from timeline
        function getCurrentStatusFromTimeline(milestoneIndex) {
            if (currentProject && currentProject.timeline && currentProject.timeline[milestoneIndex]) {
                const status = currentProject.timeline[milestoneIndex].status || 'planned';
                return status.toLowerCase().replace(/\s+/g, '-');
            }
            return 'planned';
        }
        
        // Function to show status update messages
        function showStatusUpdateMessage(message, type) {
            // Create or update notification element
            let notification = document.getElementById('milestone-status-notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'milestone-status-notification';
                notification.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 12px 20px;
                    border-radius: 8px;
                    color: white;
                    font-weight: 500;
                    z-index: 10000;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                `;
                document.body.appendChild(notification);
            }
            
            // Set message and style based on type
            notification.textContent = message;
            notification.className = type === 'success' ? 'alert-success' : 'alert-danger';
            notification.style.backgroundColor = type === 'success' ? '#059669' : '#dc2626';
            
            // Show notification
            notification.style.opacity = '1';
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
            }, 3000);
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
                    transform: translateY(-10px) !important;
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
    
    // Meeting functionality
    let memberScheduleData = [];
    
    // Global calendar functions (needed for onclick handlers)
    window.navigateCalendar = function(direction) {
        currentCalendarDate.setMonth(currentCalendarDate.getMonth() + direction);
        renderCalendar();
    };
    
    window.selectDate = function(dateString) {
        selectedDate = dateString;
        document.getElementById('meetingDate').value = dateString;
        renderCalendar(); // Re-render to show selection
        
        // Hide no date selected message and trigger time suggestions
        document.getElementById('noDateSelected').style.display = 'none';
        onDateChange();
    };
    
    // Initialize meeting functionality
    function initializeMeetingFeature() {
        console.log("Initializing meeting feature, checking access");
        
        // The section visibility is already controlled by the edit access check
        // We only need to add event listeners if the section is visible
        const projectMeetingsSection = document.getElementById('project-meetings-section');
        if (projectMeetingsSection && projectMeetingsSection.style.display !== 'none') {
            // Add event listeners
            document.getElementById('addMeetingBtn').addEventListener('click', openMeetingModal);
            document.getElementById('saveMeetingBtn').addEventListener('click', saveMeeting);
            
            // Load existing meetings
            loadProjectMeetings();
        }
        
        /* 
        // The code below was causing issues - we'll implement proper access later
        // For now always show meetings section to avoid disrupting functionality
        
        // Check if user has edit access to the project
        let hasEditAccess = false;
        
        try {
            console.log("Checking edit access, currentUserId:", currentUserId);
            console.log("Project data:", project);
            
            // Default to showing the section - safer approach
            hasEditAccess = true;
            
            // Add event listeners only if user has edit access
            document.getElementById('addMeetingBtn').addEventListener('click', openMeetingModal);
            document.getElementById('saveMeetingBtn').addEventListener('click', saveMeeting);
            
            // Load existing meetings
            loadProjectMeetings();
        } catch (error) {
            console.error('Error checking edit access:', error);
            // Show meetings section even on error for now
            const meetingsSection = document.getElementById('project-meetings-section');
            if (meetingsSection) {
                meetingsSection.style.display = 'block';
            }
            // Add event listeners
            document.getElementById('addMeetingBtn').addEventListener('click', openMeetingModal);
            document.getElementById('saveMeetingBtn').addEventListener('click', saveMeeting);
            
            // Load existing meetings
            loadProjectMeetings();
        }
        */
    }
    
    // Calendar state
    let currentCalendarDate = new Date();
    let selectedDate = null;
    
    // Open meeting modal
    function openMeetingModal() {
        const modal = new bootstrap.Modal(document.getElementById('meetingModal'));
        
        // Reset form and suggestions
        document.getElementById('meetingForm').reset();
        document.getElementById('availabilityResults').style.display = 'none';
        document.getElementById('timeSuggestionsContainer').style.display = 'none';
        document.getElementById('timeSuggestionsLoading').style.display = 'none';
        document.getElementById('memberSchedules').style.display = 'none';
        document.getElementById('noDateSelected').style.display = 'none'; // Hide "no date selected" message
        
        // Set calendar to current date and automatically select today
        currentCalendarDate = new Date();
        const today = new Date();
        selectedDate = today.toISOString().split('T')[0]; // Format as YYYY-MM-DD
        document.getElementById('meetingDate').value = selectedDate;
        
        // Render calendar with today highlighted
        renderCalendar();
        
        modal.show();
        
        // Automatically load suggestions for today
        if (memberScheduleData.length === 0) {
            // Load member schedules first, then generate suggestions for today
            loadMemberSchedules(() => {
                generateTimeSuggestionsForDate(selectedDate);
            });
        } else {
            // Generate suggestions for today immediately
            generateTimeSuggestionsForDate(selectedDate);
        }
    }
    
    // Render calendar
    function renderCalendar() {
        const calendarContainer = document.getElementById('meetingCalendar');
        const today = new Date();
        const year = currentCalendarDate.getFullYear();
        const month = currentCalendarDate.getMonth();
        
        // Create calendar HTML
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        
        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        
        let calendarHTML = `
            <div class="calendar-header">
                <button type="button" class="calendar-nav-btn" onclick="navigateCalendar(-1)">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="calendar-month-year">
                    ${monthNames[month]} ${year}
                </div>
                <button type="button" class="calendar-nav-btn" onclick="navigateCalendar(1)">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
            <div class="calendar-grid">
        `;
        
        // Add day headers
        dayNames.forEach(day => {
            calendarHTML += `<div class="calendar-day-header">${day}</div>`;
        });
        
        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();
        
        // Add previous month's trailing days
        for (let i = firstDay - 1; i >= 0; i--) {
            const day = daysInPrevMonth - i;
            calendarHTML += `<div class="calendar-day other-month">${day}</div>`;
        }
        
        // Add current month's days
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dateString = date.toISOString().split('T')[0];
            const isToday = date.toDateString() === today.toDateString();
            const isPast = date < today && !isToday;
            const isSelected = selectedDate && selectedDate === dateString;
            
            let classes = 'calendar-day';
            if (isPast) classes += ' disabled';
            if (isToday) classes += ' today';
            if (isSelected) classes += ' selected';
            
            const clickHandler = isPast ? '' : `onclick="selectDate('${dateString}')"`;
            
            calendarHTML += `<div class="${classes}" ${clickHandler}>${day}</div>`;
        }
        
        // Add next month's leading days
        const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
        const remainingCells = totalCells - (firstDay + daysInMonth);
        for (let day = 1; day <= remainingCells; day++) {
            calendarHTML += `<div class="calendar-day other-month">${day}</div>`;
        }
        
        calendarHTML += '</div>';
        
        calendarContainer.innerHTML = calendarHTML;
    }
    

    
    // Handle date change event
    function onDateChange() {
        const selectedDate = document.getElementById('meetingDate').value;
        
        if (!selectedDate) {
            document.getElementById('timeSuggestionsContainer').style.display = 'none';
            return;
        }
        
        // Show loading
        document.getElementById('timeSuggestionsLoading').style.display = 'block';
        document.getElementById('timeSuggestionsContainer').style.display = 'none';
        
        // Generate suggestions for the selected date
        if (memberScheduleData.length > 0) {
            generateTimeSuggestionsForDate(selectedDate);
        } else {
            // Load schedules first, then generate suggestions
            loadMemberSchedules(() => {
                generateTimeSuggestionsForDate(selectedDate);
            });
        }
    }
    
    // Refresh time suggestions
    function refreshTimeSuggestions() {
        const selectedDate = document.getElementById('meetingDate').value;
        if (selectedDate) {
            onDateChange();
        }
    }
    
    // Manual time selection for testing
    function setManualTime() {
        const selectedDate = document.getElementById('meetingDate').value;
        const startTime = document.getElementById('manualStartTime').value;
        const endTime = document.getElementById('manualEndTime').value;
        
        // Validate inputs
        if (!selectedDate) {
            alert('Please select a date first');
            return;
        }
        
        if (!startTime || !endTime) {
            alert('Please enter both start and end times');
            return;
        }
        
        // Convert to Date objects for validation
        const startDateTime = new Date(`${selectedDate}T${startTime}`);
        const endDateTime = new Date(`${selectedDate}T${endTime}`);
        
        if (endDateTime <= startDateTime) {
            alert('End time must be after start time');
            return;
        }
        
        // Set the times in the hidden fields
        document.getElementById('meetingStartTime').value = startTime;
        document.getElementById('meetingEndTime').value = endTime;
        document.getElementById('meetingDate').value = selectedDate;
        
        // Clear any existing suggestion selections
        document.querySelectorAll('.suggestion-card').forEach(card => {
            card.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
        });
        
        // Calculate duration
        const durationMs = endDateTime - startDateTime;
        const durationHours = Math.floor(durationMs / (1000 * 60 * 60));
        const durationMinutes = Math.floor((durationMs % (1000 * 60 * 60)) / (1000 * 60));
        
        let durationText = '';
        if (durationHours > 0) {
            durationText += `${durationHours}h `;
        }
        if (durationMinutes > 0) {
            durationText += `${durationMinutes}min`;
        }
        
        // Enable save button and show confirmation
        document.getElementById('saveMeetingBtn').disabled = false;
        
        const availabilityResults = document.getElementById('availabilityResults');
        const formattedDate = new Date(selectedDate).toLocaleDateString('en-US', { 
            weekday: 'long', 
            month: 'long', 
            day: 'numeric' 
        });
        
        availabilityResults.innerHTML = `
            <i class="bi bi-tools me-2 text-warning"></i>
            <strong>Manual Time Set:</strong> ${startTime} - ${endTime} (${durationText}) on ${formattedDate}
            <br><small class="text-warning">⚠️ Testing mode - Team availability not checked</small>
        `;
        availabilityResults.className = 'alert alert-warning';
        availabilityResults.style.display = 'block';
        
        console.log('Manual time set:', {
            date: selectedDate,
            startTime: startTime,
            endTime: endTime,
            duration: durationText
        });
    }
    
    // Filter time suggestions by AM/PM
    function filterSuggestions(filter) {
        // Update button states
        document.querySelectorAll('#timeSuggestionsContainer .btn-group button').forEach(btn => {
            btn.classList.remove('active');
        });
        const buttonId = filter === 'all' ? 'filterAll' : 
                         filter === 'am' ? 'filterAM' : 
                         filter === 'pm' ? 'filterPM' : '';
        if (buttonId) {
            document.getElementById(buttonId).classList.add('active');
        }
        
        // Get all suggestion elements
        const suggestions = document.querySelectorAll('#timeSlots .suggestion-card');
        
        suggestions.forEach((suggestion, index) => {
            const timeDisplayElement = suggestion.querySelector('.time-display .card-title');
            const startTimeText = timeDisplayElement ? timeDisplayElement.textContent.trim() : '';
            
            // Extract start time from format like "08:00 - 09:00" (ignore the icon text)
            const timeMatch = startTimeText.match(/(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})/);
            const startTime = timeMatch ? timeMatch[1] : '';
            
            let showSuggestion = true;
            
            if (startTime && filter !== 'all') {
                const [hours, minutes] = startTime.split(':').map(Number);
                
                if (filter === 'am') {
                    // Show only AM suggestions (before 12:00)
                    showSuggestion = hours < 12;
                } else if (filter === 'pm') {
                    // Show only PM suggestions (12:00 and after)
                    showSuggestion = hours >= 12;
                }
            }
            
            suggestion.style.display = showSuggestion ? 'block' : 'none';
        });
        
        // Update count display
        const visibleSuggestions = document.querySelectorAll('#timeSlots .suggestion-card:not([style*="display: none"])').length;
        
        const availabilityResults = document.getElementById('availabilityResults');
        if (availabilityResults && availabilityResults.style.display !== 'none') {
            const filterText = filter === 'all' ? '' : ` (${filter.toUpperCase()} only)`;
            availabilityResults.innerHTML = availabilityResults.innerHTML.replace(
                /\d+ team meeting slots/,
                `${visibleSuggestions} team meeting slots`
            ).replace(/ \(AM only\)| \(PM only\)/g, '') + filterText;
        }
    }
    
    // Load member schedules using individual get_schedule.php calls
    function loadMemberSchedules(callback = null) {
        console.log('Starting to load member schedules for project:', projectId);
        
        // First, get the project details using GET request (not POST)
        fetch(`src/model/get_project.php?id=${projectId}`)
        .then(response => {
            console.log('Project fetch response status:', response.status);
            return response.json();
        })
        .then(projectData => {
            console.log('Project data received:', projectData);
            
            if (!projectData.success || !projectData.project) {
                throw new Error('Could not load project details: ' + (projectData.message || 'Unknown error'));
            }
            
            const project = projectData.project;
            const memberPromises = [];
            let memberCount = 0;
            
            console.log('Project loaded:', {
                title: project.title,
                members: project.members ? project.members.length : 0,
                supervisor: project.supervisor ? 'Yes' : 'No'
            });
            
            // Collect all team members
            if (project.members && Array.isArray(project.members)) {
                console.log('Processing', project.members.length, 'team members');
                
                project.members.forEach((member, index) => {
                    console.log(`Member ${index + 1}:`, member);
                    
                    if (member.userId) {
                        let userId = member.userId;
                        
                        // Handle different userId formats
                        if (typeof userId === 'object') {
                            if (userId.$oid) {
                                userId = userId.$oid;
                            } else if (userId.oid) {
                                userId = userId.oid;
                            } else {
                                userId = String(userId);
                            }
                        } else {
                            userId = String(userId);
                        }
                        
                        console.log(`  - Extracted userId: ${userId}`);
                        memberCount++;
                        
                        // Create promise to fetch this member's schedule
                        const schedulePromise = fetch('src/model/get_schedule.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ userId: userId })
                        })
                        .then(response => {
                            console.log(`Schedule fetch for ${member.name} (${userId}) - Status:`, response.status);
                            return response.json();
                        })
                        .then(scheduleData => {
                            console.log(`Schedule data for ${member.name}:`, scheduleData);
                            
                            return {
                                userId: userId,
                                name: member.name || 'Unknown',
                                role: member.role || 'Team Member',
                                type: 'student',
                                schedule: scheduleData.success && scheduleData.schedule ? scheduleData.schedule : []
                            };
                        })
                        .catch(error => {
                            console.error(`Error fetching schedule for ${member.name}:`, error);
                            return {
                                userId: userId,
                                name: member.name || 'Unknown',
                                role: member.role || 'Team Member',
                                type: 'student',
                                schedule: []
                            };
                        });
                        
                        memberPromises.push(schedulePromise);
                    } else {
                        console.warn(`Member ${index + 1} has no userId:`, member);
                    }
                });
            }
            
            // Add supervisor
            if (project.supervisor && project.supervisor.userId) {
                console.log('Processing supervisor:', project.supervisor);
                
                let supervisorId = project.supervisor.userId;
                
                // Handle different userId formats
                if (typeof supervisorId === 'object') {
                    if (supervisorId.$oid) {
                        supervisorId = supervisorId.$oid;
                    } else if (supervisorId.oid) {
                        supervisorId = supervisorId.oid;
                    } else {
                        supervisorId = String(supervisorId);
                    }
                } else {
                    supervisorId = String(supervisorId);
                }
                
                console.log(`  - Supervisor userId: ${supervisorId}`);
                memberCount++;
                
                const supervisorSchedulePromise = fetch('src/model/get_schedule.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ userId: supervisorId })
                })
                .then(response => {
                    console.log(`Schedule fetch for supervisor ${project.supervisor.name} (${supervisorId}) - Status:`, response.status);
                    return response.json();
                })
                .then(scheduleData => {
                    console.log(`Schedule data for supervisor ${project.supervisor.name}:`, scheduleData);
                    
                    return {
                        userId: supervisorId,
                        name: project.supervisor.name || 'Unknown',
                        role: 'Supervisor',
                        type: 'faculty',
                        schedule: scheduleData.success && scheduleData.schedule ? scheduleData.schedule : []
                    };
                })
                .catch(error => {
                    console.error(`Error fetching schedule for supervisor ${project.supervisor.name}:`, error);
                    return {
                        userId: supervisorId,
                        name: project.supervisor.name || 'Unknown',
                        role: 'Supervisor',
                        type: 'faculty',
                        schedule: []
                    };
                });
                
                memberPromises.push(supervisorSchedulePromise);
            }
            
            console.log(`Total members to fetch schedules for: ${memberCount}`);
            
            if (memberPromises.length === 0) {
                throw new Error('No team members or supervisors found in project');
            }
            
            // Wait for all schedule requests to complete
            return Promise.all(memberPromises);
        })
        .then(allMemberSchedules => {
            memberScheduleData = allMemberSchedules;
            console.log('Successfully loaded schedules for', memberScheduleData.length, 'members');
            
            // Log summary of loaded data
            allMemberSchedules.forEach(member => {
                console.log(`${member.name} (${member.role}): ${member.schedule.length} schedule items`);
            });
            
            if (callback) callback();
        })
        .catch(error => {
            console.error('Error loading member schedules:', error);
            document.getElementById('timeSuggestionsLoading').style.display = 'none';
            
            // Show detailed error message
            const availabilityResults = document.getElementById('availabilityResults');
            availabilityResults.innerHTML = `<i class="bi bi-x-circle me-2"></i>Error loading team schedules: ${error.message}`;
            availabilityResults.className = 'alert alert-danger';
            availabilityResults.style.display = 'block';
        });
    }
    
    // Load project meetings
    function loadProjectMeetings() {
        const meetingsLoading = document.getElementById('meetings-loading');
        const meetingsList = document.getElementById('meetings-list');
        const noMeetings = document.getElementById('no-meetings');
        
        meetingsLoading.style.display = 'block';
        meetingsList.style.display = 'none';
        noMeetings.style.display = 'none';
        
        // Construct proper URL for the API endpoint
        // If we're on a development server (port 3000), point to XAMPP on default port
        let getMeetingsUrl;
        if (window.location.port === '3000') {
            // Development server - point to XAMPP
            getMeetingsUrl = window.location.protocol + '//' + window.location.hostname + '/uiurp/src/model/get_project_meetings.php';
        } else {
            // Same server - use relative path with proper construction
            getMeetingsUrl = window.location.protocol + '//' + window.location.hostname + 
                            (window.location.port && window.location.port !== '80' && window.location.port !== '443' 
                             ? ':' + window.location.port : '') + 
                            window.location.pathname.replace(/\/[^\/]*$/, '') + '/src/model/get_project_meetings.php';
        }
        
        fetch(getMeetingsUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ projectId: projectId }),
            credentials: 'include'  // Include session cookies for cross-origin
        })
        .then(response => response.json())
        .then(data => {
            meetingsLoading.style.display = 'none';
            
            if (data.success && data.meetings && data.meetings.length > 0) {
                renderMeetings(data.meetings);
                meetingsList.style.display = 'block';
                noMeetings.style.display = 'none';
            } else {
                meetingsList.style.display = 'none';
                noMeetings.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error loading meetings:', error);
            meetingsLoading.style.display = 'none';
            meetingsList.style.display = 'none';
            noMeetings.style.display = 'block';
        });
    }
    
    // Render meetings
    function renderMeetings(meetings) {
        const meetingsList = document.getElementById('meetings-list');
        meetingsList.innerHTML = '';
        
        // Sort meetings by date, newest first
        const sortedMeetings = [...meetings].sort((a, b) => {
            // First compare dates
            const dateComparison = new Date(b.date) - new Date(a.date);
            
            // If same date, compare start times
            if (dateComparison === 0) {
                // Convert time strings to comparable values (assuming format like "09:00")
                const aTime = a.startTime.split(':').map(Number);
                const bTime = b.startTime.split(':').map(Number);
                
                // Compare hours first, then minutes
                if (bTime[0] !== aTime[0]) {
                    return bTime[0] - aTime[0];
                } else {
                    return bTime[1] - aTime[1];
                }
            }
            
            return dateComparison;
        });
        
        sortedMeetings.forEach(meeting => {
            const meetingCard = createMeetingCard(meeting);
            meetingsList.appendChild(meetingCard);
        });
    }
    
    // Create meeting card
    function createMeetingCard(meeting) {
        const card = document.createElement('div');
        card.className = 'meeting-card mb-3 p-3 border rounded';
        
        const meetingDate = new Date(meeting.date);
        const formattedDate = meetingDate.toLocaleDateString();
        const startTime = formatTime(meeting.startTime);
        const endTime = formatTime(meeting.endTime);
        
        // Determine status color
        let statusClass = 'bg-primary';
        const currentDate = new Date();
        const meetingDateTime = new Date(meeting.date + 'T' + meeting.startTime);
        
        if (meetingDateTime < currentDate) {
            statusClass = 'bg-secondary'; // Past meeting
        } else if (meeting.status === 'Cancelled') {
            statusClass = 'bg-danger';
        }
        
        card.innerHTML = `
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="mb-0">${meeting.title}</h6>
                <span class="badge ${statusClass}">${meeting.status}</span>
            </div>
            <div class="meeting-details">
                <div class="d-flex align-items-center text-muted mb-1">
                    <i class="bi bi-calendar3 me-2"></i>
                    <small>${formattedDate}</small>
                </div>
                <div class="d-flex align-items-center text-muted mb-1">
                    <i class="bi bi-clock me-2"></i>
                    <small>${startTime} - ${endTime}</small>
                </div>
                ${meeting.meetingLink ? `
                    <div class="d-flex align-items-center text-muted mb-1">
                        <i class="bi bi-link-45deg me-2"></i>
                        <small><a href="#" onclick="handleMeetingJoin('${meeting.meetingId}'); return false;" class="text-primary">Join Meeting (Time Restricted)</a></small>
                    </div>
                ` : ''}
                <div class="d-flex align-items-center text-muted">
                    <i class="bi bi-person me-2"></i>
                    <small>Organized by ${meeting.organizer}</small>
                </div>
            </div>
            ${meeting.description ? `
                <p class="text-muted small mt-2 mb-0">${meeting.description}</p>
            ` : ''}
        `;
        
        return card;
    }
    
    // Generate time suggestions for a specific date using team schedule analysis
    function generateTimeSuggestionsForDate(selectedDate) {
        const targetDate = new Date(selectedDate);
        const dayName = targetDate.toLocaleDateString('en-US', { weekday: 'long' });
        
        console.log('Generating suggestions for', selectedDate, '(', dayName, ') using team schedule analysis');
        
        // Construct proper URL for the API endpoint
        let suggestionsUrl;
        if (window.location.port === '3000') {
            // Development server - point to XAMPP
            suggestionsUrl = `http://localhost/uiurp/src/model/get_project_meeting_suggestions.php?projectId=${projectId}&date=${selectedDate}`;
        } else {
            // Same server - use relative path
            suggestionsUrl = `src/model/get_project_meeting_suggestions.php?projectId=${projectId}&date=${selectedDate}`;
        }
        
        // Fetch suggestions from our new backend API
        fetch(suggestionsUrl, {
            method: 'GET',
            credentials: 'include'  // Include session cookies for cross-origin
        })
            .then(response => response.json())
            .then(data => {
                console.log('Team schedule analysis result:', data);
                
                // Hide loading indicator
                document.getElementById('timeSuggestionsLoading').style.display = 'none';
                
                if (data.success) {
                    const suggestions = data.suggestions || [];
                    const memberConflicts = data.memberConflicts || {};
                    
                    // Debug: Log all suggestions received from API
                    console.log('Raw suggestions from API:', suggestions.map(s => `${s.startTime} - ${s.endTime}`));
                    console.log('Debug info:', data.debug);
                    
                    if (suggestions.length > 0) {
                        // Convert suggestions to our expected format
                        const formattedSuggestions = suggestions.map(suggestion => ({
                date: selectedDate,
                displayDate: targetDate.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    month: 'short', 
                    day: 'numeric' 
                }),
                            startTime: suggestion.startTime,
                            endTime: suggestion.endTime,
                            duration: suggestion.duration,
                            durationText: suggestion.durationText,
                            quality: suggestion.quality,
                            available: data.teamMembers.length, // Everyone is available in these slots
                            total: data.teamMembers.length,
                            conflicts: [], // No conflicts in suggested times
                            score: 1.0, // Perfect score since everyone is free
                            isCompletelyFree: true
                        }));
        
                        // Render the suggestions
                        renderTeamTimeSuggestions(formattedSuggestions, data.teamMembers, memberConflicts);
            document.getElementById('timeSuggestionsContainer').style.display = 'block';
            
                        // Show success message
            const availabilityResults = document.getElementById('availabilityResults');
                        availabilityResults.innerHTML = `<i class="bi bi-check-circle me-2 text-success"></i><strong>${suggestions.length} team meeting slots found when everyone is free!</strong>`;
                availabilityResults.className = 'alert alert-success';
                        availabilityResults.style.display = 'block';
                        
                        // Show team member schedules
                        displayTeamSchedules(data.teamMembers, memberConflicts, data.dayOfWeek);
                        
            } else {
                        // No suggestions found
                        document.getElementById('timeSuggestionsContainer').style.display = 'none';
                        
                        const availabilityResults = document.getElementById('availabilityResults');
                        availabilityResults.innerHTML = `<i class="bi bi-x-circle me-2 text-warning"></i><strong>No free time slots found on ${dayName} when everyone is available</strong><br><small>Consider selecting a different date or shorter meeting duration</small>`;
                availabilityResults.className = 'alert alert-warning';
            availabilityResults.style.display = 'block';
                        
                        // Still show team schedules to help understand conflicts
                        displayTeamSchedules(data.teamMembers, memberConflicts, data.dayOfWeek);
                    }
        } else {
                    // Error occurred
            document.getElementById('timeSuggestionsContainer').style.display = 'none';
            
            const availabilityResults = document.getElementById('availabilityResults');
                    availabilityResults.innerHTML = `<i class="bi bi-exclamation-triangle me-2 text-danger"></i><strong>Error loading team schedules:</strong> ${data.error}`;
            availabilityResults.className = 'alert alert-danger';
            availabilityResults.style.display = 'block';
        }
            })
            .catch(error => {
                console.error('Error fetching team schedule suggestions:', error);
                
                // Hide loading and show error
                document.getElementById('timeSuggestionsLoading').style.display = 'none';
                document.getElementById('timeSuggestionsContainer').style.display = 'none';
                
                const availabilityResults = document.getElementById('availabilityResults');
                availabilityResults.innerHTML = `<i class="bi bi-exclamation-triangle me-2 text-danger"></i><strong>Error loading team schedules.</strong> Please try again.`;
                availabilityResults.className = 'alert alert-danger';
                availabilityResults.style.display = 'block';
            });
    }
    
    // Render team time suggestions with enhanced formatting
    function renderTeamTimeSuggestions(suggestions, teamMembers, memberConflicts) {
        const timeSlots = document.getElementById('timeSlots');
        
        if (suggestions.length === 0) {
            timeSlots.innerHTML = `
                <div class="text-center py-4">
                    <i class="bi bi-clock-history text-muted mb-3" style="font-size: 2.5rem;"></i>
                    <h6 class="text-muted mb-2">No Available Time Slots</h6>
                    <p class="text-muted small mb-0">All team members are busy during this day. Try selecting a different date.</p>
                </div>
            `;
            return;
        }
        
        let html = '';
        
        // Group suggestions by quality for better organization
        const groupedSuggestions = {
            long: suggestions.filter(s => s.quality === 'long'),
            medium: suggestions.filter(s => s.quality === 'medium'),
            short: suggestions.filter(s => s.quality === 'short')
        };
        
        // Show best suggestions first
        Object.entries(groupedSuggestions).forEach(([quality, items]) => {
            if (items.length === 0) return;
            
            items.forEach((suggestion, index) => {
                const priorityClass = suggestion.quality === 'long' ? 'border-success' : 
                                    suggestion.quality === 'medium' ? 'border-warning' : 'border-info';
                
                const priorityIcon = suggestion.quality === 'long' ? 'bi-star-fill text-success' : 
                                   suggestion.quality === 'medium' ? 'bi-star-half text-warning' : 'bi-star text-info';
                
                const qualityLabel = suggestion.quality === 'long' ? 'Optimal' :
                                   suggestion.quality === 'medium' ? 'Good' : 'Quick';
                
                const qualityColor = suggestion.quality === 'long' ? 'success' :
                                   suggestion.quality === 'medium' ? 'warning' : 'info';
                
                html += `
                    <div class="suggestion-card ${priorityClass}" onclick="selectTimeSuggestion('${suggestion.startTime}', '${suggestion.endTime}', '${suggestion.date}')">
                        <div class="card-header-section">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="time-display">
                                    <h6 class="card-title mb-1">
                                        <i class="bi ${priorityIcon} me-2"></i>
                                        ${suggestion.startTime} - ${suggestion.endTime}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>${suggestion.displayDate}
                                    </small>
                                </div>
                                <div class="badges">
                                    <span class="badge bg-${qualityColor} bg-opacity-10 text-${qualityColor} mb-1">
                                        ${qualityLabel}
                                    </span>
                                    <br>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        ${suggestion.durationText}
                                    </span>
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="availability-info">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center text-success">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <span class="small fw-medium">
                                        Everyone Available
                                    </span>
                                </div>
                                <div class="d-flex align-items-center text-muted small">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        });
        
        timeSlots.innerHTML = html;
        
        // Reset filter to "All" when new suggestions are loaded
        setTimeout(() => {
            const filterAllBtn = document.getElementById('filterAll');
            if (filterAllBtn) {
                document.querySelectorAll('#timeSuggestionsContainer .btn-group button').forEach(btn => {
                    btn.classList.remove('active');
                });
                filterAllBtn.classList.add('active');
            }
        }, 100);
    }
    
    // Display team schedules and conflicts as sidebar
    function displayTeamSchedules(teamMembers, memberConflicts, dayOfWeek) {
        const memberSchedules = document.getElementById('memberSchedules');
        
        let html = `
            <div class="sidebar-header mb-3">
                <h6 class="text-primary mb-1">
                    <i class="bi bi-people-fill me-2"></i>Team Availability
                </h6>
                <small class="text-muted">Individual schedules for ${dayOfWeek}</small>
            </div>
            <div class="members-list">
        `;
        
        teamMembers.forEach(member => {
            const conflicts = memberConflicts[member.name] || [];
            const roleIcon = member.type === 'supervisor' ? 'bi-mortarboard-fill' : 'bi-person-circle';
            const roleColor = member.type === 'supervisor' ? 'text-primary' : 'text-info';
            
            html += `
                <div class="member-card mb-3">
                    <div class="member-header">
                        <div class="d-flex align-items-center mb-2">
                            <div class="member-avatar-small me-2">
                                <i class="bi ${roleIcon} ${roleColor}"></i>
                            </div>
                            <div class="member-info flex-grow-1">
                                <div class="member-name">${member.name}</div>
                                <span class="role-badge badge bg-${member.type === 'supervisor' ? 'primary' : 'info'} bg-opacity-15 text-${member.type === 'supervisor' ? 'primary' : 'info'}">
                                    ${member.role}
                                </span>
                            </div>
                            <div class="status-indicator">
                                ${conflicts.length === 0 ? 
                                    '<i class="bi bi-check-circle-fill text-success" title="Available"></i>' : 
                                    '<i class="bi bi-exclamation-circle-fill text-warning" title="Has conflicts"></i>'
                                }
                            </div>
                        </div>
                    </div>
                    
                    <div class="member-schedule">
                        ${conflicts.length > 0 ? `
                            <div class="conflicts-compact">
                                <small class="conflicts-label text-warning fw-medium mb-1 d-block">
                                    <i class="bi bi-clock me-1"></i>Busy (${conflicts.length})
                                </small>
                                ${conflicts.map(conflict => `
                                    <div class="conflict-compact">
                                        <div class="conflict-time-badge">${conflict.startTime}-${conflict.endTime}</div>
                                        <div class="conflict-title-small">${conflict.title}</div>
                                        ${conflict.type ? `<div class="conflict-type">${conflict.type}</div>` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        ` : `
                            <div class="available-compact">
                                <small class="text-success fw-medium">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Available all day
                                </small>
                            </div>
                        `}
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        memberSchedules.innerHTML = html;
        memberSchedules.style.display = 'block';
    }
    
    // Select a time suggestion and fill the form (global function)
    window.selectTimeSuggestion = function(startTime, endTime, date) {
        // Fill hidden fields
        document.getElementById('meetingStartTime').value = startTime;
        document.getElementById('meetingEndTime').value = endTime;
        document.getElementById('meetingDate').value = date;
        
        // Update visual feedback
        document.querySelectorAll('.suggestion-card').forEach(card => {
            card.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
        });
        
        // Highlight selected card
        event.currentTarget.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
        
        // Enable save button
        document.getElementById('saveMeetingBtn').disabled = false;
        
        // Show confirmation
        const availabilityResults = document.getElementById('availabilityResults');
        availabilityResults.innerHTML = `<i class="bi bi-check-circle me-2 text-success"></i><strong>Selected:</strong> ${startTime} - ${endTime} on ${new Date(date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' })}`;
        availabilityResults.className = 'alert alert-info';
        availabilityResults.style.display = 'block';
    };

    // Create Google Meet link functionality
    document.addEventListener('DOMContentLoaded', function() {
        const createGoogleMeetBtn = document.getElementById('createGoogleMeetBtn');
        const meetingLinkInput = document.getElementById('meetingLink');
        const meetingTitleInput = document.getElementById('meetingTitle');
        const meetingDescriptionInput = document.getElementById('meetingDescription');
        const meetingDateInput = document.getElementById('meetingDate');
        const meetingStartTimeInput = document.getElementById('meetingStartTime');
        const meetingEndTimeInput = document.getElementById('meetingEndTime');

        if (createGoogleMeetBtn) {
            createGoogleMeetBtn.addEventListener('click', function() {
                // Validate that time and date are selected
                const date = meetingDateInput.value;
                const startTime = meetingStartTimeInput.value;
                const endTime = meetingEndTimeInput.value;

                if (!date || !startTime || !endTime) {
                    alert('Please select a date and time first by choosing from the time suggestions.');
                    return;
                }

                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating Meeting...';
                this.disabled = true;

                // Get meeting details
                const title = meetingTitleInput.value || 'Team Meeting';
                const description = meetingDescriptionInput.value || 'Project team meeting';

                // Create time-restricted Google Meet link
                createTimedGoogleMeetLink(title, description, date, startTime, endTime)
                    .then(meetingData => {
                        // Set the meeting link with time validation
                        meetingLinkInput.value = meetingData.accessUrl;
                        
                        // Store meeting data for validation
                        window.currentMeetingData = meetingData;
                        
                        // Show success state
                        this.innerHTML = '<i class="bi bi-check-circle me-2"></i>Meeting Created!';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-success');
                        
                        // Show meeting info
                        showMeetingInfo(meetingData);
                    })
                    .catch(error => {
                        console.error('Error creating meeting:', error);
                        this.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Error Creating Meeting';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-danger');
                    })
                    .finally(() => {
                        // Reset button after 3 seconds
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                            this.classList.remove('btn-success', 'btn-danger');
                            this.classList.add('btn-outline-primary');
                        }, 3000);
                    });
            });
        }

        // Test meeting button for current time
        const testMeetingBtn = document.getElementById('testMeetingBtn');
        if (testMeetingBtn) {
            testMeetingBtn.addEventListener('click', function() {
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating Test...';
                this.disabled = true;

                // Get current time and create 30-minute meeting
                const now = new Date();
                const endTime = new Date(now.getTime() + 30 * 60 * 1000); // 30 minutes later

                // Format times for the function
                const currentDate = now.toISOString().split('T')[0];
                const currentTime = now.toTimeString().slice(0, 5);
                const testEndTime = endTime.toTimeString().slice(0, 5);

                // Get meeting details or use defaults
                const title = meetingTitleInput.value || 'Test Meeting';
                const description = meetingDescriptionInput.value || 'Test meeting for current time';

                // Create time-restricted Google Meet link for current time
                createTimedGoogleMeetLink(title, description, currentDate, currentTime, testEndTime)
                    .then(meetingData => {
                        // Set the meeting link with time validation
                        meetingLinkInput.value = meetingData.accessUrl;
                        
                        // Store meeting data for validation
                        window.currentMeetingData = meetingData;
                        
                        // Show success state
                        this.innerHTML = '<i class="bi bi-check-circle me-2"></i>Test Created!';
                        this.classList.remove('btn-outline-secondary');
                        this.classList.add('btn-success');
                        
                        // Show meeting info with test indicator
                        showTestMeetingInfo(meetingData);
                    })
                    .catch(error => {
                        console.error('Error creating test meeting:', error);
                        this.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Error';
                        this.classList.remove('btn-outline-secondary');
                        this.classList.add('btn-danger');
                    })
                    .finally(() => {
                        // Reset button after 3 seconds
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                            this.classList.remove('btn-success', 'btn-danger');
                            this.classList.add('btn-outline-secondary');
                        }, 3000);
                    });
            });
        }
    });

    // Function to create time-restricted Google Meet link
    async function createTimedGoogleMeetLink(title, description, date, startTime, endTime) {
        return new Promise((resolve) => {
            // Create unique meeting ID
            const meetingId = generateMeetingId();
            
            // Create meeting start and end datetime objects
            const startDateTime = new Date(`${date}T${startTime}:00`);
            const endDateTime = new Date(`${date}T${endTime}:00`);
            
            // Use Google Meet's instant meeting URL (new meeting each time)
            const instantMeetUrl = 'https://meet.google.com/new';
            
            // Create the meeting data
            const meetingData = {
                id: meetingId,
                title: title,
                description: description,
                startTime: startDateTime,
                endTime: endDateTime,
                googleMeetUrl: instantMeetUrl,
                accessUrl: `${window.location.origin}${window.location.pathname}?joinMeeting=${meetingId}`,
                calendarUrl: createCalendarLink(title, description, date, startTime, endTime, instantMeetUrl)
            };
            
            // Store meeting data in localStorage for validation
            const meetings = JSON.parse(localStorage.getItem('scheduledMeetings') || '{}');
            meetings[meetingId] = meetingData;
            localStorage.setItem('scheduledMeetings', JSON.stringify(meetings));
            
            // Simulate API call delay
            setTimeout(() => {
                resolve(meetingData);
            }, 1500);
        });
    }

    // Function to create calendar link with Google Meet
    function createCalendarLink(title, description, date, startTime, endTime, meetingUrl) {
        const baseUrl = 'https://calendar.google.com/calendar/render';
        const startDateTime = formatDateForGoogle(new Date(`${date}T${startTime}:00`));
        const endDateTime = formatDateForGoogle(new Date(`${date}T${endTime}:00`));
        
        const params = new URLSearchParams({
            action: 'TEMPLATE',
            text: title,
            details: `${description}\n\nJoin Google Meet: ${meetingUrl}\n\nNote: This meeting link is only active during the scheduled time.`,
            dates: `${startDateTime}/${endDateTime}`,
            add: 'conferenceType=hangoutsMeet'
        });
        
        return `${baseUrl}?${params.toString()}`;
    }

    // Generate unique meeting ID
    function generateMeetingId() {
        const chars = 'abcdefghijklmnopqrstuvwxyz';
        const segments = [];
        
        // Generate 3 segments of 3-4 characters each (like Google Meet format)
        for (let i = 0; i < 3; i++) {
            let segment = '';
            const length = i === 1 ? 4 : 3; // Middle segment is 4 chars
            for (let j = 0; j < length; j++) {
                segment += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            segments.push(segment);
        }
        
        return segments.join('-');
    }

    // Helper function to format date for Google Calendar
    function formatDateForGoogle(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hour = String(date.getHours()).padStart(2, '0');
        const minute = String(date.getMinutes()).padStart(2, '0');
        const second = '00';
        
        return `${year}${month}${day}T${hour}${minute}${second}`;
    }

    // Send system message to project chat when meeting is created (similar to timeline editor)
    async function sendMeetingSystemMessage(meetingDate, startTime, meetingTitle, timeDifference, meetingLink = '') {
        try {
            // Get current user info first
            const userResponse = await fetch('src/model/get_current_user.php', {
                method: 'GET',
                credentials: 'include'
            });
            
            const userData = await userResponse.json();
            
            // Get user name from response or use fallback
            let currentUserName = 'Someone';
            if (userData && userData.success && userData.isLoggedIn && userData.user) {
                currentUserName = userData.user.name || 'Someone';
            }
            
            // Create appropriate message based on timing
            let systemMessage = '';
            const meetingDateTime = new Date(`${meetingDate}T${startTime}:00`);
            const formattedTime = meetingDateTime.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            const formattedDate = meetingDateTime.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            
            if (timeDifference <= 5 && timeDifference >= -5) {
                // Meeting starting now
                systemMessage = `🚀 ${currentUserName} just scheduled "${meetingTitle}" and it's starting NOW! `;
                if (meetingLink) {
                    systemMessage += `[Join Meeting](${meetingLink})`;
                }
            } else if (timeDifference <= 30) {
                // Meeting starting soon
                const minutesUntil = Math.max(1, Math.round(timeDifference));
                systemMessage = `🔔 ${currentUserName} scheduled "${meetingTitle}" for ${formattedTime} (in ${minutesUntil} minute${minutesUntil > 1 ? 's' : ''}). `;
                if (meetingLink) {
                    systemMessage += `[Join Meeting](${meetingLink})`;
                }
            } else {
                // Meeting scheduled for later
                systemMessage = `📅 ${currentUserName} scheduled "${meetingTitle}" for ${formattedTime} on ${formattedDate}. `;
                if (meetingLink) {
                    systemMessage += `[Meeting Link](${meetingLink})`;
                }
            }
            
            // Send the system message
            const systemMessageData = new FormData();
            systemMessageData.append('projectId', projectId);
            systemMessageData.append('message', systemMessage);
            
            return fetch('src/model/send_system_chat_message.php', {
                method: 'POST',
                body: systemMessageData
            });
            
        } catch (error) {
            console.error('Error sending meeting system message:', error);
            throw error;
        }
    }

    // Show meeting information after creation
    function showMeetingInfo(meetingData) {
        const availabilityResults = document.getElementById('availabilityResults');
        const meetingTime = meetingData.startTime.toLocaleString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        const endTime = meetingData.endTime.toLocaleString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        availabilityResults.innerHTML = `
            <div class="d-flex align-items-start">
                <i class="bi bi-check-circle-fill me-2 text-success mt-1"></i>
                <div>
                    <strong>📅 Scheduled Meeting Created!</strong><br>
                    <small class="text-muted">${meetingTime} - ${endTime}</small><br>
                    <small class="text-info">Meeting ID: ${meetingData.id}</small><br>
                    <div class="mt-2">
                        <a href="${meetingData.accessUrl}" class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Join Link (Time Restricted)
                        </a>
                        <a href="${meetingData.calendarUrl}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-calendar-plus me-1"></i>Add to Calendar
                        </a>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Join link will be active 5 minutes before the meeting starts.
                    </small>
                </div>
            </div>
        `;
        availabilityResults.className = 'alert alert-success';
        availabilityResults.style.display = 'block';
    }

    // Show test meeting information after creation
    function showTestMeetingInfo(meetingData) {
        const availabilityResults = document.getElementById('availabilityResults');
        const meetingTime = meetingData.startTime.toLocaleString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
        const endTime = meetingData.endTime.toLocaleString('en-US', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        availabilityResults.innerHTML = `
            <div class="d-flex align-items-start">
                <i class="bi bi-play-circle-fill me-2 text-warning mt-1"></i>
                <div>
                    <strong>🧪 Test Meeting Created!</strong><br>
                    <small class="text-muted">Active: ${meetingTime} - ${endTime} (30 min)</small><br>
                    <small class="text-info">Meeting ID: ${meetingData.id}</small><br>
                    <div class="mt-2">
                        <a href="${meetingData.accessUrl}" target="_blank" class="btn btn-sm btn-warning me-2">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Test Join Link
                        </a>
                        <button onclick="window.open('${meetingData.googleMeetUrl}', '_blank')" class="btn btn-sm btn-success">
                            <i class="bi bi-camera-video me-1"></i>Direct Meet
                        </button>
                    </div>
                </div>
            </div>
        `;
        availabilityResults.className = 'alert alert-warning';
        availabilityResults.style.display = 'block';
    }

    // Check if meeting is accessible at current time
    async function validateMeetingAccess(meetingId) {
        // First, check localStorage for Google Meet style meetings
        const meetings = JSON.parse(localStorage.getItem('scheduledMeetings') || '{}');
        let meeting = meetings[meetingId];
        
        // If not found in localStorage, check the database for regular meetings
        if (!meeting) {
            try {
                meeting = await getMeetingFromDatabase(meetingId);
            } catch (error) {
                console.error('Error fetching meeting from database:', error);
                return { accessible: false, reason: 'Meeting not found' };
            }
        }
        
        if (!meeting) {
            return { accessible: false, reason: 'Meeting not found' };
        }
        
        const now = new Date();
        let startTime, endTime;
        
        // Handle different meeting data formats
        if (meeting.startTime instanceof Date) {
            // Google Meet style meeting (from localStorage)
            startTime = meeting.startTime;
            endTime = meeting.endTime;
        } else {
            // Database meeting - handle different datetime formats
            if (meeting.startTime.includes('T') && meeting.startTime.includes('Z')) {
                // Full datetime strings (ISO format)
                startTime = new Date(meeting.startTime);
                endTime = new Date(meeting.endTime);
            } else {
                // Separate date and time components
                const meetingDate = meeting.date || new Date().toISOString().split('T')[0];
                startTime = new Date(`${meetingDate}T${meeting.startTime}:00`);
                endTime = new Date(`${meetingDate}T${meeting.endTime}:00`);
            }
        }
        
        // Allow access 5 minutes before the meeting starts
        const earlyAccess = new Date(startTime.getTime() - 5 * 60 * 1000);
        
        if (now < earlyAccess) {
            const timeUntil = Math.ceil((startTime - now) / (1000 * 60));
            const startDateTime = startTime.toLocaleString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            return { 
                accessible: false, 
                reason: `Meeting starts in ${timeUntil} minutes on ${startDateTime}` 
            };
        }
        
        if (now > endTime) {
            const endDateTime = endTime.toLocaleString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            return { 
                accessible: false, 
                reason: `Meeting ended on ${endDateTime}` 
            };
        }
        
        return { 
            accessible: true, 
            meeting: meeting,
            meetingLink: meeting.googleMeetUrl || meeting.meetingLink || 'https://meet.google.com/new'
        };
    }
    
    // Get meeting from database by ID
    async function getMeetingFromDatabase(meetingId) {
        // Construct proper URL for the API endpoint
        let apiUrl;
        if (window.location.port === '3000') {
            apiUrl = `http://localhost/uiurp/src/model/get_meeting_by_id.php?id=${meetingId}`;
        } else {
            apiUrl = `src/model/get_meeting_by_id.php?id=${meetingId}`;
        }
        
        try {
            const response = await fetch(apiUrl, {
                method: 'GET',
                credentials: 'include'
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            console.log('Database meeting response:', data);
            
            if (data.success && data.meeting) {
                console.log('Meeting data from database:', data.meeting);
                return data.meeting;
            } else {
                console.log('No meeting found in database response');
                return null;
            }
        } catch (error) {
            console.error('Error fetching meeting from database:', error);
            return null;
        }
    }

    // Handle meeting join from URL parameter
    document.addEventListener('DOMContentLoaded', async function() {
        const urlParams = new URLSearchParams(window.location.search);
        const joinMeetingId = urlParams.get('joinMeeting');
        
        if (joinMeetingId) {
            try {
                const access = await validateMeetingAccess(joinMeetingId);
                
                if (access.accessible) {
                    // Directly redirect to Google Meet for valid meetings
                    const meetingUrl = access.meetingLink || access.meeting.googleMeetUrl || access.meeting.meetingLink;
                    console.log('Redirecting to Google Meet:', meetingUrl);
                    window.location.href = meetingUrl;
                    return; // Don't execute cleanup
                } else {
                    // Show better alert without redirection
                    showMeetingAccessAlert(access.reason, access.meeting);
                    // Clean URL without reloading the page
                    history.replaceState({}, document.title, window.location.pathname);
                    return;
                }
            } catch (error) {
                console.error('Error validating meeting access:', error);
                showMeetingAccessAlert('Error joining meeting. Please try again.', null);
                // Clean URL without reloading the page
                history.replaceState({}, document.title, window.location.pathname);
                return;
            }
        }
    });

    // Show meeting access alert with better UI
    function showMeetingAccessAlert(reason, meeting) {
        // Create a better alert modal instead of browser alert
        const alertHtml = `
            <div class="modal fade" id="meetingAccessModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Meeting Access Restricted
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning mb-3">
                                <strong>${reason}</strong>
                            </div>
                            ${meeting ? `
                                <div class="meeting-info">
                                    <h6><i class="bi bi-calendar-event me-2"></i>${meeting.title || 'Meeting'}</h6>
                                    ${meeting.description ? `<p class="text-muted small mb-2">${meeting.description}</p>` : ''}
                                    <div class="d-flex align-items-center text-muted mb-1">
                                        <i class="bi bi-clock me-2"></i>
                                        <small>Access allowed 5 minutes before meeting starts</small>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left me-1"></i>Back to Project
                            </button>
                            ${meeting ? `
                                <button type="button" class="btn btn-primary" onclick="showMeetingDetails('${meeting.id || meeting.meetingId}')">
                                    <i class="bi bi-info-circle me-1"></i>Meeting Details
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal if any
        const existingModal = document.getElementById('meetingAccessModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Add modal to page
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('meetingAccessModal'));
        modal.show();
        
        // Clean up modal after it's hidden
        document.getElementById('meetingAccessModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    // Handle meeting join click without page navigation
    async function handleMeetingJoin(meetingId) {
        try {
            const access = await validateMeetingAccess(meetingId);
            
            if (access.accessible) {
                // Directly redirect to Google Meet for valid meetings
                const meetingUrl = access.meetingLink || access.meeting.googleMeetUrl || access.meeting.meetingLink;
                console.log('Redirecting to Google Meet:', meetingUrl);
                window.open(meetingUrl, '_blank'); // Open in new tab
            } else {
                // Show better alert without any navigation
                showMeetingAccessAlert(access.reason, access.meeting);
            }
        } catch (error) {
            console.error('Error validating meeting access:', error);
            showMeetingAccessAlert('Error joining meeting. Please try again.', null);
        }
    }

    // Show meeting details in meetings section
    function showMeetingDetails(meetingId) {
        // Close the access modal
        const accessModal = bootstrap.Modal.getInstance(document.getElementById('meetingAccessModal'));
        if (accessModal) {
            accessModal.hide();
        }
        
        // Scroll to meetings section and highlight the specific meeting
        const meetingsSection = document.getElementById('meetings-container');
        if (meetingsSection) {
            meetingsSection.scrollIntoView({ behavior: 'smooth' });
            
            // Highlight the specific meeting card if found
            setTimeout(() => {
                const meetingCards = document.querySelectorAll('.meeting-card');
                meetingCards.forEach(card => {
                    const cardContent = card.innerHTML;
                    if (cardContent.includes(meetingId)) {
                        card.style.boxShadow = '0 0 15px rgba(255, 193, 7, 0.6)';
                        card.style.border = '2px solid #ffc107';
                        setTimeout(() => {
                            card.style.boxShadow = '';
                            card.style.border = '';
                        }, 3000);
                    }
                });
            }, 500);
        }
    }
    

    
    // Generate meeting suggestions
    function generateMeetingSuggestions(memberSchedules) {
        const availabilityResults = document.getElementById('availabilityResults');
        const suggestedTimes = document.getElementById('suggestedTimes');
        const timeSlots = document.getElementById('timeSlots');
        
        // Define possible meeting times (business hours)
        const meetingDuration = 60; // 1 hour default
        const possibleTimes = [
            '09:00', '10:00', '11:00', '14:00', '15:00', '16:00'
        ];
        
        // Get next 7 days (excluding weekends for now)
        const suggestions = [];
        const today = new Date();
        
        for (let dayOffset = 1; dayOffset <= 14; dayOffset++) {
            const targetDate = new Date(today);
            targetDate.setDate(today.getDate() + dayOffset);
            
            // Skip weekends
            if (targetDate.getDay() === 0 || targetDate.getDay() === 6) {
                continue;
            }
            
            const dayName = targetDate.toLocaleDateString('en-US', { weekday: 'long' });
            const dateString = targetDate.toISOString().split('T')[0];
            
            possibleTimes.forEach(startTime => {
                const endTime = addMinutesToTime(startTime, meetingDuration);
                
                // Check if this time slot is available for all members
                const availability = analyzeTimeSlot(dateString, startTime, endTime, memberSchedules);
                
                if (suggestions.length < 6) { // Limit to 6 suggestions
                    suggestions.push({
                        date: dateString,
                        displayDate: targetDate.toLocaleDateString('en-US', { 
                            weekday: 'short', 
                            month: 'short', 
                            day: 'numeric' 
                        }),
                        startTime: startTime,
                        endTime: endTime,
                        available: availability.availableCount,
                        total: memberSchedules.length,
                        conflicts: availability.conflicts,
                        score: availability.availableCount / memberSchedules.length
                    });
                }
            });
        }
        
        // Sort by availability score (highest first)
        suggestions.sort((a, b) => b.score - a.score);
        
        // Display results
        if (suggestions.length > 0) {
            availabilityResults.innerHTML = '<i class="bi bi-lightbulb me-2 text-success"></i><strong>Found optimal meeting times!</strong>';
            availabilityResults.className = 'alert alert-success';
            
            // Render time slot suggestions
            renderTimeSuggestions(suggestions.slice(0, 6)); // Show top 6
            suggestedTimes.style.display = 'block';
        } else {
            availabilityResults.innerHTML = '<i class="bi bi-exclamation-triangle me-2 text-warning"></i><strong>No optimal times found in the next 2 weeks</strong>';
            availabilityResults.className = 'alert alert-warning';
        }
    }
    
    // Analyze a specific time slot with detailed conflict information
    function analyzeTimeSlotDetailed(date, startTime, endTime, memberSchedules, dayName) {
        let availableCount = 0;
        let conflicts = [];
        let totalMembers = memberSchedules.length;
        
        console.log(`Analyzing ${startTime}-${endTime} on ${dayName} for ${totalMembers} members`);
        
        memberSchedules.forEach(member => {
            let hasConflict = false;
            let memberConflicts = [];
            
            // Get this member's schedule for the specific day
            const daySchedule = member.schedule.filter(item => item.day === dayName);
            
            console.log(`${member.name} (${member.role}): ${daySchedule.length} schedule items on ${dayName}`);
            
            if (daySchedule.length === 0) {
                // Member has no schedule items for this day - completely free
                availableCount++;
                console.log(`  → ${member.name} is completely free`);
            } else {
                // Check each schedule item for conflicts
                daySchedule.forEach(scheduleItem => {
                    if (timesOverlap(startTime, endTime, scheduleItem.startTime, scheduleItem.endTime)) {
                        hasConflict = true;
                        memberConflicts.push({
                            title: scheduleItem.title,
                            time: `${scheduleItem.startTime}-${scheduleItem.endTime}`,
                            type: scheduleItem.type || 'Unknown'
                        });
                        console.log(`  → CONFLICT: ${scheduleItem.title} (${scheduleItem.startTime}-${scheduleItem.endTime})`);
                    } else {
                        console.log(`  → No conflict with: ${scheduleItem.title} (${scheduleItem.startTime}-${scheduleItem.endTime})`);
                    }
                });
                
                if (!hasConflict) {
                    // Member has schedule items but none conflict with our time slot
                    availableCount++;
                    console.log(`  → ${member.name} is available (no conflicts)`);
                } else {
                    // Add conflicts to the main conflicts array
                    conflicts.push({
                        member: member.name,
                        role: member.role,
                        conflicts: memberConflicts
                    });
                }
            }
        });
        
        const isCompletelyFree = availableCount === totalMembers;
        console.log(`Result: ${availableCount}/${totalMembers} available. Completely free: ${isCompletelyFree}`);
        
        return {
            availableCount: availableCount,
            totalMembers: totalMembers,
            conflicts: conflicts,
            isCompletelyFree: isCompletelyFree
        };
    }
    
    // Legacy function for backward compatibility
    function analyzeTimeSlot(date, startTime, endTime, memberSchedules) {
        const targetDate = new Date(date);
        const dayName = targetDate.toLocaleDateString('en-US', { weekday: 'long' });
        
        const detailed = analyzeTimeSlotDetailed(date, startTime, endTime, memberSchedules, dayName);
        
        // Convert detailed conflicts to simple format for backward compatibility
        const simpleConflicts = [];
        detailed.conflicts.forEach(memberConflict => {
            memberConflict.conflicts.forEach(conflict => {
                simpleConflicts.push({
                    member: memberConflict.member,
                    conflict: conflict.title
                });
            });
        });
        
        return {
            availableCount: detailed.availableCount,
            conflicts: simpleConflicts
        };
    }
    
    // Render time suggestions
    function renderTimeSuggestions(suggestions) {
        const timeSlots = document.getElementById('timeSlots');
        timeSlots.innerHTML = '';
        
        // Show only top 8 suggestions for the selected date
        const topSuggestions = suggestions.slice(0, 8);
        
        topSuggestions.forEach((suggestion, index) => {
            const timeCard = document.createElement('div');
            timeCard.className = 'time-suggestion-card';
            timeCard.setAttribute('data-date', suggestion.date);
            timeCard.setAttribute('data-start', suggestion.startTime);
            timeCard.setAttribute('data-end', suggestion.endTime);
            
            const scorePercentage = Math.round(suggestion.score * 100);
            const isCompletelyFree = suggestion.isCompletelyFree || scorePercentage === 100;
            
            let scoreClass = 'success';
            let cardClass = timeCard.className;
            let badgeText = `${scorePercentage}%`;
            let buttonClass = 'btn-outline-primary';
            
            if (isCompletelyFree) {
                scoreClass = 'success';
                cardClass += ' border-success';
                badgeText = 'FREE';
                buttonClass = 'btn-success';
            } else if (scorePercentage >= 70) {
                scoreClass = 'warning';
                cardClass += ' border-warning';
            } else {
                scoreClass = 'danger';
                cardClass += ' border-danger';
            }
            
            timeCard.className = cardClass;
            
            timeCard.innerHTML = `
                <div class="time-info">
                    <div class="fw-bold">${formatTime(suggestion.startTime)}</div>
                    <div class="text-muted small">${formatTime(suggestion.endTime)}</div>
                    ${isCompletelyFree ? '<div class="text-success small fw-bold">All members free!</div>' : ''}
                </div>
                <div class="availability-info mt-2">
                    <span class="badge bg-${scoreClass} mb-2">${badgeText}</span>
                    <div class="small text-muted">${suggestion.available}/${suggestion.total} available</div>
                    ${suggestion.conflicts && suggestion.conflicts.length > 0 ? `
                        <div class="conflicts mt-1">
                            <small class="text-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                ${suggestion.conflicts.length} conflict(s)
                            </small>
                        </div>
                    ` : ''}
                </div>
                <button class="btn ${buttonClass} btn-sm mt-2 w-100 use-time-btn">
                    <i class="bi bi-check-circle me-1"></i>
                    ${isCompletelyFree ? 'Select (Perfect!)' : 'Select'}
                </button>
            `;
            
            timeSlots.appendChild(timeCard);
        });
        
        // Add click handlers to use suggested times
        timeSlots.querySelectorAll('.use-time-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.time-suggestion-card');
                const startTime = card.dataset.start;
                const endTime = card.dataset.end;
                
                // Set the hidden form values
                document.getElementById('meetingStartTime').value = startTime;
                document.getElementById('meetingEndTime').value = endTime;
                
                // Check availability for this specific time
                analyzeAvailability(selectedDate, startTime, endTime, memberScheduleData);
                
                // Highlight the selected card
                timeSlots.querySelectorAll('.time-suggestion-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                
                showToast('Meeting time selected!', 'success');
            });
        });
    }
    
    // Add minutes to time string
    function addMinutesToTime(timeString, minutes) {
        const [hours, mins] = timeString.split(':').map(Number);
        const date = new Date();
        date.setHours(hours, mins, 0, 0);
        date.setMinutes(date.getMinutes() + minutes);
        
        return date.toTimeString().slice(0, 5);
    }
    
    // Analyze availability with detailed member breakdown
    function analyzeAvailability(date, startTime, endTime, memberSchedules) {
        const targetDate = new Date(date);
        const dayName = targetDate.toLocaleDateString('en-US', { weekday: 'long' });
        
        const availabilityResults = document.getElementById('availabilityResults');
        const memberSchedulesDiv = document.getElementById('memberSchedules');
        
        // Use the detailed analysis function
        const analysis = analyzeTimeSlotDetailed(date, startTime, endTime, memberSchedules, dayName);
        
        let availableMembers = [];
        let conflictingMembersDetails = [];
        
        // Build available members list
        memberSchedules.forEach(member => {
            const memberHasConflict = analysis.conflicts.some(conflict => conflict.member === member.name);
            if (!memberHasConflict) {
                availableMembers.push(member.name);
            }
        });
        
        // Build conflicting members details
        analysis.conflicts.forEach(memberConflict => {
            let conflictText = '';
            memberConflict.conflicts.forEach(conflict => {
                conflictText += `${conflict.title} (${formatTime(conflict.time.split('-')[0])} - ${formatTime(conflict.time.split('-')[1])}); `;
            });
            
            conflictingMembersDetails.push({
                name: memberConflict.member,
                role: memberConflict.role,
                conflicts: conflictText
            });
        });
        
        // Display results
        let resultHTML = '';
        if (analysis.isCompletelyFree) {
            resultHTML = '<i class="bi bi-check-circle me-2 text-success"></i><strong>Perfect! All team members are available!</strong>';
            availabilityResults.className = 'alert alert-success';
        } else if (analysis.availableCount > analysis.totalMembers * 0.7) {
            resultHTML = `<i class="bi bi-exclamation-triangle me-2 text-warning"></i><strong>Good availability: ${analysis.availableCount}/${analysis.totalMembers} members available</strong>`;
            availabilityResults.className = 'alert alert-warning';
        } else {
            resultHTML = `<i class="bi bi-x-circle me-2 text-danger"></i><strong>Limited availability: ${analysis.availableCount}/${analysis.totalMembers} members available</strong>`;
            availabilityResults.className = 'alert alert-danger';
        }
        
        availabilityResults.innerHTML = resultHTML;
        availabilityResults.style.display = 'block';
        
        // Show detailed schedule information
        let scheduleHTML = `
            <div class="mt-3">
                <h6>Detailed Availability for ${formatTime(startTime)} - ${formatTime(endTime)} on ${dayName}:</h6>
        `;
        
        // Available members
        if (availableMembers.length > 0) {
            scheduleHTML += `
                <div class="mb-3 p-2 bg-success bg-opacity-10 rounded">
                    <strong class="text-success">
                        <i class="bi bi-check-circle me-1"></i>Available Members (${availableMembers.length}):
                    </strong>
                    <div class="mt-1">${availableMembers.join(', ')}</div>
                </div>
            `;
        }
        
        // Conflicting members
        if (conflictingMembersDetails.length > 0) {
            scheduleHTML += `
                <div class="mb-3 p-2 bg-warning bg-opacity-10 rounded">
                    <strong class="text-warning">
                        <i class="bi bi-exclamation-triangle me-1"></i>Members with Conflicts (${conflictingMembersDetails.length}):
                    </strong>
                    <div class="mt-2">
            `;
            
            conflictingMembersDetails.forEach(member => {
                scheduleHTML += `
                    <div class="mb-2 border-start border-warning ps-2">
                        <strong>${member.name}</strong> <small class="text-muted">(${member.role})</small>
                        <div class="small text-muted">${member.conflicts}</div>
                    </div>
                `;
            });
            
            scheduleHTML += '</div></div>';
        }
        
        scheduleHTML += '</div>';
        memberSchedulesDiv.innerHTML = scheduleHTML;
        memberSchedulesDiv.style.display = 'block';
    }
    
    // Check if two time ranges overlap
    function timesOverlap(start1, end1, start2, end2) {
        return start1 < end2 && end1 > start2;
    }
    
    // Format time for display
    function formatTime(timeString) {
        try {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes} ${ampm}`;
        } catch (e) {
            return timeString;
        }
    }
    
    // Validate URL
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    
    // Save meeting
    function saveMeeting() {
        const title = document.getElementById('meetingTitle').value.trim();
        const date = document.getElementById('meetingDate').value;
        const startTime = document.getElementById('meetingStartTime').value;
        const endTime = document.getElementById('meetingEndTime').value;
        const description = document.getElementById('meetingDescription').value.trim();
        const meetingLink = document.getElementById('meetingLink').value.trim();
        
        if (!title || !date) {
            showToast('Please fill in the meeting title and select a date', 'warning');
            return;
        }
        
        if (!startTime || !endTime) {
            showToast('Please select a time slot from the suggestions', 'warning');
            return;
        }
        
        if (startTime >= endTime) {
            showToast('End time must be after start time', 'warning');
            return;
        }
        
        // Validate meeting link if provided
        if (meetingLink && !isValidUrl(meetingLink)) {
            showToast('Please enter a valid meeting link', 'warning');
            return;
        }
        
        const saveMeetingBtn = document.getElementById('saveMeetingBtn');
        const originalText = saveMeetingBtn.innerHTML;
        saveMeetingBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>Saving...';
        saveMeetingBtn.disabled = true;
        
        const meetingData = {
            projectId: projectId,
            title: title,
            date: date,
            startTime: startTime,
            endTime: endTime,
            description: description,
            meetingLink: meetingLink,
            type: 'Project Meeting'
        };
        
        // Construct proper URL for the API endpoint
        // If we're on a development server (port 3000), point to XAMPP on default port
        let apiUrl;
        if (window.location.port === '3000') {
            // Development server - point to XAMPP
            apiUrl = window.location.protocol + '//' + window.location.hostname + '/uiurp/src/model/save_project_meeting.php';
        } else {
            // Same server - use relative path with proper construction
            apiUrl = window.location.protocol + '//' + window.location.hostname + 
                    (window.location.port && window.location.port !== '80' && window.location.port !== '443' 
                     ? ':' + window.location.port : '') + 
                    window.location.pathname.replace(/\/[^\/]*$/, '') + '/src/model/save_project_meeting.php';
        }
        
        console.log('Making request to:', apiUrl);
        
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(meetingData),
            credentials: 'include'  // Include session cookies for cross-origin
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response OK:', response.ok);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.text().then(text => {
                console.log('Raw response text:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('JSON parse error:', e);
                    console.error('Response text that failed to parse:', text);
                    throw new Error('Invalid JSON response: ' + text.substring(0, 200) + '...');
                }
            });
        })
        .then(data => {
            console.log('Parsed response data:', data);
            if (data.success) {
                showToast('Meeting scheduled successfully!', 'success');
                
                // Check if the meeting was created for current time or soon, and refresh chat
                const meetingDate = document.getElementById('meetingDate').value;
                const startTime = document.getElementById('meetingStartTime').value;
                
                if (meetingDate && startTime) {
                    const meetingDateTime = new Date(`${meetingDate}T${startTime}:00`);
                    const currentDateTime = new Date();
                    const timeDifference = (meetingDateTime.getTime() - currentDateTime.getTime()) / (1000 * 60); // in minutes
                    
                    // If meeting is within the next 60 minutes, refresh chat to show system messages
                    if (timeDifference >= -5 && timeDifference <= 60) {
                        console.log('Meeting scheduled for soon, refreshing chat to show system messages');
                        
                        // Refresh chat messages after a short delay to allow system message to be sent
                        // Send additional real-time system message to chat (similar to timeline editor)
                        const title = document.getElementById('meetingTitle').value.trim();
                        const meetingLink = document.getElementById('meetingLink').value.trim();
                        sendMeetingSystemMessage(meetingDate, startTime, title, timeDifference, meetingLink)
                            .then(() => {
                                console.log('Real-time system message sent for meeting');
                            })
                            .catch(error => {
                                console.error('Error sending real-time system message:', error);
                            });
                        
                        setTimeout(() => {
                            // Check if chat overlay exists and is visible
                            const chatOverlay = document.getElementById('projectChatOverlay');
                            if (chatOverlay && chatOverlay.classList.contains('active')) {
                                // If chat is open, reload messages
                                if (typeof loadChatMessages === 'function') {
                                    loadChatMessages();
                                } else if (typeof window.loadChatMessages === 'function') {
                                    window.loadChatMessages();
                                }
                            }
                            
                            // Also trigger meeting notification refresh if available
                            if (typeof window.globalMeetingNotifications !== 'undefined' && 
                                window.globalMeetingNotifications.refreshNotifications) {
                                window.globalMeetingNotifications.refreshNotifications();
                            }
                        }, 2000); // 2 second delay to allow system message to be processed
                    }
                }
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('meetingModal'));
                modal.hide();
                
                // Reset form
                document.getElementById('meetingForm').reset();
                document.getElementById('availabilityResults').style.display = 'none';
                document.getElementById('memberSchedules').style.display = 'none';
                document.getElementById('timeSuggestionsContainer').style.display = 'none';
                document.getElementById('timeSuggestionsLoading').style.display = 'none';
                
                // Reload meetings
                loadProjectMeetings();
            } else {
                showToast(data.message || 'Error saving meeting', 'danger');
            }
        })
        .catch(error => {
            console.error('Error saving meeting:', error);
            showToast('Error saving meeting. Please try again.', 'danger');
        })
        .finally(() => {
            saveMeetingBtn.innerHTML = originalText;
            saveMeetingBtn.disabled = false;
        });
    }
    
    // Project-specific meeting notification integration
    function initializeProjectMeetingNotifications() {
        // Update the global notification system with this project's ID
        if (window.globalMeetingNotifications && projectId) {
            window.globalMeetingNotifications.setProjectId(projectId);
            console.log('Project meeting notifications initialized for project:', projectId);
        }
        
        // Listen for meeting notifications specific to this project
        document.addEventListener('meetingNotificationsProcessed', function(event) {
            const detail = event.detail;
            if (detail.projectId === projectId || !detail.projectId) {
                console.log('Project-specific meeting notifications processed:', detail);
                
                // Refresh chat messages to show new system messages
                if (typeof loadChatMessages === 'function') {
                    setTimeout(() => {
                        loadChatMessages();
                    }, 1000);
                }
            }
        });
    }
    
    // Initialize meeting feature when project is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Wait for project to be loaded, then initialize meetings
        setTimeout(() => {
            if (projectId) {
                initializeMeetingFeature();
                initializeProjectMeetingNotifications();
            }
        }, 1000);
    });
    </script>
    
    <!-- Include Global Meeting Notifications -->
    <?php include 'src/includes/global-meeting-notifications.php'; ?>
    
</body>
</html> 