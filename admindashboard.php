<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .sidebar {
            width: 220px;
            background-color: #004A77;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: start;
            padding: 20px;
        }

        .sidebar img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 30px;
            align-self: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            width: 100%;
            transition: background 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            background-color: white;
            color: #004A77;
        }

        .nav-link i {
            font-size: 18px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .logout {
            margin-top: auto;
        }


        
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="your-logo.png" alt="Logo"> <!-- Replace with your logo path -->

    <a href="#" class="nav-link" onclick="loadContent('home_content.php')">
        <i class="bi bi-house-door"></i> Home
    </a>
    <a href="#" class="nav-link" onclick="loadContent('status_content.php')">
        <i class="bi bi-bar-chart"></i> Status
    </a>
    <a href="#" class="nav-link" onclick="loadContent('accounts_content.php')">
        <i class="bi bi-person-gear"></i> Accounts
    </a>
    <a href="#" class="nav-link" onclick="loadContent('settings_content.php')">
        <i class="bi bi-gear"></i> Settings
    </a>
    <a href="logout.php" class="nav-link logout">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>




<!-- Main Content -->
<div class="main-content" id="main-content">
    <?php include 'home_content.php'; ?> <!-- Default content -->
</div>

<script>
    function loadContent(file) {
        fetch(file)
            .then(response => response.text())
            .then(html => {
                document.getElementById('main-content').innerHTML = html;
            })
            .catch(error => {
                document.getElementById('main-content').innerHTML = "<p>Error loading content.</p>";
                console.error("Load error:", error);
            });
    }
</script>

</body>
</html>
