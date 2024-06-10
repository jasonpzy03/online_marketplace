<?php 

	include("mysession.php");
	require 'dbconnect.php';

	if(!isset($_GET['ProductID'])) {
		header("Location: index.php");
		exit();
	}
	$sql = "SELECT ProductName, ProductDescription, ProductCategory, ProductImage FROM product WHERE ProductID=?";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: booknow.php?error=sqlerror");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "i", $_GET['ProductID']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$ProductName = $row['ProductName'];
				$ProductDescription = $row['ProductDescription'];
				$ProductCategory = $row['ProductCategory'];
				$ProductImage = $row['ProductImage'];
			}
		} else {
			header("Location: index.php");
			exit();
		}
	}

    $sql = "SELECT VariationID, VariationName, VariationPrice, VariationImage, VariationStock FROM variation WHERE ProductID=?";
	$stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: booknow.php?error=sqlerror");
		exit();
	} else {
		mysqli_stmt_bind_param($stmt, "i", $_GET['ProductID']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
        $i = 1;
		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$VariationID[$i] = $row['VariationID'];
				$VariationName[$i] = $row['VariationName'];
				$VariationPrice[$i] = $row['VariationPrice'];
				$VariationImage[$i] = $row['VariationImage'];
				$VariationStock[$i] = $row['VariationStock'];
                $i += 1;
			}
		} else {
			header("Location: index.php");
			exit();
		}
	}
	
 ?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    
    <style>
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }
        .product-image {
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php
        require 'navbar.php';
    ?>

    <!-- Product Details -->
    <div class="container mt-5">
        <?php 
            echo '<h1 class="text-center">'.$ProductName.'</h1>';
        ?>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="uploads/<?php echo $ProductImage; ?>" alt="Product Image" class="product-image">
            </div>
            <div class="col-md-6">
                <?php
                    echo '<p>Description: '.$ProductDescription.'</p>
                    <p>Price: RM '.$VariationPrice[1].'</p>
                    <p>Stock: '.$VariationStock[1].'</p>';
                ?>
                
                <form action="addtoCart.php" method="POST">
                    <div class="mb-3">
                        <input type="number" name="ProductID" hidden value="<?php echo htmlspecialchars($_GET['ProductID']); ?>">
                        <label for="variation" class="form-label">Variation</label>
                        <select class="form-select" name="variation" id="variation" required>
                            <?php 
                                for($n = 1; $n < $i; $n++) {
                                    echo '<option value="'.$VariationID[$n].'">'.$VariationName[$n].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" required>
                    </div>
                    
                    <button tyoe="submit" name="add-to-cart" class="btn btn-primary">Add to Cart</button>
                </form>
                
            </div>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>
</body>
</html>
