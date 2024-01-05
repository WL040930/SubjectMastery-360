<?php

    // Include necessary files
    include "dbconn.php"; 
    include "admin-menu.php";
    include "admin-session.php";

    // Check if 'id' is set in the URL parameters
    if (!isset($_GET['id'])) {
        // Redirect to admin-database.php if 'id' is not set
       header("Location: admin-database.php");
        exit();  
    } else {
        // Get user ID from the URL parameter
        $id = $_GET['id'];
    }

    // Query to fetch user information based on user ID
    $query = "SELECT * FROM `user` LEFT JOIN role ON user.role_id = role.role_id WHERE user_id = '$id'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    // Function to delete user
    function deleteUser($connection, $id) {
        // Check if the user is attempting to delete an admin (user with ID '4')
        if ($id == "4") {
           echo "<script> alert('You are not allowed to delete admin. ') </script>"; 
            exit();
        }
        // Construct delete query and execute
        $deleteQuery = "DELETE FROM `user` WHERE user_id = '$id'";
        mysqli_query($connection, $deleteQuery);
        // You can add additional logic or redirection after deletion
        echo "<script>alert('Account deleted successfully!');";
    }

?>

<!-- Include JavaScript file for confirmation dialog -->
<script src="../script/feature-confirmdelete.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Delete Account</title>
    <link rel="stylesheet" href="../css/admin-deleteprofile.css">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body id="all">

    <!-- Display user information in a table -->
    <h1 id="title">User Information</h1>
    <h1 id="user_title">USERNAME: <?php echo $row['user_first_name'].' '.$row['user_last_name'];?></h1>
    <form action="" method="post" onsubmit="return confirmDelete()">
        <table id="table">
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
                <td><img src="../data/image<?php echo $row['profile_picture']?>" style="width: 200px; height: 200px;"></td>
            </tr>
        </table>

        <!-- Delete button within a form -->
        <input type="submit" value="Delete" name="delete" id="delete_button"><br>
    </form>

</body>
</html>

<?php

    // check if the delete button is submitted
    if(isset($_POST['delete'])){
        //use confirm function to ask if user wants to delete
        if ("<script>confirmDelete();</script>") {
            //call delete function
            deleteUser($connection, $id);
            echo "<script> alert('Account Deleted');</script>";
            echo "<script>window.location.href='admin-database.php';</script>";
        }
    }
?>
