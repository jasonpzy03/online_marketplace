<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - New Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/newProduct.css">
    <link rel="stylesheet" href="./css/footer.css?v=1">

</head>
<body>
    <?php 
        require 'navbar.php';
    ?>

    <!-- New Listing Form -->
    <div class="container mt-5">
        <h1 class="text-center">New Product</h1>
        <form id="new-listing-form" method="POST" action="newProductBackend.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="variation" class="form-label">Variation</label>
                <input type="text" class="form-control" name="variation" id="variation" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" name="price" id="price" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" name="stock" id="stock" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category" id="category" required>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="books">Books</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
            </div>
            <button type="submit" name="product-submit" class="btn btn-primary">Create Product</button>
        </form>
    </div>

    <?php
        require 'footer.php';
    ?>
</body>
</html>

