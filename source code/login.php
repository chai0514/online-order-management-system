<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>User Login</title>
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
if (isset($_POST['username'])){
$username = stripslashes($_REQUEST['username']);
$username = mysqli_real_escape_string($con,$username);
$password = stripslashes($_REQUEST['password']);
$password = mysqli_real_escape_string($con,$password);
 $query = "SELECT * 
 FROM `user` 
 WHERE username='$username'
 AND password='".md5($password)."'"
 ;
$result = mysqli_query($con,$query) or die(mysqli_error($con));
$rows = mysqli_num_rows($result);
 if($rows==1){
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['user_id']; // Store user ID in session
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
 }else{
    echo "<div class='form'>
    <h3>Username/password is incorrect.</h3>
    <br/>Click here to <a href='login.php'>Login</a></div>";
}
 }else{
?>
<div class="form">
<h1>User Log In</h1>
<form action="" method="post" name="login">
<input type="text" name="username" class="form-control" placeholder="Username" required /><br>
<input type="password" name="password" class="form-control" placeholder="Password" required /><br>
<input name="submit" type="submit" class="btn btn-info" value="Login" />
</form>
<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>
<?php } ?>
</body>
</html>