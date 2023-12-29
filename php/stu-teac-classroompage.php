<?php
    include "dbconn.php";
    include "stu-teac-session.php";

    if (!isset($_GET['id'])) {
        header("Location: stu-teac-index.php");
        exit();
    }

    $id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $sql = "SELECT * FROM `classroom_member` WHERE `classroom_id` = '$id' AND `user_id` = '$user_id'";
    $sqlresult = mysqli_query($connection, $sql);
    $sqlrow = mysqli_fetch_assoc($sqlresult);

    if (mysqli_num_rows($sqlresult) == 0) {
        echo "<script> alert('You are not involved in this classroom.') </script>";
        echo "<script> window.location.href='stu-teac-index.php' </script>";
    } else {
        $classroom_member_id = $sqlrow['classroom_member_id'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Chat</title>
    <link rel="stylesheet" href="../css/classroom-page.css">
</head>


<body>

    <div id="chat-container">
        <div id="basic-information">
            profile picture
        </div>
        <div id="text-box">
            
        </div>
        <div id="picture">

        </div>
        <div id="comment">

        </div>
        <div id="reply">

        </div>
    </div>

















    <button onclick="toggleNewChatModal()">New Chat</button>

    <div id="newChatContainer">
        <h2>New Chat</h2>
        <form id="newChatForm" method="post" action="#" enctype="multipart/form-data">
            <label for="chat-content">Chat Content:</label>
            <input type="text" id="chat-content" name="chat-content" required>

            <label for="fileInput">Select File:</label>
            <input type="file" id="fileInput" name="fileInput">

            <input type="submit" value="Create Chat" name="submit">
        </form>

    </div>

<script src="../script/classroom-newchat.js"></script>

</body>
</html>

<?php

    if(isset($_POST['submit'])) {
        $content = $_POST['chat-content'];

        // Insert chat content into the database
        $query = "INSERT INTO `chatroom_messages`(`classroom_member_id`, `chatroom_messages_content`, `chatroom_messages_timestamp`) 
                VALUES ('$classroom_member_id','$content', CURRENT_TIMESTAMP)"; 
        $result = mysqli_query($connection, $query);


        if($result) {
            $chatid = mysqli_insert_id($connection);
            if(isset($_FILES['fileInput'])) {
                $file = $_FILES['fileInput'];

                if($file['error'] == 0) {
                    $fileName = $file['name'];
                    $tmpName = $file['tmp_name'];

                    $newFileName = uniqid() . '_' . $fileName;

                    move_uploaded_file($tmpName, '../data/file' . $newFileName);

                    $updateQuery = "INSERT INTO `chatroom_attachment`(`chatroom_messages_id`, `chatroom_attachment_name`)
                                     VALUES ('$chatid','$newFileName')";
                    mysqli_query($connection, $updateQuery);

                    echo "<script> alert('Successfully Added');</script>";
                } else {
                    echo "<script> alert('Error uploading file');</script>";
                }
            } else {
                echo "<script> alert('Successfully Added');</script>";
                header('Location: stu-teac-classroompage.php');
            }
        } else {
            echo "<script> alert('Error creating chat') </script>";
        }
    }
?>


