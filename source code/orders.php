<?php
include('auth.php');
require('database.php');

include('check_expired_orders.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS here -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
        /* Add this style to force button appearance */
        display: inline-block;
        padding: 0.5rem 1rem;
        text-decoration: none;
    }
    </style>

</head>
<body>

</header>
<main>
<div class="form">
    <div class="d-flex align-items-center justify-content-center">
            <h1 class="fw-bolder">Orders</h1>
    </div>
    <!--================Order Details Area =================-->
    <section class="section-padding">
        <div class="container">
            
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Order</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sel_query = "SELECT orders.order_id, orders.total_amount, orders.order_status
                            FROM orders
                            INNER JOIN user ON orders.user_id = user.user_id
                            WHERE user.user_id = {$_SESSION['user_id']}";
            $result = mysqli_query($con, $sel_query);
            $subtotal = 0.00;
            if (!$result) {
                die('Error fetching data: ' . mysqli_error($con));
            }
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td>
                        <a href="order_details.php?order_id=<?php echo $row['order_id'];?>"><?php echo $row['order_id']; ?></a>
                    </td>
                    <td>RM<?php echo $row["total_amount"]; ?></td>
                    <td>
                        <?php echo $row["order_status"]; ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="javascript:history.back()" class="btn btn-info">Back</a>
    <div class="float-right">
        <a href="payment_history.php" class="btn btn-info">Payment History</a>
    </div>
        </div>
    </section>
    <!--================End Order Details Area =================-->
        </div>
</main>

</body>
</html>