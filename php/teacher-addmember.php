<?php
    include "dbconn.php";
    include "teacher-session.php";

    $user_id_session = $_SESSION['id'];
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $fetchquery = "SELECT * FROM `classroom` WHERE `classroom_id` = '$id'";
        $fetchresult = mysqli_query($connection, $fetchquery);
        $fetchrow = mysqli_fetch_assoc($fetchresult);
    

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $fetchquery = "SELECT * FROM `classroom` WHERE `classroom_id` = '$id'";
        $fetchresult = mysqli_query($connection, $fetchquery);
        $fetchrow = mysqli_fetch_assoc($fetchresult);
    }

    // Get the user ID from the session or wherever it's stored
    $user_id_session = $_SESSION['id']; // Update this line based on your actual session variable

    // Handle member removal
    if (isset($_GET['remove_member'])) {
        $remove_user_id = mysqli_real_escape_string($connection, $_GET['remove_member']);

        if (isset($user_id_session) && $user_id_session == $remove_user_id) {
            echo "<script>alert('You cannot remove yourself from the classroom!');</script>";
            echo "<script>window.location.href='teacher-addmember.php';</script>";
        } else {
            // Remove the user from the classroom_member table
            $remove_member_query = "DELETE FROM classroom_member WHERE classroom_id = '$id' AND user_id = '$remove_user_id'";
            mysqli_query($connection, $remove_member_query);

            // Redirect to the same page to refresh
            header("Location: teacher-addmember.php?id=$id");
            exit();
        }
        }

    // Handle member addition
    if (isset($_POST['manage_member'])) {
        // Check if the user with the given email exists
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $user_check_query = "SELECT * FROM user WHERE email_address = '$email' LIMIT 1";
        $user_check_result = mysqli_query($connection, $user_check_query);

        if ($user_check_result) {
            $user = mysqli_fetch_assoc($user_check_result);

            if ($user) {
                $user_id = $user['user_id'];

                // Check if the user is already a member of the classroom
                $check_member_query = "SELECT * FROM classroom_member WHERE classroom_id = '$id' AND user_id = '$user_id'";
                $check_member_result = mysqli_query($connection, $check_member_query);

                if (mysqli_num_rows($check_member_result) == 0) {
                    // Add the user to the classroom_member table
                    $add_member_query = "INSERT INTO classroom_member (classroom_id, user_id) VALUES ('$id', '$user_id')";
                    mysqli_query($connection, $add_member_query);

                    // Redirect to the same page to refresh
                    header("Location: teacher-addmember.php?id=$id");
                    exit();
                } else {
                    echo "<script>alert('User is already a member of the classroom.');</script>";
                }
            } else {
                echo "<script>alert('User not found.');</script>";
            }
        } else {
            // Handle query error
            echo "<script>alert('Error in user query: " . mysqli_error($connection) . "');</script>";
        }
    }

    
    // Fetch the updated result after the removal
    $query = "SELECT *
            FROM classroom_member
            JOIN user ON classroom_member.user_id = user.user_id
            WHERE classroom_member.classroom_id = '$id'";

    $result = mysqli_query($connection, $query);
    $rowcount = ($result) ? mysqli_num_rows($result) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Remove Member</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/teacher-addmember.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>

    <h1>Add/Remove Member - <?php echo $fetchrow['classroom_name']; ?></h1>

    <h3>Total Member: <?php echo $rowcount; ?></h3>

    <table>
        <tr>
            <th>No. </th>
            <th>Name</th>
            <th>Email</th>
            <th>Manage</th>
        </tr>
        <?php
        $counter = 1;

        while ($row = ($result) ? mysqli_fetch_assoc($result) : null) {
        ?>
            <tr>
                <td><?php echo $counter; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email_address']; ?></td>
                <td>
                    <a href="teacher-addmember.php?id=<?php echo $id; ?>&remove_member=<?php echo $row['user_id']; ?>">Remove</a>
                </td>
            </tr>
        <?php
            $counter++;
        }
        ?>
        <tr>
            <td colspan="4">
                <form method="post" action="">
                    <label id="email_title" for="email">Email:</label>
                    <input id="email_con" type="email" name="email" required>
                    <button id="add_button" type="submit" name="manage_member">Add Member</button>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>

<?php

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
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/teacher-addmember.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Choose a Classroom to Manage</h1>
    <?php
        $firstIteration = true; // Flag to identify the first iteration
        while ($classroom_row = mysqli_fetch_assoc($classrooms_result)) {
            // Check if it's not the first iteration to add spacing
            if (!$firstIteration) {
                echo '</ul>'; // Close the previous <ul>
                echo '<ul id="newclass">'; // Open a new <ul>
            } else {
                echo '<ul id="oldclass">'; // Open the first <ul>
                $firstIteration = false; // Set the flag to false after the first iteration
            }
            echo '<li><a id="class_content" href="teacher-addmember.php?id=' . $classroom_row['classroom_id'] . '">' . $classroom_row['classroom_name'] . '</a></li>';
        }
        echo '</ul>'; // Close the last <ul> after the loop
    ?>
</body>
</html>

<?php

        } else {
            echo "You are not involved in any classrooms.";
        }
    }

?>
