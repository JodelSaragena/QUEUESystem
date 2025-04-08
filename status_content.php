<?php
session_start();
require 'db.php';

// Queue stats
$dayQuery = "SELECT COUNT(*) AS total FROM queue WHERE DATE(created_at) = CURDATE()";
$weekQuery = "SELECT COUNT(*) AS total FROM queue WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
$monthQuery = "SELECT COUNT(*) AS total FROM queue WHERE MONTH(created_at) = MONTH(CURDATE())";
$yearQuery = "SELECT COUNT(*) AS total FROM queue WHERE YEAR(created_at) = YEAR(CURDATE())";

$dayTotal = mysqli_fetch_assoc(mysqli_query($conn, $dayQuery))['total'] ?? 0;
$weekTotal = mysqli_fetch_assoc(mysqli_query($conn, $weekQuery))['total'] ?? 0;
$monthTotal = mysqli_fetch_assoc(mysqli_query($conn, $monthQuery))['total'] ?? 0;
$yearTotal = mysqli_fetch_assoc(mysqli_query($conn, $yearQuery))['total'] ?? 0;

// Service stats
$serviceQuery = "SELECT services, COUNT(*) AS total FROM queue GROUP BY services";
$serviceResult = mysqli_query($conn, $serviceQuery);

$labels = [];
$serviceData = [];

while ($row = mysqli_fetch_assoc($serviceResult)) {
    $labels[] = $row['services'];
    $serviceData[] = $row['total'];
}

$colors = ['#433878', '#6AB04C', '#FF7979', '#F9CA24', '#1E90FF', '#8E44AD', '#E67E22', '#95A5A6'];
?>
<?php
// ... (Your PHP logic here remains unchanged)
?>

<style>
     .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #433878;
            margin-bottom: 25px;
        }

        .status-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease;
        }

        .status-card:hover {
            transform: scale(1.02);
        }

        .status-card h5 {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 10px;
        }

        .status-card p {
            font-size: 1.5rem;
            font-weight: 600;
            color: #433878;
            margin: 0;
        }

        .service-overview {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            display: flex;
            gap: 40px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .service-list {
            min-width: 180px;
        }

        .service-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .color-box {
            width: 14px;
            height: 14px;
            border-radius: 3px;
        }

        .chart-wrapper {
            flex-grow: 1;
            max-width: 350px;
            min-width: 250px;
        }

        .display-6 {
            font-size: 2rem;
        }
</style>

<h2 class="section-title"><i class="bi bi-bar-chart-line"></i> Status Overview</h2>

<div class="row g-4">
    <div class="col-md-3">
        <div class="status-card">
            <h5>Today's Total</h5>
            <p><?= $dayTotal ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card">
            <h5>This Week's Total</h5>
            <p><?= $weekTotal ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card">
            <h5>This Month's Total</h5>
            <p><?= $monthTotal ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card">
            <h5>This Year's Total</h5>
            <p><?= $yearTotal ?></p>
        </div>
    </div>
</div>

<div class="service-overview">
    <div class="service-list">
        <h5 class="mb-3">Services Overview</h5>
        <?php foreach ($labels as $index => $service) : ?>
            <div class="service-item">
                <span class="color-box" style="background-color: <?= $colors[$index % count($colors)] ?>"></span>
                <?= $service ?>: <?= $serviceData[$index] ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="chart-wrapper">
        <canvas id="serviceChart" width="300" height="300"></canvas>
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
                backgroundColor: <?= json_encode(array_slice($colors, 0, count($serviceData))) ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
