<?php
include ('auth.php');
require ('database.php');

if (isset ($_GET['order_id'])) {
    $id = $_GET['order_id'];
    $sel_query = "SELECT * FROM orders WHERE order_id = '" . $id . "';";
    $result = mysqli_query($con, $sel_query);
    $row = mysqli_fetch_assoc($result);
} else {
    //header("Location: orders.php");
    //exit();
}

$errormessage = '';

if (isset ($_GET['error'])) {
    if ($_GET['error'] == 'invalid_card_number'){
        $errormessage = 'Please enter a valid card number.';
    }
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Payment Details</h1>
        <form id="paymentForm" action="process_payment.php" method="post">
            <div class="form-group">
                <label>Customer Name:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>

            <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" required>
            </div>

            <div class="form-group">
                <label>Address Line 1:</label>
                <input type="text" class="form-control" id="address_line1" name="address_line1" required>
            </div>

            <div class="form-group">
                <label>Address Line 2:</label>
                <input type="text" class="form-control" id="address_line2" name="address_line2">
            </div>

            <div class="form-group">
                <label>Address Line 3:</label>
                <input type="text" class="form-control" id="address_line3" name="address_line3">
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Postcode:</label>
                    <input type="text" class="form-control" id="postcode" name="postcode" required>
                </div>
                <div class="form-group col-md-4">
                    <label>City:</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                <div class="form-group col-md-4">
                    <label>State:</label>
                    <input type="text" class="form-control" id="state" name="state" required>
                </div>
            </div>

            <div class="form-group">
                <label>Payment Method:</label>
                <select class="form-control" id="payment_method" name="payment_method" required
                    onchange="showPaymentFields()">
                    <option value="" disabled selected>Select Payment Method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <!-- Card Fields -->
            <div id="cardFields" style="display: none;">
                <div class="form-group">
                    <label>Card Number:</label>
                    <input type="text" class="form-control" id="card_number" name="card_number"
                        oninput="validateCreditCardNumber(this)">
                </div>

                <div class="form-group">
                    <label>Card Holder Name:</label>
                    <input type="text" class="form-control" id="card_holder_name" name="card_holder_name">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Expiry Month:</label>
                        <input type="text" class="form-control" id="expiry_month" name="expiry_month" placeholder="MM">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Expiry Year:</label>
                        <input type="text" class="form-control" id="expiry_year" name="expiry_year" placeholder="YYYY">
                    </div>
                </div>

                <div class="form-group">
                    <label>CSV:</label>
                    <input type="text" class="form-control" id="csv" name="csv">
                </div>
            </div>

            <!-- E-Wallet Fields -->
            <div id="ewalletFields" style="display: none;">
                <div class="form-group">
                    <label for="ewallet_option">Select E-Wallet:</label>
                    <select class="form-control" id="ewallet_option" name="ewallet_option" required>
                        <option value="touch_n_go">Touch 'n Go</option>
                        <option value="boost">Boost</option>
                        <option value="grabpay">GrabPay</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Total Amount:</label>
                <input type="text" class="form-control" id="total_amount" name="total_amount"
                    value="<?php echo htmlspecialchars($row['total_amount']); ?>" readonly>
            </div>

            <!-- total will taken value from order module -->
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($_GET['order_id']); ?>">
            <input type="hidden" id="card_number" name="card_number">
            <input type="hidden" id="card_holder_name" name="card_holder_name">
            <input type="hidden" id="expiry_month" name="expiry_month">
            <input type="hidden" id="expiry_year" name="expiry_year">
            <input type="hidden" id="csv" name="csv">
            <input type="hidden" id="ewallet_option" name="ewallet_option">

            <a href="javascript:history.back()" class="btn btn-info">Back</a>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
            <span style="color: #FF0616;"><?php echo $errormessage;?></span>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery (optional but required for some Bootstrap components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function showPaymentFields() {
            var paymentMethod = document.getElementById("payment_method").value;
            var creditCardFields = document.getElementById("creditCardFields");
            var ewalletFields = document.getElementById("ewalletFields");

            if (paymentMethod === "credit_card" || paymentMethod === "debit_card") {
                cardFields.style.display = "block";
                ewalletFields.style.display = "none";
                // Scroll down to credit card fields
                creditCardFields.scrollIntoView({ behavior: 'smooth' });
            } else if (paymentMethod === "ewallet") {
                cardFields.style.display = "none";
                ewalletFields.style.display = "block";
            }
        }


        function validateCreditCardNumber(input) {
            // Remove any non-numeric characters from the input value
            var cleanedInput = input.value.replace(/\D/g, '');
            // Limit the input to 16 characters
            cleanedInput = cleanedInput.slice(0, 16);
            // Update the input value with the cleaned and limited number
            input.value = cleanedInput;
        }


        // Function to update hidden fields with payment details
        function updatePaymentDetails() {
            var paymentMethod = document.getElementById("payment_method").value;

            if (paymentMethod === "credit_card" || paymentMethod === "debit_card") {
                // Retrieve and validate credit card details
                var cardNumber = document.getElementById("card_number").value.trim();
                var cardHolderName = document.getElementById("card_holder_name").value.trim();
                var expiryMonth = document.getElementById("expiry_month").value.trim();
                var expiryYear = document.getElementById("expiry_year").value.trim();
                var csv = document.getElementById("csv").value.trim();

                // Check if any field is empty
                if (cardNumber === "" || cardHolderName === "" || expiryMonth === "" || expiryYear === "" || csv === "") {
                    alert("Please fill in all credit card details.");
                    return false; // Prevent form submission
                }
            } else if (paymentMethod === "ewallet") {
                // Retrieve e-wallet option and update hidden field
                var ewalletOption = document.getElementById("ewallet_option").value;
                document.getElementById("ewallet_option").value = ewalletOption;
            }
        }

        // Attach the updatePaymentDetails function to the form submission event
        document.getElementById("paymentForm").addEventListener("submit", updatePaymentDetails);
    </script>
</body>

</html>