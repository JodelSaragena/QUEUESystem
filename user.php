<?php
require 'db.php';
session_start();
date_default_timezone_set('Asia/Manila'); // Ensure correct timezone

// CSRF Protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$today = date('Y-m-d');
$transaction_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_type'], $_POST['csrf_token'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    $transaction_type = $_POST['transaction_type'];

    if ($transaction_type == "account opening") {
        $transaction_type = "open_account"; 
    }

    $prefix = ($transaction_type == "deposit") ? "D-" :
              (($transaction_type == "withdrawal") ? "W-" : "A-");

    if (!empty($transaction_type)) {
        $stmt = $conn->prepare("SELECT queue_number FROM queue WHERE transaction_type = ? AND date_generated = CURDATE() ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("s", $transaction_type);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        $new_queue_number = 1;
        if ($row) {
            preg_match('/(\d+)$/', $row['queue_number'], $matches);
            if (isset($matches[1])) {
                $new_queue_number = (int)$matches[1] + 1;
            }
        }

        $formatted_queue_number = $prefix . $new_queue_number;

        $stmt = $conn->prepare("INSERT INTO queue (queue_number, transaction_type, status, date_generated) VALUES (?, ?, 'waiting', CURDATE())");
        $stmt->bind_param("ss", $formatted_queue_number, $transaction_type);
        $stmt->execute();
        $stmt->close();

        $_SESSION['queue_number'] = $formatted_queue_number;

        // Redirect to refresh session
        header("Location: user.php");
        exit;
    }
}

// Retrieve latest queue number for the user
$user_queue = null;
if (isset($_SESSION['queue_number'])) {
    $sql = "SELECT queue_number, status FROM queue WHERE queue_number = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['queue_number']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_queue = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F0F0F0; /* Light gray background */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        /*.container {
            border-radius: 15px; 
            border: 3px solid rgba(126, 96, 191, 0.9); 
            padding: 20px;
            background: rgba(255, 255, 255, 0.5); 
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }*/

        .card {
            border-radius: 12px; /* Soft corners */
            border: 3px solid rgba(126, 96, 191, 0.9); /* Matched color */
            overflow: hidden;
        }

        .card-header {
            background-color: #433878;
            color: white;
            text-align: center;
        }

        .btn-deposit {
            background-color: #007bff;
            color: white;
        }

        .btn-withdrawal {
            background-color: #dc3545;
            color: white;
        }

        .btn-open-account {
            background-color: #28a745;
            color: white;
        }

        .btn-rounded:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg mt-4">
                    <div class="card-header">
                        <h5>Generate Queue Number</h5>
                    </div>
                    <div class="card-body text-center">
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <button type="submit" name="transaction_type" value="deposit" class="btn btn-primary">Deposit</button>
                            <button type="submit" name="transaction_type" value="withdrawal" class="btn btn-danger">Withdrawal</button>
                            <button type="submit" name="transaction_type" value="open_account" class="btn btn-success">Open Account</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-lg mt-4">
                    <div class="card-header">
                        <h5>Your Queue Status</h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($user_queue): ?>
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