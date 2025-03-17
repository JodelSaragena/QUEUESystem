<?php 
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'tellercrewing') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: employeedata.php");
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();

if (!$employee) {
    $_SESSION['error_message'] = "Employee not found!";
    header("Location: employeedata.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_employee'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE employees SET name=?, gender=?, age=?, birthday=?, address=?, contact=?, role=? WHERE id=?");
    $stmt->bind_param("ssissssi", $name, $gender, $age, $birthday, $address, $contact, $role, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success_message'] = "Employee updated successfully!";
    header("Location: employeedata.php");
    exit();
}
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . $_SESSION['success_message'] . "');</script>";
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo "<script>alert('" . $_SESSION['error_message'] . "');</script>";
    unset($_SESSION['error_message']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header {
            background-color: #433878 !important;
            color: white !important;
            font-weight: bold;
        }
        .small-card {
            max-width: 400px;
            margin: auto;
            min-height: 400px;
        }


    </style>
</head>
<body>
<div class="container mt-4">
    <a href="employeedata.php" class="btn btn-secondary">Back</a>
    <div class="card mt-3 small-card">
        <div class="card-header">✏️ Edit Employee</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($employee['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gender:</label>
                    <select name="gender" class="form-control" required>
                        <option value="Male" <?= ($employee['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= ($employee['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= ($employee['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Age:</label>
                    <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($employee['age']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Birthday:</label>
                    <input type="date" name="birthday" class="form-control" value="<?= htmlspecialchars($employee['birthday']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address:</label>
                    <textarea name="address" class="form-control" required><?= htmlspecialchars($employee['address']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact:</label>
                    <input type="text" name="contact" class="form-control" value="<?= htmlspecialchars($employee['contact']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role:</label>
                    <select name="role" class="form-control" required>
                        <option value="Admin" <?= ($employee['role'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="tellerDocumentation" <?= ($employee['role'] == 'tellerDocumentation') ? 'selected' : '' ?>>Teller Documentation</option>
                        <option value="tellerCrewing" <?= ($employee['role'] == 'tellerCrewing') ? 'selected' : '' ?>>Teller Crewing</option>
                        <option value="tellerTechOps" <?= ($employee['role'] == 'tellerTechOps') ? 'selected' : '' ?>>Teller TechOps</option>
                        <option value="tellerSourcing" <?= ($employee['role'] == 'tellerSourcing') ? 'selected' : '' ?>>Teller Sourcing</option>
                        <option value="tellerTanker" <?= ($employee['role'] == 'tellerTanker') ? 'selected' : '' ?>>Teller Tanker</option>
                        <option value="tellerWelfare" <?= ($employee['role'] == 'tellerWelfare') ? 'selected' : '' ?>>Teller Welfare</option>
                    </select>
                </div>
                <button type="submit" name="update_employee" class="btn btn-success">Update Employee</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
