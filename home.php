<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Bootstrap Icons -->
    <style>
        body {
            height: 100vh;
            display: flex;
            font-family: 'Poppins', sans-serif;
            font-size: smaller;
            color: black;
            background-color: #F0F0F0; /* Light gray background */
        }

        .sidebar {
            width: 95px; /* Adjusted width */
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
            font-size: 0.70rem; /* Adjusted text size */
        }

        .sidebar a i {
            font-size: 1.2rem; /* Adjusted icon size */
            margin-bottom: 3px;
        }

        .sidebar a:hover {
            background-color: #5a49a2;
        }

        .main-content {
            margin-left: 120px; /* Adjusted based on sidebar width */
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .container {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border-radius: 12px;
            border: 3px solid rgba(126, 96, 191, 0.9);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            max-width: 350px;
            text-align: center;
        }

        .header {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .btn-get-number {
            background-color: rgba(126, 96, 191, 0.9);
            color: white;
            font-size: 1.2rem;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            margin-top: 15px;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-get-number:hover {
            background-color: rgba(126, 96, 191, 1);
            transform: scale(1.05);
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
