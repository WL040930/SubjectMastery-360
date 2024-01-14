<?php

    // include database connection file
    include "dbconn.php"; 
    
    // start session if the session is not started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // direct user to logout page (make sure all the session are cleared) if the user is not logged in
    if(!isset($_SESSION['id'])) {
        header("Location: feature-logout.php");
        exit();
    } else {
        $user_id = $_SESSION['id'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/feedbackbutton.css">
</head>

<body>
    <!-- Feedback button triggering a modal -->
    <button onclick="toggleNewChatModal()" class="feedback-btn"><img src="../image/feedback.png" alt="feedback-image" id="image"></button>

        <!-- input field for feedback -->
        <div id="newChatContainer">
            <h2>New Chat</h2>
            <form id="newChatForm" method="post" action="#" enctype="multipart/form-data">
                <label for="feedback-content">Feedback Content:</label>
                <textarea id="feedback-content" name="feedback-content" cols="20" rows="5" required style="resize: none"></textarea>

                <label for="image">Select File:</label>
                <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png">

                <input type="submit" value="Submit" name="submit">
            </form>
        </div>

    <script src="../script/classroom-newchat.js"></script>
</body>
</html>

<?php

    // if user clicks on submit button
    if(isset($_POST['submit'])) {

        // retrieve feedback content from the page
        $feedbackContent = $_POST['feedback-content'];

        // insert feedback into database
        $query = "INSERT INTO `feedback`(`user_id`, `feedback_content`) 
                VALUES ('$user_id','$feedbackContent')";

        // execute the query
        $result = mysqli_query($connection, $query);

        // if the query is executed successfully
        if($result) {

            // Retrieve the feedback ID of the inserted record
            $feedback_id = mysqli_insert_id($connection);

            // Check if an image file is uploaded
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {

                // Retrieve information about the uploaded image
                $fileName = $_FILES["image"]["name"];
                $fileSize = $_FILES["image"]["size"];
                $tmpName = $_FILES["image"]["tmp_name"];

                // Define valid image extensions
                $validImageExtension = ['jpg', 'jpeg', 'png'];
                $imageExtension = explode('.', $fileName);
                $imageExtension = strtolower(end($imageExtension));

                // Check if the image extension is valid
                if (!in_array($imageExtension, $validImageExtension)) {
                    echo "<script> alert('Invalid Image Extension');</script>";
                } else if ($fileSize > 5000000) {
                    echo " <script> alert('Image Size Is Too Large'); </script>";
                } else {

                    // Generate a unique name for the image
                    $newImageName = uniqid();
                    $newImageName .= '.' . $imageExtension;

                    // Move the uploaded image to the specified directory
                    move_uploaded_file($tmpName, '../data/image' . $newImageName);

                    // SQL query to insert image file information into 'feedback_attachment' table
                    $updateQuery = "INSERT INTO `feedback_attachment`(`feedback_id`, `feedback_file_name`) 
                                    VALUES ('$feedback_id','$newImageName')";

                    // Execute the query
                    mysqli_query($connection, $updateQuery);

                    // Display success message and redirect to a specific page
                    echo "<script> alert('Feedback Submitted.');</script>";
                    header("Location: stu-teac-index.php");
                    exit();
                }
            } else {
                // Display success message if no image is uploaded
                echo "<script> alert('Feedback Submitted.');</script>";
                header("Location: stu-teac-index.php");
                exit();
            }
        }
        else {
            // Display error message if the feedback submission fails
            echo "<script>alert('Error submitting feedback!')</script>";
        }

    }

?>