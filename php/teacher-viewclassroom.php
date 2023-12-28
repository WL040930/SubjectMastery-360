<?php

    include "dbconn.php";
    session_start(); 

    $id = $_SESSION['id'];
    $query = "SELECT * FROM classroom_member cm JOIN classroom c ON cm.classroom_id = c.classroom_id WHERE cm.user_id = '$id'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['classroom_name']; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classroom</title>
</head>
<body>
    <div></div>
</body>
</html>