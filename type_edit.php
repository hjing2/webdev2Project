<?php
    require('connect.php');  

    if(isset($_GET['id'])) {
        $type_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        if($type_id === false || $type_id <= 0) {
            die('Invalid type id provided.');
            exit;
        }

        $query = "SELECT * FROM types WHERE type_id = :type_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
        $statement->execute();
        $type = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$type) {
            die('No type data found with the provided ID.');
            exit;
        }
    }
     
    if ($_POST) {
        if(isset($_POST['type_id']) && isset($_POST['type_name'])) {
            $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_NUMBER_INT);
            $name = filter_input(INPUT_POST, 'type_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $query = "UPDATE types SET type_name = :type_name WHERE type_id = :type_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':type_name', $name);
            $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
           
            if($statement->execute()) {
                header("Location: admin.php");
                exit;
            } else {
                echo "Update failed. Please try again.";
                exit;
            }
        }

        if(isset($_POST['delete'])) {
            $type_id = $_POST['type_id']; 

            $query = "DELETE FROM types WHERE type_id = :type_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
            $statement->execute();

            header("Location: admin.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Type Edit</title>
</head>
<body>
    <div id="wrapper">
        <?php include('header.php'); ?> 
        <h3>Edit Type</h3>

        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>

            <?php if (isset($type_id) && $type_id && isset($type)): ?>
                <form method="post" action="type_edit.php">
                    <input type="hidden" id="type_id" name="type_id" value="<?= htmlspecialchars($type['type_id']) ?>">
                    <label for="type_name">Type Name</label>
                    <input type="text" id="type_name" name="type_name" value="<?= htmlspecialchars($type['type_name']) ?>" required>                

                    <input type="submit" value="Update">                    
                </form>

                <form method="post" action="type_edit.php">
                    <input type="hidden" id="type_id" name="type_id" value="<?= htmlspecialchars($type['type_id']) ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            <?php else: ?>
                <p>No type selected. <a href="admin.php">Manage types</a></p>
            <?php endif ?>

        <?php else: ?>
            <p>You don't have permission to edit this page.</p>
        <?php endif; ?>

        <?php include('footer.php'); ?>

    </div>
</body>
</html>

