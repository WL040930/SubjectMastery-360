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
    <title>View Feedback</title>
</head>

<style>
    #feedback-box {
        border: 1px solid black;
        width: 100%; 
        height: 100%;  
    }

    #profile-picture {
        border: 1px solid black; 
        float: left;
        width: 10%; 
        height: auto; 
    }

    #content {
        border: 1px solid black;
        float: right;
        width: 85%; 
        height: auto;   
    }
</style>

<body>

    <?php
    
        $query = "SELECT
                    user.user_id,
                    user.username,
                    feedback.feedback_content
                FROM
                    user
                INNER JOIN
                    feedback ON user.user_id = feedback.user_id;    
                "; 
        $result = mysqli_query($connection, $query); 
        while($row = mysqli_fetch_assoc($result)) {
    
    ?>

    <div id="feedback-page">
        <div id="feedback-box">
            <div id="profile-picture">Picture</div>
            <div id="content">
                <div id="content-box">
                    <?php echo $row['user_id'];?>
                </div>
                <div id="content-box">
                    <?php echo $row['username'];?>
                </div>
                <div id="content-box">
                    <?php echo $row['feedback_content'];?>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
    </div>
</body>
</html>

<?php

        }

?>