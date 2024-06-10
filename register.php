<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="./css/footer.css?v=1">

    
</head>
<body>
    <?php 
        require 'navbar.php';
    ?>

    <!-- Register Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
                        <form method="POST" action="registerBackend.php">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="phoneno" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phoneno" id="phoneno" required>
                            </div>
                            <button type="submit" name="reg-submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-3" style="color: white;">
                    Already have an account? <a href="login.php" style="color: white;">Login here</a>
                </p>
            </div>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>

</body>
</html>
