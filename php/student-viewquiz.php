<?php

    // include necessary files
    include "dbconn.php";
    include "feature-usermenu.php";
    include "student-session.php";

    // retrieve user id from session
    $user_id = $_SESSION['id'];

    // SQL query to retrieve all the quiz attempt for the user
    $fetchQuery = "SELECT qa.*, q.*
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
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/animation.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/student-viewexamquiz.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1 align="center" style="margin: 20px;">View Quiz Result - <?php echo $_SESSION['first_name']. " ". $_SESSION['last_name']; ?></h1>

    <?php

        // if there is no quiz attempt for the user, display the message
        if (mysqli_num_rows($fetchResult) == 0) {
            echo "<h2 align='center'>No Quiz Attempt</h2> <br>";
        } else {
            // if user has quiz attempt, display the message

    ?>

    <!-- A drop down list allows user to select the specific -->
    <div class="formquiz">
        <form action="" method="post" id="quizForm">
            Quiz: 
            <select name="quiz" id="quiz" onchange="submitForm()">
                <option value="">Select Quiz: </option>
                <?php
                while ($userRow = mysqli_fetch_assoc($fetchResult)) {
                    echo "<option value='". $userRow['quiz_attempt_id']."'>" .$userRow['quiz_attempt_id']." - ".$userRow['quiz_title']."</option>";
                }
                ?>
            </select>
        </form>
    </div>

    <?php
    
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quiz'])) {
            // user_id and quiz_attempt_id are retrieved
            $quiz_attempt_id = $_POST['quiz'];

            // calculate the total mark and user score
            $totalMark = quiz_total_mark($quiz_attempt_id, $user_id); 
            $userScore = calculate_user_score($quiz_attempt_id, $user_id);

            // SQL query to retrieve the quiz attempt information
            $quiz_title_query = "SELECT q.*, qa.*, u.*, qf.* 
                                    FROM quiz_attempt qa
                                    JOIN quiz q ON qa.quiz_id = q.quiz_id
                                    JOIN user u ON qa.user_id = u.user_id
                                    JOIN quiz_feedback qf ON qa.quiz_attempt_id = qf.quiz_attempt_id
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
            <th>Feedback</th>
            <td><?php echo $quiz_title_row['quiz_feedback_content']; ?></td>
        </tr>
    </table>

    <?php

        // fetch the question and answer for the quiz attempt
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

    <!-- display the question and answer -->
    <div id="answer-box">
        <div id="quesnum"><?php echo $calnum; $calnum = $calnum + 1; ?> </div>
        <div id="quesques"><b><p>Question: </b><?php echo $row['quiz_question_text']; ?></p></div>
        <div id="quesans"><p><b>User Answer: </b><?php echo $row['option_text']; ?></p></div>
        <div id="correctanswer">
        <?php
            if ($row['iscorrect'] == TRUE) {
                echo "<div id='correct'>CORRECT</div>"; 
            } else {

                // display correct answer if the user answer is incorrect
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

    <!-- display the chart -->
    <div class="chart-container"><canvas id="quizChart" width="400" height="200"></canvas></div>

    <?php

        }
        
    ?>

    <script>
        // Submit the form when the user selects an option
        function submitForm() {
            document.getElementById("quizForm").submit();
        }
    </script>

    <script>

        // Get the context of the canvas element want to select
        var ctx = document.getElementById('quizChart').getContext('2d');

        // Set the data for the chart
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

    // Function to calculate the total mark for a specific quiz attempt and user
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

    // Function to calculate the user's score for a specific quiz attempt and user
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
