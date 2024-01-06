<?php

    include "dbconn.php";
    include "stu-teac-session.php";

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

<body id="allmenu">

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
    <div id="menu">
        <ul>
            <li>Classroom
                <ul>
                    <li><a href="stu-teac-index.php">View Classroom</a></li>
                    <li><a href="student-joinclassroom.php">Join Classroom</a></li>
                </ul>
            </li>
            <li>Quiz / Exam
                <ul>
                    <li><a href="student-quizattempt.php">Join Quiz</a></li>
                    <li><a href="student-examattempt.php">Join Exam</a></li>
                </ul>
            </li>
            <li>Results
                <ul>
                    <li><a href="student-viewquiz.php">View Quiz Results</a></li>
                    <li><a href="student-viewexam.php">View Exam Results</a></li>
                </ul>
            </li>
            <li>Others
                <ul>
                    <li><a href="stu-teac-editprofile.php?id=<?php echo $_SESSION['id']; ?>">Manage Profile</a></li>
                    <li><a href="feature-logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <?php 
        } elseif ($role == 'teacher') {
    ?>
    <div id="menu">
        <ul>
            <li>Classroom
                <ul>
                    <li><a href="stu-teac-index.php">View Classroom</a></li>
                    <li><a href="teacher-createclassroom.php">Create Classroom</a></li>
                    <li><a href="teacher-manageclassroom.php">Manage Classroom</a></li>
                </ul>
            </li>
            <li>Quiz / Exam
                <ul>
                    <li><a href="teacher-createquiz.php">Create Quiz</a></li>
                    <li><a href="teacher-createexam.php">Create Exam</a></li>
                </ul>
            </li>
            <li>Results
                <ul>
                    <li>View Quiz Results
                        <ul>
                            <li><a href="teacher-specificquiz.php">Specific Students</a></li>
                            <li><a href="teacher-overallquiz.php">Overall</a></li>
                        </ul>
                    </li>
                    <li><a href="teacher-specificexam.php">View Exam Results</a></li>
                </ul>
            </li>
            <li>Others
                <ul>
                    <li><a href="stu-teac-editprofile.php?id=<?php echo $_SESSION['id']; ?>">Manage Profile</a></li>
                    <li><a href="feature-logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <?php 
        }
    ?>
</body>
</html>
