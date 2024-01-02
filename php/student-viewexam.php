<?php
include "dbconn.php";
include "student-session.php";

$user_id = $_SESSION['id'];

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
</head>
<body>
    <form id="examForm" action="" method="post">
        <div id="name"><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></div> <br>
        
        <!-- Dropdown list of quizzes -->
        Quiz: 
        <select name="exam" id="exam" onchange="submitForm()">
            <option value="">Select a Exam</option>
            <?php
                while ($fetchRow = mysqli_fetch_assoc($fetchResult)) {
                    echo "<option value='". $fetchRow['exam_attempt_id']."'>" .$fetchRow['exam_title'] ."</option>";
                } 
            ?>
        </select>
    </form>
    <?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exam'])) {
        // user_id and exam_attempt_id is retrieved dy 
        echo $exam_attempt_id = $_POST['exam'];
    }
    
    ?>
    <script>
        function submitForm() {
            document.getElementById("examForm").submit();
        }
    </script>
</body>
</html>
