<?php

    include "dbconn.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Feedback</title>
    <link rel="stylesheet" href="../css/admin-viewfeedback.css">
    <!--font-->
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

    <div id="feedback-page">
        <div class="feedback-box">
            <div id="profile-picture">
                <img src="../data/<?php echo 'image' . $row["profile_picture"]; ?>" width="200" height="200" title="<?php echo $row['profile_picture']; ?>">
            </div>
            <div id="content-box">
                <div id="user-id">
                    <?php echo "<b>ID: </b>". $row['user_id']; ?>
                </div>
                <div id="username">
                    <?php echo "<b>USERNAME: </b>". $row['username']; ?>
                </div>
                <div id="feedback-content">
                    <?php echo "<b>FEEDBACK CONTENT: </b>". $row['feedback_content']; ?>
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
    </div>

    <?php } ?>
</body>
</html>