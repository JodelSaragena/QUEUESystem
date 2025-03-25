<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all tellers
$sql = "SELECT id, username, role FROM tellers ORDER BY role ASC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .table th, .table td {
            text-align: center;
            padding: 8px;
        }
        .card-header {
            background-color: white;
            color: black;
            text-align: center;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-center flex-grow-1">Admin Dashboard</h2>
        <div>
            <a href="createaccount.php" class="btn btn-primary">Create Account</a>
            <a href="login.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-header">Teller Accounts</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <!--<th>ID</th>-->
                            <th>Username</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <!--<td><?php echo $row['id']; ?></td>-->
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo ucfirst($row['role']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
