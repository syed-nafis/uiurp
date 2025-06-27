<?php
session_start();

// Define a constant to indicate this is the edit_project.php file
// This is used by included files like timeline_editor_overlay.php
define('INCLUDED_IN_EDIT_PROJECT', true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project | UIU Research Portal</title>
    
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
        
        /* ===== LIGHT MODE STYLES ===== */
        [data-theme="light"] {
            /* Light mode color variables */
            --primary: #2563eb;
            --secondary: #8b5cf6;
            --accent: #0ea5e9;
            --background: #f8fafc;
            --surface: #ffffff;
            --surface-light: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --border-light: #cbd5e1;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            
            /* Glass morphism for light mode */
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(148, 163, 184, 0.2);
            
            /* Gradients for light mode */
            --gradient-primary: linear-gradient(135deg, #2563eb, #8b5cf6);
            --gradient-surface: linear-gradient(135deg, #ffffff, #f8fafc);
            
            /* Shadows for light mode */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            color: var(--text-primary);
        }

        /* Background effects in light mode */
        [data-theme="light"] .floating-orb {
            opacity: 0.2;
        }

        [data-theme="light"] .orb-1 {
            background: radial-gradient(circle, rgba(37, 99, 235, 0.15) 0%, rgba(37, 99, 235, 0.05) 50%, transparent 70%);
        }

        [data-theme="light"] .orb-2 {
            background: radial-gradient(circle, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0.04) 50%, transparent 70%);
        }

        [data-theme="light"] .orb-3 {
            background: radial-gradient(circle, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.05) 50%, transparent 70%);
        }

        [data-theme="light"] .cyber-grid {
            background-image: 
                linear-gradient(to right, rgba(37, 99, 235, 0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(37, 99, 235, 0.08) 1px, transparent 1px);
        }

        /* Header container in light mode */
        [data-theme="light"] .header-container {
            background: linear-gradient(135deg, 
                rgba(248, 250, 252, 0.95) 0%, 
                rgba(241, 245, 249, 0.9) 50%,
                rgba(37, 99, 235, 0.1) 100%);
        }

        [data-theme="light"] .header-container::before {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="circuit" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M0,10 L10,10 L10,0 L20,0 M10,10 L10,20 M10,15 L20,15" stroke="rgba(37,99,235,0.08)" stroke-width="0.5" fill="none"/></pattern></defs><rect width="100" height="100" fill="url(%23circuit)"/></svg>');
            opacity: 0.8;
        }

        [data-theme="light"] .header-container::after {
            background: radial-gradient(ellipse 80% 100% at 50% 0%, 
                rgba(37, 99, 235, 0.15) 0%, 
                rgba(14, 165, 233, 0.1) 30%,
                rgba(6, 182, 212, 0.05) 60%,
                transparent 100%);
        }

        [data-theme="light"] .hero-title {
            background: linear-gradient(135deg, #0f172a 0%, #2563eb 70%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .text-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #2563eb 70%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        [data-theme="light"] .header-container p {
            color: var(--text-secondary) !important;
        }

        /* Cards in light mode */
        [data-theme="light"] .card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border-color: rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .card-header {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(139, 92, 246, 0.05));
            border-bottom: 1px solid var(--glass-border);
            color: var(--text-primary);
        }

        [data-theme="light"] .card-header i {
            color: var(--primary);
        }

        /* Form elements in light mode */
        [data-theme="light"] .form-label {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .form-control,
        [data-theme="light"] .form-select {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] .form-control:focus,
        [data-theme="light"] .form-select:focus {
            background: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
            color: var(--text-primary);
        }

        [data-theme="light"] .form-control::placeholder {
            color: var(--text-muted);
        }

        [data-theme="light"] .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        [data-theme="light"] .form-select:hover {
            border-color: var(--primary);
            background-color: var(--surface-light);
        }

        [data-theme="light"] .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
            background-color: var(--surface);
        }

        [data-theme="light"] .form-select option {
            background-color: var(--surface);
            color: var(--text-primary);
            padding: 0.5rem;
        }

        [data-theme="light"] .form-select option:hover,
        [data-theme="light"] .form-select option:focus {
            background-color: var(--surface-light);
        }

        [data-theme="light"] .form-select option:checked {
            background-color: var(--primary);
            color: white;
        }

        /* File input in light mode */
        [data-theme="light"] .form-control[type="file"] {
            background: var(--surface);
            border: 2px dashed var(--border);
            color: var(--text-secondary);
        }

        [data-theme="light"] .form-control[type="file"]:hover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        [data-theme="light"] .form-control[type="file"]:focus {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        [data-theme="light"] .form-control[type="file"]::file-selector-button {
            background: linear-gradient(135deg, var(--primary), rgba(139, 92, 246, 0.8));
            color: white;
            border: none;
        }

        [data-theme="light"] .form-control[type="file"]::file-selector-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        [data-theme="light"] .file-upload-btn {
            background: var(--surface);
            border: 2px dashed var(--border);
            color: var(--text-muted);
        }

        [data-theme="light"] .file-upload-btn:hover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
            color: var(--text-primary);
        }

        /* Buttons in light mode */
        [data-theme="light"] .btn-primary {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary);
        }

        [data-theme="light"] .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
            color: white;
        }

        [data-theme="light"] .btn-outline-primary {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        [data-theme="light"] .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        [data-theme="light"] .btn-outline-secondary {
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            background: transparent;
        }

        [data-theme="light"] .btn-outline-secondary:hover {
            background: var(--surface-light);
            color: var(--text-primary);
            border-color: var(--border-light);
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

        /* Keywords and badges in light mode */
        [data-theme="light"] .keyword-badge {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .keyword-badge:hover {
            background: rgba(37, 99, 235, 0.15);
            border-color: var(--primary);
        }

        /* Member rows in light mode */
        [data-theme="light"] .member-row {
            background: rgba(241, 245, 249, 0.8);
            border: 1px solid var(--border);
        }

        [data-theme="light"] .member-row:hover {
            border-color: var(--primary);
            background: rgba(241, 245, 249, 1);
        }

        /* Timeline styles in light mode */
        [data-theme="light"] .timeline-item {
            background: var(--glass-bg);
            border: 2px solid var(--glass-border);
            color: var(--text-primary);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .timeline-item:hover {
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .timeline-date {
            color: var(--primary) !important;
        }

        [data-theme="light"] .timeline-date i {
            color: var(--primary) !important;
        }

        [data-theme="light"] .timeline-item h6 {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .timeline-item p {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .timeline-controls .btn {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        [data-theme="light"] .timeline-controls .btn:hover {
            background: var(--surface-light);
            border-color: var(--primary);
        }

        [data-theme="light"] .timeline-controls .btn-outline-primary:hover {
            color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        [data-theme="light"] .timeline-controls .btn-outline-danger:hover {
            color: var(--error);
            background: rgba(239, 68, 68, 0.05);
            border-color: var(--error);
        }

        /* Status badges in light mode */
        [data-theme="light"] .status-completed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-color: rgba(16, 185, 129, 0.2);
        }

        [data-theme="light"] .status-in-progress {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border-color: rgba(37, 99, 235, 0.2);
        }

        [data-theme="light"] .status-planned {
            background: rgba(139, 92, 246, 0.1);
            color: var(--secondary);
            border-color: rgba(139, 92, 246, 0.2);
        }

        [data-theme="light"] .status-delayed {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
            border-color: rgba(239, 68, 68, 0.2);
        }

        /* Timeline Edit Modal in light mode */
        [data-theme="light"] #timelineEditModal .modal-content {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] #timelineEditModal .modal-footer {
            background: var(--surface-light);
        }

        [data-theme="light"] #timelineEditModal .form-control,
        [data-theme="light"] #timelineEditModal .form-select {
            background: var(--surface) !important;
            border-color: var(--border) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="light"] #timelineEditModal .form-control:focus,
        [data-theme="light"] #timelineEditModal .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1) !important;
        }

        [data-theme="light"] #timelineEditModal select[multiple] {
            background: var(--surface) !important;
        }

        [data-theme="light"] #timelineEditModal select[multiple] option {
            background: var(--surface) !important;
            border-color: var(--border);
        }

        [data-theme="light"] #timelineEditModal select[multiple] option:hover {
            background: rgba(37, 99, 235, 0.05) !important;
        }

        [data-theme="light"] #timelineEditModal select[multiple] option:checked {
            background: var(--primary) !important;
            color: white !important;
        }

        /* Dropdown styling in light mode */
        [data-theme="light"] .supervisor-dropdown,
        [data-theme="light"] .student-dropdown {
            background: var(--surface);
            border-color: var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .supervisor-option,
        [data-theme="light"] .student-option {
            color: var(--text-primary);
            border-bottom-color: var(--border);
        }

        [data-theme="light"] .supervisor-option:hover,
        [data-theme="light"] .supervisor-option.highlighted,
        [data-theme="light"] .student-option:hover,
        [data-theme="light"] .student-option.highlighted {
            background: rgba(37, 99, 235, 0.08);
            color: var(--primary);
        }

        [data-theme="light"] .supervisor-option .faculty-info,
        [data-theme="light"] .student-option .student-info {
            color: var(--text-muted);
        }

        [data-theme="light"] .supervisor-no-results,
        [data-theme="light"] .student-no-results {
            color: var(--text-muted);
        }

        /* Search input styling in light mode */
        [data-theme="light"] #supervisor {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
        }

        [data-theme="light"] .member-name.student-search {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
        }

        /* References container in light mode */
        [data-theme="light"] #references-container {
            background: rgba(241, 245, 249, 0.8);
            border: 1px solid var(--border);
        }

        [data-theme="light"] .reference-item {
            background: var(--surface);
            border: 1px solid var(--border);
        }

        [data-theme="light"] .reference-item:hover {
            border-color: var(--primary);
            background: var(--surface-light);
        }

        /* Toast notifications in light mode */
        [data-theme="light"] .toast {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .toast-header {
            border-bottom: 1px solid var(--glass-border);
        }

        [data-theme="light"] .toast-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .toast-body {
            color: var(--text-secondary);
        }

        [data-theme="light"] .toast-close {
            color: var(--text-muted);
        }

        /* Footer in light mode */
        [data-theme="light"] footer {
            background: linear-gradient(135deg, var(--surface) 0%, var(--surface-light) 100%);
            border-top: 1px solid var(--border);
            color: var(--text-primary);
        }

        [data-theme="light"] footer::before {
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.3), transparent);
        }

        /* Alert styling in light mode */
        [data-theme="light"] .alert {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
        }

        [data-theme="light"] .alert-warning {
            background: rgba(245, 158, 11, 0.05);
            border-color: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        [data-theme="light"] .alert-danger {
            background: rgba(239, 68, 68, 0.05);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--error);
        }

        [data-theme="light"] .alert-success {
            background: rgba(16, 185, 129, 0.05);
            border-color: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        [data-theme="light"] .alert-info {
            background: rgba(14, 165, 233, 0.05);
            border-color: rgba(14, 165, 233, 0.2);
            color: var(--accent);
        }

        /* Spinner in light mode */
        [data-theme="light"] .spinner-overlay {
            background: rgba(248, 250, 252, 0.8);
        }

        [data-theme="light"] .spinner {
            border: 3px solid rgba(37, 99, 235, 0.2);
            border-top: 3px solid var(--primary);
        }

        /* Misc elements in light mode */
        [data-theme="light"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .text-secondary {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .text-primary {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .bg-light {
            background-color: var(--surface) !important;
        }

        [data-theme="light"] .border {
            border-color: var(--border) !important;
        }

        [data-theme="light"] .border-primary {
            border-color: var(--primary) !important;
        }

        [data-theme="light"] hr {
            border-color: var(--border);
            opacity: 0.3;
        }

        [data-theme="light"] code {
            background: rgba(241, 245, 249, 0.8);
            color: var(--accent);
        }

        [data-theme="light"] pre {
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        [data-theme="light"] blockquote {
            border-left: 4px solid var(--primary);
            background: rgba(37, 99, 235, 0.05);
            color: var(--text-primary);
        }

        [data-theme="light"] mark {
            background: rgba(245, 158, 11, 0.2);
            color: var(--text-primary);
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
        }
        
        /* Modern Card Design */
        .card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius-lg);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-xl);
            transition: var(--transition);
            overflow: hidden;
            position: relative;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            z-index: 1;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: rgba(37, 99, 235, 0.3);
        }
        
        .card-header {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(139, 92, 246, 0.1));
            border-bottom: 1px solid var(--glass-border);
            padding: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.1rem;
            position: relative;
            z-index: 2;
        }
        
        .card-body {
            padding: 2rem;
            color: var(--text-primary);
            position: relative;
            z-index: 2;
        }
        
        /* Form Controls */
        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }
        
        .form-control, .form-select {
            background: rgba(51, 65, 85, 0.6);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(51, 65, 85, 0.8);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            color: var(--text-primary);
        }
        
        .form-control::placeholder {
            color: var(--text-muted);
        }
        
        /* Buttons */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
        }
        
        .btn-outline-primary {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        
        .btn-outline-secondary {
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            background: transparent;
        }
        
        .btn-outline-secondary:hover {
            background: var(--surface-light);
            color: var(--text-primary);
            border-color: var(--border-light);
        }
        
        .btn-outline-danger {
            border: 1px solid var(--error);
            color: var(--error);
            background: transparent;
        }
        
        .btn-outline-danger:hover {
            background: var(--error);
            color: white;
            transform: translateY(-1px);
        }
        
        /* Loading States */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .spinner-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(37, 99, 235, 0.3);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
        }
        
        .toast {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: var(--border-radius);
            backdrop-filter: blur(20px);
            margin-bottom: 10px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
            min-width: 300px;
            box-shadow: var(--shadow-lg);
        }
        
        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        .toast-header {
            padding: 1rem;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .toast-title {
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .toast-close {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toast-body {
            padding: 1rem;
            color: var(--text-secondary);
        }
        
        .toast.error {
            border-left: 4px solid var(--error);
        }
        
        .toast.success {
            border-left: 4px solid var(--success);
        }
        
        .toast.warning {
            border-left: 4px solid var(--warning);
        }
        
        .toast.info {
            border-left: 4px solid var(--accent);
        }
        
        /* File Upload Styling */
        .file-upload {
            position: relative;
            overflow: hidden;
            margin-top: 10px;
            width: 100%;
        }
        
        .file-upload-btn {
            background: rgba(51, 65, 85, 0.6);
            border: 2px dashed var(--border);
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-muted);
        }
        
        .file-upload-btn:hover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
            color: var(--text-primary);
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        
        .preview-image {
            max-width: 100%;
            max-height: 200px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
        }
        
        /* Keywords and Tags */
        .keyword-badge {
            background: rgba(37, 99, 235, 0.2);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.3);
            border-radius: 20px;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            margin: 0.2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }
        
        .keyword-badge:hover {
            background: rgba(37, 99, 235, 0.3);
            border-color: var(--primary);
        }
        
        .keyword-badge .remove-keyword {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            padding: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }
        
        /* Member rows */
        .member-row {
            background: rgba(51, 65, 85, 0.3);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }
        
        .member-row:hover {
            border-color: var(--primary);
            background: rgba(51, 65, 85, 0.5);
        }
        
        /* Timeline styles - Enhanced for Dark/Light Mode */
        .timeline-item {
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
        
        .timeline-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0.3;
        }
        
        .timeline-item.grabbing {
            cursor: grabbing;
            transform: scale(1.02);
        }
        
        .timeline-item:hover {
            border-color: var(--primary);
            background: var(--surface-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
            border-left-color: var(--accent);
        }
        
        .timeline-item.completed {
            border-left-color: var(--success);
        }
        
        .timeline-item.completed:hover {
            border-left-color: var(--success);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
        }
        
        .timeline-item.in-progress {
            border-left-color: var(--primary);
        }
        
        .timeline-item.planned {
            border-left-color: var(--secondary);
        }
        
        .timeline-item.planned:hover {
            border-left-color: var(--secondary);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.15);
        }
        
        .timeline-item.delayed {
            border-left-color: var(--error);
        }
        
        .timeline-item.delayed:hover {
            border-left-color: var(--error);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.15);
        }
        
        .timeline-date {
            color: var(--primary) !important;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .timeline-date i {
            margin-right: 0.75rem;
            color: var(--primary) !important;
            font-size: 1.1rem;
        }
        
        .timeline-controls {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .timeline-item h6 {
            color: var(--text-primary) !important;
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }
        
        .timeline-item p {
            color: var(--text-secondary) !important;
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }
        
        /* Light mode adjustments for timeline */
        [data-theme="light"] .timeline-item {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 0, 0, 0.1);
        }
        
        [data-theme="light"] .timeline-item:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--primary);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Timeline action buttons */
        .timeline-controls .btn {
            padding: 0.25rem 0.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--border);
            background: rgba(51, 65, 85, 0.6);
            color: var(--text-secondary);
            transition: var(--transition);
            font-size: 0.8rem;
        }
        
        .timeline-controls .btn:hover {
            transform: translateY(-1px);
            background: rgba(51, 65, 85, 0.8);
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
        }
        
        .timeline-controls .btn-outline-primary:hover {
            color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
        }
        
        .timeline-controls .btn-outline-danger:hover {
            color: var(--error);
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--error);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 500;
            border-radius: 1rem;
            margin-left: 0.5rem;
            position: relative;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .status-completed {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
            border-color: rgba(16, 185, 129, 0.3);
        }
        
        .status-in-progress {
            background: rgba(37, 99, 235, 0.2);
            color: var(--primary);
            border-color: rgba(37, 99, 235, 0.3);
        }
        
        .status-planned {
            background: rgba(139, 92, 246, 0.2);
            color: var(--secondary);
            border-color: rgba(139, 92, 246, 0.3);
        }
        
        .status-delayed {
            background: rgba(239, 68, 68, 0.2);
            color: var(--error);
            border-color: rgba(239, 68, 68, 0.3);
        }
        
        /* Assignment information styling */
        .assignment-info {
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid var(--glass-border);
        }
        
        .assignment-info .bi {
            margin-right: 0.25rem;
            opacity: 0.7;
        }
        
        .assignment-info span {
            display: inline-block;
            margin-right: 1rem;
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        .assignment-info strong {
            color: var(--primary);
        }
        
        /* Timeline Edit Modal Styling - Minimal Modern Design */
        #timelineEditModal .modal-content {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            color: var(--text-primary);
            max-height: 90vh; /* Prevent modals from being taller than the viewport */
            overflow-y: auto;
        }
        
        #timelineEditModal .modal-header {
            border-bottom: 1px solid var(--glass-border);
            padding: 0.8rem 1.25rem;
            background: var(--surface);
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            position: relative;
        }
        
        #timelineEditModal .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            border-radius: var(--border-radius) 0 0 0;
        }
        
        #timelineEditModal .modal-footer {
            border-top: 1px solid var(--glass-border);
            padding: 0.75rem 1.25rem;
            background: var(--surface);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }
        
        #timelineEditModal .modal-body {
            padding: 1rem 1.25rem;
        }
        
        #timelineEditModal .modal-title {
            color: var(--primary) !important;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        #timelineEditModal .modal-header p {
            color: var(--text-secondary) !important;
            margin: 0;
            font-size: 0.8rem;
        }
        
        #timelineEditModal .modal-header i {
            color: var(--primary) !important;
        }
        
        #timelineEditModal .btn-close {
            opacity: 0.7;
            width: 24px;
            height: 24px;
            padding: 0;
            transition: all 0.2s ease;
        }
        
        #timelineEditModal .btn-close:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        
        /* Form Layouts - Compact */
        #timelineEditModal .row {
            margin-bottom: 0.75rem;
        }
        
        /* Form Labels - Compact */
        #timelineEditModal .form-label {
            color: var(--text-primary) !important;
            font-weight: 500;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            font-size: 0.85rem;
        }
        
        #timelineEditModal .form-label i {
            color: var(--primary) !important;
            font-size: 0.9rem;
            margin-right: 0.35rem;
        }
        
        /* Form Controls - Compact */
        #timelineEditModal .form-control,
        #timelineEditModal .form-select {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-primary) !important;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }
        
        #timelineEditModal .form-control:focus,
        #timelineEditModal .form-select:focus {
            background: var(--surface) !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1) !important;
            color: var(--text-primary) !important;
        }
        
        #timelineEditModal .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.7;
        }
        
        /* Section Headers in Modal - More Minimal */
        #timelineEditModal .section-header h6 {
            color: var(--primary) !important;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            letter-spacing: 0.3px;
        }
        
        #timelineEditModal .section-header h6 i {
            color: var(--primary) !important;
            margin-right: 0.4rem;
            font-size: 1rem;
        }
        
        /* More compact form text */
        #timelineEditModal .form-text {
            font-size: 0.75rem;
            color: var(--text-muted) !important;
            margin-top: 0.25rem;
        }
        
        #timelineEditModal .form-text i {
            color: var(--text-muted) !important;
            font-size: 0.7rem;
        }
        
        #timelineEditModal .invalid-feedback {
            color: var(--error) !important;
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        /* Multi-select styling - Compact */
        #timelineEditModal select[multiple] {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            border-radius: var(--border-radius);
            padding: 0.4rem;
            color: var(--text-primary) !important;
            max-height: 120px;
        }
        
        #timelineEditModal select[multiple] option {
            background: var(--surface) !important;
            color: var(--text-primary) !important;
            padding: 0.4rem 0.5rem;
            border-radius: 4px;
            margin-bottom: 2px;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        #timelineEditModal select[multiple] option:hover {
            background: var(--surface-light) !important;
        }
        
        #timelineEditModal select[multiple] option:checked {
            background: var(--primary) !important;
            color: white !important;
        }
        
        /* Button styling - Compact */
        #timelineEditModal .d-flex .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
        }
        
        #timelineEditModal .btn-primary {
            background: var(--primary);
            border: none;
            color: white !important;
        }
        
        #timelineEditModal .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
            background: var(--gradient-primary);
        }
        
        #timelineEditModal .btn-outline-secondary {
            border: 1px solid var(--border-light);
            color: var(--text-secondary) !important;
            background: transparent;
        }
        
        #timelineEditModal .btn-outline-secondary:hover {
            background: var(--surface-light);
            border-color: var(--border);
            color: var(--text-primary) !important;
        }
        
        /* Light mode specific adjustments */
        [data-theme="light"] #timelineEditModal .modal-content {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(0, 0, 0, 0.08);
        }
        
        [data-theme="light"] #timelineEditModal .modal-header {
            background: var(--surface);
        }
        
        [data-theme="light"] #timelineEditModal .modal-footer {
            background: var(--surface-light);
        }
        
        [data-theme="light"] #timelineEditModal .form-control,
        [data-theme="light"] #timelineEditModal .form-select {
            background: white !important;
            border-color: var(--border) !important;
        }
        
        [data-theme="light"] #timelineEditModal .form-control:focus,
        [data-theme="light"] #timelineEditModal .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1) !important;
        }
        
        [data-theme="light"] #timelineEditModal select[multiple] {
            background: white !important;
        }
        
        [data-theme="light"] #timelineEditModal select[multiple] option {
            background: white !important;
        }
        
        [data-theme="light"] #timelineEditModal select[multiple] option:hover {
            background: rgba(37, 99, 235, 0.05) !important;
        }
        
        /* Responsive modal */
        @media (max-width: 768px) {
            #timelineEditModal .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100vw - 1rem);
            }
            
            #timelineEditModal .modal-body {
                padding: 0.75rem 1rem;
            }
        }
        
        /* References container */
        #references-container {
            max-height: 400px;
            overflow-y: auto;
            padding: 1rem;
            background: rgba(51, 65, 85, 0.3);
            border-radius: var(--border-radius);
            border: 1px solid var(--border);
        }
        
        .reference-item {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }
        
        .reference-item:hover {
            border-color: var(--primary);
            background: rgba(30, 41, 59, 0.8);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                min-height: 50vh;
                padding: 60px 0 80px;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
        }
        
        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Enhanced Footer */
        footer {
            background: linear-gradient(135deg, var(--surface) 0%, var(--background) 100%);
            border-top: 1px solid var(--border);
            margin-top: 100px;
            position: relative;
            overflow: hidden;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.5), transparent);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--surface);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--border-light);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
        
        /* ===== ADDITIONAL DARK THEME FIXES ===== */
        
        /* Ensure all text elements are properly colored */
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary) !important;
        }
        
        p, span, div, label {
            color: var(--text-primary);
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        .text-secondary {
            color: var(--text-secondary) !important;
        }
        
        /* Form validation states */
        .form-control.is-invalid {
            border-color: var(--error);
            background: rgba(239, 68, 68, 0.1);
        }
        
        .form-control.is-valid {
            border-color: var(--success);
            background: rgba(16, 185, 129, 0.1);
        }
        
        .invalid-feedback {
            color: var(--error);
        }
        
        .valid-feedback {
            color: var(--success);
        }
        
        /* Input group styling */
        .input-group .form-control {
            background: rgba(78, 94, 116, 0);
            border-color: var(--border);
            color: var(--text-primary);
        }
        
        .input-group .btn {
            border-color: var(--border);
        }
        
        /* Small text and help text */
        .form-text, small {
            color: var(--text-muted) !important;
        }
        
        /* Loading states */
        .spinner-border {
            color: var(--primary);
        }
        
        .visually-hidden {
            color: var(--text-primary);
        }
        
        /* Alert styling */
        .alert {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            border-radius: var(--border-radius);
        }
        
        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border-color: rgba(245, 158, 11, 0.3);
            color: var(--warning);
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: var(--error);
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
            color: var(--success);
        }
        
        .alert-info {
            background: rgba(14, 165, 233, 0.1);
            border-color: rgba(14, 165, 233, 0.3);
            color: var(--accent);
        }
        
        /* List group styling */
        .list-group-item {
            background: rgba(51, 65, 85, 0.6);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }
        
        .list-group-item:hover {
            background: rgba(51, 65, 85, 0.8);
            border-color: var(--primary);
        }
        
        /* Badge styling */
        .badge {
            background: var(--primary);
            color: white;
        }
        
        .badge.bg-secondary {
            background: var(--surface-light) !important;
            color: var(--text-primary);
        }
        
        .badge.bg-success {
            background: var(--success) !important;
        }
        
        .badge.bg-warning {
            background: var(--warning) !important;
        }
        
        .badge.bg-danger {
            background: var(--error) !important;
        }
        
        /* Table styling if any */
        .table {
            color: var(--text-primary);
        }
        
        .table-dark {
            background: var(--surface);
            border-color: var(--border);
        }
        
        /* Modal styling if any */
        .modal-content {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(20px);
            color: var(--text-primary);
        }
        
        .modal-header {
            border-bottom: 1px solid var(--border);
        }
        
        .modal-footer {
            border-top: 1px solid var(--border);
        }
        
        /* Dropdown styling */
        .dropdown-menu {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(20px);
            color: var(--text-primary);
        }
        
        .dropdown-item {
            color: var(--text-primary);
        }
        
        .dropdown-item:hover {
            background: rgba(37, 99, 235, 0.2);
            color: var(--text-primary);
        }
        
        /* Progress bar styling */
        .progress {
            background: rgba(51, 65, 85, 0.6);
        }
        
        .progress-bar {
            background: var(--gradient-primary);
        }
        
        /* Nav tabs styling if any */
        .nav-tabs {
            border-bottom: 1px solid var(--border);
        }
        
        .nav-tabs .nav-link {
            color: var(--text-secondary);
            border: 1px solid transparent;
        }
        
        .nav-tabs .nav-link:hover {
            color: var(--text-primary);
            border-color: var(--border);
        }
        
        .nav-tabs .nav-link.active {
            color: var(--text-primary);
            background: var(--surface);
            border-color: var(--border);
        }
        
        /* Pagination styling if any */
        .page-link {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text-primary);
        }
        
        .page-link:hover {
            background: var(--surface-light);
            border-color: var(--primary);
            color: var(--text-primary);
        }
        
        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        /* Breadcrumb styling if any */
        .breadcrumb {
            background: rgba(51, 65, 85, 0.6);
        }
        
        .breadcrumb-item a {
            color: var(--primary);
        }
        
        .breadcrumb-item.active {
            color: var(--text-muted);
        }
        
        /* Card specific fixes */
        .card-title {
            color: var(--text-primary) !important;
        }
        
        .card-text {
            color: var(--text-secondary) !important;
        }
        
        .card-subtitle {
            color: var(--text-muted) !important;
        }
        
        /* Button group styling */
        .btn-group .btn {
            border-color: var(--border);
        }
        
        /* Close button styling */
        .btn-close {
            filter: invert(1);
            opacity: 0.7;
        }
        
        .btn-close:hover {
            opacity: 1;
        }
        
        /* Accordion styling if any */
        .accordion-item {
            background: var(--surface);
            border: 1px solid var(--border);
        }
        
        .accordion-header button {
            background: var(--surface);
            color: var(--text-primary);
        }
        
        .accordion-body {
            background: var(--surface);
            color: var(--text-primary);
        }
        
        /* Offcanvas styling if any */
        .offcanvas {
            background: var(--surface);
            color: var(--text-primary);
        }
        
        .offcanvas-header {
            border-bottom: 1px solid var(--border);
        }
        
        /* Tooltip styling */
        .tooltip .tooltip-inner {
            background: var(--surface);
            color: var(--text-primary);
        }
        
        /* Popover styling */
        .popover {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(20px);
        }
        
        .popover-header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }
        
        .popover-body {
            color: var(--text-primary);
        }
        
        /* Specific form element fixes */
        select option {
            background: var(--surface);
            color: var(--text-primary);
        }
        
        /* Custom file input styling - Modern dashed border style */
        .form-control[type="file"] {
            position: relative;
            background: var(--surface);
            border: 2px dashed var(--border);
            color: var(--text-secondary);
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 0.75rem;
        }

        .form-control[type="file"]:hover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
            transform: translateY(-1px);
        }

        .form-control[type="file"]:focus {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.1);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        /* Style the file input button */
        .form-control[type="file"]::file-selector-button {
            background: linear-gradient(135deg, var(--primary), rgba(139, 92, 246, 0.8));
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            margin-right: 1rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-control[type="file"]::file-selector-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        /* Firefox file input styling */
        .form-control[type="file"]::-moz-file-upload-button {
            background: linear-gradient(135deg, var(--primary), rgba(139, 92, 246, 0.8));
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            margin-right: 1rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-control[type="file"]::-moz-file-upload-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }
        
        /* File input styling for non-form-control inputs */
        input[type="file"]:not(.form-control) {
            color: var(--text-primary);
        }
        
        input[type="file"]:not(.form-control)::-webkit-file-upload-button {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 0.5rem 1rem;
            margin-right: 1rem;
        }
        
        /* Range input styling */
        input[type="range"] {
            background: var(--surface);
        }
        
        input[type="range"]::-webkit-slider-thumb {
            background: var(--primary);
        }
        
        input[type="range"]::-moz-range-thumb {
            background: var(--primary);
            border: none;
        }
        
        /* Checkbox and radio styling */
        .form-check-input {
            background-color: var(--surface);
            border-color: var(--border);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-label {
            color: var(--text-primary);
        }
        
        /* Switch styling */
        .form-switch .form-check-input {
            background-color: var(--surface);
        }
        
        .form-switch .form-check-input:checked {
            background-color: var(--primary);
        }
        
        /* Ensure icons are properly colored */
        i, .bi {
            color: inherit;
        }
        
        /* Link styling */
        a {
            color: var(--primary);
        }
        
        a:hover {
            color: var(--accent);
        }
        
        /* Code and pre styling if any */
        code {
            background: rgba(51, 65, 85, 0.6);
            color: var(--accent);
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
        }
        
        pre {
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: var(--border-radius);
            padding: 1rem;
        }
        
        /* Blockquote styling */
        blockquote {
            border-left: 4px solid var(--primary);
            background: rgba(37, 99, 235, 0.1);
            color: var(--text-primary);
            padding: 1rem;
            margin: 1rem 0;
        }
        
        /* HR styling */
        hr {
            border-color: var(--border);
            opacity: 0.5;
        }
        
        /* Mark/highlight styling */
        mark {
            background: rgba(245, 158, 11, 0.3);
            color: var(--text-primary);
        }
        
        /* Ensure all Bootstrap utility classes work with dark theme */
        .text-primary {
            color: var(--primary) !important;
        }
        
        .text-secondary {
            color: var(--text-secondary) !important;
        }
        
        .text-success {
            color: var(--success) !important;
        }
        
        .text-warning {
            color: var(--warning) !important;
        }
        
        .text-danger {
            color: var(--error) !important;
        }
        
        .text-info {
            color: var(--accent) !important;
        }
        
        .text-light {
            color: var(--text-secondary) !important;
        }
        
        .text-dark {
            color: var(--text-primary) !important;
        }
        
        .bg-primary {
            background-color: var(--primary) !important;
        }
        
        .bg-secondary {
            background-color: var(--surface-light) !important;
        }
        
        .bg-success {
            background-color: var(--success) !important;
        }
        
        .bg-warning {
            background-color: var(--warning) !important;
        }
        
        .bg-danger {
            background-color: var(--error) !important;
        }
        
        .bg-info {
            background-color: var(--accent) !important;
        }
        
        .bg-light {
            background-color: var(--surface) !important;
        }
        
        .bg-dark {
            background-color: var(--background) !important;
        }
        
        /* Border utilities */
        .border {
            border-color: var(--border) !important;
        }
        
        .border-primary {
            border-color: var(--primary) !important;
        }
        
        .border-secondary {
            border-color: var(--surface-light) !important;
        }
        
        .border-success {
            border-color: var(--success) !important;
        }
        
        .border-warning {
            border-color: var(--warning) !important;
        }
        
        .border-danger {
            border-color: var(--error) !important;
        }
        
        .border-info {
            border-color: var(--accent) !important;
        }
        
        .border-light {
            border-color: var(--border-light) !important;
        }
        
        .border-dark {
            border-color: var(--border) !important;
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
            background: rgba(37, 99, 235, 0.1);
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
            background: rgba(37, 99, 235, 0.1);
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

        /* Light mode styles for student search */
        [data-theme="light"] .member-name.student-search {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m11.742 10.344-6.979-6.979a2.21 2.21 0 1 1 3.121-3.121l6.979 6.979a2.21 2.21 0 0 1-3.121 3.121z'/%3e%3cpath fill='none' stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6.5 6.5 10 10'/%3e%3c/svg%3e") !important;
        }

        /* Light theme file input styling */
        [data-theme="light"] .form-control[type="file"] {
            background: var(--surface);
            border: 2px dashed var(--border);
            color: var(--text-secondary);
        }

        [data-theme="light"] .form-control[type="file"]:hover {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        [data-theme="light"] .form-control[type="file"]:focus {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        /* Student dropdown styling */
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

        /* Ensure dropdowns appear above other content */
        .card:has(.supervisor-dropdown),
        .card:has(.student-dropdown) {
            overflow: visible;
        }

        .card .supervisor-search-container,
        .card .student-search-container {
            z-index: 1000;
        }

        .supervisor-dropdown.show,
        .student-dropdown.show {
            z-index: 10000;
        }

        /* Additional styling for better UX */
        .student-search-container {
            z-index: 100;
        }
    </style>
</head>
<body>
    <?php include 'src/includes/navbar.php'; ?>
    
    <!-- Background Effects -->
    <div class="background-effects">
        <div class="cyber-grid"></div>
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>
    
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <!-- Loading Spinner -->
    <div class="spinner-overlay" id="spinner">
        <div class="spinner"></div>
    </div>
    
    <!-- Toast Notifications -->
    <div class="toast-container" id="toastContainer"></div>
    
    <div class="header-container">
        <div class="container text-center hero-content">
            <h1 class="hero-title" data-aos="fade-down" data-aos-duration="1000">Edit <span class="text-gradient" data-text="Project">Project</span></h1>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">Update your research project details and share your progress with the academic community.</p>
        </div>
    </div>
    
    <div class="container my-5" style="margin-top: 40px !important; padding-top: 20px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <i class="bi bi-pencil-square me-2"></i>Edit Project Details
                    </div>
                    <div class="card-body">
                        <div id="projectLoadingState">
                            <div class="text-center p-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3">Loading project details...</p>
                            </div>
                        </div>
                        
                        <div id="projectNotFound" style="display: none;">
                            <div class="text-center p-5">
                                <i class="bi bi-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                                <h4 class="mt-3">Project Not Found</h4>
                                <p class="text-muted">The project you're looking for doesn't exist or you don't have permission to edit it.</p>
                                <a href="project_management.php" class="btn btn-primary mt-3">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Projects
                                </a>
                            </div>
                        </div>

                        <form id="editProjectForm" enctype="multipart/form-data" style="display: none;">
                            <!-- Form fields will be added here through JavaScript -->
                        </form>
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
        // Check if user should be scrolled to timeline section
        if (window.location.hash === '#timeline-section') {
            // Delay scroll to ensure page is fully loaded
            setTimeout(() => {
                const timelineSection = document.getElementById('timeline-section');
                if (timelineSection) {
                    timelineSection.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                    // Add a subtle highlight effect to draw attention
                    timelineSection.style.transition = 'box-shadow 0.3s ease';
                    timelineSection.style.boxShadow = '0 0 20px rgba(37, 99, 235, 0.3)';
                    setTimeout(() => {
                        timelineSection.style.boxShadow = '';
                    }, 2000);
                }
            }, 1000);
        }
        
        // Debug mode for troubleshooting
        const DEBUG = true;
        
        // Initialize particles.js with modern configuration
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 60,
                    "density": {
                        "enable": true,
                        "value_area": 1000
                    }
                },
                "color": {
                    "value": ["#2563eb", "#8b5cf6", "#0ea5e9", "#14b8a6", "#f59e0b"]
                },
                "shape": {
                    "type": ["circle", "triangle"],
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
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
                        "size_min": 2,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#2563eb",
                    "opacity": 0.2,
                    "width": 1
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
                        "enable": false,
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
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 0.5
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
        
        // Initialize AOS animations with enhanced settings
        AOS.init({
            duration: 800,
            easing: 'cubic-bezier(0.19, 1, 0.22, 1)',
            once: false,
            mirror: true,
            anchorPlacement: 'top-bottom',
            offset: 50,
            delay: 100
        });
        
        // Elements
        const editProjectForm = document.getElementById('editProjectForm');
        const projectLoadingState = document.getElementById('projectLoadingState');
        const projectNotFound = document.getElementById('projectNotFound');
        const spinnerOverlay = document.getElementById('spinner');
        const toastContainer = document.getElementById('toastContainer');
        
        // Helper function to safely format dates from MongoDB format
        function formatMongoDate(mongoDate) {
            try {
                if (!mongoDate) return '';
                
                // Handle different MongoDB date formats
                let date;
                
                // Case 1: Object with $date property (MongoDB BSON Date)
                if (mongoDate.$date) {
                    // Handle ISO string or millisecond timestamp
                    if (typeof mongoDate.$date === 'string') {
                        date = new Date(mongoDate.$date);
                    } else if (typeof mongoDate.$date === 'number') {
                        date = new Date(mongoDate.$date);
                    } else {
                        return '';
                    }
                } 
                // Case 2: Direct ISO string (like "2023-09-15T08:30:00.000Z")
                else if (typeof mongoDate === 'string' && mongoDate.includes('T')) {
                    date = new Date(mongoDate);
                }
                // Case 3: Regular date object
                else if (mongoDate instanceof Date) {
                    date = mongoDate;
                }
                // Case 4: Try to parse as string
                else {
                    date = new Date(mongoDate);
                }
                
                // Check if date is valid
                if (isNaN(date.getTime())) {
                    console.warn('Invalid date:', mongoDate);
                    return '';
                }
                
                // Return in YYYY-MM-DD format
                return date.toISOString().split('T')[0];
            } catch (error) {
                console.error('Error formatting date:', error, mongoDate);
                return '';
            }
        }
        
        // Get project ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const projectId = urlParams.get('id');
        
        // If no project ID is provided, show error
        if (!projectId) {
            projectLoadingState.style.display = 'none';
            projectNotFound.style.display = 'block';
            return;
        }
        
        // Fetch project details
        loadProjectDetails(projectId);
        
        // Functions
        function loadProjectDetails(id) {
            showSpinner();
            
            if (DEBUG) console.log('Loading project with ID:', id);
            
            // First try to load from MongoDB
            fetch(`src/model/get_project.php?id=${id}`)
                .then(response => {
                    if (DEBUG) console.log('Database server response:', response);
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.project) {
                        // Project found in database, use it
                        if (DEBUG) console.log('Project found in database:', data.project);
                        hideSpinner();
                        buildEditForm(data.project);
                        projectLoadingState.style.display = 'none';
                        editProjectForm.style.display = 'block';
                    } else {
                        // Project not found
                        if (DEBUG) console.error('Project not found');
                        hideSpinner();
                        projectLoadingState.style.display = 'none';
                        projectNotFound.style.display = 'block';
                        
                        // Add error details to the UI
                        const errorDetails = document.createElement('p');
                        errorDetails.className = 'text-danger mt-2';
                        errorDetails.textContent = data.message || 'Project not found';
                        projectNotFound.querySelector('p').after(errorDetails);
                    }
                })
                .catch(error => {
                    hideSpinner();
                    console.error('Error:', error);
                    projectLoadingState.style.display = 'none';
                    projectNotFound.style.display = 'block';
                    
                    // Add error details to the UI for debugging
                    const errorDetails = document.createElement('p');
                    errorDetails.className = 'text-danger mt-2';
                    errorDetails.textContent = 'Network error: ' + (error.message || 'Unknown error');
                    projectNotFound.querySelector('p').after(errorDetails);
                });
        }
        
        function buildEditForm(project) {
            // Create a hidden input for project ID
            const projectId = project._id.$oid;
            
            // Build the form HTML
            let formHTML = `
                <input type="hidden" id="projectId" name="projectId" value="${projectId}">
                
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Project Title*</label>
                            <input type="text" class="form-control" id="title" name="title" required value="${project.title || ''}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="abstract" class="form-label">Abstract*</label>
                            <textarea class="form-control" id="abstract" name="abstract" rows="3" required>${project.abstract || ''}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5">${project.description || ''}</textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="coverImage" class="form-label">Cover Image</label>
                            <div class="file-upload">
                                <div class="file-upload-btn" id="coverImageBtn">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <p>Click or drag to upload a new image</p>
                                </div>
                                <input type="file" class="form-control" id="coverImage" name="coverImage" accept="image/*">
                            </div>
                            <div id="imagePreviewContainer" class="mt-3 text-center" ${project.coverImage && project.coverImage.url ? '' : 'style="display: none;"'}>
                                <img id="imagePreview" class="preview-image" src="${project.coverImage && project.coverImage.url ? project.coverImage.url : ''}">
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
                            <input type="text" class="form-control" id="field" name="field" required value="${project.field || ''}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="institution" class="form-label">Institution</label>
                            <input type="text" class="form-control" id="institution" name="institution" value="${project.institution || 'United International University'}">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="createdAt" class="form-label">Created At</label>
                            <input type="date" class="form-control" id="createdAt" name="createdAt" value="${formatMongoDate(project.createdAt)}">
                            <small class="text-muted">Leave empty for current date</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="updatedAt" class="form-label">Updated At</label>
                            <input type="date" class="form-control" id="updatedAt" name="updatedAt" value="${formatMongoDate(project.updatedAt)}">
                            <small class="text-muted">Leave empty for current date</small>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="estimatedCompletionDate" class="form-label">Estimated Completion Date</label>
                            <input type="date" class="form-control" id="estimatedCompletionDate" name="estimatedCompletionDate" value="${formatMongoDate(project.estimatedCompletionDate)}">
                            <small class="text-muted">Expected date when the project will be completed</small>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="privacy" class="form-label">Privacy Setting</label>
                            <select class="form-select" id="privacy" name="privacy" required>
                                <option value="0" ${(project.privacy === 0 || project.privacy === '0' || project.privacy === undefined) ? 'selected' : ''}>Public - Visible to everyone</option>
                                <option value="1" ${(project.privacy === 1 || project.privacy === '1') ? 'selected' : ''}>Private - Visible only to you and collaborators</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a privacy setting.
                            </div>
                        </div>
                    </div>
                    
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
                                ${buildKeywordsBadges(project.keywords || [])}
                            </div>
                            <input type="hidden" id="keywordsList" name="keywords">
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="bi bi-link-45deg me-2"></i>External Links
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="github" class="form-label">GitHub Repository URL</label>
                                            <input type="url" class="form-control" id="github" name="github" placeholder="https://github.com/yourusername/your-repo" value="${project.links && project.links.github ? project.links.github : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="website" class="form-label">Project Website URL</label>
                                            <input type="url" class="form-control" id="website" name="website" placeholder="https://yourproject.example.com" value="${project.links && project.links.website ? project.links.website : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="paper" class="form-label">Research Paper URL</label>
                                            <input type="url" class="form-control" id="paper" name="paper" placeholder="https://journal.example.com/your-paper" value="${project.links && project.links.paper ? project.links.paper : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="doi" class="form-label">DOI</label>
                                            <input type="text" class="form-control" id="doi" name="doi" placeholder="10.xxxx/xxxxx" value="${project.links && project.links.doi ? project.links.doi : ''}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="youtube" class="form-label">YouTube Video URL</label>
                                            <input type="url" class="form-control" id="youtube" name="youtube" placeholder="https://youtube.com/watch?v=xxxx" value="${project.links && project.links.youtube ? project.links.youtube : ''}">
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
                                    <div class="supervisor-search-container position-relative">
                                        <input type="text" class="form-control" id="supervisor" name="supervisor" 
                                               placeholder="Type to search faculty..." autocomplete="off"
                                               value="${project.supervisor ? (project.supervisor.name || '') : ''}">
                                        <input type="hidden" id="supervisorId" name="supervisorId" 
                                               value="${project.supervisor && project.supervisor.userId ? (project.supervisor.userId.$oid || '') : ''}">
                                        <div class="supervisor-dropdown" id="supervisorDropdown">
                                            <!-- Faculty options will be populated here -->
                                        </div>
                                    </div>
                                    <div class="form-text">Choose a faculty member to supervise this project</div>
                                </div>
                                
                                <label class="form-label">Team Members</label>
                                <div id="membersContainer">
                                    <!-- Team members will be added here -->
                                </div>
                                <button type="button" class="btn btn-outline-primary mt-2" id="addMember">
                                    <i class="bi bi-plus-circle me-2"></i>Add Team Member
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Timeline Section -->
                <div class="row mb-4" id="timeline-section">
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
                                    <div id="filesPreview" class="mt-2">
                                        <!-- Existing files will be displayed here -->
                                    </div>
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
                                    <div id="mediaPreview" class="mt-2 row g-2">
                                        <!-- Existing media will be displayed here -->
                                    </div>
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
                                    <label class="form-label">Project References</label>
                                    <div class="row g-2 py-3">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" id="referenceTitle" placeholder="Title/Author">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" id="referenceLink" placeholder="URL (optional)">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary w-100" id="addReference">
                                                <i class="bi bi-plus-lg"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                    <div id="references-container">
                                        <!-- References will appear here -->
                                    </div>
                                    <input type="hidden" id="referencesList" name="references">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stats Section (Hidden from user but will store/update random stats) -->
                <input type="hidden" id="viewsCount" name="viewsCount" value="${project.stats ? project.stats.views || '' : ''}">
                <input type="hidden" id="downloadsCount" name="downloadsCount" value="${project.stats ? project.stats.downloads || '' : ''}">
                <input type="hidden" id="favoritesCount" name="favoritesCount" value="${project.stats ? project.stats.favorites || '' : ''}">
                
                <!-- Comments Section (Hidden, will be initialized as empty array if not present) -->
                <input type="hidden" id="commentsArray" name="commentsArray" value="${JSON.stringify(project.comments || [])}">
            `;
            
            // Additional form sections will be added in separate functions
            
            // Add action buttons at the bottom
            formHTML += `
                <div class="text-end mt-4">
                    <a href="project_management.php" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
            `;
            
            // Set form HTML
            editProjectForm.innerHTML = formHTML;
            
            // Initialize form elements
            initializeForm(project);
        }
        
        function buildKeywordsBadges(keywords) {
            if (!keywords || keywords.length === 0) return '';
            
            return keywords.map((keyword, index) => {
                return `<span class="keyword-badge">${keyword} <i class="bi bi-x-circle" data-index="${index}"></i></span>`;
            }).join('');
        }
        
        function formatReferencesForTextarea(references) {
            if (!references || references.length === 0) return '';
            
            // If references is already a string, return as is
            if (typeof references === 'string') return references;
            
            // If it's an array of reference objects, convert to text format
            if (Array.isArray(references)) {
                // Check if references have the format from our new UI
                if (references.length > 0 && (references[0].title || references[0].link)) {
                    return references.map(ref => {
                        if (ref.link) {
                            return `${ref.title} | ${ref.link}`;
                        }
                        return ref.title;
                    }).join('\n');
                }
                
                // Handle old format with 'cite' property
                return references.map(ref => ref.cite || '').join('\n');
            }
            
            return '';
        }
        
        function initializeForm(project) {
            // Initialize keywords
            window.keywords = project.keywords || [];
            document.getElementById('keywordsList').value = JSON.stringify(window.keywords);
            
            // Add keyword functionality
            const addKeywordBtn = document.getElementById('addKeyword');
            const keywordInput = document.getElementById('keyword');
            const keywordsContainer = document.getElementById('keywordsContainer');
            
            addKeywordBtn.addEventListener('click', function() {
                addKeyword();
            });
            
            keywordInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addKeyword();
                }
            });
            
            // Initialize click handlers for existing keyword badges
            document.querySelectorAll('.keyword-badge i').forEach(icon => {
                icon.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    window.keywords.splice(index, 1);
                    updateKeywordsDisplay();
                });
            });
            
            // Initialize references
            window.references = [];
            
            // Parse existing references from the project
            if (project.references) {
                if (Array.isArray(project.references)) {
                    // Check the format of the references
                    if (project.references.length > 0) {
                        if (project.references[0].title || project.references[0].link) {
                            // Already in the new format
                            window.references = project.references;
                        } else if (project.references[0].cite) {
                            // Old format with cite property
                            window.references = project.references.map(ref => {
                                // Check if the cite contains a URL
                                const parts = ref.cite.split('|').map(part => part.trim());
                                if (parts.length > 1) {
                                    return {
                                        title: parts[0],
                                        link: parts[1]
                                    };
                                }
                                return {
                                    title: ref.cite,
                                    link: ''
                                };
                            });
                        }
                    }
                } else if (typeof project.references === 'string') {
                    // Handle string format
                    const lines = project.references.split('\n');
                    window.references = lines.map(line => {
                        const parts = line.split('|').map(part => part.trim());
                        if (parts.length > 1) {
                            return {
                                title: parts[0],
                                link: parts[1]
                            };
                        }
                        return {
                            title: line,
                            link: ''
                        };
                    });
                }
            }
            
            // Update references display
            updateReferencesDisplay();
            
            // Setup reference form handlers
            const addReferenceBtn = document.getElementById('addReference');
            const referenceTitleInput = document.getElementById('referenceTitle');
            const referenceLinkInput = document.getElementById('referenceLink');
            
            addReferenceBtn.addEventListener('click', function() {
                addReference();
            });
            
            referenceTitleInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addReference();
                }
            });
            
            referenceLinkInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addReference();
                }
            });
            
            // Initialize cover image handling
            const coverImageInput = document.getElementById('coverImage');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const removeImageBtn = document.getElementById('removeImage');
            
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
            
            removeImageBtn.addEventListener('click', function() {
                coverImageInput.value = '';
                imagePreviewContainer.style.display = 'none';
                imagePreview.src = '';
            });
            
            // Initialize team members
            window.members = project.members || [];
            const membersContainer = document.getElementById('membersContainer');
            const addMemberBtn = document.getElementById('addMember');
            
            // Populate existing members
            if (window.members.length > 0) {
                window.members.forEach(member => {
                    addMemberRow(member);
                });
            } else {
                // Add at least one empty row
                addMemberRow();
            }
            
            // Add event listener for adding new members
            addMemberBtn.addEventListener('click', function() {
                addMemberRow();
            });
            
            // Initialize timeline items
            window.timelineItems = [];
            const timelineContainer = document.getElementById('timelineContainer');
            const addTimelineItemBtn = document.getElementById('addTimelineItem');
            
            // Parse existing timeline items from the project
            if (project.timeline && project.timeline.length > 0) {
                window.timelineItems = project.timeline.map(item => {
                    // Handle MongoDB date format
                    let date = item.date;
                    if (item.date && item.date.$date) {
                        date = new Date(item.date.$date).toISOString().split('T')[0];
                    } else if (typeof item.date === 'string' && item.date.includes('T')) {
                        date = new Date(item.date).toISOString().split('T')[0];
                    } else if (item.date) {
                        date = item.date;
                    } else {
                        date = new Date().toISOString().split('T')[0];
                    }
                    
                    return {
                        title: item.title || '',
                        description: item.description || '',
                        date: date,
                        status: item.status || 'Planned',
                        assignedBy: item.assignedBy || '',
                        assignedTo: Array.isArray(item.assignedTo) ? item.assignedTo : (item.assignedTo ? [item.assignedTo] : [])
                    };
                });
                updateTimelineDisplay();
            }
            
            // Add event listener for adding new timeline items
            addTimelineItemBtn.addEventListener('click', function() {
                addTimelineItem();
            });
            
            // Initialize files preview
            const filesPreviewContainer = document.getElementById('filesPreview');
            if (project.files && project.files.length > 0) {
                project.files.forEach(file => displayFilePreview(file, filesPreviewContainer));
            }
            
            // Initialize media preview
            const mediaPreviewContainer = document.getElementById('mediaPreview');
            if (project.media && project.media.length > 0) {
                project.media.forEach(media => displayMediaPreview(media, mediaPreviewContainer));
            }
            
            // Initialize form submission
            const editProjectForm = document.getElementById('editProjectForm');
            editProjectForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm(project._id.$oid);
            });
        }
        
        function addMemberRow(member = null) {
            const membersContainer = document.getElementById('membersContainer');
            const row = document.createElement('div');
            row.className = 'row mb-2 member-row';
            
            const name = member ? member.name || '' : '';
            const role = member ? member.role || '' : '';
            const contribution = member ? member.contribution || 0 : '';
            const userId = member && member.userId && member.userId.$oid ? member.userId.$oid : '';
            
            row.innerHTML = `
                <div class="col-md-3">
                    <div class="student-search-container position-relative">
                        <input type="text" class="form-control member-name student-search" placeholder="Type to search students..." autocomplete="off" required value="${name}">
                        <input type="hidden" class="member-student-id" value="${userId}">
                        <div class="student-dropdown">
                            <!-- Student options will be populated here -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control member-role" placeholder="Role (e.g., Author, Researcher)" value="${role}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control member-contribution" placeholder="Contribution %" min="0" max="100" value="${contribution}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control member-userid" placeholder="User ID (optional)" value="${userId}">
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
        
        function updateTimelineDisplay() {
            const timelineContainer = document.getElementById('timelineContainer');
            timelineContainer.innerHTML = '';
            
            if (window.timelineItems.length === 0) {
                timelineContainer.innerHTML = '<p class="text-muted text-center py-3">No timeline items added yet.</p>';
                return;
            }
            
            // Sort timeline items by date
            window.timelineItems.sort((a, b) => {
                const dateA = formatMongoDate(a.date);
                const dateB = formatMongoDate(b.date);
                return new Date(dateA || 0) - new Date(dateB || 0);
            });
            
            window.timelineItems.forEach((item, index) => {
                const statusClasses = {
                    'Completed': 'completed status-completed',
                    'In Progress': 'in-progress status-in-progress',
                    'Planned': 'planned status-planned',
                    'Delayed': 'delayed status-delayed'
                };
                
                const statusClass = statusClasses[item.status] || 'planned status-planned';
                
                const timelineItem = document.createElement('div');
                timelineItem.className = `timeline-item ${item.status ? item.status.toLowerCase().replace(' ', '-') : 'planned'}`;
                timelineItem.dataset.index = index;
                
                // Format date for display
                const formattedDate = formatMongoDate(item.date);
                const displayDate = formattedDate ? new Date(formattedDate) : new Date();
                const formattedDisplayDate = displayDate.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                // Generate assignment display text
                let assignmentInfo = '';
                
                // Ensure backward compatibility - handle various assignment field formats
                let assignedByName = '';
                
                if (item.assignedBy) {
                    // Handle new format (object with id and name)
                    if (typeof item.assignedBy === 'object' && item.assignedBy !== null) {
                        assignedByName = item.assignedBy.name || '';
                    } 
                    // Handle legacy format (string)
                    else {
                        const assignedBy = item.assignedBy;
                        const assignedByMember = findMemberById(assignedBy);
                        assignedByName = assignedByMember ? assignedByMember.name : assignedBy;
                    }
                }
                
                let assignedToNames = [];
                
                if (item.assignedTo) {
                    if (Array.isArray(item.assignedTo)) {
                        // Map to names, handling both new and legacy formats
                        assignedToNames = item.assignedTo.map(assignee => {
                            // Handle new format (object with id and name)
                            if (typeof assignee === 'object' && assignee !== null) {
                                return assignee.name || 'Unknown';
                            }
                            // Handle legacy format (string ID or name)
                            const member = findMemberById(assignee);
                            return member ? member.name : assignee;
                        });
                    } else {
                        // Handle single assignee case (backward compatibility)
                        const member = findMemberById(item.assignedTo);
                        assignedToNames = [member ? member.name : item.assignedTo];
                    }
                }
                
                if (assignedByName || assignedToNames.length > 0) {
                    assignmentInfo = '<div class="assignment-info mt-2">';
                    
                    if (assignedByName) {
                        assignmentInfo += `<span class="text-muted small me-3"><i class="bi bi-person-plus"></i> Assigned by: <strong>${assignedByName}</strong></span>`;
                    }
                    
                    if (assignedToNames.length > 0) {
                        assignmentInfo += `<span class="text-muted small"><i class="bi bi-person-check"></i> Assigned to: <strong>${assignedToNames.join(', ')}</strong></span>`;
                    }
                    
                    assignmentInfo += '</div>';
                }

                timelineItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="timeline-date">
                            <i class="bi bi-calendar3"></i>
                            ${formattedDisplayDate}
                            <span class="status-badge ${statusClass}">${item.status || 'Planned'}</span>
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
                    <h6 class="mb-2">${item.title || ''}</h6>
                    <p class="mb-2 small text-muted">${item.description || ''}</p>
                    ${assignmentInfo}
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
        
        function addTimelineItem(item = null) {
            const now = new Date();
            const formattedDate = now.toISOString().split('T')[0]; // YYYY-MM-DD format
            
            const newItem = item || {
                title: '',
                description: '',
                date: formattedDate,
                status: 'Planned',
                assignedBy: null,
                assignedTo: []
            };
            
            // Add to the array
            if (!item) {
                window.timelineItems.push(newItem);
            }
            
            // Update the display
            updateTimelineDisplay();
            
            // If it's a new item, open the edit dialog
            if (!item) {
                editTimelineItem(window.timelineItems.length - 1);
            }
        }
        
        function editTimelineItem(index) {
            const item = window.timelineItems[index];
            
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
                                <h5 class="modal-title" id="${modalId}Label">
                                    <i class="bi bi-calendar-event"></i> Edit Timeline Item
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="timelineEditForm">
                                    <!-- Basic Information -->
                                    <div class="section-header">
                                        <h6><i class="bi bi-info-circle"></i> Basic Information</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-2">
                                                <label for="timelineTitle" class="form-label">
                                                    <i class="bi bi-type"></i>Title *
                                                </label>
                                                <input type="text" class="form-control" id="timelineTitle" 
                                                       placeholder="Enter milestone title..." required>
                                                <div class="invalid-feedback">Title required</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label for="timelineDate" class="form-label">
                                                    <i class="bi bi-calendar3"></i>Date *
                                                </label>
                                                <input type="date" class="form-control" id="timelineDate" required>
                                                <div class="invalid-feedback">Date required</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label for="timelineDescription" class="form-label">
                                            <i class="bi bi-text-paragraph"></i>Description
                                        </label>
                                        <textarea class="form-control" id="timelineDescription" rows="2" 
                                                  placeholder="Describe what needs to be accomplished..."></textarea>
                                    </div>

                                    <!-- Status -->
                                    <div class="section-header">
                                        <h6><i class="bi bi-flag"></i> Status</h6>
                                    </div>
                                    <div class="mb-2">
                                        <label for="timelineStatus" class="form-label">
                                            <i class="bi bi-speedometer2"></i>Current Status
                                        </label>
                                        <select class="form-select" id="timelineStatus">
                                            <option value="Planned">📋 Planned</option>
                                            <option value="In Progress">⚡ In Progress</option>
                                            <option value="Completed">✅ Completed</option>
                                            <option value="Delayed">⚠️ Delayed</option>
                                        </select>
                                    </div>

                                    <!-- Assignment -->
                                    <div class="section-header">
                                        <h6><i class="bi bi-people"></i> Assignment</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="timelineAssignedBy" class="form-label">
                                                    <i class="bi bi-person-plus"></i>Assigned By
                                                </label>
                                                <select class="form-select" id="timelineAssignedBy">
                                                    <option value="">Select member</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label for="timelineAssignedTo" class="form-label">
                                                    <i class="bi bi-person-check"></i>Assigned To
                                                </label>
                                                <select class="form-select" id="timelineAssignedTo" multiple size="3">
                                                    <option value="">Select members</option>
                                                </select>
                                                <div class="form-text">
                                                    <i class="bi bi-info-circle"></i> Hold Ctrl/Cmd to select multiple
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x"></i> Cancel
                                </button>
                                <button type="button" class="btn btn-primary" id="saveTimelineChanges">
                                    <i class="bi bi-check"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
            }
            
            // Set form values
            document.getElementById('timelineTitle').value = item.title || '';
            document.getElementById('timelineDescription').value = item.description || '';
            document.getElementById('timelineDate').value = formatMongoDate(item.date) || new Date().toISOString().split('T')[0];
            document.getElementById('timelineStatus').value = item.status || 'Planned';
            
            // Populate assignment dropdowns with project members
            populateAssignmentDropdowns();
            
            // Auto-select current user in "Assigned By" if no assignment exists
            const assignedBySelect = document.getElementById('timelineAssignedBy');
            const assignedToSelect = document.getElementById('timelineAssignedTo');
            
            // Set assignment values - if no assignedBy exists, try to auto-select current user
            let assignedByValue = '';
            
            // Handle new format (object with id and name)
            if (item.assignedBy && typeof item.assignedBy === 'object' && item.assignedBy.id) {
                assignedByValue = item.assignedBy.id;
            } 
            // Handle legacy format (string ID or name)
            else if (item.assignedBy) {
                assignedByValue = item.assignedBy;
            }
            
            if (!assignedByValue) {
                // Try to find current user in the dropdown options
                const currentUserOption = Array.from(assignedBySelect.options).find(option => 
                    option.value && option.value !== ''
                );
                if (currentUserOption) {
                    assignedByValue = currentUserOption.value;
                }
            }
            document.getElementById('timelineAssignedBy').value = assignedByValue;
            
            // Handle multiple assignees for "Assigned To" (with backward compatibility)
            let assignedToArray = [];
            
            // Handle new format (array of objects with id and name)
            if (item.assignedTo && Array.isArray(item.assignedTo)) {
                // Extract IDs from objects if in new format
                assignedToArray = item.assignedTo.map(assignee => 
                    (assignee && typeof assignee === 'object' && assignee.id) ? assignee.id : assignee
                );
            } 
            // Handle legacy format
            else if (item.assignedTo) {
                assignedToArray = Array.isArray(item.assignedTo) ? item.assignedTo : [item.assignedTo];
            }
            
            // Select the appropriate options in the dropdown
            Array.from(assignedToSelect.options).forEach(option => {
                option.selected = assignedToArray.includes(option.value);
            });
            
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
                const assignedByValue = document.getElementById('timelineAssignedBy').value;
                
                // Get assignedBy information (both ID and name)
                let assignedBy = null;
                if (assignedByValue) {
                    const selectedOption = document.getElementById('timelineAssignedBy').options[
                        document.getElementById('timelineAssignedBy').selectedIndex
                    ];
                    assignedBy = {
                        id: assignedByValue,
                        name: selectedOption.text.replace(/ \(.*\)$/, ''), // Remove role from text
                        type: selectedOption.text.toLowerCase().includes('supervisor') ? 'faculty' : 'student'
                    };
                }
                
                // Get multiple selected values for "Assigned To" with both ID and name
                const assignedToSelect = document.getElementById('timelineAssignedTo');
                const assignedTo = Array.from(assignedToSelect.selectedOptions)
                    .filter(option => option.value !== '')
                    .map(option => ({
                        id: option.value,
                        name: option.text.replace(/ \(.*\)$/, ''), // Remove role from text
                        type: 'student' // Assuming assignedTo are only students
                    }));
                
                if (!title || !date) {
                    // Show validation error
                    if (!title) document.getElementById('timelineTitle').classList.add('is-invalid');
                    if (!date) document.getElementById('timelineDate').classList.add('is-invalid');
                    return;
                }
                
                // Update timelineItems array
                window.timelineItems[index] = {
                    title,
                    description,
                    date,
                    status,
                    assignedBy,
                    assignedTo
                };
                
                // Update the UI
                updateTimelineDisplay();
                
                // Close the modal
                modalInstance.hide();
            });
        }
        
        function deleteTimelineItem(index) {
            if (confirm('Are you sure you want to delete this timeline item?')) {
                window.timelineItems.splice(index, 1);
                updateTimelineDisplay();
            }
        }
        
        function populateAssignmentDropdowns() {
            const assignedBySelect = document.getElementById('timelineAssignedBy');
            const assignedToSelect = document.getElementById('timelineAssignedTo');
            
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
            const supervisorSelect = document.getElementById('supervisor');
            const supervisorIdInput = document.getElementById('supervisorId');
            
            if (supervisorSelect && supervisorSelect.value && supervisorSelect.value.trim()) {
                const supervisorValue = supervisorIdInput && supervisorIdInput.value ? supervisorIdInput.value : supervisorSelect.value;
                const supervisorText = `${supervisorSelect.value} (Supervisor)`;
                
                const supervisorByOption = new Option(supervisorText, supervisorValue);
                assignedBySelect.add(supervisorByOption);
            }
        }
        
        // Helper function to get current project members
        function getMembersData() {
            const members = [];
            
            // Get members from the form
            document.querySelectorAll('.member-row').forEach(row => {
                const name = row.querySelector('.member-name').value.trim();
                if (name) {
                    const role = row.querySelector('.member-role').value.trim();
                    const userId = row.querySelector('.member-userid').value.trim();
                    
                    members.push({
                        name: name,
                        role: role || 'Team Member',
                        userId: userId ? { $oid: userId } : null
                    });
                }
            });
            
            return members;
        }
        
        // Helper function to find member by ID or name
        function findMemberById(id) {
            if (!id) return null;
            
            // Check current project members
            const members = getMembersData();
            
            // First try to find by user ID
            let member = members.find(m => 
                (m.userId && m.userId.$oid === id) || 
                (m.userId && typeof m.userId === 'string' && m.userId === id)
            );
            
            // If not found by ID, try by name
            if (!member) {
                member = members.find(m => m.name === id);
            }
            
            // Check supervisor
            if (!member) {
                const supervisorSelect = document.getElementById('supervisor');
                const supervisorIdInput = document.getElementById('supervisorId');
                
                if (supervisorSelect && supervisorSelect.value) {
                    const supervisorId = supervisorIdInput && supervisorIdInput.value ? supervisorIdInput.value : supervisorSelect.value;
                    const supervisorName = supervisorSelect.value;
                    
                    if (supervisorId === id || supervisorName === id) {
                        return { name: supervisorName, role: 'Supervisor' };
                    }
                }
            }
            
            return member || { name: id, role: 'Unknown' };
        }
        
        function displayFilePreview(file, container) {
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
            
            container.appendChild(filePreview);
        }
        
        function displayMediaPreview(media, container) {
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
            
            container.appendChild(mediaPreview);
        }
        
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
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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
        
        function submitForm(projectId) {
            // Show loading state
            const saveBtn = document.querySelector('button[type="submit"]');
            const originalText = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            
            // Get form values
            const title = document.getElementById('title').value.trim();
            const abstract = document.getElementById('abstract').value.trim();
            const description = document.getElementById('description').value.trim();
            const researchField = document.getElementById('field').value.trim();
            const institution = document.getElementById('institution').value.trim();
            const privacySelect = document.getElementById('privacy');
            const privacy = privacySelect.value;
            
            if (DEBUG) {
                console.log('Submitting form with values:', {
                    projectId,
                    title,
                    abstract,
                    description,
                    field: researchField,
                    institution,
                    privacy
                });
            }
            
            // Validate required fields
            let hasErrors = false;
            
            if (!title) {
                document.getElementById('title').classList.add('is-invalid');
                hasErrors = true;
            } else {
                document.getElementById('title').classList.remove('is-invalid');
            }
            
            if (!abstract) {
                document.getElementById('abstract').classList.add('is-invalid');
                hasErrors = true;
            } else {
                document.getElementById('abstract').classList.remove('is-invalid');
            }
            
            if (!researchField) {
                document.getElementById('field').classList.add('is-invalid');
                hasErrors = true;
            } else {
                document.getElementById('field').classList.remove('is-invalid');
            }
            
            // Validate privacy
            if (privacy === '' || privacy === null || privacy === undefined) {
                privacySelect.classList.add('is-invalid');
                hasErrors = true;
            } else {
                privacySelect.classList.remove('is-invalid');
            }
            
            if (hasErrors) {
                showToast('Error', 'Please fill in all required fields', 'error');
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
                return;
            }
            
            // Get keywords from global variable
            const keywords = window.keywords || [];
            
            // Get dates
            const createdDate = document.getElementById('createdAt').value;
            const updatedDate = document.getElementById('updatedAt').value || new Date().toISOString().split('T')[0];
            const estimatedCompletionDate = document.getElementById('estimatedCompletionDate').value;
            
            // Get links
            const githubUrl = document.getElementById('github').value.trim();
            const projectUrl = document.getElementById('website').value.trim();
            const paperUrl = document.getElementById('paper').value.trim();
            const doi = document.getElementById('doi').value.trim();
            const youtubeUrl = document.getElementById('youtube').value.trim();
            
            // Get supervisor
            const supervisor = document.getElementById('supervisor').value.trim();
            
            // Get team members
            const teamMembers = [];
            document.querySelectorAll('.member-row').forEach(row => {
                const memberName = row.querySelector('.member-name').value.trim();
                if (memberName) { // Only add if there's a name
                    const role = row.querySelector('.member-role').value.trim();
                    const contribution = parseInt(row.querySelector('.member-contribution').value) || 0;
                    // Check both the hidden member-student-id and the visible member-userid fields
                    let userId = row.querySelector('.member-student-id').value.trim();
                    if (!userId) {
                        userId = row.querySelector('.member-userid').value.trim();
                    }
                    
                    teamMembers.push({
                        name: memberName,
                        role: role,
                        contribution: contribution,
                        userId: userId ? { $oid: userId } : null
                    });
                    
                    if (DEBUG) {
                        console.log('Added team member:', {
                            name: memberName,
                            role: role,
                            contribution: contribution,
                            userId: userId ? { $oid: userId } : null
                        });
                    }
                }
            });
            
            // Get timeline items (already in window.timelineItems)
            
            // Get references from the window.references array
            // Make sure the references input is updated with the latest data
            document.getElementById('referencesList').value = JSON.stringify(window.references);
            const references = window.references || [];
            
            if (DEBUG) {
                console.log('References data being submitted:', references);
            }
            
            // Get stats fields
            const views = parseInt(document.getElementById('viewsCount').value) || 0;
            const downloads = parseInt(document.getElementById('downloadsCount').value) || 0;
            const favorites = parseInt(document.getElementById('favoritesCount').value) || 0;
            
            // Get comments field
            const commentsValue = document.getElementById('commentsArray').value;
            const comments = commentsValue ? JSON.parse(commentsValue) : [];
            
            // Create FormData object for file uploads
            const formData = new FormData();
            
            // Add project ID
            formData.append('project_id', projectId);
            
            // Add basic information
            formData.append('title', title);
            formData.append('abstract', abstract);
            formData.append('description', description);
            formData.append('field', researchField);
            formData.append('institution', institution);
            formData.append('privacy', privacy);
            formData.append('keywords', JSON.stringify(keywords));
            
            // Add dates
            formData.append('created_date', createdDate);
            formData.append('updated_date', updatedDate);
            formData.append('estimatedCompletionDate', estimatedCompletionDate);
            
            // Add links
            formData.append('github_url', githubUrl);
            formData.append('project_url', projectUrl);
            formData.append('paper_url', paperUrl);
            formData.append('doi', doi);
            formData.append('youtube_url', youtubeUrl);
            
            // Add supervisor and supervisorId
            formData.append('supervisor', supervisor);
            const supervisorId = document.getElementById('supervisorId').value.trim();
            formData.append('supervisorId', supervisorId);
            
            // Add team members
            formData.append('team_members', JSON.stringify(teamMembers));
            
            // Add timeline items
            formData.append('timeline', JSON.stringify(window.timelineItems));
            
            // Add references
            formData.append('references', JSON.stringify(references));
            
            // Add stats
            formData.append('views', views);
            formData.append('downloads', downloads);
            formData.append('favorites', favorites);
            
            // Add comments
            formData.append('comments', JSON.stringify(comments));
            
            // Add cover image if selected
            const coverImageInput = document.getElementById('coverImage');
            if (coverImageInput.files && coverImageInput.files[0]) {
                formData.append('cover_image', coverImageInput.files[0]);
            }
            
            // Add project files if selected
            const filesInput = document.getElementById('projectFiles');
            if (filesInput.files && filesInput.files.length > 0) {
                for (let i = 0; i < filesInput.files.length; i++) {
                    formData.append('project_files[]', filesInput.files[i]);
                }
            }
            
            // Add media files if selected
            const mediaInput = document.getElementById('mediaFiles');
            if (mediaInput.files && mediaInput.files.length > 0) {
                for (let i = 0; i < mediaInput.files.length; i++) {
                    formData.append('project_media[]', mediaInput.files[i]);
                }
            }
            
            // For debugging - log all form data
            if (DEBUG) {
                console.log('Submitting FormData:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
            }
            
            // Send the request
            fetch('src/model/update_project.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message and redirect to project details page
                    showToast('Success', 'Project updated successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = `Project_details.php?id=${projectId}`;
                    }, 1500);
                } else {
                    // Show error message
                    showToast('Error', data.message || 'Failed to update project', 'error');
                    
                    // Reset button state
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error', 'An error occurred while updating the project', 'error');
                
                // Reset button state
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
            });
        }
        
        // Function to handle keywords
        function addKeyword() {
            const keywordInput = document.getElementById('keyword');
            const keyword = keywordInput.value.trim();
            
            if (keyword) {
                if (!window.keywords.includes(keyword)) {
                    window.keywords.push(keyword);
                    updateKeywordsDisplay();
                }
                keywordInput.value = '';
            }
        }
        
        function updateKeywordsDisplay() {
            const keywordsContainer = document.getElementById('keywordsContainer');
            const keywordsList = document.getElementById('keywordsList');
            
            keywordsContainer.innerHTML = '';
            keywordsList.value = JSON.stringify(window.keywords);
            
            if (window.keywords.length === 0) {
                keywordsContainer.innerHTML = '<p class="text-muted">No keywords added yet.</p>';
                return;
            }
            
            window.keywords.forEach((keyword, index) => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary keyword-badge me-2 mb-2';
                badge.innerHTML = `${keyword} <i class="bi bi-x-circle ms-1" data-index="${index}" role="button"></i>`;
                keywordsContainer.appendChild(badge);
                
                // Add event listener to remove icon
                badge.querySelector('i').addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    window.keywords.splice(index, 1);
                    updateKeywordsDisplay();
                });
            });
        }
        
        function updateReferencesDisplay() {
            const referencesContainer = document.getElementById('references-container');
            const referencesList = document.getElementById('referencesList');
            
            referencesContainer.innerHTML = '';
            referencesList.value = JSON.stringify(window.references);
            
            if (window.references.length === 0) {
                referencesContainer.innerHTML = '<p class="text-muted text-center py-3">No references added yet.</p>';
                return;
            }
            
            window.references.forEach((reference, index) => {
                const referenceItem = document.createElement('div');
                referenceItem.className = 'reference-item';
                
                let linkHtml = '';
                if (reference.link) {
                    linkHtml = `<div class="reference-link">
                        <a href="${reference.link}" target="_blank">${reference.link}</a>
                    </div>`;
                }
                
                referenceItem.innerHTML = `
                    <div class="reference-content">
                        <div class="reference-title">${reference.title}</div>
                        ${linkHtml}
                    </div>
                    <i class="bi bi-x-circle remove-reference" data-index="${index}"></i>
                `;
                
                referencesContainer.appendChild(referenceItem);
                
                // Add event listener to remove icon
                referenceItem.querySelector('.remove-reference').addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    window.references.splice(index, 1);
                    updateReferencesDisplay();
                });
            });
        }
        
        function addReference() {
            const titleInput = document.getElementById('referenceTitle');
            const linkInput = document.getElementById('referenceLink');
            
            const title = titleInput.value.trim();
            const link = linkInput.value.trim();
            
            if (title) {
                window.references.push({
                    title: title,
                    link: link
                });
                
                // Clear inputs
                titleInput.value = '';
                linkInput.value = '';
                
                // Update display
                updateReferencesDisplay();
                
                // Focus on title input for next entry
                titleInput.focus();
            }
        }
        
        // ===== DROPDOWN FUNCTIONALITY =====
        
        // Global variables for dropdown functionality
        let allFacultyData = [];
        let allStudentsData = [];
        let currentHighlightedIndex = -1;
        
        // Load data and initialize dropdowns when page loads
        function initializeDropdowns() {
            loadFacultyForDropdown();
            loadStudentsForDropdown();
        }
        
        function loadFacultyForDropdown() {
            // Check if global faculty data is available (from Faculty_Page.php)
            if (window.facultyData && window.facultyData.length > 0) {
                allFacultyData = window.facultyData;
                setupSupervisorSearch();
                return;
            }
            
            // If global data is not available, fetch it directly
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
                    }
                })
                .catch(error => {
                    console.error('Error fetching faculty data:', error);
                });
        }
        
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
                        
                        // Add debugging to inspect the structure
                        if (DEBUG) {
                            console.log('Loaded student data:', data[0]);
                        }
                    } else {
                        console.error('No students data received');
                    }
                })
                .catch(error => {
                    console.error('Error fetching students data:', error);
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
            
            // Position dropdown
            positionDropdown(supervisorDropdown, document.getElementById('supervisor'));
        }
        
        function selectFaculty(optionElement) {
            const facultyId = optionElement.getAttribute('data-faculty-id');
            const facultyName = optionElement.getAttribute('data-faculty-name');
            
            // Set the input values
            document.getElementById('supervisor').value = facultyName;
            document.getElementById('supervisorId').value = facultyId;
            
            // Hide dropdown
            hideSupervisorDropdown();
        }
        
        function hideSupervisorDropdown() {
            const supervisorDropdown = document.getElementById('supervisorDropdown');
            supervisorDropdown.classList.remove('show');
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
        
        function setupStudentSearch(memberRow) {
            const studentInput = memberRow.querySelector('.member-name.student-search');
            const studentDropdown = memberRow.querySelector('.student-dropdown');
            const studentIdInput = memberRow.querySelector('.member-student-id');
            
            if (!studentInput || !studentDropdown) return;
            
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
                (student.name && student.name.toLowerCase().includes(searchTerm)) || 
                (student.student_id && student.student_id.toLowerCase().includes(searchTerm))
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
            
            // Position dropdown
            positionDropdown(dropdown, dropdown.closest('.student-search-container'));
            
            if (callback) callback();
        }
        
        function selectStudent(option, input, hiddenInput, dropdown) {
            const studentData = option.studentData;
            if (studentData) {
                input.value = studentData.name;
                // Store the MongoDB _id of the student in the hidden input and member-userid field
                if (studentData._id && studentData._id.$oid) {
                    hiddenInput.value = studentData._id.$oid;
                    const memberRow = dropdown.closest('.member-row');
                    if (memberRow) {
                        const userIdInput = memberRow.querySelector('.member-userid');
                        if (userIdInput) {
                            userIdInput.value = studentData._id.$oid;
                        }
                    }
                } else if (studentData.id) {
                    hiddenInput.value = studentData.id;
                    const memberRow = dropdown.closest('.member-row');
                    if (memberRow) {
                        const userIdInput = memberRow.querySelector('.member-userid');
                        if (userIdInput) {
                            userIdInput.value = studentData.id;
                        }
                    }
                }
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
        
        function positionDropdown(dropdown, container) {
            const containerRect = container.getBoundingClientRect();
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
        }
        
        // Initialize dropdowns when document is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeDropdowns);
        } else {
            initializeDropdowns();
        }

        // Listen for theme changes from navbar toggle
        document.addEventListener('themeChanged', function(e) {
            const newTheme = e.detail.theme;
            console.log('Theme changed to:', newTheme);
            
            // Re-trigger any theme-dependent animations or effects
            const particles = document.getElementById('particles-js');
            if (particles && window.pJSDom && window.pJSDom[0]) {
                // Update particles colors based on theme
                const pJS = window.pJSDom[0].pJS;
                if (newTheme === 'light') {
                    pJS.particles.color.value = ["#2563eb", "#8b5cf6", "#0ea5e9", "#14b8a6", "#f59e0b"];
                    pJS.particles.line_linked.color = "#2563eb";
                } else {
                    pJS.particles.color.value = ["#2563eb", "#8b5cf6", "#0ea5e9", "#14b8a6", "#f59e0b"];
                    pJS.particles.line_linked.color = "#2563eb";
                }
            }
        });
    });
    </script>
    
    <!-- Include Timeline Editor Overlay -->
    <?php include 'timeline_editor_overlay.php'; ?>
</body>
</html>
