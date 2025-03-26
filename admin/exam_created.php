<?php
session_start();
require_once('../Connect.php');

// Check if the user is logged in and is an administrator
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Administrator') {
    header('Location: ../auth/login.php');
    exit;
}

// Check if the exam creation was successful
if (!isset($_SESSION['exam_created']) || $_SESSION['exam_created'] !== true) {
    header('Location: create_exam.php');
    exit;
}

// Clear the session flag for exam creation
unset($_SESSION['exam_created']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
    <title>Exam Created</title>
    <style>
        body {
            background-color: #1A2D42;
            color: #D4D8DD;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background-color: #2E4156;
            border: none;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #1A73E8;
            border: none;
        }
        .btn-primary:hover {
            background-color: #1558B0;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="mb-4">Exam Created Successfully!</h2>
        <p class="mb-4">Your exam has been created and saved successfully.</p>
        <a href="create_exam.php" class="btn btn-primary mb-2"><i class="bi bi-plus-circle me-1"></i>Create Another Exam</a>
        <a href="../index.php" class="btn btn-secondary"><i class="bi bi-house-door me-1"></i>Go to Dashboard</a>
    </div>
</body>
</html>