<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>User Registration</title>
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
if (isset($_REQUEST['username'])){
$username = stripslashes($_REQUEST['username']);
$username = mysqli_real_escape_string($con,$username); 
$email = stripslashes($_REQUEST['email']);
$email = mysqli_real_escape_string($con,$email);
$password = stripslashes($_REQUEST['password']);
$password = mysqli_real_escape_string($con,$password);
$reg_date = date("Y-m-d H:i:s");
 $query = "INSERT into `user` (username, password, email, reg_date)
VALUES ('$username', '".md5($password)."', '$email', '$reg_date')";
 $result = mysqli_query($con,$query);
 if($result){
 echo "<div class='form'>
 <h3>You are registered successfully.</h3>
 <br/>Click here to <a href='login.php'>Login</a></div>";
 }
 }else{
?>
<div class="form">
<h1>User Registration</h1>
<form name="registration" action="" method="post">
<input type="text" name="username" class="form-control" placeholder="Username" required /><br>
<input type="email" name="email" class="form-control" placeholder="Email" required /><br>
<input type="password" name="password" class="form-control" placeholder="Password" required /><br>
<a href="login.php" class="btn btn-info">Back</a>
<input type="submit" name="submit" class="btn btn-info" value="Register" />
</form>
</div>
<?php } ?>
</body>
</html>
