<?php
require 'db.php';

header('Content-Type: application/json');

$sql = "SELECT queue_number, teller FROM queue WHERE status = 'Serving' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
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
