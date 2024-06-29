<?php
include ("staff_auth.php");
require ('database.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>View Order Records</title>
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
        <h1 class="fw-bolder">Welcome to the Orders Management System</h1>
       
    
    <h2 class="fw-bold">All Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Order ID</th>
                <th scope="col">User Name</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Date and Time</th>
                <th scope="col">Payment ID</th>
                <th scope="col">Status</th>
                <th scope="col">Details</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sel_query = "SELECT * FROM orders INNER JOIN user WHERE orders.user_id = user.user_id ORDER BY order_id desc;";
            $result = mysqli_query($con, $sel_query);
            $currencySymbol = "RM";
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <th scope="row">
                        <?php echo $count; ?>
                    </th>
                    <td>
                        <?php echo $row["order_id"]; ?>
                    </td>
                    <td>
                        <?php echo $row["username"]; ?>
                    </td>
                    <td>
                        <?php echo $currencySymbol . $row["total_amount"]; ?>
                    </td>
                    <td>
                        <?php echo $row["order_date"]; ?>
                    </td>
                    <td>
                        <?php if($row["payment_id"] != 0){
                            echo '<a href="payment_view_details.php?id=' . $row["payment_id"] . '">' . $row["payment_id"] . '</a>';
                        }else{
                            echo 'None';
                        } ?>
                    </td>
                    <td>
                        <?php echo $row["order_status"]; ?>
                    </td>
                    <td>
                        <a class="btn btn-info" href="orders_view_details.php?id=<?php echo $row["order_id"]; ?>">View</a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="orders_update.php?id=<?php echo $row["order_id"]; ?>">Update</a>
                    </td>
                </tr>
                <?php $count++;
            } ?>
        </tbody>
    </table>
    </div>
</body>

</html>