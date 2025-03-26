<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || !isset($_SESSION['services'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    echo "<script>alert('Invalid request!'); window.location.href='admin_tellersdashboard.php';</script>";
    exit();
}

$id = intval($_GET['id']);
$action = $_GET['action'];

if ($action == 'call') {
    $query = "UPDATE queue SET status = 'Serving' WHERE id = $id";
} elseif ($action == 'done') {
    $query = "UPDATE queue SET status = 'Done' WHERE id = $id";
} else {
    echo "<script>alert('Invalid action!'); window.location.href='admin_tellersdashboard.php';</script>";
    exit();
}

if (mysqli_query($conn, $query)) {
    header("Location: admin_tellersdashboard.php");
} else {
    echo "<script>alert('Error updating queue: " . mysqli_error($conn) . "'); window.location.href='admin_tellersdashboard.php';</script>";
}

mysqli_close($conn);

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == "call") {
        // Assign teller and set status to Serving
        $teller = $_SESSION['role']; // Ensure the session contains the teller role
        $updateQuery = "UPDATE queue SET status = 'Serving', teller = '$teller' WHERE id = '$id'";
        mysqli_query($conn, $updateQuery);
    } elseif ($action == "done") {
        // Mark as Done
        $updateQuery = "UPDATE queue SET status = 'Done' WHERE id = '$id'";
        mysqli_query($conn, $updateQuery);
    }
}

header("Location: admin_tellersdashboard.php");
exit();






?>
