<?php
//Mysqli procedural method
//mysqli function
//DB configuration - setup, initiate, connect, establish

//mysqli_connect(server_name, username, password, database_name)
$con = mysqli_connect("localhost", "root", "", "assignment");

//error handling(fail connection)
if (mysqli_connect_errno()) {
    //status message
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

date_default_timezone_set('Asia/Singapore');
?>