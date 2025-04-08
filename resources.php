<?php 

require 'db.php';


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
        <a href="settings.php" class="btn btn-light btn-sm">&lt;</a>
        <div class="card services-card">
            <h6>Resources</h6>
            <p>No data</p>
        </div>

       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
