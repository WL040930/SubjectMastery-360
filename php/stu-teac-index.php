<?php

    include "dbconn.php";
    include "feature-usermenu.php";
    include "stu-teac-session.php";
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
    if(mysqli_num_rows($result) == 0) {
        echo "You are not a member of any classroom";
        exit();
    } else {
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classroom</title>
    <link rel="stylesheet" href="../css/index.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">

</head>
<body>
    <div class="flex-container">
        <?php
        // Loop through the classrooms and display information
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="flex-box">
                <a href="stu-teac-classroompage.php?id=<?php echo $row['classroom_id'];?>">
                    <div class="link" style="background-color: <?php echo $row['classroom_color'].';';?>">
                        <div class="imagepic">
                            <img src="../data/image<?php echo $row['classroom_picture'];?>" width="100px">
                        </div>
                        <div class="classroom_name">
                            <p><b><?php echo $row['classroom_name']; ?></b><p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
<?php
    }

// Close the database connection
mysqli_close($connection);
?>