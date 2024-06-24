<?php 

    require 'mysession.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Seller Dashboard</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/navbar.css?v=3">
    <link rel="stylesheet" href="css/seller.css?v=7">
    <link rel="stylesheet" href="./css/footer.css?v=2">

</head>
<body>
    <?php 
        require 'navbar.php';
        require 'dbconnect.php';

        $sql = "SELECT * FROM Product WHERE UserID=".$_SESSION['UserID']."";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $i = 1;

        while($row = mysqli_fetch_array($result)) {
            $ProductID[$i] = $row['ProductID'];
            $ProductName[$i] = $row['ProductName'];
            $ProductDescription[$i] = $row['ProductDescription'];
            $ProductCategory[$i] = $row['ProductCategory'];
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
    <div id="blank"></div>
    <!-- Seller Dashboard -->
    <div class="container">
        <h1 class="title">Your Products</h1>
        <div class="add-btn-container">
            <a href="newProduct.php" class="add-btn">Add new product</a>
        </div>

        
        <div class="my-products">
        <?php 
            if($num_rows > 0) {
                for($n = 1; $n < $i; $n++) {
                    echo '<form action="deleteProduct.php" method="GET">
                            <div class="product">
                                <div class="product-img-desc">
                                    <img src="uploads/'.$ProductImage[$n].'" alt="Product Image">
                                    <div class="product-name-price"> 
                                        <h5>'.$ProductName[$n].'</h5>
                                        <h5>RM '.$VariationPrice[$n].'</h5>
                                    </div>
                                </div>
                                <div class="actions">
                                    <a href="editProduct.php?productID='.$ProductID[$n].'">Edit</a>
                                    <input name="productID" value="'.$ProductID[$n].'" hidden>
                                    <button type="submit" onclick="return confirm(\'Are you sure you want to delete this product?\')" id="deleteProduct">Delete</button>
                                </div>
                            </div>
                        ';
                            
                }
            } else {
                echo "<h5 id='no-listing'>You have not listed any listing.</h5>";
            }
        ?>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>
</body>
</html>
