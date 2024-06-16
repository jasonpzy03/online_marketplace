<?php 

	if(isset($_POST['add-to-cart'])) {

		require 'dbconnect.php';
		session_start();
		$variationID = $_POST['variation'];
		$productID = $_POST['ProductID'];
		$quantity = $_POST['quantity'];

		if(empty($variationID) || empty($quantity)) {
			$_SESSION['error'] = "emptyfields";
            header("Location: product.php?ProductID=".$productID."");
            exit();

		} 
            $sql = "INSERT INTO cart(UserID, ProductID, VariationID, Quantity) VALUES(?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "sqlerror";
                header("Location: product.php?ProductID=".$productID."");
                exit();

            } else {
                
                mysqli_stmt_bind_param($stmt, "iiis", $_SESSION['UserID'], $productID, $variationID, $quantity);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $_SESSION['registration'] = "success";
                header("Location: cart.php");
                exit();
            }
				

	} else {

		header("Location: register.php");

		exit();

	}

 ?>