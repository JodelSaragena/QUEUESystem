<?php
require 'db.php';

$queue_data = [];
$items_per_page = 10;

// Get the next 10 queue numbers (11–20)
$sql = "SELECT queue_number, 
               CASE WHEN status = 'Serving' THEN teller ELSE '' END AS teller, 
               services 
        FROM queue 
        WHERE status IN ('Waiting', 'Serving') 
        AND DATE(created_at) = CURDATE()
        ORDER BY queue_number ASC
        LIMIT $items_per_page OFFSET 10";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $queue_data[] = $row;
}

mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Screen 2</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .main-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .container-left {
            width: 70%;
            padding: 20px;
            background: #003092;
            overflow-y: auto;
        }

        .container-right {
            width: 30%;
            background-color: #000;
        }

        .container-right video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
            color: white;
            text-align: center;
        }

        .sub-text {
            font-size: 1rem;
            color: white;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
        }

        th {
            font-size: 1.1rem;
            border-bottom: 2px solid #e0e0e0;
            color: white;
        }

        td {
            text-transform: uppercase;
            font-size: 1rem;
            font-weight: bold;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        th:nth-child(1), td.queue-number {
            text-align: left; 
        }

        th:nth-child(2), td.teller {
            text-align: center;
        }

        th:nth-child(3), td.services {
            text-align: right;
        }

        .queue-number,
        .teller,
        .services {
            color: white;
        }
    </style>
    <script>
        setTimeout(function() { location.reload(); }, 5000);
    </script>
</head>
<body>

<div class="main-wrapper">
    <!-- Left: Queue display -->
    <div class="container-left">
        <h2>Waitlist - Screen 2</h2>
        <!--<p class="sub-text"><?php echo count($queue_data); ?>           </p>-->

        <table>
            <thead>
                <tr>
                    <th>Queue No.</th>
                    <th>Teller</th>
                    <th>Services</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($queue_data)): ?>
                    <?php foreach ($queue_data as $data): ?>
                    <tr>
                        <td class="queue-number"><?php echo $data['queue_number']; ?></td>
                        <td class="teller"><?php echo !empty($data['teller']) ? ucfirst(strtolower($data['teller'])) : '—'; ?></td>
                        <td class="services"><?php echo ucfirst(strtolower($data['services'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">No active queues</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Right: Video display -->
    <div class="container-right"> 
    <video autoplay muted loop>
        <source src="tree.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>


</body>
</html>
