<?php

    // include necessary files
    include "dbconn.php"; 
    include "feature-usermenu.php";
    include "student-session.php";

    // fetch user id
    $user_id = $_SESSION['id'];

    // fetch the exam id from url 
    if(isset($_GET['id'])) {
        $exam_id = $_GET['id'];

        // check if user is allowed to take the exam
        $checkQuery = "SELECT
                        cm.*,
                        c.*,
                        ce.*,
                        et.*
                    FROM
                        classroom_member AS cm
                    JOIN
                        classroom AS c ON cm.classroom_id = c.classroom_id
                    JOIN
                        classroom_exam AS ce ON c.classroom_id = ce.classroom_id
                    JOIN
                        exam AS et ON ce.exam_id = et.exam_id
                    WHERE 
                        cm.user_id = '$user_id' AND 
                        ce.exam_id = '$exam_id'
                    ";        
        $checkResult = mysqli_query($connection, $checkQuery);

        if($checkResult) {

            // fetch the number of results
            $rowCheck = mysqli_num_rows($checkResult);

            // user are allowed to take exam
            if ($rowCheck == 1) {
                $row = mysqli_fetch_assoc($checkResult);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Attempt</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/student-quizexamattempt.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>

    <!-- container -->
    <div class="container">
        <div class="header">
            <h1><?php echo $row['exam_title']; ?></h1>
        </div>
        <div id="description">
            <?php echo $row['exam_description'];?>
        </div>

        <!-- important notes for exam -->  
        <div id="important">
            <b>
                IMPORTANT: KINDLY AVOID NAVIGATING AWAY FROM THIS PAGE DURING THE EXAMINATION. <br>
                THIS MAY RESULT IN YOUR RESPONSES NOT BEING REGISTERED IN THE SYSTEM. 
            </b>
        </div>

        <!-- start attempt button -->
        <form action="" method="post">
            <input type="submit" value="Start Attempt" name="submit" class="btnstart">
        </form>
    </div>
</body>
</html>
            
<?php

            // if user click start attempt button
            if(isset($_POST['submit'])){

                // create a new exam attempt record in exam_attempt table
                $attemptQuery = "INSERT INTO `exam_attempt`(`exam_id`, `user_id`, `exam_start_time`) 
                                VALUES ('$exam_id','$user_id', CURRENT_TIMESTAMP)";
                $attemptResult = mysqli_query($connection, $attemptQuery);

                // if exam attempt record is created successfully
                if ($attemptResult) {

                    // fetch the exam attempt id
                    $new_id = mysqli_insert_id($connection);

                    // create a feedback section for the exam attempt
                    $feedbackQuery = "INSERT INTO `exam_feedback`(`exam_attempt_id`) VALUES ('$new_id')";

                    if(mysqli_query($connection, $feedbackQuery)){

                        // assign a special session for the user, allowing user to attempt the exam
                        $_SESSION['quiz_attempt_started'] = true;
                        header("Location: student-exam.php?id=$new_id");
                    } 
                } else {
                    echo "<script> alert ('Error Occur. Please try again later. ');</script>";
                    echo "<script> window.location.href='stu-teac-index.php'; </script>";
                    exit();
                }

            }
            
            } else if ($rowCheck == 0) {
                echo "<script> alert ('You are not allowed to take the exam. ');</script>";
                echo "<script> window.location.href='stu-teac-index.php'; </script>";
                exit(); 
            } else {
                echo "<script> alert ('Unexpected error occur. Please contact admin.');</script>";
                echo "<script> window.location.href='stu-teac-index.php'; </script>";
                exit();
            }
        }

    // if exam id is not set in url
    } else {
        $user_id = $_SESSION['id'];

        // fetch all the exam that user is allowed to take
        $classrooms_query = "SELECT
                                cm.*,
                                c.*,
                                ce.*,
                                et.*
                            FROM
                                classroom_member AS cm
                            JOIN
                                classroom AS c ON cm.classroom_id = c.classroom_id
                            JOIN
                                classroom_exam AS ce ON c.classroom_id = ce.classroom_id
                            JOIN
                                exam AS et ON ce.exam_id = et.exam_id
                            WHERE 
                                cm.user_id = '$user_id'
                            ";
        $classrooms_result = mysqli_query($connection, $classrooms_query);

        // if there is exam that user is allowed to take
        if ($classrooms_result && mysqli_num_rows($classrooms_result) > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Exam</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/student-quizexamattempt.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1 align="center" style="margin: 20px;">Please Select The Exam </h1>
    <ul>
        <?php
        // display all the exam that user is allowed to take
            while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
                echo '<a class="linktoclassroom" href="student-examattempt.php?id=' . $classroom_row['exam_id'] . '"><li class="choose-classroom">' . $classroom_row['exam_title'] . '</li></a>';
            }
        ?>
    <br>
    </ul>
        
</body>
</html>

<?php

        } else {
            // if there is no exam that user is allowed to take
            echo "<script> alert ('No Exam Found!'); </script>";
            echo "<script> window.location.href='stu-teac-index.php'; </script>";
        }
    }

?>