<?php

    include "dbconn.php";
    include "teacher-session.php";
    include "feature-usermenu.php";

    if (isset($_GET['id'])) {
        $quiz_question_id = $_GET['id'];
    } else {
        header("Location: teacher-managequiz.php");
    }

    $fetchQuery = "SELECT * FROM quiz_question WHERE quiz_question_id = '$quiz_question_id'";
    $fetchResult = mysqli_query($connection, $fetchQuery);
    $fetchRow = mysqli_fetch_assoc($fetchResult);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quiz</title>
    <link rel="stylesheet" href="../css/teacher-editquiz.css">
    <link rel="stylesheet" href="../css/animation.css">
</head>

<body>
    <div class="headerquiz">
        Edit Question
    </div>

    <form method="post" action="process_edit_question.php">
        <input type="hidden" name="quiz_question_id" value="<?php echo $quiz_question_id; ?>">
        <input type="hidden" name="quiz_id" value="<?php echo $fetchRow['quiz_id']; ?>">
        <table>
            <tr>
                <th>Question:</th>
                <td><input type="text" name="question" value="<?php echo $fetchRow['quiz_question_text']; ?>"></td> 
            </tr>

            <?php
                $optionQuery = "SELECT * FROM quiz_option WHERE quiz_question_id = '$quiz_question_id' AND iscorrect = '1'";
                $optionResult = mysqli_query($connection, $optionQuery);
                $optionRow = mysqli_fetch_assoc($optionResult);
            ?>

            <tr>
                <th>Correct Option:</th>
                <td><input type="text" name="correct_option" value="<?php echo $optionRow['option_text']; ?>"></td>
            </tr>

            <?php
            $incorrectQuery = "SELECT * FROM quiz_option WHERE quiz_question_id = '$quiz_question_id' AND iscorrect = '0'";
            $incorrectResult = mysqli_query($connection, $incorrectQuery);
            while ($incorrectRow = mysqli_fetch_assoc($incorrectResult)) {
            ?>

            <tr>
                <th>Incorrect Option:</th>
                <td>
                    <input type="text" name="incorrect_options[<?php echo $incorrectRow['quiz_option_id']; ?>]" value="<?php echo $incorrectRow['option_text']; ?>">
                    <input type="hidden" name="incorrect_option_ids[]" value="<?php echo $incorrectRow['quiz_option_id']; ?>">
                </td>
            </tr>

            <?php
            }
            ?>

        </table>
        
        <div class="divsubmit">
            <input type="submit" name="submit" value="Update" class="submitbtn">
        </div>
    </form>

    <div class="exit-btn">
        <button type="button" id="exit" onclick="exit()" class="exit-btn2">Exit</button>
    </div>

</body>
</html>

<script>
    function exit() {
        window.location.href = "teacher-managequiz.php?id=<?php echo $fetchRow['quiz_id']; ?>";
    }
</script>
