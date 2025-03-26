<?php
session_start();
require_once('../Connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Student') {
    header('Location: ../auth/login.php');
    exit;
}

// Fetch questions from the database
$sql = "SELECT id, question, option_a, option_b, option_c, option_d FROM questions WHERE exam_id = (SELECT MAX(id) FROM create_exam)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $questions = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No questions found for this exam.";
    exit;
}

// Initialize start time
$start_time = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
    <title>RUPP | Question</title>
    <link rel="stylesheet" href="index.css">
</head>
<style>
    body {
        background-color: #1A2D42;
    }

    * {
        color: #D4D8DD;
    }

    .items {
        margin-bottom: 20px;
    }

    .options {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .options label {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btnSub {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #1A73E8;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btnSub:hover {
        background-color: #1558B0;
    }
</style>

<body>
    <form action="action.php" method="POST" onsubmit="return validateForm()">
        <fieldset>
            <legend>Linux Quizzes</legend>

            <!-- Hidden fields for start and end time -->
            <input type="hidden" name="start_time" id="start_time" value="<?php echo $start_time; ?>">
            <input type="hidden" name="end_time" id="end_time">

            <!-- Dynamically load questions -->
            <section>
                <?php foreach ($questions as $index => $question) { ?>
                    <div class="items">
                        <h3>
                            <?php echo ($index + 1) . '. ' . htmlspecialchars($question['question']); ?>
                        </h3>

                        <div class="options">
                            <label>
                                <input type="radio" name="q<?php echo $question['id']; ?>" value="A" id="q<?php echo $question['id']; ?>_a">
                                a) <?php echo htmlspecialchars($question['option_a']); ?>
                            </label>
                            <label>
                                <input type="radio" name="q<?php echo $question['id']; ?>" value="B" id="q<?php echo $question['id']; ?>_b">
                                b) <?php echo htmlspecialchars($question['option_b']); ?>
                            </label>
                            <label>
                                <input type="radio" name="q<?php echo $question['id']; ?>" value="C" id="q<?php echo $question['id']; ?>_c">
                                c) <?php echo htmlspecialchars($question['option_c']); ?>
                            </label>
                            <label>
                                <input type="radio" name="q<?php echo $question['id']; ?>" value="D" id="q<?php echo $question['id']; ?>_d">
                                d) <?php echo htmlspecialchars($question['option_d']); ?>
                            </label>
                        </div>
                    </div>
                <?php } ?>

                <input type="submit" value="Submit" class="btnSub">
            </section>
        </fieldset>
    </form>
</body>

</html>

<script>
    function validateForm() {
        // Initialize end time
        document.getElementById('end_time').value = new Date().toISOString().slice(0, 19).replace('T', ' ');

        // Check if each question has an answer
        const questions = <?php echo json_encode(array_column($questions, 'id')); ?>;
        for (let i = 0; i < questions.length; i++) {
            let selected = false;
            const radios = document.getElementsByName('q' + questions[i]);
            for (let j = 0; j < radios.length; j++) {
                if (radios[j].checked) {
                    selected = true;
                    break;
                }
            }
            if (!selected) {
                alert("Please answer all questions before submitting!");
                return false; // Prevent form submission
            }
        }
        return true; // Allow form submission
    }
</script>