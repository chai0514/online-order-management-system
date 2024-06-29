<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Staff Login</title>
        <meta charset="utf-8">
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
        if (isset($_POST['staffname'])){
        $staffname = stripslashes($_REQUEST['staffname']);
        $staffname = mysqli_real_escape_string($con,$staffname);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con,$password);
         $query = "SELECT * 
         FROM `staff` 
         WHERE staff_name='$staffname'
         AND password='".md5($password)."'"
         ;
        $result = mysqli_query($con,$query) or die(mysqli_error($con));
        $rows = mysqli_num_rows($result);
         if($rows==1){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['staff_id'] = $row['staff_id']; // Store staff ID in session
            $_SESSION['staff_name'] = $staffname;
            header("Location: staff_dashboard.php");
            exit();
         }else{
            echo "<div class='form'>
            <h3>Username/password is incorrect.</h3>
            <br/>Click here to <a href='staff_portal.php'>Re-Login</a> again.</div>";
        }
         }else{
        ?>

        <div class="form">
            <h1>Staff Login</h1>
            <form action="" method="POST" name="staff_login">
                <input type="text" name="staffname" placeholder="Staffname" required /><br>
                <input type="password" name="password" placeholder="Password" required /><br>
                <input type="submit" type="submit" class="btn btn-info" value="Login" />
            </form>
            <p style="display: block;">Register for stuff <a href="staff_registration.php">Click Here</a></p>
            <p style= "display: block;">Back to User Login <a href="login.php">Click Here</a></p>
        </div>
        <?php } ?>
    </body>
</html>