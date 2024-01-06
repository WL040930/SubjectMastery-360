<?php

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    #edit_button{
        padding: 10px;
        font-size: 18px;
        background-color: #7E6E57;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin: 20px auto;
    }

    #edit_button:hover{
        background-color: #BCA37F;
    }
</style>
<body>
    <a href="stu-teac-editprofile.php?id=<?php echo $id; ?>"><button id="edit_button" value="Edit Profile">Edit Profile</button></a>
</body>
</html>