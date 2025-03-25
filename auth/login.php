<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!-- toast  -->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <!-- toast -->
     <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
     <title>RUPP | Login</title>
    <style>
        body {
            background-image: url('https://www.rupp.edu.kh/news/news_image/59.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .card {
            background-color: rgba(0, 0, 0, 0.39);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            width: calc(100% / 3);
        }
        .form-control::placeholder,
        .form-select::placeholder {
            color: #ccc;
            opacity: 1; /* Override default opacity */
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="text-center">Login</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control placeholder" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control placeholder" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="card-footer text-center d-flex justify-content-between align-items-center pt-2">
                <p>
                    don't have an account?
                    <a href="register.php">Register</a></p>
                <button type="submit" class="btn btn-info">Login</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    require_once '../Connect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['user'] = $user;
            $_SESSION["user"]["is_examed"] = true;
            header('Location: ../index.php');
            exit;
        } else {
            echo '<span class="text-center text-danger position-absolute translate-middle-y top-0 mt-5 bg-light p-2 rounded-2">Invalid email or password</span>';
        }
    }
?>