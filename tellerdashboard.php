<?php
session_start();
require 'db.php';

if (!isset($_SESSION['teller'])) {
    header("Location: teller.php");
    exit();
}

if (isset($_POST['call_next'])) {
    // Get the next user in line
    $sql = "SELECT * FROM queue WHERE status='waiting' ORDER BY queue_number ASC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $next_user = mysqli_fetch_assoc($result);

    if ($next_user) {
        $queue_id = $next_user['id'];
        $update_sql = "UPDATE queue SET status='serving' WHERE id='$queue_id'";
        mysqli_query($conn, $update_sql);
        header("Location: tellerdashboard.php");
        exit();
    }
}

if (isset($_POST['mark_done']) && isset($_POST['queue_id'])) {
    $queue_id = $_POST['queue_id'];
    $update_sql = "UPDATE queue SET status='done' WHERE id='$queue_id'";
    mysqli_query($conn, $update_sql);
    header("Location: tellerdashboard.php");
    exit();
}

$sql = "SELECT * FROM queue WHERE status IN ('waiting', 'serving') ORDER BY queue_number ASC";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
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
    <h2 class="text-center">Welcome, <?php echo $_SESSION['teller']['username']; ?></h2>

   
    <div class="card shadow-lg mx-auto" style="max-width: 800px;">
        <div class="card-header" style="background-color: #433878; color: white; text-align: center; padding: 10px 20px; font-size: 1.2rem;">
            <h5>Queue List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive"> 
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 12%;">Queue Number</th>
                            <th style="width: 25%;">Transaction Type</th>
                            <th style="width: 18%;">Status</th>
                            <th style="width: 30%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                  
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><strong><?php echo $row['queue_number']; ?></strong></td>
                                <td><?php echo ucfirst($row['transaction_type']); ?></td>
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

    <!-- Logout-->
    <div class="text-center mt-3">
        <a href="teller.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</div>
</body>
</html>
