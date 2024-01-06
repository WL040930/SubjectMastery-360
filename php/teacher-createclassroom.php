<?php
    include "dbconn.php";
    include "feature-usermenu.php";

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Classroom</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/teacher-createclassroom.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body id="classroom_body">
    <h1>Create Classroom</h1>
    <div id="container">
        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateCode()">
            <div class="inp-box">
                <label for="name">Classroom Name: </label>
                <input type="text" name="name" required>
            </div><br>

            <div class="inp-box">
                <label for="description">Classroom Description: </label>
                <input type="text" name="description">
            </div><br>

            <div class="inp-box">
                <label for="code">Classroom Code: </label>
                <input type="text" name="code" required id="code" onblur="checkCodeAvailability()"> 
            </div><br>

            <div class="inp-box">
                <label for="image">Classroom Picture: </label>
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
            </div><br>

            <div class="inp-box">
                <label for="color">Classroom's Background Color</label>
                <select name="color" id="color">
                    <option value="AliceBlue">Alice Blue</option>
                    <option value="AntiqueWhite">Antique White</option>
                    <option value="Aqua">Aqua</option>
                    <option value="Aquamarine">Aquamarine</option>
                    <option value="Azure">Azure</option>
                    <option value="Beige">Beige</option>
                    <option value="Bisque">Bisque</option>
                    <option value="BlanchedAlmond">Blanched Almond</option>
                    <option value="BlueViolet">Blue Violet</option>
                    <option value="BurlyWood">Burly Wood</option>
                    <option value="Chartreuse">Chartreuse</option>
                    <option value="Chocolate">Chocolate</option>
                    <option value="Coral">Coral</option>
                    <option value="CornflowerBlue">Cornflower Blue</option>
                    <option value="Cornsilk">Cornsilk</option>
                    <option value="Crimson">Crimson</option>
                    <option value="Cyan">Cyan</option>
                    <option value="FireBrick">Fire Brick</option>
                    <option value="FloralWhite">Floral White</option>
                    <option value="ForestGreen">Forest Green</option>
                    <option value="Gainsboro">Gainsboro</option>
                    <option value="GhostWhite">Ghost White</option>
                    <option value="Gold">Gold</option>
                    <option value="GoldenRod">Golden Rod</option>
                    <option value="Green">Green</option>
                    <option value="GreenYellow">Green Yellow</option>
                    <option value="HoneyDew">Honey Dew</option>
                    <option value="HotPink">Hot Pink</option>
                    <option value="Ivory">Ivory</option>
                    <option value="Khaki">Khaki</option>
                    <option value="Lavender">Lavender</option>
                    <option value="LavenderBlush">Lavender Blush</option>
                    <option value="LawnGreen">Lawn Green</option>
                    <option value="LemonChiffon">Lemon Chiffon</option>
                    <option value="LightBlue">Light Blue</option>
                    <option value="LightCoral">Light Coral</option>
                    <option value="LightCyan">Light Cyan</option>
                    <option value="LightGoldenRodYellow">Light Golden Rod Yellow</option>
                    <option value="LightGray" selected>Light Gray</option>
                    <option value="LightGreen">Light Green</option>
                    <option value="LightPink">Light Pink</option>
                    <option value="LightSalmon">Light Salmon</option>
                    <option value="LightSeaGreen">Light Sea Green</option>
                    <option value="LightSkyBlue">Light Sky Blue</option>
                    <option value="LightSlateGray">Light Slate Gray</option>
                    <option value="LightSteelBlue">Light Steel Blue</option>
                    <option value="LightYellow">Light Yellow</option>
                    <option value="Lime">Lime</option>
                    <option value="LimeGreen">Lime Green</option>
                    <option value="Linen">Linen</option>
                    <option value="Magenta">Magenta</option>
                    <option value="MediumAquaMarine">Medium Aqua Marine</option>
                    <option value="MediumOrchid">Medium Orchid</option>
                    <option value="MediumPurple">Medium Purple</option>
                    <option value="MediumSeaGreen">Medium Sea Green</option>
                    <option value="MediumSlateBlue">Medium Slate Blue</option>
                    <option value="MediumSpringGreen">Medium Spring Green</option>
                    <option value="MediumTurquoise">Medium Turquoise</option>
                    <option value="MediumVioletRed">Medium Violet Red</option>
                    <option value="MintCream">Mint Cream</option>
                    <option value="MistyRose">Misty Rose</option>
                    <option value="Moccasin">Moccasin</option>
                    <option value="NavajoWhite">Navajo White</option>
                    <option value="OldLace">Old Lace</option>
                    <option value="Olive">Olive</option>
                    <option value="OliveDrab">Olive Drab</option>
                    <option value="Orange">Orange</option>
                    <option value="OrangeRed">Orange Red</option>
                    <option value="Orchid">Orchid</option>
                    <option value="PaleGoldenRod">Pale Golden Rod</option>
                    <option value="PaleGreen">Pale Green</option>
                    <option value="PaleTurquoise">Pale Turquoise</option>
                    <option value="PaleVioletRed">Pale Violet Red</option>
                    <option value="PapayaWhip">Papaya Whip</option>
                    <option value="PeachPuff">Peach Puff</option>
                    <option value="Peru">Peru</option>
                    <option value="Pink">Pink</option>
                    <option value="Plum">Plum</option>
                    <option value="PowderBlue">Powder Blue</option>
                    <option value="Red">Red</option>
                    <option value="RosyBrown">Rosy Brown</option>
                    <option value="RoyalBlue">Royal Blue</option>
                    <option value="Salmon">Salmon</option>
                    <option value="SandyBrown">Sandy Brown</option>
                    <option value="SeaGreen">Sea Green</option>
                    <option value="SeaShell">Sea Shell</option>
                    <option value="Sienna">Sienna</option>
                    <option value="Silver">Silver</option>
                    <option value="SkyBlue">Sky Blue</option>
                    <option value="SlateBlue">Slate Blue</option>
                    <option value="SlateGray">Slate Gray</option>
                    <option value="Snow">Snow</option>
                    <option value="SpringGreen">Spring Green</option>
                    <option value="SteelBlue">Steel Blue</option>
                    <option value="Tan">Tan</option>
                    <option value="Teal">Teal</option>
                    <option value="Thistle">Thistle</option>
                    <option value="Tomato">Tomato</option>
                    <option value="Turquoise">Turquoise</option>
                    <option value="Violet">Violet</option>
                    <option value="Wheat">Wheat</option>
                    <option value="White">White</option>
                    <option value="WhiteSmoke">White Smoke</option>
                    <option value="Yellow">Yellow</option>
                    <option value="YellowGreen">Yellow Green</option>
                </select>
            </div><br>
            
            <div id="validation-message"></div>
            <div class="submitbtn">
            <input type="submit" value="Create" name="submit">
            </div>
        </form>
    </div>
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
                exit();
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
            $color = $_POST['color'];
            
            // Insert classroom into the database
            $insertQuery = "INSERT INTO `classroom` (`classroom_name`, `classroom_description`, `classroom_code`, `classroom_picture`, `classroom_color`) 
                            VALUES ('$name', '$description', '$code', " . ($newImageName ? "'$newImageName'" : "NULL") . ", '$color')";

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