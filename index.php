<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/homepage.css?v=2">
    <link rel="stylesheet" href="./css/navbar.css?v=1">
    <link rel="stylesheet" href="./css/styles.css?v=1">
    <link rel="stylesheet" href="./css/footer.css?v=1">
    
</head>
<body>
    <?php 
        require 'navbar.php';
        require 'dbconnect.php';

        $sql = "SELECT ProductID, ProductName, ProductImage FROM product";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $i = 1;

        while($row = mysqli_fetch_array($result)) {
            $ProductID[$i] = $row['ProductID'];
            $ProductName[$i] = $row['ProductName'];
            $ProductImage[$i] = $row['ProductImage'];
            $i++;
        }

    ?>

   <!-- Search Bar -->
   <div class="container mt-4">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <div class="header">
                    <div class="left-side">
                      <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Fesyen</a></button>
                      <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">25% Off Voucher</a></button>
                      <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Cash On Delivery</a></button>
                      <!-- <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Hari-Hari Free Shipping</a></button>
                      <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Up to RM150</a></button> -->
                    </div>
                <form id="search-form" class="d-flex justify-content-center">
                    <input id="search-input" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <div class="right-side">
                    <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">50% Off Beauty Deals</a></button>
                    <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Super Seringgit</a></button>
                    <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Global Outlet</a></button>
                    <!-- <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Shopee Supermarket</a></button>
                    <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Shopee Home</a></button>
                    <button class="btn btn-outline-success"><a href="#" style="text-decoration: none; color: inherit;">Daily Coins & Vouchers</a></button> -->
                  </div>
            </div>
        </div>
        
      </div>
      

    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Advertisement Section -->
        <div class="ad-section">
            <img src="ads.jpg" alt="Advertisement">
            <h2>Special Offers and Promotions</h2>
            <p>Don't miss out on our exclusive deals and discounts! Shop now and save big on your favorite products.</p>
        </div>

        <!-- Product Grid -->
        <div class="row row-cols-1 row-cols-md-5 mt-5" id="product-grid">
            <?php 

                if($num_rows > 0) {
                    for($n = 1; $n < $i; $n++) {
                        echo "<a href='product.php?ProductID=". $ProductID[$n] ."'>
                                <div class='product-card'>
                                        <img src='uploads/".$ProductImage[$n]."' alt='Product Image' class='product-image'>
                                        <h5>" . $ProductName[$n] . "</h5>
                                </div>
                            </a>";
                                
                    }
                } else {
                    echo "<h1>There are no products available at the moment.</h1>";
                }

            ?>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>
</body>
</html>
