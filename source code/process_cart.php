<?php
include('auth.php');
require('database.php');

// Add to cart logic
if (isset($_GET['add_to_cart'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['add_to_cart']);
    $user_id = $_SESSION['user_id'];

    // Check if the product is already in the cart for the user
    $check_cart_query = "SELECT * FROM cart_items WHERE user_id = $user_id AND product_id = $product_id";
    $check_cart_result = mysqli_query($con, $check_cart_query);

    if ($check_cart_result && mysqli_num_rows($check_cart_result) > 0) {
        // Product already exists in cart, update quantity
        $update_quantity_query = "UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
        $update_quantity_result = mysqli_query($con, $update_quantity_query);

        if (!$update_quantity_result) {
            echo "Error updating quantity in cart.";
            exit();
        }
    } else {
        // Product not in cart, insert new cart item
        $insert_cart_query = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
        $insert_cart_result = mysqli_query($con, $insert_cart_query);

        if (!$insert_cart_result) {
            echo "Error adding product to cart.";
            exit();
        }
    }

    header("Location: cart.php");
    exit();
}

// Item quantity updates
if (isset($_POST['update_quantity']) && isset($_POST['item_quantity'])) {
    // Check stock quantity before updating item quantities in the cart
    $item_quantities = $_POST['item_quantity']; // Array of item IDs and their requested quantities

    foreach ($item_quantities as $cart_item_id => $quantity) {
        $cart_item_id = mysqli_real_escape_string($con, $cart_item_id);
        $quantity = intval($quantity);

        // Get current stock quantity for the item
        $stock_query = "SELECT product.product_quantity, product.product_name FROM cart_items 
                        INNER JOIN product ON cart_items.product_id = product.product_id 
                        WHERE cart_item_id = $cart_item_id";
        $stock_result = mysqli_query($con, $stock_query);

        if ($stock_result && mysqli_num_rows($stock_result) > 0) {
            $stock_row = mysqli_fetch_assoc($stock_result);
            $current_stock = intval($stock_row['product_quantity']);

            // Check if requested quantity exceeds available stock
            if ($quantity > $current_stock) {
                // Redirect back to cart with an error message
                header("Location: cart.php?error=stock&item_name={$stock_row['product_name']}");
                exit();
            }
        }

        // Update quantity in the cart if stock is available
        $update_query = "UPDATE cart_items SET quantity = $quantity WHERE cart_item_id = $cart_item_id";
        $update_result = mysqli_query($con, $update_query);

        if (!$update_result) {
            // Redirect back to cart with an error message
            header("Location: cart.php?error=update&item_name={$stock_row['name']}");
            exit();
        }
    }
    // Redirect back to cart page if no errors occurred during quantity update
    header("Location: cart.php");
    exit();
}

else if (isset($_POST['order']) && isset($_POST['selected_items'])) {
    // Proceed with order and payment process
    $selected_items = $_POST['selected_items']; // Array of selected item IDs

    // Generate order_id
    $order_id = generateOrderId();

    // Insert order into orders table
    $insert_order_query = "INSERT INTO orders (order_id, user_id, order_date, order_status) 
                            VALUES ('$order_id', {$_SESSION['user_id']}, NOW(), 'Pending')";
    $insert_result = mysqli_query($con, $insert_order_query);

    // Calculate total amount and construct order details
    $user_id = $_SESSION['user_id'];
    $selected_ids_str = implode(",", $selected_items);
    $cart_query = "SELECT cart_items.cart_item_id, product.product_id, product.product_name, product.product_price, cart_items.quantity 
                    FROM cart_items 
                    INNER JOIN product ON cart_items.product_id = product.product_id 
                    WHERE cart_items.user_id = $user_id AND cart_item_id IN ($selected_ids_str)";
    $cart_result = mysqli_query($con, $cart_query);

    $total_amount = 0.00;
    $order_details = '';
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $item_total = $row['product_price'] * $row['quantity'];
        $total_amount += $item_total;

        // Insert order item into order_items table
        $insert_order_item_query = "INSERT INTO order_items (order_id, product_id, price, quantity) 
                                    VALUES ('$order_id', '{$row['product_id']}', '{$row['product_price']}', {$row['quantity']})";
        $insert_order_item_result = mysqli_query($con, $insert_order_item_query);

        // Get current stock quantity for the item
        $stock_query = "SELECT product_quantity FROM product WHERE product_id = {$row['product_id']}";
        $stock_result = mysqli_query($con, $stock_query);

        if ($stock_result && mysqli_num_rows($stock_result) > 0) {
            $stock_row = mysqli_fetch_assoc($stock_result);
            $current_stock = intval($stock_row['product_quantity']);

            // Reduce stock quantity
            $update_stock_query = "UPDATE product SET product_quantity = product_quantity - {$row['quantity']} WHERE product_id = {$row['product_id']}";
            $update_stock_result = mysqli_query($con, $update_stock_query);
        }
    }

    // Update order amount into orders table
    $update_order_query = "UPDATE orders SET total_amount = $total_amount WHERE order_id = '$order_id'";
    $insert_result = mysqli_query($con, $update_order_query);

    if ($insert_result) {
        // Empty the cart after successful order
        $empty_cart_query = "DELETE FROM cart_items WHERE user_id = $user_id";
        $empty_cart_result = mysqli_query($con, $empty_cart_query);

        if ($empty_cart_result) {
            // Redirect to payment page with the generated order_id
            header("Location: order_details.php?order_id=$order_id");
            exit();
        } 
    } else {
        echo "Error placing order";
        header("Location: cart.php");
        exit();
    }
} else {
    echo "Invalid request";
    header("Location: cart.php?error=select");
    exit();
}

// Function to generate a unique order ID
function generateOrderId() {
    return 'ORD' . date('YmdHis') . rand(1000, 9999); // Example: ORD20240315120130456789
}
?>
