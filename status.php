<?php
include 'sidebar.php';
require 'db.php';
session_start();

// Debugging: Check session role
 //var_dump($_SESSION['role']); // Uncomment this for debugging
 //exit(); // Uncomment this to stop the script

// Check if the user is logged in and if the role is 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if the session role is not set or not admin
    header("Location: login.php");
    exit();
}

// Fetch total queue numbers
$dayQuery = "SELECT COUNT(*) AS total FROM queue WHERE DATE(created_at) = CURDATE()";
$weekQuery = "SELECT COUNT(*) AS total FROM queue WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
$monthQuery = "SELECT COUNT(*) AS total FROM queue WHERE MONTH(created_at) = MONTH(CURDATE())";
$yearQuery = "SELECT COUNT(*) AS total FROM queue WHERE YEAR(created_at) = YEAR(CURDATE())";

$dayResult = mysqli_fetch_assoc(mysqli_query($conn, $dayQuery));
$weekResult = mysqli_fetch_assoc(mysqli_query($conn, $weekQuery));
$monthResult = mysqli_fetch_assoc(mysqli_query($conn, $monthQuery));
$yearResult = mysqli_fetch_assoc(mysqli_query($conn, $yearQuery));

$dayTotal = $dayResult['total'] ?? 0;
$weekTotal = $weekResult['total'] ?? 0;
$monthTotal = $monthResult['total'] ?? 0;
$yearTotal = $yearResult['total'] ?? 0;

// Fetch service data
$serviceQuery = "SELECT services, COUNT(*) AS total FROM queue GROUP BY services";
$serviceResult = mysqli_query($conn, $serviceQuery);
$serviceData = [];
$labels = [];

while ($row = mysqli_fetch_assoc($serviceResult)) {
    $labels[] = $row['services'];
    $serviceData[] = $row['total'];
}

// Define a fixed color palette
$colors = ['#433878', '#6AB04C', '#FF7979', '#F9CA24', '#1E90FF', '#8E44AD', '#E67E22', '#95A5A6'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Overview</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: smaller;
            color: black;
            background-color: #F0F0F0;
        }

        .main-content {
            margin-left: 110px;
            padding: 20px;
            width: 100%;
        }

        .status-card {
            background: white;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .status-card h5 {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .status-card p {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
        }

        .chart-container {
            width: 100%;
            max-width: 350px;
            margin: auto;
        }

        .service-overview {
            display: flex;
            align-items: flex-start;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex-direction: row;
            justify-content: flex-start;
            gap: 20px;
            width: fit-content;
        }

        .service-list {
            flex: none;
            text-align: left;
        }

        .chart-wrapper {
            flex: none;
            display: flex;
            justify-content: left;
            width: 250px;
        }

        /* Color indicators beside service names */
        .service-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .color-box {
            width: 14px;
            height: 14px;
            border-radius: 3px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h4>Queue Status Overview</h4>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="status-card">
                    <h5>Today's Total</h5>
                    <p class="display-6"> <?= $dayTotal ?> </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="status-card">
                    <h5>This Week's Total</h5>
                    <p class="display-6"> <?= $weekTotal ?> </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="status-card">
                    <h5>This Month's Total</h5>
                    <p class="display-6"> <?= $monthTotal ?> </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="status-card">
                    <h5>This Year's Total</h5>
                    <p class="display-6"> <?= $yearTotal ?> </p>
                </div>
            </div>
        </div>
        <div class="service-overview mt-4">
            <div class="service-list">
                <h5>Services Overview</h5>
                <ul>
                    <?php foreach ($labels as $index => $service) : ?>
                        <li class="service-item">
                            <span class="color-box" style="background-color: <?= $colors[$index % count($colors)] ?>;"></span>
                            <?= $service ?>: <?= $serviceData[$index] ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="chart-wrapper">
                <canvas id="serviceChart"></canvas>
            </div>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('serviceChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                data: <?= json_encode($serviceData) ?>,
                backgroundColor: [
                    '#433878', '#6AB04C', '#FF7979', '#F9CA24',
                    '#1E90FF', '#8E44AD', '#E67E22', '#95A5A6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // This removes the legend
                }
            }
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
