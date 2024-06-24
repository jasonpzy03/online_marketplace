<?php 

    require 'mysession.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Profile</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/navbar.css?v=3">
    <link rel="stylesheet" href="css/footer.css?v=4">
    <link rel="stylesheet" href="css/profile.css?v=6">
    
</head>
<body>
    <?php 
    
        require 'navbar.php';
        require 'dbconnect.php';
        require 'mysession.php';

        $sql = "SELECT * FROM user WHERE UserID=".$_SESSION['UserID']."";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);

        $row = mysqli_fetch_array($result);
        $Username = $row['Username'];
        $Email = $row['Email'];
        $PhoneNo = $row['PhoneNo'];
    
    ?>
    <div id="blank"></div>
    <!-- Main Content -->
    <div class="wrapper">
        <div class="container">

            <h2>User Profile</h2>
            <form class="update-profile-form" action="updateProfile.php?v=1" method="POST">
                <div class="input">
                    <label for="username" class="form-label">Username</label>
                    <?php echo '<input type="text" minlength="4" maxlength="20" class="form-control" name="username" id="username" value="'.$Username.'" required>'; ?>
                </div>
                <div class="input">
                    <label for="email" class="form-label">Email</label>
                    <?php echo '<input type="email" class="form-control" name="email" id="email" value="'.$Email.'" required>';?>
                </div>
                <div class="input">
                    <label for="phone" class="form-label">Phone</label>
                    <?php echo '<input type="text" minlength="10" maxlength="11" class="form-control" name="phone" id="phone" value="'.$PhoneNo.'" required>';?>
                </div>
                <div class="input">
                    <label for="phone" class="form-label">Password</label>
                    <input type="text" minlength="4" maxlength="20" class="form-control" name="pwd" id="pwd" value="" required>
                </div>
                <div class="input">
                    <label for="phone" class="form-label">Confirm Password</label>
                    <input type="text" minlength="4" maxlength="20" class="form-control" name="confirm-pwd" id="confirm-pwd" value="" required>
                </div>
                <button type="submit" name="update-profile-submit" class="update-profile-btn">Update Profile</button>
            </form>

        </div>
    </div>
    

    <?php 
    
    require 'footer.php';

    ?>
</body>
</html>
