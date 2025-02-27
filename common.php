<?php
require 'db.php';

// Get the currently serving numbers categorized by transaction type
$transaction_types = ['withdrawal', 'deposit', 'open_account'];
$serving_numbers = [];
$next_numbers = [];
$waiting_numbers = [];

foreach ($transaction_types as $type) {
    $sql = "SELECT queue_number FROM queue WHERE status='serving' AND transaction_type='$type' ORDER BY queue_number ASC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $serving_numbers[$type] = $row ? $row['queue_number'] : 'None';

    $sql = "SELECT queue_number FROM queue WHERE status='waiting' AND transaction_type='$type' ORDER BY queue_number ASC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $next_numbers[$type] = $row ? $row['queue_number'] : 'None';

    $sql = "SELECT queue_number FROM queue WHERE status='waiting' AND transaction_type='$type' ORDER BY queue_number ASC";
    $result = mysqli_query($conn, $sql);
    $waiting_numbers[$type] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $waiting_numbers[$type][] = $row['queue_number'];
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            text-align: center;
        }
        .card {
            width: 230px;
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .card-header {
            background-color: #433878;
            color: white;
            width: 100%;
            text-align: center;
            font-size: 1rem;
        }
        .queue-box {
            font-size: 3rem;
            font-weight: bold;
            color: black;
        }
        .serving { background-color; }
        .next { background-color; }
        .waiting { background-color; }
        .waiting-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 5px;
        }
        .waiting-number {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .transaction-row {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .transaction-label {
            font-size: 1.5rem;
            font-weight: bold;
            margin-right: 15px;
            white-space: nowrap;
        }
        .arrow {
            font-size: 2rem;
            margin-right: 10px;
        }
        .row {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
        }
    </style>
    <script>
        setTimeout(function() { location.reload(); }, 5000);
    </script>
</head>
<body>
    <div class="container mt-2">
        <h2 class="text-center">Queue Display</h2>
        
        <?php foreach ($transaction_types as $type): ?>
            <div class="transaction-row">
                <div class="transaction-label"> <?php echo ucfirst($type); ?> </div>
                <div class="arrow">→</div>
                <div class="row">
                    <div class="col-auto">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <h5>Serving</h5>
                            </div>
                            <div class="card-body text-center serving">
                                <h1 class="queue-box"> <?php echo $serving_numbers[$type]; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <h5>Next</h5>
                            </div>
                            <div class="card-body text-center next">
                                <h1 class="queue-box"> <?php echo $next_numbers[$type]; ?> </h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <h5>Waiting</h5>
                            </div>
                            <div class="card-body text-center waiting">
                                <div class="waiting-box">
                                    <?php foreach ($waiting_numbers[$type] as $num): ?>
                                        <div class="waiting-number"> <?php echo $num; ?> </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
