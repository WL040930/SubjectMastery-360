<?php

    // include necessary files 
    include "dbconn.php"; 
    include "student-session.php"; 

    // check user attempt id from url
    if(!isset($_GET['id'])) {
        header("location: stu-teac-index.php");
        exit(); 
    } else {
        $exam_attempt_id = $_GET['id'];
    }

    // check if user is allowed to join the exam
    if (!isset($_SESSION['quiz_attempt_started']) || !$_SESSION['quiz_attempt_started']) {
        echo "<script>You are not allowed to join the exam directly</script>";
        echo "<script>window.location.href='stu-teac-index.php'</script>";
        exit();
    }

    // fetch the exam id from exam_attempt table
    $fetchQuery = "SELECT * FROM `exam_attempt` WHERE exam_attempt_id = '$exam_attempt_id'";
    $fetchResult = mysqli_query($connection, $fetchQuery);
    if($fetchResult) {
        $fetchRow = mysqli_fetch_assoc($fetchResult);
        $exam_id = $fetchRow['exam_id'];
    } else {
        header("location: stu-teac-index.php");
        exit(); 
    }

    // fetch the questionn with the specific exam_id, and then calculate the number of row of the question
    $questionQuery = "SELECT * FROM `exam_question` WHERE exam_id = '$exam_id'";
    $quetionResult = mysqli_query($connection, $questionQuery);
    $numQuestion = mysqli_num_rows($quetionResult);

    // fetch the number of row of the question in exam_user_answer table
    $examAttemptCheck = "SELECT 
                            ea.*, 
                            eua.*
                        FROM 
                            exam_attempt ea
                        JOIN 
                            exam_user_answer eua ON ea.exam_attempt_id = eua.exam_attempt_id
                        WHERE
                            ea.exam_attempt_id = '$exam_attempt_id'";
    $examAttemptCheckResult = mysqli_query($connection, $examAttemptCheck);
    $numExamAttemptCheck = mysqli_num_rows($examAttemptCheckResult);

    // check if the number of row of the question in exam_user_answer table is equal to the number of row of the question
    if ($numQuestion == $numExamAttemptCheck) {

        // if equal, fetch the exam name from exam table
        $exam_name = "SELECT * FROM `exam` WHERE exam_id = '$exam_id'";
        $exam_name_result = mysqli_query($connection, $exam_name);
        $exam_name_row = mysqli_fetch_assoc($exam_name_result);
        $number = 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/student-exam.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>

    <!--header-->
    <div class="headerexam">
        <h1>Exam - <?php echo $exam_name_row['exam_title']; ?></h1>
        <h3 style="color: red;"><b>IMPORTANT: DO NOT LEAVE THIS PAGE BEFORE YOU HAVE SUBMITTED YOUR ANSWERS.</b></h3>
    </div>

    <!--question box-->
    <div id="question-box">
        <form action="" method="post">
            <?php
                // fetch the question from exam_question table, and display the question
                $displayQuestionQuery = "SELECT
                                            eq.*,
                                            eua.*
                                        FROM
                                            exam_question eq
                                        JOIN
                                            exam_user_answer eua ON eq.exam_question_id = eua.exam_question_id
                                        WHERE 
                                            eua.exam_attempt_id = '$exam_attempt_id'
                                        ";
                $displayQuestionResult = mysqli_query($connection, $displayQuestionQuery);
                $array = array();
                while($displayQuestionRow = mysqli_fetch_assoc($displayQuestionResult)) { 
                    $array[] = $displayQuestionRow['exam_user_answer_id'];
            ?>

            <br> <br>

            No. <?php echo $number; $number = $number + 1; ?> <br> 

            <?php 
                // display the picture if the question has picture
                if($displayQuestionRow['exam_attachment'] != null) {
                    echo "<br> <img id='exam_pic' src='../data/image".$displayQuestionRow['exam_attachment']."'>";
                } 
            ?>
            
            <br>
            
            <!--display the question and the answer box-->
            <input id="exam_question" type="text" value="<?php echo $displayQuestionRow['exam_question']; ?>" disabled><br>
            <textarea id="exam_ans" name="answers[]" style="resize: none; width: 80%; height: 100px; "><?php echo $displayQuestionRow['exam_user_answer']; ?></textarea><br>
    
            <?php
                }
            
            ?>

            <!--submit button-->
            <div class="submitbtn">
                <input type="submit" value="Submit Answers" name="submit">
            </div>

            <?php

                // if user click submit button, update the answer in exam_user_answer table
                if (isset($_POST['submit'])) {
                    $answers = $_POST['answers'];

                    // the answer will be updated according to the exam_user_answer_id
                    foreach ($answers as $index => $answer) {
                        $exam_user_answer_id = ($array[$index]);
                        $query = "UPDATE `exam_user_answer` SET 
                                `exam_user_answer`='$answer' WHERE `exam_user_answer_id` = '$exam_user_answer_id'"; 
                        $result = mysqli_query($connection, $query);
                        if (!$result) {
                            die("Database query failed." . mysqli_error($connection));
                        }
                    }

                    // update the exam_end_time in exam_attempt table
                    $updateQuery = "UPDATE `exam_attempt` SET 
                    `exam_end_time`= CURRENT_TIMESTAMP WHERE `exam_attempt_id` = '$exam_attempt_id'";
                    $updateResult = mysqli_query($connection, $updateQuery);
                    if (!$updateResult) {
                        die("Database query failed." . mysqli_error($connection));
                    }

                    // unset the session, avoid user to re-enter and re-submit the answer
                    unset($_SESSION['quiz_attempt_started']);
                    echo "<script> alert('Answer submitted successfully.') </script>";
                    echo "<script> window.location.href='stu-teac-index.php'; </script>";
                    exit();
                } 
            ?>
        </form>
    </div>


</body>
</html>
  

<?php

    } else {
        // if not equal, insert the question into exam_user_answer table, with empty user answer
        while($questionRow = mysqli_fetch_assoc($quetionResult)) {
            $question_id = $questionRow['exam_question_id'];
            $insertQuery =  "INSERT INTO `exam_user_answer`(`exam_attempt_id`, `exam_question_id`) 
                            VALUES ('$exam_attempt_id','$question_id')";
            $insertResult = mysqli_query($connection, $insertQuery);
        } 

        // redirect to the same page
        header("Location: ".$_SERVER['PHP_SELF']."?id=".$exam_attempt_id);
        exit();
    }
    
?>