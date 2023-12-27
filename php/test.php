<?php

    require "dbconn.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
      
      $rows = mysqli_query($connection, "SELECT * FROM user WHERE user_id = '1'");
      ?>

      <?php foreach ($rows as $row) : ?>
      <tr>
        <td> <img src="../data/<?php echo 'image'.$row["profile_picture"]; ?>" width = 200 title="<?php echo $row['profile_picture']; ?>"> </td>
      </tr>
      <?php endforeach; ?>
    </table>
    <br>
    <a href="../image">Upload Image File</a>
</body>
</html>