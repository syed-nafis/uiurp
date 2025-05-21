<?php
// No need for session_start() here since it's now called at the beginning of each page
// Determine the base path for correct relative links
$current_path = $_SERVER['PHP_SELF'];
$path_parts = explode('/', $current_path);
$depth = count(array_filter($path_parts)) - 1;
$base_path = $depth > 1 ? str_repeat('../', $depth - 1) : '';
?>

<!-- Modern Navbar with Fluid Animations -->
<!-- Include Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">

<nav class="modern-navbar">
    <!-- Animated Background Layer -->
    <div class="navbar-bg-layer"></div>
    
    <div class="navbar-container">
        <!-- Logo with Animation -->
        <a href="index.php" class="navbar-logo">
            <img src="assets/resources/UIURP.png" alt="UIURP Logo">
            <span class="logo-glow"></span>
        </a>

        <!-- Mobile Menu Toggle -->
        <div class="mobile-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navigation Links -->
        <div class="navbar-menu">
            <div class="nav-list">
                <a href="index.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                    <span class="nav-icon"><i class="bi bi-house"></i></span>
                    <span class="nav-text">Home</span>
                    <span class="nav-highlight"></span>
                </a>
                
                <a href="Research_page.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'Research_page.php' ? 'active' : ''; ?>">
                    <span class="nav-icon"><i class="bi bi-journal-richtext"></i></span>
                    <span class="nav-text">Projects</span>
                    <span class="nav-highlight"></span>
                </a>
                
                <a href="Faculty_Page.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'Faculty_Page.php' ? 'active' : ''; ?>">
                    <span class="nav-icon"><i class="bi bi-mortarboard"></i></span>
                    <span class="nav-text">Faculty</span>
                    <span class="nav-highlight"></span>
                </a>
                
                <a href="forum_index.php" class="nav-item <?= basename($_SERVER['PHP_SELF']) == 'forum_index.php' ? 'active' : ''; ?>">
                    <span class="nav-icon"><i class="bi bi-chat-square-text"></i></span>
                    <span class="nav-text">Forum</span>
                    <span class="nav-highlight"></span>
                </a>
            </div>

            <!-- User Profile Section -->
            <div class="user-section">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                    <div class="user-profile">
                        <div class="user-trigger" id="userMenuTrigger">
                            <div class="user-avatar">
                                <img src="assets/resources/user_avatar.png" alt="User">
                                <div class="avatar-status"></div>
                            </div>
                            <span class="user-name"><?= htmlspecialchars($_SESSION['user_data']['name'] ?? 'User') ?></span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        
                        <div class="user-menu-dropdown">
                            <div class="dropdown-header">
                                <div class="header-avatar">
                                    <img src="assets/resources/user_avatar.png" alt="User">
                                </div>
                                <div class="header-info">
                                    <p class="header-name"><?= htmlspecialchars($_SESSION['user_data']['name'] ?? 'User') ?></p>
                                    <p class="header-email"><?= htmlspecialchars($_SESSION['user_data']['email'] ?? 'email@example.com') ?></p>
                                </div>
                            </div>
                            
                            <div class="dropdown-content">
                                <!-- Profile Section -->
                                <a href="<?= $base_path ?>Student_Profile.php" class="menu-item">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Edit Profile</span>
                                </a>
                                
                                <!-- Projects Section -->
                                <div class="menu-section">
                                    <p class="menu-section-title">Projects</p>
                                    <a href="<?= $base_path ?>project_management.php" class="menu-item">
                                        <i class="bi bi-folder-fill"></i>
                                        <span>My Projects</span>
                                    </a>
                                    <a href="<?= $base_path ?>project_management.php#new-project" class="menu-item">
                                        <i class="bi bi-plus-circle"></i>
                                        <span>Create New Project</span>
                                    </a>
                                </div>
                                
                                <div class="menu-divider"></div>
                                <a href="<?= $base_path ?>logout.php" class="menu-item logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= $base_path ?>login.php" class="login-button">
                        <i class="bi bi-person-circle"></i>
                        <span>Login</span>
                    </a>
                <?php endif; ?>
                </div>
        </div>
    </div>
</nav>

<!-- Navbar Styling and Animations -->
<style>
:root {
    --navbar-primary: #4361ee;
    --navbar-secondary: #3a0ca3;
    --navbar-accent: #7209b7;
    --navbar-light: #f8f9fa;
    --navbar-dark: #212529;
    --navbar-success: #4cc9f0;
    --navbar-warning: #f72585;
    --navbar-transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    --navbar-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    --navbar-gradient: linear-gradient(135deg, #4361ee, #3a0ca3);
    --navbar-bg: #ffffff;
    --navbar-height: 70px;
    --navbar-height-scroll: 60px;
    --border-radius: 12px;
}

/* Core Navbar Structure */
.modern-navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: var(--navbar-height);
    z-index: 1000;
    transition: var(--navbar-transition);
    background: var(--navbar-bg);
    box-shadow: var(--navbar-shadow);
}

.navbar-bg-layer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--navbar-bg);
    box-shadow: var(--navbar-shadow);
    z-index: -1;
}

.modern-navbar.scrolled .navbar-bg-layer {
    transform: translateY(0);
    opacity: 1;
}

.navbar-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Logo Styling and Animations */
.navbar-logo {
    display: flex;
    align-items: center;
    position: relative;
    z-index: 10;
    text-decoration: none;
}

.navbar-logo img {
    height: 55px;
    width: 90px;
    object-fit: contain;
    transition: var(--navbar-transition);
    filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.1));
}

.modern-navbar.scrolled .navbar-logo img {
    height: 45px;
    width: 80px;
}

.logo-glow {
    position: absolute;
    width: 50px;
    height: 50px;
    background: radial-gradient(circle, rgba(76, 201, 240, 0.3), transparent 70%);
    border-radius: 50%;
    z-index: -1;
    opacity: 0;
    transform: scale(0.8);
    transition: opacity 0.5s ease, transform 0.5s ease;
    top: 50%;
    left: 40px;
    margin-top: -25px;
}

.navbar-logo:hover .logo-glow {
    opacity: 1;
    transform: scale(1.5);
}

/* Navigation Menu Styling */
.navbar-menu {
    display: flex;
    align-items: center;
    height: 100%;
}

.nav-list {
    display: flex;
    align-items: center;
    height: 100%;
    margin-right: 20px;
}

.nav-item {
    position: relative;
    display: flex;
    align-items: center;
    height: 100%;
    padding: 0 20px;
    text-decoration: none;
    color: var(--navbar-dark);
    font-weight: 500;
    font-size: 16px;
    transition: var(--navbar-transition);
}

.nav-icon {
    margin-right: 8px;
    font-size: 18px;
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: inline-block;
    opacity: 0.7;
}

.nav-text {
    position: relative;
    overflow: hidden;
}

.nav-highlight {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 3px;
    background: var(--navbar-gradient);
    border-radius: 3px;
    transform: translateX(-50%);
    transition: width 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

/* Navigation Item Hover Effects */
.nav-item:hover, 
.nav-item.active {
    color: var(--navbar-primary);
}

.nav-item:hover .nav-icon,
.nav-item.active .nav-icon {
    transform: translateY(-3px);
    opacity: 1;
}

.nav-item:hover .nav-highlight,
.nav-item.active .nav-highlight {
    width: 30px;
}

/* User Section Styling */
.user-section {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
}

.user-profile {
    position: relative;
}

.user-trigger {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 30px;
    cursor: pointer;
    transition: var(--navbar-transition);
    background: rgba(0, 0, 0, 0.03);
}

.user-trigger:hover {
    background: rgba(0, 0, 0, 0.06);
}

.user-avatar {
    position: relative;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    margin-right: 12px;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-status {
    position: absolute;
    bottom: 3px;
    right: 3px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #28a745;
    border: 2px solid white;
}

.user-name {
    font-weight: 600;
    margin-right: 8px;
    font-size: 15px;
}

/* User Dropdown Styling */
.user-menu-dropdown {
    position: absolute;
    top: calc(100% + 15px);
    right: 0;
    width: 280px;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    opacity: 0;
    transform-origin: top right;
    transform: scale(0.9);
    visibility: hidden;
    transition: opacity 0.2s ease, transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), visibility 0.2s;
    overflow: hidden;
    z-index: 1001;
}

.user-profile.active .user-menu-dropdown {
    opacity: 1;
    transform: scale(1);
    visibility: visible;
}

.dropdown-header {
    padding: 20px;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.05), rgba(76, 201, 240, 0.1));
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.header-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 15px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.header-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.header-info {
    flex: 1;
}

.header-name {
    font-weight: 600;
    margin: 0;
}

.header-email {
    font-size: 13px;
    color: #6c757d;
    margin: 0;
    margin-top: 3px;
}

.dropdown-content {
    padding: 10px;
}

.menu-section {
    padding: 5px 0;
    margin-bottom: 10px;
}

.menu-section-title {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    margin: 8px 15px;
    font-weight: 600;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    text-decoration: none;
    color: var(--navbar-dark);
    border-radius: 8px;
    transition: var(--navbar-transition);
    position: relative;
    overflow: hidden;
}

.menu-item i {
    font-size: 18px;
    margin-right: 12px;
    color: #6c757d;
    transition: var(--navbar-transition);
}

.menu-item span {
    font-weight: 500;
    font-size: 14px;
    transition: var(--navbar-transition);
}

.menu-item:hover {
    background: rgba(67, 97, 238, 0.05);
    color: var(--navbar-primary);
}

.menu-item:hover i {
    color: var(--navbar-primary);
}

.menu-item:active {
    transform: scale(0.98);
}

.menu-item::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(67, 97, 238, 0.2) 0%, transparent 70%);
    transform: translate(-50%, -50%) scale(0);
    opacity: 0;
    transition: transform 0.5s ease, opacity 0.5s ease;
    pointer-events: none;
    border-radius: 50%;
}

.menu-item:active::after {
    transform: translate(-50%, -50%) scale(3);
    opacity: 1;
    transition: transform 0.15s ease-out, opacity 0.15s ease-out;
}

.menu-divider {
    height: 1px;
    background: rgba(0, 0, 0, 0.05);
    margin: 10px 0;
}

.logout {
    color: #dc3545;
}

.logout i {
    color: #dc3545;
}

.login-button {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    background: var(--navbar-gradient);
    color: white;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 500;
    font-size: 15px;
    transition: var(--navbar-transition);
    box-shadow: 0 5px 20px rgba(67, 97, 238, 0.3);
    position: relative;
    overflow: hidden;
}

.login-button i {
    margin-right: 8px;
    font-size: 18px;
}

.login-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(67, 97, 238, 0.4);
    color: white;
}

/* Mobile Toggle Button */
.mobile-toggle {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 20px;
    cursor: pointer;
    z-index: 100;
}

.mobile-toggle span {
    width: 100%;
    height: 2px;
    background: var(--navbar-dark);
    border-radius: 4px;
    transition: var(--navbar-transition);
    transform-origin: left;
}

.mobile-toggle.active span:nth-child(1) {
    transform: rotate(45deg);
}

.mobile-toggle.active span:nth-child(2) {
    opacity: 0;
}

.mobile-toggle.active span:nth-child(3) {
    transform: rotate(-45deg);
}

/* Responsive Styling */
@media (max-width: 991px) {
    .navbar-container {
        padding: 0 16px;
    }
    
    .mobile-toggle {
        display: flex;
    }
    
    .navbar-menu {
        position: fixed;
        top: 0;
        right: 0;
        width: 80%;
        max-width: 350px;
        height: 100vh;
        background: white;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        padding: 100px 30px 30px;
        box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
        transform: translateX(100%);
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 50;
        overflow-y: auto;
    }
    
    .navbar-menu.active {
        transform: translateX(0);
    }
    
    .nav-list {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        height: auto;
        margin-right: 0;
        margin-bottom: 30px;
    }
    
    .nav-item {
        width: 100%;
        height: auto;
        padding: 15px 0;
    }
    
    .nav-highlight {
        display: none;
    }
    
    .user-section {
        width: 100%;
        height: auto;
    }
    
    .user-profile, 
    .login-button {
        width: 100%;
    }
    
    .user-trigger {
        width: 100%;
        justify-content: space-between;
    }
    
    .user-menu-dropdown {
        position: static;
        width: 100%;
        margin-top: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Animation for mobile menu items */
    .nav-item, 
    .user-profile, 
    .login-button {
        opacity: 0;
        transform: translateX(20px);
    }
    
    .navbar-menu.active .nav-item, 
    .navbar-menu.active .user-profile, 
    .navbar-menu.active .login-button {
        animation: fadeSlideIn 0.5s forwards;
    }
    
    .navbar-menu.active .nav-item:nth-child(1) { animation-delay: 0.1s; }
    .navbar-menu.active .nav-item:nth-child(2) { animation-delay: 0.15s; }
    .navbar-menu.active .nav-item:nth-child(3) { animation-delay: 0.2s; }
    .navbar-menu.active .nav-item:nth-child(4) { animation-delay: 0.25s; }
    .navbar-menu.active .user-profile, 
    .navbar-menu.active .login-button { animation-delay: 0.3s; }
    
    @keyframes fadeSlideIn {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
}

/* Adjust body padding for fixed navbar */
body {
    padding-top: var(--navbar-height);
}

/* Smooth body padding transition */
.modern-navbar.scrolled + body {
    padding-top: var(--navbar-height-scroll);
}

/* Add a subtle overlay when mobile menu is open */
.menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 40;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.4s ease, visibility 0.4s;
}

.menu-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Additional scroll animation */
.modern-navbar.scrolled {
    height: var(--navbar-height-scroll);
}
</style>

<!-- Navbar Script for Functionality and Animations -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const navbar = document.querySelector('.modern-navbar');
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navbarMenu = document.querySelector('.navbar-menu');
    const userTrigger = document.getElementById('userMenuTrigger');
    const userProfile = document.querySelector('.user-profile');
    
    // Create menu overlay
    const overlay = document.createElement('div');
    overlay.className = 'menu-overlay';
    document.body.appendChild(overlay);
    
    // Handle scroll
        let lastScrollY = window.scrollY;
        let isScrollingDown = false;
    
    // Initial state check
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    }
    
    // Scroll handler with animation frame for performance
    window.addEventListener('scroll', function() {
        requestAnimationFrame(() => {
            // Check scroll direction
            isScrollingDown = window.scrollY > lastScrollY;
            lastScrollY = window.scrollY;
            
            // Toggle scrolled class
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Add subtle movement for more dynamic feel
            if (isScrollingDown && window.scrollY > 100) {
                navbar.style.transform = 'translateY(-5px)';
                setTimeout(() => {
                    navbar.style.transform = 'translateY(0)';
                }, 200);
            }
        });
    });
    
    // Mobile menu toggle
    mobileToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        navbarMenu.classList.toggle('active');
        overlay.classList.toggle('active');
        
        // Prevent body scroll when menu is open
        if (navbarMenu.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });
    
    // Close mobile menu when clicking overlay
    overlay.addEventListener('click', function() {
        mobileToggle.classList.remove('active');
        navbarMenu.classList.remove('active');
        this.classList.remove('active');
        document.body.style.overflow = '';
    });
    
    // User dropdown toggle
    if (userTrigger) {
        userTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            userProfile.classList.toggle('active');
            console.log('User dropdown toggled:', userProfile.classList.contains('active'));
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (userProfile && !userProfile.contains(e.target)) {
                userProfile.classList.remove('active');
            }
        });
        }
        
        // Add magnetic effect to nav items
            const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
                item.addEventListener('mousemove', function(e) {
                    const bounds = this.getBoundingClientRect();
            const mouseX = e.clientX - bounds.left;
            const mouseY = e.clientY - bounds.top;
            const centerX = bounds.width / 2;
            const centerY = bounds.height / 2;
                    const deltaX = (mouseX - centerX) * 0.1;
                    const deltaY = (mouseY - centerY) * 0.1;
                    
            const icon = this.querySelector('.nav-icon');
            if (icon) {
                icon.style.transform = `translate(${deltaX}px, ${deltaY - 3}px)`;
            }
                });
                
                item.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.nav-icon');
            if (icon) {
                icon.style.transform = '';
            }
                });
            });
            
    // Add ripple effect to menu items
    const menuItems = document.querySelectorAll('.menu-item');
            
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            ripple.className = 'ripple-effect';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
        
    // Add CSS for ripple effect
        const style = document.createElement('style');
    style.textContent = `
        .ripple-effect {
                position: absolute;
                border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
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
        `;
        document.head.appendChild(style);
        
    // Preload avatar images for smoother experience
    const avatars = document.querySelectorAll('.user-avatar img, .header-avatar img');
    avatars.forEach(img => {
        if (img.src) {
            const preloadImg = new Image();
            preloadImg.src = img.src;
        }
        });
    });
</script>
