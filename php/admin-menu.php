<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Change page title to ADMIN-->
    <title>ADMIN</title>

    <!-- Change the page icon to "icon.png" in the "image" folder -->
    <link rel="icon" href="../image/icon.png">

    <!-- Link to the stylesheet for the admin menu -->
    <link rel="stylesheet" href="../css/adminmenu.css">

    <!-- Preconnect to external font sources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!--website name font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@600&display=swap" rel="stylesheet">
    <!--others font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<body>  
    <!-- Header section with the website logo, name, and system title -->
    <div id="header">
        <a href="mainpage.php"><img src="../image/pic_re.png" id="weblogo" alt="logo"></a>
        <div id="webname">
            <h1>SubjectMastery360</h1>
        </div>
        <div id="head_con">
            <h1>Admin System</h1>
        </div>
    </div>
    
    <div id="all">
        <!-- Navigation menu for admin functionalities -->
        <div id="menu">
            <ul> 
                <!-- Menu items with hyperlinks to various admin pages -->
                <li><a href="admin-manageuser.php">Manage User</a></li>
                <li><a href="admin-database.php">Database</a></li>
                <li><a href="admin-viewfeedback.php">Feedback</a></li>
                <li><a href="feature-logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>