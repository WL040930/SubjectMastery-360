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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .flex-container {
            width: 85%;
            margin: 0 auto;
            height: auto;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .flex-box {
            width: 250px;
            height: 200px;
            color: white;
            font-size: 25px;
            text-align: center;
            line-height: 200px;
            border-radius: 20px;
            margin: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .link {
            text-decoration: none;
            color: black;
            display: block;
            height: 100%;
            width: 100%;
            border-radius: 20px;
            transition: transform 0.2s;
        }

        .flex-box a {
            text-decoration: none;
            color: white;
        }

        .flex-box a:hover {
            text-decoration: none;
            color: black;
        }

        .flex-box a:visited {
            text-decoration: none;
            color: black;
        }

        .link img {
            width: 120px;
            height: auto;
            margin-bottom: 10px;
            border-radius: 25px;
        }

        .link:hover {
            transform: scale(1.05); 
        }

        .imagepic {
            width: 100%;
            height: 125px;
            padding: 10px; 
        }

        .classroom_name {
            width: 100%;
            height: 100px;
            font-size: 20px;
            line-height: 100px;
            position: relative;
            top: -20px;
        }

        
    </style>
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
                            <b><?php echo $row['classroom_name']; ?></b>
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