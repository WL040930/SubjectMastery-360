<?php 

    // method must be post 
    // name of submit must be submit
    // name for input of profile picture must be image 



    require 'dbconn.php';
    if(isset($_POST["submit"])){
        if($_FILES["image"]["error"] == 4){
            echo "<script> alert('Image Does Not Exist'); </script>";
        }
        else{
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (!in_array($imageExtension, $validImageExtension) ){
                echo "<script> alert('Invalid Image Extension');</script>";
            } else if($fileSize > 1000000){
                echo " <script> alert('Image Size Is Too Large'); </script>";
            } else{
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;

                move_uploaded_file($tmpName, '../data/image' . $newImageName);
                $query = "UPDATE `user` SET `profile_picture`='$newImageName' WHERE user_id = '7'";
                mysqli_query($connection, $query);
                echo "<script> alert('Successfully Added');</script>";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="image">Choose a profile picture:</label>
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png"> <br>
            <input type="submit" value="Upload" name="submit">
        </form>
</body>
</html>