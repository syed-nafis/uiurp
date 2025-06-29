<?php
session_start();

// Get search parameter from URL if it exists
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="stylesheet" href="assets/styles/theme.css">
    <!-- Performance optimization styles -->
    <link rel="stylesheet" href="assets/styles/performance.css">
    
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
    
    <!-- Performance optimization script - Load early for immediate optimizations -->
    <script src="assets/js/performance-optimizer.js" defer></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');
        
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --light-color: #f8fafc;
            --dark-color: #0f172a;
            --success-color: #06b6d4;
            --warning-color: #f59e0b;
            --modern-blue: #0ea5e9;
            --modern-purple: #8b5cf6;
            --modern-teal: #14b8a6;
            --modern-gray: #6b7280;
            --card-bg: rgba(15, 23, 42, 0.6);
            --glass-bg: rgba(22, 28, 45, 0.7);
            --border-glow: rgba(37, 99, 235, 0.5);
            --surface-1: rgba(30, 41, 59, 0.6);
            --surface-2: rgba(15, 23, 42, 0.8);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --text-muted: rgba(255, 255, 255, 0.5);
        }
        
        * {
            box-sizing: border-box;
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
        
        /* Hero Section with Dynamic Background */
        .hero-section {
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
        
        .hero-section::before {
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
        
        .hero-section::after {
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
        
        /* Dynamic Background Layers */
        .hero-dynamic-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        
        .bg-layer-1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120%;
            background: radial-gradient(circle at 20% 30%, 
                rgba(37, 99, 235, 0.15) 0%, 
                transparent 50%);
            transform-origin: center bottom;
            transition: transform 0.3s ease-out;
        }
        
        .bg-layer-2 {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 110%;
            background: radial-gradient(circle at 80% 40%, 
                rgba(14, 165, 233, 0.12) 0%, 
                transparent 60%);
            transform-origin: center bottom;
            transition: transform 0.3s ease-out;
        }
        
        .bg-layer-3 {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150%;
            height: 200px;
            background: linear-gradient(to top,
                rgba(37, 99, 235, 0.2) 0%,
                rgba(14, 165, 233, 0.1) 30%,
                transparent 70%);
            border-radius: 50%;
            filter: blur(30px);
            transform-origin: center bottom;
            transition: all 0.3s ease-out;
        }
        
        /* Scroll-based shape modifications */
        .hero-section.scrolled-small {
            clip-path: ellipse(90% 85% at 50% 0%);
        }
        
        .hero-section.scrolled-small::after {
            width: 100%;
            height: 120px;
            bottom: -30px;
        }
        
        .hero-section.scrolled-small .bg-layer-1 {
            transform: scale(0.9) translateY(10px);
        }
        
        .hero-section.scrolled-small .bg-layer-2 {
            transform: scale(0.85) translateY(15px);
        }
        
        .hero-section.scrolled-small .bg-layer-3 {
            transform: translateX(-50%) scale(0.8) translateY(20px);
            height: 150px;
        }
        
        .hero-section.scrolled-medium {
            clip-path: ellipse(85% 75% at 50% 0%);
        }
        
        .hero-section.scrolled-medium::after {
            width: 90%;
            height: 100px;
            bottom: -20px;
        }
        
        .hero-section.scrolled-medium .bg-layer-1 {
            transform: scale(0.8) translateY(20px);
        }
        
        .hero-section.scrolled-medium .bg-layer-2 {
            transform: scale(0.75) translateY(25px);
        }
        
        .hero-section.scrolled-medium .bg-layer-3 {
            transform: translateX(-50%) scale(0.7) translateY(30px);
            height: 120px;
        }
        
        .hero-section.scrolled-large {
            clip-path: ellipse(80% 65% at 50% 0%);
        }
        
        .hero-section.scrolled-large::after {
            width: 80%;
            height: 80px;
            bottom: -10px;
        }
        
        .hero-section.scrolled-large .bg-layer-1 {
            transform: scale(0.7) translateY(30px);
        }
        
        .hero-section.scrolled-large .bg-layer-2 {
            transform: scale(0.65) translateY(35px);
        }
        
        .hero-section.scrolled-large .bg-layer-3 {
            transform: translateX(-50%) scale(0.6) translateY(40px);
            height: 100px;
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
        }
        
        .hero-title {
            font-size: clamp(2.2rem, 6vw, 3.8rem);
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff 0%, var(--modern-blue) 70%);
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
            background: linear-gradient(90deg, var(--modern-blue), var(--modern-teal));
            border-radius: 2px;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.6);
            animation: glow-pulse 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow-pulse {
            from { box-shadow: 0 0 15px rgba(37, 99, 235, 0.6); }
            to { box-shadow: 0 0 25px rgba(20, 184, 166, 0.6); }
        }
        
        /* Hero Action Buttons - Smaller */
        .hero-actions .btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            padding: 12px 24px;
        }
        
        .hero-actions .btn:hover {
            transform: translateY(-2px);
        }
        
        .hero-actions .btn-primary:hover {
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }
        
        .hero-actions .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        /* Ultra Compact Search Container */
        .compact-search-container {
            max-width: 500px;
            margin: 0 auto;
        }
        
        .search-box-compact {
            background: transparent;
            border: 1px solid rgba(37, 99, 235, 0.3);
            border-radius: 40px;
            padding: 8px 8px 8px 20px;
            backdrop-filter: none;
            transition: all 0.3s ease;
            box-shadow: none;
        }
        
        .search-box-compact:hover,
        .search-box-compact:focus-within {
            border-color: var(--modern-blue);
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
            transform: translateY(-1px);
        }
        
        .search-icon-compact {
            color: var(--text-muted);
            margin-right: 15px;
            font-size: 1rem;
        }
        
        .search-input-compact {
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-size: 1rem;
            width: 100%;
            padding: 12px 0;
            outline: none;
        }
        
        .search-input-compact::placeholder {
            color: var(--text-muted);
        }
        
        .search-input-compact:focus {
            color: var(--modern-blue);
        }
        
        .search-btn-compact {
            background: linear-gradient(135deg, var(--modern-blue), var(--modern-teal));
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: white;
            margin-left: 10px;
            font-size: 0.9rem;
        }
        
        .search-btn-compact:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }
        
        .toggle-btn-compact {
            background: transparent;
            border: 1px solid rgba(37, 99, 235, 0.3);
            border-radius: 25px;
            padding: 10px 20px;
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .toggle-btn-compact:hover {
            border-color: var(--modern-blue);
            color: var(--modern-blue);
            background: rgba(37, 99, 235, 0.05);
            transform: translateY(-2px);
        }
        
        /* Research Stats - More Compact */
        .research-stats {
            margin-top: 2.5rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1.2rem 0.8rem;
            background: rgba(15, 23, 42, 0.4);
            border-radius: 12px;
            border: 1px solid rgba(37, 99, 235, 0.15);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stat-item:hover {
            transform: translateY(-3px);
            border-color: var(--modern-blue);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--modern-blue), var(--modern-teal));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.3rem;
            line-height: 1;
        }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Enhanced Search Box - Reduced Prominence */
        .search-container {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.6) 0%, 
                rgba(30, 41, 59, 0.7) 100%);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            border: 1px solid rgba(37, 99, 235, 0.2);
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.2),
                0 0 20px rgba(37, 99, 235, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.8s ease;
        }
        
        .search-container:hover::before {
            left: 100%;
        }
        
        .search-box {
            background: rgba(15, 23, 42, 0.6);
            border: 2px solid rgba(37, 99, 235, 0.3);
            border-radius: 60px;
            padding: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .search-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, 
                transparent 30%, 
                rgba(37, 99, 235, 0.1) 50%, 
                transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .search-box:focus-within {
            border-color: var(--modern-blue);
            box-shadow: 
                0 0 30px rgba(37, 99, 235, 0.4),
                0 0 60px rgba(37, 99, 235, 0.2);
            transform: translateY(-2px);
        }
        
        .search-box:focus-within::before {
            opacity: 1;
        }
        
        .search-input {
            background: transparent;
            border: none;
            color: var(--text-primary);
            padding: 20px 30px;
            font-size: 1.1rem;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .search-input::placeholder {
            color: var(--text-muted);
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            color: var(--modern-blue);
        }
        
        .search-input:focus::placeholder {
            color: transparent;
        }
        
        .search-btn {
            background: linear-gradient(135deg, var(--modern-blue) 0%, var(--modern-purple) 100%);
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }
        
        .search-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3), transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .search-btn:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 
                0 15px 35px rgba(37, 99, 235, 0.6),
                0 0 30px rgba(139, 92, 246, 0.4);
        }
        
        .search-btn:hover::before {
            opacity: 1;
        }
        
        .search-btn:active {
            transform: scale(0.95);
        }
        
        /* Enhanced Toggle Button */
        .toggle-btn {
            background: linear-gradient(135deg, 
                rgba(30, 41, 59, 0.8) 0%, 
                rgba(15, 23, 42, 0.9) 100%);
            border: 2px solid rgba(37, 99, 235, 0.3);
            border-radius: 50px;
            padding: 15px 35px;
            color: var(--text-primary);
            font-weight: 600;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        
        .toggle-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(37, 99, 235, 0.3), 
                transparent);
            transition: left 0.6s ease;
        }
        
        .toggle-btn:hover {
            border-color: var(--modern-blue);
            color: var(--modern-blue);
            transform: translateY(-3px);
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.3),
                0 0 25px rgba(37, 99, 235, 0.4);
        }
        
        .toggle-btn:hover::before {
            left: 100%;
        }
        
        .toggle-btn i {
            transition: all 0.3s ease;
        }
        
        .toggle-btn:hover i {
            transform: rotate(180deg);
        }
        
        /* Enhanced Project Cards */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
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
            border-color: var(--modern-blue);
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
            background: linear-gradient(135deg, var(--modern-blue) 0%, var(--modern-purple) 100%);
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
            background: linear-gradient(135deg, var(--modern-teal) 0%, var(--warning-color) 100%);
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
            background: linear-gradient(90deg, var(--modern-blue), var(--modern-purple));
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }
        
        .project-card:hover .card-title {
            color: var(--modern-blue);
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
            border-left: 3px solid var(--modern-blue);
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
            border-left-color: var(--modern-teal);
        }
        
        .project-card:hover .meta-item::before {
            left: 100%;
        }
        
        .meta-icon {
            color: var(--modern-blue);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .project-card:hover .meta-icon {
            color: var(--modern-teal);
            transform: scale(1.2);
        }
        
        /* Enhanced Loading Animation */
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4rem 0;
        }
        
        .loading-spinner {
            position: relative;
            width: 80px;
            height: 80px;
        }
        
        .spinner-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid transparent;
            border-top-color: var(--modern-blue);
            animation: spin 1.5s linear infinite;
        }
        
        .spinner-ring:nth-child(2) {
            width: 90%;
            height: 90%;
            top: 5%;
            left: 5%;
            border-top-color: var(--modern-purple);
            animation-delay: 0.3s;
            animation-duration: 1.8s;
        }
        
        .spinner-ring:nth-child(3) {
            width: 80%;
            height: 80%;
            top: 10%;
            left: 10%;
            border-top-color: var(--modern-teal);
            animation-delay: 0.6s;
            animation-duration: 2.1s;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Skeleton Loading */
        .skeleton-card {
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.8) 0%, 
                rgba(30, 41, 59, 0.6) 100%);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .skeleton-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(37, 99, 235, 0.1), 
                transparent);
            animation: skeleton-loading 2s infinite;
        }
        
        @keyframes skeleton-loading {
            to { left: 100%; }
        }
        
        .skeleton-item {
            background: rgba(37, 99, 235, 0.1);
            border-radius: 8px;
            margin-bottom: 1rem;
            animation: skeleton-pulse 2s ease-in-out infinite;
        }
        
        .skeleton-title { height: 24px; width: 80%; }
        .skeleton-text { height: 16px; width: 100%; }
        .skeleton-text.short { width: 60%; }
        
        @keyframes skeleton-pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        
        /* No Results Animation */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.8) 0%, 
                rgba(30, 41, 59, 0.6) 100%);
            border-radius: 20px;
            border: 1px solid rgba(37, 99, 235, 0.2);
        }
        
        .no-results-icon {
            font-size: 4rem;
            color: var(--modern-blue);
            margin-bottom: 2rem;
            animation: float-icon 3s ease-in-out infinite;
        }
        
        @keyframes float-icon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .no-results-text {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 0;
        }
        
        /* Fade in animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Enhanced Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
            border-radius: 6px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--modern-blue), var(--modern-purple));
            border-radius: 6px;
            border: 2px solid rgba(15, 23, 42, 0.5);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--modern-teal), var(--warning-color));
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-section {
                min-height: 60vh;
                padding: 50px 0 80px;
            }
            
            .hero-section::after {
                width: 110%;
                height: 120px;
                bottom: -40px;
            }
            
            .bg-layer-3 {
                width: 130%;
                height: 150px;
            }
            
            .hero-title {
                font-size: clamp(1.8rem, 5vw, 3rem);
                margin-bottom: 1rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem !important;
                margin-bottom: 2.5rem !important;
            }
            
            .projects-grid {
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1.5rem;
            }
            
            .search-container {
                padding: 2rem 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero-section {
                min-height: 55vh;
                padding: 40px 0 60px;
                clip-path: ellipse(100% 90% at 50% 0%);
            }
            
            .hero-section::after {
            width: 100%;
                height: 100px;
                bottom: -30px;
            }
            
            .bg-layer-1, .bg-layer-2 {
                height: 100%;
            }
            
            .bg-layer-3 {
                width: 120%;
                height: 120px;
            }
            
            .hero-section.scrolled-small {
                clip-path: ellipse(95% 80% at 50% 0%);
            }
            
            .hero-section.scrolled-medium {
                clip-path: ellipse(90% 70% at 50% 0%);
            }
            
            .hero-section.scrolled-large {
                clip-path: ellipse(85% 60% at 50% 0%);
            }
            
            .hero-title {
                font-size: clamp(1.6rem, 4vw, 2.5rem);
                margin-bottom: 0.8rem;
            }
            
            .hero-subtitle {
                font-size: 1rem !important;
                line-height: 1.4 !important;
                margin-bottom: 2rem !important;
            }
            
            .projects-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .project-card {
                margin: 0 auto;
                max-width: 400px;
            }
            
            .search-input-compact {
                padding: 10px 0;
                font-size: 0.9rem;
            }
            
            .search-btn-compact {
                width: 35px;
                height: 35px;
                font-size: 0.8rem;
            }
            
            .compact-search-container {
                max-width: 100%;
                padding: 0 10px;
            }
            
            .search-box-compact {
                padding: 6px 6px 6px 16px;
            }
            
            .toggle-btn-compact {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
            
            .search-icon-compact {
                margin-right: 12px;
            font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero-section {
                min-height: 50vh;
                padding: 30px 0 50px;
                clip-path: ellipse(100% 85% at 50% 0%);
            }
            
            .hero-section::after {
                width: 90%;
                height: 80px;
                bottom: -20px;
            }
            
            .bg-layer-3 {
                width: 110%;
                height: 100px;
            }
            
            .hero-section.scrolled-small {
                clip-path: ellipse(95% 75% at 50% 0%);
            }
            
            .hero-section.scrolled-medium {
                clip-path: ellipse(90% 65% at 50% 0%);
            }
            
            .hero-section.scrolled-large {
                clip-path: ellipse(85% 55% at 50% 0%);
            }
            
            .hero-title {
                font-size: clamp(1.4rem, 4vw, 2rem);
            }
            
            .hero-subtitle {
                font-size: 0.9rem !important;
                margin-bottom: 1.5rem !important;
            }
            
            .search-box-compact {
                padding: 5px 5px 5px 14px;
            }
            
            .search-input-compact {
                font-size: 0.85rem;
                padding: 8px 0;
            }
            
            .search-btn-compact {
                width: 30px;
                height: 30px;
                font-size: 0.75rem;
            }
            
            .toggle-btn-compact {
                padding: 6px 14px;
            font-size: 0.8rem;
            }
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
                var(--modern-blue), 
                var(--modern-purple), 
                var(--modern-teal), 
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
            background: linear-gradient(135deg, var(--text-primary), var(--modern-blue));
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
            background: linear-gradient(90deg, var(--modern-blue), var(--modern-purple));
            transition: width 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--modern-blue);
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
            background: var(--modern-blue);
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
            background: var(--modern-blue);
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
        
        /* Utility Classes */
        .text-glow {
            text-shadow: 0 0 10px currentColor;
        }
        
        .hover-lift {
            transition: transform 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
        }
        
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modern-border {
            border: 1px solid var(--modern-blue);
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.3);
        }
        
        /* Click Ripple Effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }
        
        .ripple::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .ripple:active::before {
                width: 300px;
                height: 300px;
        }
    </style>
</head>
<body class="research-page">
  <?php include 'src/includes/navbar.php'; ?>

    <!-- Enhanced Background Effects -->
    <div class="background-effects">
        <div class="cyber-grid"></div>
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>
    
    <!-- Enhanced Particles -->
  <div id="particles-js"></div>
  
    <!-- Hero Section -->
    <section class="hero-section" id="hero-section">
        <!-- Dynamic Background Layers -->
        <div class="hero-dynamic-bg">
            <div class="bg-layer-1"></div>
            <div class="bg-layer-2"></div>
            <div class="bg-layer-3"></div>
    </div>
    
        <div class="container hero-content">
      <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="hero-title" data-aos="fade-down" data-aos-duration="1000">
                        Discover Innovative Research
                    </h1>
                    <p class="hero-subtitle mb-5" data-aos="fade-up" data-aos-delay="200" style="font-size: 1.3rem; color: var(--text-secondary); max-width: 700px; margin: 0 auto 3rem; line-height: 1.6;">
                        Explore groundbreaking research projects from brilliant minds around the world
                    </p>
                    
                    <!-- Compact Search Bar -->
                    <div class="compact-search-container" data-aos="fade-up" data-aos-delay="300">
                        <div class="search-box-compact">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-search search-icon-compact"></i>
                                <input type="text" class="search-input-compact" placeholder="Search projects, keywords, or authors..." id="search-bar" autocomplete="off" value="<?php echo htmlspecialchars($searchQuery, ENT_QUOTES, 'UTF-8'); ?>">
                                <button class="search-btn-compact" id="search-bttn">
                                    <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </div>
                        
                        <div class="text-center mt-3">
                            <button class="toggle-btn-compact" id="toggle-projects">
          <i class="fas fa-filter me-2"></i>Show All Projects
        </button>
      </div>
    </div>
  </div>
    </div>
    </div>
  </section>

    <!-- Projects Section -->
    <section class="container my-5">
        <!-- Loading Animation -->
        <div class="loading-container" id="loader" style="display: none;">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
    </div>
            </div>
            
        <!-- Projects Grid -->
        <div class="projects-grid" id="projectsList">
            <!-- Projects will be dynamically loaded here -->
                    </div>
    </section>

    <?php include 'src/includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
  <script>
  document.addEventListener('DOMContentLoaded', function() {
        // Initialize theme FIRST before other components
        initializeTheme();
        
        // Initialize enhanced particles
        initializeEnhancedParticles();
        
        // Initialize enhanced AOS
        initializeEnhancedAOS();
        
        // Initialize scroll animations
        initializeScrollAnimations();
        
        // Initialize enhanced search functionality
        initializeEnhancedSearch();
        
        // Initialize ripple effects
        initializeRippleEffects();
        
        // Initialize performance optimizations
        initializePerformanceOptimizations();
    });

    function initializeEnhancedParticles() {
        // Get current theme
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        
        // Theme-specific particle configurations
        const particleConfig = {
            dark: {
                colors: ["#2563eb", "#0ea5e9", "#06b6d4", "#3b82f6"],
                strokeColor: "rgba(37, 99, 235, 0.3)",
                lineColor: "#2563eb",
                opacity: 0.3,
                lineOpacity: 0.2
            },
            light: {
                colors: ["#1e40af", "#0369a1", "#0891b2", "#1d4ed8"],
                strokeColor: "rgba(30, 64, 175, 0.2)",
                lineColor: "#1e40af",
                opacity: 0.15,
                lineOpacity: 0.1
            }
        };
        
        const config = particleConfig[currentTheme];
        
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
                    "value": config.colors
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 1,
                        "color": config.strokeColor
                    }
                },
                "opacity": {
                    "value": config.opacity,
                    "random": true,
                    "anim": {
                        "enable": true,
                        "speed": 1,
                        "opacity_min": config.opacity * 0.3,
                        "sync": false
                    }
                },
                "size": {
                    "value": 4,
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
                    "distance": 150,
                    "color": config.lineColor,
                    "opacity": config.lineOpacity,
                    "width": 1.5,
                    "shadow": {
                        "enable": true,
                        "color": config.lineColor,
                        "blur": 5
                    }
                },
                "move": {
                    "enable": true,
                    "speed": 1.5,
                    "direction": "none",
                    "random": true,
                    "straight": false,
                    "out_mode": "bounce",
                    "bounce": true,
                    "attract": {
                        "enable": true,
                        "rotateX": 300,
                        "rotateY": 600
                    }
                }
            },
            "interactivity": {
                "detect_on": "window",
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
                        "distance": 200,
                        "line_linked": {
                            "opacity": config.lineOpacity * 3
                        }
                    },
                    "bubble": {
                        "distance": 250,
                        "size": 8,
                        "duration": 2,
                        "opacity": config.opacity * 2,
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
    }

    function initializeEnhancedAOS() {
        // Use performance optimizer for AOS if available
        if (window.performanceOptimizer) {
            window.performanceOptimizer.optimizeAOS();
        } else {
            // Fallback optimized AOS configuration
            const isMobile = window.innerWidth <= 768;
            
      AOS.init({
                duration: isMobile ? 300 : 600,
                once: true, // Only animate once for better performance
                mirror: false, // Disable mirror for better performance
            offset: 50,
                easing: 'ease-out',
            anchorPlacement: 'top-bottom',
                disable: isMobile ? 'mobile' : false,
            debounceDelay: 50,
                throttleDelay: 100
            });
        }
    }

    function initializeScrollAnimations() {
        // Initialize hero background scroll effects
        initializeHeroScrollEffects();
        
        // Intersection Observer for fade-in-up animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in-up elements
        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });

        // Use performance optimizer for parallax if available
        if (window.performanceOptimizer) {
            window.performanceOptimizer.addScrollListener('parallax', (scrollY) => {
                // Only update parallax on desktop for performance
                if (window.innerWidth > 768) {
                    document.querySelectorAll('.floating-orb').forEach((orb, index) => {
                        const speed = 0.3 + (index * 0.1);
                        orb.style.transform = `translateY(${scrollY * speed}px)`;
                    });
                }
            });
        } else {
            // Fallback parallax with throttling
        let parallaxTicking = false;
        
        function updateParallax() {
                if (window.innerWidth > 768) { // Only on desktop
            const scrolled = window.pageYOffset;
            
            document.querySelectorAll('.floating-orb').forEach((orb, index) => {
                const speed = 0.3 + (index * 0.1);
                orb.style.transform = `translateY(${scrolled * speed}px)`;
            });
                }
            parallaxTicking = false;
        }

        window.addEventListener('scroll', function() {
            if (!parallaxTicking) {
                requestAnimationFrame(updateParallax);
                parallaxTicking = true;
            }
        }, { passive: true });
        }
    }

    function initializeHeroScrollEffects() {
        const heroSection = document.getElementById('hero-section');
        if (!heroSection) return;

        function updateHeroBackground(scrollY) {
            const heroHeight = heroSection.offsetHeight;
            const scrollProgress = Math.min(scrollY / (heroHeight * 0.8), 1);

            // Remove existing scroll classes
            heroSection.classList.remove('scrolled-small', 'scrolled-medium', 'scrolled-large');

            // Apply scroll classes based on scroll progress
            if (scrollProgress > 0.6) {
                heroSection.classList.add('scrolled-large');
            } else if (scrollProgress > 0.4) {
                heroSection.classList.add('scrolled-medium');
            } else if (scrollProgress > 0.2) {
                heroSection.classList.add('scrolled-small');
            }

            // Additional smooth transformations (only on desktop)
            if (window.innerWidth > 768) {
            const layers = heroSection.querySelectorAll('.bg-layer-1, .bg-layer-2, .bg-layer-3');
            layers.forEach((layer, index) => {
                const layerSpeed = (index + 1) * 0.1;
                const translateY = scrollY * layerSpeed;
                const scale = 1 - (scrollProgress * 0.3 * (index + 1) / layers.length);
                
                if (!heroSection.classList.contains('scrolled-small', 'scrolled-medium', 'scrolled-large')) {
                    layer.style.transform = `translateY(${translateY}px) scale(${scale})`;
                }
            });
            }
        }

        // Use performance optimizer if available
        if (window.performanceOptimizer) {
            window.performanceOptimizer.addScrollListener('hero', updateHeroBackground);
        } else {
            // Fallback with throttling
            let scrollTicking = false;

        function handleScroll() {
            if (!scrollTicking) {
                    requestAnimationFrame(() => {
                        updateHeroBackground(window.pageYOffset);
                        scrollTicking = false;
                    });
                scrollTicking = true;
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        }
        
        // Initialize on load
        updateHeroBackground(window.pageYOffset);
    }
      
    function initializeEnhancedSearch() {
      const projectsList = document.getElementById('projectsList');
      const searchBar = document.getElementById('search-bar');
      const searchButton = document.getElementById('search-bttn');
      const toggleButton = document.getElementById('toggle-projects');
      const loader = document.getElementById('loader');
        const exploreBtn = document.querySelector('.hero-actions .btn-primary');
      
      let showAllProjects = false;
        let searchTimeout;

        // Explore Projects button functionality
        if (exploreBtn) {
            exploreBtn.addEventListener('click', function() {
                // Add animation
                this.style.transform = 'scale(0.95)';
      setTimeout(() => {
                    this.style.transform = '';
                }, 150);
                
                // Scroll to projects with smooth animation
                projectsList.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            });
        }

        // Enhanced search with debouncing
        if (searchBar) {
            searchBar.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length > 2) {
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
      }, 300);
                } else if (query.length === 0) {
                    loadProjects('src/model/fetch_projects.php?limit=15');
                }
            });
        }

        // Enhanced search button with animation
        if (searchButton) {
            searchButton.addEventListener('click', function() {
                const query = searchBar.value.trim();
                if (query) {
                    // Add pulse animation
                    this.style.animation = 'pulse 0.6s ease-in-out';
                  setTimeout(() => {
                        this.style.animation = '';
                    }, 600);
                    
                    performSearch(query);
                }
            });
        }

        // Enhanced enter key support
        if (searchBar) {
            searchBar.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value.trim();
                    if (query) {
                        performSearch(query);
                    }
              }
          });
      }

        // Enhanced toggle functionality
        if (toggleButton) {
      toggleButton.addEventListener('click', function() {
          showAllProjects = !showAllProjects;
          
                // Update button text with animation
                this.style.transform = 'scale(0.95)';
                  setTimeout(() => {
                    this.innerHTML = showAllProjects ? 
                        '<i class="fas fa-filter me-2"></i>Show Public Projects Only' : 
                        '<i class="fas fa-filter me-2"></i>Show All Projects';
                    this.style.transform = 'scale(1)';
                }, 150);
                
                // Clear search input and reload default projects
                if (searchBar) {
                    searchBar.value = '';
                }
                
                const endpoint = 'src/model/fetch_projects.php?limit=15';
                
                loadProjects(endpoint);
            });
        }
      
      function showLoader() {
          loader.style.display = 'flex';
          projectsList.innerHTML = '';
            
            // Add skeleton loading
            const skeletonCount = 6;
            for (let i = 0; i < skeletonCount; i++) {
                const skeleton = createSkeletonCard();
                skeleton.style.animationDelay = `${i * 0.1}s`;
                projectsList.appendChild(skeleton);
            }
      }
      
      function hideLoader() {
          loader.style.display = 'none';
      }
      
        function createSkeletonCard() {
            const card = document.createElement('div');
            card.className = 'skeleton-card fade-in-up';
            card.innerHTML = `
                <div class="skeleton-item" style="height: 200px; margin-bottom: 1rem;"></div>
                <div class="skeleton-item skeleton-title"></div>
                <div class="skeleton-item skeleton-text"></div>
                <div class="skeleton-item skeleton-text short"></div>
                <div class="skeleton-item skeleton-text"></div>
            `;
            return card;
        }

        function performSearch(query) {
          const searchEndpoint = 'src/model/search_projects.php';
          
          // Update URL with search parameter
          const newUrl = new URL(window.location);
          if (query && query.trim()) {
              newUrl.searchParams.set('search', query.trim());
          } else {
              newUrl.searchParams.delete('search');
          }
          window.history.replaceState({}, '', newUrl);
              
          showLoader();
            
          fetch(searchEndpoint, {
              method: 'POST',
              headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ searchString: query })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
              .then(data => {
                setTimeout(() => {
                  displayProjects(data);
                  hideLoader();
                  
                    // Smooth scroll to results
                    projectsList.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }, 300); // Small delay for better UX
            })
            .catch(error => {
                console.error('Search error:', error);
                hideLoader();
                showErrorMessage('Search failed. Please try again.');
            });
        }

        function loadProjects(url) {
            // Clear search parameter from URL when loading default projects
            const newUrl = new URL(window.location);
            newUrl.searchParams.delete('search');
            window.history.replaceState({}, '', newUrl);
            
            showLoader();
            
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                  setTimeout(() => {
                        displayProjects(data);
                        hideLoader();
                  }, 300);
              })
              .catch(error => {
                    console.error('Load projects error:', error);
                  hideLoader();
                    showErrorMessage('Failed to load projects. Please try again.');
                });
        }

        function showErrorMessage(message) {
              projectsList.innerHTML = `
                <div class="no-results fade-in-up">
                    <div class="no-results-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                  </div>
                    <p class="no-results-text">${message}</p>
                </div>
            `;
        }

        function displayProjects(projects) {
            projectsList.innerHTML = '';
            
            if (projects && projects.length > 0) {
                const uniqueProjects = removeDuplicateProjects(projects);
                
                uniqueProjects.forEach((project, index) => {
                    const projectCard = createProjectCard(project, index);
                    projectsList.appendChild(projectCard);
                });
                
                // Reinitialize animations
                  setTimeout(() => {
                    AOS.refresh();
                    initializeCardAnimations();
                }, 100);
                
            } else {
                projectsList.innerHTML = `
                    <div class="no-results fade-in-up">
                        <div class="no-results-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <p class="no-results-text">No projects found. Try different keywords or browse all available projects.</p>
                    </div>
                `;
            }
        }

        function removeDuplicateProjects(projects) {
            const uniqueProjects = [];
            const projectIds = new Set();
            
            projects.forEach(project => {
                const id = project._id && project._id.$oid ? project._id.$oid : project._id;
                if (!projectIds.has(id)) {
                    projectIds.add(id);
                    uniqueProjects.push(project);
                }
            });
            
            return uniqueProjects;
        }

        function createProjectCard(project, index) {
            const card = document.createElement('div');
            card.className = 'project-card fade-in-up';
            card.setAttribute('data-aos', 'fade-up');
            card.setAttribute('data-aos-delay', Math.min(index * 100, 600));
            
            // Handle project ID format properly
            let projectId = '';
            if (project._id) {
                if (typeof project._id === 'object' && project._id.$oid) {
                    projectId = project._id.$oid;
                } else {
                    projectId = project._id;
                }
            }
            
            // Format project data
            const formattedDate = formatDate(project.createdAt);
            const authorsList = formatAuthors(project.members);
            const supervisorName = formatSupervisor(project.supervisor);
            const imageSrc = getProjectImage(project.coverImage);
            const badgeInfo = getProjectBadge(project.privacy);
            
            // Add tracking metadata
            const trackingData = {
                title: project.title,
                category: project.category || 'Research',
                field: project.field || 'Research',
                keywords: project.keywords || [],
                tags: [project.category || 'Research', project.field || 'Research'].filter(Boolean)
            };
            
            card.innerHTML = `
                <a href="Project_details.php?id=${projectId}" class="text-decoration-none" 
                   data-item-type="project" 
                   data-item-id="${projectId}"
                   data-tracking-metadata='${JSON.stringify(trackingData)}'>
                    <div class="card-image">
                        <img src="${imageSrc}" alt="${project.title}" loading="lazy" onerror="this.src='assets/resources/research_picture/pub_1.jpg'">
                  </div>
                    <div class="card-content">
                        <div class="project-badge ${badgeInfo.class}">${badgeInfo.text}</div>
                        <h3 class="card-title">${project.title}</h3>
                        <p class="card-description">${truncateText(project.abstract || project.description || 'No description available', 120)}</p>
                        <div class="project-meta">
                            <div class="meta-item">
                                <i class="meta-icon far fa-calendar-alt"></i>
                                <span>${formattedDate}</span>
                            </div>
                            <div class="meta-item">
                                <i class="meta-icon fas fa-chalkboard-teacher"></i>
                                <span>Supervisor: ${supervisorName}</span>
                            </div>
                            <div class="meta-item">
                                <i class="meta-icon fas fa-users"></i>
                                <span>${authorsList}</span>
                            </div>
                            <div class="meta-item">
                                <i class="meta-icon fas fa-graduation-cap"></i>
                                <span>${project.field || 'Research'}</span>
                            </div>
                        </div>
                    </div>
                </a>
            `;
            
            return card;
        }

        // Utility functions
      function formatDate(dateInput) {
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
                  month: 'long', 
                  day: 'numeric' 
              });
          } catch (error) {
                console.error('Date formatting error:', error);
              return 'Date not available';
          }
      }

        function formatAuthors(members) {
            if (!members || !members.length) return 'No authors listed';
            
            return members
                .map(member => member.name || member.role || 'Author')
                .join(', ');
        }

        function formatSupervisor(supervisor) {
            if (!supervisor) return 'Not specified';
            
            if (typeof supervisor === 'string') return supervisor;
            if (typeof supervisor === 'object') {
                return supervisor.name || supervisor.userId || 'Not specified';
            }
            
            return 'Not specified';
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

        function getProjectBadge(privacy) {
            if (typeof privacy === 'undefined') {
                return { class: 'badge-secondary', text: 'Unknown' };
            }
            
            return privacy === 0 ? 
                { class: 'badge-public', text: 'Public' } : 
                { class: 'private', text: 'Private' };
        }

        function truncateText(text, maxLength) {
            if (!text || text.length <= maxLength) return text || '';
            return text.substring(0, maxLength) + '...';
        }

        // Initialize with URL search parameter or default projects
        const urlParams = new URLSearchParams(window.location.search);
        const urlSearchQuery = urlParams.get('search');
        
        if (urlSearchQuery && urlSearchQuery.trim()) {
            // Auto-search if URL has search parameter
            setTimeout(() => {
                performSearch(urlSearchQuery.trim());
            }, 100);
        } else {
            // Load default projects
            loadProjects('src/model/fetch_projects.php?limit=15');
        }
    }

    function initializeCardAnimations() {
        // Enhanced hover effects for project cards
        document.querySelectorAll('.project-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                // Add dynamic glow effect
                this.style.boxShadow = `
                    0 25px 50px rgba(0, 0, 0, 0.3),
                    0 0 40px rgba(37, 99, 235, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1)
                `;
            });

            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '';
            });

            // Add click animation
            card.addEventListener('click', function(e) {
                // Create ripple effect
                const rect = this.getBoundingClientRect();
                const ripple = document.createElement('div');
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.position = 'absolute';
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.background = 'rgba(37, 99, 235, 0.3)';
                ripple.style.borderRadius = '50%';
                ripple.style.pointerEvents = 'none';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple-animation 0.6s ease-out';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    }

    function initializeRippleEffects() {
        // Add ripple effect CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(style);
    }

    function initializePerformanceOptimizations() {
        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Preload critical resources
        const criticalResources = [
            'assets/resources/research_picture/pub_1.jpg',
            'assets/resources/research_picture/pub_2.jpg',
            'assets/resources/research_picture/pub_3.jpg'
        ];

        criticalResources.forEach(resource => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = resource;
            document.head.appendChild(link);
        });

        // Optimize scroll performance
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                // Cleanup any expired animations
                document.querySelectorAll('.fade-in-up.visible').forEach(el => {
                    el.style.willChange = 'auto';
                });
            }, 150);
        }, { passive: true });
    }

    // Initialize enhanced interactions on page load
    window.addEventListener('load', function() {
        // Add entrance animation to hero
        document.querySelector('.hero-section').style.opacity = '0';
        document.querySelector('.hero-section').style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            document.querySelector('.hero-section').style.transition = 'all 1s ease-out';
            document.querySelector('.hero-section').style.opacity = '1';
            document.querySelector('.hero-section').style.transform = 'translateY(0)';
        }, 100);

        // Initialize card animations after a short delay
        setTimeout(initializeCardAnimations, 500);
    });

    // Theme Management System
    function initializeTheme() {
        // Get saved theme from localStorage or default to dark
        const savedTheme = localStorage.getItem('theme') || 'dark';
        
        // Apply theme to document
        document.documentElement.setAttribute('data-theme', savedTheme);
        
        // Listen for theme changes from navbar
        document.addEventListener('themeChanged', function(e) {
            // Reinitialize particles with new theme
            initializeEnhancedParticles();
            
            // Add transition effect
            document.body.style.transition = 'all 0.4s ease';
            setTimeout(() => {
                document.body.style.transition = '';
            }, 400);
        });
    }

    // Listen for theme changes from other pages/tabs
    window.addEventListener('storage', function(e) {
        if (e.key === 'theme') {
            const newTheme = e.newValue || 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            // Reinitialize particles with new theme
            initializeEnhancedParticles();
        }
    });
  </script>
</body>
</html>

