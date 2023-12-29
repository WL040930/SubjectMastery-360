<?php

    include "dbconn.php"; 
    include "stu-teac-session.php"; 

    if(!isset($_GET['id'])) {
        header ("Location: stu-teac-index.php");
        exit();
    }

    $id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $sql = "SELECT * FROM `classroom_member` WHERE `classroom_id` = '$id' AND `user_id` = '$user_id'"; 
    $sqlresult = mysqli_query($connection, $sql);
    if(mysqli_num_rows($sqlresult) == 0) {
        echo "<script> alert('You are not involved in this classroom.') </script>";
        echo "<script> window.location.href='stu-teac-index.php' </script>";  
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        button {
            padding: 10px;
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #container {
            position: relative;
        }

        #newChatModal {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
        }

        input {
            padding: 8px;
            margin-bottom: 15px;
        }

        button[type="submit"] {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>

<!-- New Chat Button -->
<button onclick="openNewChatModal()">New Chat</button>

<!-- Container for positioning -->
<div id="container">

    <!-- Modal for New Chat -->
    <div id="newChatModal">
        <h2>Create New Chat</h2>
        <form id="newChatForm" enctype="multipart/form-data">
            <label for="chatName">Chat Name:</label>
            <input type="text" id="chatName" name="chatName" required>

            <label for="fileInput">Select File:</label>
            <input type="file" id="fileInput" name="fileInput">

            <button type="submit">Create Chat</button>
        </form>
    </div>

</div>

<script>
    function openNewChatModal() {
        // Display the modal with a fade-in animation
        document.getElementById('newChatModal').style.display = 'block';
    }

    // Close the modal when the form is submitted
    document.getElementById('newChatForm').addEventListener('submit', function (event) {
        event.preventDefault();
        document.getElementById('newChatModal').style.display = 'none';
    });
</script>

</body>
</html>

