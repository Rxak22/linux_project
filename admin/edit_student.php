<?php
require_once('../Connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST["student_id"];
    $name = $_POST["name"];
    $class = $_POST["class"];
    $score = $_POST["score"];
    $grade = $_POST["grade"];

    $sql = "UPDATE exam SET class='$class', score='$score', grade='$grade' WHERE student_id='$student_id'";
    $sql2 = "UPDATE users SET name='$name' WHERE id='$student_id'";

    if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
        header("Location: list_student.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>