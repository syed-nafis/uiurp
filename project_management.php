<?php
session_start();
?>
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
            /* Modern Professional Colors */
            --primary: #2563eb;
            --secondary: #8b5cf6;
            --accent: #0ea5e9;
            --background: #0f172a;
            --surface: #1e293b;
            --surface-light: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border: #334155;
            --border-light: #475569;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            
            /* Glass morphism */
            --glass-bg: rgba(30, 41, 59, 0.8);
            --glass-border: rgba(148, 163, 184, 0.1);
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #2563eb, #8b5cf6);
            --gradient-surface: linear-gradient(135deg, #1e293b, #334155);
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            
            /* Border radius */
            --border-radius: 12px;
            --border-radius-lg: 16px;
            
            /* Transitions */
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            background: linear-gradient(135deg, #0a0d1a 0%, #1a1a2e 50%, #16213e 100%);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            overflow-x: hidden;
            color: var(--text-primary);
            position: relative;
            min-height: 100vh;
            scroll-behavior: smooth;
        }
        
        /* Enhanced Background Effects */
        .background-effects {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.4;
            animation: float-orb 15s ease-in-out infinite;
            box-shadow: 0 0 50px currentColor;
        }
        
        .orb-1 {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.3) 0%, rgba(37, 99, 235, 0.1) 50%, transparent 70%);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .orb-2 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, rgba(14, 165, 233, 0.08) 50%, transparent 70%);
            top: 60%;
            right: 10%;
            animation-delay: 7s;
        }
        
        .orb-3 {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.3) 0%, rgba(6, 182, 212, 0.1) 50%, transparent 70%);
            bottom: 20%;
            left: 20%;
            animation-delay: 14s;
        }
        
        @keyframes float-orb {
            0%, 100% { transform: translate(0, 0) scale(1) rotate(0deg); }
            25% { transform: translate(30px, -20px) scale(1.05) rotate(90deg); }
            50% { transform: translate(-20px, 30px) scale(0.95) rotate(180deg); }
            75% { transform: translate(25px, 15px) scale(1.02) rotate(270deg); }
        }
        
        /* Dynamic Grid Background */
        .cyber-grid {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(to right, rgba(37, 99, 235, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
            animation: grid-pulse 4s ease-in-out infinite;
        }
        
        @keyframes grid-pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        /* Enhanced Particles */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            pointer-events: none;
        }
        
        /* Ensure content appears above particles */
        .container,
        .header-container,
        footer {
            position: relative;
            z-index: 1;
        }
        
        /* Hero Section with Dynamic Background */
        .header-container {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.95) 0%, 
                rgba(30, 41, 59, 0.9) 50%,
                rgba(37, 99, 235, 0.8) 100%);
            min-height: 70vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 80px 0 100px;
            clip-path: ellipse(100% 100% at 50% 0%);
            transition: clip-path 0.3s ease-out;
        }
        
        .header-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="circuit" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M0,10 L10,10 L10,0 L20,0 M10,10 L10,20 M10,15 L20,15" stroke="rgba(255,255,255,0.05)" stroke-width="0.5" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23circuit)"/></svg>');
            opacity: 0.6;
            z-index: 1;
        }
        
        .header-container::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 120%;
            height: 150px;
            background: radial-gradient(ellipse 80% 100% at 50% 0%, 
                rgba(37, 99, 235, 0.3) 0%, 
                rgba(14, 165, 233, 0.2) 30%,
                rgba(6, 182, 212, 0.1) 60%,
                transparent 100%);
            border-radius: 50%;
            filter: blur(20px);
            z-index: 2;
            transition: all 0.3s ease-out;
        }
        

        
        .hero-content {
            position: relative;
            z-index: 10;
        }
        
        .hero-title {
            font-size: clamp(2.2rem, 6vw, 3.8rem);
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, #0ea5e9 70%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-align: center;
            margin-bottom: 1.5rem;
            position: relative;
            text-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
        }
        
        .hero-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #0ea5e9, #14b8a6);
            border-radius: 2px;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.6);
            animation: glow-pulse 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow-pulse {
            from { box-shadow: 0 0 15px rgba(37, 99, 235, 0.6); }
            to { box-shadow: 0 0 25px rgba(20, 184, 166, 0.6); }
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #0ea5e9 70%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            position: relative;
            display: inline-block;
        }
        
        .header-container p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            font-weight: 400;
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
            text-align: center;
        }
        
        .card {
            border-radius: var(--border-radius);
            overflow: hidden;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow-md);
            margin-bottom: 24px;
            border: 1px solid var(--glass-border);
            transition: var(--transition);
            position: relative;
        }
        
        .card::before {
            display: none;
        }
        
        .card:hover {
            transform: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: rgba(76, 201, 240, 0.1);
        }
        
        .card:hover::before {
            opacity: 0;
        }
        
        .card-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            position: relative;
            overflow: hidden;
        }
        
        .card-header::after {
            display: none;
        }
        
        .card-header i {
            color: var(--primary);
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.95rem;
        }
        
        .form-label::before {
            display: none;
        }
        
        .form-control, .form-select {
            border-radius: var(--border-radius);
            padding: 12px 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: var(--transition);
            box-shadow: none;
            position: relative;
            z-index: 2;
            caret-color: var(--primary);
        }
        
        /* Ensure all text input is light colored */
        input, textarea, select, option {
            color: var(--text-primary) !important;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
            border-color: var(--primary);
            background: var(--surface-light);
            outline: none;
            color: var(--text-primary);
        }
        
        /* Ensure consistent text color in all states */
        .form-control:active, .form-select:active,
        .form-control:focus-visible, .form-select:focus-visible {
            color: rgba(255, 255, 255, 1);
        }
        
        .form-control::placeholder {
            color: var(--text-muted);
        }
        
        /* Fix for webkit browsers */
        .form-control::-webkit-input-placeholder {
            color: var(--text-muted);
        }
        
        /* Fix for Firefox */
        .form-control::-moz-placeholder {
            color: var(--text-muted);
            opacity: 1;
        }
        
        /* Override Bootstrap's text colors for form-select */
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            appearance: none;
            color-scheme: dark;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
            padding-right: 2.5rem;
        }

        /* Enhanced dropdown styling */
        .form-select:hover {
            border-color: rgba(76, 201, 240, 0.4);
            background-color: var(--surface-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-select:focus {
            border-color: var(--primary);
            background-color: var(--surface-light);
            box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.2);
            transform: translateY(-1px);
        }

        /* Custom dropdown arrow animation */
        .form-select:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        /* Dropdown options styling */
        .form-select option {
            background-color: rgba(15, 23, 42, 0.95);
            color: rgba(255, 255, 255, 0.9);
            padding: 8px 12px;
            border: none;
            transition: all 0.2s ease;
        }

        .form-select option:hover,
        .form-select option:focus {
            background-color: rgba(76, 201, 240, 0.2);
            color: rgba(255, 255, 255, 1);
        }

        .form-select option:checked {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
        }

        /* Enhanced supervisor dropdown */
        #supervisor {
            /* Clean dropdown with only arrow - no extra icons */
        }

        /* Enhanced privacy dropdown */
        #privacy {
            /* Clean dropdown with only arrow - no extra icons */
        }

        /* Enhanced timeline status dropdown */
        #timelineStatus {
            /* Clean dropdown with only arrow - no extra icons */
        }

        /* Dropdown container enhancements */
        .dropdown-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .dropdown-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.05), rgba(114, 9, 183, 0.05));
            border-radius: var(--border-radius);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: -1;
        }

        .dropdown-container:hover::before {
            opacity: 1;
        }

        /* Fix for Firefox and other browsers to ensure consistent dropdown styling */
        select.form-select option {
            background-color: rgb(15, 23, 42);
        }
        
        /* Style the form text description */
        .form-text {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }
        
        /* Remove hover effects on inputs */
        .form-control:hover, .form-select:hover {
            border-color: rgba(76, 201, 240, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Fix for file input buttons */
        input[type="file"]::file-selector-button {
            background: rgba(22, 28, 45, 0.7);
            color: rgba(76, 201, 240, 0.9);
            border: 1px solid rgba(76, 201, 240, 0.2);
            border-radius: 4px;
            padding: 8px 16px;
            margin-right: 16px;
            transition: none;
            cursor: pointer;
            font-weight: 400;
            box-shadow: none;
        }
        
        input[type="file"]::file-selector-button:hover {
            background: rgba(22, 28, 45, 0.75);
            color: rgba(76, 201, 240, 1);
            border-color: rgba(76, 201, 240, 0.4);
            transform: none;
            box-shadow: none;
        }
        
        /* Style for textarea - maintain consistent height */
        textarea.form-control {
            min-height: 100px;
        }
        
        /* More minimal card body */
        .card-body {
            padding: 1rem;
        }
        
        /* Reduce vertical spacing in the form */
        .row.mb-4 {
            margin-bottom: 1rem !important;
        }
        
        /* Make form elements more compact */
        .form-group, .mb-3 {
            margin-bottom: 0.75rem !important;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 24px;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            color: white;
            box-shadow: var(--shadow-sm);
            font-size: 0.95rem;
        }
        
        .btn-primary:hover {
            background: var(--gradient-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            filter: brightness(1.1);
        }
        
        .btn-outline-primary {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            border-radius: var(--border-radius);
            padding: 12px 24px;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            font-size: 0.95rem;
        }
        
        .btn-outline-primary:hover {
            color: white;
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn i {
            display: inline-block;
            margin-right: 6px;
            font-size: 0.9rem;
        }
        
        .btn:hover i {
            transform: none;
        }
        
        .nav-tabs {
            border-bottom: 1px solid var(--border);
            margin-bottom: 30px;
            display: flex;
            position: relative;
            z-index: 2;
            gap: 0;
            padding-bottom: 0;
            padding-top: 20px;
            margin-top: 20px;
            overflow: visible;
        }
        
        /* Add additional container padding to fix tab clipping */
        .container.my-5 {
            padding-top: 20px;
        }
        
        /* Fix tab wrapper styles */
        .tabs-wrapper {
            margin-bottom: 30px;
            margin-top: 20px;
            padding-top: 30px;
            position: relative;
            overflow: visible;
            z-index: 100;
        }
        
        /* Ensure tab content has proper spacing */
        #projectManagementTabContent {
            padding-top: 30px;
            position: relative;
            z-index: 5;
        }
        
        .nav-tabs::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: rgba(76, 201, 240, 0.15);
            z-index: 1;
            box-shadow: none;
        }
        
        /* Minimal tab styling */
        .nav-item {
            padding-top: 0;
            padding-bottom: 0;
            margin-top: 5px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            border-radius: 0;
            padding: 12px 20px;
            margin-right: 0;
            margin-top: 0;
            font-weight: 500;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.6);
            transition: var(--transition);
            background: transparent;
            backdrop-filter: none;
            position: relative;
            overflow: visible;
            z-index: 10;
            letter-spacing: 0;
            box-shadow: none;
            display: block;
            border-bottom: 2px solid transparent;
        }
        
        .nav-tabs .nav-link::before {
            content: '';
            position: absolute;
            top: -100%;
            left: -100%;
            width: 300%;
            height: 300%;
            background: radial-gradient(circle at center, rgba(76, 201, 240, 0.2), transparent 70%);
            transition: var(--smooth-transition);
            opacity: 0;
            z-index: -1;
        }
        
        .nav-tabs .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(to right, #4cc9f0, #7209b7);
            transform: translateX(-50%);
            transition: width 0.3s ease;
            border-radius: 3px;
        }
        
        .nav-tabs .nav-link:hover {
            color: rgba(255, 255, 255, 0.9);
            background: transparent;
            transform: none;
            box-shadow: none;
            border-bottom: 2px solid var(--primary);
        }
        
        .nav-tabs .nav-link:hover::before,
        .nav-tabs .nav-link:hover::after {
            display: none;
        }
        
        .nav-tabs .nav-link.active {
            color: white;
            background: transparent;
            box-shadow: none;
            transform: none;
            border-bottom: 2px solid var(--primary);
            margin-top: 0;
        }
        
        /* Minimal styling for the tabs container */
        #projectManagementTabs {
            margin-top: 30px !important;
            padding-top: 5px;
            min-height: 60px;
            display: flex;
            align-items: center;
        }
        
        .nav-tabs .nav-link.active::after {
            display: none;
        }
        
        .nav-tabs .nav-link i {
            margin-right: 8px;
            font-size: 0.95rem;
            transition: var(--transition);
            color: var(--primary);
            display: inline-block;
        }
        
        .nav-tabs .nav-link:hover i,
        .nav-tabs .nav-link.active i {
            transform: none;
            filter: none;
            color: var(--primary);
        }
        
        .project-card {
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
        }
        
        .project-card::before {
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
        
        .project-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #0ea5e9;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.3),
                0 0 40px rgba(37, 99, 235, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }
        
        .project-card:hover::before {
            opacity: 1;
        }
        
        .card-image {
            height: 250px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            filter: brightness(0.8) saturate(1.2);
        }
        
        .card-image::after {
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
        
        .project-card:hover .card-image img {
            transform: scale(1.1);
            filter: brightness(1) saturate(1.4);
        }
        
        .project-card:hover .card-image::after {
            opacity: 0.3;
        }
        
        .card-content {
            padding: 2rem;
            position: relative;
            z-index: 5;
        }
        
        .project-badge {
            position: absolute;
            top: -15px;
            left: 25px;
            background: linear-gradient(135deg, #0ea5e9 0%, #8b5cf6 100%);
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
        
        .project-badge.private {
            background: linear-gradient(135deg, #14b8a6 0%, #f59e0b 100%);
            box-shadow: 0 8px 20px rgba(20, 184, 166, 0.4);
        }
        
        .project-card:hover .project-badge {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.6);
        }
        
        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            line-height: 1.3;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .card-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }
        
        .project-card:hover .card-title {
            color: #0ea5e9;
        }
        
        .project-card:hover .card-title::after {
            width: 100%;
        }
        
        .card-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        /* Improve card text readability */
        .card p, .card .small, .card label, .card small, .card .form-label, .card .text-muted {
            color: var(--text-secondary);
        }
        
        /* Override Bootstrap's text-muted class */
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Additional contrast for important text */
        .card .card-title, .card h1, .card h2, .card h3, .card h4, .card h5, .card h6, .card strong {
            color: var(--text-primary);
        }
        
        .project-meta {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-secondary);
            font-size: 0.9rem;
            padding: 8px 15px;
            background: rgba(15, 23, 42, 0.4);
            border-radius: 10px;
            border-left: 3px solid #0ea5e9;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .meta-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.1), transparent);
            transition: left 0.5s ease;
        }
        
        .project-card:hover .meta-item {
            transform: translateX(5px);
            border-left-color: #14b8a6;
        }
        
        .project-card:hover .meta-item::before {
            left: 100%;
        }
        
        .meta-icon {
            color: #0ea5e9;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .project-card:hover .meta-icon {
            color: #14b8a6;
            transform: scale(1.2);
        }
        
        /* Action buttons removed */
        
        /* Delete button styling */
        .delete-project-btn {
            font-weight: 600;    /* To match .btn-outline-primary */
            border-radius: 10px; /* To match .btn-outline-primary */
            padding: 12px 25px;  /* To match .btn-outline-primary padding */
            transition: all 0.3s ease; /* Consistent transition handling */
        }
        
        .delete-project-btn:hover {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(247, 37, 133, 0.25);
            /* transition: all 0.3s ease; Removed as it's in the base style now */
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
            cursor: pointer;
            display: block;
            z-index: 3;
            color-scheme: dark; /* Ensure system dialogs use dark mode */
        }
        
        /* Style for file input focus */
        input[type="file"]:focus {
            outline: none;
            border-color: rgba(76, 201, 240, 0.3);
        }
        
        /* Style for file input focus-visible */
        input[type="file"]:focus-visible::file-selector-button {
            outline: none;
            border-color: rgba(76, 201, 240, 0.5);
            color: rgba(76, 201, 240, 1);
        }
        
        /* Fix for direct file inputs that aren't using our custom upload component */
        input[type="file"] {
            color: rgba(255, 255, 255, 0.8);
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(76, 201, 240, 0.1);
            border-radius: 4px;
            padding: 8px 8px 8px 12px;
            color-scheme: dark;
            width: 100%; /* Ensure full width */
            box-sizing: border-box; /* Include padding in width calculation */
        }
        
        input[type="file"]:hover {
            border-color: rgba(76, 201, 240, 0.2);
            color: rgba(76, 201, 240, 0.9);
        }
        
        .file-upload-btn {
            width: 100%;
            border: 1px dashed rgba(76, 201, 240, 0.2);
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            background: rgba(15, 23, 42, 0.5);
            transition: none;
            backdrop-filter: none;
            position: relative;
        }
        
        .file-upload-btn::before,
        .file-upload-btn::after {
            display: none;
        }
        
        .file-upload-btn:hover {
            background: rgba(15, 23, 42, 0.5);
            border-color: rgba(76, 201, 240, 0.3);
            transform: none;
            box-shadow: none;
        }
        
        .file-upload-btn i {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: rgba(76, 201, 240, 0.7);
            display: inline-block;
        }
        
        .file-upload-btn p {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 400;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .file-upload-btn:hover p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        @keyframes pulse-glow {
            0% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
            100% { opacity: 0.3; transform: scale(1); }
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
            background: rgba(101, 129, 255, 0.84);
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
            border-left: 4px solid var(--success);
        }
        
        .toast.error {
            border-left: 4px solid var(--error);
        }
        
        .toast.warning {
            border-left: 4px solid var(--warning);
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
            background-color: rgba(15, 23, 42, 0.5);
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 12px;
            border-left: 3px solid var(--primary-color);
            box-shadow: none;
            transition: none;
            cursor: grab;
            backdrop-filter: none;
            border: 1px solid rgba(76, 201, 240, 0.1);
            border-left: 3px solid var(--primary-color);
            color: rgba(255, 255, 255, 0.9);
        }
        
        .timeline-item.grabbing {
            cursor: grabbing;
        }
        
        .timeline-item:hover {
            transform: none;
            border-color: rgba(76, 201, 240, 0.15);
            background-color: rgba(15, 23, 42, 0.6);
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
            color: rgba(76, 201, 240, 0.9);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        
        .timeline-date i {
            margin-right: 8px;
            color: rgba(76, 201, 240, 0.8);
            font-size: 1rem;
        }
        
        .timeline-controls {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
        
        .timeline-item h6 {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .timeline-item p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Customize timeline action buttons */
        .timeline-controls .btn {
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid rgba(76, 201, 240, 0.1);
            background: rgba(15, 23, 42, 0.4);
            color: rgba(255, 255, 255, 0.8);
            transition: none;
            font-size: 0.8rem;
        }
        
        .timeline-controls .btn:hover {
            transform: none;
            background: rgba(15, 23, 42, 0.5);
            border-color: rgba(76, 201, 240, 0.2);
            box-shadow: none;
        }
        
        .timeline-controls .btn-outline-primary:hover {
            color: #4cc9f0;
        }
        
        .timeline-controls .btn-outline-danger:hover {
            color: #f72585;
            border-color: rgba(247, 37, 133, 0.4);
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 0.7rem;
            font-weight: 500;
            border-radius: 4px;
            margin-left: 8px;
            position: relative;
            box-shadow: none;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: none;
        }
        
        .status-completed {
            background: rgba(76, 201, 240, 0.2);
            color: #4cc9f0;
            border-color: rgba(76, 201, 240, 0.3);
        }
        
        .status-in-progress {
            background: rgba(67, 97, 238, 0.2);
            color: #4361ee;
            border-color: rgba(67, 97, 238, 0.3);
        }
        
        .status-planned {
            background: rgba(58, 12, 163, 0.2);
            color: #7209b7;
            border-color: rgba(58, 12, 163, 0.3);
        }
        
        .status-delayed {
            background: rgba(247, 37, 133, 0.2);
            color: #f72585;
            border-color: rgba(247, 37, 133, 0.3);
        }
        
        .status-badge::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 20px;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .timeline-item:hover .status-badge::after {
            opacity: 1;
        }
        
        /* Ensure linked project cards don't have default link styling */
        .project-card a {
            text-decoration: none;
            color: inherit;
        }
        
        .project-card a:hover {
            color: inherit; /* Optional: prevent color change on hover if desired */
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
            background-color: rgba(15, 23, 42, 0.5);
            transition: var(--smooth-transition);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 10px;
            border: 1px solid rgba(76, 201, 240, 0.1);
            color: rgba(255, 255, 255, 0.9);
            position: relative;
            overflow: hidden;
        }
        
        .reference-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #4cc9f0, #7209b7);
            opacity: 0.7;
        }
        
        .reference-item:hover {
            background-color: rgba(22, 28, 45, 0.7);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2), 0 0 10px rgba(76, 201, 240, 0.1);
            border-color: rgba(76, 201, 240, 0.3);
        }
        
        #references-container {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px 5px;
            scrollbar-width: thin;
            scrollbar-color: rgba(76, 201, 240, 0.5) rgba(15, 23, 42, 0.2);
        }
        
        #references-container::-webkit-scrollbar {
            width: 8px;
        }
        
        #references-container::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.2);
            border-radius: 10px;
        }
        
        #references-container::-webkit-scrollbar-thumb {
            background: rgba(76, 201, 240, 0.5);
            border-radius: 10px;
        }
        
        .reference-item a {
            word-break: break-all;
            color: #4cc9f0;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
        }
        
        .reference-item a:hover {
            color: #f72585;
            text-shadow: 0 0 5px rgba(76, 201, 240, 0.3);
        }
        
        .reference-item a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(to right, #4cc9f0, #f72585);
            transition: width 0.3s ease;
        }
        
        .reference-item a:hover::after {
            width: 100%;
        }
        
        .empty-projects-container {
            background: var(--glass-bg);
            border-radius: var(--border-radius-lg);
            padding: 4rem;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }
        
        .empty-projects-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(76, 201, 240, 0.1), transparent 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: 0;
        }
        
        .empty-projects-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, 
                transparent, 
                rgba(76, 201, 240, 0.5), 
                transparent);
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        
        .empty-projects-container:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 20px rgba(76, 201, 240, 0.2);
            transform: translateY(-8px);
            border-color: rgba(76, 201, 240, 0.4);
        }
        
        .empty-projects-container:hover::before {
            opacity: 1;
            animation: pulse-glow 3s infinite alternate;
        }
        
        .empty-projects-container:hover::after {
            opacity: 1;
        }
        
        .empty-projects-container h3 {
            color: var(--text-primary);
            font-weight: 700;
            position: relative;
            z-index: 2;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
        }
        
        .empty-projects-container p {
            color: var(--text-secondary);
            position: relative;
            z-index: 2;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .empty-icon-container {
            position: relative;
            display: inline-block;
            animation: float-animation 3s ease-in-out infinite;
        }
        
        .empty-icon-container::before {
            content: '';
            position: absolute;
            width: 80px;
            height: 20px;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            filter: blur(5px);
            animation: shadow-animation 3s ease-in-out infinite;
        }
        
        @keyframes float-animation {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        @keyframes shadow-animation {
            0%, 100% { transform: translateX(-50%) scale(1); opacity: 0.3; }
            50% { transform: translateX(-50%) scale(0.8); opacity: 0.1; }
        }
        
        .create-project-button {
            background: var(--gradient-primary);
            border: none;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            padding: 16px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: var(--border-radius);
            position: relative;
            overflow: hidden;
            color: white;
        }
        
        .create-project-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }
        
        .create-project-button:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            filter: brightness(1.1);
        }
        
        .create-project-button:hover::before {
            left: 100%;
        }
        
        .create-project-button i {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        
        .create-project-button:hover i {
            transform: rotate(90deg);
        }
        
        /* Timeline Edit Modal Styling */
        #timelineEditModal .modal-content {
            background-color: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(76, 201, 240, 0.1);
            border-radius: 4px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        #timelineEditModal .modal-header {
            border-bottom: 1px solid rgba(76, 201, 240, 0.1);
            padding: 0.75rem 1rem;
        }
        
        #timelineEditModal .modal-footer {
            border-top: 1px solid rgba(76, 201, 240, 0.1);
            padding: 0.75rem 1rem;
        }
        
        #timelineEditModal .modal-title {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 1.1rem;
        }
        
        #timelineEditModal .btn-close {
            filter: invert(1) brightness(0.8);
            opacity: 0.7;
        }
        
        #timelineEditModal .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        #timelineEditModal .form-control,
        #timelineEditModal .form-select {
            background-color: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(76, 201, 240, 0.1);
            color: rgba(255, 255, 255, 0.9);
        }
        
        #timelineEditModal .form-control:focus,
        #timelineEditModal .form-select:focus {
            border-color: rgba(76, 201, 240, 0.3);
            box-shadow: 0 0 0 1px rgba(76, 201, 240, 0.3);
        }

        /* Enhanced Footer */
        .enhanced-footer {
            background: linear-gradient(135deg, #0a0d1a 0%, #1a1a2e 100%);
            border-top: 1px solid rgba(37, 99, 235, 0.2);
            position: relative;
            overflow: hidden;
            padding: 80px 0 40px;
            color: var(--text-primary);
        }
        
        .enhanced-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent, 
                #0ea5e9, 
                #8b5cf6, 
                #14b8a6, 
                transparent);
            animation: border-glow 3s ease-in-out infinite;
        }
        
        @keyframes border-glow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        
        .footer-content {
            position: relative;
            z-index: 2;
        }
        
        .footer-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--text-primary), #0ea5e9);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .footer-description {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
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
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .footer-links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            transition: width 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #0ea5e9;
        }
        
        .footer-links a:hover::after {
            width: 100%;
        }
        
        .footer-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
            position: relative;
        }
        
        .footer-section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 30px;
            height: 2px;
            background: #0ea5e9;
            border-radius: 1px;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 2rem;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(37, 99, 235, 0.2);
            border-radius: 50%;
            color: var(--text-secondary);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: #0ea5e9;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(37, 99, 235, 0.1);
            margin-top: 3rem;
            padding-top: 2rem;
            text-align: center;
        }
        
        .copyright-text {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin: 0;
        }

        /* ===== LIGHT MODE STYLES ===== */
        [data-theme="light"] {
            --primary: #2563eb;
            --secondary: #8b5cf6;
            --accent: #0ea5e9;
            --background: #ffffff;
            --surface: #f8fafc;
            --surface-light: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --border-light: #cbd5e1;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            
            /* Glass morphism for light mode */
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(0, 0, 0, 0.1);
            
            /* Gradients for light mode */
            --gradient-primary: linear-gradient(135deg, #2563eb, #8b5cf6);
            --gradient-surface: linear-gradient(135deg, #f8fafc, #f1f5f9);
            
            /* Shadows for light mode */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] body {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
            color: var(--text-primary);
        }

        /* Background effects in light mode */
        [data-theme="light"] .floating-orb {
            opacity: 0.2;
        }

        [data-theme="light"] .orb-1 {
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.05) 50%, transparent 70%);
        }

        [data-theme="light"] .orb-2 {
            background: radial-gradient(circle, rgba(14, 165, 233, 0.08) 0%, rgba(14, 165, 233, 0.03) 50%, transparent 70%);
        }

        [data-theme="light"] .orb-3 {
            background: radial-gradient(circle, rgba(6, 182, 212, 0.1) 0%, rgba(6, 182, 212, 0.05) 50%, transparent 70%);
        }

        [data-theme="light"] .cyber-grid {
            background-image: 
                linear-gradient(to right, rgba(37, 99, 235, 0.02) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(37, 99, 235, 0.02) 1px, transparent 1px);
        }

        /* Header container in light mode */
        [data-theme="light"] .header-container {
            background: linear-gradient(135deg, 
                rgba(248, 250, 252, 0.95) 0%, 
                rgba(241, 245, 249, 0.9) 50%,
                rgba(37, 99, 235, 0.1) 100%);
        }

        [data-theme="light"] .header-container::before {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="circuit" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M0,10 L10,10 L10,0 L20,0 M10,10 L10,20 M10,15 L20,15" stroke="rgba(0,0,0,0.02)" stroke-width="0.5" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23circuit)"/></svg>');
            opacity: 0.3;
        }

        [data-theme="light"] .header-container::after {
            background: radial-gradient(ellipse 80% 100% at 50% 0%, 
                rgba(37, 99, 235, 0.1) 0%, 
                rgba(14, 165, 233, 0.08) 30%,
                rgba(6, 182, 212, 0.05) 60%,
                transparent 100%);
        }

        [data-theme="light"] .hero-title {
            background: linear-gradient(135deg, var(--text-primary) 0%, #0ea5e9 70%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        [data-theme="light"] .text-gradient {
            background: linear-gradient(135deg, var(--text-primary) 0%, #0ea5e9 70%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        [data-theme="light"] .header-container p {
            color: var(--text-secondary);
        }

        /* Cards in light mode */
        [data-theme="light"] .card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
        }

        [data-theme="light"] .card:hover {
            border-color: rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .card-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] .card-header i {
            color: var(--primary);
        }

        /* Form elements in light mode */
        [data-theme="light"] .form-label {
            color: var(--text-secondary);
        }

        [data-theme="light"] .form-control,
        [data-theme="light"] .form-select {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] .form-control:focus,
        [data-theme="light"] .form-select:focus {
            border-color: var(--primary);
            background: var(--surface-light);
            color: var(--text-primary);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }

        [data-theme="light"] .form-control::placeholder {
            color: var(--text-muted);
        }

        [data-theme="light"] .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            cursor: pointer;
            transition: var(--transition);
            padding-right: 2.5rem;
        }

        [data-theme="light"] .form-select:hover {
            border-color: rgba(37, 99, 235, 0.4);
            background-color: var(--surface-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .form-select:focus {
            border-color: var(--primary);
            background-color: var(--surface-light);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            transform: translateY(-1px);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        [data-theme="light"] .form-select option {
            background-color: var(--surface);
            color: var(--text-primary);
            padding: 8px 12px;
            border: none;
        }

        [data-theme="light"] .form-select option:hover,
        [data-theme="light"] .form-select option:focus {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .form-select option:checked {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
        }

        /* Enhanced light mode supervisor dropdown */
        [data-theme="light"] #supervisor {
            /* Clean dropdown with only arrow - no extra icons */
        }

        /* Enhanced light mode privacy dropdown */
        [data-theme="light"] #privacy {
            /* Clean dropdown with only arrow - no extra icons */
        }

        /* Enhanced light mode timeline status dropdown */
        [data-theme="light"] #timelineStatus {
            /* Clean dropdown with only arrow - no extra icons */
        }

        /* Light mode dropdown container enhancements */
        [data-theme="light"] .dropdown-container::before {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.03), rgba(139, 92, 246, 0.03));
        }

        /* File input in light mode */
        [data-theme="light"] input[type="file"]::file-selector-button {
            background: var(--surface);
            color: var(--primary);
            border: 1px solid var(--border);
        }

        [data-theme="light"] input[type="file"]::file-selector-button:hover {
            background: var(--surface-light);
            border-color: var(--primary);
        }

        [data-theme="light"] input[type="file"] {
            color: var(--text-primary);
            background: var(--surface);
            border: 1px solid var(--border);
        }

        [data-theme="light"] input[type="file"]:hover {
            border-color: var(--primary);
        }

        [data-theme="light"] .file-upload-btn {
            border: 1px dashed var(--border);
            background: var(--surface);
        }

        [data-theme="light"] .file-upload-btn:hover {
            background: var(--surface-light);
            border-color: var(--primary);
        }

        [data-theme="light"] .file-upload-btn i {
            color: var(--primary);
        }

        [data-theme="light"] .file-upload-btn p {
            color: var(--text-secondary);
        }

        /* Buttons in light mode */
        [data-theme="light"] .btn-primary {
            background: var(--gradient-primary);
            border: none;
            color: white;
        }

        [data-theme="light"] .btn-primary:hover {
            background: var(--gradient-primary);
            filter: brightness(1.1);
        }

        [data-theme="light"] .btn-outline-primary {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        [data-theme="light"] .btn-outline-primary:hover {
            color: white;
            background: var(--primary);
            border-color: var(--primary);
        }

        [data-theme="light"] .btn-outline-secondary {
            border: 1px solid var(--border);
            color: var(--text-secondary);
            background: transparent;
        }

        [data-theme="light"] .btn-outline-secondary:hover {
            background: var(--surface);
            border-color: var(--primary);
            color: var(--primary);
        }

        [data-theme="light"] .btn-outline-danger {
            border: 1px solid var(--error);
            color: var(--error);
            background: transparent;
        }

        [data-theme="light"] .btn-outline-danger:hover {
            background: var(--error);
            color: white;
        }

        /* Navigation tabs in light mode */
        [data-theme="light"] .nav-tabs {
            border-bottom: 1px solid var(--border);
        }

        [data-theme="light"] .nav-tabs::after {
            background: rgba(37, 99, 235, 0.1);
        }

        [data-theme="light"] .nav-tabs .nav-link {
            color: var(--text-secondary);
            border-bottom: 2px solid transparent;
        }

        [data-theme="light"] .nav-tabs .nav-link:hover {
            color: var(--text-primary);
            border-bottom: 2px solid var(--primary);
        }

        [data-theme="light"] .nav-tabs .nav-link.active {
            color: var(--text-primary);
            border-bottom: 2px solid var(--primary);
        }

        [data-theme="light"] .nav-tabs .nav-link i {
            color: var(--primary);
        }

        /* Project cards in light mode */
        [data-theme="light"] .project-card {
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.9) 0%, 
                rgba(248, 250, 252, 0.8) 100%);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .project-card:hover {
            border-color: var(--primary);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.1),
                0 0 40px rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .project-card::before {
            background: linear-gradient(135deg, 
                rgba(37, 99, 235, 0.05) 0%, 
                rgba(139, 92, 246, 0.05) 50%,
                rgba(20, 184, 166, 0.05) 100%);
        }

        [data-theme="light"] .card-image {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        [data-theme="light"] .card-image::after {
            background: linear-gradient(135deg, 
                rgba(248, 250, 252, 0.3) 0%, 
                rgba(241, 245, 249, 0.5) 100%);
        }

        [data-theme="light"] .card-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .project-card:hover .card-title {
            color: var(--primary);
        }

        [data-theme="light"] .card-description {
            color: var(--text-secondary);
        }

        [data-theme="light"] .meta-item {
            background: rgba(248, 250, 252, 0.6);
            border-left: 3px solid var(--primary);
            color: var(--text-secondary);
        }

        [data-theme="light"] .project-card:hover .meta-item {
            border-left-color: var(--accent);
        }

        [data-theme="light"] .meta-icon {
            color: var(--primary);
        }

        [data-theme="light"] .project-card:hover .meta-icon {
            color: var(--accent);
        }

        /* Timeline in light mode */
        [data-theme="light"] .timeline-item {
            background-color: rgba(248, 250, 252, 0.8);
            border: 1px solid var(--border);
            border-left: 3px solid var(--primary);
            color: var(--text-primary);
        }

        [data-theme="light"] .timeline-item:hover {
            background-color: rgba(241, 245, 249, 0.9);
            border-color: var(--primary);
        }

        [data-theme="light"] .timeline-date {
            color: var(--primary);
        }

        [data-theme="light"] .timeline-date i {
            color: var(--primary);
        }

        [data-theme="light"] .timeline-item h6 {
            color: var(--text-primary);
        }

        [data-theme="light"] .timeline-item p {
            color: var(--text-secondary);
        }

        [data-theme="light"] .timeline-controls .btn {
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
        }

        [data-theme="light"] .timeline-controls .btn:hover {
            background: var(--surface-light);
            border-color: var(--primary);
        }

        [data-theme="light"] .timeline-controls .btn-outline-primary:hover {
            color: var(--primary);
        }

        [data-theme="light"] .timeline-controls .btn-outline-danger:hover {
            color: var(--error);
            border-color: var(--error);
        }

        /* Status badges in light mode */
        [data-theme="light"] .status-badge {
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .status-completed {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border-color: rgba(16, 185, 129, 0.3);
        }

        [data-theme="light"] .status-in-progress {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            border-color: rgba(37, 99, 235, 0.3);
        }

        [data-theme="light"] .status-planned {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
            border-color: rgba(139, 92, 246, 0.3);
        }

        [data-theme="light"] .status-delayed {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.3);
        }

        /* Keywords in light mode */
        [data-theme="light"] .keyword-badge {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .keyword-badge:hover {
            background: rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .keyword-badge i:hover {
            color: var(--error);
        }

        /* References in light mode */
        [data-theme="light"] .reference-item {
            background-color: rgba(248, 250, 252, 0.8);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] .reference-item::before {
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
        }

        [data-theme="light"] .reference-item:hover {
            background-color: rgba(241, 245, 249, 0.9);
            border-color: var(--primary);
        }

        [data-theme="light"] .reference-item a {
            color: var(--primary);
        }

        [data-theme="light"] .reference-item a:hover {
            color: var(--secondary);
        }

        [data-theme="light"] .reference-item a::after {
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }

        [data-theme="light"] #references-container {
            scrollbar-color: rgba(37, 99, 235, 0.3) rgba(248, 250, 252, 0.5);
        }

        [data-theme="light"] #references-container::-webkit-scrollbar-track {
            background: rgba(248, 250, 252, 0.5);
        }

        [data-theme="light"] #references-container::-webkit-scrollbar-thumb {
            background: rgba(37, 99, 235, 0.3);
        }

        /* Empty state in light mode */
        [data-theme="light"] .empty-projects-container {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
        }

        [data-theme="light"] .empty-projects-container::before {
            background: radial-gradient(circle at center, rgba(37, 99, 235, 0.05), transparent 70%);
        }

        [data-theme="light"] .empty-projects-container::after {
            background: linear-gradient(to right, 
                transparent, 
                rgba(37, 99, 235, 0.2), 
                transparent);
        }

        [data-theme="light"] .empty-projects-container:hover {
            border-color: rgba(37, 99, 235, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 0 20px rgba(37, 99, 235, 0.1);
        }

        [data-theme="light"] .empty-projects-container h3 {
            color: var(--text-primary);
        }

        [data-theme="light"] .empty-projects-container p {
            color: var(--text-secondary);
        }

        [data-theme="light"] .create-project-button {
            background: var(--gradient-primary);
        }

        [data-theme="light"] .create-project-button:hover {
            filter: brightness(1.1);
        }

        /* Modal in light mode */
        [data-theme="light"] #timelineEditModal .modal-content {
            background-color: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] #timelineEditModal .modal-header {
            border-bottom: 1px solid var(--border);
        }

        [data-theme="light"] #timelineEditModal .modal-footer {
            border-top: 1px solid var(--border);
        }

        [data-theme="light"] #timelineEditModal .modal-title {
            color: var(--text-primary);
        }

        [data-theme="light"] #timelineEditModal .btn-close {
            filter: none;
            opacity: 0.7;
        }

        [data-theme="light"] #timelineEditModal .form-label {
            color: var(--text-secondary);
        }

        [data-theme="light"] #timelineEditModal .form-control,
        [data-theme="light"] #timelineEditModal .form-select {
            background-color: var(--surface-light);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] #timelineEditModal .form-control:focus,
        [data-theme="light"] #timelineEditModal .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.2);
        }

        /* Footer in light mode */
        [data-theme="light"] .enhanced-footer {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-primary);
        }

        [data-theme="light"] .enhanced-footer::before {
            background: linear-gradient(90deg, 
                transparent, 
                rgba(37, 99, 235, 0.3), 
                rgba(139, 92, 246, 0.3), 
                rgba(20, 184, 166, 0.3), 
                transparent);
        }

        [data-theme="light"] .footer-title {
            background: linear-gradient(135deg, var(--text-primary), var(--primary));
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
            background: var(--primary);
        }

        [data-theme="light"] .footer-links a {
            color: var(--text-secondary);
        }

        [data-theme="light"] .footer-links a:hover {
            color: var(--primary);
        }

        [data-theme="light"] .footer-links a::after {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        [data-theme="light"] .social-link {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: var(--text-secondary);
        }

        [data-theme="light"] .social-link:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        [data-theme="light"] .footer-bottom {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .copyright-text {
            color: var(--text-muted);
        }

        /* Spinner and toast in light mode */
        [data-theme="light"] .spinner-overlay {
            background: rgba(255, 255, 255, 0.8);
        }

        [data-theme="light"] .spinner {
            border: 4px solid rgba(37, 99, 235, 0.1);
            border-top-color: var(--primary);
        }

        [data-theme="light"] .toast {
            background: white;
            border: 1px solid var(--border);
        }

        [data-theme="light"] .toast.success {
            border-left: 4px solid var(--success);
        }

        [data-theme="light"] .toast.error {
            border-left: 4px solid var(--error);
        }

        [data-theme="light"] .toast.warning {
            border-left: 4px solid var(--warning);
        }

        [data-theme="light"] .toast-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .toast-close {
            color: var(--text-muted);
        }

        [data-theme="light"] .toast-body {
            color: var(--text-secondary);
        }

        /* Particles in light mode */
        [data-theme="light"] #particles-js {
            opacity: 0.3;
        }

        [data-theme="light"] #particles-js canvas {
            filter: invert(1) opacity(0.2);
        }

        /* Alert in light mode */
        [data-theme="light"] .alert {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] .alert-light {
            background: var(--surface-light);
            border-color: var(--border-light);
            color: var(--text-primary);
        }

        /* Badge in light mode */
        [data-theme="light"] .badge {
            background: var(--primary);
            color: white;
        }

        [data-theme="light"] .badge.bg-secondary {
            background: var(--text-muted) !important;
            color: white;
        }

        /* Text utilities in light mode */
        [data-theme="light"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .text-primary {
            color: var(--primary) !important;
        }

        /* Project badge in light mode */
        [data-theme="light"] .project-badge {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        [data-theme="light"] .project-badge.private {
            background: linear-gradient(135deg, var(--accent) 0%, var(--warning) 100%);
        }

        [data-theme="light"] .form-text {
            color: var(--text-muted);
        }

        [data-theme="light"] .form-control:hover,
        [data-theme="light"] .form-select:hover {
            border-color: rgba(37, 99, 235, 0.3);
        }

        /* ===== CLEAN DROPDOWN REDESIGN ===== */
        
        /* Reset and base dropdown styling */
        .form-select {
            background-color: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            padding: 12px 16px;
            padding-right: 40px;
            color: var(--text-primary);
            font-size: 0.95rem;
            font-weight: 400;
            line-height: 1.5;
            appearance: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            width: 100%;
            
            /* Single clean dropdown arrow */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px 12px;
        }

        /* Hover state */
        .form-select:hover {
            border-color: rgba(76, 201, 240, 0.4);
            background-color: var(--surface-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Focus state */
        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            background-color: var(--surface-light);
            box-shadow: 0 0 0 3px rgba(76, 201, 240, 0.15);
            transform: translateY(-1px);
        }

        /* Disabled state */
        .form-select:disabled {
            background-color: var(--surface);
            border-color: var(--border);
            color: var(--text-muted);
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Option styling */
        .form-select option {
            background-color: var(--surface);
            color: var(--text-primary);
            padding: 8px 12px;
            font-weight: 400;
        }

        /* Remove any specific dropdown overrides */
        #supervisor,
        #privacy,
        #timelineStatus {
            /* Inherit all styles from .form-select */
        }

        /* Enhanced container styling */
        .dropdown-container {
            position: relative;
            margin-bottom: 1rem;
        }

        .dropdown-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(76, 201, 240, 0.02), rgba(114, 9, 183, 0.02));
            border-radius: var(--border-radius);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: -1;
        }

        .dropdown-container:hover::before {
            opacity: 1;
        }

        /* ===== LIGHT MODE DROPDOWN STYLES ===== */
        
        [data-theme="light"] .form-select {
            background-color: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
            
            /* Light mode dropdown arrow */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        [data-theme="light"] .form-select:hover {
            border-color: rgba(37, 99, 235, 0.3);
            background-color: var(--surface-light);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        [data-theme="light"] .form-select:focus {
            border-color: var(--primary);
            background-color: var(--surface-light);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        [data-theme="light"] .form-select option {
            background-color: var(--surface);
            color: var(--text-primary);
        }

        [data-theme="light"] .dropdown-container::before {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.02), rgba(139, 92, 246, 0.02));
        }

        /* Remove any conflicting styles */
        [data-theme="light"] #supervisor,
        [data-theme="light"] #privacy,
        [data-theme="light"] #timelineStatus {
            /* Inherit all styles from light mode .form-select */
        }

        /* ===== DROPDOWN RESET - OVERRIDE ALL CONFLICTS ===== */
        
        /* Force clean dropdown styling - override any previous definitions */
        .form-select,
        #supervisor,
        #privacy, 
        #timelineStatus,
        [data-theme="light"] .form-select,
        [data-theme="light"] #supervisor,
        [data-theme="light"] #privacy,
        [data-theme="light"] #timelineStatus {
            /* Reset all background images to prevent duplication */
            background-image: none !important;
        }

        /* Dark mode dropdown arrow - single clean arrow */
        .form-select,
        #supervisor,
        #privacy,
        #timelineStatus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 12px center !important;
            background-size: 16px 12px !important;
        }

        /* Light mode dropdown arrow - single clean arrow */
        [data-theme="light"] .form-select,
        [data-theme="light"] #supervisor,
        [data-theme="light"] #privacy,
        [data-theme="light"] #timelineStatus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 12px center !important;
            background-size: 16px 12px !important;
        }

        /* Ensure no duplicate arrows on focus */
        .form-select:focus,
        #supervisor:focus,
        #privacy:focus,
        #timelineStatus:focus,
        [data-theme="light"] .form-select:focus,
        [data-theme="light"] #supervisor:focus,
        [data-theme="light"] #privacy:focus,
        [data-theme="light"] #timelineStatus:focus {
            /* Keep the same arrow, don't change it */
            background-image: inherit !important;
        }

        /* ===== SEARCHABLE SUPERVISOR DROPDOWN ===== */
        
        .supervisor-search-container {
            position: relative;
        }

        .supervisor-dropdown {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            background: var(--surface);
            border: 1px solid var(--border);
            border-bottom: none;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            max-height: 200px;
            overflow-y: auto;
            z-index: 99999;
            display: none;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.15);
        }

        .supervisor-dropdown.show {
            display: block;
        }

        .supervisor-option {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .supervisor-option:last-child {
            border-bottom: none;
        }

        .supervisor-option:hover,
        .supervisor-option.highlighted {
            background: rgba(76, 201, 240, 0.1);
            color: var(--primary);
        }

        .supervisor-option .faculty-name {
            font-weight: 500;
        }

        .supervisor-option .faculty-info {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .supervisor-no-results {
            padding: 12px 16px;
            color: var(--text-muted);
            font-style: italic;
            text-align: center;
        }

        /* Search input styling */
        #supervisor {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 12px center !important;
            background-size: 16px 16px !important;
            padding-right: 40px !important;
        }

        #supervisor:focus {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        #supervisor:focus + input + .supervisor-dropdown {
            border-top: 1px solid var(--primary);
        }

        /* Light mode styles for searchable dropdown */
        [data-theme="light"] .supervisor-dropdown {
            background: var(--surface);
            border-color: var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .supervisor-option {
            color: var(--text-primary);
            border-bottom-color: var(--border);
        }

        [data-theme="light"] .supervisor-option:hover,
        [data-theme="light"] .supervisor-option.highlighted {
            background: rgba(37, 99, 235, 0.08);
            color: var(--primary);
        }

        [data-theme="light"] .supervisor-option .faculty-info {
            color: var(--text-muted);
        }

        [data-theme="light"] .supervisor-no-results {
            color: var(--text-muted);
        }

        [data-theme="light"] #supervisor {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
        }

        /* Scrollbar styling for dropdown */
        .supervisor-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .supervisor-dropdown::-webkit-scrollbar-track {
            background: var(--surface);
        }

        .supervisor-dropdown::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        .supervisor-dropdown::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* ===== SEARCHABLE STUDENT DROPDOWN ===== */
        
        .student-search-container {
            position: relative;
        }

        .student-dropdown {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            background: var(--surface);
            border: 1px solid var(--border);
            border-bottom: none;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            max-height: 200px;
            overflow-y: auto;
            z-index: 99999;
            display: none;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.15);
        }

        .student-dropdown.show {
            display: block;
        }

        .student-option {
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .student-option:last-child {
            border-bottom: none;
        }

        .student-option:hover,
        .student-option.highlighted {
            background: rgba(76, 201, 240, 0.1);
            color: var(--primary);
        }

        .student-option .student-name {
            font-weight: 500;
        }

        .student-option .student-info {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .student-no-results {
            padding: 12px 16px;
            color: var(--text-muted);
            font-style: italic;
            text-align: center;
        }

        /* Student search input styling */
        .member-name.student-search {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%234cc9f0' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 12px center !important;
            background-size: 16px 16px !important;
            padding-right: 40px !important;
        }

        .member-name.student-search:focus {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* Light mode styles for student dropdown */
        [data-theme="light"] .student-dropdown {
            background: var(--surface);
            border-color: var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .student-option {
            color: var(--text-primary);
            border-bottom-color: var(--border);
        }

        [data-theme="light"] .student-option:hover,
        [data-theme="light"] .student-option.highlighted {
            background: rgba(37, 99, 235, 0.08);
            color: var(--primary);
        }

        [data-theme="light"] .student-option .student-info {
            color: var(--text-muted);
        }

        [data-theme="light"] .student-no-results {
            color: var(--text-muted);
        }

        [data-theme="light"] .member-name.student-search {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
        }

        /* Scrollbar styling for student dropdown */
        .student-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .student-dropdown::-webkit-scrollbar-track {
            background: var(--surface);
        }

        .student-dropdown::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        .student-dropdown::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Ensure card containers don't clip dropdowns */
        .card {
            overflow: visible !important;
        }

        .card-body {
            overflow: visible !important;
        }

        /* Ensure form containers don't clip dropdowns */
        .container, .container-fluid {
            overflow: visible !important;
        }

        /* Ensure project team section doesn't clip dropdowns */
        .row {
            overflow: visible !important;
        }

        /* Specific fixes for sections that follow Project Team */
        .row.mb-4 {
            position: relative;
            z-index: 1;
        }

        /* Ensure Project Team dropdowns are above everything */
        .card:has(.supervisor-dropdown),
        .card:has(.student-dropdown) {
            position: relative;
            z-index: 10000;
        }

        /* Alternative approach for broader browser support */
        .card .supervisor-search-container,
        .card .student-search-container {
            position: relative;
            z-index: 10000;
        }

        /* Force dropdowns to appear above all subsequent content */
        .supervisor-dropdown.show,
        .student-dropdown.show {
            position: absolute;
            z-index: 999999 !important;
        }

        /* Ensure dropdowns don't get clipped by transform contexts */
        .supervisor-search-container,
        .student-search-container {
            transform: none !important;
            contain: none !important;
        }

        /* Dark mode styles for supervisor dropdown */
        [data-theme="dark"] .supervisor-dropdown {
            background: #263b5d;
        }

        /* Scrollbar styling for dropdown */
        .supervisor-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .supervisor-dropdown::-webkit-scrollbar-track {
            background: var(--surface);
        }

        .supervisor-dropdown::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        .supervisor-dropdown::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        [data-theme="light"] .member-name.student-search {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
        }

        /* Dark mode styles for student dropdown */
        [data-theme="dark"] .student-dropdown {
            background: #263b5d;
        }

        /* Scrollbar styling for student dropdown */
        .student-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .student-dropdown::-webkit-scrollbar-track {
            background: var(--surface);
        }

        .student-dropdown::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        .student-dropdown::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    
    <!-- Enhanced Background Effects -->
    <div class="background-effects">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        <div class="cyber-grid"></div>
    </div>
    
    <!-- Background Particles -->
    <div id="particles-js"></div>
    
    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="spinner">
        <div class="spinner"></div>
    </div>
    
    <!-- Toast Notifications -->
    <div class="toast-container" id="toastContainer"></div>
    
    <div class="header-container">
        <div class="container text-center hero-content">
            <h1 class="hero-title" data-aos="fade-down" data-aos-duration="1000">Edit <span class="text-gradient" data-text="Research">Research</span> Projects</h1>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">Create, edit, and share your groundbreaking research with the academic community.</p>
        </div>
    </div>
    
    <div class="container my-5" style="margin-top: 40px !important; padding-top: 20px;">
        <div class="tabs-wrapper" style="padding-top: 60px; position: relative; z-index: 100;">
            <ul class="nav nav-tabs" id="projectManagementTabs" role="tablist" style="margin-top: 40px;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="edit-projects-tab" data-bs-toggle="tab" data-bs-target="#edit-projects" type="button" role="tab" aria-controls="edit-projects" aria-selected="true">
                        <i class="bi bi-collection me-2"></i>My Projects
                    </button>
                </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="new-project-tab" data-bs-toggle="tab" data-bs-target="#new-project" type="button" role="tab" aria-controls="new-project" aria-selected="false">
                    <i class="bi bi-plus-circle me-2"></i>Create New Project
                </button>
                            </li>
            </ul>
        </div>
        
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
                        <div class="card mt-3">
                            <div class="card-header">
                                <i class="bi bi-file-earmark-plus me-2"></i>New Research Project
                            </div>
                            <div class="card-body">
                                <form id="projectForm" enctype="multipart/form-data">
                                    <input type="hidden" id="projectId" name="projectId" value="">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <div class="mb-2">
                                                <label for="title" class="form-label">Project Title*</label>
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <label for="abstract" class="form-label">Abstract*</label>
                                                <textarea class="form-control" id="abstract" name="abstract" rows="3" required></textarea>
                                            </div>
                                            
                                            <div class="mb-2">
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
                                            <div class="mb-3 dropdown-container">
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
                                    
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <i class="bi bi-link-45deg me-2"></i>External Links
                                                </div>
                                                <div class="card-body pb-2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-2">
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
                                                    <div class="mb-3 dropdown-container">
                                                        <label for="supervisor" class="form-label">Project Supervisor</label>
                                                        <div class="supervisor-search-container position-relative">
                                                            <input type="text" class="form-control" id="supervisor" name="supervisor" 
                                                                   placeholder="Type to search faculty..." autocomplete="off">
                                                            <input type="hidden" id="supervisorId" name="supervisorId">
                                                            <div class="supervisor-dropdown" id="supervisorDropdown">
                                                                <!-- Faculty options will be populated here -->
                                                            </div>
                                                        </div>
                                                        <div class="form-text">Choose a faculty member to supervise this project</div>
                                                    </div>
                                                    
                                                    <label class="form-label">Team Members</label>
                                                    <div id="membersContainer">
                                                        <!-- Team members will be dynamically added here -->
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
                                    
                                    <div class="text-end mt-3">
                                        <button type="button" class="btn btn-outline-secondary me-2" id="resetForm">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-1"></i>Save Project
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

    <?php include 'src/includes/footer.php'; ?>
    


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize particles.js
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 100,
                    "density": {
                        "enable": true,
                        "value_area": 1500
                    }
                },
                "color": {
                    "value": ["#4cc9f0", "#7209b7", "#4361ee", "#3a0ca3", "#f72585"]
                },
                "shape": {
                    "type": ["circle", "triangle", "polygon", "edge", "star"],
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 6
                    }
                },
                "opacity": {
                    "value": 0.4,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 0.8,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 8,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 2,
                        "size_min": 1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 180,
                    "color": "#4cc9f0",
                    "opacity": 0.3,
                    "width": 1.2,
                    "shadow": {
                        "enable": true,
                        "blur": 5,
                        "color": "#4cc9f0"
                    }
                },
                "move": {
                    "enable": true,
                    "speed": 1.5,
                    "direction": "none",
                    "random": true,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": true,
                        "rotateX": 500,
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
                            "opacity": 0.8,
                            "color": "#f72585"
                        }
                    },
                    "bubble": {
                        "distance": 150,
                        "size": 12,
                        "duration": 2,
                        "opacity": 0.8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 2
                    },
                    "push": {
                        "particles_nb": 10
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true,
            "fps_limit": 60
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
        
        // Global students data for dropdown
        let allStudentsData = [];
        
        // Global current user data
        let currentUserData = null;
        
        // Initialize - Load user's projects and faculty data
        loadUserProjects();
        loadFacultyForDropdown();
        loadStudentsForDropdown();
        loadCurrentUser();
        
        // Initialize the initial member row with student search
        setTimeout(() => {
            // First add a member row if none exists
            if (document.querySelectorAll('.member-row').length === 0) {
                addMemberRow();
            }
            
            const initialMemberRow = document.querySelector('.member-row');
            if (initialMemberRow) {
                setupStudentSearch(initialMemberRow);
                
                // Auto-populate with creator data if available
                if (currentUserData) {
                    populateCurrentUserInFirstRow(initialMemberRow);
                }
            }
        }, 200);
        
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
            const url = isEditing ? 'src/model/update_project.php' : 'src/model/create_project_debug.php';
            
            console.log('Submitting form to:', url);
            console.log('Form data:', Object.fromEntries(formData));
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); // Get as text first to debug
            })
            .then(responseText => {
                console.log('Raw response:', responseText);
                hideSpinner();
                
                try {
                    const data = JSON.parse(responseText);
                    console.log('Parsed JSON:', data);
                    
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
                } catch (parseError) {
                    console.error('JSON Parse Error:', parseError);
                    console.error('Raw response was:', responseText);
                    showToast('Error', 'Invalid response from server.', 'error');
                }
            })
            .catch(error => {
                hideSpinner();
                console.error('Fetch Error:', error);
                showToast('Error', 'Network error: ' + error.message, 'error');
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
            const rowId = 'member-row-' + Date.now();
            row.innerHTML = `
                <div class="col-md-3">
                    <div class="student-search-container position-relative">
                        <input type="text" class="form-control member-name student-search" placeholder="Type to search students..." autocomplete="off" required>
                        <input type="hidden" class="member-student-id">
                        <div class="student-dropdown">
                            <!-- Student options will be populated here -->
                        </div>
                    </div>
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
            
            // Setup student search functionality for this row
            setupStudentSearch(row);
            
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
                const selectedStudentId = row.querySelector('.member-student-id').value.trim();
                
                if (name) {
                    const member = {
                        name: name,
                        role: role || 'Author',
                        contribution: contribution
                    };
                    
                    // Use selected student ID if available, otherwise use manually entered userId
                    if (selectedStudentId) {
                        member.userId = { '$oid': selectedStudentId };
                    } else if (userId) {
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
            
            // Auto-populate creator if user is logged in
            setTimeout(() => {
                if (currentUserData) {
                    const firstMemberRow = document.querySelector('.member-row');
                    if (firstMemberRow) {
                        populateCurrentUserInFirstRow(firstMemberRow);
                    }
                }
            }, 100);
            
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
            
            // Reset supervisor dropdown to default
            clearSupervisorSelection();
            
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
        
        // Faculty Management Functions
        let allFacultyData = [];
        let currentHighlightedIndex = -1;
        
        function loadFacultyForDropdown() {
            // Check if global faculty data is available (from Faculty_Page.php)
            if (window.facultyData && window.facultyData.length > 0) {
                allFacultyData = window.facultyData;
                setupSupervisorSearch();
                return;
            }
            
            // If global data is not available, fetch it directly
            // This handles cases where project management is accessed without visiting faculty page first
            fetch('src/model/load_faculty.php')
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        // Store globally for future use
                        window.facultyData = data;
                        allFacultyData = data;
                        setupSupervisorSearch();
                    } else {
                        console.error('No faculty data received');
                        showToast('Warning', 'Could not load faculty data for supervisor dropdown', 'warning');
                    }
                })
                .catch(error => {
                    console.error('Error fetching faculty data:', error);
                    showToast('Warning', 'Could not load faculty data for supervisor dropdown', 'warning');
                });
        }
        
        function setupSupervisorSearch() {
            const supervisorInput = document.getElementById('supervisor');
            const supervisorDropdown = document.getElementById('supervisorDropdown');
            const supervisorIdInput = document.getElementById('supervisorId');
            
            if (!supervisorInput || !supervisorDropdown) return;
            
            // Input event for filtering
            supervisorInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                filterAndDisplayFaculty(searchTerm);
            });
            
            // Focus event to show dropdown
            supervisorInput.addEventListener('focus', function() {
                const searchTerm = this.value.toLowerCase().trim();
                filterAndDisplayFaculty(searchTerm);
            });
            
            // Blur event to hide dropdown (with delay for clicks)
            supervisorInput.addEventListener('blur', function() {
                setTimeout(() => {
                    hideSupervisorDropdown();
                }, 150);
            });
            
            // Keyboard navigation
            supervisorInput.addEventListener('keydown', function(e) {
                const options = supervisorDropdown.querySelectorAll('.supervisor-option');
                
                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        currentHighlightedIndex = Math.min(currentHighlightedIndex + 1, options.length - 1);
                        updateHighlight(options);
                        break;
                        
                    case 'ArrowUp':
                        e.preventDefault();
                        currentHighlightedIndex = Math.max(currentHighlightedIndex - 1, -1);
                        updateHighlight(options);
                        break;
                        
                    case 'Enter':
                        e.preventDefault();
                        if (currentHighlightedIndex >= 0 && options[currentHighlightedIndex]) {
                            selectFaculty(options[currentHighlightedIndex]);
                        }
                        break;
                        
                    case 'Escape':
                        hideSupervisorDropdown();
                        supervisorInput.blur();
                        break;
                }
            });
            
            // Click outside to close
            document.addEventListener('click', function(e) {
                if (!supervisorInput.contains(e.target) && !supervisorDropdown.contains(e.target)) {
                    hideSupervisorDropdown();
                }
            });
        }
        
        function filterAndDisplayFaculty(searchTerm) {
            const supervisorDropdown = document.getElementById('supervisorDropdown');
            
            if (!allFacultyData || allFacultyData.length === 0) {
                supervisorDropdown.innerHTML = '<div class="supervisor-no-results">No faculty data available</div>';
                supervisorDropdown.classList.add('show');
                return;
            }
            
            // Filter faculty based on search term
            const filteredFaculty = allFacultyData.filter(faculty => 
                faculty.name.toLowerCase().includes(searchTerm) ||
                (faculty.email && faculty.email.toLowerCase().includes(searchTerm)) ||
                (faculty.department && faculty.department.toLowerCase().includes(searchTerm))
            );
            
            // Clear previous options
            supervisorDropdown.innerHTML = '';
            currentHighlightedIndex = -1;
            
            if (filteredFaculty.length === 0) {
                supervisorDropdown.innerHTML = '<div class="supervisor-no-results">No faculty found matching your search</div>';
            } else {
                filteredFaculty.forEach((faculty, index) => {
                    const option = document.createElement('div');
                    option.className = 'supervisor-option';
                    
                    // Extract the ObjectId string properly
                    let facultyId;
                    if (faculty._id && typeof faculty._id === 'object' && faculty._id.$oid) {
                        facultyId = faculty._id.$oid;
                    } else {
                        facultyId = String(faculty._id);
                    }
                    
                    option.setAttribute('data-faculty-id', facultyId);
                    option.setAttribute('data-faculty-name', faculty.name);
                    
                    // Create faculty info display
                    let facultyInfo = '';
                    if (faculty.email || faculty.department) {
                        const infoParts = [];
                        if (faculty.email) infoParts.push(faculty.email);
                        if (faculty.department) infoParts.push(faculty.department);
                        facultyInfo = `<div class="faculty-info">${infoParts.join(' • ')}</div>`;
                    }
                    
                    option.innerHTML = `
                        <div>
                            <div class="faculty-name">${faculty.name}</div>
                            ${facultyInfo}
                        </div>
                    `;
                    
                    // Click event for selection
                    option.addEventListener('click', function() {
                        selectFaculty(this);
                    });
                    
                    supervisorDropdown.appendChild(option);
                });
            }
            
            supervisorDropdown.classList.add('show');
            
            // Force the dropdown to appear above the input by default
            // Only reposition downward if there's not enough space above
            const containerRect = document.getElementById('supervisor').getBoundingClientRect();
            const spaceAbove = containerRect.top;
            
            // If there's not enough space above, position it below instead
            if (spaceAbove < 220) { // 220px accounts for dropdown height + some padding
                supervisorDropdown.style.bottom = 'auto';
                supervisorDropdown.style.top = '100%';
                supervisorDropdown.style.borderRadius = '0 0 var(--border-radius) var(--border-radius)';
                supervisorDropdown.style.borderTop = 'none';
                supervisorDropdown.style.borderBottom = '1px solid var(--border)';
                supervisorDropdown.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
            } else {
                // Reset to upward positioning (default)
                supervisorDropdown.style.bottom = '100%';
                supervisorDropdown.style.top = 'auto';
                supervisorDropdown.style.borderRadius = 'var(--border-radius) var(--border-radius) 0 0';
                supervisorDropdown.style.borderTop = '1px solid var(--border)';
                supervisorDropdown.style.borderBottom = 'none';
                supervisorDropdown.style.boxShadow = '0 -4px 12px rgba(0, 0, 0, 0.15)';
            }
        }
        
        function updateHighlight(options) {
            // Remove previous highlights
            options.forEach(option => option.classList.remove('highlighted'));
            
            // Add highlight to current option
            if (currentHighlightedIndex >= 0 && options[currentHighlightedIndex]) {
                options[currentHighlightedIndex].classList.add('highlighted');
                
                // Scroll into view if needed
                options[currentHighlightedIndex].scrollIntoView({
                    block: 'nearest',
                    behavior: 'smooth'
                });
            }
        }
        
        function selectFaculty(optionElement) {
            const facultyId = optionElement.getAttribute('data-faculty-id');
            const facultyName = optionElement.getAttribute('data-faculty-name');
            
            // Set the input values
            document.getElementById('supervisor').value = facultyName;
            document.getElementById('supervisorId').value = facultyId;
            
            // Hide dropdown
            hideSupervisorDropdown();
            
            // Optional: Show confirmation
            console.log('Selected faculty:', facultyName, 'ID:', facultyId);
        }
        
        function hideSupervisorDropdown() {
            const supervisorDropdown = document.getElementById('supervisorDropdown');
            supervisorDropdown.classList.remove('show');
            currentHighlightedIndex = -1;
        }
        
        function clearSupervisorSelection() {
            document.getElementById('supervisor').value = '';
            document.getElementById('supervisorId').value = '';
            hideSupervisorDropdown();
        }
        
        // Legacy function for compatibility - now just calls the new setup
        function populateFacultyDropdown(faculties) {
            // This function is kept for compatibility but the new searchable dropdown
            // doesn't need traditional population since it filters on demand
            allFacultyData = faculties;
            setupSupervisorSearch();
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
                        
                        // Log debugging info to console
                        console.log("Debug info:", data.debug);
                        
                        // Display projects, either user's projects or public ones
                        if (data.projects && data.projects.length > 0) {
                            // Show all user-related projects (created by user, member of, or supervising)
                            if (isLoggedIn) {
                                // The backend already filters for user's projects correctly
                                // (createdBy, members, and supervisor checks are done server-side)
                                // So we can display all returned projects
                                displayUserProjects(data.projects, false);
                            } else {
                                // For non-logged in users, show empty state
                                displayEmptyState('Join the Research Community', 
                                    'Access your personal research dashboard and connect with fellow researchers worldwide.');
                            }
                        } else {
                            const userId = data.debug?.userId || 'unknown';
                            let title = isLoggedIn ? 'Ready to Innovate?' : 'Join the Research Community';
                            let message = isLoggedIn ? 
                                `Transform your ideas into groundbreaking research projects. Share your discoveries with the academic community and make an impact.` : 
                                'Access your personal research dashboard and connect with fellow researchers worldwide.';
                            displayEmptyState(title, message);
                        }
                    } else {
                        // Show empty state or error
                        displayEmptyState('Ready to Innovate?', 'Transform your ideas into groundbreaking research projects. Share your discoveries with the academic community and make an impact.');
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Error:', error);
                    displayEmptyState('Connection Issue', 'Unable to load your projects right now. Please check your connection and try again.');
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
                
                // Card link wrapper
                const cardLink = document.createElement('a');
                cardLink.href = `Project_details.php?id=${project._id.$oid}`;
                cardLink.style.textDecoration = 'none'; // Prevent underline
                cardLink.style.color = 'inherit';     // Inherit text color

                cardLink.innerHTML = `
                    <div class="card-image">
                        <img src="${imageSrc}" alt="${project.title}" loading="lazy" onerror="this.onerror=null; this.src='${getRandomResearchImage()}';">
                    </div>
                    <div class="card-content">
                        <div class="project-badge ${badgeClass}">${badgeText}</div>
                        <h3 class="card-title">${project.title}</h3>
                        <p class="card-description">${project.abstract ? (project.abstract.length > 120 ? project.abstract.substring(0, 120) + '...' : project.abstract) : 'No description available'}</p>
                        <div class="project-meta">
                            <div class="meta-item">
                                <i class="meta-icon far fa-calendar-alt"></i>
                                <span>${formattedDate}</span>
                            </div>
                            <div class="meta-item">
                                <i class="meta-icon fas fa-graduation-cap"></i>
                                <span>${project.field || 'Research'}</span>
                            </div>
                            ${showActionButtons ? `
                            <div class="meta-item project-actions">
                                <a href="edit_project.php?id=${project._id.$oid}" class="btn btn-sm btn-outline-primary edit-project-btn">
                                    <i class="bi bi-pencil-fill me-1"></i>Edit
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-2 delete-project-btn" data-id="${project._id.$oid}" data-title="${project.title}">
                                    <i class="bi bi-trash-fill me-1"></i>Delete
                                </button>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `;
                
                const projectCardDiv = document.createElement('div');
                projectCardDiv.className = 'project-card position-relative';
                projectCardDiv.appendChild(cardLink);
                col.appendChild(projectCardDiv);
                
                userProjectsList.appendChild(col);
                
                // Add event listeners for edit and delete buttons if shown
                // These should stop propagation to prevent card click
                if (showActionButtons) {
                    const editBtn = col.querySelector('.edit-project-btn');
                    if(editBtn) {
                        editBtn.addEventListener('click', function(e) {
                            e.stopPropagation(); // Prevent card click
                            // The link will handle navigation
                        });
                    }

                    const deleteBtn = col.querySelector('.delete-project-btn');
                    if (deleteBtn) {
                        deleteBtn.addEventListener('click', function(e) {
                            e.stopPropagation(); // Prevent card click
                        const projectId = this.getAttribute('data-id');
                            const projectTitle = this.getAttribute('data-title');
                            deleteProject(projectId, projectTitle);
                    });
                    }
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
                    <div class="empty-projects-container text-center py-5">
                        <div class="empty-icon-container mb-4">
                            <i class="bi bi-lightbulb display-1 text-primary opacity-75"></i>
                        </div>
                        <h3 class="fw-bold mb-3">${title}</h3>
                        <p class="mx-auto" style="max-width: 500px; color: var(--text-secondary);">${message}</p>
                        
                        <div class="mt-4">
                            ${title !== 'Join the Research Community' ? 
                                `<button class="btn btn-primary btn-lg create-project-button px-4">
                                    <i class="bi bi-plus-circle me-2"></i>Start Your Research Journey
                                </button>` : 
                                `<a href="login.php" class="btn btn-primary btn-lg px-4">
                                    <i class="bi bi-person-fill me-2"></i>Login to Continue
                                </a>`
                            }
                        </div>
                    </div>
                </div>
            `;
            
            // Add custom styling for the empty state
            const style = document.createElement('style');
            style.textContent = `
                .empty-projects-container {
                    background: #00112957;
                    border-radius: 16px;
                    padding: 3rem;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                    transition: all 0.3s ease;
                }
                
                .empty-projects-container:hover {
                    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
                    transform: translateY(-5px);
                }
                
                .empty-icon-container {
                    position: relative;
                    display: inline-block;
                    animation: float-animation 3s ease-in-out infinite;
                }
                
                .empty-icon-container::before {
                    content: '';
                    position: absolute;
                    width: 80px;
                    height: 20px;
                    background: rgba(0, 0, 0, 0.05);
                    border-radius: 50%;
                    bottom: -10px;
                    left: 50%;
                    transform: translateX(-50%);
                    filter: blur(5px);
                    animation: shadow-animation 3s ease-in-out infinite;
                }
                
                @keyframes float-animation {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-15px); }
                }
                
                @keyframes shadow-animation {
                    0%, 100% { transform: translateX(-50%) scale(1); opacity: 0.3; }
                    50% { transform: translateX(-50%) scale(0.8); opacity: 0.1; }
                }
                
                .create-project-button {
                    background: linear-gradient(135deg, #4361ee, #3a0ca3);
                    border: none;
                    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
                    transition: all 0.3s ease;
                }
                
                .create-project-button:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
                    background: linear-gradient(135deg, #3a56e4, #2f09a0);
                }
            `;
            document.head.appendChild(style);
            
            // Add event listener to the create project button
            const createBtn = document.querySelector('.create-project-button');
            if (createBtn) {
                createBtn.addEventListener('click', function() {
                document.getElementById('new-project-tab').click();
            });
            }
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
                const supervisorInput = document.getElementById('supervisor');
                const supervisorIdInput = document.getElementById('supervisorId');
                
                if (typeof project.supervisor === 'string') {
                    // Simple string supervisor name
                    supervisorInput.value = project.supervisor;
                    supervisorIdInput.value = ''; // No ID available for string supervisors
                } else if (typeof project.supervisor === 'object') {
                    // Structured supervisor object
                    if (project.supervisor.name) {
                        supervisorInput.value = project.supervisor.name;
                        
                        // Try to find the faculty ID if available
                        if (project.supervisor.userId && project.supervisor.userId.$oid) {
                            supervisorIdInput.value = project.supervisor.userId.$oid;
                        } else {
                            // Try to match by name in faculty data
                            const matchingFaculty = allFacultyData.find(faculty => 
                                faculty.name.toLowerCase() === project.supervisor.name.toLowerCase()
                            );
                            if (matchingFaculty) {
                                // Extract the ObjectId string properly
                                let facultyId;
                                if (matchingFaculty._id && typeof matchingFaculty._id === 'object' && matchingFaculty._id.$oid) {
                                    facultyId = matchingFaculty._id.$oid;
                                } else {
                                    facultyId = String(matchingFaculty._id);
                                }
                                supervisorIdInput.value = facultyId;
                            } else {
                                supervisorIdInput.value = ''; // Custom supervisor
                            }
                        }
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
                project.members.forEach((member, index) => {
                    const row = document.createElement('div');
                    row.className = 'row mb-2 member-row';
                    const memberUserId = member.userId && member.userId.$oid ? member.userId.$oid : '';
                    
                    // Check if this member is the creator (first member or matches current user)
                    const isCreator = (index === 0 && member.role === 'Creator') || 
                                     (currentUserData && memberUserId === currentUserData.id) ||
                                     member.role === 'Creator';
                    
                    row.innerHTML = `
                        <div class="col-md-3">
                            <div class="student-search-container position-relative">
                                <input type="text" class="form-control member-name student-search" placeholder="Type to search students..." autocomplete="off" required value="${member.name || ''}" ${isCreator ? 'readonly' : ''}>
                                <input type="hidden" class="member-student-id" value="${memberUserId}">
                                <div class="student-dropdown">
                                    <!-- Student options will be populated here -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control member-role" placeholder="Role (e.g., Author, Researcher)" value="${member.role || ''}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control member-contribution" placeholder="Contribution %" min="0" max="100" value="${member.contribution || 0}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control member-userid" placeholder="User ID (optional)" value="${memberUserId}">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger remove-member" ${isCreator ? 'disabled' : ''}>
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                    
                    membersContainer.appendChild(row);
                    
                    // Apply creator styling if this is the creator
                    if (isCreator) {
                        const studentInput = row.querySelector('.member-name.student-search');
                        const removeBtn = row.querySelector('.remove-member');
                        
                        // Style the creator field
                        if (studentInput) {
                            studentInput.style.backgroundColor = 'transparent';
                            studentInput.style.color = 'var(--text-secondary, #6c757d)';
                            
                            // Add creator badge
                            const creatorBadge = document.createElement('small');
                            creatorBadge.className = 'text-primary mt-1 d-block';
                            creatorBadge.innerHTML = '<i class="bi bi-person-fill me-1"></i>Project Creator';
                            studentInput.parentElement.appendChild(creatorBadge);
                        }
                        
                        // Style the remove button
                        if (removeBtn) {
                            removeBtn.title = 'Cannot remove project creator';
                            removeBtn.style.opacity = '0.5';
                        }
                    }
                    
                    // Setup student search functionality for this row (will skip readonly fields)
                    setupStudentSearch(row);
                    
                    // Add event listener to remove button
                    row.querySelector('.remove-member').addEventListener('click', function() {
                        if (!this.disabled) {
                            row.remove();
                        }
                    });
                });
            } else {
                // Add at least one empty row
                addMemberRow();
                
                // Auto-populate with creator if available
                setTimeout(() => {
                    if (currentUserData) {
                        const firstMemberRow = document.querySelector('.member-row');
                        if (firstMemberRow) {
                            populateCurrentUserInFirstRow(firstMemberRow);
                        }
                    }
                }, 100);
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
            // Simplified approach with better error handling
            if (confirm(`Are you sure you want to delete "${projectTitle}"? This action cannot be undone.`)) {
                // Show spinner
                showSpinner();
                
                // Log what we're trying to delete for debugging
                console.log("Attempting to delete project:", projectId, projectTitle);
                
                // Send delete request
                fetch('src/model/delete_project.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ projectId: projectId })
                })
                .then(response => {
                    console.log("Delete response status:", response.status);
                    return response.json();
                })
                .then(data => {
                    hideSpinner();
                    console.log("Delete response data:", data);
                    
                    if (data.success) {
                        showToast('Success', 'Project deleted successfully', 'success');
                        loadUserProjects();
                    } else {
                        showToast('Error', data.message || 'Failed to delete project', 'error');
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Error deleting project:', error);
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
                                    <div class="mb-2">
                                        <label for="timelineTitle" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="timelineTitle" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="timelineDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="timelineDescription" rows="3"></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label for="timelineDate" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="timelineDate" required>
                                    </div>
                                    <div class="mb-2">
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
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="saveTimelineChanges">Save</button>
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
        
        // Student Management Functions
        function loadStudentsForDropdown() {
            // Check if global students data is available
            if (window.studentsData && window.studentsData.length > 0) {
                allStudentsData = window.studentsData;
                return;
            }
            
            // If global data is not available, fetch it directly
            fetch('src/model/load_students.php')
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        // Store globally for future use
                        window.studentsData = data;
                        allStudentsData = data;
                        console.log('Students loaded:', allStudentsData.length);
                    } else {
                        console.error('No students data received');
                        showToast('Warning', 'Could not load students data for team member dropdown', 'warning');
                    }
                })
                .catch(error => {
                    console.error('Error fetching students data:', error);
                    showToast('Warning', 'Could not load students data for team member dropdown', 'warning');
                });
        }
        
        function setupStudentSearch(memberRow) {
            const studentInput = memberRow.querySelector('.member-name.student-search');
            const studentDropdown = memberRow.querySelector('.student-dropdown');
            const studentIdInput = memberRow.querySelector('.member-student-id');
            
            if (!studentInput || !studentDropdown) return;
            
            // Skip setup for readonly fields (creator's row)
            if (studentInput.hasAttribute('readonly')) {
                return;
            }
            
            let currentHighlightedIndex = -1;
            
            // Input event for filtering
            studentInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                filterAndDisplayStudents(searchTerm, studentDropdown, () => {
                    currentHighlightedIndex = -1;
                });
            });
            
            // Focus event to show dropdown
            studentInput.addEventListener('focus', function() {
                const searchTerm = this.value.toLowerCase().trim();
                filterAndDisplayStudents(searchTerm, studentDropdown, () => {
                    currentHighlightedIndex = -1;
                });
            });
            
            // Blur event to hide dropdown (with delay for clicks)
            studentInput.addEventListener('blur', function() {
                setTimeout(() => {
                    hideStudentDropdown(studentDropdown);
                }, 150);
            });
            
            // Keyboard navigation
            studentInput.addEventListener('keydown', function(e) {
                const options = studentDropdown.querySelectorAll('.student-option');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    currentHighlightedIndex = Math.min(currentHighlightedIndex + 1, options.length - 1);
                    updateStudentHighlight(options, currentHighlightedIndex);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    currentHighlightedIndex = Math.max(currentHighlightedIndex - 1, -1);
                    updateStudentHighlight(options, currentHighlightedIndex);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (currentHighlightedIndex >= 0 && options[currentHighlightedIndex]) {
                        selectStudent(options[currentHighlightedIndex], studentInput, studentIdInput, studentDropdown);
                    }
                } else if (e.key === 'Escape') {
                    hideStudentDropdown(studentDropdown);
                }
            });
        }
        
        function filterAndDisplayStudents(searchTerm, dropdown, callback) {
            if (!allStudentsData || allStudentsData.length === 0) {
                dropdown.innerHTML = '<div class="student-no-results">No students data available</div>';
                dropdown.classList.add('show');
                return;
            }
            
            // Filter students based on search term
            const filteredStudents = allStudentsData.filter(student => 
                student.name.toLowerCase().includes(searchTerm) ||
                student.student_id.toLowerCase().includes(searchTerm)
            );
            
            // Clear previous options
            dropdown.innerHTML = '';
            
            if (filteredStudents.length === 0) {
                dropdown.innerHTML = '<div class="student-no-results">No students found matching your search</div>';
            } else {
                filteredStudents.forEach(student => {
                    const option = document.createElement('div');
                    option.className = 'student-option';
                    option.innerHTML = `
                        <div>
                            <div class="student-name">${student.name}</div>
                            <div class="student-info">ID: ${student.student_id}</div>
                        </div>
                    `;
                    
                    // Store student data in the element
                    option.studentData = student;
                    
                    // Click handler
                    option.addEventListener('click', function() {
                        const studentInput = dropdown.closest('.member-row').querySelector('.member-name.student-search');
                        const studentIdInput = dropdown.closest('.member-row').querySelector('.member-student-id');
                        selectStudent(this, studentInput, studentIdInput, dropdown);
                    });
                    
                    dropdown.appendChild(option);
                });
            }
            
            dropdown.classList.add('show');
            
            // Force the dropdown to appear above the input by default
            // Only reposition downward if there's not enough space above
            const containerRect = dropdown.closest('.student-search-container').getBoundingClientRect();
            const spaceAbove = containerRect.top;
            
            // If there's not enough space above, position it below instead
            if (spaceAbove < 220) { // 220px accounts for dropdown height + some padding
                dropdown.style.bottom = 'auto';
                dropdown.style.top = '100%';
                dropdown.style.borderRadius = '0 0 var(--border-radius) var(--border-radius)';
                dropdown.style.borderTop = 'none';
                dropdown.style.borderBottom = '1px solid var(--border)';
                dropdown.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
            } else {
                // Reset to upward positioning (default)
                dropdown.style.bottom = '100%';
                dropdown.style.top = 'auto';
                dropdown.style.borderRadius = 'var(--border-radius) var(--border-radius) 0 0';
                dropdown.style.borderTop = '1px solid var(--border)';
                dropdown.style.borderBottom = 'none';
                dropdown.style.boxShadow = '0 -4px 12px rgba(0, 0, 0, 0.15)';
            }
            
            if (callback) callback();
        }
        
        function selectStudent(option, input, hiddenInput, dropdown) {
            const studentData = option.studentData;
            if (studentData) {
                input.value = studentData.name;
                hiddenInput.value = studentData.id;
                hideStudentDropdown(dropdown);
                
                // Trigger change event
                input.dispatchEvent(new Event('change'));
            }
        }
        
        function updateStudentHighlight(options, index) {
            options.forEach((option, i) => {
                if (i === index) {
                    option.classList.add('highlighted');
                } else {
                    option.classList.remove('highlighted');
                }
            });
        }
        
        function hideStudentDropdown(dropdown) {
            dropdown.classList.remove('show');
        }
        
        // Current User Management Functions
        function loadCurrentUser() {
            fetch('src/model/get_current_user.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.isLoggedIn && data.user) {
                        currentUserData = data.user;
                        console.log('Current user loaded:', currentUserData);
                        
                        // Auto-populate the first member row with current user data
                        const firstMemberRow = document.querySelector('.member-row');
                        if (firstMemberRow) {
                            populateCurrentUserInFirstRow(firstMemberRow);
                        }
                    } else {
                        console.log('User not logged in or no user data available');
                        currentUserData = null;
                    }
                })
                .catch(error => {
                    console.error('Error fetching current user data:', error);
                    currentUserData = null;
                });
        }
        
        function populateCurrentUserInFirstRow(memberRow) {
            if (!currentUserData) return;
            
            const studentInput = memberRow.querySelector('.member-name.student-search');
            const studentIdInput = memberRow.querySelector('.member-student-id');
            const roleInput = memberRow.querySelector('.member-role');
            const contributionInput = memberRow.querySelector('.member-contribution');
            const userIdInput = memberRow.querySelector('.member-userid');
            
            if (studentInput && studentIdInput && roleInput && contributionInput && userIdInput) {
                // Populate the fields with current user data
                studentInput.value = currentUserData.name;
                studentIdInput.value = currentUserData.id;
                roleInput.value = currentUserData.role;
                contributionInput.value = currentUserData.contribution;
                userIdInput.value = currentUserData.id;
                
                // Mark the input as readonly to prevent accidental changes to creator info
                studentInput.setAttribute('readonly', true);
                studentInput.style.backgroundColor = 'transparent';
                studentInput.style.color = 'var(--text-secondary, #6c757d)';
                
                // Add a visual indicator that this is the creator
                const creatorBadge = document.createElement('small');
                creatorBadge.className = 'text-primary mt-1 d-block';
                creatorBadge.innerHTML = '<i class="bi bi-person-fill me-1"></i>Project Creator';
                studentInput.parentElement.appendChild(creatorBadge);
                
                // Disable the remove button for the creator's row
                const removeBtn = memberRow.querySelector('.remove-member');
                if (removeBtn) {
                    removeBtn.disabled = true;
                    removeBtn.title = 'Cannot remove project creator';
                    removeBtn.style.opacity = '0.5';
                }
            }
        }
    });
    </script>
</body>
</html> 
