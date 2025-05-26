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
        }
        
        .form-select option {
            background-color: rgba(15, 23, 42, 0.95);
            color: rgba(255, 255, 255, 0.9);
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
                                            <div class="mb-3">
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
                                                    <div class="mb-3">
                                                        <label for="supervisor" class="form-label">Project Supervisor</label>
                                                        <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Supervisor Name">
                                                    </div>
                                                    
                                                    <label class="form-label">Team Members</label>
                                                    <div id="membersContainer">
                                                        <div class="row mb-2 member-row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control member-name" placeholder="Member Name" required>
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
                                                                <button type="button" class="btn btn-outline-danger remove-member" disabled>
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
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
    
    <style>
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
    </style>

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
        
        // Initialize - Load user's projects
        loadUserProjects();
        
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
            const url = isEditing ? 'src/model/update_project.php' : 'src/model/create_project.php';
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideSpinner();
                
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
            })
            .catch(error => {
                hideSpinner();
                console.error('Error:', error);
                showToast('Error', 'An error occurred. Please try again.', 'error');
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
            row.innerHTML = `
                <div class="col-md-3">
                    <input type="text" class="form-control member-name" placeholder="Member Name" required>
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
                
                if (name) {
                    const member = {
                        name: name,
                        role: role || 'Author',
                        contribution: contribution
                    };
                    
                    if (userId) {
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
                            // Only display projects created by the current user
                            if (isLoggedIn) {
                                const userId = data.debug?.userId || null;
                                
                                // Filter projects to only show those created by the current user
                                const userProjects = data.projects.filter(project => {
                                    // Check if user is in the members list
                                    if (project.members && project.members.length > 0) {
                                        return project.members.some(member => 
                                            (member.userId && member.userId.$oid === userId) || 
                                            (member.userId === userId)
                                        );
                                    }
                                    return false;
                                });
                                
                                if (userProjects.length > 0) {
                                    displayUserProjects(userProjects, false);
                        } else {
                                    displayEmptyState('Ready to Innovate?', 
                                        `Transform your ideas into groundbreaking research projects. Share your discoveries with the academic community and make an impact.`);
                                }
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
                if (typeof project.supervisor === 'string') {
                    document.getElementById('supervisor').value = project.supervisor;
                } else if (typeof project.supervisor === 'object') {
                    // In the structured format, supervisor has name, role, and userId
                    if (project.supervisor.name) {
                        document.getElementById('supervisor').value = project.supervisor.name;
                    } else if (project.supervisor.userId && project.supervisor.userId.$oid) {
                        document.getElementById('supervisor').value = project.supervisor.userId.$oid;
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
                project.members.forEach(member => {
                    const row = document.createElement('div');
                    row.className = 'row mb-2 member-row';
                    row.innerHTML = `
                        <div class="col-md-3">
                            <input type="text" class="form-control member-name" placeholder="Member Name" required value="${member.name || ''}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control member-role" placeholder="Role (e.g., Author, Researcher)" value="${member.role || ''}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control member-contribution" placeholder="Contribution %" min="0" max="100" value="${member.contribution || 0}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control member-userid" placeholder="User ID (optional)" value="${member.userId && member.userId.$oid ? member.userId.$oid : ''}">
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
                });
            } else {
                // Add at least one empty row
                addMemberRow();
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
    });
    </script>
</body>
</html> 
