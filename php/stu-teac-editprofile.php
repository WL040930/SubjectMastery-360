<?php

    // include necessary file
    include "dbconn.php";
    include "feature-usermenu.php";

    // start the session if not started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // check if user is logged in
    if (!isset($_SESSION['id'])) {
        header("Location: feature-logout.php");
        exit();
    } else {
        $user_id = $_SESSION['id'];
    }

    $url_id = $_GET['id'];

    // check if user is trying to access another user's profile
    if ($user_id != $url_id) {
        header("Location: stu-teac-index.php");
        exit();
    }

    // get user details
    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/stu-teac-editprofile.css">
    <link rel="stylesheet" href="../css/animation.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <h1 align="center" style="margin: 20px;">Edit Profile - <?php echo $row['user_first_name'] . ' ' . $row['user_last_name']; ?></h1>
    
    <!-- display the information in table -->
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return profile_validation()">
        <table border="1">
            <tr>
                <td colspan="2">
                    <img src="../data/image<?php echo $row['profile_picture']; ?>" style="width: 150px; height: 150px; border-radius: 50%; "
                        id="previewImage"> <br>
                    <label for="image" class="custom-file-input">
                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" onchange="handleFileInput()">
                    </label>
                </td>
            </tr>
            <tr>
                <th>ID</th>
                <td> <?php echo $row['user_id']; ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td> <input type="text" name="username" id="username" value="<?php echo $row['username']; ?>"></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td> <input type="text" name="firstname" id="firstname" value="<?php echo $row['user_first_name']; ?>"></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td> <input type="text" name="lastname" id="lastname" value="<?php echo $row['user_last_name']; ?>"></td>
            </tr>
            <tr>
                <th>Password</th>
                <td> <input type="password" name="password" id="password" value="<?php echo $row['password']; ?>"></td>
            </tr>
            <tr>
                <th>Institute Name</th>
                <td> <input type="text" name="institute" value="<?php echo $row['institute_name']; ?>"></td>
            </tr>
        </table>

        <!-- validation message -->
        <div class="validation_message"></div>

        <!-- submit button -->
        <div class="divsubmit">
            <input type="submit" name="submit" value="submit" class="submitbtn">
        </div>

    </form>

    <!-- back button -->
    <div class="divback">
        <button onclick="goBack()" class="backbtn">Back</button>
    </div>
    
    <!-- include javascript -->
    <script src="../script/feature-back.js"></script>
    <script src="../script/editprofile.js"></script>


    <?php } ?>

</body>
</html>

<?php

    // update profile
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $institute = $_POST['institute'];

        if(isset($_POST['image'])) {
            $image = $_POST['image'];
        }

        // Update the user details in the database
        $query = "UPDATE `user` SET `username`='$username',`user_first_name`='$firstname',`user_last_name`='$lastname',
                `password`='$password',`institute_name`='$institute' WHERE user_id = '$user_id'";
        if (mysqli_query($connection, $query)) {
            // Update successful
        } else {
            echo "<script>alert('Profile update failed!')</script>";
        }

        // Check if an image is not provided
        if($_FILES["image"]["error"] == 4){
            // Display success message and redirect directly without uploading the image
            echo "<script> alert('Profile updated successfully!');</script>";
            echo "<script>window.location.href='stu-teac-index.php';</script>";
            exit();
        } else {
            // Process and upload the new profile picture
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (!in_array($imageExtension, $validImageExtension) ){
                 // Display an error message for invalid image extension
                echo "<script> alert('Invalid Image Extension');</script>";
            } else if($fileSize > 1000000){
                // Display an error message for large image size
                echo " <script> alert('Image Size Is Too Large'); </script>";
            } else{
                // Generate a unique image name and move the uploaded image to the server
                $newImageName = uniqid();
                $newImageName .= '.' . $imageExtension;

                move_uploaded_file($tmpName, '../data/image' . $newImageName);
                // Update the profile picture filename in the database
                $Insertquery = "UPDATE `user` SET `profile_picture`='$newImageName' WHERE user_id = '$user_id'";
                mysqli_query($connection, $Insertquery);
                // Display success message and redirect
                echo "<script> alert('Profile updated successfully!');</script>";
                echo "<script>window.location.href='stu-teac-index.php';</script>";
                exit();
            }
        }
    }
    
    mysqli_close($connection);
    
?>
