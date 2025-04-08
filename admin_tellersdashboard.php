<?php 
session_start();
include 'db.php';

// Use a dashboard token to isolate session data
$dashboardKey = isset($_GET['dashboard']) ? $_GET['dashboard'] : 'default';

if (!isset($_SESSION[$dashboardKey]['username']) || !isset($_SESSION[$dashboardKey]['role']) || !isset($_SESSION[$dashboardKey]['services'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION[$dashboardKey]['username'];
$role = $_SESSION[$dashboardKey]['role'];
$services = $_SESSION[$dashboardKey]['services'];

$query = "SELECT * FROM queue 
          WHERE services='$services'  
          AND status != 'Done' 
          AND DATE(created_at) = CURDATE()  
          ORDER BY id ASC";

$result = mysqli_query($conn, $query);

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
        body { font-family: 'Poppins', Arial, sans-serif; }
    </style> 
    <script> setTimeout(function() { location.reload(); }, 5000); </script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Welcome (<?php echo ucfirst($role); ?>)</h2>
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
                            <a href="process_queue.php?id=<?php echo $row['id']; ?>&action=call&dashboard=<?php echo $dashboardKey; ?>" class="btn btn-primary">Serve</a>
                        <?php } elseif ($row['status'] == 'Serving' && $row['teller'] == $role) { ?>
                            <a href="process_queue.php?id=<?php echo $row['id']; ?>&action=done&dashboard=<?php echo $dashboardKey; ?>" class="btn btn-success">Done</a>
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
