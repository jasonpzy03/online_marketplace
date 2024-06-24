<?php 

    require 'mysession.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Edit Product</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/navbar.css?v=2">
    <link rel="stylesheet" href="css/newProduct.css?v=4">
    <link rel="stylesheet" href="./css/footer.css?v=2">

</head>
<body>
    <?php 
        require 'navbar.php';
        require 'dbconnect.php';

        $sql = "SELECT * FROM product WHERE ProductID=".$_GET['productID']."";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);

        $row = mysqli_fetch_array($result);
        $ProductID = $row['ProductID'];
        $ProductName = $row['ProductName'];
        $ProductDescription = $row['ProductDescription'];
        $ProductCategory = $row['ProductCategory'];
        $ProductImage = $row['ProductImage'];
        
        $sql = "SELECT * FROM variation WHERE ProductID=".$_GET['productID']."";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $i = 1;
        while($row = mysqli_fetch_array($result)) {
            $VariationID[$i] = $row['VariationID'];
            $VariationName[$i] = $row['VariationName'];
            $VariationPrice[$i] = $row['VariationPrice'];
            $VariationStock[$i] = $row['VariationStock'];
            $i++;
        }

    ?>

    <div id="blank"></div>
    <div class="wrapper">
        <div class="new-product">
        <h2>Edit Product</h2>
        <form id="new-product-form" method="POST" action="editProductBackend.php" enctype="multipart/form-data">
            <div class="input">
                <label for="name" class="form-label">Product Name</label>
                <?php echo'<input type="text" minlength="10" maxlength="200" class="form-control" name="name" id="name" value ="'.$ProductName.'" required>'; ?>
            </div>
            <div class="input">
                <label for="description" class="form-label">Product Description</label>
                <?php echo'<textarea style="resize: none;" class="form-control" minlength="10" name="description" id="description" rows="3" required>'.$ProductDescription.'</textarea>'; ?>
            </div>
            <div class="input">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" id="category" required>
                    <option value="electronics" <?php if ($ProductCategory == 'electronics') echo 'selected'; ?>>Electronics</option>
                    <option value="clothing" <?php if ($ProductCategory == 'clothing') echo 'selected'; ?>>Clothing</option>
                    <option value="books" <?php if ($ProductCategory == 'books') echo 'selected'; ?>>Books</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            <div class="input">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
            </div>
            <h5>Variation List</h5>
            <div id="variations">
                
                    <?php 
                        if($num_rows > 0) {
                            for($n = 1; $n < $i; $n++) {
                                echo '<div class="variation">
                                <input type="hidden" name="variationID[]" value="'.$VariationID[$n].'" required>
                                <div class="input">
                                    <label for="variation'.$n.'" class="form-label">Variation</label>
                                    <input type="text" minlength="1" maxlength="50" class="form-control" name="variation'.$n.'" value="'.$VariationName[$n].'" id="variation'.$n.'" required>
                                </div>
                                <div class="input">
                                    <label for="price'.$n.'" class="form-label">Price</label>
                                    <input type="number" min="0" step="0.01" class="form-control" name="price'.$n.'" value="'.$VariationPrice[$n].'" id="price'.$n.'" required>
                                </div>
                                <div class="input">
                                    <label for="stock'.$n.'" class="form-label">Stock</label>
                                    <input type="number" min="0" class="form-control" name="stock'.$n.'" value="'.$VariationStock[$n].'" id="stock'.$n.'" required>
                                </div>';
                                if ($n != 1) {
                                    echo '<button type="button" id="remove-variation" onclick="removeVariation('.$n.')"><img src="icons/dustbin.png" width="20px" height="20px" alt=""></button>';
                                }
                                echo '</div>';
                                
                            }
                            
                        }
                        echo '<input type="hidden" name="productID" id="productID" value="'.$_GET['productID'].'">';
                    ?>
                <input type="hidden" name="variationCount" id="variationCount" value="<?php echo $num_rows; ?>">
                <button type="button" id="add-variation" onclick="addVariation()">Add Variation</button>
            </div>
            
            <button type="submit" name="product-submit" class="create-btn">Update Product</button>
        </form>
        </div>
        
    </div>

    <?php
        require 'footer.php';
    ?>

    <script>
        let variationCount = <?php echo json_encode($num_rows); ?>;

        function addVariation() {
            variationCount++;

            const newVariation = document.createElement('div');
            newVariation.className = 'variation';

            newVariation.innerHTML = `
                <div class="input">
                    <label for="variation${variationCount}" class="form-label">Variation</label>
                    <input type="text" class="form-control" minlength="1" maxlength="50" name="variation${variationCount}" id="variation${variationCount}" required>
                </div>
                <div class="input">
                    <label for="price${variationCount}" class="form-label">Price</label>
                    <input type="number" class="form-control" min="0" step="0.01" name="price${variationCount}" id="price${variationCount}" required>
                </div>
                <div class="input">
                    <label for="stock${variationCount}" class="form-label">Stock</label>
                    <input type="number" class="form-control" min="0" name="stock${variationCount}" id="stock${variationCount}" required>
                </div>
                <button type="button" id="remove-variation" onclick="removeVariation(${variationCount})"><img src="icons/dustbin.png" width="20px" height="20px" alt=""></button>
            `;

            if (variationCount == 1) {
                newVariation.innerHTML = `
                <div class="input">
                    <label for="variation${variationCount}" class="form-label">Variation</label>
                    <input type="text" class="form-control" minlength="1" maxlength="50" name="variation${variationCount}" id="variation${variationCount}" required>
                </div>
                <div class="input">
                    <label for="price${variationCount}" class="form-label">Price</label>
                    <input type="number" class="form-control" min="0" step="0.01" name="price${variationCount}" id="price${variationCount}" required>
                </div>
                <div class="input">
                    <label for="stock${variationCount}" class="form-label">Stock</label>
                    <input type="number" class="form-control" min="0" name="stock${variationCount}" id="stock${variationCount}" required>
                </div>
            `;
            }

            const variationsContainer = document.getElementById('variations');
            const addButton = document.getElementById('add-variation');

            variationsContainer.insertBefore(newVariation, addButton);

            // Update the hidden input field with the new variation count
            document.getElementById('variationCount').value = variationCount;
        }

        function removeVariation(id) {
            const variation = document.getElementById(`variation${id}`);
            if (variation) {
                const parentDiv = variation.parentElement;
                if (parentDiv) {
                    const grandparentDiv = parentDiv.parentElement;
                    if (grandparentDiv) {
                        grandparentDiv.remove();
                    }
                }
            }
        }
    </script>
</body>
</html>

