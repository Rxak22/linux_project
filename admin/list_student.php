<?php 
include "../Connect.php";

session_start();

$sql = "SELECT users.name, exam.student_id, exam.class, exam.score, exam.grade, exam.end_exam_time, exam.start_exam_time
        FROM users 
        JOIN exam ON users.id = exam.student_id";
$rs = mysqli_query($conn, $sql);

$students = [];
if ($rs) {
    while ($row = $rs->fetch_assoc()) {
        $students[] = $row;
    }
} else {
    $students = null;
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
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="results">
                <?php if ($students) { ?>
                    <?php foreach ($students as $student) { ?>
                    <tr>
                        <td><?php echo "0000". $student['student_id']; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['class']; ?></td>
                        <td><?php echo $student['score']; ?></td>
                        <td><?php echo $student['grade']; ?></td>
                        <td><?php echo $student['start_exam_time']; ?></td>
                        <td><?php echo $student['end_exam_time']; ?></td>
                        <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal" data-id="<?php echo "0000". $student['student_id']; ?>" data-name="<?php echo $student['name']; ?>" data-class="<?php echo $student['class']; ?>" data-score="<?php echo $student['score']; ?>" data-grade="<?php echo $student['grade']; ?>" data-start="<?php echo $student['start_exam_time']; ?>" data-end="<?php echo $student['end_exam_time']; ?>">View</button>
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo "0000". $student['student_id']; ?>" data-name="<?php echo $student['name']; ?>" data-class="<?php echo $student['class']; ?>" data-score="<?php echo $student['score']; ?>" data-grade="<?php echo $student['grade']; ?>">Edit</button>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                <tr>
                    <td colspan="8" class="text-center">No results found</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header" style="color: #D4D8DD;">
                    <h5 class="modal-title" id="viewModalLabel">Student Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: #D4D8DD;">
                    <p><strong>Student ID:</strong> <span id="modal-student-id"></span></p>
                    <p><strong>Student Name:</strong> <span id="modal-student-name"></span></p>
                    <p><strong>Class:</strong> <span id="modal-student-class"></span></p>
                    <p><strong>Score:</strong> <span id="modal-student-score"></span></p>
                    <p><strong>Grade:</strong> <span id="modal-student-grade"></span></p>
                    <p><strong>Start Exam Time:</strong> <span id="modal-start-time"></span></p>
                    <p><strong>End Exam Time:</strong> <span id="modal-end-time"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header" style="color: #D4D8DD;">
                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: #D4D8DD;">
                    <form id="edit-form" action="edit_student.php" method="POST">
                        <input type="hidden" id="edit-student-id" name="student_id">
                        <div class="mb-3">
                            <label for="edit-student-name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="edit-student-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-student-class" class="form-label">Class</label>
                            <input type="text" class="form-control" id="edit-student-class" name="class" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-student-score" class="form-label">Score</label>
                            <input type="number" class="form-control" id="edit-student-score" name="score" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-student-grade" class="form-label">Grade</label>
                            <input type="text" class="form-control" id="edit-student-grade" name="grade" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var viewModal = document.getElementById('viewModal');
        viewModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var studentId = button.getAttribute('data-id');
            var studentName = button.getAttribute('data-name');
            var studentClass = button.getAttribute('data-class');
            var studentScore = button.getAttribute('data-score');
            var studentGrade = button.getAttribute('data-grade');
            var startTime = button.getAttribute('data-start');
            var endTime = button.getAttribute('data-end');

            var modalStudentId = viewModal.querySelector('#modal-student-id');
            var modalStudentName = viewModal.querySelector('#modal-student-name');
            var modalStudentClass = viewModal.querySelector('#modal-student-class');
            var modalStudentScore = viewModal.querySelector('#modal-student-score');
            var modalStudentGrade = viewModal.querySelector('#modal-student-grade');
            var modalStartTime = viewModal.querySelector('#modal-start-time');
            var modalEndTime = viewModal.querySelector('#modal-end-time');

            modalStudentId.textContent = studentId;
            modalStudentName.textContent = studentName;
            modalStudentClass.textContent = studentClass;
            modalStudentScore.textContent = studentScore;
            modalStudentGrade.textContent = studentGrade;
            modalStartTime.textContent = startTime;
            modalEndTime.textContent = endTime;
        });

        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var studentId = button.getAttribute('data-id');
            var studentName = button.getAttribute('data-name');
            var studentClass = button.getAttribute('data-class');
            var studentScore = button.getAttribute('data-score');
            var studentGrade = button.getAttribute('data-grade');

            var editStudentId = editModal.querySelector('#edit-student-id');
            var editStudentName = editModal.querySelector('#edit-student-name');
            var editStudentClass = editModal.querySelector('#edit-student-class');
            var editStudentScore = editModal.querySelector('#edit-student-score');
            var editStudentGrade = editModal.querySelector('#edit-student-grade');

            editStudentId.value = studentId;
            editStudentName.value = studentName;
            editStudentClass.value = studentClass;
            editStudentScore.value = studentScore;
            editStudentGrade.value = studentGrade;
        });
    </script>
</body>
</html>