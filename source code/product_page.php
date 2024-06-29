<?php
require ('database.php');

// Fetch all products from database
$query = "SELECT * FROM product ORDER BY product_name ASC";
$result = mysqli_query($con, $query) or die (mysqli_error($con));

// Fetch distinct categories from database
$category_query = "SELECT DISTINCT product_category FROM product ORDER BY product_name ASC";
$category_result = mysqli_query($con, $category_query) or die (mysqli_error($con));
$categories = mysqli_fetch_all($category_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Product Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Courier New', Courier, monospace;
    }

    .container {
        margin-top: 50px;
    }

    .product-card {
        max-width: 540px;
        height: 100%;
        padding: 20px;
    }

    .card-body {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
</style>

<body>

    <div class="container pb-3">
    <a href="index.php" class="btn btn-info mb-2">Back to Main Page</a>
        <h1 class="fw-bolder">Product Page</h1>
        <!-- Filter -->
        <div class="btn-group mb-3">
            <button class="btn btn-primary filter-btn" data-category="all">All</button>
            <?php foreach ($categories as $category): ?>
                <button class="btn btn-primary filter-btn" data-category="<?php echo $category['product_category']; ?>">
                    <?php echo $category['product_category']; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Product -->
        <div class="row" id="product-container">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 product-column" data-category="<?php echo $row['product_category']; ?>">
                    <div class="card product-card">
                        <img src="<?php echo $row['product_image']; ?>" alt="Product Image" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $row['product_name']; ?>
                            </h5>
                            <p class="card-text">
                                Price:
                                <?php echo $row['product_price']; ?><br>
                                Stock:
                                <?php echo $row['product_quantity']; ?><br>
                                Category:
                                <?php echo $row['product_category']; ?>
                            </p>
                            <!-- Add to Cart button -->
                            <a href="process_cart.php?add_to_cart=<?php echo $row['product_id']; ?>"
                                class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get filter buttons
        var filterButtons = document.querySelectorAll('.filter-btn');

        // Add click event listener to filter button
        filterButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var category = this.getAttribute('data-category');

                // Filter products based on selected category
                var productContainer = document.getElementById('product-container');
                var productColumns = productContainer.querySelectorAll('.product-column');
                
                productColumns.forEach(function (column) {
                    var columnCategory = column.getAttribute('data-category');
                    if (category === 'all' || columnCategory === category) {
                        column.style.display = 'block';
                    } else {
                        column.style.display = 'none';
                    }
                });

                // Reflow product cards to update layout
                reflowProductCards(productContainer);
            });
        });

        // Reflow product cards layout
        function reflowProductCards(container) {
            var visibleColumns = Array.from(container.querySelectorAll('.product-column'));
            var count = 0;
            visibleColumns.forEach(function (column) {
                if (column.style.display !== 'none') {
                    column.style.order = count++;
                }
            });
        }
    });
    </script>

</body>

</html>