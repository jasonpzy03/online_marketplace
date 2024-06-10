<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="./css/footer.css?v=1">

    
</head>
<body>
    <?php 
        require 'navbar.php';
    ?>

    <!-- Login Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <form method="POST" action="loginBackend.php">
                            <div class="mb-3">
                                <label for="mailuid" class="form-label">Username / Email</label>
                                <input type="text" class="form-control" name="mailuid" id="mailuid" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <button type="submit" name="login-submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-3" style="color: white;">
                    Don't have an account? <a href="register.php" style="color: white;">Register here</a>
                </p>
            </div>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>
</body>
</html>
