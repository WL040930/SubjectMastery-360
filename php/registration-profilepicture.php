<?php

    include "dbconn.php";
    session_start();
    echo $_SESSION['id'] = "6";
    $id = "6"; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture Upload</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="image">Choose a profile picture:</label>
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png"> <br>
        <input type="submit" value="Upload" name="upload">
    </form>
</body>

</html>

<?php
    require 'dbconn.php';
    if(isset($_POST["upload"])){
    if($_FILES["image"]["error"] == 4){
        echo
        "<script> alert('Image Does Not Exist'); </script>"
        ;
    }
    else{
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        if ( !in_array($imageExtension, $validImageExtension) ){
        echo
        "
        <script>
            alert('Invalid Image Extension');
        </script>
        ";
        }
        else if($fileSize > 1000000){
        echo
        "
        <script>
            alert('Image Size Is Too Large');
        </script>
        ";
        }
        else{
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;

        move_uploaded_file($tmpName, '../image/image' . $newImageName);
        $query = "UPDATE `user` SET `profile_picture`='$newImageName' WHERE user_id = '6'";
        mysqli_query($connection, $query);
        echo
        "
        <script>
            alert('Successfully Added');
        </script>
        ";
        }
    }
    }

?>