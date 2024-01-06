<?php
include "dbconn.php";
include "feature-usermenu.php";
include "student-session.php";

$user_id = $_SESSION['id'];
$decline = TRUE; 

$fetchQuery = " SELECT ea.*, e.*
                FROM exam_attempt ea 
                JOIN exam e 
                ON ea.exam_id = e.exam_id
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/student-viewexamquiz.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <form id="examForm" action="" method="post">
        <div id="name"><b>Student Name: </b><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></div> <br>
        
        <!-- Dropdown list of quizzes -->
        <div id="title">Exam: </div>
        <select name="exam" id="exam" onchange="submitForm()">
            <option value="">Select a Exam</option>
            <?php
                while ($fetchRow = mysqli_fetch_assoc($fetchResult)) {
                    echo "<option value='". $fetchRow['exam_attempt_id']."'>" .$fetchRow['exam_attempt_id']." - ".$fetchRow['exam_title'] ."</option>";
                } 
            ?>
        </select>
    </form>
    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exam'])) {
        // user_id and exam_attempt_id is retrieved dy 
        $exam_attempt_id = $_POST['exam'];
        $totalMark = calculateFullMarks($exam_attempt_id, $connection);
        $userScore = calculateUserMarks($exam_attempt_id, $connection); 
        if($userScore == "Not finish marking"){
            $decline = FALSE; 
        } else {
            $wrongmark = $totalMark - $userScore;
            $decline = TRUE;
        }
        $examTitleQuery = "SELECT e.*, ea.*, ef.*
                            FROM exam_attempt ea 
                            JOIN exam e 
                            ON ea.exam_id = e.exam_id
                            JOIN exam_feedback ef ON ea.exam_attempt_id = ef.exam_attempt_id
                            WHERE ea.exam_attempt_id = $exam_attempt_id";

        $quiz_title_result = mysqli_query($connection, $examTitleQuery);
        $quiz_title_row = mysqli_fetch_assoc($quiz_title_result);
    
    ?>
        <table border="1">
        <tr>
            <th>Exam Attempt ID</th>
            <td><?php echo $exam_attempt_id; ?></td>
        </tr>
        <tr>
            <th>Exam Title</th>
            <td><?php echo $quiz_title_row['exam_title']; ?></td>
        </tr>
        <tr>
            <th>Exam Description</th>
            <td><?php echo $quiz_title_row['exam_description']; ?></td>
        </tr>
        <tr>
            <th>Exam Start Time</th>
            <td><?php echo $quiz_title_row['exam_start_time']; ?></td>
        </tr>
        <tr>
            <th>Exam End Time</th>
            <td><?php echo $quiz_title_row['exam_end_time']; ?></td>
        </tr>
        <tr>
            <th>Marks</th>
            <td><?php echo $userScore. " / ". $totalMark; ?></td>
        </tr>
        <tr>
            <th>Feedback</th>
            <td><?php echo $quiz_title_row['exam_feedback_content']; ?></td>
        </tr>
    </table>
    
    <?php
    
        $fetchExamQuery = "SELECT eua.*, eq.* FROM exam_user_answer eua 
                            JOIN exam_question eq ON eua.exam_question_id = eq.exam_question_id
                            WHERE eua.exam_attempt_id = '$exam_attempt_id'";
        $fetchExamResult = mysqli_query($connection, $fetchExamQuery);
        $calnum = 1; 
        while ($row = mysqli_fetch_assoc($fetchExamResult)) {
    
    ?>
        <div id="answer-box">
            <div id="numbering">
                <?php echo $calnum; $calnum = $calnum + 1;  ?> <br>
            </div>
            <p id="question"><b>Question: </b><?php echo $row['exam_question']; ?> </p>
            <p id="marks"><b>Mark Score: </b><?php echo $row['exam_user_marks']. " / ". $row['exam_marks']; ?></p>
            <p id="answer"><b>User Answer: </b><?php echo $row['exam_user_answer']; ?></p>
        </div>    

    <?php
        }
    }
    
    ?>
    <canvas id="quizChart" width="400" height="200"></canvas>
    
    <script>
        function submitForm() {
            document.getElementById("examForm").submit();
        }
    </script>
<?php

if ($decline) {
    // Execute the JavaScript code only if $decline is false
    ?>
    <script>
        var ctx = document.getElementById('quizChart').getContext('2d');
        var dataChart = {
            labels: ['Correct - Mark', 'Incorrect - Mark'],
            datasets: [{
                data: [<?php echo $userScore; ?>, <?php echo $wrongmark; ?>],
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
    <?php
    }
?>
</body>
</html>


<?php

    function calculateFullMarks($exam_attempt_id, $connection) {
        // SQL query to calculate the total marks for a specific exam attempt
        $totalMarkQuery = "
            SELECT SUM(eq.exam_marks) AS total_marks
            FROM exam_question eq
            INNER JOIN exam_user_answer eua ON eq.exam_question_id = eua.exam_question_id
            WHERE eua.exam_attempt_id = ?";

        // Prepare and execute the query
        $stmt = $connection->prepare($totalMarkQuery);
        $stmt->bind_param('i', $exam_attempt_id);
        $stmt->execute();
        $stmt->bind_result($total_marks);
        $stmt->fetch();

        // Close the statement
        $stmt->close();

        // Return the total marks
        return $total_marks;
    }

    function calculateUserMarks($exam_attempt_id, $connection) {
        // SQL query to check for NULL values among exam_user_marks
        $checkNullQuery = "
            SELECT COUNT(*) AS null_count
            FROM exam_user_answer
            WHERE exam_attempt_id = ?
            AND exam_user_marks IS NULL";

        // Prepare and execute the query
        $stmt = $connection->prepare($checkNullQuery);
        $stmt->bind_param('i', $exam_attempt_id);
        $stmt->execute();
        $stmt->bind_result($null_count);
        $stmt->fetch();

        // Close the statement
        $stmt->close();

        // Check if there is at least one NULL value
        if ($null_count > 0) {
            return "Not finish marking";
        }

        // If no NULL values, proceed to calculate the sum
        $userScoreQuery = "
            SELECT SUM(eua.exam_user_marks) AS user_marks
            FROM exam_user_answer eua
            WHERE eua.exam_attempt_id = ?";

        // Prepare and execute the query
        $stmt = $connection->prepare($userScoreQuery);
        $stmt->bind_param('i', $exam_attempt_id);
        $stmt->execute();
        $stmt->bind_result($user_marks);
        $stmt->fetch();

        // Close the statement
        $stmt->close();

        return $user_marks;
    }
?>
