<?php
session_start();
include("db.php");

if (isset($_SESSION['teller'])) {
    session_destroy();
    header("Location: login.php"); 
    exit();
}
?>
