<?php
//Use of include (file) - if the file did not exist will give notice warning but still can run
include("staff_auth.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<!-- <meta http-equiv="refresh" content="60"> -->
<title>Welcome to Staff Page</title>
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
        echo '<h1 class="fw-bolder">Welcome, ' . $_SESSION['staff_name'] . '!</h1>';
        ?>

        <!-- Navigation Links -->
        <h4>Categories:</h4>
        <a href="product_view.php" class="btn btn-info">Manage Products</a>
        <a href="orders_view.php" class="btn btn-info">Manage Orders</a>
        <a href="payment_view.php" class="btn btn-info">Manage Payments</a>

        <br>

        <?php
        echo '<a href="staff_logout.php" class="btn btn-danger mt-3">Logout</a>';
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>