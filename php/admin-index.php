<?php

    //include the database connection file 
    include "dbconn.php"; 

    //include the admin menu file
    include "admin-menu.php"; 

    //include the admin session file
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
    <table id="table1">
        <tr>
            <th id="th1">Total User</th>
            <td id="td1">
                <?php 
                    // Query to retrieve the total number of users
                    $userQuery = "SELECT COUNT(*) AS user_count FROM user;";
                    $userResult = mysqli_query($connection, $userQuery); 

                    // Check if the query was successful
                    if ($userQuery) {
                        $userRow = mysqli_fetch_assoc($userResult);
                        echo $userRow['user_count'];
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th id="th1">Total Classroom</th>
            <td id="td1">
                <?php 
                    // Query to retrieve the total number of classrooms
                    $classroomQuery = "SELECT COUNT(*) AS classroom_count FROM classroom;";
                    $classroomResult = mysqli_query($connection, $classroomQuery); 

                    // Check if the query was successful
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

<?php

    // Close database connection
    mysqli_close($connection);

?>