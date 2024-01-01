<?php
include "dbconn.php";

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
</head>

<body>
    <h1>Edit Profile - <?php echo $row['user_first_name'] . ' ' . $row['user_last_name']; ?></h1>
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return profile_validation()">
        <table border="1">
            <tr>
                <td colspan="2">
                    <img src="../data/image<?php echo $row['profile_picture'] ?>" style="max-width: 200px; max-height: 200px;"> <br>
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                </td>
            </tr>
            <tr>
                <td>ID</td>
                <td> <?php echo $row['user_id']; ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td> <input type="text" name="username" id="username" value="<?php echo $row['username']; ?>"></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td> <input type="text" name="firstname" id="firstname" value="<?php echo $row['user_first_name']; ?>"></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td> <input type="text" name="lastname" id="lastname" value="<?php echo $row['user_last_name']; ?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td> <input type="password" name="password" id="password" value="<?php echo $row['password']; ?>"></td>
            </tr>
            <tr>
                <td>Institute Name</td>
                <td> <input type="text" name="institute" value="<?php echo $row['institute_name']; ?>"></td>
            </tr>
        </table>
        <input type="submit" name="submit" value="submit">
    </form>
    <button onclick="goBack()">Back</button>
    <script src="../script/feature-back.js"></script>
<?php } ?>
</body>

</html>
<?php
// End of PHP code
?>
