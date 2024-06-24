<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Login</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/navbar.css?v=3">
    <link rel="stylesheet" href="css/login.css?v=4">
    <link rel="stylesheet" href="./css/footer.css?v=6">

    
</head>
<body>
    <?php 
        require 'navbar.php';
    ?>
    <div id="blank"></div>
    <!-- Login Form -->
    <div class="wrapper">
        <div class="login">
            <h2>Login</h2>
            <form class="login-form" method="POST" action="loginBackend.php">
                <div class="input">
                    <label for="mailuid" class="form-label">Username / Email</label>
                    <input type="text" minlength="4" maxlength="20" class="form-control" name="mailuid" id="mailuid" required>
                </div>
                <div class="input">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" minlength="4" maxlength="20" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" name="login-submit" class="login-btn">Login</button>
            </form>
            <p class="login-nav">Don't have an account?<a href="register.php" class="login-nav"> Register here</a></p>
        </div>
    </div>
                
    <?php
        require 'footer.php';
    ?>
</body>
</html>
