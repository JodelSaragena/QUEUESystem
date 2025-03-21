<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || !isset($_SESSION['department'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$tellerRole = $_SESSION['role']; // teller1, teller2, teller3
$department = $_SESSION['department'];

// Get all queue numbers for this department that are NOT 'Done'
$query = "SELECT * FROM queue WHERE department='$department' AND status != 'Done' ORDER BY id ASC";
$result = mysqli_query($conn, $query);

// Fetch queue numbers into an array
$queue_numbers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $queue_numbers[] = $row;
}

// Distribute queue numbers dynamically among teller1, teller2, and teller3
$tellerQueues = [[], [], []];

foreach ($queue_numbers as $index => $queue) {
    $assignedTeller = ($index % 3) + 1; // Cycle through 1, 2, 3
    $tellerQueues[$assignedTeller - 1][] = $queue; // Store queues per teller
}

// Determine which teller's queue to display
$tellerIndex = intval(substr($tellerRole, -1)) - 1; // Convert 'teller1' → 0, 'teller2' → 1, 'teller3' → 2
$myQueue = $tellerQueues[$tellerIndex];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $department; ?> Teller Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Welcome(<?php echo ucfirst($tellerRole); ?>)</h2>
            <!-- Logout Button -->
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <h3>Department: <?php echo ucfirst($department); ?></h3>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Queue Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($myQueue)) : ?>
                    <?php foreach ($myQueue as $row) : ?>
                        <tr>
                            <td><?php echo $row['queue_number']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                            <?php if ($row['status'] == 'Waiting') { ?>
                                <a href="process_queue.php?id=<?php echo $row['id']; ?>&action=call" class="btn btn-primary">Call Next</a>
                            <?php } elseif ($row['status'] == 'Serving') { ?>
                                <a href="process_queue.php?id=<?php echo $row['id']; ?>&action=done" class="btn btn-success">Done</a>
                            <?php } ?>
                        </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="3" class="text-center">No queue numbers assigned yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
