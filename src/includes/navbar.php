<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <link rel="stylesheet" href="assets/styles/navbar_style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Preload avatar image -->
        <link rel="preload" href="assets/resources/user_avatar.png" as="image">
        <!-- Critical CSS to prevent image flash -->
        <style>
            /* Critical styles to prevent image flashes */
            .user-avatar-container {
                width: 36px !important;
                height: 36px !important;
            }
            .user-avatar {
                max-width: 36px !important;
                max-height: 36px !important;
                width: 100% !important;
                height: 100% !important;
            }
        </style>

        <!-- Logo -->
        <a class="navbar-brand ps-4 p-2" href="index.php">
            <img src="assets/resources/UIURP.png" alt="UIURP Logo" height="65px" width="100px">
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'Research_page.php' ? 'active' : ''; ?>" id="projects-tab" href="Research_page.php">
                        <span>Projects</span>
                    </a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'Faculty_Page.php' ? 'active' : ''; ?>" href="Faculty_Page.php">
                        <span>Faculty</span>
                    </a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'forum_index.php' ? 'active' : ''; ?>" href="forum_index.php">
                        <span>Forum</span>
                    </a>
                </li>
            </ul>

            <!-- User Profile -->
            <div class="d-flex align-items-center">
                <div class="user-profile-container">
                    <a href="#" class="user-profile-link" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar-container">
                            <img src="assets/resources/user_avatar.png" alt="User Avatar" class="user-avatar">
                        </div>
                        <span class="user-profile-name">Najmol Hasan</span>
                        <i class="bi bi-chevron-down user-dropdown-icon"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="userDropdown">
                        <li class="dropdown-header">
                            <span>User Account</span>
                        </li>
                        <li><a class="dropdown-item" href="../../Student_Profile.php">
                            <i class="bi bi-person-circle item-icon"></i>
                            <span>Edit Profile</span>
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item logout-item" href="../../logout.php">
                            <i class="bi bi-box-arrow-right item-icon"></i>
                            <span>Logout</span>
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar');
        const navLinks = document.querySelectorAll('.nav-link');
        const dropdownItems = document.querySelectorAll('.dropdown-item');
        const userAvatar = document.querySelector('.rounded-circle');
        let lastScrollY = window.scrollY;
        let isScrollingDown = false;
        let animationFrame;
        
        // Initialize magnetic effect on nav links
        initMagneticEffect();
        
        // Set initial state
        handleScroll();
        
        // Add scroll event with requestAnimationFrame for performance
        window.addEventListener('scroll', () => {
            if (animationFrame) {
                cancelAnimationFrame(animationFrame);
            }
            
            animationFrame = requestAnimationFrame(() => {
                handleScroll();
                animationFrame = null;
            });
        });
        
        // Smoother scroll handling with animation
        function handleScroll() {
            // Calculate direction
            isScrollingDown = window.scrollY > lastScrollY;
            lastScrollY = window.scrollY;
            
            // Update navbar appearance
            if (window.scrollY > 30) {
                navbar.classList.add('scrolled');
                
                // Add subtle movement for more dynamic feel
                if (!navbar.style.transform || navbar.style.transform === 'translateY(0px)') {
                    if (isScrollingDown) {
                        navbar.style.transform = 'translateY(-5px)';
                        setTimeout(() => {
                            navbar.style.transform = 'translateY(0px)';
                        }, 200);
                    }
                }
            } else {
                navbar.classList.remove('scrolled');
            }
        }
        
        // Add magnetic effect to nav items
        function initMagneticEffect() {
            // Staggered animation on nav items
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach((item, index) => {
                // Add initial delay only on page load
                const link = item.querySelector('.nav-link');
                link.style.transitionDelay = `${index * 0.05}s`;
                
                // Reset delay after animation completes
                link.addEventListener('transitionend', function() {
                    this.style.transitionDelay = '0s';
                });
                
                // Add magnetic effect
                item.addEventListener('mousemove', function(e) {
                    const bounds = this.getBoundingClientRect();
                    const mouseX = e.clientX;
                    const mouseY = e.clientY;
                    const centerX = bounds.left + bounds.width / 2;
                    const centerY = bounds.top + bounds.height / 2;
                    const deltaX = (mouseX - centerX) * 0.1;
                    const deltaY = (mouseY - centerY) * 0.1;
                    
                    const link = this.querySelector('.nav-link');
                    link.style.transform = `translate(${deltaX}px, ${deltaY}px)`;
                });
                
                item.addEventListener('mouseleave', function() {
                    const link = this.querySelector('.nav-link');
                    link.style.transform = 'translate(0px, 0px)';
                });
            });
            
            // Add special effect to user dropdown
            const userDropdown = document.querySelector('.user-profile-container');
            const userToggle = document.querySelector('.user-profile-link');
            
            if (userDropdown && userToggle) {
                // No hover effects needed
                userToggle.addEventListener('click', function(e) {
                    // Just prevent defaults, Bootstrap handles the dropdown
                    e.preventDefault();
                });
            }
            
            // Add ripple effect to dropdown items
            dropdownItems.forEach(item => {
                item.addEventListener('mousedown', createRipple);
            });
        }
        
        // Create ripple effect on dropdown items
        function createRipple(e) {
            const button = e.currentTarget;
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            
            const size = Math.max(rect.width, rect.height) * 2;
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            ripple.className = 'ripple';
            
            // Remove existing ripples
            const existingRipple = button.querySelector('.ripple');
            if (existingRipple) {
                existingRipple.remove();
            }
            
            // Add new ripple
            button.appendChild(ripple);
            
            // Remove ripple after animation
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }
        
        // Add styles for modern user profile
        const style = document.createElement('style');
        style.innerHTML = `
            .dropdown-item {
                position: relative;
                overflow: hidden;
            }
            .ripple {
                position: absolute;
                background: rgba(67, 97, 238, 0.15);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }
            @keyframes ripple {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
            
            /* Modern user profile styling */
            .user-profile-container {
                position: relative;
            }
            
            .user-profile-link {
                display: flex;
                align-items: center;
                padding: 8px 12px;
                border-radius: 50px;
                background: #f8f9fa;
                text-decoration: none;
                color: #212529;
                transition: all 0.3s ease;
            }
            
            .user-profile-link:hover {
                background: #f1f3f5;
                color: #212529;
            }
            
            /* Sized explicitly to prevent flashing */
            .user-avatar-container {
                position: relative;
                width: 36px !important;
                height: 36px !important;
                border-radius: 50%;
                overflow: hidden;
                background: #e9ecef;
            }
            
            /* Sized explicitly to prevent flashing */
            .user-avatar {
                width: 100% !important;
                height: 100% !important;
                max-width: 36px !important;
                max-height: 36px !important;
                object-fit: cover;
                border-radius: 50%;
            }
            
            .user-profile-name {
                margin: 0 8px;
                font-weight: 500;
                font-size: 14px;
            }
            
            .user-dropdown-icon {
                font-size: 12px;
                opacity: 0.7;
            }
            
            .modern-dropdown {
                margin-top: 10px;
                border: none;
                border-radius: 12px;
                box-shadow: 0 5px 25px rgba(0,0,0,0.08);
                padding: 8px 0;
                min-width: 220px;
            }
            
            .dropdown-header {
                color: #6c757d;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
                padding: 10px 16px;
            }
            
            .dropdown-item {
                padding: 10px 16px;
                font-size: 14px;
                font-weight: 500;
                color: #495057;
                display: flex;
                align-items: center;
            }
            
            .dropdown-item:hover {
                background: #f8f9fa;
            }
            
            .item-icon {
                margin-right: 10px;
                font-size: 16px;
                color: #6c757d;
            }
            
            .logout-item {
                color: #dc3545;
            }
            
            .logout-item .item-icon {
                color: #dc3545;
            }
            
            .dropdown-divider {
                margin: 8px 0;
                border-color: #f1f3f5;
            }
        `;
        document.head.appendChild(style);
        
        // Add this to ensure the avatar is properly sized immediately on page load
        document.addEventListener('DOMContentLoaded', function() {
            const avatars = document.querySelectorAll('.user-avatar');
            avatars.forEach(avatar => {
                avatar.style.maxWidth = '36px';
                avatar.style.maxHeight = '36px';
                avatar.style.width = '100%';
                avatar.style.height = '100%';
            });
        });
    });
</script>
