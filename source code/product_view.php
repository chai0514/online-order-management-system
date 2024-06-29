<?php
include ("staff_auth.php");
require ('database.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>View Product Records</title>
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
        <a href="product_insert.php" class="btn btn-info">Insert New Product</a>
        <a href="logout.php" class="btn btn-info">Logout</a></p>
        <h1 class="fw-bolder">Welcome to the Product Management System</h1>
       
    
    <h2 class="fw-bold">All Products</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Category</th>
                <th scope="col">Image</th>
                <th scope="col">Date and Time Recorded</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            $sel_query = "SELECT * FROM product ORDER BY product_id desc;";
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
                        <?php echo $currencySymbol . $row["product_price"]; ?>
                    </td>
                    <td>
                        <?php echo $row["product_quantity"]; ?>
                    </td>
                    <td>
                        <?php echo $row["product_category"]; ?>
                    </td>
                    <td align="center">
                        <img src="<?php echo $row["product_image"]; ?>" width="100" height="100">
                    </td>
                    <td>
                        <?php echo $row["record_date"]; ?>
                    </td>
                    <td>
                        <a class="btn btn-secondary" href="product_update.php?id=<?php echo $row["product_id"]; ?>">Update</a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="product_delete.php?id=<?php echo $row["product_id"]; ?>"
                            onclick="return confirm('Are you sure you want to delete this product record?')">Delete</a>
                    </td>
                </tr>
                <?php $count++;
            } ?>
        </tbody>
    </table>
    </div>
</body>

</html>