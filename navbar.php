<?php
    require 'mysession.php';
?>

<nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">LastMinute</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php
                        if(isset($_SESSION['id'])) {
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="seller.php">Seller Centre</a>
                                </li>';
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Download</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Follow us</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Notification</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Help</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Language</a>
                    </li>
                    <?php 
                        if(!isset($_SESSION['id'])) {
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="login.php">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="register.php">Register</a>
                                </li>';
                        }
                    ?>
                    
                    <?php
                        if(isset($_SESSION['id'])) {
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="logout.php">Log out</a>
                                </li>';
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="cart.php">
                                        <img src="cartLogo.png" alt="Cart" style="width:30px;height:30px;">
                                    </a>
                                </li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>