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

    $classroom_name_fetch = "SELECT c.* 
                             FROM classroom c 
                             WHERE `classroom_id` = '$id'";
    $classroom_name_result = mysqli_query($connection, $classroom_name_fetch); 
    $classroom_member_row = mysqli_fetch_assoc($classroom_name_result); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom - <?php echo $classroom_member_row['classroom_name']; ?></title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/classroom-page.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body id="all">

    <?php
        $chatquery = "SELECT cms.*, cm.*, u.* 
                      FROM chatroom_messages cms 
                      JOIN classroom_member cm ON cms.classroom_member_id = cm.classroom_member_id
                      JOIN user u ON cm.user_id = u.user_id
                      WHERE cm.classroom_id = '$id'";
        $chatresult = mysqli_query($connection, $chatquery); 
        while ($chatrow = mysqli_fetch_assoc($chatresult)) {
    ?>
    <div id="chatbox">
        <a href="stu-teac-chat.php?id=<?php echo $chatrow['chatroom_messages_id']; ?>">
            <div id=chat_title>
                <?php echo $chatrow['chatroom_title'];  ?>
            </div>
            <div id="username">
                <?php echo $chatrow['username']; ?>
            </div>
            <div id="timestap">
                <?php echo $chatrow['chatroom_messages_timestamp'];  ?>
            </div>
        </a>
    </div>
    <?php
        }
    ?>
    <button onclick="toggleNewChatModal()">New Chat</button>

    <div id="newChatContainer">
        <h2>New Chat</h2>
        <form id="newChatForm" method="post" action="#" enctype="multipart/form-data">
            <label for="chatroom-title">Chat Title:</label>
            <input type="text" id="chatroom-title" name="chatroom-title" required>

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
        $title = $_POST['chatroom-title'];

        // Insert chat content into the database
        $query = "INSERT INTO `chatroom_messages`(`classroom_member_id`, `chatroom_messages_content`, `chatroom_title`, `chatroom_messages_timestamp`) 
                VALUES ('$classroom_member_id', '$content', '$title', CURRENT_TIMESTAMP)";
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
                    echo "<script> alert('Successfully Added');</script>";
                }
            } else {
                echo "<script> alert('Successfully Added');</script>";
                header('Location: stu-teac-classroompage.php');
            }
        } else {
            echo "<script> alert('Error creating chat') </script>";
        }
        header('Location: stu-teac-classroompage.php?id=' . $_GET['id']);
        exit(); 
    }
?>


