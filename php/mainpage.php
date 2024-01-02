<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - SubjectMaster360</title>
    <link rel="icon" href="../image/icon.png">
    <link rel="stylesheet" href="../css/mainpage.css">
    <script src="../script/mainpage.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!--website name font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@600&display=swap" rel="stylesheet">
    <!--others font-->
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div id="logo_menu">
        <a href="mainpage.php"><img src="../image/pic_re.png" id="weblogo" alt="logo"></a>
        <div id="webname">
            <h1>SubjectMastery360</h1>
        </div>
        <div id="menubar">
            <table class="menubar_content">
                <!--connect to HOME-->
                <th><a href="mainpage.php" class="menu1">HOME</a></th>
                <!--connect to ABOUT US-->
                <th><a href="" class="menu2">ABOUT US</a></th>
                <!--connect to CUSTOMER FEEDBACK-->
                <th><a href="" class="menu3">CUSTOMER FEEDBACK</a></th>   
            </table>
        </div>
    </div>
    <br>
    <div id="all">
        <div id="slogan">
            <br>
            <h1>"Empower Your Mind, Master Every Subject"</h1>
        </div>
        <br>
        <div id="login_signup">
            <div>
                <table id="login">
                    <!--connect to LOGIN PAGE-->
                    <th><a href="https://music.youtube.com/" class="login_button" title="Click to login">LOGIN</a></th>
                </table>
            </div>
            <div>
                <table id="register">
                    <!--connect to USER REGISTER PAGE-->
                    <th><a href="https://youtube.com/" class="register_button" title="Click to create a account">SIGN UP</a></th>
                </table>
            </div>
        </div>
        <br><br><br>
        <div id="objective">
            <table id="objective_table">
                <tr class="obj_img">
                    <th><img src="../image/1.png" alt="objective1" class="obj1"></th>
                    <th><img src="../image/2.png" alt="objective2" class="obj2"></th>
                    <th><img src="../image/3.png" alt="objective3" class="obj3"></th>
                    <th><img src="../image/4.png" alt="objective4" class="obj4"></th>
                </tr>
                <tr class="obj_content">
                    <td class="con">
                        <br>
                        <b id="Bcon1" class="bcon" onclick="togglepcon1()">Facilitate Students Learning Process</b><br><br>
                        <p id="Pcon1" class="pcon">SubjectMastery360 will centralize the learning materials that students need to study so that they do not have to spend time searching for them.</p>
                    </td>
                    <td class="con">
                        <br>
                        <b id="Bcon2" class="bcon" onclick="togglepcon2()">Simplifying Sharing Materials Process</b><br><br>
                        <p id="Pcon2" class="pcon">SubjectMastery360 offers “classroom” feature which allows teachers to share the study materials such as notes to their students easily.</p>
                    </td>
                    <td class="con">
                        <br>
                        <b id="Bcon3" class="bcon" onclick="togglepcon3()">Helps in Analysing & Collecting Data</b><br><br>
                        <p id="Pcon3" class="pcon">SubjectMastery360 will automatically generate results graph of the assessment to help teachers in analysing the results of students.</p>
                    </td>
                    <td class="con">
                        <br>
                        <b id="Bcon4" class="bcon" onclick="togglepcon4()">Optimize Processes to <br>Save Time & Resources</b><br><br>
                        <p id="Pcon4" class="pcon">SubjectMastery360 automates student reports, saving teachers time in report generation and writing, providing both individual and overall assessments.</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>