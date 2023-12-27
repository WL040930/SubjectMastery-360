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
    #feedback-page {
        width: 100%;
        height: 100%;
    }

    .feedback-box {
        width: 80%; 
        height: auto; 
        border-radius: 5px; 
        border: 1px solid black;
        margin: 25px auto;
    }

    #profile-picture {
        height: auto; 
        width: 20%; 
        float: left;
    }

    #content-box {
        width: 78%; 
        height: auto;
        float: right; 
    }

</style>

<body>

    <?php 

    $query = "SELECT
                *
            FROM
                user
            INNER JOIN
                feedback ON user.user_id = feedback.user_id";
            

    $result = mysqli_query($connection, $query); 
    while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <div id="feedback-page">
        <div class="feedback-box">
            <div id="profile-picture">
                <img src="../data/<?php echo 'image' . $row["profile_picture"]; ?>" width="200" height="200" title="<?php echo $row['profile_picture']; ?>">
            </div>
            <div id="content-box">
                <div id="user-id">
                    <?php echo $row['user_id']; ?>
                </div>
                <div id="username">
                    <?php echo $row['username']; ?>
                </div>
                <div id="feedback-content">
                    <?php echo $row['feedback_content']; ?>
                </div>
                <?php 
                    echo $fetchid = $row['feedback_id'];
                    $fetchquery = "SELECT * FROM feedback_attachment WHERE feedback_id = '$fetchid'"; 
                    $fetchresult = mysqli_query($connection, $fetchquery);
                    if (mysqli_num_rows($fetchresult) > 0) {
                        while ($fetchrow = mysqli_fetch_assoc($fetchresult)) {
                            echo "<div id='attachment'><img src='../data/image". $fetchrow['feedback_file_name']."' height ='200' width='auto'></img></div>"; 
                        }
                    }
                ?>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</body>
</html>

<?php
        }

?>