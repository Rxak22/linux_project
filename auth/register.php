<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
     <title>RUPP | Register</title>
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
        <h2 class="text-center">Register</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control placeholder" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label> <br>
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" id="male" value="Male" checked>
                    Male
                  </label>
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" id="female" value="Female">
                    Female
                  </label>
            </div>
            <div class="mb-3">
                <label for="class" class="form-label">Class</label>
                <input type="text" class="form-control placeholder" id="class" name="class" placeholder="Enter your class" required>
            </div>
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
                    already have an account?
                    <a href="login.php">Login</a></p>
                <button type="submit" name="submit" class="btn btn-info">Register</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

require_once("../Connect.php");

if (isset($_POST["submit"])){
    $sql = "INSERT INTO users VALUES (null, '{$_POST["name"]}', 
                                        '{$_POST["gender"]}', 
                                        '{$_POST["class"]}', 
                                        '{$_POST["email"]}', 
                                        '{$_POST["password"]}',
                                        'Student'
                                        )";

        if ($conn->query($sql) === TRUE) {
            session_start();
            $user_id = $conn->insert_id; // Get the ID of the newly inserted user
            $_SESSION["user"] = [
                "id" => $user_id,
                "name" => $_POST["name"],
                "gender" => $_POST["gender"],
                "class" => $_POST["class"],
                "email" => $_POST["email"],
                "role" => 'Student',
                "is_examed" => true
            ];
            
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
}
?>