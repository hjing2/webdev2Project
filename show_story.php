<?php
    require('connect.php');

    if (isset($_GET['story_id'])) {
        $story_id = filter_var($_GET['story_id'], FILTER_SANITIZE_NUMBER_INT);

        if ($story_id === false || $story_id <= 0) {
            header("Location: story_list.php");
            exit;
        }

        $query = "SELECT * FROM stories WHERE story_id = :story_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':story_id', $story_id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch();

        if (!$row) {
            header("Location: story_list.php");
            exit;
        }
    } else {
        header("Location: story_list.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Show Story - <?= $row['title'] ?></title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div id="animal_wrapper">
        <?php include('header.php'); ?> 

        <main>       
            <?php include('sidebar.php'); ?>

            <div class="rightside">

                <h3> <?= $row['title'] ?></h3>
                <p>
                    <small>
                    <?php
                        $formattedDate = date("F d, Y, h:i A", strtotime($row['publish_date']));
                        echo $formattedDate;
                    ?>
                    </small>
                </p>

                <div id="story_details">                  
                    <p class="story_content"><?= $row['content'] ?></p>
                </div>

            </div>
        </main>

        <?php include('footer.php'); ?>
    </div>
</body>
</html>