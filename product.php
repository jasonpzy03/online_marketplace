<?php 

	require 'dbconnect.php';

	if(!isset($_GET['ProductID'])) {
		header("Location: index.php");
		exit();
	}
	$sql = "SELECT ProductName, ProductDescription, ProductCategory, ProductImage FROM product WHERE ProductID=?";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)) {
		header("Location: product.php?error=sqlerror");
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
		header("Location: product.php?error=sqlerror");
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
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/navbar.css?v=3">
    <link rel="stylesheet" href="css/footer.css?v=2">
    <link rel="stylesheet" href="css/product.css?v=3">
    
</head>
<body>
    <?php
        require 'navbar.php';
    ?>

    <div id="blank"></div>
    <!-- Product Details -->
    <div class="wrapper">
        <div class="container">
            <div class="img">
                <img src="uploads/<?php echo $ProductImage; ?>" width="400px" height="400px" alt="Product Image" class="product-image">
            </div>
        
        
            <div class="product-content">
                <?php 
                    echo '<h3>'.$ProductName.'</h3>';
                ?>
                <div class="price-div">
                    <?php echo '<p id="price">RM '.$VariationPrice[1].'</p>'; ?>
                </div>
    
                <form class="product-form" action="addtoCart.php" method="POST">
                    <div class="section">
                        <input type="number" name="ProductID" hidden value="<?php echo htmlspecialchars($_GET['ProductID']); ?>">
                        <label for="variation" class="form-label">Variation</label>
                        <select onchange="updateInfo()" class="form-select" name="variation" id="variation" required>
                            <?php 
                                for($n = 1; $n < $i; $n++) {
                                    echo '<option id="variation-option" value="'.$VariationID[$n].'" data-price="'.$VariationPrice[$n].'" data-stock="'.$VariationStock[$n].'"">'.$VariationName[$n].'</option>';
                                }
                            ?>
                            
                        </select>
                    </div>

                    <div class="section">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" min="1" value="1" class="form-control" name="quantity" id="quantity" required>
                        <?php echo '<p id="stock">'.$VariationStock[1].' stocks available.</p>';?>
                    </div>
                    
                    <button tyoe="submit" name="add-to-cart" class="add-btn">Add to Cart</button>
                </form>
                
            </div>
        </div>
        <div class="container">
            <h4>Product Description</h4>
            <?php
                echo '<p id="description">'.$ProductDescription.'</p>';
                    
            ?>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>

    <script>
        function updateInfo() {
            var select = document.getElementById("variation");
            var selectedOption = select.options[select.selectedIndex];
            var price = selectedOption.getAttribute("data-price");
            var stock = selectedOption.getAttribute("data-stock");
            document.getElementById('price').innerHTML = 'RM ' + price;
            document.getElementById('stock').innerHTML = stock + ' stocks available.';
        }
    </script>
</body>
</html>
