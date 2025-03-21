<?php
require 'db.php';

$username = 'admin';
$password = 'admin';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';

$stmt = $conn->prepare("INSERT INTO tellers (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
