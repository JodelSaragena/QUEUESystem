<?php
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', sans-serif;
            font-size: smaller;
            color: black;
            background-color: #F0F0F0;
        }

        .sidebar {
            width: 95px;
            height: 100vh;
            background-color: #433878;
            color: white;
            padding-top: 20px;
            position: fixed;
            text-align: center;
        }

        .sidebar h4 {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            padding: 10px 5px;
            transition: background 0.3s;
            font-size: 0.70rem;
        }

        .sidebar a i {
            font-size: 1.2rem;
            margin-bottom: 3px;
        }

        .sidebar a:hover {
            background-color: #5a49a2;
        }

        .main-content {
            margin-left: 120px;
            padding: 20px;
            width: 100%;
        }

        .table th, .table td {
            text-align: center;
            padding: 8px;
        }

        .card-header {
            background-color: white;
            color: black;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4>Menu</h4>
        <a href="home.php"><i class="bi bi-house-door"></i>Home</a>
        <a href="user.php"><i class="bi bi-clipboard-plus"></i>Get Number</a>
        <a href="login.php"><i class="bi bi-person-circle"></i>Teller Login</a>
        <a href="display.php"><i class="bi bi-tv"></i>Display</a>
        <a href="#"><i class="bi bi-envelope"></i>Contact Us</a>
    </div>

    <div class="main-content">
        <div class="container mt-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="text-center flex-grow-1">Admin Dashboard</h2>
                <div>
                    <a href="createaccount.php" class="btn btn-primary">Create Account</a>
                    <a href="login.php" class="btn btn-danger">Logout</a>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-header">Teller Accounts</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
