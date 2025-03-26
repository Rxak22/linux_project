<?php
require_once('../Connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exam_title = $_POST['exam_title'];
    $num_questions = intval($_POST['num_questions']);
    $questions = $_POST['questions'];

    // Insert the exam into the `create_exam` table
    $sql = "INSERT INTO create_exam (title, created_by) VALUES ('$exam_title', '{$_SESSION['user']['id']}')";
    if ($conn->query($sql) === TRUE) {
        $exam_id = $conn->insert_id; // Get the ID of the newly created exam

        // Insert each question into the `questions` table
        foreach ($questions as $question) {
            $question_text = $conn->real_escape_string($question['question']);
            $option_a = $conn->real_escape_string($question['option_a']);
            $option_b = $conn->real_escape_string($question['option_b']);
            $option_c = $conn->real_escape_string($question['option_c']);
            $option_d = $conn->real_escape_string($question['option_d']);
            $correct_option = $conn->real_escape_string($question['correct_option']);

            $sql = "INSERT INTO questions (exam_id, question, option_a, option_b, option_c, option_d, correct_option) 
                    VALUES ('$exam_id', '$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";
            
            if (!$conn->query($sql)) {
                echo "Error inserting question: " . $conn->error . "<br>";
                echo "SQL: " . $sql . "<br>";
            }
        }

        // Set the session for exam creation success
        $_SESSION['exam_created'] = true;

        // Redirect to the success page
        header('Location: exam_created.php');
        exit;
    } else {
        // Log the error for debugging
        echo "Error inserting exam: " . $conn->error . "<br>";
        echo "SQL: " . $sql . "<br>";
    }
}
?>