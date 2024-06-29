<?php
require('database.php');

// Calculate expiration time
$expire_time = date('Y-m-d H:i:s', strtotime('-12 hours'));

// Get orders that are still pending and older than the expiration time
$get_expired_orders_query = "SELECT order_id FROM orders WHERE order_status = 'Pending' AND order_date < '$expire_time'";
$expired_orders_result = mysqli_query($con, $get_expired_orders_query);

if ($expired_orders_result && mysqli_num_rows($expired_orders_result) > 0) {
    // Loop through each expired order
    echo "detected";
    while ($row = mysqli_fetch_assoc($expired_orders_result)) {
        $order_id = $row['order_id'];

        // Get items from the expired order
        $get_order_items_query = "SELECT product_id, quantity FROM order_items WHERE order_id = '$order_id'";
        $order_items_result = mysqli_query($con, $get_order_items_query);

        if ($order_items_result && mysqli_num_rows($order_items_result) > 0) {
            // Revert stock for each item in the order
            while ($item_row = mysqli_fetch_assoc($order_items_result)) {
                $product_id = $item_row['product_id'];
                $quantity = $item_row['quantity'];

                // Update stock quantity
                $update_stock_query = "UPDATE product SET product_quantity = product_quantity + $quantity WHERE product_id = $product_id";
                $update_stock_result = mysqli_query($con, $update_stock_query);

                if (!$update_stock_result) {
                    echo "Error updating stock for product ID: $product_id";
                }
            }
        }

        // Update order status to 'Expired'
        $expire_order_query = "UPDATE orders SET order_status = 'Cancelled' WHERE order_id = '$order_id'";
        $expire_order_result = mysqli_query($con, $expire_order_query);

        if (!$expire_order_result) {
            echo "Error updating order status for order ID: $order_id";
        }
    }
}
?>
