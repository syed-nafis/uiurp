<?php
// Footer component for UIU Research Portal
?>

<footer class="enhanced-footer">
    <div class="container footer-content">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h3 class="footer-title">UIU Research Portal</h3>
                <p class="footer-description">
                    Connecting innovative minds and groundbreaking research, fostering collaboration across disciplines.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h4 class="footer-section-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="Research_page.php">Research Projects</a></li>
                    <li><a href="Faculty_Page.php">Faculty Profiles</a></li>
                    <li><a href="Research_page.php">Learning Resources</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h4 class="footer-section-title">Research Areas</h4>
                <ul class="footer-links">
                    <li><a href="#ai">Artificial Intelligence</a></li>
                    <li><a href="#cs">Computer Science</a></li>
                    <li><a href="#engineering">Engineering</a></li>
                    <li><a href="#business">Business</a></li>
                    <li><a href="#social">Social Sciences</a></li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h4 class="footer-section-title">Resources</h4>
                <ul class="footer-links">
                    <li><a href="#guidelines">Guidelines</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#support">Support</a></li>
                    <li><a href="#privacy">Privacy Policy</a></li>
                    <li><a href="src/model/debug_mongodb.php">Debug</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p class="copyright-text">
                &copy; 2025 UIU Research Portal. All rights reserved. Built with passion for research excellence.
            </p>
        </div>
    </div>
</footer>

<style>
/* Enhanced Footer Styles */
.enhanced-footer {
    background: linear-gradient(135deg, #0a0d1a 0%, #1a1a2e 100%);
    border-top: 1px solid rgba(37, 99, 235, 0.2);
    position: relative;
    overflow: hidden;
    padding: 80px 0 40px;
    color: #ffffff;
    margin-top: 5rem;
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
        #2563eb, 
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
    background: linear-gradient(135deg, #ffffff, #2563eb);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.footer-description {
    color: rgba(255, 255, 255, 0.7);
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
    background: linear-gradient(90deg, #2563eb, #8b5cf6);
    transition: width 0.3s ease;
}

.footer-links a:hover {
    color: #2563eb;
}

.footer-links a:hover::after {
    width: 100%;
}

.footer-section-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: #ffffff;
    position: relative;
}

.footer-section-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 30px;
    height: 2px;
    background: #2563eb;
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
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.1rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-link:hover {
    background: #2563eb;
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
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.9rem;
    margin: 0;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .enhanced-footer {
        padding: 60px 0 30px;
    }
    
    .footer-title {
        font-size: 1.5rem;
    }
    
    .footer-description {
        font-size: 1rem;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style> 