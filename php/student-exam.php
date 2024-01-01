<?php

    include "dbconn.php"; 
    include "student-session.php"; 

    if(!isset($_GET['id'])) {
        header("location: stu-teac-index.php");
        exit(); 
    } else {
        $exam_attempt_id = $_GET['id'];
    }

    if (!isset($_SESSION['quiz_attempt_started']) || !$_SESSION['quiz_attempt_started']) {
        echo "<script>You are not allowed to join the exam directly</script>";
        echo "<script>window.location.href='stu-teac-index.php'</script>";
        exit();
    }

    $fetchQuery = "SELECT * FROM `exam_attempt` WHERE exam_attempt_id = '$exam_attempt_id'";
    $fetchResult = mysqli_query($connection, $fetchQuery);
    if($fetchResult) {
        $fetchRow = mysqli_fetch_assoc($fetchResult);
        $exam_id = $fetchRow['exam_id'];
    } else {
        header("location: stu-teac-index.php");
        exit(); 
    }

    $questionQuery = "SELECT * FROM `exam_question` WHERE exam_id = '$exam_id'";
    $quetionResult = mysqli_query($connection, $questionQuery);
    $numQuestion = mysqli_num_rows($quetionResult);

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

    if ($numQuestion == $numExamAttemptCheck) {
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
</head>
<body>
    <h1>Exam - <?php echo $exam_name_row['exam_title']; ?></h1>
    <h3 style="color: red;"><b>IMPORTANT: DO NOT LEAVE THIS PAGE BEFORE YOU HAVE SUBMITTED YOUR ANSWERS.</b></h3>
    <br>
    <div id="question-box">
        <form action="" method="post">
            <?php
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
            No. <?php echo $number; $number = $number + 1; ?> <br>
            <input type="text" value="<?php echo $displayQuestionRow['exam_question']; ?>" disabled><br>
            <input type="text" value="<?php echo $displayQuestionRow['exam_user_answer']; ?>" name="answers[]"><br>
            <?php
                }
            ?>
            <input type="submit" value="Submit Answers" name="submit">
            <?php

                if (isset($_POST['submit'])) {
                    $answers = $_POST['answers'];

                    foreach ($answers as $index => $answer) {
                        $exam_user_answer_id = ($array[$index]);
                        $query = "UPDATE `exam_user_answer` SET 
                                `exam_user_answer`='$answer' WHERE `exam_user_answer_id` = '$exam_user_answer_id'"; 
                        $result = mysqli_query($connection, $query);
                        if (!$result) {
                            die("Database query failed." . mysqli_error($connection));
                        }
                    }

                    $updateQuery = "UPDATE `exam_attempt` SET 
                    `exam_end_time`= CURRENT_TIMESTAMP WHERE `exam_attempt_id` = '$exam_attempt_id'";
                    $updateResult = mysqli_query($connection, $updateQuery);
                    if (!$updateResult) {
                        die("Database query failed." . mysqli_error($connection));
                    }
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
        while($questionRow = mysqli_fetch_assoc($quetionResult)) {
            $question_id = $questionRow['exam_question_id'];
            $insertQuery =  "INSERT INTO `exam_user_answer`(`exam_attempt_id`, `exam_question_id`) 
                            VALUES ('$exam_attempt_id','$question_id')";
            $insertResult = mysqli_query($connection, $insertQuery);
        } 

        header("Location: ".$_SERVER['PHP_SELF']."?id=".$exam_attempt_id);
        exit();
    }
    
?>