<?php
include 'sidebar.php';
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch queue data
$query = "SELECT * FROM queue ORDER BY status ASC, queue_number ASC";
$result = mysqli_query($conn, $query);
$queues = ['Waiting' => [], 'Serving' => [], 'Done' => []];

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['status'] == 'Waiting') {
        $queues['Waiting'][] = $row;
    } elseif ($row['status'] == 'Serving') {
        $queues['Serving'][] = $row;
    } else {
        $queues['Done'][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', sans-serif;
            font-size: smaller;
            color: black;
            background-color: #F0F0F0;
        }

        .main-content {
            margin-left: 110px;
            padding: 20px;
            width: 100%;
        }

        .queue-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="main-content">
    <div class="row">
        <?php foreach ($queues as $status => $queueList): ?>
            <div class="col-md-4">
                <div class="queue-card">
                    <h5 class="text-capitalize"> <?= ucfirst($status) ?> </h5>
                    <ul class="list-group" style="max-height: 300px; overflow-y: auto;">
                        <?php if (!empty($queueList)): ?>
                            <?php foreach (array_slice($queueList, 0, 8) as $queue): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong><?= $queue['queue_number'] ?></strong> - <?= $queue['services'] ?></span>
                                    <span class="badge bg-primary"> <?= ucfirst($queue['status']) ?> </span>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">No data available</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




