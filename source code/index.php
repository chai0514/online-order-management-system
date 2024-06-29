<?php
session_start(); // Start session
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome to Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Courier New', Courier, monospace;
    }


    .form {
        margin: 50px;
        padding: 20px;
        border: 1px solid #c8ced3;
        border-radius: 10px;
        background-color: #fff;
    }

    .btn-link {
        display: inline-block;
        padding: 0.5rem 1rem;
        text-decoration: none;
    }
</style>

<body>
    <div class="form">
        <?php
        if (isset ($_SESSION['username'])) {
            // If user logged in
            echo '<h1 class="fw-bolder">Welcome, ' . $_SESSION['username'] . '!</h1>';
        } else {
            // If user not logged in
            echo '<h1 class="fw-bolder">Welcome, guest!</h1>';
        }
        ?>
        <!-- Search Bar -->
        <form action="search_results.php" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="search" name="search" placeholder="Enter product name">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Navigation Links -->
        <h4>Categories:</h4>
        <a href="orders.php" class="btn btn-info">Orders</a>
        <a href="product_page.php" class="btn btn-info">Product Page</a>
        <a href="cart.php" class="btn btn-info">Shopping Cart</a>

        <br>

        <?php
        if (isset ($_SESSION['username'])) {
            // If user logged in
            echo '<a href="logout.php" class="btn btn-danger mt-3">Logout</a>';
        } else {
            // If user not logged in
            echo '<a href="login.php" class="btn btn-danger mt-3">Login</a>';
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>