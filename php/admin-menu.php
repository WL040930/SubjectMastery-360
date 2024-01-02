<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Bar</title>
    <link rel="stylesheet" href="../css/adminmenu.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--website name font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@600&display=swap" rel="stylesheet">
    <!--others font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>  
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
        <div id="menubar">
            <ul> 
                <li><a href="admin-manageuser.php" disable>Manage User</a></li>
                <li><a href="admin-database.php">Database</a></li>
                <li><a href="admin-viewfeedback.php">Feedback</a></li>
                <li><a href="feature-logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>