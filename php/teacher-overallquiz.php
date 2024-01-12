<?php

    // include necessary files
    include "dbconn.php";
    include "feature-usermenu.php";
    include "teacher-session.php";

    // get the quiz id from the url
    $id = $_SESSION['id'];

    // Fetch the quizzes that the teacher has created
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
    <link rel="stylesheet" href="../css/teacher-overallquiz.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
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

        // If the user has selected a quiz, display the quiz result
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quiz'])) {
            $quiz_id = $_POST['quiz'];
            $titleQuery = "SELECT * FROM quiz WHERE quiz_id = '$quiz_id'";
            $titleResult = mysqli_query($connection, $titleQuery);
            $titleRow = mysqli_fetch_assoc($titleResult);
            $quiz_title = $titleRow['quiz_title'];
            $numofAttempt = quiz_attempt_count($quiz_id);
            // If there is at least one attempt, calculate the average mark
            if ($numofAttempt > 0) {
                $totalMark = calculate_total_marks($quiz_id, $connection); 
                $averageMark = $totalMark / $numofAttempt;
                $fullMark = calculate_total_possible_marks($quiz_id, $connection); 
                $percentage = ($averageMark / $fullMark) * 100;
                $incorrect = 100 - $percentage; 
            } else {
                $averageMark = 0;
                $fullMark = 0;
                $percentage = 0;
                $incorrect = 0;
            }
    ?>
        <!-- Display the quiz result -->
        <table border="1">
            <tr>
                <th>Quiz ID</th>
                <td><?php echo $quiz_id; ?></td>
            </tr>
            <tr>
                <th>Quiz Title</th>
                <td><?php echo $quiz_title; ?></td>
            </tr>
            <tr>
                <th>Number of Attempt</th>
                <td><?php echo $numofAttempt; ?></td>
            </tr>
            <tr>
                <th>Full Marks of the Assessment</th>
                <td><?php echo $fullMark; ?></td>
            </tr>
            <tr>
                <th>Average Mark</th>
                <td><?php echo $averageMark; ?></td>
            </tr>
            <tr>
                <th>Percentage</th>
                <td><?php echo $percentage; ?></td>
            </tr>
        </table>
        <!-- Display the chart -->
        <div class="chart-container">
            <canvas id="quizChart" width="400" height="200"></canvas>
        </div>
    <?php

        }
    
    ?>
    
    <script>
        // Function to submit the form
        function submitForm() {
            document.getElementById("quizForm").submit();
        }
    </script> 
    <script>
        // Create the chart
        var ctx = document.getElementById('quizChart').getContext('2d');
        var dataChart = {
            labels: ['Correct Percentage', 'Incorrect Percentage'],
            datasets: [{
                data: [<?php echo $percentage; ?>, <?php echo $incorrect; ?>],
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

    // Function to calculate the number of attempts for a specific quiz
    function quiz_attempt_count($quiz_id) {
        global $connection;

        // Fetch the attempt count
        $attemptCountQuery = "
            SELECT COUNT(DISTINCT qa.quiz_attempt_id) AS attempt_count
            FROM quiz_attempt qa
            WHERE qa.quiz_id = ?";

        $stmt = $connection->prepare($attemptCountQuery);
        $stmt->bind_param('i', $quiz_id); // 'i' represents an integer type
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $attempt_count = $row['attempt_count'];
        } else {
            $attempt_count = 0;
        }

        // Close the statement
        $stmt->close();

        // Return the attempt count for the specific quiz
        return $attempt_count;
    }


    // Function to calculate the total marks of a specific quiz
    function calculate_total_marks($quiz_id, $db) {
        // Fetch the total marks
        $query = "  SELECT SUM(qq.quiz_mark) as total_marks
                    FROM quiz_user_answer qua
                    JOIN quiz_attempt qa ON qua.quiz_attempt_id = qa.quiz_attempt_id
                    JOIN quiz_question qq ON qua.quiz_question_id = qq.quiz_question_id
                    JOIN quiz_option qot ON qua.answer = qot.quiz_option_id
                    WHERE qa.quiz_id = ? AND qot.iscorrect = 1
                    ";

        // Prepare the statement
        // The question mark (?) is a placeholder for the quiz id
        // 'i' represents an integer type
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_marks'];
    }

    // Function to calculate the total possible marks of a specific quiz
    function calculate_total_possible_marks($quiz_id, $db) {
        $query = "  SELECT SUM(qq.quiz_mark) as total_marks
                    FROM quiz_question qq
                    WHERE qq.quiz_id = ?
                    ";
                    
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $quiz_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total_marks'];
    }

?>