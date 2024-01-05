<?php

    // Include the database connection file
    include "dbconn.php"; 

    // Include the admin menu file
    include "admin-menu.php"; 

    // Include the admin session file
    include "admin-session.php"; 

    // Check if the 'id' parameter is set in the URL
    if(!isset($_GET['id'])){
        // Redirect to the admin-manageuser.php page if 'id' is not set
        header("Location: admin-manageuser.php");
        exit();
    } else {
        // Get the 'id' from the URL
        $id = $_GET['id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Profile</title>
    <link rel="stylesheet" href="../css/admin-manageprofile.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    
    <form action="" method="post" enctype="multipart/form-data">

    <?php
        // Query to retrieve user information based on the provided 'id'
        $query = "SELECT * FROM user WHERE user_id = '$id'";
        $result = mysqli_query($connection, $query);

        // Check if there is exactly one result
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
    ?>

        <table border = "1" id=table>
            <tr>
                <td colspan="2">
                    <img src="../data/image<?php echo $row['profile_picture']?>" id="profile"> <br>
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

    // Check if the form is submitted
    if(isset($_POST['submit'])){

        // Retrieve form data
        $username = $_POST['username']; 
        $firstname = $_POST['firstname']; 
        $lastname = $_POST['lastname']; 
        $institute = $_POST['institute'];

        // Check if an image is provided
        if(isset($_POST['image'])) {
            $image = $_POST['image'];
        }

        // Check if required fields are not empty
        if(!empty($username) && !empty($firstname) && !empty($lastname) ) {
            // Update user information in the database
            $query = "UPDATE `user` SET `username`='$username',`user_first_name`='$firstname',`user_last_name`='$lastname',`institute_name`='$institute' WHERE user_id = '$id'"; 
            if(mysqli_query($connection, $query)) {
                //update Successful
            } else {
                // Display an error message if the update is unsuccessful
                echo "<div id='error_msg'><br>ERROR: Record Update Unsuccessful, Please Try Again.<br><br></div>";
                exit(); 
            }
        } else {
            // Display an error message if required fields are empty
            echo "<div id='error_msg'><br>ERROR: Username, First Name, Last Name and Password Cannot be Null.<br><br></div>";
            exit(); 
        }

        // Check if an image is not provided
        if($_FILES["image"]["error"] == 4){
            // Display success message and redirect directly without uploading the image
            echo "<script> alert('Successfully Added');</script>";
            echo "<script>window.location.href='admin-manageuser.php';</script>";
            exit();
        }
        else{
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
                $query = "UPDATE `user` SET `profile_picture`='$newImageName' WHERE user_id = '$id'";
                mysqli_query($connection, $query);
                // Display success message and redirect
                echo "<script> alert('Successfully Added');</script>";
                echo "<script>window.location.href='admin-manageuser.php';</script>";
            }
        }
    }
?>