<?php

    include "dbconn.php"; 
    include "admin-menu.php"; 
    include "admin-session.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page - Admin</title>
    <link rel="stylesheet" href="../css/adminmenu.css">
</head>

<body>
    <?php 
        $userQuery = "SELECT COUNT(*) AS user_count FROM user;";
        $userResult = mysqli_query($connection, $userQuery); 
        if ($userQuery) {
            $userRow = mysqli_fetch_assoc($userResult);
    ?>
    Total User: <?php echo $userRow['user_count'];  ?>
    <?php } ?>

    <br>

    <?php 
        $classroomQuery = "SELECT COUNT(*) AS classroom_count FROM classroom;";
        $classroomResult = mysqli_query($connection, $classroomQuery); 
        if($classroomQuery){
            $classroomRow = mysqli_fetch_assoc($classroomResult);
    ?>
    Total Classroom: <?php echo $classroomRow['classroom_count']; ?>
    <?php } ?>
</body>
</html>