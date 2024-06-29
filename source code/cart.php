<?php
include('auth.php');
require('database.php');

// Modify item quantity
if (isset($_POST['update_quantity'])) {
    $cart_item_id = mysqli_real_escape_string($con, $_POST['cart_item_id']);
    $quantity = intval($_POST['quantity']);
    $cart_query = "SELECT product.name, cart_items.quantity, product.stock 
                    FROM cart_items 
                    INNER JOIN product ON cart_items.product_id = product.product_id 
                    WHERE cart_item_id = $cart_item_id";
    $cart_result = mysqli_query($con, $cart_query);
    $cart_item = mysqli_fetch_assoc($result);

    // Ensure quantity is at least 1 before updating
    if ($quantity >= 1 && $cart_item["stock"] >= $quantity) {
        $update_query = "UPDATE cart_items SET quantity = $quantity WHERE cart_item_id = $cart_item_id";
        $update_result = mysqli_query($con, $update_query);
    } else {
        // Quantity is zero or negative, remove the item from the cart
        $delete_query = "DELETE FROM cart_items WHERE cart_item_id = $cart_item_id";
        $delete_result = mysqli_query($con, $delete_query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS here -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Courier New', Courier, monospace;
    }

    .form {
        margin: 50px;
        padding: 20px;
        border: 1px solid #c8ced3;
        border-radius: 10px;
        background-color: #fff;
    }

    .btn-link {
        /* Add this style to force button appearance */
        display: inline-block;
        padding: 0.5rem 1rem;
        text-decoration: none;
    }
    </style>

</head>
<body>

</header>
<main>
<div class="form">
    <div class="d-flex align-items-center justify-content-center">
            <h1 class="fw-bolder">Cart</h1>
    </div>
    <!--================Cart Area =================-->
    <section class="section-padding">
        <div class="container">

<form action="process_cart.php" method="post">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Select</th>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sel_query = "SELECT cart_items.cart_item_id, product.product_name, product.product_price, product.product_image, cart_items.quantity 
                            FROM cart_items 
                            INNER JOIN product ON cart_items.product_id = product.product_id 
                            WHERE cart_items.user_id = {$_SESSION['user_id']}";
            $result = mysqli_query($con, $sel_query);
            if (!$result) {
                die('Error fetching data: ' . mysqli_error($con));
            }
            if (mysqli_num_rows($result) == 0){
                echo '<tr><td colspan="5"><h6><a href="product_page.php" style="color: #FF0616;">You have no item in cart, Add it now !</a><h6></td></tr>';
            }
            else{
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" value="<?php echo $row['cart_item_id']; ?>">
                        </td>
                        <td align="center">
                            <div class="media">
                                <div class="d-flex"><img src="<?php echo $row['product_image']; ?>" alt="image" style="max-width: 100px; max-height: 100px;"/></div>
                                <div class="media-body">
                                    <p><?php echo $row['product_name']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td>RM<?php echo $row["product_price"]; ?></td>
                        <td>
                            <input type="number" name="item_quantity[<?php echo $row['cart_item_id']; ?>]" value="<?php echo $row["quantity"]; ?>" min="1">
                        </td>
                        <td>RM<?php echo sprintf("%.2f", $row["product_price"] * $row["quantity"]); ?></td>
                    </tr>
            <?php
            } }
            ?>
        </tbody>
    </table>
    <a href="javascript:history.back()" class="btn btn-info">Back</a>
    <div class="float-right">
        <?php if(mysqli_num_rows($result) > 0){ // show buttons if cart item > 0
            echo '<button type="submit" name="update_quantity" class="btn btn-primary">Update Quantity</button>';
            echo '  <button type="submit" name="order" class="btn btn-primary">Make Order</button>';
        } ?>
    </div>
    <?php
        // Display error message
        if (isset($_GET["error"]) && $_GET["error"] == "stock"){
            echo "<p style='color: #FF0616'> Failed to update quantity, " . $_GET["item_name"] . " has no enough stock.</p>";
        }
        elseif (isset($_GET["error"]) && $_GET["error"] == "select"){
            echo "<p style='color: #FF0616'> You must select at least one item.</p>";
        }
    ?>
</form>

        </div>
    </section>
    <!--================End Cart Area =================-->
    </div>
</main>

</body>
</html>