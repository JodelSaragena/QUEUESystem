<?php
require 'db.php';

$sql = "SELECT queue_number, teller FROM queue WHERE status = 'Serving' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    echo json_encode([
        'queue_number' => $row['queue_number'],
        'teller' => $row['teller']
    ]);
} else {
    echo json_encode([
        'queue_number' => null,
        'teller' => null
    ]);
}

mysqli_close($conn);
?>
