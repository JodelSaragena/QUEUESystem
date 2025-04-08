<?php      
require 'db.php';

$queue_data = [];

// Fetch all queue numbers, but only display tellers for "Serving" status
$sql = "SELECT queue_number, 
               CASE WHEN status = 'Serving' THEN teller ELSE '' END AS teller, 
               services 
        FROM queue 
        WHERE status IN ('Waiting', 'Serving') 
        AND DATE(created_at) = CURDATE()  -- Only fetch today's queue numbers
        ORDER BY queue_number ASC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $queue_data[] = $row;
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Queue Display</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .sub-text {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 20px;
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
            color: #333;
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
        .queue-number {
            font-weight: bold;
            font-size: 1.1rem;
            color:black;
        }
        .teller {
            font-weight: bold;
            color:black;
        }
        .services {
            font-weight: bold;
            color: #343a40;
        }
    </style>
    <script>
        setTimeout(function() { location.reload(); }, 5000);
    </script>
     <!-- SOUND EFFECT -->
     <audio id="dingSound" src="sounds/ding.mp3" preload="auto"></audio>

     <script>
        const audio = document.getElementById("dingSound");

        function playDing() {
            if (audio) {
                audio.play();
            }
        }

        function checkForNewServe() {
            fetch("get_current_serving.php")
                .then(res => res.json())
                .then(data => {
                    if (data.queue_number) {
                        const lastServed = localStorage.getItem("lastServedNumber");
                        if (lastServed !== data.queue_number) {
                            // New serving number detected
                            playDing();
                            localStorage.setItem("lastServedNumber", data.queue_number);
                        }
                    }
                })
                .catch(err => console.error("Error checking serve:", err));
        }

        setInterval(checkForNewServe, 3000); // check every 3 seconds
    </script>



  

</head>
<body>

<div class="container">
    <h2>Waitlist</h2>
    <p class="sub-text"><?php echo count($queue_data); ?> </p>

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

</body>
</html>
