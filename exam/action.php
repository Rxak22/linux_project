<?php
session_start();
require_once "../Connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Correct answers
    $answers = [
        "q1" => "ls",
        "q2" => "Changes the current directory",
        "q3" => "cat",
        "q4" => "rm",
        "q5" => "mkdir"
    ];

    // Initialize user score
    $score = 0;
    $totalQuestions = count($answers);

    echo "<div class='container mt-5'>";
    echo "<h2 class='text-center text-light'>Linux Quiz Results</h2>";

    // Loop through each question
    foreach ($answers as $question => $correctAnswer) {
        if (isset($_POST[$question])) {
            $userAnswer = strtolower(trim($_POST[$question]));
            $correctAnswer = strtolower(trim($correctAnswer));

            if ($userAnswer == $correctAnswer) {
                $score++;
                echo "<p class='text-success'><strong>Question " . substr($question, 1) . ":</strong> Correct ✅</p>";
            } else {
                echo "<p class='text-danger'><strong>Question " . substr($question, 1) . ":</strong> Incorrect ❌ (Correct answer: <b>$correctAnswer</b>)</p>";
            }
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
} else {
    echo "<h3 class='text-center text-light'>No answers submitted!</h3>";
}

// insert result to database
$id = $_SESSION["user"]['id'];
$class = $_SESSION["user"]['class'];
$grade = calculateGrade($score, $totalQuestions);
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

$sql = "INSERT INTO exam VALUES (null, 
                                '$id', 
                                '$class', 
                                '$score', 
                                '$grade', 
                                '$start_time',
                                '$end_time')";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error inserting record: " . mysqli_error($conn);
}

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
    <title>Document</title>
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