<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <link rel="stylesheet" href="Style/navbar_style.css">

        <!-- Logo -->
        <a class="navbar-brand ps-4 p-2" href="index.php">
            <img src="resources/UIURP.png" alt="UIURP Logo" height="65px" width="65px">
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
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'Research_page.php' ? 'active' : ''; ?>" href="Research_page.php">Projects</a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold <?= basename($_SERVER['PHP_SELF']) == 'Faculty_Page.php' ? 'active' : ''; ?>" href="Faculty_Page.php">Faculty</a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link fw-semibold" href="#">Forum</a>
                </li>
            </ul>

            <!-- User Profile -->
            <div class="d-flex align-items-center">
                <a href="Student_Profile.php" class="nav-link d-flex align-items-center fw-semibold">
                    <img src="resources/user_avatar.png" alt="User Avatar" class="rounded-circle me-2" width="40" height="40">
                    <span class="user-name">user_name</span>
                </a>
            </div>
        </div>
    </div>
</nav>
