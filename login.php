<?php
// Set secure session cookie parameters before session_start()
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
$cookieParams = session_get_cookie_params();
session_set_cookie_params([
    'lifetime' => $cookieParams['lifetime'],
    'path' => $cookieParams['path'],
    'domain' => $cookieParams['domain'],
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
// Session idle timeout (20 minutes)
$timeout = 20 * 60; // 20 minutes in seconds
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    // Last request was more than 20 minutes ago
    session_unset();     // Unset $_SESSION variable for the run-time
    session_destroy();   // Destroy session data in storage
    header('Location: login.php?timeout=1');
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time
// Handle redirect page
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/styles/login.css">
    <style>
        .alert {
            padding: 15px;
            margin: 15px auto;
            width: 80%;
            border-radius: 5px;
            text-align: center;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="main">  	
        <input type="checkbox" id="chk" checked>
        
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            $_SESSION['faculty_id'] = (string) $faculty['_id'];
            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_GET['timeout']) && $_GET['timeout'] == 1) {
            echo '<div class="alert alert-warning">Your session has expired due to inactivity. Please log in again.</div>';
        }
        ?>
        
        <div class="signup">
            <form action="src/controller/login_user.php" method="post">
                <label for="chk" aria-label="Switch to signup"><i class="fas fa-user-plus"></i> Sign Up</label>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="resident">Resident</option>
                    <option value="admin">Admin</option>
                    <option value="faculty">Faculty</option>
                </select>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                <button type="submit"><i class="fas fa-user-plus"></i> Create Account</button>
            </form>
        </div>
        <div class="login">
            <form action="src/controller/login_user.php" method="post">
                <label for="chk" aria-label="Switch to login"><i class="fas fa-sign-in-alt"></i> Login</label>
                <input type="text" name="username" placeholder="Username or ID" required>
                <input type="password" name="Password" placeholder="Password" required>
                <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
                <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
            </form>
        </div>
    </div>
</body>
</html>
