<?php

    include "dbconn.php";
    include "teacher-session.php"; 

    $id = $_SESSION['id'];

    $fetchQuery = "SELECT cm.*, c.*, ce.*, e.*
                    FROM classroom_member cm 
                    JOIN classroom c ON cm.classroom_id = c.classroom_id
                    JOIN classroom_exam ce ON c.classroom_id = ce.classroom_id
                    JOIN exam e ON ce.exam_id = e.exam_id
                    WHERE user_id = '$id'";
    $fetchResult = mysqli_query($connection, $fetchQuery);
    mysqli_num_rows($fetchResult); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Exam Result</title>
</head>
<body>
    <form id="examForm" action="" method="post">
        <!-- Dropdown list of quizzes -->
        Exam: 
        <select name="exam" id="exam" onchange="submitForm()">
            <option value="">Select a Exam</option>
            <?php
            while ($fetchRow = mysqli_fetch_assoc($fetchResult)) {
                echo "<option value='". $fetchRow['exam_id']."'>" .$fetchRow['exam_title'] ."</option>";
            } 
            ?>
        </select>
    </form>
    <?php
    if(isset($_POST['exam'])){ 
        $exam_id = $_POST['exam'];
        // Fetch users for the selected quiz
        $fetchUsersQuery = "SELECT DISTINCT u.*, ea.*
                            FROM user u
                            JOIN exam_attempt ea ON u.user_id = ea.user_id
                            WHERE ea.exam_id = '$exam_id'";
        $fetchUsersResult = mysqli_query($connection, $fetchUsersQuery);
    ?>

    <form action="" method="post" id="userForm">
        User: 
        <select name="user" id="user" onchange="submitForm2()">
            <option value="">Select a User</option>
            <?php
            while ($userRow = mysqli_fetch_assoc($fetchUsersResult)) {
                echo "<option value='". $userRow['exam_attempt_id']."'>" .$userRow['exam_attempt_id']." - ".$userRow['username']."</option>";
            }
            ?>
        </select>
    </form>
    
    <?php
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user'])) {
            // user_id and exam_attempt_id is retrieved dy 
            $exam_attempt_id = $_POST['user'];
            $totalMark = calculateFullMarks($exam_attempt_id, $connection);
            $userScore = calculateUserMarks($exam_attempt_id, $connection); 
            if($userScore == "Not finish marking"){
                $decline = FALSE; 
            } else {
                $wrongmark = $totalMark - $userScore;
                $decline = TRUE;
            }
            $examTitleQuery = "SELECT e.*, ea.*
                                FROM exam_attempt ea 
                                JOIN exam e 
                                ON ea.exam_id = e.exam_id
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
                <td><?php echo $userScore. " / ". $totalMark ?></td>
            </tr>
            <tr>
            <form action="" method="post">
                    <?php
                        $feedback_query = "SELECT * FROM exam_feedback WHERE exam_attempt_id = '$exam_attempt_id'";
                        $feedback_result = mysqli_query($connection, $feedback_query);
                        $feedback_row = mysqli_fetch_assoc($feedback_result);
                    ?>
                    <th>Overall Feedback</th>
                    <td>
                        <input type="text" name="feedback" value="<?php echo $feedback_row['exam_feedback_content']; ?>">
                        <input type="hidden" name="exam_attempt_id" value="<?php echo $exam_attempt_id; ?>">
                        <input type="submit" value="Submit" name="submitfeedback">
                    </td>
                </form>
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
        <?php echo $calnum; $calnum = $calnum + 1;  ?> <br>
        <p>Question: <?php echo $row['exam_question']; ?> </p>
        <p>Mark Score: <?php echo $row['exam_user_marks']. " / ". $row['exam_marks']; ?></p>
        <p>User Answer: <?php echo $row['exam_user_answer']; ?></p>
        <form action="" method="post">
            <input type="text" name="markInput" value="<?php echo $row['exam_user_marks']; ?>" <?php echo ($row['exam_user_marks'] !== null) ? 'required' : ''; ?>>
            <input type="submit" value="Update" name="updateMark">
        </form>
        <?php   
            if(isset($_POST['updateMark'])) {
                $mark = $_POST['markInput'];
                $exam_user_answer_id = $row['exam_user_answer_id'];
                $updateMark = "UPDATE `exam_user_answer` SET `exam_user_marks`='$mark' WHERE exam_user_answer_id = '$exam_user_answer_id'"; 
                $updateResult = mysqli_query($connection, $updateMark); 
                if ($updateResult) {
                    echo "yes"; 
                } else {
                    echo "no"; 
                }
            }
        ?>
    </div>    

    <?php
        }
    }

    ?>
</body>
</html>


<script>
    function submitForm() {
        document.getElementById("examForm").submit();
    }

    function submitForm2(){
        document.getElementById("userForm").submit();
    }
</script>

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

<?php
    if (isset($_POST['submitfeedback'])) {
        $feedback = $_POST['feedback'];
        $exam_attempt_id = $_POST['exam_attempt_id'];

        $update_feedback_query = "UPDATE `exam_feedback` SET `exam_feedback_content`='$feedback' WHERE exam_attempt_id = '$exam_attempt_id'";
        $update_feedback_result = mysqli_query($connection, $update_feedback_query);

        if ($update_feedback_result) {
            echo "<script>alert('Feedback Updated Successfully');</script>";
            exit(); 
        } else {
            echo "<script>alert('Feedback Update Failed');</script>";
            exit(); 
        }
    }
?>