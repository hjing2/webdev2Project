<?php
    require('connect.php');

    if (isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        
        if ($id === false || $id <= 0) {
            header("Location: index.php");
            exit;
        }

        $query = "SELECT * FROM animals WHERE id = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        $row = $statement->fetch();
        
        if (!$row) {
            header("Location: index.php");
            exit;
        }

    } else {
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FurEver Winnipeg - <?= $row['name'] ?></title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div id="wrapper">
        <?php include('header.php'); ?> 

        <div id="animal_details">
            <div class="animal_info">
                <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
            </div>
            <div class="animal_info">
                <h2>Name: <?= $row['name'] ?></h2>
                <p>Type: <?= $row['type'] ?></p>
                <p>Breed: <?= $row['breed'] ?></p>
                <p>Age: <?= $row['age'] ?></p>
                <p>Gender: <?= $row['gender'] ?></p>
                <p>Color: <?= $row['color'] ?></p>
                <p>Description: <?= $row['description'] ?></p>
            </div>
        </div>

        <div id="footer">
            Copywrong 2024 - No Rights Reserved
        </div> 
    </div>  
</body>
</html>
