<?php
include('auth.php');
require('database.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_name = $_POST['customer_name'];
    $contact_no = $_POST['contact_no'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $address_line3 = $_POST['address_line3'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $payment_method = $_POST['payment_method'];
    $order_id = $_POST['order_id'];
    // Assuming you receive these fields from the form submission
    $total_amount = $_POST['total_amount'];

    // Validate credit card number
    $card_number = $_POST['card_number'];
    if ($payment_method != 'ewallet' && !ctype_digit($card_number)) {
        // Redirect back to payment page with error message if non-numeric characters are found
        header("Location: payment.php?order_id=" . $_POST['order_id'] . "&error=invalid_card_number");
        exit();
    }

    // Check if the order_id matches the user's order
    $order_check_query = "SELECT user_id FROM orders WHERE order_id = '$order_id'";
    $order_check_result = mysqli_query($con, $order_check_query);
    if ($order_check_result && mysqli_num_rows($order_check_result) > 0) {
        $order_row = mysqli_fetch_assoc($order_check_result);
        $user_id_from_order = $order_row['user_id'];
        if ($_SESSION['user_id'] != $user_id_from_order) {
            // Redirect to payment page with an error message if user_id doesn't match
            header("Location: payment.php?order_id=" . $_POST['order_id'] . "&error=user_mismatch");
            exit();
        }
    } else {
        // Redirect to payment page with an error message if order_id is invalid
        header("Location: payment.php?order_id=" . $_POST['order_id'] . "&error=invalid_order");
        exit();
    }

    // Store customer details and payment information in the database
    $query = "INSERT INTO payment (customer_name, contact_no, address_line1, address_line2, address_line3, postcode, city, state, payment_method, total_amount, payment_date) 
              VALUES ('$customer_name', '$contact_no', '$address_line1', '$address_line2', '$address_line3', '$postcode', '$city', '$state', '$payment_method', '$total_amount', NOW())";

    // Execute the query
    $result = mysqli_query($con, $query);

    if ($result) {
        // Get the newly inserted payment_id
        $payment_id = mysqli_insert_id($con);
        
        // Update the order status to "Preparing" and set the payment_id
        $update_order_query = "UPDATE orders SET order_status = 'Preparing', payment_id = '$payment_id' WHERE order_id = '$order_id'";
        echo $update_order_query;
        $update_result = mysqli_query($con, $update_order_query);

        if ($update_result) {
            // Redirect to payment history page
            header("Location: payment_history.php");
            exit();
        } else {
            echo "Error updating order status: " . mysqli_error($con);
        }
    } else {
        echo "Error processing payment: " . mysqli_error($con);
    }
} else {
    // If the request method is not POST, redirect the user to the payment page
    header("Location: payment.php");
    exit();
}
?>
