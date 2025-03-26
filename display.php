<?php      
require 'db.php';

$departments = ['ADMIN', 'ACCOUNTS', 'DOCUMENTATION', 'CREWING', 'TECHOPS', 'SOURCING', 'TANKER', 'WELFARE'];
$queue_data = [];

$sql = "SELECT queue_number, teller, services FROM queue WHERE status IN ('Waiting', 'Serving') ORDER BY queue_number ASC";
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
            <th>Queue No.</th>
            <th>Teller</th>
            <th>Department</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($queue_data as $data): ?>
        <tr>
            <td><?php echo $data['queue_number']; ?></td>
            <td><?php echo $data['teller']; ?></td>
            <td><?php echo ucfirst(strtolower($data['services'])); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
