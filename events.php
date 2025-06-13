<?php
// Start session and error handling
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include autoloader for MongoDB
require __DIR__ . '/vendor/autoload.php';

// MongoDB connection function
function connectToMongoDB() {
    try {
        $mongoClient = new MongoDB\Client("mongodb+srv://uiurp:uiurp12345@uiurp.fluqo.mongodb.net/uiurp?retryWrites=true&w=majority");
        return $mongoClient->uiurp;
    } catch (Exception $e) {
        error_log("MongoDB connection failed:  " . $e->getMessage());
        return null;
    }
}

// Fetch events from MongoDB
function getEventsFromMongoDB() {
    $db = connectToMongoDB();
    if (!$db) {
        return [];
    }
    
    try {
        $collection = $db->events;
        $cursor = $collection->find([], ['sort' => ['eventDate' => 1]]);
        $events = [];
        
        foreach ($cursor as $event) {
            // Convert MongoDB document to array properly
            $eventArray = json_decode(json_encode($event), true);
            
            // Ensure _id is properly formatted
            if (isset($eventArray['_id']['$oid'])) {
                // Store both formats for compatibility
                $eventArray['_id_string'] = $eventArray['_id']['$oid'];
            } else {
                // If not in expected format, convert to string
                $eventArray['_id_string'] = (string)$eventArray['_id'];
            }
            
            // Helper function to convert MongoDB date
            $convertDate = function($dateValue) {
                if (is_array($dateValue) && isset($dateValue['$date'])) {
                    if (is_array($dateValue['$date']) && isset($dateValue['$date']['$numberLong'])) {
                        return date('Y-m-d\TH:i:s\Z', intval($dateValue['$date']['$numberLong']) / 1000);
                    } elseif (is_numeric($dateValue['$date'])) {
                        return date('Y-m-d\TH:i:s\Z', $dateValue['$date'] / 1000);
                    }
                }
                return $dateValue; // Return as-is if not a MongoDB date
            };
            
            // Convert MongoDB UTCDateTime objects to readable dates
            if (isset($eventArray['eventDate'])) {
                $eventArray['eventDate'] = $convertDate($eventArray['eventDate']);
            }
            if (isset($eventArray['createdAt'])) {
                $eventArray['createdAt'] = $convertDate($eventArray['createdAt']);
            }
            if (isset($eventArray['updatedAt'])) {
                $eventArray['updatedAt'] = $convertDate($eventArray['updatedAt']);
            }
            if (isset($eventArray['registration']['deadline'])) {
                $eventArray['registration']['deadline'] = $convertDate($eventArray['registration']['deadline']);
            }
            
            $events[] = $eventArray;
        }
        
        return $events;
    } catch (Exception $e) {
        error_log("Error fetching events: " . $e->getMessage());
        return [];
    }
}

// Get events data
$events = getEventsFromMongoDB();

// Handle filtering
$filteredEvents = $events;
$searchTerm = $_GET['search'] ?? '';
$eventType = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';

if ($searchTerm || $eventType || $status) {
    $filteredEvents = array_filter($events, function($event) use ($searchTerm, $eventType, $status) {
        $matchesSearch = !$searchTerm || 
            stripos($event['title'], $searchTerm) !== false || 
            stripos($event['description'], $searchTerm) !== false;
        
        $matchesType = !$eventType || $event['eventType'] === $eventType;
        $matchesStatus = !$status || $event['status'] === $status;
        
        return $matchesSearch && $matchesType && $matchesStatus;
    });
}

// Get unique event types and statuses for filters
$eventTypes = array_unique(array_column($events, 'eventType'));
$statuses = array_unique(array_column($events, 'status'));

// Function to check if the current user is the creator of an event
function isEventCreator($event) {
    // If user is not logged in, they can't be the creator
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    // Check if the event has a createdBy field and if it matches the current user's ID
    return isset($event['createdBy']) && $event['createdBy'] === $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Events - UIU Research Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Modern Futuristic Color Scheme */
            --primary-gradient: linear-gradient(135deg, #4c9af1 0%, #7209b7 100%);
            --secondary-gradient: linear-gradient(135deg, #f72585 0%, #4cc9f0 100%);
            --neo-primary: #4361ee;
            --neo-secondary: #3a0ca3;
            --neo-accent: #7209b7;
            --neo-blue: #4cc9f0;
            --neo-magenta: #f72585;
            --neo-light: #f8f9fa;
            --neo-dark: #121729;
            
            /* Theme Variables - Dark Mode (Default) */
            --bg-primary: #0a1121;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --bg-card: rgba(30, 41, 59, 0.8);
            --bg-glass: rgba(255, 255, 255, 0.1);
            --border-glass: rgba(255, 255, 255, 0.2);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --border-color: rgba(76, 201, 240, 0.1);
            --shadow-color: rgba(0, 0, 0, 0.3);
        }

        /* Light Theme Variables */
        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --bg-secondary: #e2e8f0;
            --bg-tertiary: #cbd5e1;
            --bg-card: rgba(255, 255, 255, 0.9);
            --bg-glass: rgba(255, 255, 255, 0.8);
            --border-glass: rgba(67, 97, 238, 0.2);
            --text-primary: #1e293b;
            --text-secondary: rgba(30, 41, 59, 0.8);
            --text-muted: rgba(30, 41, 59, 0.6);
            --border-color: rgba(67, 97, 238, 0.15);
            --shadow-color: rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .main-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            position: relative;
            padding-bottom: 100px; /* Space for footer */
        }

        /* Background Elements */
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(114, 9, 183, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(247, 37, 133, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(76, 201, 240, 0.1) 0%, transparent 50%);
            z-index: -2;
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: var(--neo-blue);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .particle:nth-child(1) { width: 2px; height: 2px; top: 20%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 3px; height: 3px; top: 60%; left: 70%; animation-delay: 5s; }
        .particle:nth-child(3) { width: 1px; height: 1px; top: 80%; left: 20%; animation-delay: 10s; }
        .particle:nth-child(4) { width: 4px; height: 4px; top: 40%; left: 90%; animation-delay: 15s; }
        .particle:nth-child(5) { width: 2px; height: 2px; top: 30%; left: 30%; animation-delay: 7s; }
        .particle:nth-child(6) { width: 3px; height: 3px; top: 70%; left: 60%; animation-delay: 12s; }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0px) rotate(360deg); }
        }

        /* Header Section */
        .page-header {
            padding: 8rem 0 5rem;
            text-align: center;
            position: relative;
            margin-top: 75px;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200px;
            background: var(--primary-gradient);
            top: -150px;
            left: -50%;
            transform: rotate(-2deg);
            opacity: 0.05;
            z-index: 0;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: var(--neo-blue);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 2rem auto 2rem;
            position: relative;
        }

        /* Filter Section */
        .filter-section {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 10px 30px var(--shadow-color);
        }

        .filter-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(76, 201, 240, 0.15);
            border-color: rgba(76, 201, 240, 0.3);
        }
        
        .filter-section form {
            width: 100%;
        }
        
        /* Filter Header */
        .filter-header {
            text-align: center;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .filter-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
        
        .filter-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        /* Filter Groups and Inputs */
        .filter-group {
            border-radius: 12px;
            overflow: hidden;
            background: var(--bg-glass);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 52px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        
        .filter-group:hover, .filter-group:focus-within {
            border-color: var(--neo-blue);
            box-shadow: 0 8px 15px rgba(76, 201, 240, 0.1);
            transform: translateY(-2px);
        }
        
        .filter-input, .filter-select {
            background: transparent;
            border: none;
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            height: 50px;
        }
        
        .input-group-text {
            background: transparent;
            border: none;
            color: var(--neo-blue);
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
        }
        
        .filter-input:focus, 
        .filter-select:focus {
            outline: none;
            box-shadow: none;
            background: transparent;
        }
        
        .filter-input::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }
        
        .filter-select option {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        /* Filter Buttons */
        .filter-btn {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            overflow: hidden;
            position: relative;
            z-index: 1;
            color: white;
            height: 52px;
            box-shadow: 0 4px 12px rgba(76, 201, 240, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .create-btn {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            overflow: hidden;
            position: relative;
            z-index: 1;
            color: white;
            height: 52px;
            box-shadow: 0 4px 12px rgba(247, 37, 133, 0.15);
            flex-shrink: 0;
            width: auto;
            min-width: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .filter-btn::before, .create-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
            z-index: -1;
        }

        .filter-btn:hover::before, .create-btn:hover::before {
            left: 100%;
        }

        .filter-btn:hover, .create-btn:hover {
            transform: translateY(-2px);
        }
        
        .filter-btn:hover {
            box-shadow: 0 10px 25px rgba(76, 201, 240, 0.3);
        }
        
        .create-btn:hover {
            box-shadow: 0 10px 25px rgba(247, 37, 133, 0.3);
        }

        .filter-btn i, .create-btn i {
            transition: transform 0.3s ease;
        }

        .filter-btn:hover i, .create-btn:hover i {
            transform: scale(1.2);
        }
        
        /* Active Filters */
        .active-filters {
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            margin-top: 1.5rem;
        }
        
        .active-filter-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .active-filter-badge {
            display: inline-flex;
            align-items: center;
            background: var(--bg-glass);
            border: 1px solid var(--neo-blue);
            color: var(--neo-blue);
            border-radius: 50px;
            padding: 0.3rem 0.8rem;
            margin: 0 0.5rem 0.5rem 0;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .active-filter-badge:hover {
            background: rgba(76, 201, 240, 0.1);
        }
        
        .filter-remove {
            margin-left: 0.4rem;
            color: var(--neo-blue);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .filter-remove:hover {
            transform: scale(1.2);
        }
        
        .active-filter-clear {
            color: var(--text-muted);
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .active-filter-clear:hover {
            color: #dc3545;
        }
        
        @media (max-width: 576px) {
            .create-btn {
                padding: 0;
                width: 52px;
                min-width: 52px;
            }
            
            .create-btn i {
                margin-right: 0 !important;
            }
            
            .active-filters {
                text-align: center;
            }
            
            .filter-section {
                padding: 1.5rem;
            }
            
            .filter-header {
                margin-bottom: 1rem;
            }
        }
        
        /* Media queries for responsive filters */
        @media (max-width: 991px) {
            .filter-btn, .create-btn {
                margin-top: 0.5rem;
            }
        }

        /* Event Cards */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
            position: relative;
            z-index: 1;
        }

        .event-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
            height: 630px;
            display: flex;
            flex-direction: column;
            padding: 0;
            box-shadow: 0 10px 30px var(--shadow-color);
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
            z-index: 1;
            transition: height 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(76, 201, 240, 0.2);
            border-color: var(--neo-blue);
        }

        .event-card:hover::before {
            height: 6px;
        }

        .card-header {
            padding: 2rem 2rem 1rem;
            flex-shrink: 0;
            position: relative;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 10%;
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-color), transparent);
        }

        .card-scroll-content {
            flex: 1;
            overflow-y: auto;
            padding: 0 2rem;
            display: flex;
            flex-direction: column;
            scrollbar-width: thin;
            scrollbar-color: rgba(76, 201, 240, 0.3) var(--bg-glass);
        }

        .card-footer {
            padding: 1.5rem 2rem 2rem;
            border-top: 1px solid var(--border-color);
            background-color: rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
            width: 100%;
        }

        [data-theme="light"] .card-footer {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
        }

        .event-title-container {
            flex: 1;
            padding-right: 15px;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 1.4rem;
            max-height: 4.2rem;
            width: 100%;
            word-break: break-word;
        }

        .event-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .status-scheduled {
            background: rgba(76, 201, 240, 0.2);
            color: var(--neo-blue);
            border: 1px solid rgba(76, 201, 240, 0.3);
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-cancelled {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .event-type {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            background: var(--secondary-gradient);
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0;
        }

        .event-content {
            margin-top: 1.5rem; /* Add margin to create space after header */
        }

        .event-description {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.6;
            width: 100%;
            word-break: break-word;
        }

        .event-details {
            display: grid;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .event-detail {
            display: flex;
            align-items: flex-start;
            color: var(--text-secondary);
            font-size: 0.9rem;
            width: 100%;
        }

        .event-detail i {
            margin-right: 0.75rem;
            color: var(--neo-blue);
            font-size: 1rem;
            width: 1rem;
            text-align: center;
            flex-shrink: 0;
            margin-top: 0.2rem;
        }

        .event-detail-text {
            flex: 1;
            word-break: break-word;
        }

        .speakers-section {
            margin-top: 1rem;
            margin-bottom: 1rem;
            width: 100%;
        }

        .speakers-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .speakers-container {
            width: 100%;
        }

        .speaker-item {
            background: var(--bg-glass);
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            word-break: break-word;
        }

        .speaker-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .speaker-affiliation {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .speaker-topic {
            color: var(--neo-blue);
            font-size: 0.8rem;
            font-style: italic;
        }

        .no-speakers {
            color: var(--text-muted);
            font-size: 0.9rem;
            font-style: italic;
            padding: 1rem 0;
        }

        .event-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            width: 100%;
        }

        .btn-row {
            display: flex;
            gap: 1rem;
            width: 100%;
            flex-wrap: wrap;
        }

        .btn-primary, .btn-outline {
            flex: 1;
            min-width: 120px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            padding: 0.6rem 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76, 201, 240, 0.3);
            color: white;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--neo-blue);
            color: var(--neo-blue);
        }

        .btn-outline:hover {
            background: var(--neo-blue);
            color: white;
        }

        .btn-disabled {
            background: var(--bg-glass);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .btn-disabled:hover {
            transform: none;
            box-shadow: none;
        }

        .registration-info {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 0.5rem;
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Custom scrollbar for the entire card content */
        .card-scroll-content::-webkit-scrollbar {
            width: 4px;
        }

        .card-scroll-content::-webkit-scrollbar-track {
            background: var(--bg-glass);
            border-radius: 10px;
        }

        .card-scroll-content::-webkit-scrollbar-thumb {
            background: rgba(76, 201, 240, 0.3);
            border-radius: 10px;
        }

        .card-scroll-content::-webkit-scrollbar-thumb:hover {
            background: rgba(76, 201, 240, 0.5);
        }

        /* No Events Message */
        .no-events {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
            animation: fadeIn 1s ease-out;
        }

        .no-events i {
            font-size: 4rem;
            color: var(--neo-blue);
            margin-bottom: 1rem;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Page Animation */
        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        .slide-up {
            animation: slideUp 0.8s cubic-bezier(0.23, 1, 0.32, 1);
        }
        
        /* Event action buttons */
        .event-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .event-action-btn i {
            font-size: 0.9rem;
        }
        
        .edit-btn {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            color: #ffc107;
        }
        
        .edit-btn:hover {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            transform: scale(1.1);
        }
        
        .delete-btn {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #dc3545;
        }
        
        .delete-btn:hover {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            transform: scale(1.1);
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Ripple Animation for Buttons */
        .ripple {
            position: relative;
            overflow: hidden;
        }

        .ripple:after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }

        .ripple:active:after {
            transform: scale(0, 0);
            opacity: .3;
            transition: 0s;
        }

        /* Hover Glow Effect */
        .glow-on-hover {
            transition: all 0.3s ease;
        }

        .glow-on-hover:hover {
            box-shadow: 0 0 15px rgba(76, 201, 240, 0.5);
        }

        /* Custom scrollbar styles */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-glass);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(76, 201, 240, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(76, 201, 240, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .filter-row {
                flex-direction: column;
            }
            
            .event-card {
                height: auto;
                min-height: 600px;
            }
            
            .btn-row {
                flex-direction: column;
            }
            
            .btn-primary, .btn-outline {
                width: 100%;
            }
        }

        /* Page loader animation */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .loader-hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-circle {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-top-color: var(--neo-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-gradient);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 5px 15px var(--shadow-color);
        }

        .back-to-top.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Filter animations and effects */
        .filter-section {
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            opacity: 0.95;
            transform: translateY(10px);
        }
        
        .filter-section.filter-visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .filter-section.submitting {
            transform: scale(0.99);
            opacity: 0.8;
        }
        
        .filter-group.focused {
            border-color: var(--neo-blue);
            box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.15);
        }
        
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
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
        
        .active-filter-badge {
            transform: translateY(0);
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }
        
        .active-filter-badge.badge-hover {
            transform: translateY(-3px);
            box-shadow: 0 3px 10px rgba(76, 201, 240, 0.2);
        }
        
        .active-filter-clear {
            display: inline-flex;
            align-items: center;
        }
        
        .active-filter-clear i {
            transition: transform 0.3s ease;
        }
        
        .active-filter-clear:hover i {
            transform: rotate(90deg);
        }

        /* Alert styling enhancements */
        .alert-success {
            position: relative;
            overflow: hidden;
            background: rgba(25, 135, 84, 0.15);
            border: 1px solid rgba(25, 135, 84, 0.3);
            color: #198754;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            z-index: 1050;
        }
        
        [data-theme="light"] .alert-success {
            background: rgba(25, 135, 84, 0.08);
            border: 1px solid rgba(25, 135, 84, 0.2);
        }
        
        .alert-countdown {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(25, 135, 84, 0.5);
            width: 100%;
            animation: countdown 5s linear forwards;
            z-index: 1;
        }
        
        @keyframes countdown {
            from { width: 100%; }
            to { width: 0%; }
        }
        
        .alert-dismissible {
            padding-right: 3rem;
        }
        
        .alert-dismissible .btn-close {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 1rem;
            padding: 0.5rem;
            opacity: 0.5;
            transition: all 0.2s ease;
        }
        
        .alert-dismissible .btn-close:hover {
            opacity: 1;
            transform: translateY(-50%) rotate(90deg);
        }
        
        .alert-success i {
            color: #198754;
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
    </style>
    
    <!-- Theme detector script - Must run before page rendering -->
    <script>
        (function() {
            // Get saved theme immediately to prevent flash
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        })();
    </script>
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader">
        <div class="loader-circle"></div>
    </div>

    <!-- Background Elements -->
    <div class="bg-gradient"></div>
    <div class="floating-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="main-container">
        <?php
        // Include navbar
        $navbar_path = 'src/includes/navbar.php';
        if (file_exists($navbar_path)) {
            include $navbar_path;
        } else {
            // Fallback navbar
            echo '<nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="index.php">UIU Research Portal</a>
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" href="index.php">Home</a>
                        <a class="nav-link" href="Research_page.php">Projects</a>
                        <a class="nav-link" href="Faculty_Page.php">Faculty</a>
                        <a class="nav-link active" href="events.php">Events</a>
                        <a class="nav-link" href="forum_index.php">Forum</a>
                    </div>
                </div>
            </nav>';
        }
        ?>

        <!-- Page Header -->
        <section class="page-header">
            <div class="container fade-in">
                <h1 class="page-title" data-aos="fade-up">University Events</h1>
                <p class="page-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Discover upcoming conferences, seminars, workshops, and academic events at UIU
                </p>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="container">
            <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'true'): ?>
            <div class="alert alert-success mb-4 fade-in alert-dismissible" role="alert" data-aos="fade-up">
                <i class="bi bi-check-circle-fill me-2"></i> Event has been deleted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="alert-countdown"></div>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['created']) && $_GET['created'] === 'true'): ?>
            <div class="alert alert-success mb-4 fade-in alert-dismissible" role="alert" data-aos="fade-up">
                <i class="bi bi-check-circle-fill me-2"></i> Event has been created successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="alert-countdown"></div>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['updated']) && $_GET['updated'] === 'true'): ?>
            <div class="alert alert-success mb-4 fade-in alert-dismissible" role="alert" data-aos="fade-up">
                <i class="bi bi-check-circle-fill me-2"></i> Event has been updated successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="alert-countdown"></div>
            </div>
            <?php endif; ?>
            
            <div class="filter-section slide-up" data-aos="fade-up" data-aos-delay="200">
                <div class="filter-header mb-3">
                    <h4 class="filter-title">Find Events</h4>
                    <p class="filter-subtitle">Use filters to find events that match your interests</p>
                </div>
                
                <form method="GET" action="">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-4 col-md-6">
                            <div class="input-group filter-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="search" 
                                    class="form-control filter-input" 
                                    placeholder="Search events by title or description..." 
                                    value="<?= htmlspecialchars($searchTerm) ?>"
                                >
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="input-group filter-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <select name="type" class="form-control filter-select">
                                    <option value="">All Event Types</option>
                                    <?php foreach ($eventTypes as $type): ?>
                                        <option value="<?= htmlspecialchars($type) ?>" <?= $eventType === $type ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($type) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-2 col-md-6">
                            <div class="input-group filter-group">
                                <span class="input-group-text">
                                    <i class="bi bi-flag"></i>
                                </span>
                                <select name="status" class="form-control filter-select">
                                    <option value="">All Statuses</option>
                                    <?php foreach ($statuses as $statusOption): ?>
                                        <option value="<?= htmlspecialchars($statusOption) ?>" <?= $status === $statusOption ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($statusOption) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6 d-flex">
                            <button type="submit" class="filter-btn ripple me-2 flex-grow-1">
                                <i class="bi bi-funnel me-2"></i>Apply Filters
                            </button>
                            <a href="create_event.php" class="create-btn ripple" title="Create New Event">
                                <i class="bi bi-plus-lg me-md-2"></i>
                                <span class="d-none d-sm-inline">Create Event</span>
                            </a>
                        </div>
                    </div>
                    
                    <?php if ($searchTerm || $eventType || $status): ?>
                    <div class="active-filters mt-3">
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="active-filter-label me-2">Active filters:</span>
                            
                            <?php if ($searchTerm): ?>
                            <span class="active-filter-badge">
                                <i class="bi bi-search me-1"></i>
                                "<?= htmlspecialchars($searchTerm) ?>"
                                <a href="?<?= http_build_query(array_merge($_GET, ['search' => ''])) ?>" class="filter-remove">
                                    <i class="bi bi-x"></i>
                                </a>
                            </span>
                            <?php endif; ?>
                            
                            <?php if ($eventType): ?>
                            <span class="active-filter-badge">
                                <i class="bi bi-tag me-1"></i>
                                <?= htmlspecialchars($eventType) ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['type' => ''])) ?>" class="filter-remove">
                                    <i class="bi bi-x"></i>
                                </a>
                            </span>
                            <?php endif; ?>
                            
                            <?php if ($status): ?>
                            <span class="active-filter-badge">
                                <i class="bi bi-flag me-1"></i>
                                <?= htmlspecialchars($status) ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['status' => ''])) ?>" class="filter-remove">
                                    <i class="bi bi-x"></i>
                                </a>
                            </span>
                            <?php endif; ?>
                            
                            <a href="events.php" class="active-filter-clear ms-2">
                                <i class="bi bi-trash me-1"></i>Clear all
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </section>

        <!-- Events Grid -->
        <section class="container" id="events-container">
            <?php if (empty($filteredEvents)): ?>
                <div class="no-events" data-aos="fade-up">
                    <i class="bi bi-calendar-x"></i>
                    <h3>No Events Found</h3>
                    <p>No events match your current filters. Try adjusting your search criteria.</p>
                </div>
            <?php else: ?>
                <div class="events-grid">
                    <?php foreach ($filteredEvents as $index => $event): 
                        $eventDate = new DateTime($event['eventDate']);
                        $registrationDeadline = !empty($event['registration']['deadline']) 
                            ? new DateTime($event['registration']['deadline']) 
                            : null;
                        
                        // Determine button states
                        $hasRegistration = $event['registration']['required'] && !empty($event['registration']['link']);
                        $hasJoinLink = $event['location']['type'] === 'Virtual' && !empty($event['location']['joinLink']);
                    ?>
                        <div class="event-card" data-aos="fade-up" data-aos-delay="<?= 50 + ($index * 50) ?>">
                            <!-- Card Header -->
                            <div class="card-header">
                                <div class="event-header">
                                    <div class="event-title-container">
                                        <h3 class="event-title"><?= htmlspecialchars($event['title']) ?></h3>
                                        <div class="d-flex align-items-center">
                                            <span class="event-type me-2"><?= htmlspecialchars($event['eventType']) ?></span>
                                            <?php if (isEventCreator($event) || isset($_SESSION['admin'])): ?>
                                                <a href="edit_event.php?id=<?= $event['_id_string'] ?? $event['_id'] ?>" class="event-action-btn edit-btn me-1" title="Edit Event">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="#" class="event-action-btn delete-btn" title="Delete Event" 
                                                   data-bs-toggle="modal" data-bs-target="#deleteModal<?= $event['_id_string'] ?? $event['_id'] ?>">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <span class="event-status status-<?= strtolower($event['status']) ?>">
                                        <?= htmlspecialchars($event['status']) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Scrollable Content Area -->
                            <div class="card-scroll-content">
                                <div class="event-content">
                                    <p class="event-description">
                                        <?= htmlspecialchars($event['description']) ?>
                                    </p>

                                    <div class="event-details">
                                        <div class="event-detail">
                                            <i class="bi bi-calendar-event"></i>
                                            <span class="event-detail-text"><?= $eventDate->format('F j, Y') ?></span>
                                        </div>
                                        <div class="event-detail">
                                            <i class="bi bi-clock"></i>
                                            <span class="event-detail-text"><?= htmlspecialchars($event['startTime']) ?> - <?= htmlspecialchars($event['endTime']) ?> (<?= htmlspecialchars($event['timeZone']) ?>)</span>
                                        </div>
                                        <div class="event-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span class="event-detail-text">
                                                <?php if ($event['location']['type'] === 'Virtual'): ?>
                                                    Virtual - <?= htmlspecialchars($event['location']['virtualPlatform'] ?? 'Online') ?>
                                                <?php elseif ($event['location']['type'] === 'Physical'): ?>
                                                    <?= htmlspecialchars($event['location']['room'] ?? 'On Campus') ?>
                                                <?php else: ?>
                                                    Hybrid - <?= htmlspecialchars($event['location']['room'] ?? 'Multiple Locations') ?>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="event-detail">
                                            <i class="bi bi-building"></i>
                                            <span class="event-detail-text"><?= htmlspecialchars($event['organizer']) ?></span>
                                        </div>
                                    </div>

                                    <div class="speakers-section">
                                        <div class="speakers-title">Featured Speakers:</div>
                                        <div class="speakers-container">
                                            <?php if (!empty($event['speakers'])): ?>
                                                <?php foreach ($event['speakers'] as $speaker): ?>
                                                    <div class="speaker-item">
                                                        <div class="speaker-name"><?= htmlspecialchars($speaker['name']) ?></div>
                                                        <div class="speaker-affiliation"><?= htmlspecialchars($speaker['affiliation']) ?></div>
                                                        <?php if (!empty($speaker['topic'])): ?>
                                                            <div class="speaker-topic"><?= htmlspecialchars($speaker['topic']) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="no-speakers">No featured speakers for this event</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Footer -->
                            <div class="card-footer">
                                <div class="event-actions">
                                    <div class="btn-row">
                                        <?php if ($hasRegistration): ?>
                                            <a href="<?= htmlspecialchars($event['registration']['link']) ?>" 
                                               target="_blank" 
                                               class="btn-primary ripple">
                                                <i class="bi bi-calendar-plus me-2"></i>Register
                                            </a>
                                        <?php elseif ($hasJoinLink): ?>
                                            <a href="<?= htmlspecialchars($event['location']['joinLink']) ?>" 
                                               target="_blank" 
                                               class="btn-primary ripple">
                                                <i class="bi bi-camera-video me-2"></i>Join Event
                                            </a>
                                        <?php else: ?>
                                            <span class="btn-primary btn-disabled">
                                                <i class="bi bi-calendar-x me-2"></i>No Registration
                                            </span>
                                        <?php endif; ?>
                                        
                                        <a href="#" class="btn-outline ripple">
                                            <i class="bi bi-info-circle me-2"></i>Details
                                        </a>
                                    </div>
                                    
                                    <div class="registration-info">
                                        <?php if ($registrationDeadline): ?>
                                            Registration deadline: <?= $registrationDeadline->format('M j, Y') ?>
                                        <?php else: ?>
                                            &nbsp; <!-- Empty space to maintain consistent height -->
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Back to Top Button -->
        <div class="back-to-top" id="backToTop">
            <i class="bi bi-arrow-up"></i>
        </div>
    </div>

    <?php
    // Include footer
    $footer_path = 'src/includes/footer.php';
    if (file_exists($footer_path)) {
        include $footer_path;
    }
    ?>
    
    <!-- Delete Modals -->
    <?php foreach ($filteredEvents as $event): 
        $eventId = $event['_id_string'] ?? $event['_id'];
    ?>
    <div class="modal fade" id="deleteModal<?= $eventId ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $eventId ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: var(--bg-card); border-color: var(--border-glass); border-radius: 15px;">
                <div class="modal-header" style="border-bottom-color: var(--border-glass);">
                    <h5 class="modal-title" id="deleteModalLabel<?= $eventId ?>" style="color: var(--text-primary);">Confirm Event Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>
                <div class="modal-body" style="color: var(--text-secondary);">
                    <p class="mb-2">Are you sure you want to delete this event?</p>
                    <p class="mb-0"><strong><?= htmlspecialchars($event['title']) ?></strong></p>
                    <p class="mt-3 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>This action cannot be undone.</p>
                </div>
                <div class="modal-footer" style="border-top-color: var(--border-glass);">
                    <form method="POST" action="edit_event.php">
                        <input type="hidden" name="event_id" value="<?= $eventId ?>">
                        <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete_event" class="btn btn-cancel" style="background: rgba(220, 53, 69, 0.1); border-color: #dc3545; color: #dc3545;">
                            <i class="bi bi-trash me-2"></i>Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Page loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelector('.page-loader').classList.add('loader-hidden');
            }, 500);
        });
        
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });

        // Auto-hide alert messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-success');
            
            if (alerts.length > 0) {
                alerts.forEach(alert => {
                    // Add transition for smooth fade-out
                    alert.style.transition = 'opacity 0.7s ease, transform 0.7s ease';
                    
                    // Auto-dismiss timer
                    setTimeout(() => {
                        // Start fade out with slight upward movement
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-15px)';
                        
                        // Remove from DOM after fade completes
                        setTimeout(() => {
                            // Use Bootstrap's alert dismiss if available
                            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                            if (bsAlert) {
                                bsAlert.close();
                            } else {
                                alert.remove();
                            }
                        }, 700);
                    }, 5000);
                    
                    // Add click handler for manual close with animation
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function() {
                            alert.style.opacity = '0';
                            alert.style.transform = 'translateY(-15px)';
                            
                            setTimeout(() => {
                                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                                if (bsAlert) {
                                    bsAlert.close();
                                } else {
                                    alert.remove();
                                }
                            }, 700);
                        });
                    }
                });
            }
            
            // Remove alerts from URL parameters after loading
            if (window.history.replaceState && (
                window.location.href.includes('deleted=true') || 
                window.location.href.includes('updated=true') || 
                window.location.href.includes('created=true')
            )) {
                const cleanUrl = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, cleanUrl);
            }
        });

        // Auto-submit form on filter change
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                let filterContainer = this.closest('.filter-section');
                if (filterContainer) {
                    filterContainer.classList.add('submitting');
                }
                setTimeout(() => {
                    this.closest('form').submit();
                }, 300);
            });
        });
        
        // Filter input focus effects
        document.querySelectorAll('.filter-input, .filter-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.filter-group').classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.closest('.filter-group').classList.remove('focused');
            });
        });
        
        // Add ripple effect to filter buttons
        document.querySelectorAll('.ripple').forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - this.getBoundingClientRect().left;
                const y = e.clientY - this.getBoundingClientRect().top;
                
                const rippleEffect = document.createElement('span');
                rippleEffect.classList.add('ripple-effect');
                rippleEffect.style.left = x + 'px';
                rippleEffect.style.top = y + 'px';
                
                this.appendChild(rippleEffect);
                
                setTimeout(() => {
                    rippleEffect.remove();
                }, 600);
            });
        });
        
        // Back to top button functionality
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Staggered card animation on scroll
        const eventCards = document.querySelectorAll('.event-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        eventCards.forEach(card => {
            card.classList.add('fade-in');
            observer.observe(card);
        });
        
        // Add animation for filter section on page load
        document.addEventListener('DOMContentLoaded', () => {
            const filterSection = document.querySelector('.filter-section');
            if (filterSection) {
                setTimeout(() => {
                    filterSection.classList.add('filter-visible');
                }, 300);
            }
            
            // Handle filter badge animations
            document.querySelectorAll('.active-filter-badge').forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.classList.add('badge-hover');
                });
                
                badge.addEventListener('mouseleave', function() {
                    this.classList.remove('badge-hover');
                });
            });
        });

        // Listen for theme changes from navbar
        document.addEventListener('themeChanged', function(e) {
            console.log('Theme changed to:', e.detail.theme);
            AOS.refresh();
        });
    </script>
</body>
</html> 