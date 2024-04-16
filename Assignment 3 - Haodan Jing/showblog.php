<?php

/*******w******** 
    
    Name: Haodan Jing
    Date: Jan 29th, 2024
    Description: This is the page to show the full blog content. when id is not valid, the page will redirect to the home page.

****************/

    require('connect.php');

    if (isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        
        if ($id === false || $id <= 0) {
          
            header("Location: index.php");
            exit;
        }

        $query = "SELECT * FROM blogs WHERE id = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        $row = $statement->fetch();
        
        if (!$row) {
            header("Location: index.php");
            exit;
        }

    } else {
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Haodan Jing's Blog - <?= $row['title'] ?></title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div id="wrapper">
        <?php include('header.php'); ?> 

        <div id="all_blogs">
            <div class="blog_post">
                <h2><?= $row['title'] ?> </h2>
                <p>
                    <small>
                        <?php
                        $formattedDate = date("F d, Y, h:i A", strtotime($row['date']));
                        echo $formattedDate;
                    ?> <a href="edit.php?id=<?= $row['id'] ?>">edit</a></small>
                </p>
                <div class="blog_content">
                    <?= nl2br($row['content']) ?>
                </div>
            </div>
        </div>

        <div id="footer">
        Copywrong 2024 - No Rights Reserved
        </div> 
    </div>  
</body>
</html> 