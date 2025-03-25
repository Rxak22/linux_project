<?php
    session_start();
    require_once('../Connect.php');
    if (!isset($_SESSION['user'])) {
        header('Location: ../auth/login.php');
        exit;
    }
    $username = $_SESSION['user']["name"]; // Assuming the username is stored in the session

    // select all user section
    $sql = "SELECT id, name, gender, class, email, role FROM users LIMIT 10";
    $rs = mysqli_query($conn, $sql);

    $users = [];
    if ($rs) {
        while ($row = $rs->fetch_assoc()) {
            $users[] = $row;
        }
    } else {
        $users = null;
    }

    // insert user into database
    if (isset($_POST["submit"])) {
        $sql = "UPDATE users SET name = '{$_POST["name"]}',
                                         gender = '{$_POST["gender"]}', 
                                         class = '{$_POST["class"]}', 
                                         email = '{$_POST["email"]}', 
                                         role = '{$_POST["role"]}' 
                                         WHERE id = '{$_POST["id"]}'";

        if ($conn->query($sql) === TRUE) {
            header('Location: ./manage_user.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // delete user
    if (isset($_POST["delete"])) {
        $sql = "DELETE FROM users WHERE id = '{$_POST["id"]}'";

        if ($conn->query($sql) === TRUE) {
            header('Location: ./manage_user.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
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

        /* for new user option */
        .student_list {
            width: 70%;
        }
        .new_user {
            width: 30%;
        }
        .divider {
            width: 1px;
            background-color: #D4D8DD;
            margin: 0 20px;
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
                            <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
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
            <a href="../index.php"><i class="bi bi-house-door me-2"></i>Home</a>
            <a href="new_user.php"><i class="bi bi-person-plus me-2"></i>New User</a>
            <a href="manage_user.php"><i class="bi bi-people me-2"></i>Manage All User</a>
            <a href="list_student.php"><i class="bi bi-list-ul me-2"></i>List Student Result</a>
            <a href="create_exam.php"><i class="bi bi-file-earmark-plus me-2"></i>Create Exam</a>
        <?php
            }
        ?>
    </div>
    <!-- end sidebar -->
    <div class="content d-flex">
        <div class="student_list pe-2" style="color: #D4D8DD">
        <h2 class="text-center">All users</h2>
            <table class="table table-dark table-striped table-hover mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users) { ?>
                        <?php foreach ($users as $user) { ?>
                        <tr class="user-row" data-id="<?php echo $user['id']; ?>" data-name="<?php echo $user['name']; ?>" data-gender="<?php echo $user['gender']; ?>" data-class="<?php echo $user['class']; ?>" data-email="<?php echo $user['email']; ?>" data-role="<?php echo $user['role']; ?>">
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['gender']; ?></td>
                            <td><?php echo $user['class']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php 
                                if ($user['id'] == $_SESSION["user"]["id"]){
                                    echo $user['role']. " (You)";
                                }else {
                                    echo $user['role'];
                                }
                            ?></td>
                        </tr>
                        <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No users found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="divider"></div>
        <div class="new_user" style="color: #D4D8DD">
        <h2 class="text-center">Register</h2>
        <form id="user-form" action="" method="POST">
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control " id="name" name="name" placeholder="Enter your name" required>
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
                <input type="text" class="form-control" id="class" name="class" placeholder="Enter your class" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label> <br>
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="role" id="teacher" value="Teacher" checked>
                    Teacher
                  </label>
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="role" id="admin" value="Administrator">
                    Admin
                  </label>
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="role" id="student" value="Student">
                    Student
                  </label>
            </div>
            <div class="card-footer text-center d-flex justify-content-between align-items-center pt-2">
                <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                <button type="submit" name="submit" class="btn btn-info">Done</button>
            </div>
        </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.user-row').forEach(row => {
            row.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const gender = this.getAttribute('data-gender');
                const classValue = this.getAttribute('data-class');
                const email = this.getAttribute('data-email');
                const role = this.getAttribute('data-role');

                document.getElementById('id').value = id;
                document.getElementById('name').value = name;
                document.getElementById('class').value = classValue;
                document.getElementById('email').value = email;

                if (gender === 'Male') {
                    document.getElementById('male').checked = true;
                } else {
                    document.getElementById('female').checked = true;
                }

                if (role === 'Teacher') {
                    document.getElementById('teacher').checked = true;
                } else if (role === 'Administrator') {
                    document.getElementById('admin').checked = true;
                } else {
                    document.getElementById('student').checked = true;
                }
            });
        });
    </script>
</body>
</html>