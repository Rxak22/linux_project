<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $start_time = $_POST['start_time'];
    }
    // change user is_examed session t ofalse
    session_start();
    $_SESSION["user"]["is_examed"] = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <<link rel="icon" href="https://rupp.edu.kh/images/rupp-logo.pn">
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
</style>

<body>
    <form action="action.php" method="POST" onsubmit="return validateForm()">
        <fieldset>
            <legend>Linux quizzes</legend>

            <!-- hide -->
            <input type="hidden" name="start_time" id="start_time" value="<?php echo $start_time; ?>"> 
            <input type="hidden" name="end_time" id="end_time">
            <!-- hide -->
            <section>

                <div class="items">
                    <h3>
                        1. Which command is used to list all files and directories in Linux?
                    </h3>

                    <input type="radio" name="q1" value="ls"> a) ls
                    <input type="radio" name="q1" value="dir"> b) dir
                    <input type="radio" name="q1" value="list"> c) list
                    <input type="radio" name="q1" value="show"> d) show

                </div>
                <div class="items">
                    <h3>
                        2. What does the cd command do?
                    </h3>

                    <input type="radio" name="q2" value=" Copies a file" id="">a) Copies a file
                    <input type="radio" name="q2" value="Deletes a file" id="">b) Deletes a file
                    <input type="radio" name="q2" value="Changes the current directory" id="">c) Changes the current directory
                    <input type="radio" nam ="q2" value="Creates a new directory" id="">d) Creates a new directory

                </div>

                <div class="items">
                    <h3>
                        3. Which command is used to display the content of a text file in the terminal?
                    </h3>
                    <input type="radio" name="q3" value="cat" id="">a) cat
                    <input type="radio" name="q3" value="view" id="">b) view
                    <input type="radio" name="q3" value="open" id="">c) open
                    <input type="radio" name="q3" value="edit" id="">d) edit
                </div>



                <div class="items">
                    <h3>
                        4. What command is used to delete a file in Linux?
                    </h3>
                    <input type="radio" name="q4" value="rm" id="">a) rm
                    <input type="radio" name="q4" value="del" id="">b) del
                    <input type="radio" name="q4" value="erase" id="">c) erase
                    <input type="radio" name="q4" value="remove" id="">d) remove
                </div>


                <div class="items">
                    <h3>
                        5. Which command is used to create a new directory?
                    </h3>
                    <input type="radio" name="q5" value="mkdir" id="">a) mkdir
                    <input type="radio" name="q5" value="mkdirs" id="">b) mkdirs
                    <input type="radio" name="q5" value="create" id="">c) create
                    <input type="radio" name="q5" value="newdir" id="">d) newdir
                </div>

                <input type="submit" value="Submit" class="btnSub">


            </section>

        </fieldset>

    </form>

</body>

</html>

<script>
    function validateForm() {
        // initialize end time 
        document.getElementById('end_time').value = new Date().toISOString().slice(0, 19).replace('T', ' ');


        // Check if each question has an answer
        const questions = ["q1", "q2", "q3", "q4", "q5"];
        for (let i = 0; i < questions.length; i++) {
            let selected = false;
            const radios = document.getElementsByName(questions[i]);
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