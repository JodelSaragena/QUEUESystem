<?php
$password = "yourpassword"; // Change this to your new admin password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashedPassword;
?>
