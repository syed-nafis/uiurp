<?php
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <link rel="stylesheet" href="assets/styles/navbar_style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Moved here -->

        <!-- Logo -->
        <a class="navbar-brand ps-4 p-2" href="index.php">
            <img src="assets/resources/UIURP.png" alt="UIURP Logo" height="65px" width="65px">
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'Research_page.php' ? 'active' : ''; ?>" id="projects-tab" href="Research_page.php">Projects</a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'Faculty_Page.php' ? 'active' : ''; ?>" href="Faculty_Page.php">Faculty</a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'forum_index.php' ? 'active' : ''; ?>" href="forum_index.php">Forum</a>
                </li>
            </ul>

            <!-- User Profile -->
             <?php if (isset($_SESSION['logged_in'])): ?>
                <div class="d-flex align-items-center dropdown">
                    <a href="#" class="nav-link d-flex align-items-center fw-semibold dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/resources/user_avatar.png" alt="User Avatar" class="rounded-circle me-2" width="40" height="40">
                        <span class="user-name">
                            <?php
                                $userData = $_SESSION['user_data'];
                                if (is_array($userData)) {
                                    echo $userData['name'];
                                } elseif (is_object($userData)) {
                                    echo $userData->name;
                                } else {
                                    echo 'User';
                                }
                            ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="../../Student_Profile.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="../../login.php" class="nav-link d-flex align-items-center fw-semibold dropdown-toggle" id="userDropdown" role="button" aria-expanded="false">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
