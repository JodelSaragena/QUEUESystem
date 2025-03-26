<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || !isset($_SESSION['services'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$tellerRole = $_SESSION['role']; // teller1, teller2, teller3
$services = $_SESSION['services'];

// Get queue numbers assigned to this teller that are NOT 'Done'
$query = "SELECT * FROM queue WHERE services=? AND teller=? AND status != 'Done' ORDER BY id ASC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $services, $tellerRole);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
        }
        .serving {
            background-color: #ffcc00;
            font-weight: bold;
        }
    </style> 
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Welcome (<?php echo ucfirst($tellerRole); ?>)</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
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
            <tbody id="queueTable">
                <?php if (!empty($myQueue)) : ?>
                    <?php foreach ($myQueue as $row) : ?>
                        <tr id="queue-<?php echo $row['id']; ?>" class="<?php echo $row['status'] == 'Serving' ? 'serving' : ''; ?>">
                            <td><?php echo $row['queue_number']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <?php if ($row['status'] == 'Waiting') { ?>
                                    <button class="btn btn-primary callNext" data-id="<?php echo $row['id']; ?>">Call Next</button>
                                <?php } elseif ($row['status'] == 'Serving') { ?>
                                    <button class="btn btn-success markDone" data-id="<?php echo $row['id']; ?>">Done</button>
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

    <audio id="notificationSound" src="ding.mp3"></audio> 

    <script>
        $(document).ready(function () {
            function loadQueue() {
                $.ajax({
                    url: "fetch_queue.php",
                    type: "GET",
                    success: function (data) {
                        $("#queueTable").html(data);
                    }
                });
            }

            $(".callNext").click(function () {
                var id = $(this).data("id");
                $.post("process_queue.php", { id: id, action: "call" }, function () {
                    $("#notificationSound")[0].play(); 
                    loadQueue();
                });
            });

            $(".markDone").click(function () {
                var id = $(this).data("id");
                $.post("process_queue.php", { id: id, action: "done" }, function () {
                    loadQueue();
                });
            });

            setInterval(loadQueue, 5000);
        });
    </script>
</body>
</html>
