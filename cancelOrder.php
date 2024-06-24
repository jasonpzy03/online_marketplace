<?php 

	require 'dbconnect.php';
    session_start();
    $OrderID= $_GET['OrderID'];

    if(empty($OrderID)) {
        header("Location: purchases.php?error=emptyfields");
        exit();

    } else {
        
        $sql = "DELETE FROM order_details WHERE OrderID=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['error'] = "sqlerror";
            header("Location: purchases.php?error=sqlerror1");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "i", $OrderID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "sqlerror";
                header("Location: purchases.php?error=sqlerror2");
                exit();

            } else {

                header("Location: purchases.php?delete=success");
                exit();
            }
            
            
            
        }

    }

 ?>