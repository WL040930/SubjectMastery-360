<?php
    include "dbconn.php"; 
    include "admin-menu.php";
    include "admin-session.php";

    if(!isset($_GET['id'])) {
        header("Location: admin-database.php");
        exit();  
    } else {
        $id = $_GET['id'];
    }

    $query = "SELECT * FROM `user` LEFT JOIN role ON user.role_id = role.role_id WHERE user_id = '$id'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    // Function to delete user
    function deleteUser($connection, $id) {
        if($id == "4") {
            echo "<script> alert('You are not allowed to delete admin. ') </script>"; 
            exit();
        }
        $deleteQuery = "DELETE FROM `user` WHERE user_id = '$id'";
        mysqli_query($connection, $deleteQuery);
        // You can add additional logic or redirection after deletion
        echo "<script>alert('Account deleted successfully!');";
    }
?>

<script src="../script/feature-confirmdelete.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
    <h1>User Information - <?php echo $row['user_first_name'].' '.$row['user_last_name'];?></h1>
    <form action="" method="post" onsubmit="return confirmDelete()">
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $row['user_id'];?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo $row['role'];?></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><?php echo $row['user_first_name'];?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?php echo $row['user_last_name'];?></td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td><?php echo $row['email_address'];?></td>
            </tr>
            <tr>
                <th>Institute Name</th>
                <td><?php echo $row['institute_name'];?></td>
            </tr>
            <tr>
                <th>Profile Picture</th>
                <td><img src="../data/image<?php echo $row['profile_picture']?>" style="max-width: 200px; max-height: 200px;"></td>
            </tr>
        </table>
        <input type="submit" value="Delete" name="delete">
    </form>

</body>
</html>

<?php
    if(isset($_POST['delete'])){
        if ("<script>confirmDelete();</script>") {
            deleteUser($connection, $id);
            echo "<script> alert('Account Deleted');</script>";
            echo "<script>window.location.href='admin-database.php';</script>";
        }
    }
?>
