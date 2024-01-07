<?php

    // Include necessary files
    include "dbconn.php"; 
    include "admin-menu.php";
    include "admin-session.php";

    // Initialize variables for sorting and searching
    $sortrole = ""; 
    $searchby = "";

    // Check if the form is submitted
    if (isset($_GET['submit'])) {
        // Set sorting option based on user selection
        $sortrole = $_GET['sort-by'];
        if ($sortrole == "default") {
            $sortrole = "";
        } elseif ($sortrole == "student") {
            $sortrole = "WHERE role = 'student'";
        } elseif ($sortrole == "teacher") {
            $sortrole = "WHERE role = 'teacher'";
        }

        // Set search criteria based on user input
        $searchby = $_GET['search-by'];
        $searchTerm = mysqli_real_escape_string($connection, $_GET['search']);

        // Build the search condition based on the selected sort role
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

        // Construct the final query for fetching data
        $query = "SELECT * FROM user LEFT JOIN role ON user.role_id = role.role_id $sortrole $searchbyClause";
        $result = mysqli_query($connection, $query);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Database</title>
    <link rel="stylesheet" href="../css/admin-database.css">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body id="all">
    <!-- Search form for sorting and filtering data -->
    <form action="#" method="get" id="search-form">
        <label for="search-by">
            Search by:
            <select name="search-by" id="search-by">
                <option value="username" id="search_op1">Username</option>
                <option value="email" id="search_op2">Email Address</option>  
            </select>
        </label>
        <label for="search" id="search-label" style="display: none;">
            <input type="text" name="search" id="search" placeholder="Enter your search">
        </label>
        <label for="sort-by" id="sortlabel">
            Sort by:
            <select name="sort-by" id="sort-by">
                <option value="default" id="sort_op1">Default</option>
                <option value="student" id="sort_op2">Student</option>  
                <option value="teacher" id="sort_op3">Teacher</option>  
            </select>
        </label>
        <button type="submit" id="search-button" name="submit">Search</button>
    </form>

    <!-- Display the table with user data -->
    <?php if (isset($_GET['submit'])) { ?>
        <table id="data_table">
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
                <td><a href="admin-manageprofile.php?id=<?php echo $row['user_id'];?>"><img src="../image/edit.png" alt="edit" id="edit"></a></td>
                <td><a href="admin-deleteprofile.php?id=<?php echo $row['user_id'];?>"><img src="../image/delete.png" alt="delete" id="delete"></a></td>
            </tr>
        <?php } ?>
        </table>
        <br><br>
    <?php } ?>
    
    <script src="../script/admin-database.js"></script>
</body>
</html>

<?php

    // Close database connection
    mysqli_close($connection);

?>