<?php

    include "dbconn.php"; 
    include "admin-menu.php"; 
    include "admin-session.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page - Admin</title>
    <link rel="stylesheet" href="../css/adminmenu.css">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Classroom Counts</title>
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <table>
        <tr>
            <th>Total User</th>
            <td>
                <?php 
                    $userQuery = "SELECT COUNT(*) AS user_count FROM user;";
                    $userResult = mysqli_query($connection, $userQuery); 
                    if ($userQuery) {
                        $userRow = mysqli_fetch_assoc($userResult);
                        echo $userRow['user_count'];
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th>Total Classroom</th>
            <td>
                <?php 
                    $classroomQuery = "SELECT COUNT(*) AS classroom_count FROM classroom;";
                    $classroomResult = mysqli_query($connection, $classroomQuery); 
                    if ($classroomQuery) {
                        $classroomRow = mysqli_fetch_assoc($classroomResult);
                        echo $classroomRow['classroom_count'];
                    }
                ?>
            </td>
        </tr>
    </table>
</body>
</html>

</body>
</html>