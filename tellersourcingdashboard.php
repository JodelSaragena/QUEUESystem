<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tellersourcing') {
    header("Location: login.php");
    exit();
}


// Fetch total employee count
$sql_count = "SELECT COUNT(*) as total FROM employees";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_employees = $row_count['total'];

// Fetch all employee names
$sql_employees = "SELECT id, name, role FROM employees ORDER BY id ASC";

$result_employees = $conn->query($sql_employees);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sourcing Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .card-header {
            background-color: #433878;
            color: white;
            text-align: center;
        }
        .table-responsive {
            max-height: 300px; 
            overflow-y: auto; 
            border: 1px solid #dee2e6;
        }

        .table thead {
            position: sticky;
            top: 0;
            background-color: #212529; 
            color: white;
            z-index: 2;
        }

    </style>
</head>
<body class="bg-light">
<div class="container mt-3">
    <h2 class="text-center">Sourcing Dashboard</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header">Total Employees</div>
                <div class="card-body text-center">
                    <h3><?php echo $total_employees; ?></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header">Employee List</div>
                <div class="card-body">
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result_employees->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['role']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <a href="login.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
