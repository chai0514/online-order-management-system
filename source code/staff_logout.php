<?php
session_start();
//Set condition -  to destroy/terminate/end the session
if(session_destroy())
{
//Once successful, it will redirect user to login page
header("Location: staff_portal.php");
//End of this process
exit();
}
?>