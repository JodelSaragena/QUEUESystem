<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jody's Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            color: black;
            text-align: center;
            background-color: #F0F0F0; /* Light gray background */
        }

        .container {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.5); /* Semi-transparent white */
            padding: 20px;
            border-radius: 12px; /* Slightly rounded corners */
            border: 3px solid rgba(126, 96, 191, 0.9); /* Matched button color */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            max-width: 350px;
        }

        .header {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .btn-get-number {
            background-color: rgba(126, 96, 191, 0.9); /* Same as border */
            color: white;
            font-size: 1.2rem;
            padding: 12px 20px;
            border-radius: 8px; /* Slightly rounded button */
            border: none;
            margin-top: 15px;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-get-number:hover {
            background-color: rgba(126, 96, 191, 1);
            transform: scale(1.05); /* Slight zoom effect */
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
