<?php

    include "dbconn.php"; 
    include "teacher-session.php";

    if(isset($_SESSION['id'])){
        $user_id = $_SESSION['id'];
    } else {
        header("Location: feature-logout.php");
        exit(); 
    }

    if(isset($_GET['id'])) {
        $quiz_id = $_GET['id'];
        $query = "SELECT * FROM quiz WHERE quiz_id = '$quiz_id'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
</head>
<body>
    
    <h1>Add Question - <?php echo $row['quiz_title'];?></h1>

    <?php 



?>

</body>
</html>


<?php

    } else {
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
        if(mysqli_num_rows($fetch_result) > 0) {
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Exam</title>
</head>
<body>
    <h1>Choose the Exam you would like to add a question</h1>

    <?php
        while ($fetch_row = mysqli_fetch_assoc($fetch_result)) {
            echo "<a href='teacher-quizquestion.php?id=".$fetch_row['quiz_id']."'>".$fetch_row['quiz_title']."</a><br>";
        }
    ?>
</body>
</html>

<?php
            } else {
                echo "You are not involved in any classroom.";
            }
        } else {
        echo "Error in fetching data: " . mysqli_error($connection);
        }
    }
?>