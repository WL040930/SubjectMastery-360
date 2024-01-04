<?php

    include "dbconn.php"; 
    include "admin-menu.php"; 
    include "admin-session.php"; 

    if(!isset($_GET['id'])){
        header("Location: admin-manageuser.php");
        exit();
    } else {
        $id = $_GET['id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="../css/admin-manageprofile.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    
    <form action="" method="post" enctype="multipart/form-data">

    <?php
        $query = "SELECT * FROM user WHERE user_id = '$id'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
    ?>

        <table border = "1" id=table>
            <tr>
                <td colspan="2">
                    <img src="../data/image<?php echo $row['profile_picture']?>" style="max-width: 200px; max-height: 200px;"> <br>
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                </td>
                </td>
            </tr>
            <tr>
                <td id="tabla_column">ID</td>
                <td> <?php echo $row['user_id']; ?></td>
            </tr>
            <tr>
                <td id="tabla_column">Username</td>
                <td> <input type="text" name="username" value="<?php echo $row['username'];?>"></td>
            </tr>
            <tr>
                <td id="tabla_column">First Name</td>
                <td> <input type="text" name="firstname" value="<?php echo $row['user_first_name']; ?>"></td>
            </tr>
            <tr>
                <td id="tabla_column">Last Name</td>
                <td> <input type="text" name="lastname" value="<?php echo $row['user_last_name']; ?>"></td>
            </tr>
            <tr>
                <td id="tabla_column">Password</td>
                <td> <input type="password" name="password" value="<?php echo $row['password']; ?>" disabled></td>
            </tr>
            <tr>
                <td id="tabla_column">Institute Name</td>
                <td> <input type="text" name="institute" value="<?php echo $row['institute_name'];?>"></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="submit" value="Submit" id="submit_button">
    </form>
    <button onclick="goBack()" id="back_button">Back</button>
    <script src="../script/feature-back.js"></script>
    <?php } ?>

</body>
</html>

<?php

    if(isset($_POST['submit'])){
        $username = $_POST['username']; 
        $firstname = $_POST['firstname']; 
        $lastname = $_POST['lastname']; 
        $institute = $_POST['institute'];

        if(isset($_POST['image'])) {
            $image = $_POST['image'];
        }

        if(!empty($username) && !empty($firstname) && !empty($lastname) ) {
            $query = "UPDATE `user` SET `username`='$username',`user_first_name`='$firstname',`user_last_name`='$lastname',`institute_name`='$institute' WHERE user_id = '$id'"; 
            if(mysqli_query($connection, $query)) {
                
            } else {
                echo "Record update unsuccessful, please try again.";
                exit(); 
            }
        } else {
            echo "Username, First Name, Last Name and Password cannot be null.";
            exit(); 
        }

        if($_FILES["image"]["error"] == 4){
            echo "<script> alert('Successfully Added');</script>";
            echo "<script>window.location.href='admin-manageuser.php';</script>";
            exit();
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
                $query = "UPDATE `user` SET `profile_picture`='$newImageName' WHERE user_id = '$id'";
                mysqli_query($connection, $query);
                echo "<script> alert('Successfully Added');</script>";
                echo "<script>window.location.href='admin-manageuser.php';</script>";
            }
        }
    }
    

//CHECK ADMIN PROBLEM 
?>

