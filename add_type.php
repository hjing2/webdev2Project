<?php
    require('connect.php');

    if ($_POST) {
        $type = filter_input(INPUT_POST, 'type_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!empty($type)) {
            $query = "INSERT INTO types (type_name) VALUES (:type_name)";
            $statement = $db->prepare($query);
            $statement->bindValue(':type_name', $type);
            $statement->execute();

            header("Location: admin.php");
            exit();
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

        <h3>Add a New Animal Type</h3>
        <form method="post" action="add_type.php">
          <label for="type_name">Type:</label>
          <input type="text" id="type_name" name="type_name" value="<?= isset($_POST['type_name']) ? htmlspecialchars($_POST['type_name']) : "" ?>" required>
          <input type="submit" value="Add Type">
        </form>
    </body>
</html>