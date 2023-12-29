<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="text">
        <input type="submit" value="submit" name="submit">
    </form>
</body>
</html>

<?php

    include "dbconn.php";
    
    if(isset($_POST['submit'])){
        $content = $_POST['text']; 
        echo $content; 

        $query = "INSERT INTO `chatroom_messages`(`classroom_member_id`, `chatroom_messages_content`, `chatroom_messages_timestamp`) 
        VALUES ('2','$content', CURRENT_TIMESTAMP)";

        if(mysqli_query($connection, $query)) {
            echo "yes";
        } else {
            echo "no";
        }

    }

?>