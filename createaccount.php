<?php
session_start();
require 'db.php'; // Ensure this connects to your database

// Count total accounts created
$count_query = $conn->query("SELECT COUNT(*) as total FROM tellers");
$count_result = $count_query->fetch_assoc();
$total_accounts = $count_result['total'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = $_POST['role'];

    // Check if username already exists
    $check_query = $conn->prepare("SELECT id FROM tellers WHERE username = ?");
    $check_query->bind_param("s", $username);
    $check_query->execute();
    $check_result = $check_query->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists!'); window.location.href='createaccount.php';</script>";
    } else {
        // Insert new teller
        $stmt = $conn->prepare("INSERT INTO tellers (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Account created successfully!'); window.location.href='createaccount.php';</script>";
        } else {
            echo "<script>alert('Error creating account.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .form-card, .stats-card {
            width: 100%;
            max-width: 450px; /* Keeps cards from being too wide */
            margin: auto;
        }
        .dashboard-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .card-header {
            background-color: #433878; /* Matches admin dashboard */
            color: white;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #433878; /* Dark purple */
            border-color: #433878;
        }
    
        .btn-dashboard {
            background-color: #433878; 
            color: white;
        }
        .btn-dashboard:hover {
            background-color: #362c66;
        }
        .display-4 {
            color: #433878; /* Matches the header color */
            font-weight: bold;
        }
    </style>
</head>
<title>Create Account Dashboard</title>
<body>
    <div class="container mt-3">
        <!-- Back to Dashboard Button -->
        <div class="d-flex justify-content-start">
            <a href="admindashboard.php" class="btn btn-dashboard">Back to Dashboard</a>
        </div>

        <!-- Dashboard Layout -->
        <div class="dashboard-container">
            <!-- Create Account Form (Left) -->
            <div class="card form-card shadow">
                <div class="card-header text-center">Create New Teller Account</div>
                <div class="card-body">
                    <form method="POST" action="createaccount.php">
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
                                <option value="tellerWithdraw">Teller Withdraw</option>
                                <option value="tellerDeposit">Teller Deposit</option>
                                <option value="tellerOpenAccount">Teller Open Account</option>
                                <option value="tellerDocumentation">Teller Documentation</option>
                                <option value="tellerCrewing">Teller Crewing</option>
                                <option value="tellerTechOps">Teller Tech Ops</option>
                                <option value="tellerSourcing">Teller Sourcing</option>
                                <option value="tellerTanker">Teller Tanker</option>
                                <option value="tellerWelfare">Teller Welfare</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>
                    </form>
                </div>
            </div>


          <!-- Total Accounts Created (Right) -->
<div class="card stats-card shadow">
    <div class="card-header text-center">Total Accounts Created</div>
    <div class="card-body text-center">
        <p class="display-4" id="totalAccounts">
            <?php
            require 'db.php';
            $result = $conn->query("SELECT COUNT(*) AS total FROM tellers");
            $row = $result->fetch_assoc();
            echo $row['total'];
            ?>
        </p>
        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accountsModal">
            Accounts Created
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="accountsModal" tabindex="-1" aria-labelledby="accountsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="accountsModalLabel">List of Created Accounts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="userList">
                    <?php
                    $users_query = $conn->query("SELECT id, username FROM tellers");
                    while ($user = $users_query->fetch_assoc()) {
                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">' .
                            $user['username'] .
                            ' <button class="btn btn-danger btn-sm delete-btn" data-id="' . $user['id'] . '">Delete</button>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript (Ensure Bootstrap is included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AJAX Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function() {
            let userId = this.getAttribute("data-id");
            let listItem = this.closest("li");

            if (confirm("Are you sure you want to delete this account?")) {
                fetch("delete_account.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id=" + userId
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        listItem.remove();
                        updateTotalAccounts();
                    } else {
                        alert("Error deleting account.");
                    }
                });
            }
        });
    });

    function updateTotalAccounts() {
        fetch("count_accounts.php")
        .then(response => response.text())
        .then(count => {
            document.getElementById("totalAccounts").innerText = count;
        });
    }
});
</script>

        </div>
    </div>
</body>
</html>

