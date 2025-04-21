<?php
session_start();
require 'db.php'; // Ensure this connects to your database

// Sanitize and validate the ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$dashboard = isset($_GET['dashboard']) ? htmlspecialchars($_GET['dashboard']) : '';

// Redirect if ID is not valid
if ($id <= 0) {
    echo "<script>alert('Invalid request.'); window.location.replace('admindashboard.php?dashboard={$dashboard}');</script>";
    exit();
}

// Check if the account exists
$stmt = $conn->prepare("SELECT id FROM tellers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Account not found.'); window.location.replace('admindashboard.php?dashboard={$dashboard}');</script>";
    $stmt->close();
    exit();
}
$stmt->close();

// Proceed with deletion
$delete_stmt = $conn->prepare("DELETE FROM tellers WHERE id = ?");
$delete_stmt->bind_param("i", $id);

if ($delete_stmt->execute()) {
    echo "<script>
            alert('Account deleted successfully.');
            window.location.replace('admindashboard.php?dashboard={$dashboard}');
          </script>";
} else {
    echo "<script>
            alert('Error deleting account. Please try again later.');
            window.location.replace('admindashboard.php?dashboard={$dashboard}');
          </script>";
}
$delete_stmt->close();
$conn->close();
?>
