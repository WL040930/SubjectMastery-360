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
    <!-- Include any necessary styles or scripts here -->
</head>
<body>

<!-- New Chat Button -->
<button onclick="openNewChatModal()">New Chat</button>

<!-- Modal for New Chat -->
<div id="newChatModal" style="display: none;">
    <h2>Create New Chat</h2>
    <form id="newChatForm" enctype="multipart/form-data">
        <label for="chatName">Chat Name:</label>
        <input type="text" id="chatName" name="chatName" required>

        <label for="fileInput">Select File:</label>
        <input type="file" id="fileInput" name="fileInput">

        <button type="submit">Create Chat</button>
    </form>
</div>

<script>
    function openNewChatModal() {
        // Display the modal when the button is clicked
        document.getElementById('newChatModal').style.display = 'block';
    }

    document.getElementById('newChatForm').addEventListener('submit', function (event) {
        // Handle form submission via AJAX or submit the form in the traditional way
        event.preventDefault();

        // Use JavaScript or AJAX to handle form submission and chat creation
        // You may need to adapt this part based on your backend logic

        // Example using FormData to send form data via AJAX
        var formData = new FormData(this);

        // Add additional data if needed
        formData.append('action', 'createChat');

        // Send AJAX request to your server-side script
        // Replace 'your_server_script.php' with the actual server-side script
        fetch('your_server_script.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server
            console.log(data);

            // Optionally, close the modal or perform other actions
            document.getElementById('newChatModal').style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>