<?php

include 'db.php'; // Ensure DB connection


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

<!-- Services Content -->
<h3>Services</h3>
<div class="main-content d-flex gap-3 align-items-start">
    <a href="#" onclick="loadContent('settings_content.php')" class="btn btn-light btn-sm">&lt; Back</a>

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

    <!-- Add New Service 
    <div class="card add-service-card">
        <h6>Add New Service</h6>
        <form method="POST" class="form-inline">
            <input type="text" name="service_name" class="form-control" placeholder="Enter service name" required>
            <button type="submit" name="add_service" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>  -->
