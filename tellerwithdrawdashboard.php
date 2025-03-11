<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tellerwithdraw') {
    header("Location: login.php");
    exit();
}

// Fetch  wtihdrawal transactions 
$sql = "SELECT * FROM queue WHERE transaction_type = 'withdrawal' AND status != 'done' ORDER BY created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<title>Withdraw Teller Dashboard</title>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <h3>Withdrawal Transactions</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Queue Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['queue_number']; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'waiting') { ?>
                                <a href="call_next.php?id=<?php echo $row['id']; ?>" class="btn btn-info" style="background-color: yellow; border-color: yellow;">Call Next</a>
                                <?php } ?>
                            <?php if ($row['status'] == 'serving') { ?>
                                <a href="mark_done.php?id=<?php echo $row['id']; ?>" class="btn btn-success" style="background-color: #433878; border-color: #433878;" >Mark as Done</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="login.php" class="btn btn-danger">Logout</a>

    </div>
</body>
</html>
