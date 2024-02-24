<?php
    // Include database connection
    include "dbconn.php";

    // Check if commentCount is set and is a valid integer
    if(isset($_POST['commentCount']) && is_numeric($_POST['commentCount'])) {
        $commentNewCount = $_POST['commentCount'];
    } else {
        // Handle the case when commentCount is not provided or not valid
        $commentNewCount = 1; // Default value
    }

    $commentLastCount = $commentNewCount - 1;

    // Initialize the output variable
    $output = '';

    // Construct the SQL query
    $query = "SELECT * FROM user
            INNER JOIN feedback ON user.user_id = feedback.user_id ";

    // If search_submit is set, apply email search filter
    if(isset($_POST['search_submit'])) {
        $searchEmail = mysqli_real_escape_string($connection, $_POST['search_email']);
        $query .= "WHERE user.email_address LIKE '%$searchEmail' 
                OR user.email_address LIKE '$searchEmail%'
                OR user.email_address LIKE '%$searchEmail%' ";
    }

    // Limit the number of results based on commentNewCount
    $query .= "LIMIT 1 OFFSET $commentLastCount";

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Check if there are any results
    if(mysqli_num_rows($result) > 0) {
        // Loop through the results and generate HTML output
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<div class="feedback-box">
                            <div class="personal-info">
                                <table class="table-feedback">
                                    <tr>
                                        <td rowspan="2" class="feedback-column">
                                            <div id="profile-picture" style="border: 0px">
                                                <img class="profile-picture" src="../data/image' . $row["profile_picture"] . '" width="50" height="50" title="' . $row['profile_picture'] . '">
                                            </div>
                                        </td>
                                        <td class="feedback-column">
                                            <b>User ID: </b>
                                        </td>
                                        <td class="feedback-column">
                                            <div id="user-id">' . $row['user_id'] . '</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="feedback-column">
                                            <b>Email Address: </b>
                                        </td>
                                        <td class="feedback-column">
                                            <div id="username">' . $row['email_address'] . '</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="feedback-content">
                                <div id="feedback-content">
                                    <b>FEEDBACK CONTENT: <br></b>' . $row['feedback_content'] . '
                                </div>';

            // Fetch feedback attachments
            $fetchid = $row['feedback_id'];
            $fetchquery = "SELECT * FROM feedback_attachment WHERE feedback_id = '$fetchid'";
            $fetchresult = mysqli_query($connection, $fetchquery);
            if (mysqli_num_rows($fetchresult) > 0) {
                while ($fetchrow = mysqli_fetch_assoc($fetchresult)) {
                    $output .= '<div id="attachment"><img src="../data/image' . $fetchrow['feedback_file_name'] . '" height="200" width="auto"></div>';
                }
            }
            $output .= '</div>
                        </div>';
        }
    } else {
        // No feedback found
        $output = '<div style="text-align: center">No feedback found.</div>';
        echo '<script> 
                document.getElementById("buttonId").style.display = "none";
                </script>';
    }

    // Output the generated HTML
    echo $output;

    // Close database connection
    mysqli_close($connection);
?>
