<?php 

    require 'mysession.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Purchases</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/purchases.css?v=7">
    <link rel="stylesheet" href="css/navbar.css?v=4">
    <link rel="stylesheet" href="css/footer.css?v=4">
    
</head>
<body>
    <?php 
        require 'navbar.php';
        require 'dbconnect.php';

        $sql = "SELECT * FROM order_items WHERE UserID=".$_SESSION['UserID']."";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $i = 1;

        while($row = mysqli_fetch_array($result)) {
            $OrderID[$i] = $row['OrderID'];
            $ProductID[$i] = $row['ProductID'];
            $VariationID[$i] = $row['VariationID'];
            $Quantity[$i] = $row['Quantity'];
            $i++;
        }

        for($n = 1; $n < $i; $n++) {
            $sql = "SELECT OrderTotal FROM order_details WHERE OrderID=" . $OrderID[$n];
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $OrderTotal[$n] = $row['OrderTotal'];
        }

        for ($n = 1; $n < $i; $n++) {
            $sql = "SELECT * FROM variation WHERE VariationID=" . $VariationID[$n];
            $result = mysqli_query($conn, $sql);
        
            $row = mysqli_fetch_array($result);
            $VariationName[$n] = $row['VariationName'];
            $VariationImage[$n] = $row['VariationImage'];
            $VariationPrice[$n] = $row['VariationPrice'];
        }

        for ($n = 1; $n < $i; $n++) {
            $sql = "SELECT * FROM product WHERE ProductID=" . $ProductID[$n];
            $result = mysqli_query($conn, $sql);
        
            $row = mysqli_fetch_array($result);
            $ProductName[$n] = $row['ProductName'];
            $ProductImage[$n] = $row['ProductImage'];
        }


    ?>

    <div id="blank"></div>
    <div class="wrapper">
    <div class="purchases">
        <h1 class="title">Your Purchases</h1>

            <?php 
                if($num_rows > 0) {
                    for($n = 1; $n < $i; $n++) {
                        echo '<form action="cancelOrder.php" method="GET"><div class="product">
                        <div class="product-img-desc">
                            <img src="uploads/'.$VariationImage[$n].'" alt="Variation Image">
                            <div class="product-name-price"> 
                                <h5>'.$ProductName[$n].'</h5>
                                <h5>'.$VariationName[$n].'</h5>
                                <h5>RM '.$VariationPrice[$n].'</h5>
                                <h5>x '.$Quantity[$n].'</h5>
                            </div>
                        </div>
                        
                        <div class="actions">
                            <input name="OrderID" value="'.$OrderID[$n].'" hidden>
                            <button type="submit" id="cancelOrder" onclick="return confirm(\'Are you sure you want to cancel this order?\')">Cancel Order</button>
                        </div>
                    </div>
                    </form>';
                                
                    }

                    
                } else {
                    echo "<h5 id='no-order'>You have no existing orders.</h5>";
                }
            ?>

    </div>
    </div>
    

    <?php
        require 'footer.php';
    ?>
</body>
</html>
