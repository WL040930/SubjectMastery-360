<?php

    include "../dbconn.php";
    session_start();
    if(isset($_SESSION['admin']) == null) {
        echo "<script>alert('Authorized Access only!')</script>";
        echo "<script>window.location.href='../login.php';</script>";
    } else {
        if(isset($_GET['id'])) {
            $email = $_GET['emailbox'];
            $query = "SELECT * FROM user WHERE email_address LIKE '%$email' OR email_address LIKE '$email%'
            OR email_address LIKE '%$email%'";
            $result = mysqli_query($connection, $query);
            if(mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $username = $row['username'];
                    $email = $row['email_address'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
</head>
<body>
    <div id="search-box">
        hihi
        <form action="" method="get">
            <input type="text" name="emailbox" id="inp-box" placeholder="Enter Email">
            <input type="submit" value="" name = "btnSearch">
        </form>
    </div>
    <div id="query-box">
        <table border="1">
            <tr>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>


</body>
</html>

<?php

}
} else {
    echo "<script> alert('No record found!') </script>";
}
}
}     

?>