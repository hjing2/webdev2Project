<?php


    require('connect.php');

    $query = "SELECT * FROM animals ORDER BY animal_id DESC LIMIT 8";

    $statement = $db->prepare($query);

    $statement->execute(); 

    $query2 = "SELECT * FROM stories ORDER BY publish_date DESC LIMIT 5";

    $statement2 = $db->prepare($query2);

    $statement2->execute(); 

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
        <main>       
            
            <?php include('sidebar.php'); ?>

            <div class="rightside">
                
                <h2 class="homepage_h2_title"><a href="adoptable_list.php">Adoptable Pets</a></h2>
                <div id="all_animals">
                
                    <div class="homepage_animal_list">
                        <?php while($row = $statement->fetch()): ?>
                        <div class="homepage_animal_info">
                            <h3><a href="show_animal.php?animal_id=<?= $row['animal_id'] ?>"><?php echo $row['age']."-year-old ". $row['type']." ".$row['name'] ?></a></h3>
                            <img class="small_animal_image" src="<?= $row['image_path'] ?>" alt="<?php echo $row['age']."-years-old ". $row['type']." ".$row['name'] ?>">

                            <div class="animal_description">
                                <p>
                                    <?php echo substr($row['description'], 0, 50);  ?>
                                    <?php if (strlen($row['description']) > 50) : ?>
                                        ... <a href="show_animal.php?animal_id=<?= $row['animal_id'] ?>">Explore more</a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>  
                        <?php endwhile; ?>  
                    </div>
                </div>

                <h2 class="homepage_h2_title"><a href="story_list.php">Adoption Stories</a></h2>
                <div class="adoption_story_list">
                    <?php while($row2 = $statement2->fetch()): ?>
                    <h4 class="story_title"><a href="show_story.php?story_id=row2['story_id'] ?>"><?= $row2['title'] ?></a></h4>
                    <p>
                        <small>
                        <?php
                            $formattedDate2 = date("F d, Y, h:i A", strtotime($row2['publish_date']));
                            echo $formattedDate2;
                        ?>
                        </small>
                    </p>
                    <div class="story_content">
                        <?php echo substr($row2['content'], 0, 100);  ?>
                        <?php if (strlen($row2['content']) > 100) : ?>
                            ... <a href="showblog.php?story_id=<?= $row2['story_id'] ?>">Read Full Story</a>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>  
                </div> 
                             
            </div>
        </main>

        <?php include('footer.php'); ?>
    </div>     
</body>
</html>