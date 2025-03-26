<?php
session_start();
require_once "../Connect.php";

// Check if the user is logged in
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "Student") {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the correct answers from the database
    $sql = "SELECT id, correct_option FROM questions WHERE exam_id = (SELECT MAX(id) FROM create_exam)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $answers = [];
        while ($row = $result->fetch_assoc()) {
            $answers[$row['id']] = $row['correct_option'];
        }
    } else {
        echo "<h3 class='text-center text-light'>No questions found for this exam!</h3>";
        exit;
    }

    // Initialize user score
    $score = 0;
    $totalQuestions = count($answers);

    echo "<div class='container mt-5'>";
    echo "<h2 class='text-center text-light'>Linux Quiz Results</h2>";

    // Loop through each question and check the user's answers
    foreach ($answers as $question_id => $correctAnswer) {
        if (isset($_POST["q" . $question_id])) {
            $userAnswer = $_POST["q" . $question_id];

            if ($userAnswer == $correctAnswer) {
                $score++;
                echo "<p class='text-success'><strong>Question $question_id:</strong> Correct ✅</p>";
            } else {
                echo "<p class='text-danger'><strong>Question $question_id:</strong> Incorrect ❌ (Correct answer: <b>$correctAnswer</b>)</p>";
            }
        } else {
            echo "<p class='text-warning'><strong>Question $question_id:</strong> No answer provided ⚠️</p>";
        }
    }

    // Display final score
    echo "<h3 class='text-center text-light'>Your Score: $score / $totalQuestions</h3>";
    $grade = calculateGrade($score, $totalQuestions);
    echo "<h3 class='text-center text-light'>Your Grade: $grade</h3>";

    if ($score == $totalQuestions) {
        echo "<p class='text-center text-success'>🎉 Excellent! You got all the answers right!</p>";
    } elseif ($score >= ($totalQuestions / 2)) {
        echo "<p class='text-center text-warning'>😊 Good job! But there's still room for improvement.</p>";
    } else {
        echo "<p class='text-center text-danger'>😕 Keep practicing! Review Linux commands and try again.</p>";
    }
    echo "<div class='text-center mt-4'><a href='../index.php' class='btn btn-primary'>Back</a></div>";
    echo "</div>";

    // Insert result into the database
    $id = $_SESSION["user"]['id'];
    $class = $_SESSION["user"]['class'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $sql = "INSERT INTO exam (student_id, class, score, grade, start_exam_time, end_exam_time) 
            VALUES ('$id', '$class', '$score', '$grade', '$start_time', '$end_time')";
    $result = $conn->query($sql);

    if (!$result) {
        echo "Error inserting record: " . $conn->error;
    }
} else {
    echo "<h3 class='text-center text-light'>No answers submitted!</h3>";
}

// Function to calculate grade
function calculateGrade($score, $totalQuestions) {
    $percentage = ($score / $totalQuestions) * 100;

    if ($percentage >= 90) {
        return 'A';
    } elseif ($percentage >= 80) {
        return 'B';
    } elseif ($percentage >= 70) {
        return 'C';
    } elseif ($percentage >= 60) {
        return 'D';
    } else {
        return 'F';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
    <title>RUPP | Result</title>
    <style>
        body {
            background-color: #1A2D42;
            color: #D4D8DD;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #2E4156;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

</body>

</html>