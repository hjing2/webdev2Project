<?php

/*******w******** 
    
    Name: Haodan Jing
    Date: Jan 29th, 2024
    Description: This is the home page of the blog website. With the links in the home page, you can check links to full blog pages, create new post page, and edit post page. It only shows 5 most recent blogs in the home page, and only shows 200 characters of the blog content.

****************/

    require('connect.php');

    $query = "SELECT * FROM animals ORDER BY date DESC LIMIT 10";

    $statement = $db->prepare($query);

    $statement->execute(); 

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
    <!-- Remember that alternative syntax is good and html inside php is bad -->

    <div id="wrapper">
        <?php include('header.php'); ?> 
        
        <div id="all_animals">
            <?php while($row = $statement->fetch()): ?>
            <div class="blog_post">
                <h2><a href="showblog.php?id=<?= $row['id'] ?>"><?php echo $row['name'] ?></a></h2>
                <p>
                    <small>
                    <?php
                        $formattedDate = date("F d, Y, h:i A", strtotime($row['date']));
                        echo $formattedDate;
                    ?>
                    <a href="edit.php?id=<?= $row['id'] ?>">edit</a>
                    </small>
                </p>
                <div class="blog_content">
                    <?php echo substr($row['content'], 0, 200);  ?>
                    <?php if (strlen($row['content']) > 200) : ?>
                        ... <a href="showblog.php?id=<?= $row['id'] ?>">Know more about it</a>
                    <?php endif; ?>
                </div>
            </div>  
            <?php endwhile; ?>        
        </div>

        <?php include('footer.php'); ?>
    </div>     
</body>
</html>