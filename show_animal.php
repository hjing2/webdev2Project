<?php
    require('connect.php');

        

    if (isset($_GET['animal_id'])) {
        $animal_id = filter_var($_GET['animal_id'], FILTER_SANITIZE_NUMBER_INT);
        
        if ($animal_id === false || $animal_id <= 0) {
            header("Location: index1.php");
            exit;
        }

        $query = "SELECT animals.*, types.type_name as type_name 
                 FROM animals 
                 JOIN types ON types.type_id = animals.type_id 
                 WHERE animal_id = :animal_id";

        $statement = $db->prepare($query);
        $statement->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
 
        $statement->execute();

        $row = $statement->fetch();

        
        if (!$row) {
            header("Location: index1.php");
            exit;
        }

    } else {
        header("Location: index1.php");
        exit;
    }

    $comment_query = "
        SELECT comments.*, COALESCE(users.user_name, comments.user_name) as combined_user_name
        FROM comments
        LEFT JOIN users ON comments.user_id = users.user_id
        WHERE animal_id = :animal_id 
        ORDER BY comment_time DESC
    ";
    $comment_statement = $db->prepare($comment_query);
    $comment_statement->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
    $comment_statement->execute();
    $comments = $comment_statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FurEver Winnipeg - <?= $row['breed'] ?></title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div id="animal_wrapper">
        <?php include('header.php'); ?> 

        <main>       
            <?php include('sidebar.php'); ?>

            <div class="rightside">
                <div id="animal_details">
                    <div class="animal_detail1">

                        <?php if((($row['image_path']) === NULL) || (($row['image_path']) === '')): ?>
                            <div class="no_photo">
                                <p>No photo</p>
                            </div>
                        <?php else: ?>
                            <img class="animal_image" src="<?= $row['image_path'] ?>" alt="<?= $row['breed'] ?>">
                        <?php endif; ?>
                    </div>
                    <div class="animal_detail2">
                        <p>Name: <?= $row['name'] ?></p>
                        <p>Type: <?= $row['type_name'] ?></p>
                        <p>Breed: <?= $row['breed'] ?></p>
                        <p>Age: <?= $row['age'] ?></p>
                        <p>Gender: <?= $row['gender'] ?></p>                        
                        <p>Description: <?= $row['description'] ?></p>
                    </div>
                </div>

                <?php if (isset($_SESSION['is_admin'])): ?>
                    <div class="animal_edit_link">
                        <p><a href="edit.php?animal_id=<?= $row['animal_id'] ?>">Edit</a></p>
                    </div>
                <?php endif; ?>

                <div class="comments">
                    <h3>Comments</h3>
                    <form action="handle_comments.php" method="post">
                        <label for="comment">Add New Comment</label>
                        <textarea for="comment" name="comment" required><?php echo isset($_SESSION['input_values']['comment']) ? $_SESSION['input_values']['comment'] : ''; ?></textarea>
                    
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <label for="user_name">Your name:</label>
                            <input type="text" id="user_name" name="user_name"><?php echo isset($_SESSION['input_values']['user_name']) ? $_SESSION['input_values']['user_name'] : ''; ?>
                        <?php endif; ?>

                        <p><img src="captcha.php" alt="Captcha Image" class="captcha_image"></p>
                        <label for="captcha">Please enter the number in the image:</label>
                        <input type="text" class="captcha_input" name="captcha_input" required>

                        <?php if (isset($_SESSION['captcha_error'])): ?> 
                            <p><?= $_SESSION['captcha_error'] ?></p>
                        <?php endif; ?>
                        
                        <input type="hidden" name="animal_id" value="<?= $row['animal_id'] ?>">
                        <input type="submit" name="submit_comment" value="Submit Comment">
                    </form>
                      
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment_content">
                            <p><?= $comment['content'] ?></p>
                            <p class="comment_info">
                                <?php 
                                $username = empty($comment['combined_user_name']) ? "Anonymous user" : htmlspecialchars($comment['combined_user_name']); 
                                ?>
                                
                                Posted by <?= $username ?> at <?= htmlspecialchars($comment['comment_time']) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </main>

        <?php include('footer.php'); ?>
    </div>  
</body>
</html>
