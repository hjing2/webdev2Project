<?php
    require('connect.php');

    $query = "SELECT * FROM stories ORDER BY publish_date DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $stories = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Story List</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div id="animal_wrapper">
        <?php include('header.php'); ?> 

        <main>       
            <?php include('sidebar.php'); ?>

            
            <div class="rightside">

                <?php if (isset($_SESSION['is_admin'])): ?>
                    <div class="add_new_story">
                        <p class="add_new_story_message"><a href="add_story.php">Add a new story</a></p> 
                    </div>
                <?php endif; ?>

                <h3>Story List</h3>

                <div class="story_list">
                   <?php foreach($stories as $story): ?>
                      <div class="story_list_info">
                          <h3><a href="show_story.php?story_id=<?= $story['story_id'] ?>">
                          <?php echo $story['title'] ?></a></h3>
                          <p class="story_publish_date"><?= $story['publish_date'] ?></p>
                      </div>
                   <?php endforeach; ?>
                </div>

            </div>
        </main>

        <?php include('footer.php'); ?>
    </div>

                
</body>
</html>