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
</head>
<body>
    <div id="container">
        <h1><?php echo $row['quiz_title']; ?></h1>
        <div id="description">
            <?php echo $row['quiz_description'];?>
        </div>
        <div id="important">
            <b>
                IMPORTANT: KINDLY AVOID NAVIGATING AWAY FROM THIS PAGE DURING THE EXAMINATION, <br>
                AS THIS MAY RESULT IN YOUR RESPONSES NOT BEING REGISTERED IN THE SYSTEM. 
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
</head>
<body>
    <h1>Please select the Quiz: </h1>
    <ul>
        <?php
        while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
            echo '<li><a href="student-quizattempt.php?id=' . $classroom_row['quiz_id'] . '">' . $classroom_row['quiz_title'] . '</a></li>';
        }
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