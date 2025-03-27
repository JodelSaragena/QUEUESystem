<!DOCTYPE html>
<html lang="en">
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

    .sidebar {
        width: 95px;
        height: 100vh;
        background-color: #433878;
        color: white;
        padding-top: 20px;
        position: fixed;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-bottom: 20px;
    }

    .sidebar-menu {
        flex-grow: 1;
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

    .sidebar a:hover {
        background-color: #5a49a2;
    }

    .sidebar-footer {
        margin-top: auto;
    }
</style>
<body>
<div class="sidebar">
    <div class="sidebar-menu">
        <h4>Menu</h4>
        <a href="admindashboard.php"><i class="bi bi-house-door fs-4"></i>Home</a>
        <a href="user.php"><i class="bi bi-clipboard-plus fs-4"></i>Get Number</a>
        <a href="login.php"><i class="bi bi-person-circle fs-4"></i>Teller Login</a>
        <a href="display.php"><i class="bi bi-tv fs-4"></i>Display</a>
        <a href="status.php"><i class="bi bi-bar-chart-fill fs-4"></i>Status</a>
        <a href="accounts.php"><i class="bi bi-people fs-4"></i>Accounts</a>
    </div>

    <div class="sidebar-footer">
        <a href="settings.php"><i class="bi bi-gear fs-4"></i>Settings</a>
        <a href="logout.php" class="text-white"><i class="bi bi-box-arrow-right fs-4"></i>Logout</a>
    </div>
</div>
</body>
</html>