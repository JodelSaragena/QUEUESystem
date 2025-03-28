<?php 
require 'db.php';
session_start();
date_default_timezone_set('Asia/Manila'); 

// Ensure CSRF token is generated only once per session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$tellers = ['Teller1', 'Teller2', 'Teller3']; 
$prefixes = [
    'ADMIN' => 'A-', 'ACCOUNTS' => 'B-', 'DOCUMENTATION' => 'C-',
    'CREWING' => 'D-', 'TECHOPS' => 'E-', 'SOURCING' => 'F-',
    'TANKER' => 'G-', 'WELFARE' => 'H-'
];

// Handle queue generation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['services'], $_POST['teller'], $_POST['csrf_token'])) {
    // Secure CSRF token validation
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }
    
    $services = $_POST['services'];
    $teller = $_POST['teller'];
    $prefix = $prefixes[$services] ?? 'X-';

    if (!empty($services) && !empty($teller)) {
        $conn->query("LOCK TABLES queue WRITE");

        // Get the last queue number for the selected service
        $stmt = $conn->prepare("SELECT queue_number FROM queue WHERE services = ? AND DATE(date_generated) = CURDATE() ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("s", $services);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        
        $last_queue_number = isset($row['queue_number']) ? intval(preg_replace('/\D/', '', $row['queue_number'])) : 0;
        $formatted_queue_number = $prefix . ($last_queue_number + 1);
        
        // Insert the new queue number
        $stmt = $conn->prepare("INSERT INTO queue (queue_number, services, status, teller, date_generated) VALUES (?, ?, 'Waiting', ?, CURDATE())");
        $stmt->bind_param("sss", $formatted_queue_number, $services, $teller);
        $stmt->execute();
        $stmt->close();
        
        $conn->query("UNLOCK TABLES");

        $_SESSION['queue_number'] = $formatted_queue_number;

        // Regenerate CSRF token after successful form submission
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        header("Location: user.php");
        exit;
    }
}

// Get user's current queue number
$user_queue = null;
if (isset($_SESSION['queue_number'])) {
    $stmt = $conn->prepare("SELECT queue_number, status, teller FROM queue WHERE queue_number = ? LIMIT 1");
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
                        <a href="admindashboard.php" class="btn btn-light btn-sm">&lt;</a>
                        <h6 class="flex-grow-1 text-center m-0">Generate Queue Number</h6>
                        <div style="width: 32px;"></div> <!-- Placeholder to balance the flexbox alignment -->
                    </div>

                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div class="row g-2">
                                <div class="col-6">
                                    <select class="form-select" name="services" required>
                                        <option value="" disabled selected>Service</option>
                                        <?php foreach ($prefixes as $key => $prefix) : ?>
                                            <option value="<?php echo $key; ?>"> <?php echo ucfirst(strtolower($key)); ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select class="form-select" name="teller" required>
                                        <option value="" disabled selected>Teller</option>
                                        <?php foreach ($tellers as $teller) : ?>
                                            <option value="<?php echo $teller; ?>"> <?php echo $teller; ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-primary w-auto mt-4 d-block mx-auto">Generate</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow mt-3">
                    <div class="card-header d-flex justify-content-between">
                        <h6>Your Queue</h6>
                        <?php if ($user_queue): ?>
                            <button class="btn btn-secondary btn-sm" onclick="printQueue()">🖨 Print Number</button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($user_queue): ?>
                            <h3 id="queueNumberPrint" style="font-size: 8rem;"> <?php echo $user_queue['queue_number']; ?></h3>
                            <p><strong>Status:</strong> <?php echo ucfirst($user_queue['status']); ?></p>
                            <p><strong>Teller:</strong> <?php echo $user_queue['teller']; ?></p>
                        <?php else: ?>
                            <p class="alert alert-secondary">You have not joined the queue yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function printQueue() {
        var queueNumber = document.getElementById("queueNumberPrint").innerText;
        var tellerName = "<?php echo $user_queue ? $user_queue['teller'] : ''; ?>"; 
        var printWindow = window.open('', '', 'width=400,height=600');
        printWindow.document.write('<html><head><title>Print Queue</title></head><body>');
        printWindow.document.write('<h2 style="text-align: center;">Queue Number</h2>');
        //printWindow.document.write('<h2 style="text-align: center;">Codeit Inc.</h2>');
        printWindow.document.write('<h1 style="text-align: center; font-size: 5rem;">' + queueNumber + '</h1>');
        printWindow.document.write('<p style="text-align: center; font-size: 1.2rem;">Teller: <strong>' + tellerName + '</strong></p>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
    </script>
</body>
</html>
