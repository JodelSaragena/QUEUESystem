<?php
require 'db.php';
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE queue SET status = 'serving' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['HTTP_REFERER']); //  back to the dashboard
        exit();
    }
}
?>
