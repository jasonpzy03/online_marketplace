<?php 

	if(isset($_POST['product-submit'])) {

		require 'dbconnect.php';
		session_start();
		$productID= $_POST['productID'];
		$productname= $_POST['name'];
		$productdesc = $_POST['description'];
		$productimage = $_FILES["fileToUpload"]["name"];
		$productcategory = $_POST['category'];
        
        $variations = [];
        $variationID = [];
        $prices = [];
        $stocks = [];

        $variationIDs = $_POST['variationID'];
        $orderTotal = 0;

        foreach ($variationIDs as $varID) {
            $variationID[] = $varID;
        }

        // Get the total number of variations from the hidden input field
        $totalVariations = isset($_POST['variationCount']) ? intval($_POST['variationCount']) : 0;

        // Loop through the variations using a for loop
        for ($i = 1; $i <= $totalVariations; $i++) {
            $variationKey = "variation$i";
            $priceKey = "price$i";
            $stockKey = "stock$i";

            if (isset($_POST[$variationKey], $_POST[$priceKey], $_POST[$stockKey])) {
                $variations[] = $_POST[$variationKey];
                $prices[] = $_POST[$priceKey];
                $stocks[] = $_POST[$stockKey];
            }
        }

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

		if(empty($productname) || empty($productdesc) || empty($variations[0]) || empty($productimage) || empty($productcategory)) {
			$_SESSION['error'] = "emptyfields";
			$_SESSION['tmp_productname'] = $productname;
			$_SESSION['tmp_productdesc'] = $productdesc;
			$_SESSION['tmp_productimage'] = $productimage;
			$_SESSION['tmp_productcategory'] = $productcategory;
            header("Location: editProduct.php?productID=".$productID."&error=emptyfields");
            exit();

		} else {
			
            $sql = "UPDATE product SET ProductName=?, ProductDescription=?, ProductCategory=?, ProductImage=? WHERE ProductID=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['error'] = "sqlerror";
                header("Location: editProduct.php?error=sqlerror1");
                exit();

            } else {

                mysqli_stmt_bind_param($stmt, "ssssi", $productname, $productdesc, $productcategory, $productimage, $productID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                
                $sql = "DELETE FROM variation WHERE ProductID=$productID";
                mysqli_query($conn, $sql);

                $sql = "INSERT INTO variation(VariationID, ProductID, VariationName, VariationPrice, VariationImage, VariationStock) VALUES(?, ?, ?, ?, ?, ?)";
                
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    $_SESSION['error'] = "sqlerror";
                    header("Location: newProduct.php?error=sqlerror2");
                    exit();
    
                } else {
                    for($i = 0; $i < $totalVariations; $i++) {
                            if ($variations[$i] != null) {
                                mysqli_stmt_bind_param($stmt, "iissss", $variationID[$i], $productID, $variations[$i], $prices[$i], $productimage, $stocks[$i]);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);
                            }
                            

                    }

                    header("Location: index.php");
                    exit();
                }
                
                
                
            }

	    }

	} else {

		header("Location: editProduct.php?back=true");

		exit();

	}

 ?>