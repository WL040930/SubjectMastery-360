<?php

    // include database connection file
    include "dbconn.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Feedback</title>
    <link rel="stylesheet" href="../css/admin-viewfeedback.css">
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/mainpage.css">
    <link rel="stylesheet" href="../css/animation.css">
    <!--font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body id="all">
    <div id="logo_menu">
        <a href="mainpage.php"><img src="../image/pic_re.png" id="weblogo" alt="logo"></a>
        <div id="webname">
            <h1>SubjectMastery360</h1>
        </div>
        <div id="menubar">
            <table class="menubar_content">
                <!--connect to HOME-->
                <th><a href="mainpage.php" class="menu1">HOME</a></th>
                <!--connect to ABOUT US-->
                <th><a href="aboutus.php" class="menu2">ABOUT US</a></th>
                <!--connect to CUSTOMER FEEDBACK-->
                <th><a href="feedback.php" class="menu3">CUSTOMER FEEDBACK</a></th>   
            </table>
        </div>
    </div>
    <br>

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
    <?php
    
        } 
    ?>

</body>
</html>