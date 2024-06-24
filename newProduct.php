<?php 

    require 'mysession.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - New Listing</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/navbar.css?v=2">
    <link rel="stylesheet" href="css/newProduct.css?v=9">
    <link rel="stylesheet" href="./css/footer.css?v=3">

</head>
<body>
    <?php 
        require 'navbar.php';
    ?>

    <div id="blank"></div>
    <!-- New Listing Form -->
    <div class="wrapper">
        <div class="new-product">
            <h2>New Product</h2>
            <form id="new-product-form" method="POST" action="newProductBackend.php" enctype="multipart/form-data">
                <div class="input">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" minlength="10" maxlength="200" class="form-control" name="name" id="name" required>
                </div>
                <div class="input">
                    <label for="description" class="form-label">Product Description</label>
                    <textarea class="form-control" style="resize: none;" minlength="10" name="description" id="description" rows="3" required></textarea>
                </div>
                <div class="input">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" name="category" id="category" required>
                        <option value="electronics">Electronics</option>
                        <option value="clothing">Clothing</option>
                        <option value="books">Books</option>
                    </select>
                </div>
                <div class="input">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
                </div>
                <hr>
                <h4>Variation List</h4>
                <div id="variations" class="mb-3">
                    <div class="variation">
                        <div class="input">
                            <label for="variation1" class="form-label">Variation</label>
                            <input type="text" minlength="1" maxlength="50" class="form-control" name="variation1" id="variation1" required>
                        </div>
                        <div class="input">
                            <label for="price1" class="form-label">Price</label>
                            <input type="number" min="0" step="0.01" class="form-control" name="price1" id="price1" required>
                        </div>
                        <div class="input">
                            <label for="stock1" class="form-label">Stock</label>
                            <input type="number" min="0" class="form-control" name="stock1" id="stock1" required>
                        </div>
                        
                    </div>
                    <input type="hidden" name="variationCount" id="variationCount" value="1">
                    <button type="button" id="add-variation" onclick="addVariation()">Add Variation</button>
                </div>
                
                <button type="submit" name="product-submit" class="create-btn">Create Product</button>
            </form>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>

    <script>
        let variationCount = 1;

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

