<?php
include ("staff_auth.php");
require ('database.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header("Location: orders_view.php");
    exit();
}


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
       
    
    <h2 class="fw-bold">Order Details: <?php echo $id?></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sel_query = "SELECT * FROM order_items INNER JOIN product ON order_items.product_id = product.product_id WHERE order_id = '" . $id . "' ORDER BY product_name desc;";
            $result = mysqli_query($con, $sel_query);
            $currencySymbol = "RM";
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <th scope="row">
                        <?php echo $count; ?>
                    </th>
                    <td>
                        <?php echo $row["product_name"]; ?>
                    </td>
                    <td>
                        <?php echo $row["quantity"]; ?>
                    </td>
                    <td>
                        <?php echo $currencySymbol . $row["price"] * $row["quantity"]; ?>
                    </td>
                </tr>
                <?php $count++;
            } ?>
        </tbody>
    </table>
    <a href="javascript:history.back()" class="btn btn-info">Back</a>
    </div>
</body>

</html>