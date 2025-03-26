<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            font-size: smaller;
            color: black;
            background-color: #F0F0F0;
            padding-top: 20px;
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
    <div class="container">
        <div class="header">Welcome!!!</div>
        <p class="mt-2">We are happy to serve you.</p>
        <a href="user.php" class="btn btn-get-number">GET A NUMBER</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
