<?php
require 'db.php';

$date_today = date('Y-m-d'); // Get today's date

$query = "SELECT * FROM queue WHERE DATE(created_at) = '$date_today' ORDER BY status ASC, queue_number ASC";
$result = mysqli_query($conn, $query);
$queues = ['Waiting' => [], 'Serving' => [], 'Done' => []];

while ($row = mysqli_fetch_assoc($result)) {
    $queues[$row['status']][] = $row;
}

header('Content-Type: application/json');
echo json_encode($queues);
?>
