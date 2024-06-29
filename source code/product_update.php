<?php
include ("staff_auth.php");
require ('database.php');
$id = $_REQUEST['id'];
$query = "SELECT * FROM product where product_id='" . $id . "'";
$result = mysqli_query($con, $query) or die (mysqli_error($con));
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Update Product Record</title>
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
            <a href="product_view.php" class="btn btn-info">View Product Record</a>
            <a href="staff_dashboard.php" class="btn btn-info">Dashboard</a>
            <a href="logout.php" class="btn btn-info">Logout</a>
        </p>
        <h1 class="fw-bolder">Update Product Record</h1>

        <?php
        $status = "";
        if (isset ($_POST['new']) && $_POST['new'] == 1) {
            $id = $_REQUEST['id'];
            $product_name = $_REQUEST['product_name'];
            $price = str_replace('RM ', '', $_REQUEST['price']);
            $quantity = $_REQUEST['quantity'];
            $category = $_REQUEST['product_category'];
            $image = $_REQUEST['product_image'];
            $date_record = date("Y-m-d H:i:s");
            $submittedby = $_SESSION["staff_name"];

            $update = "UPDATE product SET 
            record_date='" . $date_record . "',
            product_name='" . $product_name . "', 
            product_price='" . $price . "', 
            product_quantity='" . $quantity . "', 
            product_category='" . $category . "', 
            product_image='" . $image . "',
            submitted_by='" . $submittedby . "' 
            WHERE product_id='" . $id . "'";

            mysqli_query($con, $update) or die (mysqli_error($con));
            $status = "<div class='alert alert-success' role='alert' style='text-align: center;'>
                Product Updated Successfully.
                <a href='product_view.php' class='link'>Click here to view Product Record</a>
            </div>";
        }
        ?>

        <form name="form" method="post" action="">
            <input type="hidden" name="new" value="1" />
            <input name="id" type="hidden" value="<?php echo $row['product_id']; ?>" />
            <p><input type="text" name="product_name" class="form-control" placeholder="Update Product Name"
                    required value="<?php echo $row['product_name']; ?>" /></p>
            <p><input type="text" name="price" class="form-control" placeholder="Update Product Price" required
                    value="RM <?php echo $row['product_price']; ?>" /></p>
            <p><input type="text" name="quantity" class="form-control" placeholder="Update Product Quantity" required
                    value="<?php echo $row['product_quantity']; ?>" /></p>
            <div class="dropdown pb-3">
                <button class="btn dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php echo $row['product_category']; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Phone Cases')">Phone Cases</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Headphones')">Headphones</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setCategory('Screen Protectors')">Screen
                            Protectors</a></li>
                </ul>
                <!-- Store the selected category -->
                <input type="hidden" name="product_category" id="selectedCategory"
                    value="<?php echo $row['product_category']; ?>">
            </div>
            <div class="input-group pb-3">
                <input type="text" name="product_image" id="productImageInput" class="form-control"
                    placeholder="Update Product Image URL" required
                    value="<?php echo $row['product_image']; ?>" />
                <button type="button" class="btn btn-primary" onclick="confirmImage()">Confirm
                    URL</button>
            </div>

            <div id="imagePreview" style="display: none;">
                <!--Preview Image before submit-->
                <p><strong>Image Preview:</strong></p>
                <img src="" alt="Product Image" id="previewImage"
                    style="max-width: 100%; max-height: 200px;">
            </div>
            <p><input name="submit" type="submit" value="Update" class="btn btn-primary" /></p>
        </form>

        <?php echo $status; ?>

    </div>

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
</body>

</html>
