<?php

    include "dbconn.php";
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Menu</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/usermenu.css">
    <!--website name font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@600&display=swap" rel="stylesheet">
    <!--others font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>

    <div id="header">
        <a href="mainpage.php"><img src="../image/pic_re.png" id="weblogo" alt="logo"></a>
        <div id="webname">
            <h1>SubjectMastery360</h1>
        </div>
        <div id="title">
            <h1>Welcome <?php echo $_SESSION['first_name']. " ". $_SESSION['last_name'];?>!</h1>
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
                    <li><a href="student-joinclassroom.php">Join Classroom</a></li>
                </ul>
            </li>
            <li> Quiz/Exam
                <ul>
                    <li><a href="student-quizattempt.php">Join Quiz</a></li>
                    <li><a href="student-examattempt.php">Join Exam</a></li>
                </ul>
            </li>
            <li> Report
                <ul>
                    <li><a href="student-viewquiz.php">View Quiz Report</a></li>
                    <li><a href="#">View Exam Report</a></li>
                </ul>
            </li>
            <li> Others
                <ul>
                    <li><a href="#">Manage Profile</a></li>
                    <li><a href="#">Logout</a></li>
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
                    <li><a href="teacher-createexam.php">Create Exam</a></li>
                </ul>
            </li>
            <li> Report
                <ul>
                    <li><a href="#">View Quiz Report</a></li>
                    <li><a href="#">View Exam Report</a></li>
                </ul>
            </li>
            <li> Others
                <ul>
                    <li><a href="#">Manage Profile</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </li>
        </ul>
    <?php 
        }
    ?>
</body>
</html>
