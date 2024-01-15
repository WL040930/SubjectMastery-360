<?php

    // include all necessary files
    include "dbconn.php"; 
    include "feature-usermenu.php";
    include "teacher-session.php";

    // get the exam id from the url
    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    } else {
        // if the user is not logged in, redirect to the logout page
        header("Location: feature-logout.php");
        exit(); 
    }

    // get the exam id from the url
    if(isset($_GET['id'])) {
        $exam_id = $_GET['id'];
        $query = "SELECT * FROM exam WHERE exam_id = '$exam_id'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exam</title>
    <link rel="stylesheet" href="../css/animation.css">
    <link rel="stylesheet" href="../css/teacher-managequiz.css">
</head>
<body>

    <div class="mng_header">
        Manage exam - <?php echo $row['exam_title']; ?>
    </div>
    <div class="mng-desc">
        <?php echo $row['exam_description']; ?>
    </div>

    <div class="main-content">
        <table>
            <tr>
                <th>No.</th> 
                <th>Question</th> 
                <th>Marks</th>
                <th>Manage</th>
            </tr>
            <?php 
                $num = 0;
                $quesquery = "SELECT * FROM exam_question WHERE exam_id = '$exam_id'";
                $result = mysqli_query($connection, $quesquery);
                while ($rowques = mysqli_fetch_assoc($result)) {
                    $num++;
            ?>
            <tr>
                <td><?php echo $num; ?></td>
                <td><?php echo $rowques['exam_question']; ?></td>
                <td><?php echo $rowques['exam_marks']; ?></td>
                <td>
                    <a href="teacher-editexam.php?id=<?php echo $rowques['exam_question_id']; ?>" class="link"><img src="../image/edit.png" alt="edit" id="edit"></a></a>
                </td>
            </tr>
            <?php
                }
            ?>
        </table>
        <div class="linkdiv">
            <a href="teacher-examquestion.php?id=<?php echo $exam_id; ?>" class="link">Click Here to Add Question.</a>
        </div>
    </div>

</body>
</html>



<?php

    } else {
        // if the url does not contain the exam id, display the exam list
        $fetch = "SELECT 
                    cm.*,
                    c.*,
                    ce.*,
                    e.*
                FROM 
                    classroom_member cm
                JOIN 
                    classroom c ON cm.classroom_id = c.classroom_id
                JOIN 
                    classroom_exam ce ON c.classroom_id = ce.classroom_id
                JOIN 
                    exam e ON ce.exam_id = e.exam_id
                WHERE 
                    cm.user_id = '$user_id';
                ";

        $fetch_result = mysqli_query($connection, $fetch);

        if ($fetch_result) {
            // if the user is involved in any of the classroom, display the classroom list
            if(mysqli_num_rows($fetch_result) > 0) {
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Exam</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/animation.css">
    <link rel="stylesheet" href="../css/teacher-examquestion.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1 id="eq_h1" align="center">Choose The Exam You Would Like To Manage</h1>
    <div id="eq_choices">
    <ul>
        <?php
            while ($fetch_row = mysqli_fetch_assoc($fetch_result)) {
                echo "<a href='teacher-manageexam.php?id=".$fetch_row['exam_id']."'><li class='choose-classroom'>".$fetch_row['exam_title']."</li></a>";
            }
        ?>
    </ul>
    </div>
</body>
</html>

<?php
            } else {
                echo "<div style='text-align: center; font-size: 24px; margin-top: 100px;'>You did not create any exam before.</div>";
            }
        } else {
            echo "Error in fetching data: " . mysqli_error($connection);
        }
    }
?>