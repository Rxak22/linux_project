<?php
session_start();
require_once('../Connect.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Administrator') {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['num_questions'])) {
    $num_questions = intval($_POST['num_questions']);
} else {
    $num_questions = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.png">
    <title>Create Exam</title>
    <style>
        body {
            background-color: #1A2D42;
            color: #D4D8DD;
        }
        .card {
            background-color: #2E4156;
            border: none;
        }
        .card-header {
            background-color: #1A2D42;
            color: #D4D8DD;
        }
        .form-control, .form-select {
            background-color: #2E4156;
            color: #D4D8DD;
            border: 1px solid #D4D8DD;
        }
        .form-control::placeholder {
            color: #AAB7B7;
        }
        .btn-primary, .btn-success {
            background-color: #1A73E8;
            border: none;
        }
        .btn-primary:hover, .btn-success:hover {
            background-color: #1558B0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Create Exam</h2>

        <!-- Step 1: Ask for the number of questions -->
        <?php if ($num_questions == 0) { ?>
            <form action="" method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="num_questions" class="form-label">How many questions do you want to create?</label>
                    <input type="number" class="form-control" id="num_questions" name="num_questions" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        <?php } ?>

        <!-- Step 2: Add questions -->
        <?php if ($num_questions > 0) { ?>
            <form action="save_exam.php" method="POST" class="mt-4">
                <input type="hidden" name="num_questions" value="<?php echo $num_questions; ?>">
                <div class="mb-3">
                    <label for="exam_title" class="form-label">Exam Title</label>
                    <input type="text" class="form-control" id="exam_title" name="exam_title" placeholder="Enter exam title" required>
                </div>
                <?php for ($i = 1; $i <= $num_questions; $i++) { ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            Question <?php echo $i; ?>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="question_<?php echo $i; ?>" class="form-label">Question</label>
                                <input type="text" class="form-control" id="question_<?php echo $i; ?>" name="questions[<?php echo $i; ?>][question]" placeholder="Enter the question" required>
                            </div>
                            <div class="mb-3">
                                <label for="option_a_<?php echo $i; ?>" class="form-label">Option A</label>
                                <input type="text" class="form-control" id="option_a_<?php echo $i; ?>" name="questions[<?php echo $i; ?>][option_a]" placeholder="Enter option A" required>
                            </div>
                            <div class="mb-3">
                                <label for="option_b_<?php echo $i; ?>" class="form-label">Option B</label>
                                <input type="text" class="form-control" id="option_b_<?php echo $i; ?>" name="questions[<?php echo $i; ?>][option_b]" placeholder="Enter option B" required>
                            </div>
                            <div class="mb-3">
                                <label for="option_c_<?php echo $i; ?>" class="form-label">Option C</label>
                                <input type="text" class="form-control" id="option_c_<?php echo $i; ?>" name="questions[<?php echo $i; ?>][option_c]" placeholder="Enter option C" required>
                            </div>
                            <div class="mb-3">
                                <label for="option_d_<?php echo $i; ?>" class="form-label">Option D</label>
                                <input type="text" class="form-control" id="option_d_<?php echo $i; ?>" name="questions[<?php echo $i; ?>][option_d]" placeholder="Enter option D" required>
                            </div>
                            <div class="mb-3">
                                <label for="correct_option_<?php echo $i; ?>" class="form-label">Correct Option</label>
                                <select class="form-select" id="correct_option_<?php echo $i; ?>" name="questions[<?php echo $i; ?>][correct_option]" required>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <button type="submit" class="btn btn-success">Save Exam</button>
            </form>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>