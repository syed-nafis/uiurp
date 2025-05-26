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
    <link rel="stylesheet" href="assets/styles/theme.css">
    <!-- Preload fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Core colors */
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #7209b7;
            --accent-secondary: #f72585;
            --neo-teal: #4cc9f0;
            --neo-purple: #7209b7;
            --neo-blue: #4361ee;
            --neo-magenta: #f72585;
            --light: #f8f9fa;
            --dark: #0f172a;
            --dark-surface: #1e293b;
            
            /* Theme Variables - Dark Mode (Default) */
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --border-color: rgba(76, 201, 240, 0.1);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --card-bg: rgba(30, 41, 59, 0.8);
            --hero-bg: rgba(15, 23, 42, 0.95);
            
            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #4361ee, #3a0ca3);
            --gradient-accent: linear-gradient(135deg, #7209b7, #f72585);
            --gradient-neo: linear-gradient(135deg, #4cc9f0, #7209b7);
            --gradient-button: linear-gradient(135deg, #4361ee, #3a0ca3);
            --gradient-text: linear-gradient(135deg, #4cc9f0, #f72585);
            
            /* Animations */
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            --transition-smooth: all 0.6s cubic-bezier(0.33, 1, 0.68, 1);
            --transition-bounce: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            
            /* Effects */
            --shadow-sm: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.1);
            --shadow-neo: 0 10px 30px rgba(76, 201, 240, 0.3);
            --shadow-glow: 0 0 20px rgba(76, 201, 240, 0.5);
            
            /* Design System */
            --border-radius: 12px;
            --border-radius-xl: 20px;
            --border-radius-pill: 50px;
        }

        /* Light Theme Variables */
        [data-theme="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: rgba(67, 97, 238, 0.15);
            --shadow-color: rgba(0, 0, 0, 0.08);
            --card-bg: rgba(255, 255, 255, 0.95);
            --hero-bg: rgba(248, 250, 252, 0.98);
        }

        /* Light Theme Search Section */
        [data-theme="light"] .search-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        [data-theme="light"] .search-blur-effect {
            background: radial-gradient(circle, rgba(67, 97, 238, 0.08), transparent 70%);
        }

        [data-theme="light"] .search-glow {
            background: radial-gradient(ellipse at center, rgba(114, 9, 183, 0.06), transparent 70%);
        }

        [data-theme="light"] .futuristic-search-bar {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(67, 97, 238, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .futuristic-search-bar:focus-within {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(67, 97, 238, 0.4);
            box-shadow: 0 12px 40px rgba(67, 97, 238, 0.15);
        }

        [data-theme="light"] .search-icon-container {
            color: var(--text-secondary);
        }

        [data-theme="light"] .futuristic-search-bar .form-control {
            color: var(--text-primary);
        }

        [data-theme="light"] .futuristic-search-bar .form-control::placeholder {
            color: var(--text-muted);
        }

        [data-theme="light"] .keyword-tag {
            background: rgba(67, 97, 238, 0.1);
            color: var(--neo-primary);
            border: 1px solid rgba(67, 97, 238, 0.2);
        }

        [data-theme="light"] .keyword-tag:hover {
            background: rgba(67, 97, 238, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        [data-theme="light"] .popular-label {
            color: var(--text-secondary);
        }

        [data-theme="light"] .scroll-down-arrow {
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
            color: var(--neo-primary);
        }

        /* Light Theme Hero Section */
        [data-theme="light"] .neo-hero-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        [data-theme="light"] .neo-glow-orb.orb-1 {
            background: radial-gradient(circle, rgba(67, 97, 238, 0.08), transparent 70%);
        }

        [data-theme="light"] .neo-glow-orb.orb-2 {
            background: radial-gradient(circle, rgba(114, 9, 183, 0.06), transparent 70%);
        }

        [data-theme="light"] .neo-glow-orb.orb-3 {
            background: radial-gradient(circle, rgba(247, 37, 133, 0.05), transparent 70%);
        }

        [data-theme="light"] .neo-grid {
            background-image: 
                linear-gradient(rgba(67, 97, 238, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(67, 97, 238, 0.08) 1px, transparent 1px);
        }

        [data-theme="light"] .neo-hero-title .title-line {
            color: var(--text-primary);
        }

        [data-theme="light"] .neo-hero-subtitle {
            color: var(--text-secondary);
        }

        [data-theme="light"] .neo-badge {
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
        }

        [data-theme="light"] .badge-text {
            color: var(--neo-primary);
        }

        [data-theme="light"] .neo-button.secondary {
            background: transparent;
            border: 2px solid var(--neo-primary);
            color: var(--neo-primary);
        }

        [data-theme="light"] .neo-button.secondary:hover {
            background: var(--neo-primary);
            color: white;
        }

        [data-theme="light"] .neo-stat-item {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(67, 97, 238, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .stat-value {
            color: var(--neo-primary);
        }

        [data-theme="light"] .stat-label {
            color: var(--text-secondary);
        }

        [data-theme="light"] .stats-header h6 {
            color: var(--text-primary);
        }

        /* Light Theme Featured Projects Section */
        [data-theme="light"] .featured-projects {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: var(--text-primary);
        }

        [data-theme="light"] .projects-bg-gradient {
            background: radial-gradient(circle at 30% 50%, rgba(67, 97, 238, 0.05) 0%, transparent 60%), 
                        radial-gradient(circle at 70% 20%, rgba(114, 9, 183, 0.03) 0%, transparent 60%);
        }

        [data-theme="light"] .projects-grid-overlay {
            background-image: linear-gradient(to right, rgba(67, 97, 238, 0.08) 1px, transparent 1px), 
                              linear-gradient(to bottom, rgba(67, 97, 238, 0.08) 1px, transparent 1px);
        }

        [data-theme="light"] .projects-glow-sphere {
            background: radial-gradient(circle, rgba(67, 97, 238, 0.06), transparent 70%);
        }

        [data-theme="light"] .futuristic-badge {
            background: rgba(67, 97, 238, 0.1);
            color: var(--neo-primary);
            border: 1px solid rgba(67, 97, 238, 0.2);
        }

        [data-theme="light"] .futuristic-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .section-subtitle {
            color: var(--text-secondary);
        }

        [data-theme="light"] .filter-btn {
            background: rgba(67, 97, 238, 0.05);
            border: 1px solid rgba(67, 97, 238, 0.15);
            color: var(--text-secondary);
        }

        [data-theme="light"] .filter-btn:hover,
        [data-theme="light"] .filter-btn.active {
            background: rgba(67, 97, 238, 0.1);
            color: var(--neo-primary);
            border-color: rgba(67, 97, 238, 0.3);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
        }

        [data-theme="light"] .futuristic-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(67, 97, 238, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .futuristic-card:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(67, 97, 238, 0.2);
            box-shadow: 0 16px 48px rgba(67, 97, 238, 0.12);
        }

        [data-theme="light"] .card-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .card-text {
            color: var(--text-secondary);
        }

        [data-theme="light"] .card-meta {
            color: var(--text-muted);
        }

        /* Light Theme Research Impact Section */
        [data-theme="light"] .research-impact {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            color: var(--text-primary);
        }

        [data-theme="light"] .impact-shape-1 {
            background: radial-gradient(circle, rgba(67, 97, 238, 0.08), transparent);
        }

        [data-theme="light"] .impact-shape-2 {
            background: radial-gradient(circle, rgba(114, 9, 183, 0.06), transparent);
        }

        [data-theme="light"] .grid-overlay {
            background-image: 
                linear-gradient(rgba(67, 97, 238, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(67, 97, 238, 0.08) 1px, transparent 1px);
        }

        [data-theme="light"] .glowing-orb.orb-1 {
            background: radial-gradient(circle, rgba(67, 97, 238, 0.1), transparent 70%);
        }

        [data-theme="light"] .glowing-orb.orb-2 {
            background: radial-gradient(circle, rgba(114, 9, 183, 0.08), transparent 70%);
        }

        [data-theme="light"] .glowing-orb.orb-3 {
            background: radial-gradient(circle, rgba(247, 37, 133, 0.06), transparent 70%);
        }

        [data-theme="light"] .impact-chart-container {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(67, 97, 238, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .impact-chart-container:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(67, 97, 238, 0.25);
            box-shadow: 0 12px 48px rgba(67, 97, 238, 0.12);
        }

        [data-theme="light"] .chart-wrapper {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(67, 97, 238, 0.1);
        }

        [data-theme="light"] .chart-header h4 {
            background: linear-gradient(135deg, var(--text-primary), var(--neo-primary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        [data-theme="light"] .chart-controls .btn {
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
            color: var(--neo-primary);
        }

        [data-theme="light"] .chart-controls .btn:hover,
        [data-theme="light"] .chart-controls .btn.active {
            background: rgba(67, 97, 238, 0.15);
            color: var(--neo-primary);
        }

        /* Light Theme Faculty Spotlight Section */
        [data-theme="light"] .faculty-spotlight {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: var(--text-primary);
        }

        [data-theme="light"] .neo-badge {
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
            color: var(--neo-primary);
        }

        [data-theme="light"] .neo-badge-link:hover .neo-badge {
            background: rgba(67, 97, 238, 0.15);
            border-color: rgba(67, 97, 238, 0.3);
            box-shadow: 0 4px 16px rgba(67, 97, 238, 0.2);
        }

        [data-theme="light"] .futuristic-title {
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--neo-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        [data-theme="light"] .neo-faculty-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(67, 97, 238, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .neo-faculty-card:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(67, 97, 238, 0.2);
            box-shadow: 0 8px 32px rgba(67, 97, 238, 0.12);
        }

        [data-theme="light"] .faculty-name {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .faculty-position {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .faculty-quote {
            background: rgba(248, 250, 252, 0.8) !important;
            border-left: 3px solid rgba(67, 97, 238, 0.3) !important;
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .faculty-info {
            background: rgba(255, 255, 255, 0.95) !important;
        }

        [data-theme="light"] .faculty-title {
            color: var(--text-secondary);
        }

        [data-theme="light"] .faculty-specialty {
            color: var(--neo-primary);
        }

        [data-theme="light"] .faculty-bio {
            color: var(--text-secondary);
        }

        [data-theme="light"] .faculty-stats {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(67, 97, 238, 0.1);
        }

        [data-theme="light"] .stat-number {
            color: var(--neo-primary);
        }

        [data-theme="light"] .stat-label {
            color: var(--text-muted);
        }

        /* Light Theme Events Section */
        [data-theme="light"] .events-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-primary);
        }

        [data-theme="light"] .events-bg-grid {
            background-image: linear-gradient(to right, rgba(67, 97, 238, 0.08) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(67, 97, 238, 0.08) 1px, transparent 1px);
        }

        [data-theme="light"] .events-orb.orb-1 {
            background: radial-gradient(circle, rgba(114, 9, 183, 0.06) 0%, transparent 70%);
        }

        [data-theme="light"] .events-orb.orb-2 {
            background: radial-gradient(circle, rgba(247, 37, 133, 0.05) 0%, transparent 70%);
        }

        [data-theme="light"] .events-glow-effect {
            background: radial-gradient(ellipse, rgba(114, 9, 183, 0.03), transparent 70%);
        }

        [data-theme="light"] .events-timeline-line {
            background: linear-gradient(to right, 
                rgba(67, 97, 238, 0), 
                rgba(67, 97, 238, 0.3), 
                rgba(67, 97, 238, 0.5), 
                rgba(67, 97, 238, 0.3), 
                rgba(67, 97, 238, 0));
        }

        [data-theme="light"] .event-badge {
            background: rgba(247, 37, 133, 0.1);
            border: 1px solid rgba(247, 37, 133, 0.2);
        }

        [data-theme="light"] .neo-event-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(67, 97, 238, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .neo-event-card:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(247, 37, 133, 0.2);
            box-shadow: 0 12px 48px rgba(247, 37, 133, 0.12);
        }

        [data-theme="light"] .event-date-badge {
            background: rgba(247, 37, 133, 0.1);
            border: 1px solid rgba(247, 37, 133, 0.2);
        }

        [data-theme="light"] .neo-event-card:hover .event-date-badge {
            background: rgba(247, 37, 133, 0.15);
            box-shadow: 0 4px 12px rgba(247, 37, 133, 0.15);
        }

        [data-theme="light"] .event-day {
            background: linear-gradient(135deg, var(--text-primary), var(--neo-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        [data-theme="light"] .event-month {
            color: var(--text-secondary);
        }

        [data-theme="light"] .event-title {
            color: var(--text-primary);
        }

        [data-theme="light"] .event-description {
            color: var(--text-secondary);
        }

        [data-theme="light"] .event-meta {
            color: var(--text-muted);
        }

        /* Light Theme FAQ Section */
        [data-theme="light"] .faq-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: var(--text-primary);
        }

        [data-theme="light"] .faq-bg-particles {
            background-image: radial-gradient(rgba(67, 97, 238, 0.08) 2px, transparent 2px);
        }

        [data-theme="light"] .faq-orb-1 {
            background: radial-gradient(circle, rgba(67, 97, 238, 0.06) 0%, transparent 70%);
        }

        [data-theme="light"] .faq-orb-2 {
            background: radial-gradient(circle, rgba(247, 37, 133, 0.05) 0%, transparent 70%);
        }

        [data-theme="light"] .faq-mesh-grid {
            background-image: linear-gradient(to right, rgba(67, 97, 238, 0.08) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(67, 97, 238, 0.08) 1px, transparent 1px);
        }

        [data-theme="light"] .faq-badge {
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
        }

        [data-theme="light"] .neo-accordion .accordion-item {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(67, 97, 238, 0.15);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .neo-accordion .accordion-item:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(67, 97, 238, 0.25);
            box-shadow: 0 6px 24px rgba(67, 97, 238, 0.12);
        }

        [data-theme="light"] .neo-accordion .accordion-button {
            background: rgba(248, 250, 252, 0.8);
            color: var(--text-primary);
        }

        [data-theme="light"] .neo-accordion .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.9), rgba(226, 232, 240, 0.9));
            color: var(--neo-primary);
        }

        [data-theme="light"] .neo-accordion .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231e293b'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }

        [data-theme="light"] .neo-accordion .accordion-button:not(.collapsed)::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234361ee'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }

        [data-theme="light"] .neo-accordion .accordion-body {
            background: rgba(248, 250, 252, 0.6);
            color: var(--text-secondary);
            border-top: 1px solid rgba(67, 97, 238, 0.1);
        }

        [data-theme="light"] .neo-accordion .accordion-body strong {
            color: var(--neo-primary);
        }

        [data-theme="light"] .neo-accordion .accordion-body a {
            color: var(--neo-magenta);
            border-bottom: 1px dashed rgba(247, 37, 133, 0.4);
        }

        [data-theme="light"] .neo-accordion .accordion-body a:hover {
            color: var(--neo-magenta);
            border-bottom: 1px solid rgba(247, 37, 133, 0.6);
        }

        /* Light Theme Footer Section */
        [data-theme="light"] .neo-footer {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-primary);
        }

        [data-theme="light"] .footer-orb.orb-1 {
            background: radial-gradient(circle, rgba(67, 97, 238, 0.06) 0%, transparent 70%);
        }

        [data-theme="light"] .footer-orb.orb-2 {
            background: radial-gradient(circle, rgba(114, 9, 183, 0.05) 0%, transparent 70%);
        }

        [data-theme="light"] .footer-circuit-grid {
            background-image: linear-gradient(to right, rgba(67, 97, 238, 0.08) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(67, 97, 238, 0.08) 1px, transparent 1px);
        }

        [data-theme="light"] .footer-text-logo {
            background: linear-gradient(135deg, var(--neo-primary), var(--neo-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        [data-theme="light"] .footer-tagline {
            color: var(--text-primary);
        }

        [data-theme="light"] .footer-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(67, 97, 238, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        [data-theme="light"] .footer-card:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(67, 97, 238, 0.2);
            box-shadow: 0 6px 32px rgba(67, 97, 238, 0.12);
        }

        [data-theme="light"] .footer-heading {
            color: var(--text-primary);
        }

        [data-theme="light"] .footer-icon {
            color: var(--neo-primary);
        }

        [data-theme="light"] .footer-links a {
            color: var(--text-secondary);
        }

        [data-theme="light"] .footer-links a:hover {
            color: var(--neo-primary);
        }

        [data-theme="light"] .footer-text {
            color: var(--text-secondary);
        }

        [data-theme="light"] .neo-input {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(67, 97, 238, 0.2);
            color: var(--text-primary);
        }

        [data-theme="light"] .neo-input:focus {
            background: rgba(255, 255, 255, 0.9);
            border-color: var(--neo-primary);
        }

        [data-theme="light"] .neo-input::placeholder {
            color: var(--text-muted);
        }

        [data-theme="light"] .social-link {
            background: rgba(255, 255, 255, 0.8);
            color: var(--text-secondary);
            border: 1px solid rgba(67, 97, 238, 0.1);
        }

        [data-theme="light"] .social-link:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--neo-primary);
            border-color: rgba(67, 97, 238, 0.2);
        }

        [data-theme="light"] .copyright-text {
            color: var(--text-muted);
        }

        [data-theme="light"] .footer-bottom-links a {
            color: var(--text-secondary);
        }

        [data-theme="light"] .footer-bottom-links a:hover {
            color: var(--neo-primary);
        }

        [data-theme="light"] .footer-line {
            background: linear-gradient(to right, transparent, rgba(67, 97, 238, 0.3), transparent);
        }

        /* Additional Light Theme Global Improvements */
        [data-theme="light"] .text-light {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .bg-dark {
            background: var(--bg-secondary) !important;
        }

        [data-theme="light"] .border-light {
            border-color: var(--border-color) !important;
        }

        /* Light Theme Button Improvements */
        [data-theme="light"] .btn-outline-light {
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        [data-theme="light"] .btn-outline-light:hover {
            background: var(--bg-secondary);
            border-color: var(--neo-primary);
            color: var(--neo-primary);
        }

        /* Light Theme Card Improvements */
        [data-theme="light"] .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        [data-theme="light"] .card-header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        [data-theme="light"] .card-footer {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
        }

        /* Light Theme List Group Improvements */
        [data-theme="light"] .list-group-item {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }

        [data-theme="light"] .list-group-item:hover {
            background: var(--bg-secondary);
        }

        /* Light Theme Badge Improvements */
        [data-theme="light"] .badge {
            background: rgba(67, 97, 238, 0.1);
            color: var(--neo-primary);
        }

        /* Light Theme Smooth Transitions */
        [data-theme="light"] * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Fix Hardcoded White Text Colors for Light Theme */
        [data-theme="light"] .futuristic-title {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .card-title {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .card-text {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .card-meta {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .neo-button {
            background: var(--neo-primary) !important;
            color: white !important;
        }

        [data-theme="light"] .neo-button:hover {
            color: white !important;
        }

        [data-theme="light"] .event-title {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .event-description {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .event-meta {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .chart-header h4 {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .section-subtitle {
            color: var(--text-secondary) !important;
        }

        /* Fix specific white text elements */
        [data-theme="light"] h1,
        [data-theme="light"] h2,
        [data-theme="light"] h3,
        [data-theme="light"] h4,
        [data-theme="light"] h5,
        [data-theme="light"] h6 {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] p {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .text-white {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .text-light {
            color: var(--text-primary) !important;
        }

        /* Fix card tags */
        [data-theme="light"] .card-tags span {
            background: rgba(67, 97, 238, 0.1) !important;
            color: var(--neo-primary) !important;
            border: 1px solid rgba(67, 97, 238, 0.2) !important;
        }

        /* Fix link colors */
        [data-theme="light"] .card-link {
            color: var(--neo-primary) !important;
        }

        [data-theme="light"] .card-link:hover {
            color: var(--neo-secondary) !important;
        }

        /* Fix hero section text */
        .hero-text-uiu {
            color: var(--text-primary);
            transition: color 0.4s ease;
        }

        [data-theme="light"] .hero-text-uiu {
            color: var(--text-primary) !important;
        }

        /* Fix Research Impact Section Text Colors */
        [data-theme="light"] .impact-stat-value {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .impact-stat-label {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .chart-text {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .chart-label {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .chart-value {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .chart-legend {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .metric-number {
            color: var(--neo-primary) !important;
        }

        [data-theme="light"] .metric-label {
            color: var(--text-secondary) !important;
        }

        /* Fix Research Events Section Text Colors */
        [data-theme="light"] .event-card-title {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .event-card-description {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .event-card-date {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .event-card-time {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .event-card-location {
            color: var(--text-muted) !important;
        }

        [data-theme="light"] .event-card-category {
            color: var(--neo-primary) !important;
        }

        [data-theme="light"] .event-status {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .event-participants {
            color: var(--text-muted) !important;
        }

        /* Fix Chart.js and Canvas Text Colors */
        [data-theme="light"] canvas {
            filter: none !important;
        }

        /* Fix any remaining white text in cards */
        [data-theme="light"] .neo-event-card h5,
        [data-theme="light"] .neo-event-card h6,
        [data-theme="light"] .neo-event-card .card-title {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .neo-event-card p,
        [data-theme="light"] .neo-event-card .card-text {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .neo-event-card small,
        [data-theme="light"] .neo-event-card .text-muted {
            color: var(--text-muted) !important;
        }

        /* Fix Chart Controls and Legend Text */
        [data-theme="light"] .chart-control-btn {
            background: rgba(67, 97, 238, 0.1) !important;
            color: var(--text-primary) !important;
            border: 1px solid rgba(67, 97, 238, 0.2) !important;
        }

        [data-theme="light"] .chart-control-btn.active {
            background: rgba(67, 97, 238, 0.2) !important;
            color: var(--neo-primary) !important;
        }

        [data-theme="light"] .chart-legend {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .chart-legend span {
            color: var(--text-secondary) !important;
        }

        /* Fix Faculty Specialty Badge */
        [data-theme="light"] .faculty-specialty-badge {
            background: rgba(67, 97, 238, 0.1) !important;
            border: 1px solid rgba(67, 97, 238, 0.2) !important;
            color: var(--neo-primary) !important;
        }

        [data-theme="light"] .neo-faculty-card:hover .faculty-specialty-badge {
            background: rgba(67, 97, 238, 0.15) !important;
            border-color: rgba(67, 97, 238, 0.3) !important;
        }

        /* Fix Loading Text */
        [data-theme="light"] .text-light {
            color: var(--text-primary) !important;
        }

        /* Fix Event Date Numbers and Text */
        [data-theme="light"] .event-day {
            background: linear-gradient(135deg, var(--text-primary), var(--neo-primary)) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }

        [data-theme="light"] .event-month {
            color: var(--text-secondary) !important;
        }

        /* Fix any remaining chart text elements */
        [data-theme="light"] .chart-wrapper * {
            color: var(--text-primary) !important;
        }

        /* Fix dynamic content text colors */
        [data-theme="light"] .dynamic-content,
        [data-theme="light"] .dynamic-content * {
            color: var(--text-primary) !important;
        }

        [data-theme="light"] .dynamic-content p,
        [data-theme="light"] .dynamic-content .text-secondary {
            color: var(--text-secondary) !important;
        }

        [data-theme="light"] .dynamic-content small,
        [data-theme="light"] .dynamic-content .text-muted {
            color: var(--text-muted) !important;
        }

        /* Fix specific event title and meta item colors */
        [data-theme="light"] .event-title {
            color: var(--text-primary) !important;
            -webkit-text-fill-color: var(--text-primary) !important;
            background: none !important;
        }

        [data-theme="light"] .meta-item {
            color: var(--text-secondary) !important;
        }

        /* Fix Chart Axis Numbers and Text */
        [data-theme="light"] .chart-wrapper canvas,
        [data-theme="light"] .impact-chart-container canvas {
            color: var(--text-primary) !important;
        }

        /* Force chart text colors using CSS */
        [data-theme="light"] .chartjs-render-monitor {
            color: var(--text-primary) !important;
        }

        /* Target Chart.js generated text elements */
        [data-theme="light"] .chart-wrapper text,
        [data-theme="light"] .impact-chart-container text {
            fill: var(--text-primary) !important;
            color: var(--text-primary) !important;
        }

        /* Additional chart text targeting */
        [data-theme="light"] .chart-wrapper *[fill="#ffffff"],
        [data-theme="light"] .chart-wrapper *[fill="white"],
        [data-theme="light"] .impact-chart-container *[fill="#ffffff"],
        [data-theme="light"] .impact-chart-container *[fill="white"] {
            fill: var(--text-primary) !important;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background-color 0.4s ease, color 0.4s ease;
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
            background-color: var(--hero-bg);
            transition: background-color 0.4s ease;
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
            color: var(--text-primary);
            position: relative;
            transition: color 0.4s ease;
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
            color: var(--text-secondary);
            max-width: 540px;
            margin-bottom: 2rem;
            transition: color 0.4s ease;
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
            display: flex;
            justify-content: space-between;
            position: relative;
        }
        
        .highlight-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 10px;
            background: rgba(248, 249, 250, 0.8);
            margin: 0 5px;
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
            margin: 0;
            flex-shrink: 0;
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
            position: relative;
            width: 100%;
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
                width: 100%;
                margin: 2rem 0;
            }
        }
        
        @media (max-width: 480px) {
            .impact-highlights {
                grid-template-columns: 1fr;
                width: 100%;
                margin: 2rem 0;
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

        /* Futuristic Hero Section Styles */
        .neo-hero-section {
            position: relative;
            height: 100vh;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            overflow: hidden;
            color: var(--text-primary);
            padding: 0;
            transition: background 0.4s ease, color 0.4s ease;
        }

        /* Background elements */
        .neo-hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .neo-particles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.7;
        }

        .neo-glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            z-index: 0;
        }

        .orb-1 {
            top: 20%;
            left: 15%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.3), transparent 70%);
            animation: float-slow 15s ease-in-out infinite alternate;
        }

        .orb-2 {
            bottom: 15%;
            right: 10%;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(114, 9, 183, 0.3), transparent 70%);
            animation: float-slow 18s ease-in-out infinite alternate-reverse;
        }

        .orb-3 {
            top: 60%;
            left: 30%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(247, 37, 133, 0.3), transparent 70%);
            animation: float-slow 12s ease-in-out infinite alternate;
        }

        .neo-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(76, 201, 240, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(76, 201, 240, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 1;
        }

        .neo-circuit-lines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .circuit-line {
            position: absolute;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--neo-teal), transparent);
            opacity: 0.15;
            z-index: 1;
        }

        .line-1 {
            top: 20%;
            left: 0;
            width: 100%;
            animation: pulse-line 4s infinite ease-in-out;
        }

        .line-2 {
            top: 40%;
            left: 0;
            width: 100%;
            animation: pulse-line 6s infinite ease-in-out;
            animation-delay: 1s;
        }

        .line-3 {
            top: 60%;
            left: 0;
            width: 100%;
            animation: pulse-line 5s infinite ease-in-out;
            animation-delay: 2s;
        }

        .line-4 {
            top: 80%;
            left: 0;
            width: 100%;
            animation: pulse-line 7s infinite ease-in-out;
            animation-delay: 3s;
        }

        .circuit-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--neo-teal);
            z-index: 2;
            box-shadow: 0 0 10px var(--neo-teal);
            opacity: 0.7;
            animation: pulse-dot 3s infinite ease-in-out;
        }

        .dot-1 {
            top: 20%;
            left: 30%;
            animation-delay: 0.5s;
        }

        .dot-2 {
            top: 60%;
            right: 40%;
            animation-delay: 1.5s;
        }

        .dot-3 {
            top: 80%;
            left: 60%;
            animation-delay: 2.5s;
        }

        @keyframes pulse-line {
            0% { opacity: 0.05; }
            50% { opacity: 0.2; }
            100% { opacity: 0.05; }
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(0.8); opacity: 0.5; }
        }

        @keyframes float-slow {
            0% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-20px) translateX(20px); }
            100% { transform: translateY(0) translateX(0); }
        }

        /* Content styling */
        .neo-hero-content {
            position: relative;
            z-index: 10;
            padding: 2rem 0;
        }

        .neo-badge {
            position: relative;
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: rgba(76, 201, 240, 0.1);
            border-radius: var(--border-radius-pill);
            margin-bottom: 1.5rem;
            overflow: hidden;
            border: 1px solid rgba(76, 201, 240, 0.3);
        }

        .badge-text {
            position: relative;
            z-index: 1;
            color: var(--neo-teal);
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .badge-glow {
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(76, 201, 240, 0.3), transparent);
            animation: badge-shimmer 3s infinite linear;
        }

        @keyframes badge-shimmer {
            0% { left: -100%; }
            100% { left: 200%; }
        }

        .neo-hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .title-line {
            display: block;
            transform: translateX(-20px);
            opacity: 0;
            animation: slide-in 0.8s forwards cubic-bezier(0.17, 0.84, 0.44, 1);
        }

        @keyframes slide-in {
            0% { transform: translateX(-20px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        .gradient-text {
            background: var(--gradient-text);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline;
        }

        .neo-hero-subtitle {
            font-size: 1.2rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            max-width: 90%;
        }

        /* Hero buttons */
        .neo-hero-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .neo-button {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: var(--border-radius-pill);
            font-weight: 600;
            text-decoration: none;
            overflow: hidden;
            transition: var(--transition-bounce);
            z-index: 1;
        }

        .neo-button .button-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
        }

        .neo-button .button-icon {
            margin-left: 8px;
            font-size: 1.1rem;
        }

        .neo-button.primary {
            background: var(--gradient-button);
            color: white;
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
        }

        .neo-button.primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.4);
        }

        .neo-button.primary .button-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
            z-index: 1;
        }

        .neo-button.primary:hover .button-glow {
            animation: button-shine 1.5s infinite;
        }

        @keyframes button-shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .neo-button.secondary {
            background: transparent;
            color: var(--neo-teal);
            border: 1px solid rgba(76, 201, 240, 0.3);
        }

        .neo-button.secondary:hover {
            background: rgba(76, 201, 240, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(76, 201, 240, 0.2);
        }

        .neo-button.secondary .button-border {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: var(--border-radius-pill);
        }

        .neo-button.secondary:hover .button-border {
            animation: border-pulse 1.5s infinite;
        }

        @keyframes border-pulse {
            0% { box-shadow: 0 0 0 0 rgba(76, 201, 240, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(76, 201, 240, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 201, 240, 0); }
        }

        /* Stats section */
        .neo-stats-container {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            border: 1px solid rgba(76, 201, 240, 0.1);
            box-shadow: var(--shadow-neo);
        }

        .stats-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.2rem;
            gap: 0.5rem;
        }

        .stats-header h6 {
            margin: 0;
            font-weight: 600;
            color: var(--neo-teal);
            font-size: 1rem;
        }

        .stats-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(76, 201, 240, 0.1);
            color: var(--neo-teal);
            animation: pulse 2s infinite ease-in-out;
        }

        .neo-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .neo-stat-item {
            position: relative;
            background: rgba(30, 41, 59, 0.5);
            border-radius: var(--border-radius);
            padding: 1.2rem 1rem;
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(76, 201, 240, 0.05);
            overflow: hidden;
        }

        .neo-stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-color: rgba(76, 201, 240, 0.2);
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.3rem;
            background: var(--gradient-neo);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .stat-icon {
            position: absolute;
            top: 0;
            right: 0;
            padding: 0.5rem;
            opacity: 0.2;
            font-size: 1.5rem;
            color: var(--neo-teal);
        }

        /* Visual section */
        .neo-hero-visual {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .visual-container {
            position: relative;
            width: 100%;
            height: 500px;
        }

        .visual-element {
            position: relative;
        }

        .main-visual {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            animation: float 6s ease-in-out infinite alternate;
        }

        .main-visual img {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 0 20px rgba(76, 201, 240, 0.3));
        }

        .glow-effect {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(76, 201, 240, 0.2) 0%, transparent 70%);
            filter: blur(20px);
            animation: pulse 4s infinite ease-in-out;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .float-element {
            position: absolute;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border-radius: var(--border-radius);
            padding: 1rem;
            box-shadow: var(--shadow-neo);
            border: 1px solid rgba(76, 201, 240, 0.2);
            z-index: 5;
        }

        .element-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .element-content i {
            font-size: 1.5rem;
            color: var(--neo-teal);
        }

        .element-content span {
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
        }

        .element-1 {
            top: 10%;
            left: 10%;
            animation: float 6s ease-in-out infinite alternate;
        }

        .element-2 {
            top: 15%;
            right: 15%;
            animation: float 8s ease-in-out infinite alternate-reverse;
        }

        .element-3 {
            bottom: 15%;
            left: 15%;
            animation: float 7s ease-in-out infinite alternate-reverse;
        }

        .element-4 {
            bottom: 10%;
            right: 10%;
            animation: float 5s ease-in-out infinite alternate;
        }

        .connection-lines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 4;
        }

        .connections {
            width: 100%;
            height: 100%;
        }

        .connection-path {
            stroke-dasharray: 10;
            animation: dash 30s linear infinite;
            opacity: 0.6;
        }

        @keyframes dash {
            to {
                stroke-dashoffset: 1000;
            }
        }

        .path1 { animation-delay: 0s; }
        .path2 { animation-delay: 5s; }
        .path3 { animation-delay: 10s; }
        .path4 { animation-delay: 15s; }


        /* Responsive adjustments */
        @media (max-width: 991px) {
            .neo-hero-title {
                font-size: 3rem;
            }
            
            .neo-hero-visual {
                margin-top: 3rem;
            }
            
            .visual-container {
                height: 400px;
            }
            
            .neo-stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5rem;
            }
            
            .neo-button {
                padding: 10px 20px;
            }
        }

        @media (max-width: 767px) {
            .neo-hero-section {
                padding: 60px 0 0;
            }
            
            .neo-hero-title {
                font-size: 2.5rem;
            }
            
            .neo-hero-subtitle {
                font-size: 1rem;
            }
            
            .neo-hero-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .neo-button {
                width: 100%;
                justify-content: center;
            }
            
            .neo-stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .neo-hero-visual {
                display: none;
            }
        }

        /* Futuristic Search Section Styles */
        .search-section {
            background: linear-gradient(135deg, #121729 0%, #1a2151 100%);
            position: relative;
            overflow: hidden;
            padding: 60px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        /* Scroll Down Indicator */
        .scroll-down-container {
            position: absolute;
            bottom: 50px;
            left: 0;
            right: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 10;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
        }
        
        .scroll-down-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 6px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .scroll-down-arrow {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(76, 201, 240, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--neo-teal);
            border: 1px solid rgba(76, 201, 240, 0.3);
            animation: bounce 2s infinite;
        }
        
        .scroll-down-arrow i {
            font-size: 1.5rem;
        }
        
        .scroll-down-container:hover .scroll-down-arrow {
            background: rgba(76, 201, 240, 0.2);
            transform: translateY(5px);
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body>
    <!-- Scroll navigation dots -->
    <div class="scroll-navigation">
        <div class="scroll-dot" data-section="Search" data-index="0"></div>
        <div class="scroll-dot" data-section="Hero" data-index="1"></div>
        <div class="scroll-dot" data-section="Featured Research" data-index="2"></div>
        <div class="scroll-dot" data-section="Research Impact" data-index="3"></div>
        <div class="scroll-dot" data-section="Faculty Spotlight" data-index="4"></div>
        <div class="scroll-dot" data-section="Research Events" data-index="5"></div>
        <div class="scroll-dot" data-section="Research Guidance" data-index="6"></div>
        <div class="scroll-dot" data-section="Footer" data-index="7"></div>
    </div>
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
    

        <!-- Search Section -->
    <section class="search-section position-relative vh-100">
        <div class="search-particles" id="search-particles"></div>
        <div class="search-blur-effect"></div>
        <div class="search-glow"></div>
        <div class="container position-relative h-100 d-flex flex-column justify-content-center">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="search-container" data-aos="fade-up" data-aos-duration="1200">
                        <div class="neo-badge mb-3 mx-auto text-center" style="max-width: fit-content;">
                            <span class="badge-text">UIU Research Portal</span>
                            <div class="badge-glow"></div>
                        </div>
                        
                        <div class="search-header text-center mb-3">
                            <h1 class="display-4 fw-bold mb-2" style="color: var(--text-primary); transition: color 0.4s ease;">Find Your Research Interests</h1>
                            <p class="lead" style="color: var(--text-secondary); transition: color 0.4s ease;">Discover projects aligned with your academic pursuits</p>
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

                                        <!-- Scroll Down Indicator -->
            <div class="scroll-down-container">
                <div class="scroll-down-text" style="color: var(--text-secondary); transition: color 0.4s ease;">Discover More</div>
                <div class="scroll-down-arrow" id="scrollToHero" style="color: var(--text-primary); transition: color 0.4s ease;">
                    <i class="bi bi-chevron-down"></i>
                </div>
            </div>
        </div>
        <div class="search-grid-overlay"></div>
    </section>
    
    <!-- Futuristic Hero Section -->
    <section class="neo-hero-section vh-100" id="hero-section">
        <!-- Animated Background Elements -->
        <div class="neo-hero-bg">
            <div class="neo-particles-container" id="particles-js"></div>
            <div class="neo-glow-orb orb-1"></div>
            <div class="neo-glow-orb orb-2"></div>
            <div class="neo-glow-orb orb-3"></div>
            <div class="neo-grid"></div>
            <div class="neo-circuit-lines">
                <div class="circuit-line line-1"></div>
                <div class="circuit-line line-2"></div>
                <div class="circuit-line line-3"></div>
                <div class="circuit-line line-4"></div>
                <div class="circuit-dot dot-1"></div>
                <div class="circuit-dot dot-2"></div>
                <div class="circuit-dot dot-3"></div>
      </div>
        </div>

        <div class="container position-relative">
            <div class="row h-100 align-items-center">
                <!-- Text Content -->
                <div class="col-lg-6">
                    <div class="neo-hero-content" data-aos="fade-up">
                        <div class="neo-badge">
                            <span class="badge-text">Explore Research</span>
                            <div class="badge-glow"></div>
                        </div>
                        
                        <h1 class="neo-hero-title">
                            <span class="title-line" data-aos="fade-right" data-aos-delay="100">Discover</span>
                            <span class="title-line" data-aos="fade-right" data-aos-delay="300">groundbreaking</span>
                            <span class="title-line gradient-text" data-aos="fade-right" data-aos-delay="500">research <span class="hero-text-uiu">at UIU</span></span>
                        </h1>
                        
                        <p class="neo-hero-subtitle" data-aos="fade-up" data-aos-delay="700">
                            Connect with innovative researchers, explore cutting-edge projects, and collaborate on ideas that shape the future.
                        </p>
                        
                        <div class="neo-hero-buttons" data-aos="fade-up" data-aos-delay="900">
                            <a href="Research_page.php" class="neo-button primary">
                                <span class="button-content">Explore Projects</span>
                                <span class="button-icon"><i class="bi bi-search"></i></span>
                                <span class="button-glow"></span>
                            </a>
                            <a href="project_management.php#new-project" class="neo-button secondary">
                                <span class="button-content">Start Research</span>
                                <span class="button-icon"><i class="bi bi-plus-circle"></i></span>
                                <span class="button-border"></span>
                            </a>
                        </div>
                        
                        <!-- Research Stats -->
                        <div class="neo-stats-container" data-aos="fade-up" data-aos-delay="1100">
                            <div class="stats-header">
                                <span class="stats-icon"><i class="bi bi-graph-up-arrow"></i></span>
                                <h6>Research Impact</h6>
                            </div>
                            
                            <div class="neo-stats-grid">
                                <div class="neo-stat-item" data-aos="zoom-in" data-aos-delay="1200">
                                    <div class="stat-value" data-counter="250">0</div>
                                    <div class="stat-label">Projects</div>
                                    <div class="stat-icon"><i class="bi bi-folder-fill"></i></div>
                                </div>
                                
                                <div class="neo-stat-item" data-aos="zoom-in" data-aos-delay="1300">
                                    <div class="stat-value" data-counter="120">0</div>
                                    <div class="stat-label">Researchers</div>
                                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                                </div>
                                
                                <div class="neo-stat-item" data-aos="zoom-in" data-aos-delay="1400">
                                    <div class="stat-value" data-counter="85">0</div>
                                    <div class="stat-label">Publications</div>
                                    <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Visual Content -->
                <div class="col-lg-6 position-relative d-none d-lg-block">
                    <div class="neo-hero-visual">
                        <div class="visual-container">
                            <div class="visual-element main-visual">
                                <img src="assets/resources/hero-research.png" alt="Research Visualization" class="img-fluid">
                                <div class="glow-effect"></div>
                            </div>
                            
                            <div class="floating-elements">
                                <div class="float-element element-1">
                                    <div class="element-content">
                                        <i class="bi bi-cpu"></i>
                                        <span>AI</span>
                                    </div>
                                </div>
                                <div class="float-element element-2">
                                    <div class="element-content">
                                        <i class="bi bi-graph-up"></i>
                                        <span>Data</span>
                                    </div>
                                </div>
                                <div class="float-element element-3">
                                    <div class="element-content">
                                        <i class="bi bi-lightbulb"></i>
                                        <span>Innovation</span>
                                    </div>
                                </div>
                                <div class="float-element element-4">
                                    <div class="element-content">
                                        <i class="bi bi-code-slash"></i>
                                        <span>Tech</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="connection-lines">
                                <svg class="connections" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                                    <path class="connection-path path1" d="M250,250 L100,150" stroke="#4cc9f0" stroke-width="2"></path>
                                    <path class="connection-path path2" d="M250,250 L400,150" stroke="#7209b7" stroke-width="2"></path>
                                    <path class="connection-path path3" d="M250,250 L100,350" stroke="#4361ee" stroke-width="2"></path>
                                    <path class="connection-path path4" d="M250,250 L400,350" stroke="#f72585" stroke-width="2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        /* Futuristic Search Section Styles */
        .search-section {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            position: relative;
            overflow: hidden;
            padding: 60px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            transition: background 0.4s ease;
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
            transform: translateY(-5rem);
        }
        
        .futuristic-search-bar {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--card-bg);
            border-radius: 30px;
            padding: 8px 8px 8px 20px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 30px var(--shadow-color);
            transition: all 0.4s ease;
            overflow: hidden;
        }
        
        .futuristic-search-bar:focus-within {
            background: var(--bg-tertiary);
            box-shadow: 0 15px 40px rgba(76, 201, 240, 0.2);
            transform: translateY(-2px);
        }
        
        .search-icon-container {
            color: var(--text-secondary);
            font-size: 1.2rem;
            margin-right: 15px;
            transition: color 0.4s ease;
        }
        
        .futuristic-search-bar .form-control {
            background: transparent;
            border: none;
            color: var(--text-primary);
            flex-grow: 1;
            font-size: 1.05rem;
            padding: 12px 5px;
            box-shadow: none;
            transition: color 0.4s ease;
        }
        
        .futuristic-search-bar .form-control::placeholder {
            color: var(--text-muted);
            transition: color 0.4s ease;
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
            gap: 8px;
            margin-top: 15px;
            margin-bottom: 20px;
            animation: fade-in-up 1s ease forwards;
        }
        
        .interactive-tag-cloud span,
        #keywordsList span:not(.popular-label) {
            background: rgba(0, 37, 84, 0.33);
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
                    <div class="impact-chart-container glassmorphism" style="height: 600px;">
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
                        <div class="chart-wrapper" style="height: calc(100% - 100px);">
                            <canvas id="researchImpactChart"></canvas>
                            <div class="chart-glow-effect"></div>
                        </div>
                    </div>
                </div>
            </div>
            

            </div>
        </div>
    </section>

    <!-- Faculty Spotlight Section -->
    <section class="faculty-spotlight section-padding position-relative">
        <!-- Futuristic background elements -->
        <div class="faculty-bg-grid"></div>
        <div class="faculty-orb orb-1"></div>
        <div class="faculty-orb orb-2"></div>
        <div class="faculty-glow-effect"></div>
        
        <div class="container position-relative mt-4">
            <div class="text-center mb-2" data-aos="fade-up">
                <div class="section-header text-center">
                    <h2 class="futuristic-title">Faculty <span class="text-gradient">Spotlight</span></h2>
                    <p class="section-subtitle mx-auto">Meet our distinguished faculty members who are leading cutting-edge research and shaping the future of innovation at UIU.</p>
                    <div class="d-flex justify-content-center mt-1">
                        <div class="title-underline"></div>
                    </div>
                        </div>
                    </div>
                    
            <div class="faculty-showcase" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-2 justify-content-center" id="randomFacultyList">
                    <!-- Faculty members will be dynamically loaded here -->
                    <div class="text-center w-100 py-5">
                        <div class="neo-loader">
                            <span></span>
                            <span></span>
                            <span></span>
                                </div>
                        <p class="mt-4 text-light">Loading brilliant minds...</p>
                            </div>
                        </div>
                    </div>
                    
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Fetch faculty data from the same endpoint used in Faculty_Page.php
                    fetch('src/model/load_faculty.php')
                        .then(response => response.json())
                        .then(data => {
                            if (!data || data.length === 0) {
                                document.getElementById('randomFacultyList').innerHTML = '<p class="text-center text-light">No faculty members found.</p>';
                                return;
                            }
                            
                            // Shuffle the array to get random faculty
                            const shuffledFaculty = shuffleArray([...data]);
                            
                            // Take only the first 4 entries (or fewer if less than 4 are available)
                            const selectedFaculty = shuffledFaculty.slice(0, 4);
                            
                            // Clear loading spinner
                            document.getElementById('randomFacultyList').innerHTML = '';
                            
                            // Generate HTML for each faculty card with staggered animation delay
                            selectedFaculty.forEach((faculty, index) => {
                                const profileImage = faculty.profile_image ? faculty.profile_image : 'assets/resources/imgPlaceholder.png';
                                
                                // Create specialty display (use first field of research if available)
                                let specialty = '';
                                if (faculty.interested_fields_of_research && faculty.interested_fields_of_research.length > 0) {
                                    specialty = faculty.interested_fields_of_research[0];
                                } else {
                                    specialty = 'Research Faculty';
                                }
                                
                                // Calculate animation delay based on index
                                const animDelay = 100 + (index * 150);
                                
                                // Create faculty card
                                const facultyCard = `
                                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="${animDelay}">
                                    <div class="neo-faculty-card" data-faculty-id="${faculty._id}" style="cursor: pointer;">
                                        <div class="card-border"></div>
                                        <div class="faculty-img-wrapper">
                            <div class="faculty-img-container" id="img-container-${index}">
                                                <img src="${profileImage}" alt="${faculty.name}" class="img-fluid" onload="handleImageLoad(${index})" onerror="handleImageError(${index})">
                                                <div class="img-overlay"></div>
                            </div>
                                            <div class="faculty-specialty-badge">
                                                <span>${specialty}</span>
                                </div>
                            </div>
                            <div class="faculty-info">
                                                <h4 class="faculty-name">${faculty.name}</h4>
                                                <p class="faculty-position">Faculty Member</p>
                                    <div class="faculty-quote">
                                                    <q>${faculty.bio ? (faculty.bio.length > 100 ? faculty.bio.substring(0, 100) + '...' : faculty.bio) : 'Research faculty at UIU.'}</q>
                                    </div>
                            </div>
                            </div>
                        </div>
                                `;
                                
                                document.getElementById('randomFacultyList').insertAdjacentHTML('beforeend', facultyCard);
                            });
                            
                            // Simple card interactions
                            setTimeout(() => {
                                const facultyCards = document.querySelectorAll('.neo-faculty-card');
                                facultyCards.forEach(card => {
                                    // Add click handler to redirect to faculty profile
                                    card.addEventListener('click', function(e) {
                                        const facultyId = this.getAttribute('data-faculty-id');
                                        if (facultyId) {
                                            window.location.href = `Faculty_Profile.php?id=${facultyId}`;
                                        }
                                    });
                                    
                                    // Add hover effect for better UX
                                    card.addEventListener('mouseenter', function() {
                                        this.style.cursor = 'pointer';
                                    });
                                });
                            }, 500);
                        })
                        .catch(error => {
                            document.getElementById('randomFacultyList').innerHTML = `<p class="text-danger">Failed to load faculty data. Please try again later.</p>`;
                            console.error('Error loading faculty data:', error);
                        });
                    
                    // Function to shuffle an array (Fisher-Yates algorithm)
                    function shuffleArray(array) {
                        for (let i = array.length - 1; i > 0; i--) {
                            const j = Math.floor(Math.random() * (i + 1));
                            [array[i], array[j]] = [array[j], array[i]];
                        }
                        return array;
                    }
                    
                    // Image loading handlers
                    window.handleImageLoad = function(index) {
                        const container = document.getElementById(`img-container-${index}`);
                        if (container) {
                            container.classList.add('loaded');
                        }
                    };
                    
                    window.handleImageError = function(index) {
                        const container = document.getElementById(`img-container-${index}`);
                        if (container) {
                            const img = container.querySelector('img');
                            if (img) {
                                img.src = 'assets/resources/imgPlaceholder.png';
                                img.onload = () => container.classList.add('loaded');
                            }
                        }
                    };
                });
            </script>
            

        </div>
    </section>

    <style>
    /* Modern Futuristic Faculty Spotlight Styling */
    .faculty-spotlight {
        background: linear-gradient(135deg, #0f1428 0%, #121a33 100%);
        position: relative;
        overflow: visible;
        color: #fff;
        padding: 60px 0 60px 0 !important;
        margin: 0;
        min-height: auto;
    }
    
    @media (max-width: 768px) {
        .faculty-spotlight {
            padding: 40px 0 40px 0 !important;
        }
    }
    
    .faculty-bg-grid {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: transparent;
        z-index: 1;
        opacity: 0;
        pointer-events: none;
    }
    
    .faculty-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
        pointer-events: none;
    }
    
    .faculty-orb.orb-1 {
        width: 300px;
        height: 300px;
        top: -50px;
        right: -100px;
        background: transparent;
        opacity: 0;
    }
    
    .faculty-orb.orb-2 {
        width: 400px;
        height: 400px;
        bottom: -100px;
        left: -150px;
        background: transparent;
        opacity: 0;
    }
    
    .faculty-glow-effect {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        height: 60%;
        background: transparent;
        opacity: 0;
        z-index: 1;
        pointer-events: none;
    }
    
    @keyframes float-slow {
        0% { transform: translateY(0) translateX(0); }
        50% { transform: translateY(-30px) translateX(20px); }
        100% { transform: translateY(20px) translateX(-20px); }
    }
    
         .neo-badge {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         background: rgba(255, 255, 255, 0.1);
         backdrop-filter: blur(5px);
         border: 1px solid rgba(255, 255, 255, 0.2);
         border-radius: 50px;
         padding: 0.5rem 1.25rem;
         font-size: 0.85rem;
         font-weight: 500;
         color: #f8f9fa;
         margin-bottom: 1.5rem;
         box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
         position: relative;
         overflow: hidden;
         margin-left: auto;
         margin-right: auto;
     }
     
     .neo-badge i {
         margin-right: 0.5rem;
         color: #e2e8f0;
     }
     
     .neo-badge-link {
         text-decoration: none;
         display: inline-block;
         transition: transform 0.3s ease;
         position: relative;
         z-index: 10;
         cursor: pointer;
     }
     
     .neo-badge-link:hover {
         transform: translateY(-3px);
     }
     
     .neo-badge-link:hover .neo-badge {
         background: rgba(255, 255, 255, 0.15);
         border-color: rgba(255, 255, 255, 0.3);
         box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
     }
     
     .neo-badge-link .neo-badge {
         pointer-events: none;
     }
    
    .futuristic-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #ffffff 0%, #e5e5e5 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
        letter-spacing: -0.5px;
    }
    
    .faculty-showcase {
        position: relative;
        z-index: 10;
        padding: 2rem 0;
        width: 100%;
    }
    
    .faculty-showcase .row {
        margin: 0 -15px;
        justify-content: center;
        align-items: flex-start;
    }
    
    .faculty-showcase .col-md-6.col-lg-3 {
        padding: 0 15px;
        margin-bottom: 2rem;
        display: flex;
        align-items: stretch;
    }
    
    .neo-faculty-card {
        position: relative;
        background: rgba(30, 41, 59, 0.95);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
        padding: 0;
        height: auto;
        min-height: 440px;
        width: 100%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3),
                    0 1px 3px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }
    
    .neo-faculty-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2),
                    0 2px 6px rgba(0, 0, 0, 0.1);
        border-color: rgba(255, 255, 255, 0.12);
    }
    
    .card-border {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 16px;
        background: transparent;
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        z-index: 1;
    }
    
    .faculty-img-wrapper {
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .faculty-img-container {
        position: relative;
        overflow: hidden;
        border-radius: 16px 16px 0 0;
        height: 280px;
        width: 100%;
        background: #2d3748;
    }
    
    .faculty-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        transition: transform 0.3s ease;
    }
    
    .neo-faculty-card:hover .faculty-img-container img {
        transform: scale(1.02);
    }
    
    .faculty-img-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #2d3748;
        z-index: 1;
        opacity: 1;
        transition: opacity 0.3s ease;
    }
    
    .faculty-img-container.loaded::before {
        opacity: 0;
    }
    
    .faculty-img-container::after {
        content: '👤';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: #718096;
        z-index: 2;
        opacity: 1;
        transition: opacity 0.3s ease;
    }
    
    .faculty-img-container.loaded::after {
        opacity: 0;
    }
    
    .img-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, 
                    transparent 0%, 
                    transparent 60%,
                    rgba(30, 41, 59, 0.3) 100%);
        z-index: 2;
        transition: all 0.3s ease;
    }
    

    
    .faculty-specialty-badge {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #e2e8f0;
        z-index: 3;
        transition: all 0.3s ease;
    }
    
    .neo-faculty-card:hover .faculty-specialty-badge {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.25);
    }
    
    .faculty-info {
        padding: 1.25rem;
        position: relative;
        z-index: 3;
        flex: 1;
        display: flex;
        flex-direction: column;
        background: rgba(30, 41, 59, 0.95);
        min-height: 140px;
    }
    
    .faculty-name {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #f7fafc;
        line-height: 1.3;
        letter-spacing: -0.02em;
        transition: color 0.3s ease;
    }
    
    .faculty-position {
        font-size: 0.85rem;
        color: #a0aec0;
        margin-bottom: 1rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .faculty-quote {
        background: rgba(45, 55, 72, 0.5);
        border-left: 3px solid rgba(255, 255, 255, 0.2);
        border-radius: 0 8px 8px 0;
        padding: 12px 15px;
        font-style: italic;
        font-size: 0.85rem;
        color: #cbd5e0;
        margin-bottom: 0;
        margin-top: 1rem;
        position: relative;
        transition: all 0.3s ease;
        line-height: 1.4;
        flex: 1;
        min-height: 60px;
        display: flex;
        align-items: center;
    }
    
    .neo-button {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #4361ee;
        border: 1px solid #4361ee;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        color: white;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }
    
    .neo-button:hover {
        background: #3651d4;
        border-color: #3651d4;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(67, 97, 238, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .button-content {
        position: relative;
    }
    
    .button-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 8px;
        transition: transform 0.3s ease;
    }
    
    .neo-button:hover .button-icon {
        transform: translateX(3px);
    }
    
    /* Responsive Design for Faculty Cards */
    @media (max-width: 1199px) {
        .faculty-spotlight {
            padding: 50px 0 70px 0 !important;
        }
        
        .neo-faculty-card {
            min-height: 360px;
        }
        
        .faculty-img-container {
            height: 200px;
        }
        
        .faculty-info {
            min-height: 120px;
        }
    }
    
    @media (max-width: 991px) {
        .faculty-spotlight {
            padding: 40px 0 60px 0 !important;
        }
        
        .neo-faculty-card {
            min-height: 340px;
        }
        
        .faculty-img-container {
            height: 180px;
        }
        
        .faculty-showcase .col-md-6.col-lg-3 {
            margin-bottom: 1.5rem;
        }
        
        .faculty-info {
            min-height: 110px;
            padding: 1rem;
        }
        
        .futuristic-title {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 767px) {
        .faculty-spotlight {
            padding: 30px 0 50px 0 !important;
        }
        
        .neo-faculty-card {
            min-height: 320px;
        }
        
        .faculty-img-container {
            height: 160px;
        }
        
        .faculty-info {
            padding: 1rem;
            min-height: 100px;
        }
        
        .faculty-name {
            font-size: 1.2rem;
        }
        
        .faculty-quote {
            font-size: 0.8rem;
            padding: 10px 12px;
            min-height: 50px;
        }
        
        .futuristic-title {
            font-size: 2rem;
        }
        
        .faculty-showcase {
            padding: 1rem 0;
        }
        
        .faculty-showcase .col-md-6.col-lg-3 {
            margin-bottom: 1.5rem;
        }
        
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 1rem !important;
        }
    }
    
    @media (max-width: 575px) {
        .faculty-spotlight {
            padding: 25px 0 40px 0 !important;
        }
        
        .faculty-img-container {
            height: 140px;
        }
        
        .neo-faculty-card {
            min-height: 300px;
        }
        
        .faculty-info {
            padding: 0.875rem;
            min-height: 90px;
        }
        
        .faculty-social {
            top: 10px;
            right: 10px;
            gap: 6px;
        }
        
        .social-icon {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
        
        .faculty-quote {
            font-size: 0.75rem;
            padding: 8px 10px;
            min-height: 45px;
        }
        
        .futuristic-title {
            font-size: 1.8rem;
        }
        
        .faculty-showcase .col-md-6.col-lg-3 {
            margin-bottom: 1.25rem;
        }
    }
    
    /* Neo loader */
    .neo-loader {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .neo-loader span {
        display: block;
        width: 15px;
        height: 15px;
        background: #4361ee;
        border-radius: 50%;
        animation: neo-loader 1.5s infinite ease-in-out;
    }
    
    .neo-loader span:nth-child(1) {
        animation-delay: 0s;
        background: #4361ee;
    }
    
    .neo-loader span:nth-child(2) {
        animation-delay: 0.2s;
        background: #7209b7;
    }
    
    .neo-loader span:nth-child(3) {
        animation-delay: 0.4s;
        background: #4cc9f0;
    }
    
    @keyframes neo-loader {
        0%, 100% { transform: scale(0.5); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }
    
    /* Responsive adjustments */
    @media (max-width: 991px) {
        .futuristic-title {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 767px) {
        .neo-faculty-card {
            max-width: 320px;
            margin: 0 auto;
        }
    }
    </style>

    <!-- Futuristic Research Events Section -->
    <section class="events-section section-padding">
        <!-- Futuristic background elements -->
        <div class="events-bg-grid"></div>
        <div class="events-orb orb-1"></div>
        <div class="events-orb orb-2"></div>
        <div class="events-glow-effect"></div>
        
        <div class="container position-relative">
            <div class="section-header text-center mb-5" data-aos="fade-up">
                <div class="badge-wrapper d-flex justify-content-center mb-3">
                    <span class="neo-badge event-badge"><i class="bi bi-calendar-event me-2"></i>Upcoming Opportunities</span>
                    </div>
                <h2 class="futuristic-title">Research <span class="text-gradient">Events</span></h2>
                <p class="section-subtitle mx-auto">Discover symposiums, workshops, and networking opportunities to expand your research horizons</p>
                <div class="title-underline mx-auto"></div>
            </div>
            
            <div class="row g-4 event-timeline">
                <!-- Event 1 -->
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
                    <div class="neo-event-card">
                        <div class="card-border"></div>
                        <div class="card-glow"></div>
                        
                        <div class="event-date-badge">
                            <div class="date-content">
                            <span class="event-day">15</span>
                            <span class="event-month">DEC</span>
                        </div>
                            <div class="date-glow"></div>
                        </div>
                        
                        <div class="event-content">
                            <div class="event-tags">
                                <span class="event-tag">Conference</span>
                                <span class="event-tag">Research</span>
                            </div>
                            
                            <h4 class="event-title">Annual Research Symposium</h4>
                            
                            <div class="event-meta">
                                <div class="meta-item">
                                    <i class="bi bi-clock"></i>
                                    <span>10:00 AM - 4:00 PM</span>
                            </div>
                                <div class="meta-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>UIU Main Auditorium</span>
                                </div>
                            </div>
                            
                            <p class="event-description">Join us for presentations from leading researchers across multiple disciplines, networking opportunities, and research showcases.</p>
                            
                            <a href="#" class="neo-button small">
                                <span class="button-content">Register Now</span>
                                <span class="button-icon"><i class="bi bi-arrow-right"></i></span>
                                <div class="button-glow"></div>
                            </a>
                        </div>
                        
                        <div class="card-circuit-pattern"></div>
                    </div>
                </div>
                
                <!-- Event 2 -->
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="neo-event-card">
                        <div class="card-border"></div>
                        <div class="card-glow"></div>
                        
                        <div class="event-date-badge">
                            <div class="date-content">
                            <span class="event-day">22</span>
                            <span class="event-month">DEC</span>
                        </div>
                            <div class="date-glow"></div>
                        </div>
                        
                        <div class="event-content">
                            <div class="event-tags">
                                <span class="event-tag">Workshop</span>
                                <span class="event-tag">AI</span>
                            </div>
                            
                            <h4 class="event-title">AI Research Workshop</h4>
                            
                            <div class="event-meta">
                                <div class="meta-item">
                                    <i class="bi bi-clock"></i>
                                    <span>2:00 PM - 5:00 PM</span>
                            </div>
                                <div class="meta-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>Virtual Event</span>
                                </div>
                            </div>
                            
                            <p class="event-description">A practical workshop on applying machine learning to research problems with hands-on training sessions and expert guidance.</p>
                            
                            <a href="#" class="neo-button small">
                                <span class="button-content">Join Online</span>
                                <span class="button-icon"><i class="bi bi-arrow-right"></i></span>
                                <div class="button-glow"></div>
                            </a>
                        </div>
                        
                        <div class="card-circuit-pattern"></div>
                    </div>
                </div>
                
                <!-- Event 3 -->
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="neo-event-card">
                        <div class="card-border"></div>
                        <div class="card-glow"></div>
                        
                        <div class="event-date-badge">
                            <div class="date-content">
                            <span class="event-day">10</span>
                            <span class="event-month">JAN</span>
                        </div>
                            <div class="date-glow"></div>
                        </div>
                        
                        <div class="event-content">
                            <div class="event-tags">
                                <span class="event-tag">Workshop</span>
                                <span class="event-tag">Funding</span>
                            </div>
                            
                            <h4 class="event-title">Grant Writing Workshop</h4>
                            
                            <div class="event-meta">
                                <div class="meta-item">
                                    <i class="bi bi-clock"></i>
                                    <span>9:00 AM - 1:00 PM</span>
                            </div>
                                <div class="meta-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>Science Building, Room 305</span>
                                </div>
                            </div>
                            
                            <p class="event-description">Learn strategies for writing successful research grant proposals with feedback from experienced researchers and grant reviewers.</p>
                            
                            <a href="#" class="neo-button small">
                                <span class="button-content">Register Now</span>
                                <span class="button-icon"><i class="bi bi-arrow-right"></i></span>
                                <div class="button-glow"></div>
                            </a>
                        </div>
                        
                        <div class="card-circuit-pattern"></div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="neo-button primary calendar-button">
                    <span class="button-content">View Full Calendar</span>
                    <span class="button-icon"><i class="bi bi-calendar-week"></i></span>
                    <div class="button-glow"></div>
                </a>
            </div>
    </div>
  </section>

    <style>
    /* Modern Futuristic Events Section Styling */
    .events-section {
        background: linear-gradient(135deg, #121729 0%, #1a2151 100%);
        position: relative;
        overflow: hidden;
        color: #fff;
    }
    
    .events-bg-grid {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: linear-gradient(to right, rgba(76, 201, 240, 0.03) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(76, 201, 240, 0.03) 1px, transparent 1px);
        background-size: 30px 30px;
        z-index: 1;
        opacity: 0.5;
        pointer-events: none;
    }
    
    .events-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 1;
        pointer-events: none;
    }
    
    .events-orb.orb-1 {
        width: 400px;
        height: 400px;
        top: -100px;
        left: -150px;
        background: radial-gradient(circle, rgba(114, 9, 183, 0.2) 0%, transparent 70%);
        animation: float-slow 12s ease-in-out infinite alternate-reverse;
    }
    
    .events-orb.orb-2 {
        width: 300px;
        height: 300px;
        bottom: -50px;
        right: -100px;
        background: radial-gradient(circle, rgba(247, 37, 133, 0.2) 0%, transparent 70%);
        animation: float-slow 15s ease-in-out infinite alternate;
    }
    
    .events-glow-effect {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%;
        height: 60%;
        background: radial-gradient(ellipse, rgba(114, 9, 183, 0.1), transparent 70%);
        opacity: 0.6;
        z-index: 1;
        filter: blur(40px);
        pointer-events: none;
    }
    
    .events-timeline {
        position: relative;
        z-index: 2;
    }
    
    .events-timeline-line {
        position: absolute;
        top: 115px;
        left: 50%;
        width: 80%;
        height: 2px;
        background: linear-gradient(to right, 
            rgba(76, 201, 240, 0), 
            rgba(76, 201, 240, 0.5), 
            rgba(76, 201, 240, 0.8), 
            rgba(76, 201, 240, 0.5), 
            rgba(76, 201, 240, 0));
        transform: translateX(-50%);
        z-index: 1;
        opacity: 0.5;
    }
    
    .event-badge {
        background: rgba(247, 37, 133, 0.1);
        border: 1px solid rgba(247, 37, 133, 0.2);
    }
    
    .event-badge i {
        color: rgba(247, 37, 133, 0.8);
    }
    
    .neo-event-card {
        position: relative;
        background: rgba(30, 41, 59, 0.6);
        border-radius: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
        padding: 0;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: all 0.4s cubic-bezier(0.17, 0.67, 0.83, 0.67);
        transform: perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1);
        transform-style: preserve-3d;
    }
    
    .neo-event-card:hover {
        box-shadow: 0 15px 40px rgba(247, 37, 133, 0.2);
        border-color: rgba(247, 37, 133, 0.3);
        transform: translateY(-10px) scale(1.02);
    }
    
    .neo-event-card .card-border {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 2px solid transparent;
        border-radius: 16px;
        background-image: linear-gradient(to bottom right, 
            rgba(76, 201, 240, 0), 
            rgba(76, 201, 240, 0.1), 
            rgba(247, 37, 133, 0.2), 
            rgba(76, 201, 240, 0));
        background-origin: border-box;
        background-clip: content-box, border-box;
        pointer-events: none;
        z-index: 2;
    }
    
    .neo-event-card .card-glow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(247, 37, 133, 0.2), transparent 70%);
        opacity: 0;
        transition: opacity 0.5s ease;
        z-index: 1;
        pointer-events: none;
    }
    
    .neo-event-card:hover .card-glow {
        opacity: 1;
    }
    
    .event-date-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 70px;
        height: 70px;
        background: rgba(247, 37, 133, 0.15);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(247, 37, 133, 0.3);
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 3;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .neo-event-card:hover .event-date-badge {
        transform: scale(1.1);
        background: rgba(247, 37, 133, 0.2);
        box-shadow: 0 5px 15px rgba(247, 37, 133, 0.2);
    }
    
    .date-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .event-day {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1;
        background: linear-gradient(135deg, #ffffff, #e0e0e0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .event-month {
        font-size: 0.8rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .date-glow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, transparent, rgba(247, 37, 133, 0.2), transparent);
        transform: translateX(-100%);
        z-index: -1;
    }
    
    .neo-event-card:hover .date-glow {
        animation: shine 2s infinite;
    }
    
    .event-content {
        padding: 1.5rem;
        position: relative;
        z-index: 3;
    }
    
    .event-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .event-tag {
        background: rgba(76, 201, 240, 0.1);
        border: 1px solid rgba(76, 201, 240, 0.2);
        border-radius: 50px;
        padding: 4px 12px;
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }
    
    .neo-event-card:hover .event-tag {
        background: rgba(76, 201, 240, 0.15);
        transform: translateY(-2px);
    }
    
    .event-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 12px;
        background: linear-gradient(135deg, #ffffff, #e0e0e0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transition: all 0.3s ease;
    }
    
    .neo-event-card:hover .event-title {
        transform: scale(1.02);
    }
    
    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 15px;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.7);
    }
    
    .meta-item i {
        color: rgba(247, 37, 133, 0.8);
        font-size: 0.9rem;
    }
    
    .event-description {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }
    
    .card-circuit-pattern {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 120px;
        height: 120px;
        background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTAgMTBjMCAwIDIwIDAgMjAgMjBtLTIwIDIwYzAgMCAyMCAwIDIwLTIwbTIwIDBjMCAwIDAgMjAgLTIwIDIwbTQwIC0yMGMwIDAgMCAyMCAtMjAgMjBtMjAgLTIwYzAgMCAwIC0yMCAtMjAgLTIwbS0yMCAwYzAgMCAwIC0yMCAyMCAtMjAiIHN0cm9rZT0icmdiYSgyNDcsIDM3LCAxMzMsIDAuMikiIHN0cm9rZS13aWR0aD0iMiIgZmlsbD0ibm9uZSIvPjwvc3ZnPg==');
        background-size: 100% 100%;
        opacity: 0.2;
        z-index: 1;
    }
    
    .calendar-button {
        background: linear-gradient(135deg, rgba(247, 37, 133, 0.9), rgba(114, 9, 183, 0.9));
        border-color: rgba(247, 37, 133, 0.5);
    }
    
    .calendar-button:hover {
        background: linear-gradient(135deg, rgba(247, 37, 133, 1), rgba(114, 9, 183, 1));
    }
    
    /* Animations for staggered card appearance */
    @keyframes card-float {
        0% { transform: translateY(20px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }
    
    /* Add responsive adjustments */
    @media (max-width: 991px) {
        .events-timeline-line {
            display: none;
        }
    }
    
    @media (max-width: 767px) {
        .neo-event-card {
            max-width: 320px;
            margin: 0 auto;
        }
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add parallax effect to event cards
        const eventCards = document.querySelectorAll('.neo-event-card');
        
        eventCards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // Calculate rotation values based on mouse position
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const deltaX = (x - centerX) / 15;
                const deltaY = (y - centerY) / 15;
                
                // Apply 3D rotation
                this.style.transform = `perspective(1000px) rotateX(${-deltaY}deg) rotateY(${deltaX}deg) translateY(-5px)`;
                
                // Move glow to follow cursor
                const glow = this.querySelector('.card-glow');
                if (glow) {
                    glow.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(247, 37, 133, 0.3), transparent 60%)`;
                    glow.style.opacity = '1';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                // Reset transforms and effects
                this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
                
                const glow = this.querySelector('.card-glow');
                if (glow) {
                    glow.style.background = 'radial-gradient(circle at center, rgba(247, 37, 133, 0.2), transparent 70%)';
                    glow.style.opacity = '0';
                }
            });
            
            // Add entry animation
            const delay = Array.from(eventCards).indexOf(card) * 100;
            card.style.animation = `card-float 0.8s ease-out ${delay}ms forwards`;
            card.style.opacity = '0';
        });
    });
    </script>

  <!-- Futuristic Research Guidance FAQ Section -->
  <section id="faq-section" class="faq-section section-padding">
    <!-- Futuristic background elements -->
    <div class="faq-bg-particles"></div>
    <div class="faq-orb faq-orb-1"></div>
    <div class="faq-orb faq-orb-2"></div>
    <div class="faq-mesh-grid"></div>
    
    <div class="container position-relative">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <div class="badge-wrapper d-flex justify-content-center mb-3">
                <span class="neo-badge faq-badge"><i class="bi bi-question-circle me-2"></i>Research Guidance</span>
            </div>
            <h2 class="futuristic-title">Frequently <span class="text-gradient">Asked</span> Questions</h2>
            <p class="section-subtitle mx-auto">Find detailed answers to common research questions at UIU</p>
            <div class="title-underline mx-auto"></div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-10">
                <div class="faq-container" data-aos="fade-up">
                    <div class="row">
        <div class="col-md-6">
                            <div class="accordion neo-accordion" id="faqAccordionLeft">
            <!-- FAQs will be dynamically added here -->
          </div>
        </div>
        <div class="col-md-6">
                            <div class="accordion neo-accordion" id="faqAccordionRight">
            <!-- FAQs will be dynamically added here -->
          </div>
        </div>
      </div>
      </div>
    </div>
        </div>
        
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="200">
            <a href="#" class="neo-button primary question-button">
                <span class="button-content">Ask a Question</span>
                <span class="button-icon"><i class="bi bi-question-circle"></i></span>
                <div class="button-glow"></div>
            </a>
                    </div>
                    </div>
  </section>

  <style>
  /* Modern Futuristic FAQ Section Styling */
  .faq-section {
      background: linear-gradient(135deg, #1a1d2c 0%, #2a1a46 100%);
      position: relative;
      overflow: hidden;
      color: #fff;
      padding: 100px 0;
  }
  
  .faq-bg-particles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: radial-gradient(rgba(76, 201, 240, 0.1) 2px, transparent 2px);
      background-size: 50px 50px;
      z-index: 1;
      opacity: 0.2;
      pointer-events: none;
  }
  
  .faq-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(70px);
      z-index: 1;
      pointer-events: none;
  }
  
  .faq-orb-1 {
      width: 500px;
      height: 500px;
      top: -200px;
      right: -200px;
      background: radial-gradient(circle, rgba(76, 201, 240, 0.15) 0%, transparent 70%);
      animation: float-slow 15s ease-in-out infinite alternate;
  }
  
  .faq-orb-2 {
      width: 400px;
      height: 400px;
      bottom: -150px;
      left: -150px;
      background: radial-gradient(circle, rgba(247, 37, 133, 0.15) 0%, transparent 70%);
      animation: float-slow 18s ease-in-out infinite alternate-reverse;
  }
  
  .faq-mesh-grid {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: linear-gradient(to right, rgba(114, 9, 183, 0.05) 1px, transparent 1px),
                        linear-gradient(to bottom, rgba(114, 9, 183, 0.05) 1px, transparent 1px);
      background-size: 35px 35px;
      z-index: 1;
      opacity: 0.4;
      pointer-events: none;
  }
  
  .faq-badge {
      background: rgba(76, 201, 240, 0.1);
      border: 1px solid rgba(76, 201, 240, 0.3);
      padding: 8px 16px;
  }
  
  .faq-badge i {
      color: rgba(76, 201, 240, 0.8);
  }
  
  .faq-container {
      position: relative;
      z-index: 2;
  }
  
  .neo-accordion {
      position: relative;
      z-index: 2;
  }
  
  .neo-accordion .accordion-item {
      background: rgba(30, 41, 59, 0.6);
      border: 1px solid rgba(76, 201, 240, 0.2);
      border-radius: 12px;
      backdrop-filter: blur(10px);
      overflow: hidden;
      margin-bottom: 16px;
      transition: all 0.3s ease;
      transform: translateY(0);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }
  
  .neo-accordion .accordion-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(76, 201, 240, 0.15);
      border-color: rgba(76, 201, 240, 0.4);
  }
  
  .neo-accordion .accordion-button {
      background: rgba(30, 41, 59, 0.8);
      color: #fff;
      font-weight: 600;
      padding: 20px;
      border: none;
      position: relative;
      transition: all 0.3s ease;
      overflow: hidden;
  }
  
  .neo-accordion .accordion-button:not(.collapsed) {
      background: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(42, 26, 70, 0.9));
      color: rgba(76, 201, 240, 1);
      box-shadow: none;
  }
  
  .neo-accordion .accordion-button::after {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
      transition: all 0.3s ease;
  }
  
  .neo-accordion .accordion-button:not(.collapsed)::after {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234CC9F0'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
  }
  
  .neo-accordion .accordion-button::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(to bottom, rgba(76, 201, 240, 0.7), rgba(114, 9, 183, 0.7));
      opacity: 0;
      transition: opacity 0.3s ease;
  }
  
  .neo-accordion .accordion-button:not(.collapsed)::before {
      opacity: 1;
  }
  
  .neo-accordion .accordion-body {
      background: rgba(22, 28, 45, 0.6);
      color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      line-height: 1.6;
      font-size: 0.95rem;
      border-top: 1px solid rgba(76, 201, 240, 0.1);
  }
  
  /* Highlight keywords in answers */
  .neo-accordion .accordion-body strong {
      color: rgba(76, 201, 240, 1);
      font-weight: 600;
  }
  
  .neo-accordion .accordion-body a {
      color: rgba(247, 37, 133, 0.9);
      text-decoration: none;
      border-bottom: 1px dashed rgba(247, 37, 133, 0.4);
      transition: all 0.3s ease;
  }
  
  .neo-accordion .accordion-body a:hover {
      color: rgba(247, 37, 133, 1);
      border-bottom: 1px solid rgba(247, 37, 133, 0.8);
  }
  
  /* Animated glow around the active accordion */
  .neo-accordion .accordion-item.active-glow {
      position: relative;
  }
  
  .neo-accordion .accordion-item.active-glow::after {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      background: linear-gradient(45deg, 
          rgba(76, 201, 240, 0.5),
          rgba(114, 9, 183, 0.5),
          rgba(247, 37, 133, 0.5),
          rgba(76, 201, 240, 0.5));
      border-radius: 14px;
      z-index: -1;
      opacity: 0;
      transition: opacity 0.3s ease;
  }
  
  .neo-accordion .accordion-item:has(.accordion-button:not(.collapsed))::after {
      opacity: 0.7;
      animation: glow-pulse 3s infinite;
  }
  
  /* Question button styling */
  .question-button {
      background: linear-gradient(135deg, rgba(76, 201, 240, 0.9), rgba(114, 9, 183, 0.9));
      border-color: rgba(76, 201, 240, 0.5);
  }
  
  .question-button:hover {
      background: linear-gradient(135deg, rgba(76, 201, 240, 1), rgba(114, 9, 183, 1));
  }
  
  /* Animation for the accordion items */
  @keyframes slide-in {
      0% { transform: translateY(30px); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
  }
  
  @keyframes glow-pulse {
      0% { opacity: 0.7; }
      50% { opacity: 0.3; }
      100% { opacity: 0.7; }
  }
  
  /* Responsive styles */
  @media (max-width: 767px) {
      .neo-accordion .accordion-item {
          margin-bottom: 10px;
      }
      
      .neo-accordion .accordion-button {
          padding: 15px;
          font-size: 0.95rem;
      }
      
      .neo-accordion .accordion-body {
          padding: 15px;
          font-size: 0.9rem;
      }
  }
  </style>
  
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Add animation to FAQ accordion items
      const setupFaqAnimations = () => {
          const accordionItems = document.querySelectorAll('.neo-accordion .accordion-item');
          
          accordionItems.forEach((item, index) => {
              // Add staggered animation
              const delay = 100 + (index * 50);
              item.style.animation = `slide-in 0.6s ease-out ${delay}ms forwards`;
              item.style.opacity = '0';
              
              // Add event listeners for button interactions
              const button = item.querySelector('.accordion-button');
              
              button.addEventListener('click', function() {
                  // Remove active glow from all items
                  accordionItems.forEach(i => i.classList.remove('active-glow'));
                  
                  // Add active glow to clicked item if it's expanded
                  if (this.classList.contains('collapsed')) {
                      setTimeout(() => {
                          item.classList.add('active-glow');
                      }, 100);
                  }
              });
          });
      };
      
      // Set up observer to run the animation when fetching is complete
      const observer = new MutationObserver((mutations) => {
          mutations.forEach((mutation) => {
              if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                  // Check if FAQs have been loaded
                  if (document.querySelectorAll('.neo-accordion .accordion-item').length > 0) {
                      setupFaqAnimations();
                      observer.disconnect(); // Stop observing once FAQs are loaded
                  }
              }
          });
      });
      
      // Start observing the accordion containers
      observer.observe(document.getElementById('faqAccordionLeft'), { childList: true });
      observer.observe(document.getElementById('faqAccordionRight'), { childList: true });
      
      // Create interactive particle background effect
      const createParticleEffect = () => {
          const faqSection = document.getElementById('faq-section');
          if (!faqSection) return;
          
          // Create canvas for particles
          const canvas = document.createElement('canvas');
          canvas.classList.add('faq-particles-canvas');
          canvas.style.position = 'absolute';
          canvas.style.top = '0';
          canvas.style.left = '0';
          canvas.style.width = '100%';
          canvas.style.height = '100%';
          canvas.style.pointerEvents = 'none';
          canvas.style.zIndex = '1';
          canvas.style.opacity = '0.4';
          
          faqSection.insertBefore(canvas, faqSection.firstChild);
          
          // Set canvas size
          const resizeCanvas = () => {
              canvas.width = faqSection.offsetWidth;
              canvas.height = faqSection.offsetHeight;
          };
          
          resizeCanvas();
          window.addEventListener('resize', resizeCanvas);
          
          // Create particles
          const ctx = canvas.getContext('2d');
          const particles = [];
          
          class Particle {
              constructor() {
                  this.x = Math.random() * canvas.width;
                  this.y = Math.random() * canvas.height;
                  this.size = Math.random() * 2 + 0.5;
                  this.speedX = Math.random() * 0.5 - 0.25;
                  this.speedY = Math.random() * 0.5 - 0.25;
                  this.color = Math.random() > 0.5 ? 
                      `rgba(76, 201, 240, ${Math.random() * 0.5 + 0.2})` : 
                      `rgba(247, 37, 133, ${Math.random() * 0.5 + 0.2})`;
              }
              
              update() {
                  this.x += this.speedX;
                  this.y += this.speedY;
                  
                  if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                  if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
              }
              
              draw() {
                  ctx.fillStyle = this.color;
                  ctx.beginPath();
                  ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                  ctx.fill();
              }
          }
          
          const initParticles = () => {
              for (let i = 0; i < 50; i++) {
                  particles.push(new Particle());
              }
          };
          
          const animateParticles = () => {
              ctx.clearRect(0, 0, canvas.width, canvas.height);
              
              for (let i = 0; i < particles.length; i++) {
                  particles[i].update();
                  particles[i].draw();
                  
                  // Connect particles with lines
                  for (let j = i; j < particles.length; j++) {
                      const dx = particles[i].x - particles[j].x;
                      const dy = particles[i].y - particles[j].y;
                      const distance = Math.sqrt(dx * dx + dy * dy);
                      
                      if (distance < 100) {
                          ctx.beginPath();
                          ctx.strokeStyle = `rgba(114, 9, 183, ${0.1 * (1 - distance / 100)})`;
                          ctx.lineWidth = 0.2;
                          ctx.moveTo(particles[i].x, particles[i].y);
                          ctx.lineTo(particles[j].x, particles[j].y);
                          ctx.stroke();
                      }
                  }
              }
              
              requestAnimationFrame(animateParticles);
          };
          
          initParticles();
          animateParticles();
      };
      
      // Initialize the particle effect
      createParticleEffect();
  });
  </script>

    <!-- Futuristic Footer Section -->
    <footer class="neo-footer footer" id="footer-section">
        <div class="footer-bg-elements">
            <div class="footer-orb orb-1"></div>
            <div class="footer-orb orb-2"></div>
            <div class="footer-circuit-grid"></div>
                </div>
        
        <div class="container position-relative" style="z-index: 5;">
            <div class="footer-logo-section text-center" data-aos="fade-up">
                <a href="index.php" class="glowing-logo interactive-element">
                    <h2 class="text-logo footer-text-logo">UIURP</h2>
                    <div class="logo-glow"></div>
                </a>
                <h4 class="mt-4 mb-3 footer-tagline">Advancing the Future Through <span class="text-gradient">Innovative Research</span></h4>
                <div class="title-underline mx-auto"></div>
            </div>
            
            <div class="row g-4 mt-5">
                                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="footer-card interactive-card">
                        <div class="card-glow"></div>
                        <div class="card-content">
                            <h5 class="footer-heading">
                                <i class="bi bi-link-45deg footer-icon"></i>
                                Quick Links
                            </h5>
                    <ul class="footer-links">
                                <li>
                                    <a href="Research_page.php" class="interactive-link">
                                        <span class="link-icon"><i class="bi bi-arrow-right-circle"></i></span>
                                        <span class="link-text">Research Projects</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="Faculty_Page.php" class="interactive-link">
                                        <span class="link-icon"><i class="bi bi-arrow-right-circle"></i></span>
                                        <span class="link-text">Faculty Profiles</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="Research_page.php" class="interactive-link" data-tooltip="Browse academic publications">
                                        <span class="link-icon"><i class="bi bi-arrow-right-circle"></i></span>
                                        <span class="link-text">Publications Database</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="Research_page.php" class="interactive-link" data-tooltip="Access research learning materials">
                                        <span class="link-icon"><i class="bi bi-arrow-right-circle"></i></span>
                                        <span class="link-text">Learning Resources</span>
                                    </a>
                                </li>
                    </ul>
                </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="footer-card">
                        <div class="card-glow"></div>
                        <div class="card-content">
                        <h5 class="footer-heading">
                                <i class="bi bi-journal-text footer-icon"></i>
                                Research Resources
                        </h5>
                    <ul class="footer-links">
                        <li><a href="#">Research Guidelines</a></li>
                        <li><a href="#">Funding Opportunities</a></li>
                        <li><a href="#">Labs & Facilities</a></li>
                                <li><a href="#">Ethics Committee</a></li>
                    </ul>
                </div>
                        </div>
                    </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="footer-card">
                        <div class="card-glow"></div>
                        <div class="card-content">
                        <h5 class="footer-heading">
                                <i class="bi bi-envelope-at footer-icon"></i>
                                Stay Connected
                        </h5>
                            <p class="footer-text">Subscribe for research news, events, and opportunities</p>
                            <div class="neo-newsletter">
                                <div class="input-wrapper">
                                    <input type="email" class="neo-input" placeholder="Email address">
                                    <button class="neo-button small subscribe-button">
                                        <span class="button-content">Subscribe</span>
                                        <span class="button-icon"><i class="bi bi-send"></i></span>
                                    </button>
                </div>
                                <p class="privacy-note">By subscribing, you agree to our Privacy Policy</p>
            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                        <div class="footer-social-section text-center mt-5" data-aos="fade-up" data-aos-delay="400">
                <div class="social-links-container">
                    <a href="#" class="social-link facebook-link" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                        <div class="link-glow"></div>
                        <span class="link-tooltip">Follow us on Facebook</span>
                    </a>
                    <a href="#" class="social-link twitter-link" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                        <div class="link-glow"></div>
                        <span class="link-tooltip">Follow us on Twitter</span>
                    </a>
                    <a href="#" class="social-link linkedin-link" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                        <div class="link-glow"></div>
                        <span class="link-tooltip">Connect on LinkedIn</span>
                    </a>
                    <a href="#" class="social-link instagram-link" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                        <div class="link-glow"></div>
                        <span class="link-tooltip">Follow our Instagram</span>
                    </a>
                    <a href="#" class="social-link youtube-link" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                        <div class="link-glow"></div>
                        <span class="link-tooltip">Watch on YouTube</span>
                    </a>
                </div>
            </div>
            
            <div class="footer-bottom" data-aos="fade-up" data-aos-delay="500">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="copyright-text">&copy; 2025 UIU Research Portal. All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <ul class="footer-bottom-links">
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-line"></div>
            </div>
    </div>
      
        <!-- Contact Modal -->
        <div class="contact-modal" id="contactModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5><i class="bi bi-envelope-paper-fill"></i> Contact Us</h5>
                    <button class="close-btn" id="closeModal"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
    </div>
  </footer>
    
    <style>
    /* Futuristic Footer Styling - Improved */
    .neo-footer {
        background: linear-gradient(135deg, #121729 0%, #1e1a3a 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
        padding: 120px 0 70px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-sizing: border-box;
        scroll-margin-top: 0;
    }
    
    .footer-bg-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none; /* This ensures clicks pass through to elements below */
    }
    
    .footer-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.4;
        pointer-events: none;
    }
    
    .footer-orb.orb-1 {
        width: 600px;
        height: 600px;
        top: -300px;
        right: -200px;
        background: radial-gradient(circle, rgba(76, 201, 240, 0.15) 0%, transparent 70%);
        animation: float-slow 20s ease-in-out infinite alternate;
    }
    
    .footer-orb.orb-2 {
        width: 500px;
        height: 500px;
        bottom: -250px;
        left: -200px;
        background: radial-gradient(circle, rgba(114, 9, 183, 0.15) 0%, transparent 70%);
        animation: float-slow 25s ease-in-out infinite alternate-reverse;
    }
    
    .footer-circuit-grid {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(to right, rgba(76, 201, 240, 0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(76, 201, 240, 0.03) 1px, transparent 1px);
        background-size: 30px 30px;
        z-index: 0;
        opacity: 0.5;
        pointer-events: none;
    }
    
    
    .glowing-logo {
        position: relative;
        display: inline-block;
    }
    
    .footer-text-logo {
        position: relative;
        z-index: 2;
        font-size: 3.5rem;
        font-weight: 700;
        margin: 0;
        background: linear-gradient(to right, #ffffff, #4cc9f0);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 8px rgba(114, 9, 183, 0.3);
        transition: all 0.5s ease;
        letter-spacing: -1px;
        text-transform: uppercase;
    }
    
    .glowing-logo:hover .footer-text-logo {
        background: linear-gradient(to right, #ffffff, #7209b7);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 15px rgba(76, 201, 240, 0.6);
    }
    
    .logo-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 140%;
        height: 140%;
        background: radial-gradient(circle, rgba(76, 201, 240, 0.2), transparent 70%);
        border-radius: 50%;
        z-index: 1;
        opacity: 0.7;
        animation: pulse-glow 3s infinite alternate;
    }
    
    .footer-tagline {
        font-weight: 300;
        letter-spacing: 1px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .footer-card {
        position: relative;
        background: rgba(30, 41, 59, 0.4);
        border-radius: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(76, 201, 240, 0.1);
        overflow: hidden;
        height: 100%;
        transition: all 0.3s ease;
        transform: translateY(0);
    }
    
    .footer-card:hover {
        transform: translateY(-10px);
        border-color: rgba(76, 201, 240, 0.3);
        box-shadow: 0 10px 25px rgba(76, 201, 240, 0.1);
    }
    
    .card-glow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(76, 201, 240, 0.1), transparent 70%);
        opacity: 0;
        transition: all 0.5s ease;
        z-index: 1;
    }
    
    .footer-card:hover .card-glow {
        opacity: 1;
    }
    
    .card-content {
        position: relative;
        z-index: 5;
        padding: 25px;
    }
    
    .footer-heading {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .footer-icon {
        color: rgba(76, 201, 240, 0.9);
        font-size: 1.4rem;
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li {
        margin-bottom: 12px;
        position: relative;
        transition: all 0.3s ease;
        padding-left: 18px;
    }
    
    .footer-links li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background: rgba(76, 201, 240, 0.7);
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .footer-links li:hover {
        transform: translateX(5px);
    }
    
    .footer-links li:hover::before {
        background: rgba(247, 37, 133, 0.9);
        box-shadow: 0 0 8px rgba(247, 37, 133, 0.5);
    }
    
    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
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
        background: linear-gradient(to right, rgba(76, 201, 240, 0.7), rgba(247, 37, 133, 0.7));
        transition: all 0.3s ease;
    }
    
    .footer-links a:hover {
        color: #fff;
    }
    
    .footer-links a:hover::after {
        width: 100%;
    }
    
    .footer-text {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
        margin-bottom: 20px;
    }
    
    .neo-newsletter {
        position: relative;
    }
    
    .input-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .neo-input {
        width: 100%;
        background: rgba(22, 28, 45, 0.6);
        border: 1px solid rgba(76, 201, 240, 0.2);
        border-radius: 50px;
        padding: 12px 20px;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .neo-input:focus {
        outline: none;
        border-color: rgba(76, 201, 240, 0.5);
        box-shadow: 0 0 15px rgba(76, 201, 240, 0.2);
    }
    
    .neo-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    
    .subscribe-button {
        width: 100%;
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.9), rgba(114, 9, 183, 0.9));
        border-color: rgba(76, 201, 240, 0.3);
        margin: 0;
    }
    
    .subscribe-button:hover {
        background: linear-gradient(135deg, rgba(76, 201, 240, 1), rgba(114, 9, 183, 1));
    }
    
    .privacy-note {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.5);
        margin-top: 10px;
        text-align: center;
    }
    
    .social-links-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 30px 0;
    }
    
    .social-link {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: rgba(30, 41, 59, 0.6);
        border: 1px solid rgba(76, 201, 240, 0.2);
        border-radius: 50%;
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
        transition: all 0.3s ease;
        overflow: hidden;
        z-index: 2;
    }
    
    .social-link:hover {
        color: #fff;
        transform: translateY(-5px);
        border-color: rgba(247, 37, 133, 0.4);
    }
    
    .link-glow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(247, 37, 133, 0.3), transparent 70%);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .social-link:hover .link-glow {
        opacity: 1;
    }
    
    /* Enhanced Social Links */
    .facebook-link .link-glow {
        background: radial-gradient(circle at center, rgba(24, 119, 242, 0.5), transparent 70%);
    }
    
    .twitter-link .link-glow {
        background: radial-gradient(circle at center, rgba(29, 161, 242, 0.5), transparent 70%);
    }
    
    .linkedin-link .link-glow {
        background: radial-gradient(circle at center, rgba(0, 119, 181, 0.5), transparent 70%);
    }
    
    .instagram-link .link-glow {
        background: radial-gradient(circle at center, rgba(225, 48, 108, 0.5), transparent 70%);
    }
    
    .youtube-link .link-glow {
        background: radial-gradient(circle at center, rgba(255, 0, 0, 0.5), transparent 70%);
    }
    
    .social-link:hover {
        transform: translateY(-8px) scale(1.1);
    }
    
    .social-link:active {
        transform: translateY(-2px) scale(0.95);
    }
    
    .link-tooltip {
        position: absolute;
        top: -35px;
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        background: rgba(30, 41, 59, 0.95);
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.75rem;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 100;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(76, 201, 240, 0.2);
    }
    
    .social-link:hover .link-tooltip {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    
    .footer-bottom {
        margin-top: 70px;
        position: relative;
        z-index: 2;
        padding-bottom: 30px;
    }
    
    .copyright-text {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    
    .footer-bottom-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: flex-end;
        gap: 20px;
    }
    
    .footer-bottom-links li a {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .footer-bottom-links li a:hover {
        color: rgba(76, 201, 240, 1);
    }
    
    .footer-line {
        height: 1px;
        background: linear-gradient(to right, 
            transparent, 
            rgba(76, 201, 240, 0.2), 
            rgba(247, 37, 133, 0.2), 
            rgba(76, 201, 240, 0.2), 
            transparent);
        margin-top: 20px;
    }
    
    /* Interactive Elements */
    .interactive-element {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.17, 0.67, 0.83, 0.67);
        position: relative;
        z-index: 5;
    }
    
    .interactive-element:hover {
        transform: scale(1.05) translateY(-5px);
    }
    
    .interactive-element:active {
        transform: scale(0.98);
    }
    
    .interactive-card {
        transform-style: preserve-3d;
        perspective: 1000px;
    }
    
    .interactive-card .card-content {
        transition: transform 0.5s cubic-bezier(0.17, 0.67, 0.83, 0.67);
        backface-visibility: hidden;
    }
    
    .interactive-card:hover .card-content {
        transform: translateZ(20px);
    }
    
    .interactive-link {
        display: flex;
        align-items: center;
        position: relative;
        padding: 5px 0;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        transform: translateX(0);
    }
    
    .link-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        color: rgba(76, 201, 240, 0.7);
        font-size: 1rem;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateX(-10px);
    }
    
    .link-text {
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }
    
    .interactive-link:hover {
        color: white;
        transform: translateX(5px);
    }
    
    .interactive-link:hover .link-icon {
        opacity: 1;
        transform: translateX(0);
        color: rgba(247, 37, 133, 0.9);
    }
    
    .interactive-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 1px;
        background: linear-gradient(to right, rgba(76, 201, 240, 0.7), rgba(247, 37, 133, 0.7));
        transition: all 0.3s ease;
    }
    
    .interactive-link:hover::after {
        width: 100%;
    }
    
    /* Tooltips for links */
    .interactive-link[data-tooltip] {
        position: relative;
    }
    
    .interactive-link[data-tooltip]::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 0;
        background: rgba(30, 41, 59, 0.95);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 100;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(76, 201, 240, 0.2);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .interactive-link[data-tooltip]:hover::before {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Animations */
    @keyframes pulse-glow {
        0% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 0.7; transform: translate(-50%, -50%) scale(1.1); }
        100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
    }
    
    /* Contact Modal Styling */
    .contact-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .contact-modal.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content {
        width: 90%;
        max-width: 500px;
        background: rgba(22, 28, 45, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid rgba(76, 201, 240, 0.2);
        overflow: hidden;
        transform: scale(0.9);
        transition: transform 0.3s ease;
    }
    
    .contact-modal.active .modal-content {
        transform: scale(1);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid rgba(76, 201, 240, 0.1);
    }
    
    .modal-header h5 {
        margin: 0;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .modal-header h5 i {
        color: rgba(76, 201, 240, 0.9);
    }
    
    .close-btn {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .close-btn:hover {
        color: rgba(247, 37, 133, 0.9);
        transform: rotate(90deg);
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .form-control {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(76, 201, 240, 0.2);
        color: white;
    }
    
    .form-control:focus {
        background: rgba(30, 41, 59, 0.7);
        border-color: rgba(76, 201, 240, 0.5);
        box-shadow: 0 0 15px rgba(76, 201, 240, 0.2);
        color: white;
    }
    
    .submit-btn {
        background: linear-gradient(135deg, rgba(76, 201, 240, 0.9), rgba(114, 9, 183, 0.9));
        border: none;
        transition: all 0.3s ease;
    }
    
    .submit-btn:hover {
        background: linear-gradient(135deg, rgba(76, 201, 240, 1), rgba(114, 9, 183, 1));
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(76, 201, 240, 0.3);
    }
    
    /* Responsive adjustments */
    @media (max-width: 991px) {
        .footer-card {
            margin-bottom: 20px;
        }
    }
    
    @media (max-width: 767px) {
        .footer-bottom-links {
            justify-content: center;
            margin-top: 15px;
        }
        
        .copyright-text {
            text-align: center;
        }
        
        .footer-logo {
            max-height: 60px;
        }
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to footer cards
        const footerCards = document.querySelectorAll('.footer-card');
        
        footerCards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                // For interactive 3D cards, calculate rotation
                if (this.classList.contains('interactive-card')) {
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateY = ((x - centerX) / centerX) * 5; // Max 5 degrees
                    const rotateX = ((centerY - y) / centerY) * 5; // Max 5 degrees
                    
                    // Apply 3D transform to content
                    const content = this.querySelector('.card-content');
                    if (content) {
                        content.style.transform = `translateZ(20px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                    }
                }
                
                // Move the glow to follow cursor
                const glow = this.querySelector('.card-glow');
                if (glow) {
                    glow.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(76, 201, 240, 0.2), transparent 70%)`;
                    glow.style.opacity = '1';
                }
            });
            
            // Reset on mouse leave
            if (card.classList.contains('interactive-card')) {
                card.addEventListener('mouseleave', function() {
                    const content = this.querySelector('.card-content');
                    if (content) {
                        content.style.transform = 'translateZ(0) rotateX(0) rotateY(0)';
                    }
                    
                    const glow = this.querySelector('.card-glow');
                    if (glow) {
                        glow.style.opacity = '0';
                    }
                });
            }
        });
        
        // Add floating animation to logo
        const logo = document.querySelector('.glowing-logo');
        let floatY = 0;
        let floatDirection = 1;
        
        const animateLogo = () => {
            if (floatY > 10) floatDirection = -1;
            if (floatY < -10) floatDirection = 1;
            
            floatY += 0.2 * floatDirection;
            if (logo) {
                logo.style.transform = `translateY(${floatY}px)`;
            }
            
            requestAnimationFrame(animateLogo);
        };
        
        animateLogo();
        
        // Contact Modal Functionality
        const contactLink = document.getElementById('contactLink');
        const contactModal = document.getElementById('contactModal');
        const closeModal = document.getElementById('closeModal');
        
        if (contactLink && contactModal && closeModal) {
            contactLink.addEventListener('click', function(e) {
                e.preventDefault();
                contactModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            closeModal.addEventListener('click', function() {
                contactModal.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Close when clicking outside the modal
            contactModal.addEventListener('click', function(e) {
                if (e.target === contactModal) {
                    contactModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
            
            // Handle form submission
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show success message
                    const successMsg = document.createElement('div');
                    successMsg.className = 'alert alert-success mt-3';
                    successMsg.textContent = 'Your message has been sent successfully!';
                    
                    contactForm.appendChild(successMsg);
                    
                    // Reset form
                    contactForm.reset();
                    
                    // Close modal after delay
                    setTimeout(() => {
                        contactForm.removeChild(successMsg);
                        contactModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }, 2000);
                });
            }
        }
    });
    </script>

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
            
            // Initialize particles.js for hero section
            if (typeof particlesJS !== 'undefined') {
                particlesJS('particles-js', {
                    "particles": {
                        "number": {
                            "value": 50,
                            "density": {
                                "enable": true,
                                "value_area": 800
                            }
                        },
                        "color": {
                            "value": ["#4cc9f0", "#7209b7", "#4361ee", "#f72585"]
                        },
                        "shape": {
                            "type": "circle"
                        },
                        "opacity": {
                            "value": 0.5,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 1,
                                "opacity_min": 0.1,
                                "sync": false
                            }
                        },
                        "size": {
                            "value": 3,
                            "random": true,
                            "anim": {
                                "enable": true,
                                "speed": 2,
                                "size_min": 0.1,
                                "sync": false
                            }
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
                            "push": {
                                "particles_nb": 3
                            }
                        }
                    },
                    "retina_detect": true
                });
            }
            
            // Initialize stat counters
            const statCounters = document.querySelectorAll('.stat-value[data-counter]');
            statCounters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-counter'));
                let count = 0;
                const increment = target / 60; // Animate over 60 frames for smooth effect
                const interval = setInterval(() => {
                    count += increment;
                    if (count >= target) {
                        count = target;
                        clearInterval(interval);
                    }
                    counter.textContent = Math.floor(count);
                }, 30);
            });
            
            // Add mousemove parallax effect to hero visual
            const heroVisual = document.querySelector('.neo-hero-visual');
            if (heroVisual) {
                document.addEventListener('mousemove', (e) => {
                    const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
                    const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
                    
                    const mainVisual = document.querySelector('.main-visual');
                    if (mainVisual) {
                        mainVisual.style.transform = `translate(calc(-50% + ${moveX * 2}px), calc(-50% + ${moveY * 2}px))`;
                    }
                    
                    const floatElements = document.querySelectorAll('.float-element');
                    floatElements.forEach((element, index) => {
                        const factor = (index + 1) * 0.4;
                        element.style.transform = `translate(${moveX * factor}px, ${moveY * factor}px)`;
                    });
                });
            }
            
            // Smooth scroll from search section to hero section
            const scrollToHero = document.getElementById('scrollToHero');
            if (scrollToHero) {
                scrollToHero.addEventListener('click', function() {
                    const heroSection = document.getElementById('hero-section');
                    if (heroSection) {
                        heroSection.scrollIntoView({ 
                            behavior: 'smooth'
                        });
                    }
                });
                
                // Make the entire scroll-down-container clickable
                const scrollDownContainer = document.querySelector('.scroll-down-container');
                if (scrollDownContainer) {
                    scrollDownContainer.addEventListener('click', function() {
                        const heroSection = document.getElementById('hero-section');
                        if (heroSection) {
                            heroSection.scrollIntoView({ 
                                behavior: 'smooth' 
                            });
                        }
                    });
                }
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
                    const gradientPublication = ctx.getContext('2d').createLinearGradient(0, 0, 0, 600);
                    gradientPublication.addColorStop(0, 'rgba(67, 97, 238, 0.95)');
                    gradientPublication.addColorStop(0.5, 'rgba(67, 97, 238, 0.5)');
                    gradientPublication.addColorStop(1, 'rgba(67, 97, 238, 0.02)');
                    
                    const gradientCitation = ctx.getContext('2d').createLinearGradient(0, 0, 0, 600);
                    gradientCitation.addColorStop(0, 'rgba(114, 9, 183, 0.95)');
                    gradientCitation.addColorStop(0.5, 'rgba(114, 9, 183, 0.5)');
                    gradientCitation.addColorStop(1, 'rgba(114, 9, 183, 0.02)');
                    
                    const gradientFunding = ctx.getContext('2d').createLinearGradient(0, 0, 0, 600);
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

    <!-- Scroll snapping enhancement script -->
    <script>
        // Force scroll to top on page load/reload
        window.onload = function() {
            window.scrollTo(0, 0);
        }
        
        // Also use history API to prevent browser from restoring previous scroll position
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure we're at the top when DOM is ready
            window.scrollTo(0, 0);
            
            // Get all sections that should snap (using more specific selectors)
            const sections = document.querySelectorAll('.search-section, .neo-hero-section, .featured-projects, .research-impact, .faculty-spotlight, .events-section, #faq-section, #footer-section');
            const scrollDots = document.querySelectorAll('.scroll-dot');
            
            // Variables for controlled scrolling
            let isScrolling = false;
            let currentSectionIndex = 0;
            let scrollTimeout;
            const scrollDelay = 800; // Debounce delay in ms
            
            // Initialize by setting first section as active
            updateActiveSection(0);
            
            // Add a flag to allow free scrolling
            let allowFreeScroll = false;
            
            // Add an improved "Go to Footer" button
            const footerButton = document.createElement('div');
            footerButton.classList.add('scroll-to-footer');
            footerButton.innerHTML = '<span>Footer</span><i class="bi bi-arrow-down-circle-fill"></i>';
            footerButton.title = "Go to Footer";
            footerButton.style.position = 'fixed';
            footerButton.style.bottom = '20px';
            footerButton.style.right = '20px';
            footerButton.style.backgroundColor = 'rgba(76, 201, 240, 0.3)';
            footerButton.style.color = '#fff';
            footerButton.style.padding = '8px 16px';
            footerButton.style.borderRadius = '50px';
            footerButton.style.display = 'flex';
            footerButton.style.alignItems = 'center';
            footerButton.style.justifyContent = 'center';
            footerButton.style.gap = '8px';
            footerButton.style.cursor = 'pointer';
            footerButton.style.zIndex = '1000';
            footerButton.style.transition = 'all 0.3s ease';
            footerButton.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.3)';
            footerButton.style.border = '1px solid rgba(76, 201, 240, 0.5)';
            footerButton.style.backdropFilter = 'blur(5px)';
            footerButton.style.fontSize = '14px';
            footerButton.style.fontWeight = '600';
            
            // Style for the text and icon
            const spanStyle = document.createElement('style');
            spanStyle.textContent = `
                .scroll-to-footer span {
                    transition: all 0.3s ease;
                }
                .scroll-to-footer i {
                    font-size: 18px;
                    transition: all 0.3s ease;
                }
            `;
            document.head.appendChild(spanStyle);
            
            footerButton.addEventListener('mouseover', function() {
                this.style.backgroundColor = 'rgba(76, 201, 240, 0.5)';
                this.style.transform = 'scale(1.05) translateY(-2px)';
                this.style.boxShadow = '0 6px 20px rgba(76, 201, 240, 0.3)';
            });
            
            footerButton.addEventListener('mouseout', function() {
                this.style.backgroundColor = 'rgba(76, 201, 240, 0.3)';
                this.style.transform = 'scale(1) translateY(0)';
                this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.3)';
            });
            
            footerButton.addEventListener('click', function() {
                // Enable free scrolling
                allowFreeScroll = true;
                
                // Scroll to footer using the id to ensure proper targeting
                const footer = document.getElementById('footer-section');
                if (footer) {
                    console.log("Scrolling to footer section");
                    footer.scrollIntoView({ behavior: 'smooth' });
                    
                    // Update active section
                    updateActiveSection(sections.length - 1);
                    
                    // Update the dot navigation
                    scrollDots.forEach(dot => {
                        dot.classList.remove('active');
                        if (dot.getAttribute('data-index') === (sections.length - 1).toString()) {
                            dot.classList.add('active');
                        }
                    });
                } else {
                    console.error("Footer section not found");
                }
            });
            
            document.body.appendChild(footerButton);
            
            // Control mouse wheel scrolling
            window.addEventListener('wheel', function(e) {
                // If free scroll is enabled, allow normal scrolling
                if (allowFreeScroll || currentSectionIndex === sections.length - 1) {
                    return; // Allow default scroll behavior
                }
                
                e.preventDefault(); // Prevent default scroll
                
                if (!isScrolling) {
                    isScrolling = true;
                    
                    // Determine scroll direction
                    const direction = e.deltaY > 0 ? 1 : -1;
                    
                    // Calculate next section index
                    let nextIndex = currentSectionIndex + direction;
                    
                    // Ensure index is within bounds
                    if (nextIndex >= 0 && nextIndex < sections.length) {
                        scrollToSection(nextIndex);
                        
                        // If we reach the last section, enable free scrolling
                        if (nextIndex === sections.length - 1) {
                            allowFreeScroll = true;
                        }
                    } else {
                        // Reset scrolling state if at bounds
                        isScrolling = false;
                    }
                    
                    // Debounce to prevent rapid scrolling
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        isScrolling = false;
                    }, scrollDelay);
                }
            }, { passive: false }); // passive: false is required to use preventDefault
            
            // Function to scroll to a specific section
            function scrollToSection(index) {
                // Hide scroll indicators while scrolling
                document.querySelectorAll('.scroll-down-container').forEach(indicator => {
                    indicator.style.opacity = '0';
                });
                
                // Perform scroll
                sections[index].scrollIntoView({ behavior: 'smooth' });
                
                // Update active section
                updateActiveSection(index);
                
                // Show scroll indicators after scrolling completes
                setTimeout(() => {
                    document.querySelectorAll('.scroll-down-container').forEach(indicator => {
                        indicator.style.opacity = '1';
                    });
                }, scrollDelay);
            }
            
            // Function to update active section with improved feedback
            function updateActiveSection(index) {
                console.log(`Updating active section to index: ${index}`);
                
                currentSectionIndex = index;
                
                // Update section classes
                sections.forEach((section, i) => {
                    section.classList.remove('active-section');
                    if (i === index) {
                        console.log(`Setting active section: ${section.id || section.className}`);
                    }
                });
                sections[currentSectionIndex].classList.add('active-section');
                
                // Update navigation dots using data-index attribute
                scrollDots.forEach((dot) => {
                    dot.classList.remove('active');
                    const dotIndex = parseInt(dot.getAttribute('data-index'));
                    if (dotIndex === currentSectionIndex) {
                        dot.classList.add('active');
                        console.log(`Activated dot for section: ${dot.getAttribute('data-section')}`);
                    }
                });
                
                // Special handling for footer
                if (index === sections.length - 1) {
                    allowFreeScroll = true;
                    console.log("Footer section activated - free scrolling enabled");
                }
            }
            
            // Add click functionality to scroll dots with improved targeting
            scrollDots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    if (!isScrolling) {
                        // Use the data-index attribute to get the correct section index
                        const targetIndex = parseInt(dot.getAttribute('data-index'));
                        
                        if (targetIndex >= 0 && targetIndex < sections.length) {
                            isScrolling = true;
                            
                            // Scroll to the target section
                            scrollToSection(targetIndex);
                            
                            // Reset scrolling state after animation
                            setTimeout(() => {
                                isScrolling = false;
                            }, scrollDelay);
                            
                            // If clicking on the last dot (footer), enable free scrolling
                            if (targetIndex === sections.length - 1) {
                                allowFreeScroll = true;
                                console.log("Enabling free scroll for footer");
                            } else {
                                allowFreeScroll = false;
                            }
                        }
                    }
                });
            });
            
            // Enhance scroll down button functionality
            document.querySelectorAll('.scroll-down-arrow').forEach(arrow => {
                arrow.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!isScrolling && currentSectionIndex < sections.length - 1) {
                        isScrolling = true;
                        scrollToSection(currentSectionIndex + 1);
                        
                        // Reset scrolling state after animation
                        setTimeout(() => {
                            isScrolling = false;
                        }, scrollDelay);
                        
                        // If scrolling to the last section (footer), enable free scrolling
                        if (currentSectionIndex + 1 === sections.length - 1) {
                            allowFreeScroll = true;
                        }
                    }
                });
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                // Allow normal keyboard navigation if free scrolling is enabled
                if (isScrolling || allowFreeScroll) return;
                
                let nextIndex = currentSectionIndex;
                
                // Down arrow or Page Down
                if (e.key === 'ArrowDown' || e.key === 'PageDown') {
                    e.preventDefault();
                    nextIndex = currentSectionIndex + 1;
                }
                
                // Up arrow or Page Up
                if (e.key === 'ArrowUp' || e.key === 'PageUp') {
                    e.preventDefault();
                    nextIndex = currentSectionIndex - 1;
                }
                
                // Ensure index is within bounds and scroll if valid
                if (nextIndex >= 0 && nextIndex < sections.length && nextIndex !== currentSectionIndex) {
                    isScrolling = true;
                    scrollToSection(nextIndex);
                    
                    // Reset scrolling state after animation
                    setTimeout(() => {
                        isScrolling = false;
                    }, scrollDelay);
                    
                    // If we reach the last section, enable free scrolling
                    if (nextIndex === sections.length - 1) {
                        allowFreeScroll = true;
                    }
                }
            });
            
            // Handle touch events for mobile
            let touchStartY = 0;
            let touchEndY = 0;
            const touchThreshold = 50; // Minimum swipe distance
            
            document.addEventListener('touchstart', (e) => {
                // Allow normal touch behavior if free scrolling is enabled
                if (allowFreeScroll || currentSectionIndex === sections.length - 1) {
                    return;
                }
                
                touchStartY = e.changedTouches[0].screenY;
            }, { passive: true });
            
            document.addEventListener('touchend', (e) => {
                // Allow normal touch behavior if free scrolling is enabled
                if (allowFreeScroll || currentSectionIndex === sections.length - 1) {
                    return;
                }
                
                touchEndY = e.changedTouches[0].screenY;
                const touchDiff = touchStartY - touchEndY;
                
                // If the swipe is significant enough
                if (Math.abs(touchDiff) > touchThreshold && !isScrolling) {
                    isScrolling = true;
                    
                    // Determine swipe direction
                    const direction = touchDiff > 0 ? 1 : -1;
                    
                    // Calculate next section index
                    let nextIndex = currentSectionIndex + direction;
                    
                    // Ensure index is within bounds and scroll if valid
                    if (nextIndex >= 0 && nextIndex < sections.length) {
                        scrollToSection(nextIndex);
                        
                        // If we reach the last section, enable free scrolling
                        if (nextIndex === sections.length - 1) {
                            allowFreeScroll = true;
                        }
                    }
                    
                    // Reset scrolling state after animation
                    setTimeout(() => {
                        isScrolling = false;
                    }, scrollDelay);
                }
            }, { passive: true });
            
            // Add a direct way to test footer scrolling - will be useful for debugging
            window.scrollToFooter = function() {
                console.log("Direct footer navigation triggered");
                const footer = document.getElementById('footer-section');
                if (footer) {
                    allowFreeScroll = true;
                    footer.scrollIntoView({ behavior: 'smooth' });
                    updateActiveSection(sections.length - 1);
                    console.log("Footer scrolling complete");
                } else {
                    console.error("Footer section not found for direct navigation");
                }
            };
            
            // Add keyboard shortcut (F key) to jump to footer for testing
            document.addEventListener('keydown', (e) => {
                if (e.key === 'f' || e.key === 'F') {
                    window.scrollToFooter();
                }
            });
        });
    </script>

    <!-- Ensure the badge is clickable -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const badgeLink = document.querySelector('.neo-badge-link');
            if (badgeLink) {
                badgeLink.addEventListener('click', function(e) {
                    window.location.href = 'Faculty_Page.php';
                });
            }
        });
    </script>

    <!-- Theme Initialization Script -->
    <script>
        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check for saved theme preference or default to 'dark'
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            
            // Add theme transition class to body for smooth transitions
            document.body.classList.add('theme-transition');
            
            // Update any text elements that need theme-specific styling
            updateThemeSpecificElements(savedTheme);
        });
        
        // Function to update theme-specific elements
        function updateThemeSpecificElements(theme) {
            // Update any hardcoded text colors that need to change with theme
            const textElements = document.querySelectorAll('.text-light, .text-muted');
            textElements.forEach(element => {
                if (theme === 'light') {
                    element.style.color = 'var(--text-primary)';
                } else {
                    element.style.color = ''; // Reset to default
                }
            });
            
            // Update search section text colors
            const searchTitle = document.querySelector('.search-header h1');
            const searchSubtitle = document.querySelector('.search-header p');
            
            if (searchTitle) {
                searchTitle.style.color = 'var(--text-primary)';
            }
            if (searchSubtitle) {
                searchSubtitle.style.color = 'var(--text-secondary)';
            }
            
            // Update scroll down text
            const scrollText = document.querySelector('.scroll-down-text');
            const scrollArrow = document.querySelector('.scroll-down-arrow');
            
            if (scrollText) {
                scrollText.style.color = 'var(--text-secondary)';
            }
            if (scrollArrow) {
                scrollArrow.style.color = 'var(--text-primary)';
            }
        }
        
        // Listen for theme changes from navbar toggle
        document.addEventListener('themeChanged', function(e) {
            updateThemeSpecificElements(e.detail.theme);
            updateChartColors(e.detail.theme);
        });
        
        // Function to update Chart.js colors based on theme
        function updateChartColors(theme) {
            if (typeof Chart !== 'undefined' && window.researchChart) {
                const isLight = theme === 'light';
                const textColor = isLight ? '#1e293b' : '#ffffff';
                const gridColor = isLight ? 'rgba(67, 97, 238, 0.1)' : 'rgba(255, 255, 255, 0.1)';
                
                // Update chart options
                if (window.researchChart.options.scales.x) {
                    window.researchChart.options.scales.x.ticks.color = textColor;
                    window.researchChart.options.scales.x.grid.color = gridColor;
                }
                if (window.researchChart.options.scales.y) {
                    window.researchChart.options.scales.y.ticks.color = textColor;
                    window.researchChart.options.scales.y.grid.color = gridColor;
                }
                if (window.researchChart.options.plugins && window.researchChart.options.plugins.legend) {
                    window.researchChart.options.plugins.legend.labels.color = textColor;
                }
                
                // Update the chart
                window.researchChart.update();
            }
            
            // Also try to update any other charts that might exist
            if (typeof Chart !== 'undefined') {
                Chart.helpers.each(Chart.instances, function(instance) {
                    const isLight = theme === 'light';
                    const textColor = isLight ? '#1e293b' : '#ffffff';
                    const gridColor = isLight ? 'rgba(67, 97, 238, 0.1)' : 'rgba(255, 255, 255, 0.1)';
                    
                    if (instance.options.scales) {
                        Object.keys(instance.options.scales).forEach(scaleKey => {
                            if (instance.options.scales[scaleKey].ticks) {
                                instance.options.scales[scaleKey].ticks.color = textColor;
                            }
                            if (instance.options.scales[scaleKey].grid) {
                                instance.options.scales[scaleKey].grid.color = gridColor;
                            }
                        });
                    }
                    
                    if (instance.options.plugins && instance.options.plugins.legend) {
                        instance.options.plugins.legend.labels.color = textColor;
                    }
                    
                    instance.update();
                });
            }
        }
        
        // Call updateChartColors when charts are loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for charts to be initialized and then update colors
            setTimeout(() => {
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                updateChartColors(currentTheme);
            }, 2000);
        });
    </script>
</body>
</html>