<?php
include ("staff_auth.php");
require ('database.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sel_query = "SELECT * FROM payment WHERE payment_id = '" . $id . "';";
    $result = mysqli_query($con, $sel_query);
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location: payment_view.php");
    exit();
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>View Payment Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    body {
        font-family: 'Courier New', Courier, monospace;
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 50px;
    }

    th{
        text-align:center;
    }
</style>

<body>
    <div class="container">
        <a href="staff_dashboard.php" class="btn btn-info">Dashboard</a>
        <a href="logout.php" class="btn btn-info">Logout</a></p>
        <h1 class="fw-bolder">Welcome to the Payment Management System</h1>
       
    
    <h2 class="fw-bold">Payment Details: <?php echo $id?></h2>

    <form id="paymentForm">
            <div class="form-group">
                <label>Payment Date:</label>
                <input type="text" class="form-control" id="customer_name" value="<?php echo $row['payment_date'];?>" readonly>
            </div>
            <div class="form-group">
                <label>Customer Name:</label>
                <input type="text" class="form-control" id="customer_name" value="<?php echo $row['customer_name'];?>" readonly>
            </div>

            <div class="form-group">
                <label>Contact Number:</label>
                <input type="text" class="form-control" id="contact_no" value="<?php echo $row['contact_no'];?>" readonly>
            </div>

            <div class="form-group">
                <label>Address Line 1:</label>
                <input type="text" class="form-control" id="address_line1" value="<?php echo $row['address_line1'];?>" readonly>
            </div>

            <div class="form-group">
                <label>Address Line 2:</label>
                <input type="text" class="form-control" id="address_line2" value="<?php echo $row['address_line2'];?>" readonly>
            </div>

            <div class="form-group">
                <label>Address Line 3:</label>
                <input type="text" class="form-control" id="address_line3" value="<?php echo $row['address_line3'];?>" readonly>
            </div>

            <div class="form-group">
                <label>Address Line 3:</label>
                <input type="text" class="form-control" id="address_line3" value="<?php echo $row['address_line3'];?>" readonly>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Postcode:</label>
                    <input type="text" class="form-control" id="postcode" value="<?php echo $row['postcode'];?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>City:</label>
                    <input type="text" class="form-control" id="city" value="<?php echo $row['city'];?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label>State:</label>
                    <input type="text" class="form-control" id="state" value="<?php echo $row['state'];?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Payment Method:</label>
                <input type="text" class="form-control" id="address_line3" value="<?php echo $row['payment_method'];?>" readonly>
            </div>

            <div class="form-group">
                <label>Total Amount:</label>
                <input type="text" class="form-control" id="address_line3" value="RM<?php echo $row['total_amount'];?>" readonly>
            </div>
    </form>
    <br>
    <a href="javascript:history.back()" class="btn btn-info">Back</a>
    </div>
</body>

</html>