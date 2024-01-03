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
    
</body>
</html>