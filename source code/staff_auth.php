<?php
session_start();
if(!isset($_SESSION["staff_name"])){
header("Location: staff_portal.php");
exit(); }
?>