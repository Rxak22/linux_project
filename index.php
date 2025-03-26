<?php
session_start();
require_once('Connect.php');
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
        if ($_SESSION['user']['role'] == 'Administrator') {
        ?>
            <a href="index.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="./admin/new_user.php"><i class="bi bi-person-plus me-2"></i>New User</a>
            <a href="./admin/manage_user.php"><i class="bi bi-people me-2"></i>Manage All User</a>
            <a href="./admin/list_student.php"><i class="bi bi-list-ul me-2"></i>List Student Result</a>
            <a href="./admin/create_exam.php"><i class="bi bi-file-earmark-plus me-2"></i>Create Exam</a>
        <?php
        }
        ?>
        <!-- for teacher access -->
        <?php
        if ($_SESSION['user']['role'] == 'Teacher') {
        ?>
            <a href="index.php"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="./exam/"><i class="bi bi-pencil-square me-2"></i>Let Exam</a>
            <a href="./admin/list_student.php"><i class="bi bi-list-ul me-2"></i>List Student Result</a>
            <a href="./admin/create_exam.php"><i class="bi bi-file-earmark-plus me-2"></i>Create Exam</a>
        <?php
        }
        ?>
        <!-- for student access -->
        <?php
        if ($_SESSION['user']['role'] == 'Student') {
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
        <!-- for admin access -->
        <?php
        if ($_SESSION["user"]["role"] == "Administrator") {
        ?>
            <div class="container-fluid">
                <h2 class="text-center text-light mb-4">Dashboard Overview</h2>
                <div class="row">
                    <!-- Card 1: Total Users -->
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    // Query to count total users
                                    $result = $conn->query("SELECT COUNT(*) AS total_users FROM users");
                                    $data = $result->fetch_assoc();
                                    echo $data['total_users'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2: Total Exams -->
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Exams</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    // Query to count total exams
                                    $result = $conn->query("SELECT COUNT(*) AS total_exams FROM exam");
                                    $data = $result->fetch_assoc();
                                    echo $data['total_exams'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3: Total Students -->
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Students</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    // Query to count total students
                                    $result = $conn->query("SELECT COUNT(*) AS total_students FROM users WHERE role = 'Student'");
                                    $data = $result->fetch_assoc();
                                    echo $data['total_students'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-dark text-light">
                            <div class="card-header">
                                <h5 class="card-title">Recent Activities</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Class</th>
                                            <th>Score</th>
                                            <th>Grade</th>
                                            <th>Exam Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query to fetch recent exam results
                                        $result = $conn->query("SELECT users.name, exam.class, exam.score, exam.grade, exam.end_exam_time 
                                                                FROM exam 
                                                                JOIN users ON exam.student_id = users.id 
                                                                ORDER BY exam.end_exam_time DESC LIMIT 5");
                                        if ($result->num_rows > 0) {
                                            $counter = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                    <td>{$counter}</td>
                                                    <td>{$row['name']}</td>
                                                    <td>{$row['class']}</td>
                                                    <td>{$row['score']}</td>
                                                    <td>{$row['grade']}</td>
                                                    <td>{$row['end_exam_time']}</td>
                                                </tr>";
                                                $counter++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No recent activities found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- for student access -->
        <?php
        if ($_SESSION["user"]["role"] == "Student") {
        ?>
            <div class="container-fluid">
                <h2 class="text-center text-light mb-4">Welcome, <?php echo $username; ?>!</h2>
                <div class="row">
                    <!-- Card 1: Upcoming Exams -->
                    <div class="col-md-6">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Upcoming Exams</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    // Query to count upcoming exams
                                    $result = $conn->query("SELECT COUNT(*) AS upcoming_exams FROM exam WHERE start_exam_time > NOW()");
                                    $data = $result->fetch_assoc();
                                    echo $data['upcoming_exams'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2: Completed Exams -->
                    <div class="col-md-6">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Completed Exams</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    // Query to count completed exams for the logged-in student
                                    $student_id = $_SESSION['user']['id'];
                                    $result = $conn->query("SELECT COUNT(*) AS completed_exams FROM exam WHERE student_id = $student_id AND end_exam_time < NOW()");
                                    $data = $result->fetch_assoc();
                                    echo $data['completed_exams'];
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Exam Results -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-dark text-light">
                            <div class="card-header">
                                <h5 class="card-title">Recent Exam Results</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Class</th>
                                            <th>Score</th>
                                            <th>Grade</th>
                                            <th>Exam Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Query to fetch recent exam results for the logged-in student
                                        $result = $conn->query("SELECT class, score, grade, end_exam_time 
                                                        FROM exam 
                                                        WHERE student_id = $student_id 
                                                        ORDER BY end_exam_time DESC LIMIT 5");
                                        if ($result->num_rows > 0) {
                                            $counter = 1;
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                <td>{$counter}</td>
                                                <td>{$row['class']}</td>
                                                <td>{$row['score']}</td>
                                                <td>{$row['grade']}</td>
                                                <td>{$row['end_exam_time']}</td>
                                            </tr>";
                                                $counter++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>No recent results found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>