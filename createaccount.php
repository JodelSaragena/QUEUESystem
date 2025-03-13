<?php
session_start();
require 'db.php'; // Ensure this connects to your database

// Count total accounts created
$count_query = $conn->query("SELECT COUNT(*) as total FROM tellers");
$count_result = $count_query->fetch_assoc();
$total_accounts = $count_result['total'];

// Fetch all teller accounts
$accounts_query = $conn->query("SELECT id, username, role FROM tellers");
$accounts = $accounts_query->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $check_query = $conn->prepare("SELECT id FROM tellers WHERE username = ?");
    $check_query->bind_param("s", $username);
    $check_query->execute();
    $check_result = $check_query->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists!'); window.location.href='createaccount.php';</script>";
    } else {
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .card-header { background-color: #433878; color: white; font-weight: bold; }
        .btn-primary { background-color: #433878; border-color: #433878; }
        .btn-dashboard { background-color: #433878; border-color: #433878;color: white; }
        .display-4 { color: #433878; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-start mb-3">
            <a href="admindashboard.php" class="btn btn-dashboard">Back to Dashboard</a>
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="card shadow">
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
            </div>

            <!-- Right Column -->
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header">Total Accounts Created</div>
                    <div class="card-body">
                        <p class="display-4" id="totalAccounts"><?php echo $total_accounts; ?></p>
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#accountsModal">Accounts</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accounts Modal -->
    <div class="modal fade" id="accountsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">List of Accounts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="accountsTable">
                            <?php foreach ($accounts as $account) : ?>
                                <tr id="row-<?php echo $account['id']; ?>">
                                    <td><?php echo htmlspecialchars($account['username']); ?></td>
                                    <td><?php echo htmlspecialchars($account['role']); ?></td>
                                    <td>
                                        <?php if ($account['role'] !== 'admin') : ?>
                                            <button class="btn btn-danger btn-sm" onclick="deleteAccount(<?php echo $account['id']; ?>)">Delete</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteAccount(accountId) {
            if (confirm("Are you sure you want to delete this account?")) {
                $.ajax({
                    url: 'delete_account.php',
                    type: 'POST',
                    data: { id: accountId },
                    success: function(response) {
                        if (response === "success") {
                            document.getElementById("row-" + accountId).remove();
                            let total = parseInt(document.getElementById("totalAccounts").innerText);
                            document.getElementById("totalAccounts").innerText = total - 1;
                        } else {
                            alert("Error deleting account.");
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
