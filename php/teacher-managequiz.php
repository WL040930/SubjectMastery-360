<?php

    include "dbconn.php";
    include "feature-usermenu.php";
    include "teacher-session.php";

    $user_id = $_SESSION['id'];

    if(isset($_GET['id'])) {
        $quiz_id = $_GET['id'];
        $query = "SELECT q.*, qq.*
                  FROM quiz q
                  JOIN quiz_question qq ON q.quiz_id = qq.quiz_id
                  WHERE q.quiz_id = '$quiz_id'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $num = 0;

        mysqli_data_seek($result, 0);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quiz</title>
    <link rel="stylesheet" href="../css/teacher-managequiz.css">
    <link rel="stylesheet" href="../css/animation.css">
</head>
<body>
    <div class="mng_header">
        Manage Quiz - <?php echo $row['quiz_title']; ?>
    </div>
    <div class="mng-desc">
        <?php echo $row['quiz_description']; ?>
    </div>

    <div class="main-content">
        <table>
            <tr>
               <th>No.</th> 
               <th>Question</th> 
               <th>Option 1 - Correct Answer</th> 
               <th>Option 2</th> 
               <th>Option 3</th> 
               <th>Option 4</th> 
               <th>Manage</th>
            </tr>
            <?php 
                while ($rowques = mysqli_fetch_assoc($result)) {
                    $num++;
            ?>
            <tr>
                <td><?php echo $num; ?></td>
                <td><?php echo $rowques['quiz_question_text']; ?></td>
                <?php
                    $optionQuery = "SELECT * FROM quiz_option WHERE quiz_question_id = '".$rowques['quiz_question_id']."' AND iscorrect = '1'";
                    $optionResult = mysqli_query($connection, $optionQuery);
                    $optionRow = mysqli_fetch_assoc($optionResult);
                ?>
                <td><?php echo $optionRow['option_text']; ?></td>
                <?php
                    $incorrectQuery = "SELECT * FROM quiz_option WHERE quiz_question_id = '".$rowques['quiz_question_id']."' AND iscorrect = '0'";
                    $incorrectResult = mysqli_query($connection, $incorrectQuery);
                    while ($incorrectRow = mysqli_fetch_assoc($incorrectResult)) {
                ?>
                <td><?php echo $incorrectRow['option_text']; ?></td>
                <?php
                    }
                ?>
                <td><a href="teacher-editquiz.php?id=<?php echo $rowques['quiz_question_id']; ?>"><img src="../image/edit.png" alt="edit" id="edit"></a></td>
            </tr>

            <?php
                }
            ?>
        </table>

        <div class="linkdiv">
            <a href="teacher-quizquestion.php?id=<?php echo $quiz_id; ?>" class="link">Click Here to Add Question.</a>
        </div>
    </div>
</body>
</html>

<?php
    
    } else {
        // if the user has not choose the quiz, show the list of quiz
        $fetch = "SELECT 
                    cm.*,
                    c.*,
                    cq.*,
                    q.*
                FROM 
                    classroom_member cm
                JOIN 
                    classroom c ON cm.classroom_id = c.classroom_id
                JOIN 
                    classroom_quiz cq ON c.classroom_id = cq.classroom_id
                JOIN 
                    quiz q ON cq.quiz_id = q.quiz_id
                WHERE 
                    cm.user_id = '$user_id';
                ";

        $fetch_result = mysqli_query($connection, $fetch);

        if ($fetch_result) {
            // if the user has created any quiz before, show the list of quiz
            if(mysqli_num_rows($fetch_result) > 0) {
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Quiz</title>
    <link rel="stylesheet" href="../css/teacher-quizquestion.css">
    <link rel="stylesheet" href="../css/animation.css">
</head>
<body>
    <h1 align="center">Choose the Quiz you would like to Manage</h1>
    <ul>
    <?php
        while ($fetch_row = mysqli_fetch_assoc($fetch_result)) {
            echo "<a class='linktoclassroom' href='teacher-managequiz.php?id=".$fetch_row['quiz_id']."'><li class='choose-classroom'>".$fetch_row['quiz_title']."</li></a>";
        }
    ?>
    </ul>
</body>
</html>

<?php
            } else {
                // if the user has not created any quiz before, show the message
                echo "<div style='text-align: center; font-size: 24px; margin-top: 100px;'>You did not create any quiz before.</div>";
            }
        } else {
            echo "Error in fetching data: " . mysqli_error($connection);
        }
    }
?>