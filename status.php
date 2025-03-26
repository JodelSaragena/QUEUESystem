<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch total queue numbers
$dayQuery = "SELECT COUNT(*) AS total FROM queue WHERE DATE(created_at) = CURDATE()";
$monthQuery = "SELECT COUNT(*) AS total FROM queue WHERE MONTH(created_at) = MONTH(CURDATE())";
$yearQuery = "SELECT COUNT(*) AS total FROM queue WHERE YEAR(created_at) = YEAR(CURDATE())";

$dayResult = mysqli_fetch_assoc(mysqli_query($conn, $dayQuery));
$monthResult = mysqli_fetch_assoc(mysqli_query($conn, $monthQuery));
$yearResult = mysqli_fetch_assoc(mysqli_query($conn, $yearQuery));

$dayTotal = $dayResult['total'] ?? 0;
$monthTotal = $monthResult['total'] ?? 0;
$yearTotal = $yearResult['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Overview</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', Arial, sans-serif;            
            font-size: smaller;
            color: black;
            background-color: #F0F0F0;
        }

        .sidebar {
            width: 95px;
            height: 100vh;
            background-color: #433878;
            color: white;
            padding-top: 20px;
            position: fixed;
            text-align: center;
        }

        .sidebar a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            padding: 10px 5px;
            transition: background 0.3s;
            font-size: 0.70rem;
        }

        .sidebar a:hover {
            background-color: #5a49a2;
        }

        .main-content {
            margin-left: 110px;
            padding: 20px;
            width: 100%;
        }

        .status-card {
    background: white;
    border-radius: 8px; /* Slightly smaller border radius */
    padding: 8px; /* Reduced padding */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.status-card h5 {
    font-size: 0.9rem; /* Smaller heading */
    margin-bottom: 5px;
}

.status-card p {
    font-size: 1.2rem; /* Reduce number display size */
    font-weight: bold;
    margin: 0;
}

/* Adjust column spacing to keep it balanced */
.col-md-4 {
    padding: 5px;
}


        </style>
</head>
<body>
    <div class="sidebar">
        <h4>Menu</h4>
        <a href="admindashboard.php"><i class="bi bi-house-door"></i>Home</a>
        <a href="user.php"><i class="bi bi-clipboard-plus"></i>Get Number</a>
        <a href="login.php"><i class="bi bi-person-circle"></i>Teller Login</a>
        <a href="display.php"><i class="bi bi-tv"></i>Display</a>
        <a href="status.php"><i class="bi bi-bar-chart-fill"></i>Status</a>
        <a href="accounts.php"><i class="bi bi-people"></i>Accounts</a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href=""><i class=""></i></a>
        <a href="settings.php"><i class="bi bi-gear"></i>Settings</a>
        <a href="logout.php" class="text-white"><i class="bi bi-box-arrow-right"></i>Logout</a>
    </div>

    <div class="main-content">
        <h3>Queue Status Overview</h3>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="status-card">
                    <h5>Today's Total</h5>
                    <p class="display-6"> <?= $dayTotal ?> </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="status-card">
                    <h5>This Month's Total</h5>
                    <p class="display-6"> <?= $monthTotal ?> </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="status-card">
                    <h5>This Year's Total</h5>
                    <p class="display-6"> <?= $yearTotal ?> </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
