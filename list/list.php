<?php 
include "../Connect.php";
session_start();

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT stu_id, name, class, email, score FROM tbl_student 
        WHERE stu_id LIKE ? OR name LIKE ? OR class LIKE ? 
        ORDER BY score DESC"; // តម្រៀបតាមពិន្ទុ

$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$rs = $stmt->get_result();

$students = [];
$rank = 1; // ចាប់ផ្តើម RANK ពីលេខ 1

while ($row = $rs->fetch_assoc()) {
    $row['rank'] = $rank++; // បន្ថែមលំដាប់ ១, ២, ៣, ...
    $students[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Student List</title>
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
                <h1 class="fs-5 fw-bold" style="color:#D4D8DD;">List Students</h1>
            </div>
            <div class="col-7">
                <div class="search d-flex mt-2">
                    <input type="text" class="form-control placeholder me-2" id="searchInput" placeholder="Search...">
                    <button class="btn btn-primary" onclick="searchStudent()"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
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
                </tr>
            </thead>
            <tbody id="results">
                <?php foreach ($students as $student) { ?>
                <tr>
                    <td><?php echo $student['stu_id']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['class']; ?></td>
                    <td><?php echo $student['score']; ?></td>
                    <td><?php echo $student['rank']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    function searchStudent() {
        let searchValue = document.getElementById("searchInput").value;
        fetch("list.php?search=" + encodeURIComponent(searchValue))
            .then(response => response.text())
            .then(html => {
                document.open();
                document.write(html);
                document.close();
            });
    }
</script>
</html>
