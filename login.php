<?php 
session_start();
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
        ?>
        
        <div class="signup">
            <form action="src/controller/login_user.php" method="post">
                <label for="chk" aria-label="Switch to signup"><i class="fas fa-user-plus"></i> Sign Up</label>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="resident">Student</option>
                    <option value="admin">Admin</option>
                    <option value="faculty">Faculty</option>
                </select>
                <button type="submit"><i class="fas fa-user-plus"></i> r</button>
            </form>
        </div>
        <div class="login">
            <form action="src/controller/login_user.php" method="post">
                <label for="chk" aria-label="Switch to login"><i class="fas fa-sign-in-alt"></i> Login</label>
                <input type="text" name="username" placeholder="Username or ID" required>
                <input type="password" name="Password" placeholder="Password" required>
                <button type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
                <button type="button" onclick="toggleToSignup()"><i class="fas fa-user-plus"></i> Don't have an account?</button>
            </form>
        </div>
    </div>
    
    <script>
        function toggleToSignup() {
            // Uncheck the checkbox to show signup form
            document.getElementById('chk').checked = false;
        }
    </script>
</body>
</html>
