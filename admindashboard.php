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
    // Initialize array to prevent undefined keys
    $stats[$type] = [
        'today' => 0,
        'month' => 0,
        'year' => 0
    ];

    // Fetch transactions for today
    $sql_today = "SELECT COUNT(*) as count FROM queue WHERE transaction_type=? AND DATE(created_at) = CURDATE()";
    $stmt_today = $conn->prepare($sql_today);
    $stmt_today->bind_param("s", $type);
    $stmt_today->execute();
    $result_today = $stmt_today->get_result();
    if ($row_today = $result_today->fetch_assoc()) {
        $stats[$type]['today'] = $row_today['count'];
    }

    // Fetch transactions for this month
    $sql_month = "SELECT COUNT(*) as count FROM queue WHERE transaction_type=? AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
    $stmt_month = $conn->prepare($sql_month);
    $stmt_month->bind_param("s", $type);
    $stmt_month->execute();
    $result_month = $stmt_month->get_result();
    if ($row_month = $result_month->fetch_assoc()) {
        $stats[$type]['month'] = $row_month['count'];
    }

    // Fetch transactions for this year
    $sql_year = "SELECT COUNT(*) as count FROM queue WHERE transaction_type=? AND YEAR(created_at) = YEAR(CURDATE())";
    $stmt_year = $conn->prepare($sql_year);
    $stmt_year->bind_param("s", $type);
    $stmt_year->execute();
    $result_year = $stmt_year->get_result();
    if ($row_year = $result_year->fetch_assoc()) {
        $stats[$type]['year'] = $row_year['count'];
    }
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
        .dashboard-container {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        .stats-container {
            flex: 1;
            max-width: 40%;
        }
        .table-container {
            flex: 2;
            max-width: 60%;
        }
        .table th, .table td {
            max-width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
            padding: 8px;
            font-size: 1rem;
        }
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        .card-header {
            background-color: #433878;
            color: white;
            text-align: center;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.9rem;
        }
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }
            .stats-container, .table-container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-3">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-center flex-grow-1">Welcome! Admin Dashboard</h2>
        <div class="d-flex">
            <a href="createaccount.php" class="btn btn-primary me-2">Create Account</a>
            <a href="login.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <!-- Transaction Summary (Left Side) -->
        <div class="stats-container">
            <div class="card shadow-lg mb-3">
                <div class="card-header">Transaction Summary</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Type</th>
                                    <th>Today</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    <th>Export</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaction_types as $type): ?>
                                    <tr>
                                        <td><?php echo ucfirst(str_replace('_', ' ', $type)); ?></td>
                                        <td><?php echo $stats[$type]['today']; ?></td>
                                        <td><?php echo $stats[$type]['month']; ?></td>
                                        <td><?php echo $stats[$type]['year']; ?></td>
                                <td>
                                            <a href="export_pdf.php?type=<?php echo $type; ?>" class="btn btn-success btn-sm">Export pdf</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
                setInterval(() => {
                    location.reload();
                }, 10000); // Refresh every 60 seconds
        </script>

        <!-- All Transactions (Right Side) -->
        <div class="table-container">
            <div class="card shadow-lg">
                <div class="card-header">All Transactions</div>
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
