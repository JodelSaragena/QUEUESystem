<?php
include 'sidebar.php';
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all tellers
$sql = "SELECT id, username, role FROM tellers ORDER BY role ASC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', sans-serif;
            font-size: smaller;
            color: black;
            background-color: #F0F0F0;
        }
       
        .main-content {
            margin-left: 110px;
            padding: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 20px;
            height: auto;
        }

        .scrollable-table {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <div class="main-content container">
        <h2 class="text-center mb-4">Accounts</h2>
        <div class="row">
            <!-- Teller Accounts List -->
            <div class="col-md-6">
                <div class="card">
                    <h4 class="text-center">Teller Accounts</h4>
                    <div class="scrollable-table">
                        <table class="table table-bordered mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Username</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo ucfirst($row['role']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Create New Account -->
            <div class="col-md-6">
                <div class="card">
                    <h4 class="text-center">Create New Account</h4>
                    <form action="createaccount.php" method="POST" class="mt-3">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="tellerDocumentation">Teller Admin</option>
                                <option value="tellerDocumentation">Teller Documentation</option>
                                <option value="tellerCrewing">Teller Crewing</option>
                                <option value="tellerTechOps">Teller TechOps</option>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
