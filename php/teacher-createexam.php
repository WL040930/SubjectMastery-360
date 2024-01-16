<?php

    // include necessary files
    include "dbconn.php";
    include "feature-usermenu.php";
    include "teacher-session.php"; 

    // get the classroom id from the url
    if(isset($_GET['id'])){ 
        $id = $_GET['id'];
        $user_id = $_SESSION['id'];

        // check if the user is involved in the classroom
        $sql = "SELECT * FROM `classroom_member` WHERE `classroom_id` = '$id' AND `user_id` = '$user_id'";
        $sqlresult = mysqli_query($connection, $sql);
        $sqlrow = mysqli_fetch_assoc($sqlresult);

        if (mysqli_num_rows($sqlresult) == 0) {
            // if the user is not involved in the classroom, display this message
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
    <title>Create Exam</title>
    <link rel="stylesheet" href="../css/animation.css">
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/teacher-createexam.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Create Exam</h1>
    <div id="container">
        <!-- form to create exam -->
        <form action="" method="post">
            <table>
                <tr>
                    <th>Exam Name: </th>
                    <td><input class="inp-box" type="text" name="exam_name" placeholder="Exam Name" required> <br></td>
                </tr>
                <tr>
                    <th>Exam Description: </th>
                    <td><textarea id="description" name="exam_description" placeholder="Exam Description" cols="30" rows="10"></textarea></td>
                </tr>
            </table>
            <!--
            <div id="exam_name">
                <div class="name-con"><b>Exam Name: </b></div> <br>
                <input class="inp-box" type="text" name="exam_name" placeholder="exam name" required> <br>
            </div>
            <div style="clear: both"></div>
            <div id="exam_description">
                <b id="desc_con">Exam Description: </b>
                <input class="inp-box" id="description" type="text" name="exam_description" placeholder="exam description"> <br>
            </div>
            <div style="clear: both"></div>
            -->
            <div id="classroomsubmit_button">
                <input type="submit" value="Create" name="submit">
            </div>
        </form>
    </div>
</body>
</html>

<?php

        // if the user click the submit button
        if(isset($_POST['submit'])) {

            // get the exam name and description from the form
            $name = $_POST['exam_name'];
            $description = $_POST['exam_description'];

            // insert the exam into the database
            $insertExamQuery = "INSERT INTO `exam`(`exam_title`, `exam_description`) 
                                VALUES ('$name','$description')";
            
            $insertResult = mysqli_query($connection, $insertExamQuery);
            if ($insertResult) {

                // if the exam is inserted successfully, get the exam id
                $exam_id = mysqli_insert_id($connection);

                // insert the classroom and exam id into the classroom_exam table
                $insertClassroomExamQuery = "INSERT INTO `classroom_exam`(`classroom_id`, `exam_id`) 
                                            VALUES ('$id','$exam_id')";
                $insertClassroomExamResult = mysqli_query($connection, $insertClassroomExamQuery);
                if ($insertClassroomExamResult) {
                    echo "<script> alert('Exam Created Successfully'); </script>";
                    echo "<script> window.location.href='teacher-examquestion.php?id=$exam_id';</script>";
                } 
            }
        }

?>

<?php
    
    } else {
        // if the id is not in the url, display all the classroom that the user is involved in
        $user_id = $_SESSION['id'];
        $classrooms_query = "SELECT cm.classroom_id, c.classroom_name FROM classroom_member cm 
                            JOIN classroom c ON cm.classroom_id = c.classroom_id 
                            WHERE cm.user_id = '$user_id'";
        $classrooms_result = mysqli_query($connection, $classrooms_query);

        // if the user is involved in at least one classroom, display the classroom
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
    <link rel="stylesheet" href="../css/animation.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div style="padding: 10px;"><h1>Please select the classroom you would like to create exam: </h1></div>
    <ul>
        <?php
        while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
            echo '<a class="linktoclassroom" href="teacher-createexam.php?id=' . $classroom_row['classroom_id'] . '"><li class="choose-classroom">' . $classroom_row['classroom_name'] . '</li></a>';
        }

        ?>
    </ul>
</body>
</html>

<?php
        } else {
            // if the user is not involved in any classroom, display this message
            echo "<div style='text-align: center; font-size: 24px; margin-top: 100px;'>You are not involved in any of the classroom. </div>";
        }
    }

?>