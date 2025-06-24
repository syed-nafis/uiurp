<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/login.css">
    <style>
        .alert {
            padding: 10px;
            margin: 10px auto;
            width: 80%;
            border-radius: 5px;
            text-align: center;
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
        <input type="checkbox" id="chk">
        
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
                <label for="chk">Sign Up</label>
                <input type="text" name="username" placeholder="User name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <input type="text" name="role" placeholder="Your role? ex: resident / admin" required="">
                <button>Sign Up</button>
            </form>
        </div>
        <div class="login">
            <form action="src/controller/login_user.php" method="post">
                <label for="chk">Login</label>
                <input type="username" name="username" placeholder="username or id" required="">
                <input type="password" name="Password" placeholder="password" required="">
                <button>Login</button>
            </form>
        </div>
    </div>
</body>
</html>
