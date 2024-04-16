<?php

    require('connect.php');   

    if(isset($_GET['comment_id'])) {
        $comment_id = $_GET['comment_id']; 

        $query = "DELETE FROM comments WHERE comment_id = :comment_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->execute();

        header("Location: admin.php");
        exit;
    }

?>