<?php

    include "dbconn.php";
    include "stu-teac-session.php";

    if(isset($_GET['id'])) {
        $messages_id = $_GET['id'];
        $classroom_id_query = " SELECT cms.*, cm.*, u.*
                                FROM chatroom_messages cms
                                JOIN classroom_member cm ON cms.classroom_member_id = cm.classroom_member_id
                                JOIN user u ON cm.user_id = u.user_id 
                                WHERE cms.chatroom_messages_id ='$messages_id'"; 
        $classroom_id_result = mysqli_query($connection, $classroom_id_query);
        if(mysqli_num_rows($classroom_id_result) == 1) {
            $classroom_id_row = mysqli_fetch_assoc($classroom_id_result); 
            $classroom_id = $classroom_id_row['classroom_id'];
        } else {
            echo "<script> alert('There is an error.'); </script>";
            echo "<script> window.location.href='stu-teac-index.php'; </script>";
            exit();
        }
    } else {
        header("Location: stu-teac-index.php"); 
        exit(); 
    }

    $user_id = $_SESSION['id'];
    
    $checkQuery = "SELECT * FROM classroom_member WHERE user_id = '$user_id' AND classroom_id = '$classroom_id'";

    $checkResult = mysqli_query($connection, $checkQuery);

    if(mysqli_num_rows($checkResult) != 1) {
        echo "<script> alert('You are not a member of this classroom.'); </script>";
        echo "<script> window.location.href='stu-teac-index.php'; </script>";
        exit();
    } else {
        $checkRow = mysqli_fetch_assoc($checkResult);
        $classroom_member_id = $checkRow['classroom_member_id'];
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/stu-teac-chat.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div id="all">
        <h1><?php echo $classroom_id_row['chatroom_title']; ?></h1>
        <h4>Created By: <?php echo $classroom_id_row['username']; ?></h5>
        <h4>Time Created: <?php echo $classroom_id_row['chatroom_messages_timestamp']; ?></h5>
        <div id="chat_content">
            <br><b>Content: </b> <br>
            <?php echo $classroom_id_row['chatroom_messages_content']; ?>
        </div>
        <?php
            $query = "SELECT ca.*
                        FROM chatroom_attachment ca
                        WHERE ca.chatroom_messages_id = '$messages_id'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $numRows = mysqli_num_rows($result);

                if ($numRows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="attachment-box">
                        <a href="download.php?filename=<?php echo urlencode($row['chatroom_attachment_name']); ?>" class="download-link">Download Attachment</a>
                    </div>
            <?php
                    }
                } 
            } else {
                echo "Query failed: " . mysqli_error($connection);
            }
        ?>
    </div>
    <b id="comment_title">Comment: </b>
    <?php 
        $replyQuery = "SELECT r.*, cm.*, u.*
                        FROM reply r
                        JOIN classroom_member cm ON r.classroom_member_id = cm.classroom_member_id
                        JOIN user u ON cm.user_id = u.user_id
                        WHERE r.chatroom_messages_id = '$messages_id'";
        $replyresult = mysqli_query($connection, $replyQuery);
        if($replyQuery){
            if(mysqli_num_rows($replyresult) > 0){

                while($replyRow = mysqli_fetch_assoc($replyresult)) {
                    
    ?>

        <div id="reply-box">
            <div id="username"><b>Username: </b><?php echo $replyRow['username']; ?> <br></div>
            <div id="timestap"><b>Timestap: </b><?php echo $replyRow['reply_timestamp']; ?> <br></div>
            <div id="replytext"><b>Content: </b><?php echo $replyRow['reply_text']; ?></div>
        </div>
    <?php
                }
            } else {
                echo "There is no reply messages in this chatroom";
            }
        } else {
            echo "Query Failed: ". mysqli_error($connection); 
        }
    ?>
    <div id="leave-reply">
        <form action="" method="post" id="title">
            Leave Reply: 
            <input id="content_box" type="text" name="reply" placeholder="Leave Your Reply Here." style="width: 500px;" required>
            <input type="submit" value="Post" name="submit" id="submit_button">
        </form>
    </div>
</body>
</html>

<?php

    if(isset($_POST['submit'])) {
        $reply = $_POST['reply'];
        $insertQuery = "INSERT INTO `reply`(`classroom_member_id`, `chatroom_messages_id`, `reply_text`, `reply_timestamp`) 
                        VALUES ('$classroom_member_id','$messages_id','$reply', CURRENT_TIMESTAMP)";
        $insertResult = mysqli_query($connection, $insertQuery); 
        if($insertResult){
            $redirectUrl = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
            header("Location: $redirectUrl");
            exit();
        } else {
            echo "<script> alert(Error posting reply. Please try again later.);</script>";
            exit(); 
        }
    }

?>