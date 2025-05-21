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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0b5ed7;
            --secondary-color: #6610f2;
            --accent-color: #fd7e14;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --transition-speed: 0.3s;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --card-shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.15);
            --border-radius: 16px;
            --spacing-sm: 10px;
            --spacing-md: 20px;
            --spacing-lg: 30px;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            color: #495057;
            line-height: 1.7;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            color: #343a40;
            letter-spacing: -0.02em;
        }
        
        .project-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--border-radius);
            padding: calc(var(--spacing-lg) * 1.5);
            margin-bottom: var(--spacing-lg);
            border-left: 5px solid var(--primary-color);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }
        
        .project-header:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        
        .project-header:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(var(--primary-color-rgb, 13, 110, 253), 0.08) 0%, rgba(var(--secondary-color-rgb, 102, 16, 242), 0.05) 100%);
            z-index: 0;
        }
        
        .project-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(120deg, #000000, #333333);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        
        .project-header .meta-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        
        .project-header .meta-item i {
            color: var(--primary-color);
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .project-header .status-badge {
            position: relative;
            z-index: 1;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            margin-right: 0.75rem;
        }
        
        .project-header .status-badge i {
            margin-right: 0.5rem;
        }
        
        .project-header .privacy-toggle {
            border-radius: 50px;
            font-weight: 500;
            padding: 0.4rem 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .project-header .privacy-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        
        .project-header .privacy-toggle i {
            margin-right: 0.5rem;
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
            border-left: 4px solid var(--primary-color);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-md);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
        }
        
        .metadata-card:hover {
            box-shadow: var(--card-shadow-hover);
        }
        
        .abstract-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            font-style: italic;
            box-shadow: var(--card-shadow);
            border-left: 5px solid var(--secondary-color);
            line-height: 1.8;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }
        
        .abstract-box:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-5px);
        }
        
        .abstract-box::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 10px;
            font-size: 150px;
            color: rgba(0, 0, 0, 0.03);
            font-family: 'Georgia', serif;
            line-height: 1;
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
            margin-bottom: 20px;
        }
        
        .abstract-box p {
            position: relative;
            z-index: 2;
            font-size: 1.05rem;
            color: #343a40;
            margin-bottom: 15px;
        }
        
        .abstract-highlight {
            color: var(--secondary-color);
            font-weight: 600;
        }
        
        /* Enhanced timeline styling with more polish */
        .timeline-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 50px;
            padding-bottom: 60px;
            overflow: visible;
        }
        
        /* Improved timeline central axis */
        .timeline-container::after {
            content: '';
            position: absolute;
            width: 6px;
            background: linear-gradient(to bottom, 
                var(--primary-color), 
                var(--secondary-color),
                var(--accent-color));
            top: 40px;
            bottom: 55px; /* Adjust to leave space above the end label */
            left: 50%;
            margin-left: -3px;
            border-radius: 6px;
            opacity: 0.9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: gradient-flow 8s ease infinite;
            background-size: 200% 200%;
        }
        
        /* Animate gradient background of timeline */
        @keyframes gradient-flow {
            0% {
                background-position: 0% 0%;
            }
            50% {
                background-position: 100% 100%;
            }
            100% {
                background-position: 0% 0%;
            }
        }
        
        .timeline-item {
            padding: var(--spacing-md) var(--spacing-lg);
            position: relative;
            width: 50%;
            box-sizing: border-box;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: calc(var(--spacing-md) * 1.5);
        }
        
        .timeline-item:hover {
            transform: scale(1.03) translateY(-5px);
            z-index: 10;
        }
        
        /* Enhanced timeline node styling */
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 28px;
            height: 28px;
            background: white;
            border: 4px solid;
            border-color: var(--primary-color);
            border-radius: 50%;
            top: 20px;
            z-index: 10;
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
        
        /* Enhanced timeline connector lines */
        .timeline-left::before,
        .timeline-right::before {
            content: '';
            position: absolute;
            top: 30px;
            width: 40px;
            height: 4px;
            background: linear-gradient(to right, transparent, var(--primary-color));
            z-index: 9;
            transition: all var(--transition-speed) ease;
        }
        
        .timeline-left::before {
            right: -40px;
            background: linear-gradient(to right, transparent, var(--primary-color));
        }
        
        .timeline-right::before {
            left: -40px;
            background: linear-gradient(to left, transparent, var(--secondary-color));
        }
        
        .timeline-item:hover::before {
            width: 50px;
            height: 6px;
        }
        
        /* Enhanced timeline content styling */
        .timeline-content {
            padding: var(--spacing-md) var(--spacing-md);
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
            border-top: 4px solid;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .timeline-left .timeline-content {
            border-top-color: var(--primary-color);
            transform: translateX(10px);
            text-align: right;
        }
        
        .timeline-right .timeline-content {
            border-top-color: var(--secondary-color);
            transform: translateX(-10px);
            text-align: left;
        }
        
        .timeline-content:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
        }
        
        .timeline-left .timeline-content:hover {
            transform: translateY(-3px) translateX(5px);
        }
        
        .timeline-right .timeline-content:hover {
            transform: translateY(-3px) translateX(-5px);
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
        
        /* Improved timeline title styling */
        .timeline-title {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-weight: 600;
            font-size: 1.15rem;
            color: #343a40;
            position: relative;
        }
        
        .timeline-left .timeline-title {
            justify-content: flex-end;
        }
        
        .timeline-left .timeline-title .timeline-icon {
            order: 2;
            margin-left: 8px;
            margin-right: 0;
        }
        
        .timeline-right .timeline-title .timeline-icon {
            margin-right: 8px;
        }
        
        .timeline-title .timeline-icon {
            font-size: 1rem;
            color: var(--primary-color);
            transition: all var(--transition-speed) ease;
        }
        
        .timeline-content:hover .timeline-icon {
            transform: scale(1.2);
        }
        
        .timeline-right .timeline-title .timeline-icon {
            color: var(--secondary-color);
        }
        
        /* Enhanced timeline description text and date */
        .timeline-content p {
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 0.75rem;
            color: #495057;
        }
        
        .timeline-date {
            display: inline-flex;
            align-items: center;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #6c757d;
            background: rgba(0, 0, 0, 0.05);
            padding: 4px 10px;
            border-radius: 20px;
            position: relative;
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }
        
        .timeline-content:hover .timeline-date {
            background: rgba(var(--primary-color-rgb, 13, 110, 253), 0.1);
            color: var(--primary-color);
        }
        
        .timeline-date i {
            margin-right: 5px;
            font-size: 0.9rem;
        }
        
        /* Status badge improvements */
        .timeline-status {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            font-size: 0.75rem;
            border-radius: 20px;
            margin-left: 8px;
            font-weight: 500;
            position: relative;
            top: -1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            transition: all var(--transition-speed) ease;
        }
        
        .timeline-left .timeline-status {
            margin-right: 8px;
            margin-left: 0;
        }
        
        .timeline-content:hover .timeline-status {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        /* Timeline marker label enhancements */
        .timeline-marker-label {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.95);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            z-index: 15;
            text-align: center;
            white-space: nowrap;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            font-weight: 500;
        }
        
        .timeline-marker-label:hover {
            transform: translateX(-50%) translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        
        .timeline-start-label {
            top: 5px;
            background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(var(--primary-color-rgb, 13, 110, 253), 0.1));
            border-color: rgba(var(--primary-color-rgb, 13, 110, 253), 0.2);
        }
        
        .timeline-end-label {
            bottom: 20px; /* Position it farther from the end of the timeline line */
            background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(var(--accent-color-rgb, 253, 126, 20), 0.1));
            border-color: rgba(var(--accent-color-rgb, 253, 126, 20), 0.2);
            padding-bottom: 8px; /* Add a bit more padding for visual spacing */
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
            width: 50%;
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
        
        .timeline-left {
            left: 0;
        }
        
        .timeline-right {
            left: 50%;
        }
        
        /* Timeline connector lines */
        .timeline-left::before,
        .timeline-right::before {
            content: '';
            position: absolute;
            top: 30px;
            width: 40px;
            height: 4px;
            background: linear-gradient(to right, transparent, var(--primary-color));
            z-index: 3;
        }
        
        .timeline-left::before {
            right: -40px;
            background: linear-gradient(to right, transparent, var(--primary-color));
        }
        
        .timeline-right::before {
            left: -40px;
            background: linear-gradient(to left, transparent, var(--secondary-color));
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
            margin-bottom: 12px;
            font-weight: 600;
            font-size: 1.15rem;
            color: #343a40;
            position: relative;
        }
        
        .timeline-title .timeline-icon {
            margin-right: 8px;
            font-size: 1rem;
            color: var(--primary-color);
        }
        
        .timeline-right .timeline-title .timeline-icon {
            color: var(--secondary-color);
        }
        
        .timeline-date {
            display: inline-flex;
            align-items: center;
            margin-top: 12px;
            font-size: 0.85rem;
            color: #6c757d;
            background: rgba(0, 0, 0, 0.05);
            padding: 4px 10px;
            border-radius: 20px;
        }
        
        .timeline-date i {
            margin-right: 5px;
            font-size: 0.9rem;
        }
        
        /* Status badge positioning and styling */
        .timeline-status {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            font-size: 0.75rem;
            border-radius: 20px;
            margin-left: 8px;
            font-weight: 500;
            position: relative;
            top: -1px;
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
            padding: var(--spacing-md);
            background: rgba(255, 255, 255, 0.95);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
        }
        
        .timeline-content:hover {
            box-shadow: var(--card-shadow-hover);
        }
        
        .reference-item {
            border-left: 3px solid var(--secondary-color);
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-md);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
        }
        
        .reference-item:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
            border-left-width: 5px;
        }
        
        .member-card {
            padding: var(--spacing-md);
            border-radius: var(--border-radius);
            margin-bottom: var(--spacing-md);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
            border-left: 3px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }
        
        .member-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-5px);
            border-left-width: 5px;
        }
        
        .member-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 5px;
            background: linear-gradient(to bottom, transparent, var(--primary-color), transparent);
            opacity: 0;
            transition: all var(--transition-speed) ease;
        }
        
        .member-card:hover::before {
            opacity: 1;
        }
        
        .member-card[data-contribution="0"] {
            border-left-color: #6c757d;
        }
        
        .member-card[data-contribution="0"]:hover::before {
            background: linear-gradient(to bottom, transparent, #6c757d, transparent);
        }
        
        .member-card[data-contribution^="7"], 
        .member-card[data-contribution^="8"], 
        .member-card[data-contribution^="9"], 
        .member-card[data-contribution="100"] {
            border-left-color: #198754;
        }
        
        .member-card[data-contribution^="7"]:hover::before, 
        .member-card[data-contribution^="8"]:hover::before, 
        .member-card[data-contribution^="9"]:hover::before, 
        .member-card[data-contribution="100"]:hover::before {
            background: linear-gradient(to bottom, transparent, #198754, transparent);
        }
        
        .member-name {
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        
        .member-role {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 12px;
            background: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .member-role i {
            font-size: 0.8rem;
        }
        
        .progress {
            height: 10px;
            border-radius: 6px;
            background-color: rgba(0, 0, 0, 0.05);
            margin-bottom: 12px;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .progress-bar {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 6px;
            position: relative;
            overflow: hidden;
            transition: width 1.2s ease;
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
        
        .member-id {
            display: flex;
            align-items: center;
            margin-top: 10px;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .member-id i {
            margin-right: 5px;
            font-size: 0.9rem;
        }
        
        .badge-custom {
            font-size: 0.85em;
            padding: 6px 14px;
            margin-right: 8px;
            margin-bottom: 8px;
            border-radius: 50px;
            transition: all var(--transition-speed) ease;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-weight: 500;
            color: white;
        }
        
        .badge-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
            border: none;
            margin-bottom: var(--spacing-lg);
        }
        
        .card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 15px 20px;
            border-bottom: none;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 500;
        }
        
        .card-body {
            padding: var(--spacing-md);
        }
        
        .progress {
            height: 10px;
            border-radius: 6px;
            background-color: rgba(0, 0, 0, 0.05);
            margin-bottom: 12px;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
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
            background: transparent;
            border-color: rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
            padding: 14px 16px;
        }
        
        .list-group-item:hover {
            background: rgba(255, 255, 255, 0.7);
            transform: translateX(5px);
        }
        
        .btn {
            border-radius: 50px;
            padding: 8px 22px;
            transition: all var(--transition-speed) ease;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }
        
        .btn-primary:active, .btn-primary:focus {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary-color));
            box-shadow: none;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: 2px solid transparent;
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
            font-weight: 600;
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 12px;
            color: #343a40;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
            transition: width 0.3s ease;
        }
        
        .section-title:hover::after {
            width: 100px;
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
            background: radial-gradient(circle at 30% 40%, rgba(76, 201, 240, 0.05), transparent 30%),
                        radial-gradient(circle at 70% 70%, rgba(114, 9, 183, 0.05), transparent 35%),
                        radial-gradient(circle at 80% 10%, rgba(247, 37, 133, 0.05), transparent 25%);
            transition: opacity 1.5s ease-in-out;
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
        .spinner-border {
            width: 3.5rem;
            height: 3.5rem;
            border-width: 0.25rem;
            animation: spinner-border 1.2s linear infinite, pulse 2s ease-in-out infinite;
            border-color: var(--primary-color) transparent transparent transparent;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, var(--secondary-color), var(--primary-color));
        }
        
        /* Footer styling */
        footer {
            background: linear-gradient(to right, #212529, #343a40);
            padding: 30px 0;
            position: relative;
            overflow: hidden;
            margin-top: 50px;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        
        /* Container styling */
        .container.my-5 {
            padding-top: 20px;
            padding-bottom: 50px;
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
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 50%);
            opacity: 0.6;
            transition: all var(--transition-speed) ease;
        }
        
        .media-card:hover .media-overlay {
            opacity: 0.8;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.2) 60%);
        }
        
        .media-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            color: white;
            font-weight: 500;
            transform: translateY(10px);
            transition: all var(--transition-speed) ease;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .media-card:hover .media-caption {
            transform: translateY(0);
        }
        
        .media-type-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            color: var(--primary-color);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 1;
            transition: all var(--transition-speed) ease;
            opacity: 0.8;
        }
        
        .media-card:hover .media-type-badge {
            background: rgba(255, 255, 255, 0.95);
            opacity: 1;
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
            background: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .lightbox.active {
            opacity: 1;
            pointer-events: auto;
        }
        
        .lightbox-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
            transition: transform 0.3s ease;
            transform: scale(0.9);
        }
        
        .lightbox.active .lightbox-content {
            transform: scale(1);
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
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }
        
        .lightbox-navigation {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            padding: 0 20px;
        }
        
        .lightbox-nav-btn {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .lightbox-nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Media counter badge */
        .media-counter {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(var(--primary-color-rgb, 13, 110, 253), 0.8);
            color: white;
            border-radius: 20px;
            padding: 3px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
            transition: all var(--transition-speed) ease;
        }
        
        .media-card:hover .media-counter {
            background: rgba(var(--primary-color-rgb, 13, 110, 253), 1);
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
            transition: all var(--transition-speed) ease;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
        }
        
        .media-card img {
            transition: transform 0.7s ease;
            width: 100%;
            height: 220px;
            object-fit: cover;
            object-position: center;
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

        /* Add styling for the description section */
        .description-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
            box-shadow: var(--card-shadow);
            border-left: 5px solid var(--primary-color);
            line-height: 1.8;
            position: relative;
            overflow: hidden;
            transition: all var(--transition-speed) ease;
        }

        .description-box:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-5px);
        }

        .description-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(to right, 
                rgba(var(--primary-color-rgb, 13, 110, 253), 0.05),
                rgba(var(--primary-color-rgb, 13, 110, 253), 0.1),
                rgba(var(--primary-color-rgb, 13, 110, 253), 0.05));
            opacity: 0.5;
            z-index: 0;
        }

        .description-box h3 {
            position: relative;
            z-index: 2;
            margin-bottom: 20px;
        }

        .description-box p {
            position: relative;
            z-index: 2;
            font-size: 1.05rem;
            color: #343a40;
            margin-bottom: 15px;
        }

        .description-highlight {
            color: var(--primary-color);
            font-weight: 600;
        }

        .description-section {
            margin-bottom: 20px;
        }

        .description-section:last-child {
            margin-bottom: 0;
        }

        .description-section-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: #343a40;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .description-section-title i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        /* Add styles for timeline marker labels */
        .timeline-marker-label {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.95);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            z-index: 3;
            text-align: center;
            white-space: nowrap;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .timeline-start-label {
            top: 5px;
            background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(var(--primary-color-rgb, 13, 110, 253), 0.1));
            border-color: rgba(var(--primary-color-rgb, 13, 110, 253), 0.2);
        }

        .timeline-end-label {
            bottom: 20px; /* Position it farther from the end of the timeline line */
            background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(var(--accent-color-rgb, 253, 126, 20), 0.1));
            border-color: rgba(var(--accent-color-rgb, 253, 126, 20), 0.2);
            padding-bottom: 8px; /* Add a bit more padding for visual spacing */
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

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 UIU</p>
        </div>
    </footer>

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
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
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
            
            const privacy = isPublic ? 
                '<span class="status-badge bg-success text-white"><i class="bi bi-unlock"></i>Public</span>' : 
                '<span class="status-badge bg-warning text-dark"><i class="bi bi-lock"></i>Private</span>';
                
            const supervisorInfo = project.supervisor ? 
                `<div class="meta-item"><i class="bi bi-person-badge"></i><strong>Supervisor:</strong> ${project.supervisor.name || (typeof project.supervisor === 'string' ? project.supervisor : (project.supervisor.$oid || 'Unknown'))}</div>` : '';
            
            // Add toggle button with appropriate styling based on current privacy
            const toggleBtnStyle = isPublic ? 'btn-outline-warning' : 'btn-outline-success';
            const toggleBtnText = isPublic ? 'Make Private' : 'Make Public';
            const toggleBtn = `
                <button id="privacyToggleBtn" class="privacy-toggle btn ${toggleBtnStyle}" data-project-id="${project._id.$oid}">
                    <i class="bi ${isPublic ? 'bi-lock-fill' : 'bi-unlock-fill'}"></i>${toggleBtnText}
                </button>
            `;
            
            // Check if the current user is the creator of the project
            // We need to fetch the current logged-in user information from PHP session
            let isCreator = false;
            let currentUser = null;
            
            // Fetch the current user ID from a PHP variable injected into the page
            if (typeof currentUserId !== 'undefined') {
                currentUser = currentUserId;
            }
            
            // Check if the current user is the project creator
            if (currentUser) {
                // Check if user is in members list with appropriate role/permissions
                if (project.members && project.members.length > 0) {
                    isCreator = project.members.some(member => 
                        (member.userId && member.userId.$oid === currentUser) || 
                        (member.userId === currentUser)
                    );
                }
            }
            
            // Only show edit button if user is the creator
            const editBtn = isCreator ? `
                <button id="editProjectBtn" class="btn btn-outline-primary ms-2" data-project-id="${project._id.$oid}">
                    <i class="bi bi-pencil-square"></i>Edit Project
                </button>
            ` : '';
            
            headerEl.innerHTML = `
                <div class="d-flex justify-content-between align-items-start position-relative z-1">
                    <div>
                        <h1 class="float-animation display-4">${project.title}</h1>
                        <div class="mb-3 d-flex align-items-center mt-3">
                            ${privacy}
                            ${isCreator ? toggleBtn : ''}
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
            
            // Add event listener for the toggle button
            const toggleButton = document.getElementById('privacyToggleBtn');
            if (toggleButton) {
                toggleButton.addEventListener('click', function() {
                    toggleProjectPrivacy(project._id.$oid);
                });
                
                // Add ripple effect to the button
                toggleButton.addEventListener('mousedown', createRipple);
            }
            
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
                        <small class="text-muted fst-italic">Last updated: ${formatDate(project.updatedAt)}</small>
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
                            <small class="text-muted fst-italic">Last updated: ${formatDate(project.updatedAt)}</small>
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
                membersEl.innerHTML = '<p class="text-muted">No team members listed</p>';
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
                    <div class="progress-label">
                        <div>Contribution <strong>${member.contribution}%</strong></div>
                        <div class="progress-percentage">
                            ${contributionLabel ? `<span class="contribution-level">${contributionLabel}</span>` : ''}
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%" 
                        aria-valuenow="${member.contribution}" aria-valuemin="0" aria-valuemax="100">
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
                        <div class="member-id">
                            <i class="bi bi-fingerprint"></i>
                            <span>ID: ${member.userId?.$oid || member.userId}</span>
                        </div>
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
                keywordsEl.innerHTML = '<p class="text-muted">No keywords listed</p>';
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
                resourcesEl.innerHTML = '<p class="text-muted">No files available</p>';
                return;
            }
            
            let resourcesHTML = '<ul class="list-group list-group-flush">';
            
            project.files.forEach(file => {
                const icon = getFileIcon(file.type);
                const size = formatFileSize(file.size);
                const date = formatDate(file.uploadedAt);
                
                resourcesHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="${icon} me-2"></i> ${file.name}
                            <small class="d-block text-muted">${size} - Uploaded on ${date}</small>
                        </div>
                        <a href="${file.path}" class="btn btn-sm btn-outline-primary" download>
                            <i class="bi bi-download"></i>
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
                linksEl.innerHTML = '<p class="text-muted">No external links available</p>';
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
            
            // Display timeline items
            sortedTimeline.forEach((item, index) => {
                const date = formatDate(item.date);
                const status = getStatusBadge(item.status);
                const side = index % 2 === 0 ? 'timeline-left' : 'timeline-right';
                const delay = 100 * (index + 1);
                
                // Get appropriate icon based on title or status
                let icon = 'bi-calendar-event';
                if (item.title.toLowerCase().includes('research')) icon = 'bi-search';
                if (item.title.toLowerCase().includes('design')) icon = 'bi-pencil-square';
                if (item.title.toLowerCase().includes('development')) icon = 'bi-code-slash';
                if (item.title.toLowerCase().includes('test')) icon = 'bi-check-circle';
                if (item.title.toLowerCase().includes('review')) icon = 'bi-eye';
                if (item.title.toLowerCase().includes('presentation')) icon = 'bi-easel';
                if (item.title.toLowerCase().includes('publication')) icon = 'bi-journal-text';
                
                timelineHTML += `
                    <div class="timeline-item ${side}" data-aos="${side === 'timeline-left' ? 'fade-right' : 'fade-left'}" data-aos-delay="${delay}">
                        <div class="timeline-content">
                            <div class="timeline-title">
                                <i class="bi ${icon} timeline-icon"></i>
                                ${item.title}
                                <span class="timeline-status">${status}</span>
                            </div>
                            <p class="mb-2">${item.description}</p>
                            <div class="timeline-date">
                                <i class="bi bi-clock"></i>${date}
                            </div>
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
                    
                    // Add a tooltip or label for the start marker
                    const startMarker = document.createElement('div');
                    startMarker.className = 'timeline-marker-label timeline-start-label';
                    startMarker.innerHTML = `<strong>Started:</strong> ${startDate}`;
                    timelineEl.insertBefore(startMarker, timelineEl.firstChild);
                    
                    // Add a tooltip or label for the end marker (kept this part)
                    const endMarker = document.createElement('div');
                    endMarker.className = 'timeline-marker-label timeline-end-label';
                    endMarker.innerHTML = `<strong>Completed:</strong> ${endDate}`;
                    timelineEl.appendChild(endMarker);
                }
            }
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
    </script>
    
</body>
</html> 