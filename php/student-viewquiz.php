<?php

    include "dbconn.php"; 
    include "student-session.php";

    $user_id = $_SESSION['id'];

    $fetchQuery = " SELECT qa.*, q.*
                    FROM quiz_attempt qa 
                    JOIN quiz q 
                    ON qa.quiz_id = q.quiz_id
                    WHERE user_id = '$user_id'"; 
    $fetchResult = mysqli_query($connection, $fetchQuery);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quiz Result</title>
</head>
<body>
    <form id="quizForm" action="" method="post">
        <div id="name"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></div> <br>
        
        <!-- Dropdown list of quizzes -->
        Quiz: 
        <select name="quiz" id="quiz" onchange="submitForm()">
            <option value="">Select a Quiz</option>
            <?php
                while ($fetchRow = mysqli_fetch_assoc($fetchResult)){
                    echo "<option value='". $fetchRow['quiz_attempt_id']."'>" .$fetchRow['quiz_title'] ."</option>";
                } 
            ?>
        </select>
    </form>

    <script>
        function submitForm() {
            document.getElementById("quizForm").submit();
        }
    </script>
</body>
</html>

<?php

    function quiz_total_mark(){
        
    }

?>