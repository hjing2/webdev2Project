<?php
    require('connect.php');

    if (isset($_GET['animal_id'])) {
        $animal_id = filter_var($_GET['animal_id'], FILTER_SANITIZE_NUMBER_INT);
        
        if ($animal_id === false || $animal_id <= 0) {
            header("Location: index1.php");
            exit;
        }

        $query = "SELECT * FROM animals WHERE animal_id = :animal_id";

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
                <div id="animal_details">
                    <div class="animal_info">
                        <img class="animal_image" src="<?= $row['image_path'] ?>" alt="<?= $row['breed'] ?>">
                    </div>
                    <div class="animal_info">
                        <p>Type: <?= $row['type'] ?></p>
                        <p>Breed: <?= $row['breed'] ?></p>
                        <p>Age: <?= $row['age'] ?></p>
                        <p>Gender: <?= $row['gender'] ?></p>
                        <p>Color: <?= $row['color'] ?></p>
                        <p>Description: <?= $row['description'] ?></p>
                    </div>
                </div>
            </div>
        </main>

        <?php include('footer.php'); ?>
    </div>  
</body>
</html>
