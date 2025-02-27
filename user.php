<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_type'])) {
    $transaction_type = $_POST['transaction_type'];

    // Get the last queue number for the selected transaction type
    $sql = "SELECT queue_number FROM queue WHERE transaction_type = '$transaction_type' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Extract the number from the last queue number
    if ($row) {
        preg_match('/\d+/', $row['queue_number'], $matches);
        $last_queue_number = $matches[0];
        $new_queue_number = $last_queue_number + 1;
    } else {
        $new_queue_number = 1; // Start from 1 if no previous queue
    }

    // Add prefix based on transaction type
    $prefix = ($transaction_type == 'deposit') ? 'D-' : (($transaction_type == 'withdrawal') ? 'W-' : 'O-');
    $formatted_queue_number = $prefix . $new_queue_number;

    // Insert into queue table
    $sql = "INSERT INTO queue (transaction_type, queue_number, status) 
            VALUES ('$transaction_type', '$formatted_queue_number', 'waiting')";
    mysqli_query($conn, $sql);
}

// Get the latest queue number for display
$sql = "SELECT queue_number, status FROM queue WHERE status != 'done' ORDER BY created_at DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$user_queue = mysqli_fetch_assoc($result);

mysqli_close($conn);

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
