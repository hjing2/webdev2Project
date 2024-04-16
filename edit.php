<?php

    require('connect.php');

    require 'C:\xampp\htdocs\wd2\assignments\Project\php-image-resize-master\php-image-resize-master\lib\ImageResize.php';
    require 'C:\xampp\htdocs\wd2\assignments\Project\php-image-resize-master\php-image-resize-master\lib\ImageResizeException.php';

    $type_query = "SELECT * FROM types";
    $type_statement = $db->prepare($type_query);
    $type_statement->execute();

    // $type_statement->bindvalue(':type_id', $type_id);

    $types = $type_statement->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET['animal_id'])) {
        $animal_id = filter_input(INPUT_GET, 'animal_id', FILTER_SANITIZE_NUMBER_INT);

        if($animal_id === false || $animal_id <= 0) {
            header("Location: index1.php");
            exit;
        }

        $query = "SELECT * FROM animals WHERE animal_id = :animal_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
        $statement->execute();
        $animal = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$animal) {
            header("Location: index1.php");
            exit;
        }
    }

    if ($_POST) {
        
        if(isset($_POST['delete'])) {
           
            $query = "DELETE FROM animals WHERE animal_id = :animal_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
            $statement->execute();

            header("Location: index1.php");
            exit;
        }

        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_NUMBER_INT);
        $breed = filter_input(INPUT_POST, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = $_POST["description"];
        // $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if (strlen($type_id) > 0 && strlen($breed) > 0 && $age > 0 && strlen($gender) > 0 && strlen($name) > 0 && strlen($description) > 0) {

            
        $image_dir = "uploads/";
        $image_path = $animal['image_path'];

        function file_upload_path($original_filename, $image_dir) {
            $current_folder = dirname(__FILE__);          
            $path_segments = [$current_folder, $image_dir, basename($original_filename)];           
            return join(DIRECTORY_SEPARATOR, $path_segments);
        }

        if ($_FILES['image']['size'] > 0) { 
            $image_temp_path = $image_dir . basename($_FILES["image"]["name"]);
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            $image_filename = $_FILES['image']['name'];
            $image_path = file_upload_path($image_filename,$image_dir);
            $actual_file_extension = pathinfo($image_path,PATHINFO_EXTENSION);
            if($check !== false) {
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $image_temp_path)){
                    $image_path = $image_temp_path;

                    try { 
                        $path_first_part = pathinfo($image_path, PATHINFO_FILENAME);
                        $image = new \Gumlet\ImageResize($image_path);

                        $image->resizeToWidth(400);

                        $resizedImage = file_upload_path($path_first_part. '_resized.'.$actual_file_extension, $image_dir);
                        $image->save($resizedImage);
                    } catch (\Gumlet\ImageResizeException $e) {
                        echo "";
                    }
                }else{
                  $errorMovingFile = "Sorry, there was an error moving your file.";
                }
            }else {
                $errorImageType = "File is not an image. Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } 

            if (isset($_POST['delete_image']) && $animal['image_path'] && file_exists($animal['image_path'])) {
                unlink($animal['image_path']);
                $animal['image_path'] = NULL; 
                $image_path = NULL; 
            }
            
            $query = "UPDATE animals SET type_id = :type_id, breed = :breed, age = :age, gender = :gender, name = :name, description = :description, image_path = :image_path WHERE animal_id = :animal_id";
            $statement = $db->prepare($query);

            $statement->bindValue(':type_id', $type_id);
            $statement->bindValue(':breed', $breed);
            $statement->bindValue(':age', $age);
            $statement->bindValue(':gender', $gender);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':description', $description);
            $statement->bindvalue(':image_path', $image_path);
            $statement->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);

            $statement->execute();

            header("Location: index1.php");
            exit;

        } else {
            if (strlen($type_id) < 1) {
                $errorType = 'Please choose a type; if unknown, use "Unknown"';
            }
            if (strlen($breed) < 1) {
                $errorBreed = 'Please enter a breed; if unknown, use "Unknown"';
            }
            if (strlen($age) < 1) {
                $errorAge = 'Please enter a age; if unknown, use "Unknown"';
            }
            if (strlen($gender) < 1) {
                $errorGender = 'Please enter a gender; if unknown, use "Unknown"';
            }
            if (strlen($name) < 1) {
                $errorName = 'Please enter a name; if unknown, use "Unknown"';
            }
            if (strlen($description) < 1) {
                $errorDescription = 'Please enter a description; if unknown, use "Unknown"';
            }
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="main.css">
    <title>Edit Animal Information</title>
    <script src="https://cdn.tiny.cloud/1/9zdhq4t44vot7n723lfjq3gv8bzr1uz4lyxo995eojfcz09f/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#description'
      });
    </script>
</head>
<body>
    <?php include('header.php'); ?> 

    <h3>Edit Animal Information</h3>

    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>

        <?php if (isset($animal_id) && $animal_id && isset($animal)): ?>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="animal_id" value="<?= $animal['animal_id'] ?>">

                <label for="name">Name</label>
                <input id="name" name="name" value="<?= $animal['name'] ?>">
                <p class="error_post">
                    <?php if(isset($errorName) && !empty($errorName)){ echo $errorName; } ?>
                </p>
                
                <!-- <label for="type">Type</label>
                <select id="type" name="type" >
                    <option value="Cat" >Cat</option>
                    <option value="Dog" >Dog</option>
                    <option value="Rabbit" >Rabbit</option>
                    <option value="Fish">Fish</option>
                    <option value="Hamster">Hamster</option>
                    <option value="Snake">Snake</option>
                    <option value="Lizard">Lizard</option>
                    <option value="Parrot">Parrot</option>
                </select> -->
                <label for="type_id">Type</label>
                <select name="type_id" id="type_id">
                  <?php foreach ($types as $type) : ?>
                    <option value="<?= $type['type_id']; ?>"><?= $type['type_name']; ?></option>
                  <?php endforeach; ?>
                </select>
                <p class="error_type">
                    <?php if (isset($errorType) && !empty($errorType)) {
                        echo $errorType;
                    } ?>
                </p>

                <label for="breed">Breed</label>
                <input id="breed" name="breed" value="<?= $animal['breed'] ?>">
                <p class="error_post">
                    <?php if(isset($errorBreed) && !empty($errorBreed)){ echo $errorBreed; } ?>
                </p>

                <label for="age">Age</label>
                <input type="number" id="age" name="age" value="<?= $animal['age'] ?>">
                <p class="error_post">
                    <?php if(isset($errorAge) && !empty($errorAge)){ echo $errorAge; } ?>
                </p>

                <label for="gender">Gender</label>
                <select id="gender" name="gender" >
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                    <option value="Unknown">Unknown</option>
                </select>
                <p class="error_post">
                    <?php if(isset($errorGender) && !empty($errorGender)){ echo $errorGender; } ?>
                </p>

                <label for="description">Description</label>
                <textarea id="description" name="description"><?= $animal['description'] ?></textarea>
                <p class="error_post">
                    <?php if(isset($errorDescription) && !empty($errorDescription)){ echo $errorDescription; } ?>
                </p>

                <?php if (isset($animal['image_path']) && file_exists($animal['image_path'])) : ?>       
                    <label for="image">Current Image</label>
                    <img src="<?= $animal['image_path'] ?>" alt="<?= $animal['name'] ?>" style="max-width: 200px;">
                    <label for="delete_image">Delete Current Image</label>
                    <input type="checkbox" id="delete_image" name="delete_image">
                <?php else : ?>
                    <label for="image">Upload Image</label>
                    <input type="file" id="image" name="image">
                    <p class="error_post">
                        <?php 
                            if(isset($errorMovingFile) && !empty($errorMovingFile)){ 
                                echo $errorMovingFile; 
                            } 
                            if(isset($errorImageType) && !empty($errorImageType)) {
                                echo $errorImageType;
                            }
                        ?>
                    </p>
                <?php endif; ?>

                <input type="submit" value="Update">
                <input type="submit" name="delete" value="Delete">
            </form>
        <?php else: ?>
            <p>No animal selected. <a href="add_animal.php">Add a new animal with this link</a></p>
        <?php endif ?>

    <?php else: ?>
        <p>You don't have permission to edit this page.</p>
    <?php endif; ?>

    <?php include('footer.php'); ?>

</body>
</html>
