<?php   
 
session_start();
require 'db.php'; // Ensure this connects to your database

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
        echo "<script>alert('All fields are required!'); window.location.href='accounts.php';</script>";
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
        echo "<script>alert('Username already exists!'); window.location.href='accounts.php';</script>";
        exit();
    }

    // Insert new teller account
    $stmt = $conn->prepare("INSERT INTO tellers (username, password, role, services) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $username, $hashed_password, $role, $services);
    if ($stmt->execute()) {
        echo "<script>alert('Teller account created successfully!'); window.location.href='accounts.php';</script>";
    } else {
        die("Execute failed: " . $stmt->error);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
        }
        .card-body form .form-label {
            font-size: 14px;
        }
        .card-body form .form-control, 
        .card-body form .form-select {
            font-size: 14px;
            padding: 6px 10px;
        }
        .btn-primary {
            font-size: 14px;
            padding: 7px 10px;
        }
        .card-body.scrollable {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <h4>Create Account</h4>
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header text-center">Create New Teller Account</div>
                    <div class="card-body">
                        <form method="POST" action="accounts.php">
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
            <div class="col-md-7">
                <h4>Accounts</h4>
                <div class="card shadow">
                    <div class="card-header text-center">Total Accounts Created: <?php echo $total_accounts; ?></div>
                    <div class="card-body scrollable">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Services</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $account) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($account['username']); ?></td>
                                        <td><?php echo htmlspecialchars($account['role']); ?></td>
                                        <td><?php echo htmlspecialchars($account['services']); ?></td>
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
                </div>
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
</body>
</html>
