<?php

    include "dbconn.php";
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/usermenu.css">
</head>

<body>

    <div id="header">
        <div id="image">
            <img src="../image/logo.png" alt="" height="100px">
        </div>
        <div id="title">
            <h1>Welcome, <?php echo $_SESSION['first_name']. " ". $_SESSION['last_name'];?></h1>
        </div>
        <div style="clear: both"></div>
    </div>

    <?php
    
        $role = $_SESSION['role']; 
        if ($role == 'student') {

    ?>
        <ul>
            <li> Classroom
                <ul>
                    <li><a href="stu-teac-viewclassroom.php">View Classroom</a></li>
                    <li><a href="#">Join Classroom</a></li>
                </ul>
            </li>
            <li> Quiz/Exam
                <ul>
                    <li><a href="#">Join Quiz</a></li>
                    <li><a href="#">Join Exam</a></li>
                </ul>
            </li>
            <li> Report
                <ul>
                    <li>
                        <a href="#">View Quiz Report</a>
                        <a href="#">View Exam Report</a>
                    </li>
                </ul>
            </li>
        </ul>
    <?php 
        } elseif ($role == 'teacher') {
    ?>
        <ul>
            <li> Classroom
                <ul>
                    <li><a href="stu-teac-viewclassroom.php">View Classroom</a></li>
                    <li><a href="teacher-createclassroom.php">Create Classroom</a></li>
                    <li><a href="teacher-manageclassroom.php">Manage Classroom</a></li>
                </ul>
            </li>
            <li> Quiz/Exam
                <ul>
                    <li><a href="#">Create Quiz</a></li>
                    <li><a href="#">Create Exam</a></li>
                </ul>
            </li>
            <li> Report
                <ul>
                    <li><a href="#">View Quiz Report</a></li>
                    <li><a href="#">View Exam Report</a></li>
                </ul>
            </li>
        </ul>
    <?php 
        }
    ?>
</body>
</html>
