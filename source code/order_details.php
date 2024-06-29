<?php
include('auth.php');
require('database.php');

include('check_expired_orders.php');

// Check if user is logged in and if order_id is provided via GET parameter or session
if (isset($_SESSION['user_id']) && isset($_GET['order_id'])) {
    $order_id = mysqli_real_escape_string($con, $_GET['order_id']);

    // Query to fetch order details along with user_id
    $query = "SELECT order_id, user_id 
              FROM orders
              WHERE orders.order_id = '$order_id'";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
        
        // Check if the logged-in user matches the user_id in the order
        if ($order['user_id'] != $_SESSION['user_id']) {
            echo "Unauthorized access! You are not allowed to view this order.";
            exit();
        }
    } else {
        echo "Order not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    header("Location: index.php");
    exit();
}

// Cancel Order Logic
if (isset($_POST['cancel_order'])) {
    // Begin transaction for atomic operations
    mysqli_begin_transaction($con);

    // Update order status to 'Cancelled'
    $cancel_order_query = "UPDATE orders SET order_status = 'Cancelled' WHERE order_id = '$order_id'";
    $cancel_order_result = mysqli_query($con, $cancel_order_query);

    // Revert stock for items in the cancelled order
    $revert_stock_query = "UPDATE product 
                           INNER JOIN order_items ON product.product_id = order_items.product_id
                           SET product.product_quantity = product.product_quantity + order_items.quantity
                           WHERE order_items.order_id = '$order_id'";
    $revert_stock_result = mysqli_query($con, $revert_stock_query);

    if ($cancel_order_result && $revert_stock_result) {
        // Commit transaction if both queries succeed
        mysqli_commit($con);
    } else {
        // Rollback transaction if any query fails
        mysqli_rollback($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Order Details</title>
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
<main>
<div class="form">
    <div class="d-flex align-items-center justify-content-center">
            <h1 class="fw-bolder">Order: <?php echo $order_id;?></h1>
    </div>
    <!--================Order Details Area =================-->
    <section class="section-padding">
        <div class="container">
            
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sel_query = "SELECT product.product_name, order_items.price, product.product_image, order_items.quantity
                            FROM order_items 
                            INNER JOIN product ON order_items.product_id = product.product_id
                            WHERE order_items.order_id = '$order_id'";
            $result = mysqli_query($con, $sel_query);
            $subtotal = 0.00;
            if (!$result) {
                die('Error fetching data: ' . mysqli_error($con));
            }
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td align="center">
                        <div class="media">
                            <div class="d-flex"><img src="<?php echo $row['product_image']; ?>" alt="image" style="max-width: 100px; max-height: 100px;"/></div>
                            <div class="media-body">
                                <p><?php echo $row['product_name']; ?></p>
                            </div>
                        </div>
                    </td>
                    <td>RM<?php echo $row["price"]; ?></td>
                    <td>
                        <?php echo $row["quantity"]; ?>
                    </td>
                    <td>RM<?php echo sprintf("%.2f", $row["price"] * $row["quantity"]); ?></td>
                </tr>
            <?php
            $subtotal += $row["price"] * $row["quantity"];
            }
            ?>
            <tr>
                <td colspan="2"></td>
                <td><h5>Subtotal</h5></td>
                <td><h5>RM<?php echo sprintf("%.2f", $subtotal);?></h5></td>
            </tr>
        </tbody>
    </table>
    <?php
        $order_query = "SELECT order_date, order_status, total_amount
        FROM orders
        WHERE order_id = '$order_id'";
        $result = mysqli_query($con, $order_query);
        $row = mysqli_fetch_assoc($result);
        echo "Order Date: " . $row['order_date'];
        echo "<br>Status: " . $row['order_status'];
        if($row['order_status'] == 'Pending'){
            $new_date = date('Y-m-d H:i:s', strtotime($row['order_date'] . ' +12 hours'));
            echo " <span style='color: #FF0616;'>(Expired after $new_date)</span>";
        }
    ?>
    <br>
    <a href="javascript:history.back()" class="btn btn-info">Back</a>
    <div class="float-right">
        <?php if($row['order_status'] == 'Pending'){ ?>
            <form method="post">
                <input type="hidden" name="cancel_order" value="1">
                <button type="submit" class="btn btn-danger">Cancel Order</button>
            
        <?php echo '  <a class="btn btn-primary" href="payment.php?order_id=' . $order_id . '">Proceed to Payment</a></form>';
        } ?>
    </div>

        </div>
    </section>
    <!--================End Order Details Area =================-->
    </div>
</main>

</body>
</html>