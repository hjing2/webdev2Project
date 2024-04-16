<?php

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // print_r($_SESSION);
?>


<div id="header">
    <div>
        <?php if (isset($_SESSION['user_id']) || isset($_SESSION['is_admin'])): ?>
            <p class="logout_link"><a href="logout.php">Log Out</a></p>
        <?php else: ?>
            <p class="login_link"><a href="login.php">Login/Register</a></p>
        <?php endif; ?>
    </div>
    <div>
        <h1><a href="index1.php">FurEver Winnipeg</a></h1>
        <form action="search_result.php" method="get" class="search_form">
            <input type="text" name="search" id="search" placeholder="Search" value="<?= isset($_GET['search']) ? $_GET['search'] : ' ' ?>" >
            <button type="submit">Search</button>
        </form>
    </div>
    
</div> 


<!-- <nav>
    <ul id="menu">
        <li><a href="adoptable_list.php" class="active">Animall List</a></li>
        <li><a href="add_animal.php">Add New Animals</a></li>
        <li><a href="user_register.php">Register New User</a></li>
    </ul>  
</nav> -->