<?php
include 'sidebar.php';
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 14px;
            color: black;
            background-color: #F0F0F0;
        }

        .main-content {
            margin-left: 110px;
            padding: 20px;
            width: 100%;
            max-width: 600px;
        }

        .settings-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .settings-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
            text-decoration: none;
            color: black;
        }

        .settings-item:hover {
            background-color: #f8f9fa;
        }

        .settings-item:last-child {
            border-bottom: none;
        }

        .settings-item span {
            font-size: 13px;
            color: gray;
        }

        .icon {
            font-size: 18px;
            color: black;
        }
    </style>
</head>
<body>

    <div class="main-content">
        <h3>Settings</h3>
        <div class="settings-card mt-4">
            <a href="services.php" class="settings-item">
                <div>
                    <strong>Services</strong><br>
                    <span>Create and manage your services.</span>
                </div>
                <i class="bi bi-chevron-right icon"></i>
            </a>
            <a href="resources.php" class="settings-item">
                <div>
                    <strong>Resources</strong><br>
                    <span>Create and manage your resources.</span>
                </div>
                <i class="bi bi-chevron-right icon"></i>
            </a>
            <a href="resources.php" class="settings-item"></>
               
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>