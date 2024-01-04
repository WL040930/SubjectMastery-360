<?php

    include "dbconn.php";
    include "feature-feedbackbutton.php";

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: logout.php");
        exit();
    }
    
    $id = $_SESSION['id'];
    $query = "SELECT * FROM classroom_member cm JOIN classroom c ON cm.classroom_id = c.classroom_id WHERE cm.user_id = '$id'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($result)) {
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classroom</title>
    <link rel="stylesheet" href="../css/view-classroom.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div id="classroom-container">
        <a href="stu-teac-classroompage.php?id=<?php echo $row['classroom_id'];?>">
        <div id="border">
            <div id="classroom-column" style="background-color: <?php echo $row['classroom_color'].';';?>">
                <img src="../data/image<?php echo $row['classroom_picture'];?>" width="100px">
                <h2 id="class_name"><?php echo $row['classroom_name'];?></h2>
            </div>
            <div id="classroom-column" style="background-color: <?php echo $row['classroom_color'].';';?>">
                <img src="../data/image<?php echo $row['classroom_picture'];?>" width="100px">
                <h2><?php echo $row['classroom_name'];?></h2>
            </div>
            <div id="classroom-column" style="background-color: <?php echo $row['classroom_color'].';';?>">
                <img src="../data/image<?php echo $row['classroom_picture'];?>" width="100px">
                <h2><?php echo $row['classroom_name'];?></h2>
            </div>
            <div id="classroom-column" style="background-color: <?php echo $row['classroom_color'].';';?>">
                <img src="../data/image<?php echo $row['classroom_picture'];?>" width="100px">
                <h2><?php echo $row['classroom_name'];?></h2>
            </div>
            <div id="classroom-column" style="background-color: <?php echo $row['classroom_color'].';';?>">
                <img src="../data/image<?php echo $row['classroom_picture'];?>" width="100px">
                <h2><?php echo $row['classroom_name'];?></h2>
            </div>
        </div>    
        </a>
    </div>
</body>
</html>

<?php

    }

?>