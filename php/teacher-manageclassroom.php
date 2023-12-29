<?php
    include "dbconn.php";
    include "teacher-session.php";
    
    // Check if classroom_id is provided in the URL
    if (isset($_GET['id'])) {
        $classroom_id = $_GET['id'];

        // Query to get classroom information based on the provided classroom_id
        $query = "SELECT * FROM classroom WHERE classroom_id = '$classroom_id'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $color = $row['classroom_color'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classroom</title>
</head>
<body>
    <h1>Manage Classroom - <?php echo $row['classroom_name']; ?></h1>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateCode()">
        <table>
            <tr>
                <th>Classroom Name: </th>
                <td><input type="text" name="name" value="<?php echo $row['classroom_name'];?>" required></td>
            </tr>
            <tr>
                <th>Classroom Description: </th>
                <td><input type="text" name="description" value="<?php echo $row['classroom_description'];?>"></td>
            </tr>
            <tr>
                <th>Classroom Code: </th>
                <td><input type="text" name="code" id="code" value="<?php echo $row['classroom_code'];?>" onblur="checkCodeAvailability()" required></td>
            </tr>
            <tr>
                <th>Classroom Picture: </th>
                <td>
                    <img src="../data/image<?php echo $row['classroom_picture']; ?>" alt="Classroom Picture" width="200px">
                    <br>
                    <input type="file" name="image" id="classroom_picture">
                </td>
            </tr>
            <tr>
                <th>Classroom Color: </th>
                <td>
                    <select name="color" id="color">
                        <option value=<?php $row['classroom_color']?>><?php echo $row['classroom_color'];?></option>
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
                        <option value="LightGray">Light Gray</option>
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
                </td>
            </tr>
        </table>
        <div id="validation-message"></div>
        <input type="submit" value="Update" name="submit">
    </form>
    <a href="teacher-addmember.php?id=<?php echo $row['classroom_id'];?>">Click Here to Add Member into Classroom</a>
</body>
</html>

<script src="../script/teacher-codevalidation.js"></script>

<?php
if (isset($_POST['submit'])) {
    // Form data
    $classroom_name = $_POST['name'];
    $classroom_description = $_POST['description'];
    $classroom_code = $_POST['code'];
    $classroom_color = $_POST['color'];

    // Initialize image variables
    $newImageName = null;

    // Image processing
    if ($_FILES["image"]["error"] == 0) {
        $fileName = $_FILES["image"]["name"];
        $tmpName = $_FILES["image"]["tmp_name"];

        // Valid image extensions
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('Invalid Image Extension');</script>";
        } else {
            // Move uploaded image to the destination folder
            $newImageName = uniqid() . '.' . $imageExtension;
            move_uploaded_file($tmpName, '../data/image/' . $newImageName);
        }
    }

    // Update classroom information in the 'classroom' table
    $query = "UPDATE `classroom` SET `classroom_name`='$classroom_name',
              `classroom_description`='$classroom_description', `classroom_code`='$classroom_code',
              `classroom_color`='$classroom_color'";

    // Include image information if it exists
    if ($newImageName) {
        $query .= ", `classroom_picture`='$newImageName'";
    }

    $query .= " WHERE `classroom_id`='$classroom_id'";

    mysqli_query($connection, $query);

    echo "<script> alert('Classroom Information Successfully Updated');</script>";
    echo "<script> window.location.href = 'stu-teac-viewclassroom.php'; </script>";
}
?>

<?php
        } else {
            echo "Classroom not found.";
        }
    } else {
        $user_id = $_SESSION['id'];
        $classrooms_query = "SELECT cm.classroom_id, c.classroom_name FROM classroom_member cm 
                            JOIN classroom c ON cm.classroom_id = c.classroom_id 
                            WHERE cm.user_id = '$user_id'";
        $classrooms_result = mysqli_query($connection, $classrooms_query);

        if ($classrooms_result && mysqli_num_rows($classrooms_result) > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Classroom</title>
</head>
<body>
    <h1>Choose a Classroom to Manage</h1>
    <ul>
        <?php
        while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
            echo '<li><a href="teacher-manageclassroom.php?id=' . $classroom_row['classroom_id'] . '">' . $classroom_row['classroom_name'] . '</a></li>';
        }
        ?>
    </ul>
</body>
</html>

<?php

        } else {
            echo "You are not involved in any classrooms.";
        }
    }

?>
