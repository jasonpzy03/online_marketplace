<?php 

    require 'mysession.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Buyer Cart</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/cart.css?v=6">
    <link rel="stylesheet" href="css/navbar.css?v=4">
    <link rel="stylesheet" href="css/footer.css?v=5">
    
</head>
<body>
    <?php 
        require 'navbar.php';
        require 'dbconnect.php';

        $sql = "SELECT CartID, ProductID, VariationID, Quantity, CartTotal FROM cart WHERE UserID=".$_SESSION['UserID']."";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $i = 1;

        while($row = mysqli_fetch_array($result)) {
            $CartID[$i] = $row['CartID'];
            $ProductID[$i] = $row['ProductID'];
            $VariationID[$i] = $row['VariationID'];
            $Quantity[$i] = $row['Quantity'];
            $i++;
        }

        for($n = 1; $n < $i; $n++) {
            $sql = "SELECT ProductName FROM product WHERE ProductID=" . $ProductID[$n];
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
        
            $row = mysqli_fetch_array($result);
            $ProductName[$n] = $row['ProductName'];
        }

        for ($n = 1; $n < $i; $n++) {
            $sql = "SELECT VariationName, VariationImage, VariationPrice FROM variation WHERE VariationID=" . $VariationID[$n];
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
        
            $row = mysqli_fetch_array($result);
            $VariationName[$n] = $row['VariationName'];
            $VariationImage[$n] = $row['VariationImage'];
            $VariationPrice[$n] = $row['VariationPrice'];
        }


    ?>

    <div id="blank"></div>
    <div class="wrapper">
        <div class="cart">
            <h1 class="title" >Your Cart</h1>
            <form id="cart-form" action="cartBackend.php" method="POST">

                <?php 
                    if($num_rows > 0) {
                        for($n = 1; $n < $i; $n++) {
                            echo '
                            <div class="product">
                            <div class="product-img-desc">
                                <img src="uploads/'.$VariationImage[$n].'" alt="Variation Image">
                                <div class="product-name-price"> 
                                    <h5>'.$ProductName[$n].'</h5>
                                    <h5>'.$VariationName[$n].'</h5>
                                    <h5>RM '.$VariationPrice[$n].'</h5>
                                    <h5>x '.$Quantity[$n].'</h5>
                                </div>
                            </div>
                            <input type="checkbox" name="checkbox[]" value="'.$CartID[$n].'" class="form-check-input">
                            <div class="actions">
                                <input name="RemoveCartID" value="'.$CartID[$n].'" hidden>
                                <button id="removeCart" name="remove-cart" type="submit" onclick="return confirm(\'Are you sure you want to remove this cart?\')">Remove Cart</button>
                            </div>
                        </div>
                            ';
                                    
                        }

                        
                    } else {
                        echo "<h5 id='no-product'>There are no products in your cart.</h5>";
                    }
                ?>

                <div class="pay-container">
                    <button type="submit" name="cart-submit" class="pay-btn">Pay</button>
                </div>
            </form>
        </div>
    </div>
    

    <?php
        require 'footer.php';
    ?>
</body>
</html>
