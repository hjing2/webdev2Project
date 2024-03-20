<?php
    require('connect.php');

    $query = "SELECT * FROM animals ORDER BY animal_id DESC LIMIT 10";
    $statement = $db->prepare($query);
    $statement->execute();
    $animals = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FurEver Winnipeg - Adoptable Pets</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div id="animal_wrapper">
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
                <div id="animal_list">
                    <?php foreach($animals as $index => $animal): ?>
                        <div class="animal_info">
                            <h3><a href="show_animal.php?animal_id=<?= $animal['animal_id'] ?>"><?php echo $animal['breed'] ?></a></h3>
                            <img class="small_animal_image" src="<?= $animal['image_path'] ?>" alt="<?php echo $animal['breed'] ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>

        <?php include('footer.php'); ?>
    </div>  
</body>
</html>