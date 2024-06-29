<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Staff Registration</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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
<?php
require('database.php');
if (isset($_REQUEST['staffname'])){
$staffname = stripslashes($_REQUEST['staffname']);
$staffname = mysqli_real_escape_string($con,$staffname); 
$email = stripslashes($_REQUEST['email']);
$email = mysqli_real_escape_string($con,$email);
$password = stripslashes($_REQUEST['password']);
$password = mysqli_real_escape_string($con,$password);
$phone = stripcslashes($_REQUEST['phone']);
$phone = mysqli_real_escape_string($con,$phone);
$position = stripcslashes($_REQUEST['position']);
$position = mysqli_real_escape_string($con,$position);
$reg_date = date("Y-m-d H:i:s");
 $query = "INSERT into `staff` (staff_name, password, email, phone_no, position, reg_date)
VALUES ('$staffname', '".md5($password)."', '$email', '$phone', '$position', '$reg_date')";
 $result = mysqli_query($con,$query);
 if($result){
 echo "<div class='form'>
 <h3>You are registered successfully.</h3>
 <br/>Click here to <a href='staff_portal.php'>Login</a></div>";
 }
 }else{
?>
<div class="form">


<form name="staff_registration" action="" method="post">
    <table>
        <h1>Staff Registration</h1>
            <tr>
                <th>Staff Name:</th>
                <td>
                    <input type="text" name="staffname" placeholder="Staffname" required /><br>
                </td>
            </tr>
            <tr>
                <th>Staff Email:</th>
                <td>
                    <input type="email" name="email" placeholder="Email" required /><br>
                </td>
            </tr>
            <tr>
                <th>Password:</th>
                <td>
                    <input type="password" name="password" placeholder="Password" required /><br>
                </td>
            </tr>
            <tr>
                <th>Phone Number:</th>
                <td>
                    <input type="text" name="phone" placeholder="Phone Number" required /><br>
                </td>
            </tr>
            <tr>
                <th>Roles:</th>
                <td>
                    <select name = "position">
                        <option selected>Staff</option>
                        <option>Admin</option>
                        <option>Manager</option>
                        <option>Stock Manager</option>
                    </select>
                </td>
            </tr>

    </table>
<a href="staff_portal.php" class="btn btn-info">Back</a>
<input type="submit" name="submit" class="btn btn-info" value="Register" />
</form>
</div>
<?php } ?>
</body>
</html>