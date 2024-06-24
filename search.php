<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastMinute - Search Results</title>
    <link rel="stylesheet" href="css/styles.css?v=2">
    <link rel="stylesheet" href="css/navbar.css?v=2">
    <link rel="stylesheet" href="css/homepage.css?v=2">
    <link rel="stylesheet" href="css/footer.css?v=2">
    <link rel="stylesheet" href="css/search.css?v=5">

</head>
<body>
   <?php 
        require 'navbar.php';
        require 'dbconnect.php';
        $keyword = $_GET['keyword'];

        if (!empty($_GET['category'])) {
            $category = $_GET['category'];
            $sql = "SELECT ProductID, ProductName, ProductImage FROM product WHERE ProductName LIKE '%".$keyword."%' AND ProductCategory='".$category."'";

        } else {
            $sql = "SELECT ProductID, ProductName, ProductImage FROM product WHERE ProductName LIKE '%".$keyword."%'";
        }
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $i = 1;

        while($row = mysqli_fetch_array($result)) {
            $ProductIDs[$i] = $row['ProductID'];
            $i++;
        }

        $j = 1;
        for ($n = 1; $n < $i; $n++) {
            
            if (!empty($_GET['min']) && !empty($_GET['max'])) {
                $min = $_GET['min'];
                $max = $_GET['max'];
                $sql = "SELECT * FROM variation WHERE ProductID=".$ProductIDs[$n]." AND VariationPrice BETWEEN $min AND $max";

            } else if (!empty($_GET['min'])) {
                $min = $_GET['min'];
                $sql = "SELECT * FROM variation WHERE ProductID=".$ProductIDs[$n]." AND VariationPrice >= $min";
            } else if (!empty($_GET['max'])) {
                $max = $_GET['max'];
                $sql = "SELECT * FROM variation WHERE ProductID=".$ProductIDs[$n]." AND VariationPrice <= $max";
            } else {
                $sql = "SELECT * FROM variation WHERE ProductID=".$ProductIDs[$n];
            }
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $VariationPrice[$j] = $row['VariationPrice'];
                $ProductID[$j] = $row['ProductID'];
                $j++;
            }    
        }

        if ($j > 0) {
            for ($n = 1; $n < $j; $n++) {
                $sql = "SELECT ProductID, ProductName, ProductImage FROM product WHERE ProductID=".$ProductID[$n];
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    $ProductName[$n] = $row['ProductName'];
                    $ProductImage[$n] = $row['ProductImage'];
                }
            }
        }
   ?>

</div>

    <div id="blank"></div>
    <!-- Main Content -->
    <div class="wrapper">
        <div class="container">
            <form action="search.php" class="search-filter" method="GET">
            <h3 class="filter-title">Search Filters</h3>
                <?php echo '<input hidden type="text" name="keyword" value="'.$_GET['keyword'].'">'; ?>

                    <!-- Price range -->
                    <div class="filter-group">
                        <h5>Price range:</h5>
                        
                        <input type="number" min="1" step="0.01" id="min-price" name="min" placeholder="Min" value="<?php if(isset($_GET['min'])) echo $_GET['min'];?>">
                        <input type="number" min="1" step="0.01" id="max-price" name="max" placeholder="Max" value="<?php if(isset($_GET['max'])) echo $_GET['max'];?>">

                    </div>
                    <!-- Payment option -->
                    <div class="filter-group">
                        <h5>Category:</h5>
                        <div>
                            <input <?php if(isset($_GET['category']) && $_GET['category']=="electronics") echo 'checked'; ?> type="radio" id="electronics" name="category" value="electronics">
                            <label for="electronics">Electronics</label>
                        </div>
                        <div>
                            <input <?php if(isset($_GET['category']) && $_GET['category']=="clothing") echo 'checked'; ?> type="radio" id="clothing" name="category" value="clothing">
                            <label for="clothing">Clothing</label>
                        </div>
                        <div>
                            <input <?php if(isset($_GET['category']) && $_GET['category']=="books") echo 'checked'; ?> type="radio" id="books" name="category" value="books">
                            <label for="books">Books</label>
                        </div>
                    </div>
                    <button class="apply-btn" type="submit">Apply</button>
            </form>
            <div class="search-result">
                <?php echo '<h3>Search result for "'.$_GET['keyword'].'"</h3>'; ?>

                <div id="product-grid">
                    <?php 

                        if($num_rows > 0) {
                            for($n = 1; $n < $j; $n++) {
                                echo "<a href='product.php?ProductID=". $ProductID[$n] ."'>
                                <div class='product-card'>
                                        <div id='product-card-img'>
                                            <img src='uploads/".$ProductImage[$n]."' alt='Product Image'>
                                        </div>
                                        <div class='product-card-wrapper'>
                                            <p id='product-name'>" . $ProductName[$n] . "</p>
                                            <p id='product-price'>RM " . $VariationPrice[$n] . "</p>
                                        </div>
                                </div>
                            </a>";
                                        
                            }
                        } else {
                            echo "<h5 id='no-product'>There are no products available at the moment.</h5>";
                        }

                    ?>
                    
                </div>

            </div>
        </div>
    </div>

    <?php 
        require 'footer.php';
    ?>
</body>
</html>
