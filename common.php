<?php     
require 'db.php';

$departments = ['ADMIN', 'ACCOUNTS', 'DOCUMENTATION', 'CREWING', 'TECHOPS', 'SOURCING', 'TANKER', 'WELFARE'];
$queue_data = [];

foreach ($departments as $department) {
    // Fetch tellers for this department
    $sql = "SELECT DISTINCT teller FROM queue WHERE department='$department' ORDER BY teller ASC";
    $result = mysqli_query($conn, $sql);
    $tellers = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $tellers[] = $row['teller'];
    }

    // If no tellers found, set default values
    $teller_display = !empty($tellers) ? implode(", ", $tellers) : 'No Tellers';

    // Fetch the currently serving queue numbers for all tellers
    $serving = [];
    foreach ($tellers as $teller) {
        $sql = "SELECT queue_number FROM queue WHERE status='Serving' AND department='$department' AND teller='$teller' ORDER BY queue_number ASC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $serving[$teller] = $row ? $row['queue_number'] : 'None';
    }

    // Fetch the next queue numbers for all tellers
    $next = [];
    foreach ($tellers as $teller) {
        $sql = "SELECT queue_number FROM queue WHERE status='Waiting' AND department='$department' AND teller='$teller' ORDER BY queue_number ASC LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $next[$teller] = $row ? $row['queue_number'] : 'None';
    }

    // Fetch all waiting queue numbers
    $sql = "SELECT queue_number FROM queue WHERE status='Waiting' AND department='$department' ORDER BY queue_number ASC";
    $result = mysqli_query($conn, $sql);
    
    $waiting_list = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $waiting_list[] = $row['queue_number'];
    }

    // Limit the waiting list to 3 numbers
    $waiting_list = array_slice($waiting_list, 0, 3);

    $queue_data[$department] = [
        'tellers' => $tellers,  // Array of tellers
        'serving' => $serving,
        'next' => $next,
        'waiting' => $waiting_list
    ];
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .queue-table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
            font-size: 1.1rem;
        }
        td {
            font-size: 1rem;
            font-weight: bold;
        }
        .waiting-list {
            font-size: 0.9rem;
            font-weight: bold;
            color: #007bff;
        }
        .none {
            color: red;
        }
        .teller {
            color: green;
        }
    </style>
    <script>
        setTimeout(function() { location.reload(); }, 5000);
    </script>
</head>
<body>

<h2>Queue Display</h2>

<table class="queue-table">
    <thead>
        <tr>
            <th>Department</th>
            <th>Tellers</th>
            <th>Serving</th>
            <th>Next</th>
            <th>Waiting List</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($queue_data as $department => $data): ?>
        <tr>
            <td><?php echo ucfirst(strtolower($department)); ?></td>
            <td>
                <?php 
                // Display each teller's name (e.g., Teller1) in vertical
                foreach ($data['tellers'] as $index => $teller) {
                    echo "<span>$teller</span><br>";
                }
                ?>
            </td>
            <td>
                <?php 
                // Display Serving queue number aligned with each teller
                foreach ($data['tellers'] as $teller) {
                    echo "<span>{$data['serving'][$teller]}</span><br>";
                }
                ?>
            </td>
            <td>
                <?php 
                // Display Next queue number aligned with each teller
                foreach ($data['tellers'] as $teller) {
                    echo "<span>{$data['next'][$teller]}</span><br>";
                }
                ?>
            </td>
            <td>
                <?php if (!empty($data['waiting'])): ?>
                    <?php 
                    // Display the first 3 waiting numbers and show "More" if there are more
                    echo implode("<br>", $data['waiting']);
                    if (count($data['waiting']) > 3) {
                        echo "<br><span class='none'>More...</span>";
                    }
                    ?>
                <?php else: ?>
                    <span class="none">None</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
