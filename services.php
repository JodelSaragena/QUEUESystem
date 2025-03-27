<?php 
include 'sidebar.php';
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch distinct services from the queue table
$query = "SELECT DISTINCT services FROM queue";
$result = mysqli_query($conn, $query);

// Handle adding a new service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_service"])) {
    $new_service = trim($_POST["service_name"]);
    
    if (!empty($new_service)) {
        $insert_query = "INSERT INTO queue (services) VALUES ('$new_service')";
        mysqli_query($conn, $insert_query);
        header("Location: services.php");
        exit();
    }
}

// Handle service deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_service"])) {
    $service_to_delete = $_POST["service_name"];

    $delete_query = "DELETE FROM queue WHERE services = '$service_to_delete'";
    mysqli_query($conn, $delete_query);
    
    header("Location: services.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #F0F0F0;
        }

        .main-content {
            margin-left: 110px;
            padding: 20px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .services-card {
            flex: 1;
            max-width: 300px;
        }

        .add-service-card {
            flex: 1.5;
            max-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .service-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            font-size: 12px; /* Smaller text size */
            border-bottom: 1px solid #ddd;
        }

        .service-item:last-child {
            border-bottom: none;
        }

        .delete-btn {
            cursor: pointer;
            color: red;
        }

        h6 {
            font-size: 14px; /* Slightly smaller heading */
            font-weight: bold;
        }

        .form-inline {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .form-inline input {
            flex: 1;
        }

        .form-inline button {
            white-space: nowrap;
        }
    </style>
</head>
<body>

    <div class="main-content">
        <!-- Smaller Services List -->
        <div class="card services-card">
            <h6>Existing Services</h6>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="service-item">
                    <span><?php echo htmlspecialchars($row["services"]); ?></span>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($row["services"]); ?>">
                        <!--<button type="submit" name="delete_service" class="btn btn-sm btn-danger">Delete</button>-->
                    </form>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Add New Service -->
        <div class="card add-service-card">
            <h6>Add New Service</h6>
            <form method="POST" class="form-inline">
                <input type="text" name="service_name" class="form-control" placeholder="Enter service name" required>
                <!--<button type="submit" name="add_service" class="btn btn-primary">Add</button>-->
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
