<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all transactions
$sql = "SELECT * FROM queue ORDER BY status, queue_number ASC";
$result = $conn->query($sql);

// Fetch transaction counts
$transaction_types = ['withdrawal', 'deposit', 'open_account'];
$stats = [];

foreach ($transaction_types as $type) {
    // Today
    $sql_today = "SELECT COUNT(*) as count FROM queue WHERE transaction_type=? AND DATE(created_at) = CURDATE()";
    $stmt_today = $conn->prepare($sql_today);
    $stmt_today->bind_param("s", $type);
    $stmt_today->execute();
    $result_today = $stmt_today->get_result();
    $row_today = $result_today->fetch_assoc();
    $today_count = $row_today ? $row_today['count'] : 0;

    // This Month
    $sql_month = "SELECT COUNT(*) as count FROM queue WHERE transaction_type=? AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
    $stmt_month = $conn->prepare($sql_month);
    $stmt_month->bind_param("s", $type);
    $stmt_month->execute();
    $result_month = $stmt_month->get_result();
    $row_month = $result_month->fetch_assoc();
    $month_count = $row_month ? $row_month['count'] : 0;

    // Total
    $sql_total = "SELECT COUNT(*) as count FROM queue WHERE transaction_type=?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("s", $type);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $row_total = $result_total->fetch_assoc();
    $total_count = $row_total ? $row_total['count'] : 0;

    // Store results
    $stats[$type] = [
        'today' => $today_count,
        'month' => $month_count,
        'total' => $total_count
    ];
}

// Update queue status - Mark as Done
if (isset($_POST['mark_done']) && isset($_POST['queue_id'])) {
    $queue_id = $_POST['queue_id'];
    $update_sql = "UPDATE queue SET status='done' WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $queue_id);
    $stmt->execute();
    header("Location: admindashboard.php");
    exit();
}

// Update queue status - Call Next
if (isset($_POST['call_next']) && isset($_POST['queue_id'])) {
    $queue_id = $_POST['queue_id'];
    $update_sql = "UPDATE queue SET status='serving' WHERE id=?";
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
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .stats-container .card {
          width: 45%;
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
    <!-- Top Section: Buttons on the Right & Title at the Center -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div> <!-- Empty div to balance alignment -->
        <h2 class="text-center flex-grow-1">Welcome! Admin Dashboard</h2>
        <br><br><br>
        <div class="d-flex">
            <a href="createaccount.php" class="btn btn-primary me-2">Create Account</a>
            <a href="login.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="stats-container">
            <?php foreach ($transaction_types as $type): ?>
                <div class="card shadow-lg mb-3">
                    <div class="card-header">Total <?php echo ucfirst(str_replace('_', ' ', $type)); ?> Transactions</div>
                    <div class="card-body text-center">
                        <p>Today: <strong><?php echo $stats[$type]['today']; ?></strong></p>
                        <p>This Month: <strong><?php echo $stats[$type]['month']; ?></strong></p>
                        <p>Overall: <strong><?php echo $stats[$type]['total']; ?></strong></p>
                        <a href="export_pdf.php?type=<?php echo $type; ?>" class="btn btn-success mb-3">
                            Export <?php echo ucfirst(str_replace('_', ' ', $type)); ?> Transactions
                        </a>

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
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="queue_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" name="call_next" class="btn btn-primary btn-sm">Call Next</button>
                                                </form>
                                                <form method="POST" class="d-inline">
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
</div>
</body>
</html>
