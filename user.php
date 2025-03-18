<?php
require 'db.php';
require 'db.php';
date_default_timezone_set('Asia/Manila'); // Ensure correct timezone

$today = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_type'])) {
    $transaction_type = $_POST['transaction_type'];

    if ($transaction_type == "account opening") {
        $transaction_type = "open_account"; 
    }

    // Prefix based on transaction type
    $prefix = ($transaction_type == "deposit") ? "D-" :
              (($transaction_type == "withdrawal") ? "W-" : "A-");

    // Check the last queue number for today
    $stmt = $conn->prepare("SELECT queue_number FROM queue WHERE transaction_type = ? AND date_generated = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("ss", $transaction_type, $today);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Start from 1 if no queue exists today
    $new_queue_number = 1;
    if ($row) {
        preg_match('/(\d+)$/', $row['queue_number'], $matches);
        if (isset($matches[1])) {
            $new_queue_number = (int)$matches[1] + 1;
        }
    }

    // Format the queue number with prefix
    $formatted_queue_number = $prefix . $new_queue_number;

    // Insert the new queue number with today's date
    $stmt = $conn->prepare("INSERT INTO queue (queue_number, transaction_type, status, date_generated) VALUES (?, ?, 'waiting', ?)");
    $stmt->bind_param("sss", $formatted_queue_number, $transaction_type, $today);
    $stmt->execute();
    $stmt->close();

    $_SESSION['queue_number'] = $formatted_queue_number;
}

// Retrieve latest queue number for the user
$sql = "SELECT queue_number, status FROM queue WHERE queue_number = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['queue_number']);
$stmt->execute();
$result = $stmt->get_result();
$user_queue = $result->fetch_assoc();
$stmt->close();

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center">Welcome to the Queuing System</h2>

        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg mt-4" style="max-width: 400px; margin: 0 auto;">
                    <div class="card-header" style="background-color: #433878; color: white; text-align: center;">
                        <h5>Generate Queue Number</h5>
                    </div>

                    <div class="card-body text-center">
                        <form method="POST">
                            <button type="submit" name="transaction_type" value="deposit" class="btn btn-primary">Deposit</button>
                            <button type="submit" name="transaction_type" value="withdrawal" class="btn btn-warning">Withdrawal</button>
                            <button type="submit" name="transaction_type" value="open_account" class="btn btn-success">Open Account</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-lg mt-4" style="max-width: 400px; margin: 0 auto;">
                    <div class="card-header" style="background-color: #433878; color: white; text-align: center;">
                        <h5>Your Queue Status</h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($user_queue && $user_queue['status'] != 'done'): ?>
                            <p>Your Queue Number:</p>
                            <h1 style="font-size: 8rem; font-weight: bold;"><?php echo $user_queue['queue_number']; ?></h1>
                            <p>Status: <strong><?php echo ucfirst($user_queue['status']); ?></strong></p>
                        <?php else: ?>
                            <p class="alert alert-secondary">You have not joined the queue yet.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
