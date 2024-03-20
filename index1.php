<?php


    require('connect.php');

    $query = "SELECT * FROM animals ORDER BY animal_id DESC LIMIT 6";

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
            
            <div class="sidebar">
                <ul>
                    <li><a href="adoptable_list.php">Adoptable Pets</a></li>
                    <li><a href="pet_forum.php">Pet Forum</a></li>
                    <li><a href="adoption_stories.php">Adoption Stories</a></li>
                    <li><a href="adoption_guidelines.php">Adoption Guidelines</a></li>
                    <li><a href="volunteer_application.php">Volunteer Application</a></li>
                </ul>
            </div>

            <div class="rightside">
                <div id="all_animals">
                    <h3><a href="adoptable_list.php">Adoptable Pets</a></h3>
                    <?php while($row = $statement->fetch()): ?>
                    <div class="animal_info">
                        <h3><a href="show_animal.php?animal_id=<?= $row['animal_id'] ?>"><?php echo $row['age']."-year-old ". $row['type'] ?></a></h2>
                        <img class="small_animal_image" src="<?= $row['image_path'] ?>" alt="<?php echo $row['age']."years old". $row['type'] ?>">

                        <div class="animal_description">
                            <p>
                                <?php echo substr($row['description'], 0, 50);  ?>
                                <?php if (strlen($row['description']) > 50) : ?>
                                    ... <a href="show_animal.php?animal_id=<?= $row['animal_id'] ?>">Know more about it</a>
                                <?php endif; ?>
                            </p>
                        </div>
                        <!-- <p>
                            <small>
                            <?php
                                $formattedDate = date("F d, Y, h:i A", strtotime($row['date']));
                                echo "Info updated: ".$formattedDate;
                            ?>
                            <a href="edit.php?id=<?= $row['id'] ?>">edit</a>
                            </small>
                        </p> -->
                    </div>  
                    <?php endwhile; ?>        
                </div>

                <div class="adoption_story">
                    <?php while($row2 = $statement2->fetch()): ?>
                    <h4 class="story_title"><a href="adoption_story.php?animal_id=<?= $row2['animal_id'] ?>"><?= $row2['title'] ?></a></h4>
                    <p>
                        <small>
                        <?php
                            $formattedDate2 = date("F d, Y, h:i A", strtotime($row2['publish_date']));
                            echo $formattedDate2;
                        ?>
                        <a href="edit.php?animalid=<?= $row2['animal_id'] ?>">edit</a>
                        </small>
                    </p>
                    <div class="story_content">
                        <?php echo substr($row2['content'], 0, 100);  ?>
                        <?php if (strlen($row2['content']) > 100) : ?>
                            ... <a href="showblog.php?animal_id=<?= $row2['animal_id'] ?>">Read Full Story</a>
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