<?php

    include "dbconn.php";
    session_start(); 

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Classroom</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateCode()">
        <label for="name">Classroom Name: </label>
        <input type="text" name="name" required>
        <br>
        <label for="description">Classroom Description: </label>
        <input type="text" name="description">
        <br>
        <label for="code">Classroom Code: </label>
        <input type="text" name="code" required id="code" onblur="checkCodeAvailability()"> 
        <br>
        <label for="image">Classroom Picture: </label>
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
        <br>
        <label for="color">Classroom's Background Color</label>
        <select name="color" id="color">
            <option value="Red">Blue</option>
            <option value="">Blue</option>
        </select>
        <br>
        <div id="validation-message"></div>
        <input type="submit" value="Create" name="submit">
    </form>
    <script src="../script/teacher-codevalidation.js"></script>
</body>
</html>

<?php

    if(isset($_POST["submit"])){
        if($_FILES["image"]["error"] == 4){
            $newImageName = null;
        } else {
            $fileName = $_FILES["image"]["name"];
            $tmpName = $_FILES["image"]["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (!in_array($imageExtension, $validImageExtension) ){
                echo "<script> alert('Invalid Image Extension');</script>";
                exit(); // Exit the script if the image extension is invalid
            }

            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, '../data/image' . $newImageName);
        }

        $code = $_POST['code'];
        $query = "SELECT classroom_code FROM `classroom` WHERE classroom_code = '$code'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Code already exists. Please choose a different code.');</script>";
        } else {
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            // Insert classroom into the database
            $insertQuery = "INSERT INTO `classroom` (`classroom_name`, `classroom_description`, `classroom_code`, `classroom_picture`) 
                            VALUES ('$name', '$description', '$code', " . ($newImageName ? "'$newImageName'" : "NULL") . ")";

            if (mysqli_query($connection, $insertQuery)) {
                $fetchQuery = "SELECT * FROM `classroom` WHERE classroom_code = '$code'";
                $fetchResult = mysqli_query($connection, $fetchQuery);
                $fetchRow = mysqli_fetch_assoc($fetchResult);
                $classroomId = $fetchRow['classroom_id'];
                $ID = $_SESSION['id'];
                $insertsql = "INSERT INTO `classroom_member`(`user_id`, `classroom_id`) VALUES ('$ID','$classroomId')"; 
                if (mysqli_query($connection, $insertsql)) {
                    echo "<script>alert('Classroom created successfully.');</script>";
                } else {
                    echo "<script>alert('Error creating classroom.');</script>";
                }
            } else {
                echo "<script>alert('Error creating classroom.');</script>";
            }
        }
    }
?>