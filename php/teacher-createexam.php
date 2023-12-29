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
    <title>Create Exam</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="exam_name" placeholder="Exam Name" required> <br>
        <input type="text" name="exam_description" placeholder="Exam Description"> <br>
        <input type="submit" value="Create" name="submit">
    </form>
</body>
</html>

<?php

        if(isset($_POST['submit'])) {
            $name = $_POST['exam_name'];
            $description = $_POST['exam_description'];
            $insertExamQuery = "INSERT INTO `exam`(`exam_title`, `exam_description`) 
                                VALUES ('$name','$description')";
            
            $insertResult = mysqli_query($connection, $insertExamQuery);
            if ($insertResult) {
                $exam_id = mysqli_insert_id($connection);
                $insertClassroomExamQuery = "INSERT INTO `classroom_exam`(`classroom_id`, `exam_id`) 
                                            VALUES ('$id','$exam_id')";
                $insertClassroomExamResult = mysqli_query($connection, $insertClassroomExamQuery);
                if ($insertClassroomExamResult) {
                    echo "<script> alert('Exam Created Successfully') </script>";
                    echo "<script> window.location.href=teacher-addquestion.php?id=$exam_id</script>";
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
</head>
<body>
    <h1>Please select the classroom you would like to manage: </h1>
    <ul>
        <?php
        while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
            echo '<li><a href="teacher-createexam.php?id=' . $classroom_row['classroom_id'] . '">' . $classroom_row['classroom_name'] . '</a></li>';
        }
        ?>
    </ul>
</body>
</html>

<?php

        }
    }

?>