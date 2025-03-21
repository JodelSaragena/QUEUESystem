<?php
session_start();
require 'db.php'; // Ensure this connects to your database

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid request.'); window.location.href='createaccount.php';</script>";
    exit();
}

$id = intval($_GET['id']);

// Fetch the role of the account to prevent deleting admin accounts
$stmt = $conn->prepare("SELECT role FROM tellers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Account not found.'); window.location.href='createaccount.php';</script>";
    exit();
}

$account = $result->fetch_assoc();
if ($account['role'] === 'admin') {
    echo "<script>alert('Admin accounts cannot be deleted.'); window.location.href='createaccount.php';</script>";
    exit();
}

// Proceed with deletion
$delete_stmt = $conn->prepare("DELETE FROM tellers WHERE id = ?");
$delete_stmt->bind_param("i", $id);

if ($delete_stmt->execute()) {
    echo "<script>alert('Account deleted successfully.'); window.location.href='createaccount.php';</script>";
} else {
    echo "<script>alert('Error deleting account.'); window.location.href='createaccount.php';</script>";
}
?>
