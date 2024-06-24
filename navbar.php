<div class="navbar">
<div class="nav-wrapper">
    <div class="navbar-logo">
        <a href="index.php">LMMarketplace</a>
    </div>
    <div class="seller-center">
        <?php
            if(isset($_SESSION['id'])) {
                echo '<a class="nav-link" href="seller.php">Seller Centre</a>';
            }
        ?>
    </div>
    
    <form id="search-form" action="search.php" method="get">
        <input id="search-input" name="keyword" type="search" placeholder="Search LMMarketplace">
        <button type="submit"><img src="icons/search.png" width="20px" height="20px" alt="Search"></button>
    </form>
    
    <ul class="navbar-links">
        
        <?php 
            if(!isset($_SESSION['id'])) {
                echo '<li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>';
            }

            if(isset($_SESSION['id'])) {
                echo '<li class="nav-item">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="purchases.php">Purchases</a>
            </li>
            <li class="nav-item">
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
