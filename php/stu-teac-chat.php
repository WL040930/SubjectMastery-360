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
</head>

<style>
    .attachment-box {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px;
    display: inline-block;
}

.download-link {
    text-decoration: none;
    background-color: #4CAF50;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
}

.download-link:hover {
    background-color: #45a049;
}

</style>

<body>
    <div>
        <h1><?php echo $classroom_id_row['chatroom_title']; ?></h1>
        <h3>Created By: <?php echo $classroom_id_row['username']; ?></h3>
        <h6>Time Created: <?php echo $classroom_id_row['chatroom_messages_timestamp']; ?></h6>
        <b>Content: </b> <br>
        <?php echo $classroom_id_row['chatroom_messages_content']; ?>
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
            <?php echo $replyRow['username']; ?> <br>
            <?php echo $replyRow['reply_timestamp']; ?> <br>
            <?php echo $replyRow['reply_text']; ?>
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
        <form action="" method="post">
            Leave Reply: 
            <input type="text" name="reply" placeholder="Leave Your Reply Here." required>
            <input type="submit" value="Post" name="submit">
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