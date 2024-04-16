<?php
    require('connect.php');

    if ($_POST) {
        $animal_id = filter_input(INPUT_POST, 'animal_id', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = $_POST['content'];

        if (!empty($title) && !empty($content)) {
            $query = "INSERT INTO stories (title, content, publish_date) VALUES ( :title, :content, NOW())";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->execute();

            header("Location: story_list.php");
        }
    }

    $animals_query = "SELECT * FROM animals";
    $animals_statement = $db->prepare($animals_query);
    $animals_statement->execute();
    $animals = $animals_statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="main.css">
    <title>Add New Animal Story</title>
    <script src="https://cdn.tiny.cloud/1/9zdhq4t44vot7n723lfjq3gv8bzr1uz4lyxo995eojfcz09f/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#content'
      });
    </script>
</head>
<body>
    <?php include('header.php'); ?> 

    <h3>Add a New Animal Story</h3>

    <form method="post" action="add_story.php" enctype="multipart/form-data">

       <!--  <label for="animal_id">Animal</label>
        <select id="animal_id" name="animal_id">
          <?php foreach ($animals as $animal) : ?>
            <option value="<?= $animal['animal_id']; ?>"><?= $animal['name']; ?></option>
          <?php endforeach; ?>
        </select> -->

        <label for="title">Story Title</label>
        <input id="title" name="title">

        <label for="content">Story Content</label>
        <textarea id="content" name="content"></textarea>

        <input type="submit" value="Add Story">
    </form>

    <?php include('footer.php'); ?>
</body>
</html