<?php
session_start();
require 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['teller']) || $_SESSION['teller']['role'] !== 'admin') {
    header("Location: teller.php");
    exit();
}

// Fetch all transactions
$sql = "SELECT * FROM queue ORDER BY status, queue_number ASC";
$result = $conn->query($sql);

// Fetch transaction counts
$transaction_types = ['withdrawal', 'deposit', 'open_account'];
$stats = [];

foreach ($transaction_types as $type) {
    // Total transactions today
    $sql_today = "SELECT COUNT(*) as count FROM queue WHERE transaction_type='$type' AND DATE(created_at) = CURDATE()";
    $result_today = $conn->query($sql_today)->fetch_assoc();
    
    // Total transactions this month
    $sql_month = "SELECT COUNT(*) as count FROM queue WHERE transaction_type='$type' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
    $result_month = $conn->query($sql_month)->fetch_assoc();
    
    // Total transactions overall
    $sql_total = "SELECT COUNT(*) as count FROM queue WHERE transaction_type='$type'";
    $result_total = $conn->query($sql_total)->fetch_assoc();
    
    $stats[$type] = [
        'today' => $result_today['count'] ?? 0,
        'month' => $result_month['count'] ?? 0,
        'total' => $result_total['count'] ?? 0
    ];
}

// Update queue status (Admin can mark transactions as 'done')
if (isset($_POST['mark_done']) && isset($_POST['queue_id'])) {
    $queue_id = $_POST['queue_id'];
    $update_sql = "UPDATE queue SET status='done' WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $queue_id);
    $stmt->execute();
    header("Location: admindashboard.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .table th, .table td {
            text-align: center;
            white-space: nowrap;
            font-size: 1rem;
            padding: 8px;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.9rem;
        }
        .card-header {
            background-color: #433878;
            color: white;
        }
        .dashboard-container {
            display: flex;
            gap: 20px;
        }
        .stats-container {
            flex: 1;
        }
        .table-container {
            flex: 1;
        }
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-3">
    <h2 class="text-center">Admin Dashboard</h2>
    <div class="dashboard-container">
        <div class="stats-container">
            <?php foreach ($transaction_types as $type): ?>
                <div class="card shadow-lg mb-3">
                    <div class="card-header">Total <?php echo ucfirst(str_replace('_', ' ', $type)); ?> Transactions</div>
                    <div class="card-body text-center">
                        <p>Today: <strong><?php echo $stats[$type]['today']; ?></strong></p>
                        <p>This Month: <strong><?php echo $stats[$type]['month']; ?></strong></p>
                        <p>Overall: <strong><?php echo $stats[$type]['total']; ?></strong></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="table-container">
            <div class="card shadow-lg">
                <div class="card-header text-center">All Transactions</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Queue No.</th>
                                    <th>Transaction</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><strong><?php echo $row['queue_number']; ?></strong></td>
                                        <td><?php echo ucfirst(str_replace('_', ' ', $row['transaction_type'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo ($row['status'] == 'serving') ? 'success' : 'warning'; ?>">
                                                <?php echo ucfirst($row['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] != 'done'): ?>
                                                <form method="POST">
                                                    <input type="hidden" name="queue_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" name="mark_done" class="btn btn-success btn-sm">Mark Done</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">✓ Done</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="teller.php" class="btn btn-danger">Logout</a>
    </div>
</div>
</body>
</html>
