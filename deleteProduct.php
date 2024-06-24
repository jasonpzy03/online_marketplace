<?php 

	require 'dbconnect.php';
    session_start();
    $productID= $_GET['productID'];

    if(empty($productID)) {
        header("Location: seller.php?error=emptyfields");
        exit();

    } else {
        
        $sql = "DELETE FROM product WHERE ProductID=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['error'] = "sqlerror";
            header("Location: editProduct.php?error=sqlerror1");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "i", $productID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "sqlerror";
                header("Location: editProduct.php?error=sqlerror2");
                exit();

            } else {

                header("Location: seller.php?delete=success");
                exit();
            }
            
            
            
        }

    }

 ?>