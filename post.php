<?php
    require('connect.php');
    require('authenticate.php');

    if ($_POST) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $breed = filter_input(INPUT_POST, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (strlen($name) > 0 && strlen($type) > 0 && strlen($breed) > 0 && $age > 0 && strlen($gender) > 0 && strlen($color) > 0 && strlen($description) > 0) {
            // Upload image
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $query = "INSERT INTO animals (name, type, breed, age, gender, color, description, image) VALUES (:name, :type, :breed, :age, :gender, :color, :description, :image)";
                $statement = $db->prepare($query);

                $statement->bindvalue(':name', $name);
                $statement->bindvalue(':type', $type);
                $statement->bindvalue(':breed', $breed);
                $statement->bindvalue(':age', $age);
                $statement->bindvalue(':gender', $gender);
                $statement->bindvalue(':color', $color);
                $statement->bindvalue(':description', $description);
                $statement->bindvalue(':image', $target_file);

                $statement->execute();

                header("Location: index.php");
                exit;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }

        } else {
            if (strlen($name) < 1) {
                $errorName = 'Please input at least one character in the name';
            }
            if (strlen($type) < 1) {
                $errorType = 'Please input at least one character in the type';
            }
            if (strlen($breed) < 1) {
                $errorBreed = 'Please input at least one character in the breed';
            }
            if ($age <= 0) {
                $errorAge = 'Please input a valid age';
            }
            if (strlen($gender) < 1) {
                $errorGender = 'Please input at least one character in the gender';
            }
            if (strlen($color) < 1) {
                $errorColor = 'Please input at least one character in the color';
            }
            if (strlen($description) < 1) {
                $errorDescription = 'Please input at least one character in the description';
            }
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="main.css">
    <title>FurEver Winnipeg - Add Animal</title>
</head>
<body>
    <?php include('header.php'); ?> 

    <h3>Add a New Animal</h3>
    <form method="post" action="add_animal.php" enctype="multipart/form-data">
        <label for="name">Name</label>
        <input id="name" name="name">
        <p class="error_post">
            <?php if(!empty($errorName)){ echo $errorName; } ?>
        </p>

        <label for="type">Type</label>
        <input id="type" name="type">
        <p class="error_post">
            <?php if(!empty($errorType)){ echo $errorType; } ?>
        </p>

        <label for="breed">Breed</label>
        <input id="breed" name="breed">
        <p class="error_post">
            <?php if(!empty($errorBreed)){ echo $errorBreed; } ?>
        </p>

        <label for="age">Age</label>
        <input type="number" id="age" name="age">
        <p class="error_post">
            <?php if(!empty($errorAge)){ echo $errorAge; } ?>
        </p>

        <label for="gender">Gender</label>
        <input id="gender" name="gender">
        <p class="error_post">
            <?php if(!empty($errorGender)){ echo $errorGender; } ?>
        </p>

        <label for="color">Color</label>
        <input id="color" name="color">
        <p class="error_post">
            <?php if(!empty($errorColor)){ echo $errorColor; } ?>
        </p>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"></textarea>
        <p class="error_post">
            <?php if(!empty($errorDescription)){ echo $errorDescription; } ?>
        </p>

        <label for="image">Upload Image</label>
        <input type="file" id="image" name="image">
        <p class="error_post">
            <?php if(!empty($errorImage)){ echo $errorImage; } ?>
        </p>

        <input type="submit" value="Add Animal">
    </form>

    <div id="footer">
        Copywrong 2024 - No Rights Reserved
    </div> 
</body>
</html>
