<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Buyer Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/cart.css?v=1">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    
</head>
<body>
    <?php 
        require 'navbar.php';
        require 'dbconnect.php';

        $sql = "SELECT ProductID, VariationID, Quantity FROM cart WHERE UserID=".$_SESSION['UserID']."";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $i = 1;

        while($row = mysqli_fetch_array($result)) {
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

    <div class="container">
        <h1 class="text-center mt-5">Your Cart</h1>
        <form id="cart-form" action="payment.php" method="POST">
            <div class="row mt-3">
                <?php 
                    if($num_rows > 0) {
                        for($n = 1; $n < $i; $n++) {
                            echo '<div class="col-12">
                            <div class="card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="uploads/'.$VariationImage[$n].'" alt="Product Image" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">'.$ProductName[$n].'</h5>
                                            <h5 class="card-title">'.$VariationName[$n].'</h5>
                                            <p class="card-text">Price: '.$VariationPrice[$n].'</p>
                                            <input type="checkbox" name="product" value="10" class="form-check-input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                                    
                        }
                    } else {
                        echo "<h1>There are no products in your cart.</h1>";
                    }
                ?>
                
                
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Pay</button>
            </div>
        </form>
    </div>

    <?php
        require 'footer.php';
    ?>
</body>
</html>
