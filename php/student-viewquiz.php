<?php
include "dbconn.php";
include "student-session.php";

$user_id = $_SESSION['id'];

$fetchQuery = " SELECT qa.*, q.*
                FROM quiz_attempt qa 
                JOIN quiz q 
                ON qa.quiz_id = q.quiz_id
                WHERE user_id = '$user_id'"; 
$fetchResult = mysqli_query($connection, $fetchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quiz Result</title>
</head>
<body>
    <form id="quizForm" action="" method="post">
        <div id="name"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></div> <br>
        
        <!-- Dropdown list of quizzes -->
        Quiz: 
        <select name="quiz" id="quiz" onchange="submitForm()">
            <option value="">Select a Quiz</option>
            <?php
                while ($fetchRow = mysqli_fetch_assoc($fetchResult)) {
                    echo "<option value='". $fetchRow['quiz_attempt_id']."'>" .$fetchRow['quiz_title'] ."</option>";
                } 
            ?>
        </select>
    </form>
    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quiz'])) {
        // user_id and quiz_attempt_id is retrieved dy 
        $quiz_attempt_id = $_POST['quiz'];
        $totalMark = quiz_total_mark($quiz_attempt_id, $user_id); 
        $userScore = calculate_user_score($quiz_attempt_id, $user_id);
        $quiz_title_query = "SELECT q.*, qa.* FROM quiz_attempt qa
                                JOIN quiz q ON qa.quiz_id = q.quiz_id";
        $quiz_title_result = mysqli_query($connection, $quiz_title_query);
        $quiz_title_row = mysqli_fetch_assoc($quiz_title_result);
    ?>
    
    <table border="1">
        <tr>
            <th>Quiz Attempt ID</th>
            <td><?php echo $quiz_attempt_id; ?></td>
        </tr>
        <tr>
            <th>Quiz Title</th>
            <td><?php echo $quiz_title_row['quiz_title']; ?></td>
        </tr>
        <tr>
            <th>Quiz Description</th>
            <td><?php echo $quiz_title_row['quiz_description']; ?></td>
        </tr>
        <tr>
            <th>Quiz Start Time</th>
            <td><?php echo $quiz_title_row['quiz_start_time']; ?></td>
        </tr>
        <tr>
            <th>Quiz End Time</th>
            <td><?php echo $quiz_title_row['quiz_end_time']; ?></td>
        </tr>
        <tr>
            <th>Marks</th>
            <td><?php echo $userScore. " / ". $totalMark ?></td>
        </tr>
    </table>

    <?php
    $fetchResultQuery = "SELECT qq.*, qo.*, qua.* 
                         FROM quiz_user_answer qua 
                         JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id 
                         JOIN quiz_option qo ON qua.answer = qo.quiz_option_id
                         WHERE qua.quiz_attempt_id = $quiz_attempt_id"; 
    $fetchResultQueryResult = mysqli_query($connection, $fetchResultQuery);
    $calnum = 1; 
    if(mysqli_num_rows($fetchResultQueryResult) > 0) {
        while($row = mysqli_fetch_assoc($fetchResultQueryResult)) {
?>

    <div id="answer-box">
        <?php echo $calnum; $calnum = $calnum + 1; ?> <br>
        <p>Question: <?php echo $row['quiz_question_text']; ?></p>
        <p>User Answer: <?php echo $row['option_text']; ?></p>
        <?php
            if ($row['iscorrect'] == TRUE) {
                echo "CORRECT"; 
            }
            else {
                echo "INCORRECT <br>";
                $fetchCorrectAnswer = "SELECT * FROM quiz_option WHERE quiz_question_id = ".$row['quiz_question_id']." AND iscorrect = 1";
                $fetchCorrectAnswerResult = mysqli_query($connection, $fetchCorrectAnswer);
                $correctAnswerRow = mysqli_fetch_assoc($fetchCorrectAnswerResult);
                echo "Correct Answer: ".$correctAnswerRow['option_text'];
            }
        ?>
    </div>

<?php
        }
    }
    }

    ?>

    <script>
        function submitForm() {
            document.getElementById("quizForm").submit();
        }
    </script>
</body>
</html>


<?php

    function quiz_total_mark($quiz_attempt_id, $user_id) {
        global $connection;

        // SQL query to calculate the total marks for a specific quiz attempt and user
        $totalMarkQuery = "
            SELECT SUM(qq.quiz_mark) AS total_mark
            FROM quiz_user_answer qua
            INNER JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
            WHERE qua.quiz_attempt_id = ?
            AND qua.quiz_attempt_id IN (
                SELECT quiz_attempt_id
                FROM quiz_attempt
                WHERE user_id = ?
            )";

        // Prepare and execute the query
        $stmt = $connection->prepare($totalMarkQuery);
        $stmt->bind_param('ii', $quiz_attempt_id, $user_id);
        $stmt->execute();
        $stmt->bind_result($total_mark);
        $stmt->fetch();

        // Close the statement
        $stmt->close();

        // Return the total mark
        return $total_mark;
}

?>


<?php

    function calculate_user_score($quiz_attempt_id, $user_id) {
        global $connection;

        // SQL query to calculate the user's score based on correctness of answers
        $userScoreQuery = "
            SELECT SUM(qq.quiz_mark * qo.iscorrect) AS user_score
            FROM quiz_user_answer qua
            INNER JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
            INNER JOIN quiz_option qo ON qua.answer = qo.quiz_option_id
            WHERE qua.quiz_attempt_id = ?
            AND qua.quiz_attempt_id IN (
                SELECT quiz_attempt_id
                FROM quiz_attempt
                WHERE user_id = ?
            )";

        // Prepare and execute the query
        $stmt = $connection->prepare($userScoreQuery);
        $stmt->bind_param('ii', $quiz_attempt_id, $user_id);
        $stmt->execute();
        $stmt->bind_result($user_score);
        $stmt->fetch();

        // Close the statement
        $stmt->close();

        // Return the user's score
        return $user_score;
    }
?>
