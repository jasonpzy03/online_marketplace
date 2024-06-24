<?php 

	if(isset($_POST['cart-submit'])) {

		require 'dbconnect.php';
		session_start();
		if (isset($_POST['checkbox'])) {
            $selectedCart = $_POST['checkbox'];
            $orderTotal = 0;

            foreach ($selectedCart as $cart) {
                $sql = "SELECT * FROM cart WHERE CartID=$cart";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $orderTotal += $row['CartTotal'];
            }
            
            $currentDateTime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO order_details(UserID, OrderTotal, created_at) VALUES(?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "sqlerror";
                header("Location: cart.php?error=sqlerror1");
                exit();

            } else {
                
                mysqli_stmt_bind_param($stmt, "ids", $_SESSION['UserID'], $orderTotal, $currentDateTime);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $orderID = mysqli_stmt_insert_id($stmt);

                foreach ($selectedCart as $cart) {
                    $sql = "SELECT * FROM cart WHERE CartID=$cart";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

                    $sql = "INSERT INTO order_items(OrderID, ProductID, VariationID, Quantity, UserID, created_at) VALUES(?, ?, ?, ?, ?, ?)";
                
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        $_SESSION['error'] = "sqlerror";
                        header("Location: cart.php?error=sqlerror2");
                        exit();
        
                    } else {
                        
                        mysqli_stmt_bind_param($stmt, "iiiiis", $orderID, $row['ProductID'], $row['VariationID'], $row['Quantity'], $_SESSION['UserID'], $currentDateTime);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        
                        $sql = "DELETE FROM cart WHERE CartID=$cart";
                        mysqli_query($conn, $sql);
                    }
        
                }

                header("Location: purchases.php");
                exit();
 
            }
            
        } else {
            header("Location: cart.php?error=emptyfields");
		    exit();
        }

	} else if(isset($_POST['remove-cart'])) {
        require 'dbconnect.php';
        session_start();
        $CartID= $_POST['RemoveCartID'];

        if(empty($CartID)) {
            header("Location: cart.php?error=emptyfields");
            exit();

        } else {
            
            $sql = "DELETE FROM cart WHERE CartID=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "sqlerror";
                header("Location: cart.php?error=sqlerror1");
                exit();

            } else {

                mysqli_stmt_bind_param($stmt, "i", $CartID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    $_SESSION['error'] = "sqlerror";
                    header("Location: cart.php?error=sqlerror2");
                    exit();

                } else {

                    header("Location: cart.php?delete=success");
                    exit();
                }
                
                
                
            }

        }

    } else {

		header("Location: cart.php?back=true");

		exit();

	}

 ?>