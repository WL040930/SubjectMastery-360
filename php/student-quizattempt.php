<?php

    include "dbconn.php"; 
    include "student-session.php";

    $user_id = $_SESSION['id'];

    // link is quiz id 
    if(isset($_GET['id'])) {
        $quiz_id = $_GET['id'];

        $checkQuery = "SELECT
                        cm.*,
                        c.*,
                        cq.*,
                        q.*
                    FROM
                        classroom_member AS cm
                    JOIN
                        classroom AS c ON cm.classroom_id = c.classroom_id
                    JOIN
                        classroom_quiz AS cq ON c.classroom_id = cq.classroom_id
                    JOIN
                        quiz AS q ON cq.quiz_id = q.quiz_id
                    WHERE 
                        cm.user_id = '$user_id' AND 
                        cq.quiz_id = '$quiz_id'
                    "; 
        $checkResult = mysqli_query($connection, $checkQuery);

        if($checkResult) {
            $rowCheck = mysqli_num_rows($checkResult);

            if ($rowCheck == 1) {
                $row = mysqli_fetch_assoc($checkResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Attempt</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/student-quizattempt.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div id="container">
        <h1><?php echo $row['quiz_title']; ?></h1>
        <div id="description">
            <?php echo $row['quiz_description'];?>
        </div>
        <div id="important">
            <b>
                IMPORTANT: KINDLY AVOID NAVIGATING AWAY FROM THIS PAGE DURING THE EXAMINATION. <br>
                THIS MAY RESULT IN YOUR RESPONSES NOT BEING REGISTERED IN THE SYSTEM. 
            </b>
        </div>
        <form action="" method="post">
            <input type="submit" value="Start Attempt" name="submit">
        </form>
    </div>
</body>
</html>
            
<?php

            if(isset($_POST['submit'])){
                $attemptQuery = "INSERT INTO `quiz_attempt`(`user_id`, `quiz_id`, `quiz_start_time`) 
                                VALUES ('$user_id','$quiz_id', CURRENT_TIMESTAMP)";
                $attemptResult = mysqli_query($connection, $attemptQuery);
                if ($attemptResult) {
                    $new_id = mysqli_insert_id($connection);
                    $feedbackquery = "INSERT INTO `quiz_feedback`(`quiz_attempt_id`)
                                        VALUES ('$new_id')";
                    if(mysqli_query($connection, $feedbackquery)){
                        $_SESSION['quiz_attempt_started'] = true;
                        header("Location: student-quiz.php?id=$new_id");
                    } 
                } else {
                    echo "<script> alert ('Error Occur. Please try again later. ');</script>";
                    echo "<script> window.location.href='stu-teac-index.php'; </script>";
                    exit();
                }

            }
            
            } else if ($rowCheck == 0) {
                echo "<script> alert ('You are not allowed to take the Quiz. ');</script>";
                echo "<script> window.location.href='stu-teac-index.php'; </script>";
                exit(); 
            } else {
                echo "<script> alert ('Unexpected error occur. Please contact admin.');</script>";
                echo "<script> window.location.href='stu-teac-index.php'; </script>";
                exit();
            }
        }

    
    
?>

<?php

    } else {
        $user_id = $_SESSION['id'];
        $classrooms_query = "SELECT
                                cm.*,
                                c.*,
                                cq.*,
                                q.*
                            FROM
                                classroom_member AS cm
                            JOIN
                                classroom AS c ON cm.classroom_id = c.classroom_id
                            JOIN
                                classroom_quiz AS cq ON c.classroom_id = cq.classroom_id
                            JOIN
                                quiz AS q ON cq.quiz_id = q.quiz_id
                            WHERE 
                                cm.user_id = '$user_id'
                            ";
        $classrooms_result = mysqli_query($connection, $classrooms_query);

        if ($classrooms_result && mysqli_num_rows($classrooms_result) > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Quiz</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/student-quizattempt.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Please Select The Quiz: </h1>
    <ul>
    <?php
        $firstIteration = true; // Flag to identify the first iteration
        while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
            // Check if it's not the first iteration to add spacing
            if (!$firstIteration) {
                echo '</ul>'; // Close the previous <ul>
                echo '<ul id="newquiz">'; // Open a new <ul>
            } else {
                echo '<ul id="oldquiz">'; // Open the first <ul>
                $firstIteration = false; // Set the flag to false after the first iteration
            }
            echo '<li><a id="title" href="student-quizattempt.php?id=' . $classroom_row['quiz_id'] . '">' . $classroom_row['quiz_title'] . '</a></li>';
        }
        echo '</ul>'; // Close the last <ul> after the loop
        ?>
    </ul>
</body>
</html>

<?php

        } else {
            echo "<script> alert ('No Quiz Found!'); </script>";
            echo "<script> window.location.href='stu-teac-index.php'; </script>";
        }
    }

?>