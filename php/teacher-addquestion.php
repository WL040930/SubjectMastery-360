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
        $exam_id = $_GET['id'];
        

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
</head>
<body>
    
</body>
</html>


<?php

    } else {
        $fetch = "SELECT 
                    cm.*,
                    c.*,
                    ce.*,
                    e.*
                FROM 
                    classroom_member cm
                JOIN 
                    classroom c ON cm.classroom_id = c.classroom_id
                JOIN 
                    classroom_exam ce ON c.classroom_id = ce.classroom_id
                JOIN 
                    exam e ON ce.exam_id = e.exam_id
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
            echo "<a href='teacher-addquestion.php?id=".$fetch_row['exam_id']."'>".$fetch_row['exam_title']."</a><br>";
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