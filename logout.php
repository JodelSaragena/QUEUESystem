<?php
// Check if a specific session name is passed in the URL
if (isset($_GET['dashboard'])) {
    $dashboardKey = $_GET['dashboard'];
    session_name($dashboardKey);  // Set the session name based on the dashboard
    session_start();  // Start the session for this dashboard
    
    // Destroy only this session
    session_destroy();  
    header("Location: login.php"); // Redirect back to login page
    exit();
}

// If no dashboard is specified, destroy the default session (optional fallback)
session_start();
session_destroy();  
header("Location: login.php");
exit();
?>
