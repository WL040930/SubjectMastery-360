<?php

    include "dbconn.php";
    include "admin-session.php";
    include "admin-menu.php";

    if(isset($_POST['search_submit'])) {
        $searchEmail = mysqli_real_escape_string($connection, $_POST['search_email']);
        $query = "SELECT * FROM user
                  INNER JOIN feedback ON user.user_id = feedback.user_id
                  WHERE user.email_address LIKE '%$searchEmail' 
                  OR user.email_address LIKE '$searchEmail%'
                  OR user.email_address LIKE '%$searchEmail%'
                  LIMIT 1";
        } else {
            $query = "SELECT * FROM user
                      INNER JOIN feedback ON user.user_id = feedback.user_id
                      LIMIT 1";
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="../css/admin-viewfeedback.css">
    <link rel="stylesheet" href="../css/animation.css">
    <!--script to connect to the ajax in jquery-->
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            var commentCount = 1;
            $("button").click(function(){
                commentCount = commentCount + 1;
                var formData = $("#search-form").serialize(); // Serialize form data
                // Append commentCount to serialized form data
                formData += "&commentCount=" + commentCount;
                $.ajax({
                    type: "POST",
                    url: "search-feedback.php", 
                    data: formData, // Send serialized form data with commentCount
                    success: function(response) {
                        $(".feedback-box:last").after(response); 
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@500&display=swap" rel="stylesheet">
</head>

<style>
    .showbtn {
        text-align: center;
        margin: 20px 0px 20px 0px;
    }

    button{ 
        text-align: center;
        margin: 20px 0px 20px 0px;
        padding: 10px 20px 10px 20px;
        background-color: #7E6E57;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
</style>

<body>
    <div class="form">
        <form id="search-form" method="post" action="">
            <label for="search-email">Search by Email:</label>
            <input type="text" id="search-email" name="search_email" placeholder="Enter email address">
            <button type="submit" name="search_submit" class="btnSubmit">Search</button>
        </form>
    </div>


    <?php 
                
        $result = mysqli_query($connection, $query); 
        while ($row = mysqli_fetch_assoc($result)) {
    
    ?>

    <div class="feedback-box">
        <div class="personal-info">
            <table class="table-feedback">
                <tr>
                    <td rowspan="2" class="feedback-column">
                        <div id="profile-picture" style="border: 0px">
                            <img class="profile-picture" src="../data/<?php echo 'image' . $row["profile_picture"]; ?>" width="50" height="50" title="<?php echo $row['profile_picture']; ?>">
                        </div>
                    </td>
                    <td class="feedback-column">
                        <b>User ID: </b>
                    </td>
                    <td class="feedback-column">
                        <div id="user-id">
                            <?php echo $row['user_id']; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="feedback-column">
                        <b>Email Addrress: </b>
                    </td>
                    <td class="feedback-column">
                        <div id="username">
                            <?php echo $row['email_address']; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="feedback-content">
            <div id="feedback-content">
                <?php echo "<b>FEEDBACK CONTENT: <br></b>". $row['feedback_content']; ?>
            </div>
            <?php 
                $fetchid = $row['feedback_id'];
                $fetchquery = "SELECT * FROM feedback_attachment WHERE feedback_id = '$fetchid'"; 
                $fetchresult = mysqli_query($connection, $fetchquery);
                if (mysqli_num_rows($fetchresult) > 0) {
                    while ($fetchrow = mysqli_fetch_assoc($fetchresult)) {
                        echo "<div id='attachment'><img src='../data/image". $fetchrow['feedback_file_name']."' height ='200' width='auto'></img></div>"; 
                    }
                }
            ?>
        </div>
    </div>
    
    <div class="showbtn">
        <button id="buttonId">Show more feedbacks</button>
    </div>

</body>
</html>

<?php
        }

    // Close database connection
    mysqli_close($connection);

?>