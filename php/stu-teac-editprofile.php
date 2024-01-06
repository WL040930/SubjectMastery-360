<?php
    include "dbconn.php";
    include "feature-usermenu.php";

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: stu-teac-index.php");
        exit();
    } else {
        $user_id = $_SESSION['id'];
    }

    $url_id = $_GET['id'];
    if ($user_id != $url_id) {
        header("Location: stu-teac-index.php");
        exit();
    }

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
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Edit Profile - <?php echo $row['user_first_name'] . ' ' . $row['user_last_name']; ?></h1>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return profile_validation()">
        <table border="1">
            <tr>
                <td colspan="2">
                    <img src="../data/image<?php echo $row['profile_picture'] ?>" style="width: 150px; height: 150px;"> <br>
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                </td>
            </tr>
            <tr>
                <td id="title">ID</td>
                <td> <?php echo $row['user_id']; ?></td>
            </tr>
            <tr>
                <td id="title">Username</td>
                <td> <input id="textbox" type="text" name="username" id="username" value="<?php echo $row['username']; ?>"></td>
            </tr>
            <tr>
                <td id="title">First Name</td>
                <td> <input id="textbox" type="text" name="firstname" id="firstname" value="<?php echo $row['user_first_name']; ?>"></td>
            </tr>
            <tr>
                <td id="title">Last Name</td>
                <td> <input id="textbox" type="text" name="lastname" id="lastname" value="<?php echo $row['user_last_name']; ?>"></td>
            </tr>
            <tr>
                <td id="title">Password</td>
                <td> <input id="textbox" type="password" name="password" id="password" value="<?php echo $row['password']; ?>"></td>
            </tr>
            <tr>
                <td id="title">Institute Name</td>
                <td> <input id="textbox" type="text" name="institute" value="<?php echo $row['institute_name']; ?>"></td>
            </tr>
        </table>
        <input type="submit" name="submit" value="submit" id="submit_button">
    </form>
    <button onclick="goBack()" id="back_button">Back</button>
    <script src="../script/feature-back.js"></script>
<?php } ?>
</body>

</html>
<?php
// End of PHP code
?>
