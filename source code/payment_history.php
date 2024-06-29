<?php
// Start the session
session_start();

require ("database.php");

// Check if the user is logged in
if (!isset ($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit();
}

// Retrieve payment history for the current user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM orders INNER JOIN payment ON orders.payment_id = payment.payment_id WHERE user_id = $user_id ORDER BY order_date DESC";
$result = mysqli_query($con, $query);

// Display payment history
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Payment History</h1>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Order ID</th>
                    <th>Payment Date</th>
                    <th>Total Amount</th>
                    <th>Order Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['payment_id'] != 0){
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['payment_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['order_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['payment_date']; ?>
                            </td>
                            <td>
                                <?php echo $row['total_amount']; ?>
                            </td>
                            <td>
                                <?php echo $row['order_status']; ?>
                            </td>
                        </tr>
                        <?php
                        }
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">No payment history found.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-info">Back</a>
    </div>

    <!-- Bootstrap JS and jQuery (optional but required for some Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>