<?php 
session_start();
include 'db.php';

if (!isset($_GET['dashboard']) || !isset($_SESSION[$_GET['dashboard']])) {
    header("Location: login.php");
    exit();
}

// Access the session data for the specific dashboard
$dashboardKey = $_GET['dashboard'];
$username = $_SESSION[$dashboardKey]['username'];
$services = $_SESSION[$dashboardKey]['services'];

// Get queue numbers for this teller that are NOT 'Done'
$query = "SELECT * FROM queue 
          WHERE services='$services'  
          AND status != 'Done' 
          AND DATE(created_at) = CURDATE()  
          ORDER BY id ASC";

$result = mysqli_query($conn, $query);

// Fetch queue numbers
$myQueue = [];
while ($row = mysqli_fetch_assoc($result)) {
    $myQueue[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo ucfirst($services); ?> Teller Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
        }
    </style>
    <script>
        setTimeout(function() { location.reload(); }, 5000);
    </script>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Welcome (<?php echo ucfirst($_SESSION[$dashboardKey]['role']); ?>)</h2>
            <a href="logout.php?dashboard=<?php echo $dashboardKey; ?>" class="btn btn-danger">Logout</a>
        </div>
        <h3>Services: <?php echo ucfirst($services); ?></h3>

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
                                    <a href="crewing_process_queue.php?dashboard=<?php echo $dashboardKey; ?>&id=<?php echo $row['id']; ?>&action=call" class="btn btn-primary">Serve</a>
                                <?php } elseif ($row['status'] == 'Serving' && $row['teller'] == $_SESSION[$dashboardKey]['role']) { ?>
                                    <a href="crewing_process_queue.php?dashboard=<?php echo $dashboardKey; ?>&id=<?php echo $row['id']; ?>&action=done" class="btn btn-success">Done</a>
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
