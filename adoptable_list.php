<?php

    require('connect.php');

    $type_query = "SELECT * FROM types";
    $type_statement = $db->prepare($type_query);
    $type_statement->execute();

    $types = $type_statement->fetchAll(PDO::FETCH_ASSOC);

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'animal_id';
    $direction = 'DESC';
    if ($sort == 'type' || $sort == 'age' || $sort == 'breed') {
       $direction = 'ASC';
    }

    $type_id = ($_GET && isset($_GET['type_id']) && $_GET['type_id'] != 'all') ? (int)$_GET['type_id'] : 'all';
    
    $query = "SELECT animals.*, types.type_name as type_name 
              FROM animals 
              JOIN types ON types.type_id = animals.type_id ";

    if ($type_id !== 'all') {
        $query .= "WHERE animals.type_id = :type_id ";
    }

    $query .= "ORDER BY " . $sort . " " . $direction;
    $statement = $db->prepare($query);

    if($type_id !== 'all') {
        $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    }

    $animals_per_page = 6;  
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $animals_per_page;

    if (isset($_GET['page'])) {
        $current_page = $_GET['page'];
    } else {
        $current_page = 1;
    }

    $query .= " LIMIT :limit OFFSET :offset"; 
    $statement =$db->prepare($query);
    if ($type_id !== 'all') {
        $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    }
    $statement->bindValue(':limit', $animals_per_page, PDO::PARAM_INT);
    $statement->bindValue(':offset', $offset, PDO::PARAM_INT);

    $statement->execute();
    $animals = $statement->fetchAll();

    $total_query = "SELECT COUNT(*) as total FROM animals";
    if($type_id !== 'all') {
        $total_query .= " WHERE type_id = :type_id";
    }
    $total_statement = $db->prepare($total_query);
    if($type_id !== 'all') {
        $total_statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    }
    $total_statement->execute(); 
    $total_animals = $total_statement->fetchColumn();
    $total_pages = ceil($total_animals / $animals_per_page);

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
            <?php include('sidebar.php'); ?>

            
            <div class="rightside">

                <?php if((isset($_SESSION['is_admin'])) || (isset($_SESSION['user_id']))) : ?>
                <div class="filters">
                    <div class="sort_by">
                        <form class="sort_form" action="adoptable_list.php" method="get">
                            <label for="sort">Sort by:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()">
                               <option value="type" <?= $sort == 'type' ? 'selected' : ' '  ?> >Animal Type</option>
                               <option value="age" <?= $sort == 'age' ? 'selected' : ' '  ?>>Animal Age</option>
                               <option value="breed" <?= $sort == 'breed' ? 'selected' : ' '  ?>>Animal Breed</option>
                            </select>          
                        </form>
                    </div>

                    <div class="type_category">
                        <form class="type_form" action="adoptable_list.php" method="get">
                            <label for="type_id">Choose Type:</label>
                            <select name="type_id" id="type_id" onchange="this.form.submit()">
                                <option value="all" <?= $type_id === 'all' ? 'selected' : '' ?>>All Types</option>
                                <?php foreach ($types as $type) : ?>
                                    <option value="<?= $type['type_id']?>" <?= $type_id === $type['type_id'] ? 'selected' : '' ?>>
                                        <?= $type['type_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>          
                        </form>
                    </div>
                </div>

               <?php endif; ?>

                <?php if (isset($_SESSION['is_admin'])): ?>
                    <div class="add_new_animal">
                        <p class="add_new_animal_message"><a href="add_animal.php">Add a new animal</a></p> 
                    </div>
                <?php endif; ?>

                <div id="animal_list">
                    <?php foreach($animals as $index => $animal): ?>
                        <div class="animal_info">
                            <h3><a href="show_animal.php?animal_id=<?= $animal['animal_id'] ?>"><?php echo $animal['name'] ?></a></h3>
                            <p>Animal Type: <?=  $animal['type_name'] ?></p>
                            <p>Animal Age: <?= $animal['age'] ?></p>
                            <p>Animal Breed: <?= $animal['breed'] ?> </p>
                            <img class="small_animal_image" src="<?= $animal['image_path'] ?>" alt="<?php echo $animal['name'] ?>">
                            <?php if (isset($_SESSION['is_admin'])): ?>
                                <p class="edit_animal_link_on_list_page"><a href="edit.php?animal_id=<?= $animal['animal_id'] ?>">Edit</a></p> 
                            <?php endif; ?>                            
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_pages > 1) : ?>
                    <div class="pagination">
                       <?php for($p=1; $p <= $total_pages; $p++): ?>
                          <a 
                             href="?page=<?php echo $p; ?>&type_id=<?php echo $type_id; ?>&sort=<?php echo "$sort"; ?>" 
                             class="<?php if($p == $current_page) { echo 'active'; } ?>"
                          >
                             <?php echo $p; ?>
                          </a>
                       <?php endfor ?>
                    </div>
                <?php endif; ?>
                
            </div>
        </main>

        <?php include('footer.php'); ?>
    </div>  
</body>
</html>