<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ./auth/login.php');
        exit;
    }
    $username = $_SESSION['user']["name"]; // Assuming the username is stored in the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.pn">
     <title>RUPP | Home</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #1A2D42;
            box-shadow: 0 2px 4px rgba(255, 0, 0, 0.2);
        }
        .navbar-brand img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }
        .sidebar {
            height: 91vh;
            position: sticky;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #1A2D42;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #D4D8DD;
            display: block;
        }
        .sidebar a:hover {
            background-color: #2E4156;
        }
        a:hover {
           color: #AAB7B7; 
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #2E4156;
            position: absolute;
            top: 66px;
            width: calc(100% - 250px);
            height: calc(100% - 66px);
        }
    </style>
</head>
<body>
    <!--  start navbar -->
    <nav class="navbar navbar-expand-lg navbar-light z-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img class="me-2" src="https://rupp.edu.kh/images/rupp-logo.png" alt="Logo">
                <h6 style="color:#D4D8DD;">RUPP Exam System</h6>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:#D4D8DD;">
                            <i class="bi bi-person-circle me-2"></i><?php echo $username; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./auth/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- start sidebar -->
    <div class="sidebar z-0">
        <!-- for admin access -->
        <?php
            if($_SESSION['user']['role'] == 'Administrator') {
        ?>
            <a href="index.php"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="./admin/new_user.php"><i class="bi bi-person-plus me-2"></i>New User</a>
            <a href="./admin/new_user.php"><i class="bi bi-person-plus me-2"></i>Manage All User</a>
            <a href="./admin/list_student.php"><i class="bi bi-list-ul me-2"></i>List Student Result</a>
            <a href="./exam/create_exam.php"><i class="bi bi-file-earmark-plus me-2"></i>Create Exam</a>
        <?php
            }
        ?>
        <!-- for teacher access -->
        <?php
            if($_SESSION['user']['role'] == 'Teacher') {
        ?>
            <a href="index.php"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="./exam/"><i class="bi bi-pencil-square me-2"></i>Let Exam</a>
            <a href="./admin/list_student.php"><i class="bi bi-list-ul me-2"></i>List Student Result</a>
            <a href="./exam/create_exam.php"><i class="bi bi-file-earmark-plus me-2"></i>Create Exam</a>
        <?php
            }
        ?>
        <!-- for student access -->
        <?php
            if($_SESSION['user']['role'] == 'Student') {
        ?>
            <a href="index.php"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="./exam/"><i class="bi bi-pencil-square me-2"></i>Let Exam</a>
            <a href="./list/"><i class="bi bi-file-earmark-bar-graph me-2"></i>See Result</a>
        <?php
            }
        ?>

        <!-- backup sidebar -->
            <!-- <a href="index.php"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="./exam/"><i class="bi bi-pencil-square me-2"></i>Let Exam</a>
            <a href="./admin/new_user.php"><i class="bi bi-person-plus me-2"></i>New User</a>
            <a href="./list/"><i class="bi bi-file-earmark-bar-graph me-2"></i>See Result</a>
            <a href="./admin/list_student.php"><i class="bi bi-list-ul me-2"></i>List Student Result</a>
            <a href="./exam/create_exam.php"><i class="bi bi-file-earmark-plus me-2"></i>Create Exam</a> -->
        <!-- backup sidebar -->
    </div>
    <!-- end sidebar -->
    <div class="content">
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>