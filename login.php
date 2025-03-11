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
    <title>Teller Login </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teller Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        
        body {
            background: linear-gradient(to right, #6a4c8c, #7E60BF); 
            height: 100vh; 
            display: flex;
            justify-content: center;
            align-items: center;
        }

      
        .form-container {
            background-color:0;
            border-radius: 20px; 
            box-shadow: 0 0px 0px rgba(0, 0, 0, 0.1); 
            padding: 30px;
            width: 100%;
            max-width: 400px; 
        }

       
        .card-header {
            background-color: #433878;
            color: white;
            text-align: center;
        }

       
        .btn-login {
            background-color: #7E60BF;
            color: white;
            border: none;
            padding: 15px;
            font-size: 1.2rem;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        @media (max-width: 576px) {
            .btn-login {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Teller/ Admin Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            </div>

                            <?php if (isset($error_msg)): ?>
                                <div class="error-message mb-3">
                                    <?php echo $error_msg; ?>
                                </div>
                            <?php endif; ?>

                            <button type="submit" name="login" class="btn btn-login w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
