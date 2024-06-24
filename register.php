<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Register</title>
    <link rel="stylesheet" href="css/navbar.css?v=5">
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/footer.css?v=3">
    <link rel="stylesheet" href="css/register.css?v=3">
    
</head>
<body>
    <?php 
        require 'navbar.php';
    ?>
    <div id="blank"></div>
    <!-- Register Form -->
    <div class="wrapper">
        <div class="register">
            <h2>Create Account</h2>
            <form class="register-form" method="POST" action="registerBackend.php">
                <div class="input">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" minlength="4" maxlength="20" class="form-control" name="username" id="username" required>
                </div>
                <div class="input">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="input">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" minlength="4" maxlength="20" class="form-control" name="password" id="password" required>
                </div>
                <div class="input">
                    <label for="phoneno" class="form-label">Phone Number</label>
                    <input type="text" minlength="10" maxlength="11" class="form-control" name="phoneno" id="phoneno" required>
                </div>
                <button type="submit" name="reg-submit" class="reg-btn">Register</button>
            </form>
            <p class="login-nav">Already have an account? <a class="login-nav" href="login.php">Login</a></p>
        </div>
    </div>
    <?php
        require 'footer.php';
    ?>

</body>
</html>
