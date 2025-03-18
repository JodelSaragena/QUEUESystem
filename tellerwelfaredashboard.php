<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tellerwelfare') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welfare Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #433878;
            color: white;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-4">
<h2 class="text-center">Welcome, <?php echo $_SESSION['username']; ?>!</h2> 
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header">🎉 Welfare Dashreboard</div>
                    <div class="card-body text-center">
                        <p>Welcome to the Welfare Dashboard!</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="login.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
