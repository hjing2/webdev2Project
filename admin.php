<?php
    
    require('connect.php');   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>FurEver Winnipeg</title>
</head>
    <body>
       
        <div id="wrapper">
            <?php include('header.php'); ?> 
        <h1>Admin Panel</h1>
        <?php

            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                echo "You are not authorized to view this page. <a href='login.php'>Login</a>";
                die();
            }

            $query = "SELECT * FROM users";
            $result = $db->query($query);

        ?>

        <h2>User Management Panel</h2>
        <table border='1'>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Pet Experience</th>
                <th>Contact</th>
                <th>Email Address</th>
                <th>Admin User</th>
                <th>Action</th>
            </tr>

            <?php  while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>  
               <?php if ($row['is_admin'] != 1): ?>     
                   <tr>
                        <td> <?=$row['user_id'] ?> </td>
                        <td> <?=$row['user_name'] ?></td>
                        <td> <?=$row['age'] ?></td>
                        <td> <?=$row['gender'] ?></td>
                        <td> <?=$row['pet_experience'] ?></td>
                        <td> <?=$row['contact'] ?></td>
                        <td> <?=$row['email_address'] ?></td>
                        <td> <?=$row['is_admin'] ?></td>
                        <td><a href="user_edit.php?user_id=<?=$row['user_id'] ?>">Edit</a></td>
                    </tr>
            <?php endif; ?>
            <?php endwhile; ?>

        </table>

        
        <a href="user_register.php">Add New User</a>
        
        <br>
        
        <?php

            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                echo "You are not authorized to view this page. <a href='login.php'>Login</a>";
                die();
            }

            $comment_query = "SELECT * FROM comments";
            $comment_result = $db->query($comment_query);

        ?>


        <h2>Comment Management Panel</h2>
        <table border='1'>
            <tr>
                <th>Comment ID</th>
                <th>Animal ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>Content</th>
                <th>Contact</th>
                <th>Comment Time</th>
            </tr>

            <?php  while($comment_row = $comment_result->fetch(PDO::FETCH_ASSOC)): ?>           
                <tr>
                    <td> <?=$comment_row['comment_id'] ?> </td>
                    <td> <?=$comment_row['animal_id'] ?></td>
                    <td> <?=$comment_row['user_id'] ?></td>
                    <td> <?=$comment_row['user_name'] ?></td>
                    <td> <?=$comment_row['content'] ?></td>
                    <td> <?=$comment_row['comment_time'] ?></td>
                    <td><a href="comment_delete.php?comment_id=<?=$comment_row['comment_id'] ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <br>

        <?php

            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                echo "You are not authorized to view this page. <a href='login.php'>Login</a>";
                die();
            }

            $type_query = "SELECT * FROM types";
            $type_result = $db->query($type_query);
        ?>

        <h2>Type Management Panel</h2>
        <table border='1'>
          <tr>
            <th>Type ID</th>
            <th>Type</th>
            <th>Action</th>
          </tr>
          <?php  while($type_row = $type_result->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
              <td> <?=$type_row['type_id'] ?> </td>
              <td> <?=$type_row['type_name'] ?></td>
              <td><a href="type_edit.php?id=<?=$type_row['type_id'] ?>">Edit</a></td>
            </tr>
          <?php endwhile; ?>
        </table>

        <a href="add_type.php">Add New Type</a>
        
    </body>
</html>