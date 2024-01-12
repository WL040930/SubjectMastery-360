<?php 

    // Include database connection file
    include "dbconn.php";

    // Start session if the session is not started
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    // Check if the user is logged in
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
    } else {
        header("Location: feature-logout.php");
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
<form action="" method="post" enctype="multipart/form-data">

    <?php
        // Query to retrieve user information based on the provided 'id'
        $query = "SELECT * FROM user WHERE user_id = '$id'";
        $result = mysqli_query($connection, $query);

        // Check if there is exactly one result
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
    ?>

        <!-- Display the information in table -->
        <table border = "1" id=table>
            <tr>
                <td colspan="2">
                    <img src="../data/image<?php echo $row['profile_picture']; ?>" style="width: 150px; height: 150px;"
                        id="previewImage"> <br>
                    <label for="image" class="custom-file-input">
                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" onchange="handleFileInput()">
                    </label>
                </td>
            </tr>
            <tr>
                <td id="tabla_column">ID</td>
                <td> <?php echo $row['user_id']; ?></td>
            </tr>
            <tr>
                <td id="tabla_column">Username</td>
                <td> <input id="textbox" type="text" name="username" value="<?php echo $row['username'];?>" disabled></td>
            </tr>
            <tr>
                <td id="tabla_column">First Name</td>
                <td> <input id="textbox" type="text" name="firstname" value="<?php echo $row['user_first_name']; ?>" disabled></td>
            </tr>
            <tr>
                <td id="tabla_column">Last Name</td>
                <td> <input id="textbox" type="text" name="lastname" value="<?php echo $row['user_last_name']; ?>" disabled></td>
            </tr>
            <tr>
                <td id="tabla_column">Password</td>
                <td> <input id="textbox" type="password" name="password" value="<?php echo $row['password']; ?>" disabled></td>
            </tr>
            <tr>
                <td id="tabla_column">Institute Name</td>
                <td> <input id="textbox" type="text" name="institute" value="<?php echo $row['institute_name'];?>" disabled></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="submit" value="Submit" id="submit_button">
    </form>

    <?php

        } else {
            // Display an error message if there is no result
            echo "<script> alert('No Result Found');</script>";
        }

    ?>

</body>
</html>

    <script>

        // Function to display the selected image in the preview image element
        function handleFileInput() {
            var fileInput = document.getElementById('image');
            var previewImage = document.getElementById('previewImage');
            var selectedFile = fileInput.files[0];

            if (selectedFile) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(selectedFile);
            }
        }

    </script>

<?php

    // Check if the form is submitted
    if(isset($_POST['submit'])){

        if(isset($_POST['image'])) {
            $image = $_POST['image'];
        }

        // Check if an image is not provided
        if($_FILES["image"]["error"] == 4){

            // Display success message and redirect directly without uploading the image
            echo "<script> alert('Successfully Added');</script>";
            echo "<script>window.location.href='feature-logout.php';</script>";
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
                echo "<script>window.location.href='feature-logout.php';</script>";
            }
        }
    }
?>

<?php

    // Close database connection
    mysqli_close($connection);

?>