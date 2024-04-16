<?php

/*******w******** 
    
    Name: Haodan Jing
    Date: Jan 29th, 2024
    Description: This is the page to post blogs. The blog will not be posted if there's no character in the title or content.

****************/

    require('connect.php');
    require('authenticate.php');

    if ($_POST) {
        
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
        if (strlen($title) > 0 && strlen($content) > 0) {
            $query = "INSERT INTO blogs (title, content) VALUES (:title, :content)";
            $statement = $db->prepare($query);

            $statement->bindvalue(':title', $title);
            $statement->bindvalue(':content', $content);

            $statement->execute();

            header("Location: index.php");
            exit;

        } else {
            if (strlen($title) < 1) {
                $errorTitle = 'Please input at least one character in the title';
            }
            if (strlen($content) < 1) {
                $errorContent = 'Please input at least one character in the content';
            }
        } 
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post!</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php include('header.php'); ?> 

    <h3>Add a new blog post</h3>
    <form method="post" action="post.php">
        <label for="title">Title</label>
        <input id="title" name="title">
        <p class="error_post">
            <?php if(!empty($errorTitle)){
                echo $errorTitle;
            } ?>
        </p>
        <label for="content">Content</label>
        <textarea id="content" name="content" rows="8"></textarea>
        <p class="error_post">
            <?php if(!empty($errorContent)){
                echo $errorContent;
            } ?>
        </p>
        <input type="submit" value="Post">
    </form>

    <div id="footer">
        Copywrong 2024 - No Rights Reserved
    </div> 

</body>
</html>