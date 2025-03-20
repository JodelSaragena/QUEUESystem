<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM tellers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true); 
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $redirects = [
                'admin' => 'admindashboard.php',
                'tellerwithdraw' => 'tellerwithdrawdashboard.php',
                'tellerdeposit' => 'tellerdepositdashboard.php',
                'telleropenaccount' => 'telleropenaccountdashboard.php',
                'tellerdocumentation' => 'tellerdocumentationdashboard.php',
                'tellercrewing' => 'tellercrewingdashboard.php',
                'tellertechops' => 'tellertechopsdashboard.php',
                'tellersourcing' => 'tellersourcingdashboard.php',
                'tellertanker' => 'tellertankerdashboard.php',
                'tellerwelfare' => 'tellerwelfaredashboard.php'
            ];

            if (isset($redirects[$_SESSION['role']])) {
                header("Location: " . $redirects[$_SESSION['role']]);
                exit();
            } else {
                echo "<script>alert('Invalid role'); window.location.href='login.php';</script>";
            }
            
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Teller Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background:  #694F8E/*linear-gradient(to bottom, #E3A5C7, #694F8E)*/;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            color: white;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 600px;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 50px;
            overflow: hidden;
            padding: 40px;
            width: 100%;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.15);
            position: relative;
            text-align: left;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 30px;
            padding: 15px;
            font-size: 1rem;
            color: white;
            font-weight: 500;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        .btn-login {
            background: white;
            color: black;
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 15px 25px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: 0.3s;
            font-weight: 500;
            width: auto;
            display: block;
        }

        .btn-login:hover {
            background: rgba(200, 200, 200, 0.8);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="glass-container">
            <h2 class="text-white text-start">Teller/Admin Login</h2>
            <form method="POST" action="login.php">
                <div class="mb-3 text-start">
                    <label for="username" class="form-label text-white">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="mb-3 text-start">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" name="login" class="btn btn-login text-start">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
