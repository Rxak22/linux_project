<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<style>
    body {
        background-color: #1A2D42;
    }
    h1, p, a {
        color: #D4D8DD;
    }
</style>
<body>
    <?php
        session_start();
        if (isset($_SESSION["user"]) && $_SESSION["user"]["is_examed"] == true) {
    ?>
        <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Linux Exam</h1>
                <p>You have 30 minutes to complete the exam. Good luck!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="question.php" method="post">
                    <input type="hidden" name="start_time" id="start_time">
                    <input type="submit" class="btn btn-primary" value="Start Exam" />
                </form>
            </div>
        </div>
    </div>
    <?php        
        }
        else {
    ?>
        <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Linux Exam</h1>
                <p>You have already taken the exam. You can't take it again.</p>
                <a href="../list/index.php">see your result.</a>
            </div>
        </div>    
    <?php
        }
    ?>
    

    <script>
        document.getElementById('start_time').value = new Date().toISOString().slice(0, 19).replace('T', ' ');
    </script>
</body>
</html>