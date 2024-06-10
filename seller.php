<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Seller Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/seller.css">
    <link rel="stylesheet" href="./css/footer.css?v=1">

</head>
<body>
    <?php 
        require 'navbar.php';
    ?>

    <!-- Seller Dashboard -->
    <div class="container">
        <h1 class="text-center mt-5">Seller Dashboard</h1>
        <div class="text-center mt-4">
            <a href="newProduct.php" class="btn btn-primary">Add new product</a>
        </div>
    </div>

    <?php
        require 'footer.php';
    ?>

</body>
</html>
