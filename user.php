<?php 
require 'db.php';
session_start();
date_default_timezone_set('Asia/Manila'); 

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$prefixes = [
    'ADMIN' => 'A-', 'ACCOUNTS' => 'B-', 'DOCUMENTATION' => 'C-',
    'CREWING' => 'D-', 'TECHOPS' => 'E-', 'SOURCING' => 'F-',
    'TANKER' => 'G-', 'WELFARE' => 'H-'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['services'], $_POST['csrf_token'])) {
    // Secure CSRF token validation
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }
    
    $services = $_POST['services'];
    $prefix = $prefixes[$services] ?? 'X-';

    if (!empty($services)) {
        $conn->query("LOCK TABLES queue WRITE");

        //last queue number for the selected service
        $stmt = $conn->prepare("SELECT queue_number FROM queue WHERE services = ? AND DATE(date_generated) = CURDATE() ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("s", $services);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        $last_queue_number = isset($row['queue_number']) ? intval(preg_replace('/\D/', '', $row['queue_number'])) : 0;
        $formatted_queue_number = $prefix . ($last_queue_number + 1);
        
        // Insert the new queue number 
        $stmt = $conn->prepare("INSERT INTO queue (queue_number, services, status, date_generated) VALUES (?, ?, 'Waiting', CURDATE())");
        $stmt->bind_param("ss", $formatted_queue_number, $services);
        $stmt->execute();
        $stmt->close();
        
        $conn->query("UNLOCK TABLES");

        $_SESSION['queue_number'] = $formatted_queue_number;

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        header("Location: user.php");
        exit;
    }
}

// Get user's current queue number
$user_queue = null;
if (isset($_SESSION['queue_number'])) {
    $stmt = $conn->prepare("SELECT queue_number, status FROM queue WHERE queue_number = ? LIMIT 1");
    $stmt->bind_param("s", $_SESSION['queue_number']);
    $stmt->execute();
    $user_queue = $stmt->get_result()->fetch_assoc();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--<a href="admindashboard.php" class="btn btn-light btn-sm">&lt;</a>-->
                        <h6 class="flex-grow-1 text-center m-0">Generate Queue Number</h6>
                        <div style="width: 32px;"></div>
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="mb-3">
                                <select class="form-select" name="services" required>
                                    <option value="" disabled selected>Service</option>
                                    <?php foreach ($prefixes as $key => $prefix) : ?>
                                        <option value="<?php echo $key; ?>"> <?php echo ucfirst(strtolower($key)); ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">Generate</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6>Your Queue</h6>
                    <?php if ($user_queue): ?>
                        <button class="btn btn-sm btn-primary" onclick="printQueueNumber()">🖨Print Number</button>
                    <?php endif; ?>
                </div>
                <div class="card-body text-center">
                    <?php if ($user_queue): ?>
                        <h3 id="queueNumberPrint" style="font-size: 8rem;"> <?php echo $user_queue['queue_number']; ?></h3>
                    <?php else: ?>
                        <p class="alert alert-secondary">You have not joined the queue yet.</p>
                    <?php endif; ?>
                </div>
            </div>

            <script>
   function printQueueNumber() {
    const printWindow = window.open('', '', 'width=600,height=800');
    
    const queueNumber = document.getElementById("queueNumberPrint").innerText;
    
    const currentDate = new Date();
    const date = (currentDate.getMonth() + 1) + '/' + currentDate.getDate() + '/' + currentDate.getFullYear().toString().slice(-2);
    const time = currentDate.getHours() % 12 || 12;
    const minutes = currentDate.getMinutes().toString().padStart(2, '0');
    const period = currentDate.getHours() < 12 ? 'AM' : 'PM';
    const timeString = time + ':' + minutes + ' ' + period;

    printWindow.document.write(`
        <html>
        <head>
            <title>Queue Number</title>
            <style>
                @media print {
                    html, body {
                        margin: 0;
                        padding: 0;
                        width: 100%;
                        height: 100%;
                    }
                    .print-container {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        width: 100vw;
                        height: 100vh;
                        page-break-inside: avoid;
                        text-align: center;
                        box-sizing: border-box;
                        padding: 0;
                        font-family: Arial, sans-serif;
                    }
                    .queue {
                        font-size: 30vw; /* auto-scales based on width */
                        line-height: 1;
                        margin: 0;
                    }
                    .subtext {
                        font-size: 3vw;
                        margin-top: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-container">
                <div class="subtext">Queue Number</div>
                <div class="queue">${queueNumber}</div>
                <div class="subtext">Thank you for waiting!</div>
                <div class="subtext">${date}, ${timeString}</div>
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}


</script>




            </div>
        </div>
    </div>
</body>
</html>

