<?php
include("auth.php");
require('database.php');
$status = "";
if (isset($_POST['new']) && $_POST['new'] == 1) {
    $product_name = $_REQUEST['product_name'];
    $product_price = $_REQUEST['product_price'];
    $product_quantity = $_REQUEST['product_quantity'];
    $product_category = $_REQUEST['product_category'];
    $image = $_REQUEST['product_image'];
    $date_record = date("Y-m-d H:i:s");
    $submitted_by = $_SESSION["staff_name"];
    $ins_query = "INSERT into product
 (`product_name`,`product_price`,`product_quantity`, `product_category`, `product_image`,`record_date`,`submitted_by`)values
 ('$product_name','$product_price','$product_quantity','$product_category','$image','$date_record','$submitted_by')";
    mysqli_query($con, $ins_query)
        or die(mysqli_error($con));
        $status = "<div class='alert alert-success' role='alert' style='text-align: center;'>
        New Product Insdert Successfully.
        <a href='product_view.php' class='link'>Click here to view Product Record</a>
    </div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Insert New Product</title>
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

    h1 {
        text-align: center;
    }

    .form-control,
    .dropdown-toggle{
        width: 300px;
    }

    .dropdown-toggle {
        border: 1px solid #ced4da;
        background-color:white;
    }
</style>

<body>
    <div class="container">
    <p>
        <a href="product_view.php" class="btn btn-info">View Product Record</a>
        <a href="staff_dashboard.php" class="btn btn-info">Dashboard</a>
        <a href="logout.php" class="btn btn-info">Logout</a></p>

    <h1 class="fw-bolder">Insert New Product</h1>
    <form name="form" method="post" action="">
        <input type="hidden" name="new" value="1" />
        <p><input type="text" name="product_name" class="form-control" placeholder="Enter Product Name" required /></p>
        <p><input type="number" name="product_price" class="form-control" step="0.01" min="0"
                placeholder="Enter Product Price (RM)" required /></p>
        <p><input type="number" name="product_quantity" class="form-control" placeholder="Enter Product Quantity"
                required />
        </p>
        <div class="dropdown pb-3">
            <button class="btn dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                Select a Category
            </button>
            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                <li><a class="dropdown-item" href="#" onclick="setCategory('Phone Cases')">Phone Cases</a></li>
                <li><a class="dropdown-item" href="#" onclick="setCategory('Headphones')">Headphones</a></li>
                <li><a class="dropdown-item" href="#" onclick="setCategory('Screen Protectors')">Screen Protectors</a>
                </li>
            </ul>
            <!-- Store selected category -->
            <input type="hidden" name="product_category" id="selectedCategory" value="">
        </div>

        <div class="input-group pb-3">
            <input type="text" name="product_image" id="productImageInput" class="form-control"
                placeholder="Enter Product Image URL" required />
            <button type="button" class="btn btn-primary" onclick="confirmImage()">Confirm URL</button>
        </div>

        <div id="imagePreview" style="display: none;">
            <!--Preview image before submit-->
            <p><strong>Image Preview:</strong></p>
            <img src="" alt="Product Image" id="previewImage" style="max-width: 100%; max-height: 200px;">
        </div>
        <p><input name="submit" type="submit" value="Submit" class="btn btn-primary" /></p>
    </form>
    <p style="color:#008000;">
        <?php echo $status; ?>
    </p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script>
        function confirmImage() {
            var imageUrl = document.getElementById('productImageInput').value;
            var previewImage = document.getElementById('previewImage');
            var imagePreview = document.getElementById('imagePreview');

            if (imageUrl) {
                previewImage.onload = function () {
                    // Image loaded successfully
                    imagePreview.style.display = 'block';
                    imagePreview.style.paddingBottom = "30px";
                };

                previewImage.onerror = function () {
                    // Image failed to load
                    alert('Error loading the image. Please check the URL.');
                    imagePreview.style.display = 'none';
                };

                previewImage.src = imageUrl;
            } else {
                alert('Please enter a valid image URL.');
                imagePreview.style.display = 'none';
            }
        }


        function setCategory(category) {
            document.getElementById('categoryDropdown').innerText = category;
            document.getElementById('selectedCategory').value = category; 
        }

    </script>

    </div>
</body>

</html>