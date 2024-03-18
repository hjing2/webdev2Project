<?php

/*******w******** 
    
    Name: Haodan Jing
    Date: Jan 29th, 2024
    Description: This is the edit page to update the existing blog title and content. It include update and delete function, and will not update the blog if there's no character in the title or content.

****************/

    require('connect.php');
    require('authenticate.php');

    if(isset($_GET['id'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        if($id === false || $id <= 0) {
            header("Location: index.php");
            exit;
        }

        $query = "SELECT * FROM blogs WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $blog = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$blog) {
            header("Location: index.php");
            exit;
        }
    }

    if ($_POST) {
        
        if(isset($_POST['delete'])) {
           
            $query = "DELETE FROM blogs WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            header("Location: index.php");
            exit;
        }

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (strlen($title) > 0 && strlen($content) > 0) {
            $query = "UPDATE blogs SET title = :title, content = :content WHERE id = :id";
            $statement = $db->prepare($query);

            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);

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
    <title>Edit Blog Post</title>
</head>
<body>
    <?php include('header.php'); ?> 

    <h3>Edit blog post</h3>
    <?php if (isset($id) && $id && isset($blog)): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $blog['id'] ?>">
            <label for="title">Title</label>
            <input id="title" name="title" value="<?= $blog['title'] ?>"> 
            <p class="error_post">
                <?php if (isset($errorTitle) && !empty($errorTitle)) {
                    echo $errorTitle;
                } ?>
            </p>
            <label for="content">Content</label>
            <textarea id="content" name="content" rows="8"><?= $blog['content'] ?></textarea>
            <p class="error_post">
                <?php if (isset($errorContent) && !empty($errorContent)) {
                    echo $errorContent;
                } ?>
            </p>
            <input type="submit" value="Confirm Edit">
            <input type="submit" name="delete" value="Delete">
        </form>
    <?php else: ?>
        <p>No blog selected. <a href="post.php">Create a new blog with this link</a></p>
    <?php endif ?>

    <div id="footer">
        Copywrong 2024 - No Rights Reserved
    </div> 

</body>
</html>
