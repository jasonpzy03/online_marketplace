<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Home</title>
    <link rel="stylesheet" href="./css/homepage.css?v=9">
    <link rel="stylesheet" href="./css/navbar.css?v=11">
    <link rel="stylesheet" href="./css/styles.css?v=2">
    <link rel="stylesheet" href="./css/footer.css?v=4">
    
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

        for ($n = 1; $n < $i; $n++) {
            $sql = "SELECT * FROM variation WHERE ProductID=".$ProductID[$n]."";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $VariationPrice[$n] = $row['VariationPrice'];
        }
        
    ?>


    <!-- Advertisement Section -->
    <div class="ad-section">
        <div id="slider">
            <input type="radio" name="slider" id="slide1" checked>
            <input type="radio" name="slider" id="slide2">
            <input type="radio" name="slider" id="slide3">
            <input type="radio" name="slider" id="slide4">
            <div id="slides">
                <div id="overflow">
                    <div class="inner">
                        <div class="slide slide_1">
                        <div class="slide-content">
                            <img src="slides/slides1.jpeg" width="100%" height="100%" alt="">
                        </div>
                        </div>
                        <div class="slide slide_2">
                        <div class="slide-content">
                            <img src="slides/slides2.jpeg" width="100%" height="100%" alt="">

                        </div>
                        </div>
                        <div class="slide slide_3">
                        <div class="slide-content">
                            <img src="slides/slides3.jpeg" width="100%" height="100%" alt="">

                        </div>
                        </div>
                        <div class="slide slide_4">
                        <div class="slide-content">
                            <img src="slides/slides4.jpeg" width="100%" height="100%" alt="">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="controls">
            <label for="slide1"></label>
            <label for="slide2"></label>
            <label for="slide3"></label>
            <label for="slide4"></label>
        </div>
        <div id="bullets">
            <label for="slide1"></label>
            <label for="slide2"></label>
            <label for="slide3"></label>
            <label for="slide4"></label>
        </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="daily-discover">
            <b>DAILY DISCOVER</b>
        </div>
        <!-- Product Grid -->
        
        <div id="product-grid">
            <?php 

                if($num_rows > 0) {
                    for($n = 1; $n < $i; $n++) {
                        echo "<a href='product.php?ProductID=". $ProductID[$n] ."'>
                                <div class='product-card'>
                                        <div id='product-card-img'>
                                            <img src='uploads/".$ProductImage[$n]."' alt='Product Image'>
                                        </div>
                                        <div class='product-card-wrapper'>
                                            <p id='product-name'>" . $ProductName[$n] . "</p>
                                            <p id='product-price'>RM " . $VariationPrice[$n] . "</p>
                                        </div>
                                </div>
                            </a>";
                                
                    }
                } else {
                    echo "<h5 id='no-product'>There are no products available at the moment.</h5>";
                }

            ?>
        </div>
        
        
    </div>
    
    


    <?php
        require 'footer.php';
    ?>
</body>
</html>
