<?php
    require('connect.php');

    require 'C:\xampp\htdocs\wd2\assignments\Project\php-image-resize-master\php-image-resize-master\lib\ImageResize.php';
    require 'C:\xampp\htdocs\wd2\assignments\Project\php-image-resize-master\php-image-resize-master\lib\ImageResizeException.php';

        $type_query = "SELECT * FROM types";
        $type_statement = $db->prepare($type_query);
        $type_statement->execute();

        // $type_statement->bindvalue(':type_id', $type_id);
    
        $types = $type_statement->fetchAll(PDO::FETCH_ASSOC);

    if ($_POST) {

        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_NUMBER_INT);

        // $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $type_name = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $breed = filter_input(INPUT_POST, 'breed', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = $_POST["description"];

       
        $image_dir = "uploads/";
        $image_path = NULL;

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

        if (!empty($type_id) && strlen($breed) > 0 && $age > 0 && strlen($gender) > 0 && strlen($name) > 0 && strlen($description) > 0) {

            $query = "INSERT INTO animals (type_id, breed, age, gender, name, description, image_path) VALUES (:type_id, :breed, :age, :gender, :name, :description, :image_path)";
            $statement = $db->prepare($query);

            // $statement->bindvalue(':type', $type);
            $statement->bindvalue(':type_id', $type_id);
            $statement->bindvalue(':breed', $breed);
            $statement->bindvalue(':age', $age);
            $statement->bindvalue(':gender', $gender);
            $statement->bindvalue(':name', $name);
            $statement->bindvalue(':description', $description);
            $statement->bindvalue(':image_path', $image_path);

            $statement->execute();

            header("Location: index1.php");
        } else {   
            if (empty($type_id)) {
                $errorType = 'Please choose a type';
            }
            if (strlen($breed) < 1) {
                $errorBreed = 'Please enter a breed; if unknown, use "Unknown"';
            }
            if ($age <= 0) {
                $errorAge = 'Please enter a age; if unknown, use "Unknown"';
            }
            if (strlen($gender) < 1) {
                $errorGender = 'Please choose a gender; if unknown, use "Unknown"';
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
    <title>FurEver Winnipeg - Add Animal</title>
    <script src="https://cdn.tiny.cloud/1/9zdhq4t44vot7n723lfjq3gv8bzr1uz4lyxo995eojfcz09f/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#description'
      });
    </script>
</head>
<body>
    <?php include('header.php'); ?> 

    <h3>Add a New Animal</h3>
    <form method="post" action="add_animal.php" enctype="multipart/form-data">

        <label for="name">Name</label>
        <input id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "" ?>">
        <p class="error_post">
            <?php if(!empty($errorName)){ echo $errorName; } ?>
        </p>
        
        <label for="type_id">Type</label>
        <select name="type_id" id="type_id">
          <?php foreach ($types as $type) : ?>
            <option value="<?= $type['type_id']; ?>"><?= $type['type_name']; ?></option>
          <?php endforeach; ?>
        </select>
        <p class="error_post">
            <?php if(!empty($errorType)){ echo $errorType; } ?>
        </p>

        <label for="breed">Breed</label>
        <input id="breed" name="breed" value="<?= isset($_POST['breed']) ? htmlspecialchars($_POST['breed']) : "" ?>">
        <p class="error_post">
            <?php if(!empty($errorBreed)){ echo $errorBreed; } ?>
        </p>

        <label for="age">Age</label>
        <input type="number" id="age" name="age" value="<?= isset($_POST['age']) ? htmlspecialchars($_POST['age']) : "" ?>">
        <p class="error_post">
            <?php if(!empty($errorAge)){ echo $errorAge; } ?>
        </p>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" value="<?= isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : "" ?>">
            <option value="Female">Female</option>
            <option value="Male">Male</option>
            <option value="Unknown">Unknown</option>
        </select>
        <p class="error_post">
            <?php if(!empty($errorGender)){ echo $errorGender; } ?>
        </p>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" ><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : "" ?></textarea>
        <p class="error_post">
            <?php if(!empty($errorDescription)){ echo $errorDescription; } ?>
        </p>

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

        <input type="submit" value="Add Animal">
    </form>

    <?php include('footer.php'); ?> 
</body>
</html>
