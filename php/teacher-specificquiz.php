<?php
    include "dbconn.php";
    include "teacher-session.php";

    $id = $_SESSION['id'];

    $fetchQuery = "SELECT cm.*, c.*, cq.*, q.*
                    FROM classroom_member cm 
                    JOIN classroom c ON cm.classroom_id = c.classroom_id
                    JOIN classroom_quiz cq ON c.classroom_id = cq.classroom_id
                    JOIN quiz q ON cq.quiz_id = q.quiz_id
                    WHERE user_id = '$id'";
    $fetchResult = mysqli_query($connection, $fetchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quiz Result</title>
    <link rel="icon" href="../image/icon.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/teacher-specificquiz.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body id="all"> 
    <form id="quizForm" action="" method="post">
        <!-- Dropdown list of quizzes -->
        Quiz: 
        <select name="quiz" id="quiz" onchange="submitForm()">
            <option value="">Select a Quiz</option>
            <?php
            while ($fetchRow = mysqli_fetch_assoc($fetchResult)) {
                echo "<option value='". $fetchRow['quiz_id']."'>" .$fetchRow['quiz_title'] ."</option>";
            } 
            ?>
        </select>
    </form>

    <?php
    if(isset($_POST['quiz'])){ 
        $quiz_id = $_POST['quiz'];
        // Fetch users for the selected quiz
        $fetchUsersQuery = "SELECT DISTINCT u.*, qa.*
                            FROM user u
                            JOIN quiz_attempt qa ON u.user_id = qa.user_id
                            WHERE qa.quiz_id = '$quiz_id'";
        $fetchUsersResult = mysqli_query($connection, $fetchUsersQuery);
    ?>
    <!-- Display the second dropdown only if a quiz is selected -->
    <form action="" method="post" id="userForm">
        User: 
        <select name="user" id="user" onchange="submitForm2()">
            <option value="">Select a User</option>
            <?php
            while ($userRow = mysqli_fetch_assoc($fetchUsersResult)) {
                echo "<option value='". $userRow['quiz_attempt_id']."'>" .$userRow['quiz_attempt_id']." - ".$userRow['username']."</option>";
            }
            ?>
        </select>
    </form>
    <?php
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user'])) {
        // user_id and quiz_attempt_id are retrieved
        $quiz_attempt_id = $_POST['user'];
        $totalMark = quiz_total_mark($quiz_attempt_id); 
        $userScore = calculate_user_score($quiz_attempt_id);
        $quiz_title_query = "SELECT q.*, qa.*, u.* FROM quiz_attempt qa
                                JOIN quiz q ON qa.quiz_id = q.quiz_id
                                JOIN user u ON qa.user_id = u.user_id
                                WHERE qa.quiz_attempt_id = $quiz_attempt_id";
        $quiz_title_result = mysqli_query($connection, $quiz_title_query);
        $quiz_title_row = mysqli_fetch_assoc($quiz_title_result);
    ?>
    
    <table border="1">
        <tr>
            <th>Quiz Attempt ID</th>
            <td><?php echo $quiz_attempt_id; ?></td>
        </tr>
        <tr>
            <th>User</th>
            <td><?php echo $quiz_title_row['username']; ?></td>
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
        <tr>
    <form action="" method="post">
        <?php
        $feedback_query = "SELECT * FROM quiz_feedback WHERE quiz_attempt_id = '$quiz_attempt_id'";
        $feedback_result = mysqli_query($connection, $feedback_query);
        $feedback_row = mysqli_fetch_assoc($feedback_result);
        ?>
        <th>Overall Feedback</th>
        <td>
            <input type="text" name="feedback" value="<?php echo $feedback_row['quiz_feedback_content']; ?>">
            <input type="hidden" name="quiz_attempt_id" value="<?php echo $quiz_attempt_id; ?>"> <br>
            <input type="submit" value="Submit" name="submitfeedback">
        </td>
    </form>
</tr>
    </table>

    <?php
        $fetchResultQuery = "SELECT qq.*, qo.*, qua.*, qf.quiz_feedback_content 
                            FROM quiz_user_answer qua 
                            JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id 
                            LEFT JOIN quiz_option qo ON qua.answer = qo.quiz_option_id
                            LEFT JOIN quiz_feedback qf ON qf.quiz_attempt_id = qua.quiz_attempt_id
                            WHERE qua.quiz_attempt_id = $quiz_attempt_id"; 
        $fetchResultQueryResult = mysqli_query($connection, $fetchResultQuery);
        $calnum = 1; 
        $correctData = 0;
        $incorrectData = 0;

        if(mysqli_num_rows($fetchResultQueryResult) > 0) {
            while($row = mysqli_fetch_assoc($fetchResultQueryResult)) {
                if ($row['iscorrect'] == true) {
                    $correctData++;
                } else {
                    $incorrectData++;
                }
        ?>

    <div id="answer-box">
        <div id="quesnum"><?php echo $calnum; $calnum = $calnum + 1; ?> </div>
        <div id="quesques"><b><p>Question: </b><?php echo $row['quiz_question_text']; ?></p></div>
        <div id="quesans"><p><b>User Answer: </b><?php echo $row['option_text']; ?></p></div>
        <div id="correctanswer"><?php
            if ($row['iscorrect'] == TRUE) {
                echo "<div id='correct'>CORRECT</div>"; 
            } else {
                echo "<div id='incorrect'>INCORRECT</div><br>";
                $fetchCorrectAnswer = "SELECT * FROM quiz_option WHERE quiz_question_id = ".$row['quiz_question_id']." AND iscorrect = 1";
                $fetchCorrectAnswerResult = mysqli_query($connection, $fetchCorrectAnswer);
                $correctAnswerRow = mysqli_fetch_assoc($fetchCorrectAnswerResult);
                echo "<div id='final_ans'><b>Correct Answer: </b></div>".$correctAnswerRow['option_text'];
            }
        ?>
        </div>
    </div>
    <?php
            }
        }
    }
    

    ?>

    <!-- Adjusted the size of the canvas for better performance -->
    <div class="chart-container"><canvas id="quizChart" width="400" height="200"></canvas></div>

    <script>
        function submitForm() {
            document.getElementById("quizForm").submit();
        }

        function submitForm2() {
            document.getElementById("userForm").submit();
        }
    </script>
    <script>
        var ctx = document.getElementById('quizChart').getContext('2d');
        var dataChart = {
            labels: ['Correct - Question', 'Incorrect - Question'],
            datasets: [{
                data: [<?php echo $correctData; ?>, <?php echo $incorrectData; ?>],
                backgroundColor: [
                    'rgba(75, 192, 75, 0.7)', // Green for correct
                    'rgba(255, 99, 132, 0.7)' // Red for incorrect
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)',
                    'rgba(255, 255, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Create the pie chart with data
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: dataChart,
        });
    </script>
</body>
</html>

<?php

    function quiz_total_mark($quiz_attempt_id) {
        global $connection;

        // SQL query to calculate the total marks for a specific quiz attempt
        $totalMarkQuery = "
            SELECT SUM(qq.quiz_mark) AS total_mark
            FROM quiz_user_answer qua
            INNER JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
            WHERE qua.quiz_attempt_id = ?";

        // Prepare and execute the query
        $stmt = $connection->prepare($totalMarkQuery);
        $stmt->bind_param('i', $quiz_attempt_id);
        $stmt->execute();
        $stmt->bind_result($total_mark);
        $stmt->fetch();

        // Close the statement
        $stmt->close();

        // Return the total mark
        return $total_mark;
    }

    function calculate_user_score($quiz_attempt_id) {
        global $connection;

        // SQL query to calculate the user's score based on correctness of answers
        $userScoreQuery = "
            SELECT SUM(qq.quiz_mark * qo.iscorrect) AS user_score
            FROM quiz_user_answer qua
            INNER JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
            INNER JOIN quiz_option qo ON qua.answer = qo.quiz_option_id
            WHERE qua.quiz_attempt_id = ?";

        // Prepare and execute the query
        $stmt = $connection->prepare($userScoreQuery);
        $stmt->bind_param('i', $quiz_attempt_id);
        $stmt->execute();
        $stmt->bind_result($user_score);
        $stmt->fetch();

        // Close the statement
        $stmt->close();

        // Return the user's score
        return $user_score;
    }
?>
<?php
if (isset($_POST['submitfeedback'])) {
    $feedback = $_POST['feedback'];
    $quiz_attempt_id = $_POST['quiz_attempt_id']; // Retrieve quiz_attempt_id from the form

    $update_feedback_query = "UPDATE `quiz_feedback` SET `quiz_feedback_content`='$feedback' WHERE quiz_attempt_id = '$quiz_attempt_id'";
    $update_feedback_result = mysqli_query($connection, $update_feedback_query);

    if ($update_feedback_result) {
        echo "<script>alert('Feedback Updated Successfully');</script>";
    } else {
        echo "<script>alert('Feedback Update Failed');</script>";
    }
}
?>