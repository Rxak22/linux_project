<?php 
include "../Connect.php";

session_start();
$user_id = $_SESSION["user"]["id"];

$sql = "SELECT student_id, class, score, grade, start_exam_time, end_exam_time FROM exam WHERE student_id = $user_id";
$rs = mysqli_query($conn, $sql);

if ($rs) {
    $student = $rs->fetch_assoc();
} else {
    $student = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
     <title>RUPP | Student Result</title>
    <style>
       .btn-back:hover {
         background-color: black;
         color: white;
         padding: 5px 10px;
       }
    </style>
</head>
<style>
    body {
        background-color: #1A2D42;
    }
</style>
<body>
    <div class="container-fluid m-4">
        <div class="row">
            <a href="../index.php">
                <span class=""><i class="fa-solid fa-arrow-left bg-danger btn btn-outline btn-back"></i></span>
            </a>
            <div class="col-4 mt-4">
                <h1 class="fs-5 fw-bold" style="color:#D4D8DD;">Student Result</h1>
            </div>
        </div>
        <table class="table table-dark table-striped table-hover mt-4">
            <thead>
                <tr> 
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Score</th>
                    <th>Grade</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody id="results">
                <?php if ($student) { ?>
                <tr>
                    <td><?php echo "0000". $student['student_id']; ?></td>
                    <td><?php echo $_SESSION["user"]["name"]; ?></td>
                    <td><?php echo $student['class']; ?></td>
                    <td><?php echo $student['score']; ?></td>
                    <td><?php echo $student['grade']; ?></td>
                    <td><?php echo $student['end_exam_time']; ?></td>
                </tr>
                <?php } else { ?>
                <tr>
                    <td colspan="6" class="text-center">No results found</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>