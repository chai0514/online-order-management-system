<?php
require ('database.php');

if (isset ($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);

    $query = "SELECT * FROM product WHERE product_name LIKE '%$search%'";
    $result = mysqli_query($con, $query) or die (mysqli_error($con));
}

// Sorting functionality
$sort = isset ($_GET['sort']) ? $_GET['sort'] : ''; 
switch ($sort) {
    case 'low_to_high':
        $query .= " ORDER BY product_price ASC";
        break;
    case 'high_to_low':
        $query .= " ORDER BY product_price DESC";
        break;
    case 'a_to_z':
        $query .= " ORDER BY product_name ASC";
        break;
    case 'z_to_a':
        $query .= " ORDER BY product_name DESC";
        break;
    default:
        // Default sorting order
        $query .= " ORDER BY product_name ASC";
        break;
}
$result = mysqli_query($con, $query) or die (mysqli_error($con));

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Search Results</title>
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
</style>

<body>
    <div class="container">
    <a href="index.php" class="btn btn-info mb-3">Back to Main Page</a>

        <!-- Search Bar -->
        <form action="search_results.php" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="search" name="search" placeholder="Enter product name">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Sorting Options -->
        <div class="dropdown pt-2 pb-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                Sort by
            </button>
            <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                <li><a class="dropdown-item"
                        href="search_results.php?search=<?php echo $search; ?>&sort=low_to_high">Price: Low to High</a>
                </li>
                <li><a class="dropdown-item"
                        href="search_results.php?search=<?php echo $search; ?>&sort=high_to_low">Price: High to Low</a>
                </li>
                <li><a class="dropdown-item" href="search_results.php?search=<?php echo $search; ?>&sort=a_to_z">Name: A
                        to Z</a></li>
                <li><a class="dropdown-item" href="search_results.php?search=<?php echo $search; ?>&sort=z_to_a">Name: Z
                        to A</a></li>
            </ul>
        </div>

        <h1 class="fw-bolder">Search Results</h1>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Display search results
                ?>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo $row['product_image']; ?>" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="col-md-8">
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
                </div>
                <?php
            }
        } else {
            // Display message if no results found
            echo '<p>No results found.</p>';
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>