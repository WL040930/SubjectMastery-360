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

    <button onclick="toggleNewChatModal()">New Chat</button>

    <div id="newChatContainer">
        <h2>New Chat</h2>
        <form id="newChatForm" method="post" action="#" enctype="multipart/form-data">
            <label for="chat-content">Chat Content:</label>
            <input type="text" id="chat-content" name="chat-content" required>

            <label for="fileInput">Select File:</label>
            <input type="file" id="fileInput" name="fileInput">

           <input type="submit" value="Create Chat" name=submit>
        </form>
    </div>

    <script src="../script/classroom-newchat.js"></script>

</body>
</html>

