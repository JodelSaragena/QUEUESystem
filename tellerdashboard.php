<!-- <?php 
session_start();
require 'db.php';

if (!isset($_SESSION['teller'])) {
    header("Location: login.php");
    exit();
}

$teller_role = $_SESSION['teller']['role']; // teller's role

// Map teller roles to their respective transaction types
$transaction_map = [
    'tellerwithdraw' => 'withdrawal',
    'tellerdeposit' => 'deposit',
    'telleropenaccount' => 'open_account'
];

// Ensure the role exists in the mapping
if (!isset($transaction_map[$teller_role])) {
    die("Unauthorized access.");
}

$transaction_type = $transaction_map[$teller_role];

// Fetch only transactions related to the logged-in teller's role
$sql = "SELECT * FROM queue WHERE status IN ('waiting', 'serving') AND transaction_type = ? ORDER BY queue_number ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $transaction_type);
$stmt->execute();
$result = $stmt->get_result();

// Handle 'Call Next' button
if (isset($_POST['call_next'])) {
    $next_sql = "SELECT * FROM queue WHERE status='waiting' AND transaction_type = ? ORDER BY queue_number ASC LIMIT 1";
    $stmt = $conn->prepare($next_sql);
    $stmt->bind_param("s", $transaction_type);
    $stmt->execute();
    $next_user = $stmt->get_result()->fetch_assoc();

    if ($next_user) {
        $queue_id = $next_user['id'];
        $update_sql = "UPDATE queue SET status='serving' WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $queue_id);
        $stmt->execute();
        header("Location: tellerdashboard.php");
        exit();
    }
}

// Handle 'Mark Done' button
if (isset($_POST['mark_done']) && isset($_POST['queue_id'])) {
    $queue_id = $_POST['queue_id'];
    $update_sql = "UPDATE queue SET status='done' WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $queue_id);
    $stmt->execute();
    header("Location: tellerdashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Teller Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2 class="text-center">Welcome, <?php echo $_SESSION['teller']['username']; ?> (<?php echo ucfirst(str_replace('teller', '', $teller_role)); ?>)</h2>

    <div class="card shadow-lg mx-auto" style="max-width: 800px;">
        <div class="card-header" style="background-color: #433878; color: white; text-align: center; padding: 10px 20px; font-size: 1.2rem;">
            <h5>Your Assigned Transactions (<?php echo ucfirst(str_replace('_', ' ', $transaction_type)); ?>)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive"> 
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 12%;">Queue Number</th>
                            <th style="width: 18%;">Status</th>
                            <th style="width: 30%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?php echo $row['queue_number']; ?></strong></td>
                                <td>
                                    <span class="badge bg-<?php echo ($row['status'] == 'serving') ? 'success' : 'warning'; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'waiting'): ?>
                                        <form method="POST">
                                            <button type="submit" name="call_next" class="btn btn-primary btn-sm">Call Next</button>
                                        </form>
                                    <?php elseif ($row['status'] == 'serving'): ?>
                                        <form method="POST">
                                            <input type="hidden" name="queue_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="mark_done" class="btn btn-success btn-sm">Mark Done</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div> 
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="login.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</div>
</body>
</html>
 -->