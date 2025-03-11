<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to Jody's Bank</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Jody's Bank</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        
        body {
            background: linear-gradient(to right, #6a4c8c, #7E60BF);
        }

   
        .card-header {
            background-color: #433878;
            color: white;
            text-align: center;
            padding: 15px 20px; 
            font-size: 2rem; 
            font-weight: bold; 
        }

    
        .card-body {
            padding: 40px; 
        }

        
        .btn-get-number {
            background-color: #7E60BF;
            color: white;
            border: none;
            font-size: 1.8rem; 
            padding: 10px ;
            width: 100%; 
            border-radius: 50px;
        }
        .btn-get-number:hover {
            background-color: #7E60BF; 
            transform: scale(1.05); 
            cursor: pointer; 
        }

        .card {
            border-radius: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px; 
            margin: 0 auto;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4"> 
            <div class="card shadow-lg border-0">
                <div class="card-header text-center">
                    <h4>Welcome to Jody's Bank</h4>
                </div>
                <div class="card-body text-center">
                    <p class="mb-4 fw-bold" style="font-size: 1.2rem;">We are happy to serve you.</p>
                    <a href="user.php" class="btn btn-get-number">GET A NUMBER</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
