<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || !isset($_SESSION['services'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    echo "<script>alert('Invalid request!'); window.location.href='documentation_tellersdashboard.php';</script>";
    exit();
}

$id = intval($_GET['id']);
$action = $_GET['action'];
$teller = $_SESSION['role']; // Get the teller role

// Fetch the current queue status and assigned teller
$query = "SELECT * FROM queue WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Queue not found!'); window.location.href='documentation_tellersdashboard.php';</script>";
    exit();
}

if ($action == 'call') {
    // Assign the teller role and set status to "Serving"
    $query = "UPDATE queue SET status = 'Serving', teller = '$teller' WHERE id = $id";
} elseif ($action == 'done') {
    // Ensure that the teller who is serving the queue can mark it as done
    if ($row['teller'] !== $teller) {
        echo "<script>alert('You are not authorized to mark this queue as Done.'); window.location.href='documentation_tellersdashboard.php';</script>";
        exit();
    }
    // Mark as "Done" but keep the teller info
    $query = "UPDATE queue SET status = 'Done' WHERE id = $id";
} else {
    echo "<script>alert('Invalid action!'); window.location.href='documentation_tellersdashboard.php';</script>";
    exit();
}

if (mysqli_query($conn, $query)) {
    header("Location: documentation_tellersdashboard.php");
} else {
    echo "<script>alert('Error updating queue: " . mysqli_error($conn) . "'); window.location.href='documentation_tellersdashboard.php';</script>";
}

mysqli_close($conn);
?>
