<?php 

	if(isset($_POST['product-submit'])) {

		require 'dbconnect.php';
		session_start();
		$productname = $_POST['name'];
		$productdesc = $_POST['description'];
		$variationname = $_POST['variation'];
		$variationprice = $_POST['price'];
		$productimage = $_FILES["fileToUpload"]["name"];
		$productcategory = $_POST['category'];
		$variationstock = $_POST['stock'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["product-submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        }

		if(empty($productname) || empty($productdesc) || empty($variationname) || empty($variationprice) || empty($productimage) || empty($productcategory) || empty($variationstock)) {
			$_SESSION['error'] = "emptyfields";
			$_SESSION['tmp_productname'] = $productname;
			$_SESSION['tmp_productdesc'] = $productdesc;
			$_SESSION['tmp_productvariation'] = $variationname;
			$_SESSION['tmp_productprice'] = $variationprice;
			$_SESSION['tmp_variationstock'] = $variationstock;
			$_SESSION['tmp_productimage'] = $productimage;
			$_SESSION['tmp_productcategory'] = $productcategory;
            header("Location: newProduct.php?error=emptyfields");
            exit();

		} else {
			
            $sql = "INSERT INTO product(ProductName, ProductDescription, ProductCategory, ProductImage) VALUES(?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "sqlerror";
                header("Location: newProduct.php?error=sqlerror1");
                exit();

            } else {

                mysqli_stmt_bind_param($stmt, "ssss", $productname, $productdesc, $productcategory, $productimage);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $productid = mysqli_stmt_insert_id($stmt);
                
                $sql = "INSERT INTO variation(ProductID, VariationName, VariationPrice, VariationImage, VariationStock) VALUES(?, ?, ?, ?, ?)";
                
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    $_SESSION['error'] = "sqlerror";
                    header("Location: newProduct.php?error=sqlerror2");
                    exit();
    
                } else {
                    mysqli_stmt_bind_param($stmt, "issss", $productid, $variationname, $variationprice, $productimage, $variationstock);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    header("Location: index.php");
                    exit();
                    
                }
                
            }

	    }

	} else {

		header("Location: newProduct.php?back=true");

		exit();

	}

 ?>