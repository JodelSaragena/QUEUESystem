<?php
session_start();
include 'db.php';

$dashboardKey = isset($_GET['dashboard']) ? $_GET['dashboard'] : 'default';

if (!isset($_SESSION[$dashboardKey]['username']) || !isset($_SESSION[$dashboardKey]['role']) || !isset($_SESSION[$dashboardKey]['services'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    echo "<script>alert('Invalid request!'); window.location.href='admin_tellersdashboard.php?dashboard=$dashboardKey';</script>";
    exit();
}

$id = intval($_GET['id']);
$action = $_GET['action'];
$teller = $_SESSION[$dashboardKey]['role'];

$query = "SELECT * FROM queue WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Queue not found!'); window.location.href='admin_tellersdashboard.php?dashboard=$dashboardKey';</script>";
    exit();
}

if ($action == 'call') {
    $query = "UPDATE queue SET status = 'Serving', teller = '$teller' WHERE id = $id";
} elseif ($action == 'done') {
    if ($row['teller'] !== $teller) {
        echo "<script>alert('You are not authorized to mark this queue as Done.'); window.location.href='admin_tellersdashboard.php?dashboard=$dashboardKey';</script>";
        exit();
    }
    $query = "UPDATE queue SET status = 'Done' WHERE id = $id";
} else {
    echo "<script>alert('Invalid action!'); window.location.href='admin_tellersdashboard.php?dashboard=$dashboardKey';</script>";
    exit();
}

if (mysqli_query($conn, $query)) {
    header("Location: admin_tellersdashboard.php?dashboard=$dashboardKey");
} else {
    echo "<script>alert('Error updating queue: " . mysqli_error($conn) . "'); window.location.href='admin_tellersdashboard.php?dashboard=$dashboardKey';</script>";
}

mysqli_close($conn);
?>
