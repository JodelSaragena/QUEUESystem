<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_type'])) {
    $transaction_type = $_POST['transaction_type'];


    if ($transaction_type == "account opening") {
        $transaction_type = "open_account"; 
    }

    // prefix 
    $prefix = ($transaction_type == "deposit") ? "D-" :
              (($transaction_type == "withdrawal") ? "W-" : "A-");

    // Get the last queue number /specific transaction type
    $stmt = $conn->prepare("SELECT queue_number FROM queue WHERE transaction_type = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $transaction_type);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // In. queue number
    $new_queue_number = 1;

    if ($row) {
        // Extract the numeric part of the last queue number ( A5 → 5)
        preg_match('/(\d+)$/', $row['queue_number'], $matches);
        if (isset($matches[1])) {
            $new_queue_number = (int)$matches[1] + 1;
        }
    }

    // Format queue number (D1, W2, A3)
    $formatted_queue_number = $prefix . $new_queue_number;

    // Check if the generated queue number already exists (extra safety)
    $stmt = $conn->prepare("SELECT COUNT(*) FROM queue WHERE queue_number = ?");
    $stmt->bind_param("s", $formatted_queue_number);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // If duplicate check again
    while ($count > 0) {
        $new_queue_number++;
        $formatted_queue_number = $prefix . $new_queue_number;

        $stmt = $conn->prepare("SELECT COUNT(*) FROM queue WHERE queue_number = ?");
        $stmt->bind_param("s", $formatted_queue_number);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
    }

    // Insert into queue table
    $stmt = $conn->prepare("INSERT INTO queue (queue_number, transaction_type, status) VALUES (?, ?, 'waiting')");
    $stmt->bind_param("ss", $formatted_queue_number, $transaction_type);
    $stmt->execute();
    $stmt->close();

    $_SESSION['queue_number'] = $formatted_queue_number;
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
