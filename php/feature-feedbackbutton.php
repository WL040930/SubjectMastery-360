<?php

    include "dbconn.php"; 
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

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
    <title>Document</title>
    <link rel="stylesheet" href="../css/feedbackbutton.css">
</head>

<body>
    <button onclick="toggleNewChatModal()"><img src="../image/feedback.png" alt="feedback-image" id="image"></button>

        <div id="newChatContainer">
            <h2>New Chat</h2>
            <form id="newChatForm" method="post" action="#" enctype="multipart/form-data">
                <label for="feedback-content">Feedback Content:</label>
                <input type="text" id="feedback-content" name="feedback-content" required>

                <label for="image">Select File:</label>
                <input type="file" id="image" name="image">

                <input type="submit" value="Submit" name="submit">
            </form>

        </div>

    <script src="../script/classroom-newchat.js"></script>
</body>
</html>

<?php

    if(isset($_POST['submit'])) {
        $feedbackContent = $_POST['feedback-content'];

        $query = "INSERT INTO `feedback`(`user_id`, `feedback_content`) 
                VALUES ('$user_id','$feedbackContent')";

        $result = mysqli_query($connection, $query);
        if($result) {
            $feedback_id = mysqli_insert_id($connection);
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $fileName = $_FILES["image"]["name"];
                $fileSize = $_FILES["image"]["size"];
                $tmpName = $_FILES["image"]["tmp_name"];

                $validImageExtension = ['jpg', 'jpeg', 'png'];
                $imageExtension = explode('.', $fileName);
                $imageExtension = strtolower(end($imageExtension));

                if (!in_array($imageExtension, $validImageExtension)) {
                    echo "<script> alert('Invalid Image Extension');</script>";
                } else if ($fileSize > 5000000) {
                    echo " <script> alert('Image Size Is Too Large'); </script>";
                } else {
                    $newImageName = uniqid();
                    $newImageName .= '.' . $imageExtension;

                    move_uploaded_file($tmpName, '../data/image' . $newImageName);
                    $updateQuery = "INSERT INTO `feedback_attachment`(`feedback_id`, `feedback_file_name`) 
                                    VALUES ('$feedback_id','$newImageName')";
                    mysqli_query($connection, $updateQuery);

                    echo "<script> alert('Question Added Success.');</script>";
                    $current_page = basename($_SERVER['PHP_SELF']);
                    header("Location: $current_page?id=" . $_GET['id']);
                    exit();
                }
            } else {
                echo "<script> alert('Question Added Success.');</script>";
            }
        }
        else {
            echo "<script>alert('Error submitting feedback!')</script>";
        }

    }
//DOUBLE CHECK ON THE LINKING PART !!!
?>