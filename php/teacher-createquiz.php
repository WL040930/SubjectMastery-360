<?php

    include "dbconn.php";
    include "teacher-session.php"; 

    if(isset($_GET['id'])){ 
        $id = $_GET['id'];
        $user_id = $_SESSION['id'];

        $sql = "SELECT * FROM `classroom_member` WHERE `classroom_id` = '$id' AND `user_id` = '$user_id'";
        $sqlresult = mysqli_query($connection, $sql);
        $sqlrow = mysqli_fetch_assoc($sqlresult);

        if (mysqli_num_rows($sqlresult) == 0) {
            echo "<script> alert('You are not involved in this classroom.') </script>";
            echo "<script> window.location.href='stu-teac-index.php' </script>";
            exit(); 
        }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/teacher-createexam.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Create Quiz</h1>
    <div id="container">
        <form action="" method="post">
            <input type="text" name="quiz_name" placeholder="Quiz Name" required> <br>
            <input type="text" name="quiz_description" placeholder="Quiz Description"> <br>
            <input type="submit" value="Create" name="submit">
        </form>
    </div>
</body>
</html>

<?php

        if(isset($_POST['submit'])) {
            $name = $_POST['quiz_name'];
            $description = $_POST['quiz_description'];
            $insertExamQuery = "INSERT INTO `quiz`(`quiz_title`, `quiz_description`) 
                                VALUES ('$name','$description')";
            
            $insertResult = mysqli_query($connection, $insertExamQuery);
            if ($insertResult) {
                $quiz_id = mysqli_insert_id($connection);
                $insertClassroomQuizQuery = "INSERT INTO `classroom_quiz`(`classroom_id`, `quiz_id`) 
                                            VALUES ('$id','$quiz_id')";
                $insertClassroomQuizResult = mysqli_query($connection, $insertClassroomQuizQuery);
                if ($insertClassroomQuizResult) {
                    echo "<script> alert('Quiz Created Successfully'); </script>";
                    echo "<script> window.location.href='teacher-quizquestion.php?id=$quiz_id'; </script>";
                } 
            }
        }

?>

<?php
    // outside the classroom page
    } else {
        $user_id = $_SESSION['id'];
        $classrooms_query = "SELECT cm.classroom_id, c.classroom_name FROM classroom_member cm 
                            JOIN classroom c ON cm.classroom_id = c.classroom_id 
                            WHERE cm.user_id = '$user_id'";
        $classrooms_result = mysqli_query($connection, $classrooms_query);

        if ($classrooms_result && mysqli_num_rows($classrooms_result) > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Classroom</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/teacher-createexam.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Please select the classroom you would like to manage: </h1>
    <ul>
        <?php
        $firstIteration = true; // Flag to identify the first iteration
        while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
            // Check if it's not the first iteration to add spacing
            if (!$firstIteration) {
                echo '</ul>'; // Close the previous <ul>
                echo '<ul id="fir_exam">'; // Open a new <ul>
            } else {
                echo '<ul id="sec_exam">'; // Open the first <ul>
                $firstIteration = false; // Set the flag to false after the first iteration
            }
            echo '<li><a id="title" href="teacher-createquiz.php?id=' . $classroom_row['classroom_id'] . '">' . $classroom_row['classroom_name'] . '</a></li>';
        }
        echo '</ul>'; // Close the last <ul> after the loop
        ?>
    </ul>
</body>
</html>

<?php
        } else {
            echo "You are not involved in any of the classroom. ";
        }
    }

?>