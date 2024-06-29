<?php
include ("staff_auth.php");
require ('database.php');
$id = $_REQUEST['id'];
$query = "SELECT * FROM orders where order_id='" . $id . "'";
$result = mysqli_query($con, $query) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Update Order Record</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
</head>

<style>
    body {
        font-family: 'Courier New', Courier, monospace;
        background-color: #f8f9fa;
    }

    .link{
        text-decoration:none;
    }

    .container {
        margin-top: 50px;
    }

    h1 {
        text-align: center;
    }

    .form-control,
    .dropdown-toggle {
        width: 300px;
    }

    .dropdown-toggle {
        border: 1px solid #ced4da;
        background-color: white;
    }
</style>

<body>
    <div class="container">
        <p>
            <a href="orders_view.php" class="btn btn-info">View Order Record</a>
            <a href="staff_dashboard.php" class="btn btn-info">Dashboard</a>
            <a href="logout.php" class="btn btn-info">Logout</a>
        </p>
        <h1 class="fw-bolder">Update Order Record</h1>

        <?php
        $status = "";
        if (isset ($_POST['new']) && $_POST['new'] == 1) {
            $id = $_REQUEST['id'];
            $status = $_REQUEST['status'];

            $update = "UPDATE orders SET 
            order_status ='" . $status . "'
            WHERE order_id ='$id'";

            mysqli_query($con, $update) or die (mysqli_error($con));
            $status = "<div class='alert alert-success' role='alert' style='text-align: center;'>
                Order Status Updated Successfully.
                <a href='orders_view.php' class='link'>Click here to view Order Record</a>
            </div>";
        }
        ?>

        <form name="form" method="post" action="">
            <input type="hidden" name="new" value="1" />
            <input name="id" type="hidden" value="<?php echo $row['order_id']; ?>" />
            <div class="form-group">
                <label>Order ID:</label>
                <input type="text" class="form-control" name="order_id"
                    value="<?php echo $id; ?>" readonly>
            </div>
            <div class="dropdown pb-3">
                <button class="btn dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php echo $row['order_status']; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Pending')">Pending</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Preparing')">Preparing</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Shipped')">Shipped</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Delivered')">Delivered</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Cancelled')">Cancelled</a></li>
                </ul>
                <!-- Store the selected category -->
                <input type="hidden" name="status" id="selectedCategory"
                    value="<?php echo $row['order_status']; ?>">
            </div>
            <p><input name="submit" type="submit" value="Update" class="btn btn-primary" /></p>
        </form>

        <?php echo $status; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script>

        function setCategory(category) {
            document.getElementById('categoryDropdown').innerText = category;
            document.getElementById('selectedCategory').value = category;
        }
    </script>
</body>

</html>
