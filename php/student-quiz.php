<?php

    // include necessary file 
    include "dbconn.php"; 
    include "student-session.php";

    // fetch quiz attempt id from url
    if(!isset($_GET['id'])) {
        header("location: stu-teac-index.php");
        exit(); 
    } else {
        $quiz_attempt_id = $_GET['id'];
    }
    
    // check if the user is allowed to take the quiz
    if (!isset($_SESSION['quiz_attempt_started']) || !$_SESSION['quiz_attempt_started']) {
        echo "<script> alert('You are not allowed to join the quiz directly'); </script>";
        echo "<script> window.location.href='stu-teac-index.php'</script>";
        exit();
    }

    // fetch quiz id from quiz attempt id
    $fetchQuery = "SELECT * FROM `quiz_attempt` WHERE quiz_attempt_id = '$quiz_attempt_id'";
    $fetchResult = mysqli_query($connection, $fetchQuery);
    if($fetchResult) {
        $fetchRow = mysqli_fetch_assoc($fetchResult);
        $quiz_id = $fetchRow['quiz_id'];
    } else {
        header("location: stu-teac-index.php");
        exit(); 
    }

    // fetch all the questions from the quiz, and calculate the number of questios in the quiz
    $questionQuery = "SELECT * FROM `quiz_question` WHERE quiz_id = '$quiz_id'";
    $quetionResult = mysqli_query($connection, $questionQuery);
    $numQuestion = mysqli_num_rows($quetionResult);

    // fetch all the questions with the specific quiz attempt id, and calculate the number of questions 
    $quizAttemptCheck = "SELECT 
                            qa.*, 
                            qua.*
                        FROM 
                            quiz_attempt qa
                        JOIN 
                            quiz_user_answer qua ON qa.quiz_attempt_id = qua.quiz_attempt_id
                        WHERE
                            qa.quiz_attempt_id = '$quiz_attempt_id'";
                        $quizAttemptCheckResult = mysqli_query($connection, $quizAttemptCheck);
                        $numQuizAttemptCheck = mysqli_num_rows($quizAttemptCheckResult);
    
    // check if the number of questions in the quiz is equal to the number of questions with the specific quiz attempt id
    if ($numQuestion == $numQuizAttemptCheck) {
        $quiz_name = "SELECT * FROM `quiz` WHERE quiz_id = '$quiz_id'";
        $quiz_name_result = mysqli_query($connection, $quiz_name);
        $quiz_name_row = mysqli_fetch_assoc($quiz_name_result);
        $number = 1; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/student-quiz.css">
    <link rel="stylesheet" href="../css/animation.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="headerquiz">
        <h1>Quiz - <?php echo $quiz_name_row['quiz_title']; ?></h1>
        <h3 style="color: red;"><b>IMPORTANT: DO NOT LEAVE THIS PAGE BEFORE YOU HAVE SUBMITTED YOUR ANSWERS.</b></h3>
    </div>

    <div class="container-all">
        <form action="" method="post">
            <?php
                $displayQuestionQuery = "SELECT
                                            ua.*,
                                            qq.*
                                        FROM
                                            quiz_user_answer ua
                                        JOIN
                                            quiz_question qq ON ua.quiz_question_id = qq.quiz_question_id
                                        WHERE
                                            ua.quiz_attempt_id = '$quiz_attempt_id'
                                        ";
                $displayQuestionResult = mysqli_query($connection, $displayQuestionQuery);
                $number = 1;
                while ($displayQuestionRow = mysqli_fetch_assoc($displayQuestionResult)) {
                    $question_fetch_id = $displayQuestionRow['quiz_question_id'];
            ?>

            <h3>No. <?php echo $number; $number = $number + 1; ?></h3>

            <?php
                if($displayQuestionRow['quiz_attachment'] != null) {
                    echo "<img class='attachment-image' src='../data/image" . $displayQuestionRow['quiz_attachment'] . "'>";
                }
            ?>

            <p><?php echo $displayQuestionRow['quiz_question_text']; ?></p>

            <?php
                $fetchOption = "SELECT
                                    qq.*,
                                    qo.*
                                FROM
                                    quiz_question qq
                                JOIN
                                    quiz_option qo ON qq.quiz_question_id = qo.quiz_question_id
                                WHERE
                                    qq.quiz_question_id = '$question_fetch_id'
                                ";

                $fetchOptionResult = mysqli_query($connection, $fetchOption);

                // Fetch options into an array
                $options = array();
                while ($fetchOptionRow = mysqli_fetch_assoc($fetchOptionResult)) {
                    $options[] = array(
                        'option_id' => $fetchOptionRow['quiz_option_id'],
                        'option_text' => $fetchOptionRow['option_text'],
                    );
                }

                // Shuffle the options array
                shuffle($options);

                // Display shuffled radio buttons
                foreach ($options as $option) {
                    ?>
                    <label>
                        <input type="radio" name="question<?php echo $question_fetch_id;?>" value="<?php echo $option['option_id'];?>">
                        <?php echo $option['option_text'];?>
                    </label>
                    <?php
                }
            ?>
            <?php } ?>

            <input type="submit" value="Submit Answers" name="submit">
        </form>

        <?php
            // Check if quiz has been submitted and show success message
            if (isset($_POST['submit'])) {
                echo "<div class='message'>Answer Submitted Successfully</div>";
            }
        ?>
    </div>
</body>
</html>

<?php
        if (isset($_POST['submit'])) {
            // Reset the result set pointer to the beginning
            mysqli_data_seek($displayQuestionResult, 0);

            // Loop through each question
            while ($displayQuestionRow = mysqli_fetch_assoc($displayQuestionResult)) {
                $question_fetch_id = $displayQuestionRow['quiz_question_id'];

                // Check if the corresponding radio button is selected
                if (isset($_POST['question' . $question_fetch_id])) {
                    $selectedOptionId = $_POST['question' . $question_fetch_id];

                    // Update the selected option in the quiz_user_answer table
                    $updateAnswerQuery = "UPDATE quiz_user_answer 
                                          SET answer = '$selectedOptionId'
                                          WHERE quiz_attempt_id = '$quiz_attempt_id' 
                                          AND quiz_question_id = '$question_fetch_id'";
                    $updateAnswerResult = mysqli_query($connection, $updateAnswerQuery);

                    // Add error handling if needed
                    if (!$updateAnswerResult) {
                        echo "Error: " . mysqli_error($connection);
                    }
                }
            }

            $updateQuery = "UPDATE `quiz_attempt` SET 
                            `quiz_end_time`= CURRENT_TIMESTAMP WHERE `quiz_attempt_id` = '$quiz_attempt_id'";
            mysqli_query($connection, $updateQuery);
            unset($_SESSION['quiz_attempt_started']);
            echo "<script> alert('Answer Submitted Successfully'); </script>";
            echo "<script> window.location.href='stu-teac-index.php'; </script>";
            exit(); 
        }

    // if the number of questions in the quiz is not equal to the number of questions with the specific quiz attempt id
    } else {

        // insert all the questions into the quiz_user_answer table
        while($questionRow = mysqli_fetch_assoc($quetionResult)) {
            $question_id = $questionRow['quiz_question_id'];
            $insertQuery =  "INSERT INTO `quiz_user_answer`(`quiz_attempt_id`, `quiz_question_id`) 
                            VALUES ('$quiz_attempt_id','$question_id')";
            $insertResult = mysqli_query($connection, $insertQuery);
        } 

        // redirect to the same page
        header("Location: ".$_SERVER['PHP_SELF']."?id=".$quiz_attempt_id);
        exit();
    }
    
?>