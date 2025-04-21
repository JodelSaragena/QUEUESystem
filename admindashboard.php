<?php 
session_start();
require 'db.php';

if (!isset($_GET['dashboard']) || !isset($_SESSION[$_GET['dashboard']])) {
    header("Location: login.php");
    exit();
}

$dayTotal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM queue WHERE DATE(created_at) = CURDATE()"))['total'] ?? 0;
$weekTotal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM queue WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)"))['total'] ?? 0;
$monthTotal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM queue WHERE MONTH(created_at) = MONTH(CURDATE())"))['total'] ?? 0;
$yearTotal = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM queue WHERE YEAR(created_at) = YEAR(CURDATE())"))['total'] ?? 0;

$labels = [];
$serviceData = [];
$colors = ['#433878', '#6AB04C', '#FF7979', '#F9CA24', '#1E90FF', '#8E44AD', '#E67E22', '#95A5A6'];
$serviceResult = mysqli_query($conn, "SELECT services, COUNT(*) AS total FROM queue GROUP BY services");
while ($row = mysqli_fetch_assoc($serviceResult)) {
    $labels[] = $row['services'];
    $serviceData[] = $row['total'];
}



// Count total accounts created
$count_query = $conn->query(query: "SELECT COUNT(*) as total FROM tellers");
$count_result = $count_query->fetch_assoc();
$total_accounts = $count_result['total'];

// Fetch all teller accounts
$accounts_query = $conn->query("SELECT id, username, role, services FROM tellers");
$accounts = $accounts_query->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $services = trim($_POST['services']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($role) || empty($services)) {
        echo "<script>alert('All fields are required!'); window.location.href='admindashboard.php?dashboard=" . $_GET['dashboard'] . "';</script>";
        exit();
    }
    // Prevent duplicate usernames
    $check_query = $conn->prepare("SELECT id FROM tellers WHERE username = ?");
    $check_query->bind_param("s", $username);
    $check_query->execute();
    $check_result = $check_query->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists!'); window.location.href='admindashboard.php?dashboard=" . $_GET['dashboard'] . "';</script>";
        exit();
    }


    // Hash password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prevent duplicate usernames
    $check_query = $conn->prepare("SELECT id FROM tellers WHERE username = ?");
    $check_query->bind_param("s", $username);
    $check_query->execute();
    $check_result = $check_query->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists!'); window.location.href='admindashboard.php?dashboard=" . $_GET['dashboard'] . "';</script>";
        exit();
    }

    // Insert new teller account
    $stmt = $conn->prepare("INSERT INTO tellers (username, password, role, services) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $username, $hashed_password, $role, $services);
    if ($stmt->execute()) {
        echo "<script>alert('Teller account created successfully!'); window.location.href='admindashboard.php?dashboard=" . $_GET['dashboard'] . "';</script>";

    } else {
        die("Execute failed: " . $stmt->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }
        .top-nav {
            background-color: #003092;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container {
            padding: 30px;
        }
        .status-card, .queue-card, .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>
    <div class="top-nav">
        <h5 class="mb-0">Admin Dashboard</h5>
        <div>
            <a href="admindashboard.php?dashboard=<?= $_GET['dashboard']; ?>" class="btn btn-light btn-sm me-2"><i class="bi bi-house-door"></i> Home</a>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>

    <div class="container">

        <h4 class="text-primary"><i class="bi bi-card-checklist"></i> Queue Status</h4>
        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="queue-card p-3"><h6 class="text-center">Waiting</h6><ul class="list-group queue-waiting"></ul></div></div>
            <div class="col-md-4"><div class="queue-card p-3"><h6 class="text-center">Serving</h6><ul class="list-group queue-serving"></ul></div></div>
            <div class="col-md-4"><div class="queue-card p-3"><h6 class="text-center">Done</h6><ul class="list-group queue-done"></ul></div></div>
        </div>



        <h4 class="text-primary"><i class="bi bi-bar-chart-line"></i> Status Overview</h4>
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="status-card p-3 text-center">
            <h6>Today</h6>
            <p><?= $dayTotal ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card p-3 text-center">
            <h6>This Week</h6>
            <p><?= $weekTotal ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card p-3 text-center">
            <h6>This Month</h6>
            <p><?= $monthTotal ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="status-card p-3 text-center">
            <h6>This Year</h6>
            <p><?= $yearTotal ?></p>
        </div>
    </div>
</div>



<h4 class="text-primary"><i class="bi bi-pie-chart"></i> Service Overview</h4>
<div class="row mb-4">
    <div class="col-md-7 mx-auto">
        <div class="card p-3">
            <div class="row">
                <!-- Service Breakdown List (Left Side) -->
                <div class="col-md-6">
                    <div style="width: 100%;">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($labels as $index => $label): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-1 px-2 small">
                                    <?= htmlspecialchars($label); ?>
                                    <span>
                                        <span class="badge rounded-pill" style="background-color: <?= $colors[$index % count($colors)]; ?>; width: 12px; height: 12px; display: inline-block; margin-right: 10px;"></span>
                                        <?= $serviceData[$index]; ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Pie Chart (Right Side) -->
                <div class="col-md-5 d-flex justify-content-center align-items-center">
                    <canvas id="serviceChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>





        <h4 class="text-primary"><i class="bi bi-person-plus"></i> Manage Accounts</h4>
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header text-center">Create New Teller Account</div>
            <div class="card-body">
                <form method="POST" action="admindashboard.php?dashboard=<?= $_GET['dashboard']; ?>">
                    <div class="mb-3">
                        <label class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role:</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="teller1">Teller 1</option>
                            <option value="teller2">Teller 2</option>
                            <option value="teller3">Teller 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Services:</label>
                        <select name="services" class="form-select" required>
                            <option value="ADMIN">Admin</option>
                            <option value="ACCOUNTS">Accounts</option>
                            <option value="DOCUMENTATION">Documentation</option>
                            <option value="CREWING">Crewing</option>
                            <option value="TECHOPS">Tech Ops</option>
                            <option value="SOURCING">Sourcing</option>
                            <option value="TANKER">Tanker</option>
                            <option value="WELFARE">Welfare</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
    <div class="card shadow">
        <div class="card-header text-center">Total Accounts Created: <?= $total_accounts; ?></div>
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Services</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?= htmlspecialchars($account['username']); ?></td>
                            <td><?= htmlspecialchars($account['role']); ?></td>
                            <td><?= htmlspecialchars($account['services']); ?></td>
                            <td>
                                <?php if ($account['role'] !== 'admin'): ?>
                                    <button class="btn btn-danger btn-sm" onclick="deleteAccount(<?= $account['id']; ?>)">Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
        function deleteAccount(accountId) {
            if (confirm("Are you sure you want to delete this account?")) {
                window.location.href = "delete_account.php?id=" + accountId;
            }
        }
    </script>

<script>
    var ctx = document.getElementById('serviceChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [{
                label: 'Services',
                data: <?= json_encode($serviceData); ?>,
                backgroundColor: <?= json_encode($colors); ?>
            }]
        }
    });

    function fetchQueueData() {
        fetch('fetch_queue.php')
            .then(response => response.json())
            .then(data => {
                updateQueueList('queue-waiting', data.Waiting);
                updateQueueList('queue-serving', data.Serving);
                updateQueueList('queue-done', data.Done);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateQueueList(className, list) {
        const container = document.querySelector(`.${className}`);
        container.innerHTML = '';
        if (list.length > 0) {
            list.forEach(item => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `<strong>${item.queue_number}</strong> - ${item.services}<span class="badge bg-primary">${item.status}</span>`;
                container.appendChild(li);
            });
        } else {
            container.innerHTML = '<li class="list-group-item text-muted text-center">No data</li>';
        }
    }

    setInterval(fetchQueueData, 5000);
    fetchQueueData();
</script>
</body>
</html>
