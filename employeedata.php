<?php 
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tellercrewing') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO employees (name, gender, age, birthday, address, contact, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $name, $gender, $age, $birthday, $address, $contact, $role);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = "Employee added successfully!";
    header("Location: employeedata.php");
    exit();
}

if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = "Employee deleted successfully!";
    header("Location: employeedata.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .small-card {
            max-width: 500px;
            margin: auto;
            min-height: 400px;
        }
        .card-header {
            background-color: #433878 !important;
            color: white !important;
            font-weight: bold;
        }
        .card-spacing {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-3 d-flex justify-content-between align-items-center">
    <a href="tellercrewingdashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    <h2 class="text-center flex-grow-1">Employee Information Management</h2>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<div class="container mt-4">
    <div class="d-flex justify-content-between flex-wrap">
        <div class="col-md-3 card-spacing">
            <div class="card shadow">
                <div class="card-header text-white" style="background-color: #433878;">👨‍💼 Add Employee</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" required oninvalid="this.setCustomValidity('Please enter a name')" oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender:</label>
                            <select name="gender" class="form-control" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Age:</label>
                            <input type="number" name="age" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Birthday:</label>
                            <input type="date" name="birthday" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address:</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact:</label>
                            <input type="text" name="contact" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role:</label>
                            <select name="role" class="form-control" required>
                                <option value="Admin">Admin</option>
                                <option value="tellerDocumentation">Teller Documentation</option>
                                <option value="tellerCrewing">Teller Crewing</option>
                                <option value="tellerTechOps">Teller TechOps</option>
                                <option value="tellerSourcing">Teller Sourcing</option>
                                <option value="tellerTanker">Teller Tanker</option>
                                <option value="tellerWelfare">Teller Welfare</option>
                            </select>
                        </div>
                        <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 card-spacing">
            <div class="card shadow">
                <div class="card-header text-white" style="background-color: #433878;">📋 Employee List</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $conn->query("SELECT * FROM employees ORDER BY id DESC");
                            while ($row = $query->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['birthday']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                echo "<td class='d-flex gap-2'>";
                                echo "<a href='edit_employee.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>";
                                echo "<a href='employeedata.php?delete=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this employee?\");'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
