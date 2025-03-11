<?php
require 'db.php';
$result = $conn->query("SELECT COUNT(*) AS total FROM tellers");
$row = $result->fetch_assoc();
echo $row['total'];
?>
