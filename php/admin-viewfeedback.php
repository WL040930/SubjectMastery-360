<?php

    // Include necessary files
    include "dbconn.php"; 
    include "admin-menu.php";
    include "admin-session.php";
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Feedback</title>
    <link rel="stylesheet" href="../css/admin-viewfeedback.css">
    <link rel="stylesheet" href="../css/animation.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body id="all">

    <?php 
    
        // SQL query to fetch user details and feedback
        $query = "SELECT
                    *
                FROM
                    user
                INNER JOIN
                    feedback ON user.user_id = feedback.user_id";
                
        // Loop through the result set
        $result = mysqli_query($connection, $query); 
        while ($row = mysqli_fetch_assoc($result)) {

    ?>

    <div class="feedback-box">
        <div class="personal-info">
            <table class="table-feedback">
                <tr>
                    <td rowspan="2" class="feedback-column">
                        <div id="profile-picture" style="border: 0px">
                            <img class="profile-picture" src="../data/<?php echo 'image' . $row["profile_picture"]; ?>" width="50" height="50" title="<?php echo $row['profile_picture']; ?>">
                        </div>
                    </td>
                    <td class="feedback-column">
                        <b>User ID: </b>
                    </td>
                    <td class="feedback-column">
                        <div id="user-id">
                            <?php echo $row['user_id']; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="feedback-column">
                        <b>Username: </b>
                    </td>
                    <td class="feedback-column">
                        <div id="username">
                            <?php echo $row['username']; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="feedback-content">
            <div id="feedback-content">
                <?php echo "<b>FEEDBACK CONTENT: <br></b>". $row['feedback_content']; ?>
            </div>
            <?php 
                $fetchid = $row['feedback_id'];
                $fetchquery = "SELECT * FROM feedback_attachment WHERE feedback_id = '$fetchid'"; 
                $fetchresult = mysqli_query($connection, $fetchquery);
                if (mysqli_num_rows($fetchresult) > 0) {
                    while ($fetchrow = mysqli_fetch_assoc($fetchresult)) {
                        echo "<div id='attachment'><img src='../data/image". $fetchrow['feedback_file_name']."' height ='200' width='auto'></img></div>"; 
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>

<?php
        }

    // Close database connection
    mysqli_close($connection);

?>