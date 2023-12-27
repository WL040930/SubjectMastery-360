<?php
    include "dbconn.php"; 
    include "admin-menu.php";
    include "admin-session.php";

    $sortrole = ""; 
    $searchby = "";

    if (isset($_GET['submit'])) {
        $sortrole = $_GET['sort-by'];
        if ($sortrole == "default") {
            $sortrole = "";
        } elseif ($sortrole == "student") {
            $sortrole = "WHERE role = 'student'";
        } elseif ($sortrole == "teacher") {
            $sortrole = "WHERE role = 'teacher'";
        }

        $searchby = $_GET['search-by'];
        $searchTerm = mysqli_real_escape_string($connection, $_GET['search']);

        if (empty($sortrole)) {
            $searchbyClause = "";
            if (!empty($searchby)) {
                if ($searchby == "username") {
                    $searchbyClause = "WHERE username LIKE '%$searchTerm%'";
                } elseif ($searchby == "email") {
                    $searchbyClause = "WHERE email_address LIKE '%$searchTerm%'";
                }
            }
        } else {
            $searchbyClause = "";
            if (!empty($searchby)) {
                if ($searchby == "username") {
                    $searchbyClause = "AND username LIKE '%$searchTerm%'";
                } elseif ($searchby == "email") {
                    $searchbyClause = "AND email_address LIKE '%$searchTerm%'";
                }
            }
        }

        $query = "SELECT * FROM user LEFT JOIN role ON user.role_id = role.role_id $sortrole $searchbyClause";
        $result = mysqli_query($connection, $query);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database</title>
    <link rel="stylesheet" href="../styles/admin-database.css">
</head>
<body>
    <form action="#" method="get" id="search-form">
        <label for="search-by">
            Search by:
            <select name="search-by" id="search-by">
                <option value="username">Username</option>  
                <option value="email">Email Address</option>  
            </select>
        </label>
        <label for="search" id="search-label" style="display: none;">
            <input type="text" name="search" id="search" placeholder="Enter your search">
        </label>
        <label for="sort-by">
            Sort by:
            <select name="sort-by" id="sort-by">
                <option value="default">Default</option>
                <option value="student">Student</option>  
                <option value="teacher">Teacher</option>  
            </select>
        </label>
        <button type="submit" id="search-button" name="submit">Search</button>
    </form>

    <?php if (isset($_GET['submit'])) { ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Role</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Institute Name</th>
                <th colspan="2">Manage</th>
            </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['user_first_name']; ?></td>
                <td><?php echo $row['user_last_name']; ?></td>
                <td><?php echo $row['email_address']; ?></td>
                <td><?php echo $row['institute_name']; ?></td>
                <td><a href="admin-manageprofile.php?id=<?php echo $row['user_id'];?>">Edit</a></td>
                <td><a href="admin-deleteprofile.php?id=<?php echo $row['user_id'];?>">Delete</a></td>
            </tr>
        <?php } ?>
        </table>
    <?php } ?>
    
    <script src="../script/admin-database.js"></script>
</body>
</html>
