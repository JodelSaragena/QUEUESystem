<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tellercrewing') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teller Crewing Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #433878;
            color: white;
            font-weight: bold;
        }
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }
        .left-section, .right-section {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <a href="login.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="dashboard-container mt-2">
            <div class="left-section">
                <div class="card mt-1 shadow">
                    <div class="card-header">📌 Teller Crewing Officer</div>
                    <div class="card-body">
                        <p>✅ Responsible for managing employees in teller operations.</p>
                    </div>
                </div>
            </div>

            <div class="right-section">
                <div class="card shadow">
                    <div class="card-header">👨‍💼 Employee Information Management</div>
                    <div class="card-body text-center">
                        <p>Manage Employees' personal details and updates.</p>
                        <a href="employeedata.php" class="btn btn-primary">Employees</a>
                        <div class="container mt-3 text-end">
               </div>
             </div>
            </div>
        </div>
    </div>
</body>
</html>
