<?php

    include "dbconn.php";
    include "stu-teac-session.php";

    if(isset($_GET['id'])) {
        $messages_id = $_GET['id'];
        $classroom_id_query = " SELECT cms.*, cm.* 
                                FROM chatroom_messages cms
                                JOIN classroom_member cm ON cms.classroom_member_id = cm.classroom_member_id 
                                WHERE cms.chatroom_messages_id ='$messages_id'"; 
        $classroom_id_result = mysqli_query($connection, $classroom_id_query);
        if(mysqli_num_rows($classroom_id_result) == 1) {
            $classroom_id_row = mysqli_fetch_assoc($classroom_id_result); 
            $classroom_id = $classroom_id_row['classroom_id'];
        } else {
            echo "<script> alert('There is an error.'); </script>";
            echo "<script> window.location.href='stu-teac-index.php'; </script>";
            exit();
        }
    } else {
        header("Location: stu-teac-index.php"); 
        exit(); 
    }

    $user_id = $_SESSION['id'];
    
    $checkQuery = "SELECT * FROM classroom_member WHERE user_id = '$user_id' AND classroom_id = '$classroom_id'";

    $checkResult = mysqli_query($connection, $checkQuery);

    if(mysqli_num_rows($checkResult) != 1) {
        echo "<script> alert('You are not a member of this classroom.'); </script>";
        echo "<script> window.location.href='stu-teac-index.php'; </script>";
        exit();
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
</head>
<body>
    <div>
        <h1></h1>
    </div>
</body>
</html>