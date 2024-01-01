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
<body>
    <a href="stu-teac-editprofile.php?id=<?php echo $id; ?>"><button value="Edit Profile">Edit Profile</button></a>
</body>
</html>