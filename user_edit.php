<?php

    require('connect.php');   

    if(isset($_GET['user_id'])) {
       $user_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);

       if($user_id === false || $user_id <= 0) {
           die('No user found with the provided ID.');
           exit;
       }

       $query = "SELECT * FROM users WHERE user_id = :user_id";
       $statement = $db->prepare($query);
       $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
       $statement->execute();
       $user = $statement->fetch(PDO::FETCH_ASSOC);

       if(!$user) {
           die('No user data');
           exit;
       }
    }

    if ($_POST) {

        if(isset($_POST['delete'])) {
            $user_id = $_POST['user_id']; 

            $query = "DELETE FROM users WHERE user_id = :user_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $statement->execute();

            header("Location: admin.php");
            exit;
        }

        if(isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
            $user_id = $_POST['user_id'];
            $user_id = $_POST['user_id']; // This line is to get the user_id, or it won't update
            $name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
           $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $pet_experience = filter_input(INPUT_POST, 'pet_experience', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_NUMBER_INT);
           $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL); 
           
           if ($password !== $confirm_password) {
               echo "Error: Passwords do not match.";
               exit;

           } else {

               $hashed_password = password_hash($password, PASSWORD_DEFAULT);

               $query = "UPDATE users SET user_name = :user_name, password = :password, age = :age, gender = :gender, pet_experience = :pet_experience, contact = :contact, email_address = :email_address WHERE user_id = :user_id";
               $statement = $db->prepare($query);
               $statement->bindValue(':user_name', $name);
               $statement->bindValue(':password', $hashed_password);
               $statement->bindValue(':age', $age);
               $statement->bindValue(':gender', $gender);
               $statement->bindValue(':pet_experience', $pet_experience);
               $statement->bindValue(':contact', $contact);
               $statement->bindValue(':email_address', $email_address);
               $statement->bindValue(':user_id', $user_id);

               if ($statement->execute()) {
                   header("Location: admin.php");
                   exit;
               } else {
                   echo "Update failed. Please try again.";
                   exit;
               }
           }
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
    <title>User Edit</title>
</head>
<body>
    <div id="wrapper">
        <?php include('header.php'); ?> 
        <h3>Edit Account</h3>

        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>

            <?php if (isset($user_id) && $user_id && isset($user)): ?>
                <form method="post" action="user_edit.php">

                    <input type="hidden" id="user_id" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">


                    <label for="user_name">Username</label>
                    <input type="text" id="user_name" name="user_name" value="<?= htmlspecialchars($user['user_name']) ?>" required>
                    
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>

                    <label for="age">Age</label>
                    <input type="age" id="age" name="age" value="<?php echo $user['age'] ?>">

                    <label for="gender">Gender</label>
                    <input type="gender" id="gender" name="gender" value="<?php echo $user['gender'] ?>">

                    <label for="pet_experience">Pet Experience</label>
                    <input type="pet_experience" id="pet_experience" name="pet_experience" value="<?php echo $user['pet_experience'] ?>">

                    <label for="contact">Contact</label>
                    <input type="contact" id="contact" name="contact">

                    <label for="email_address">Email Address</label>
                    <input type="email_address" id="email_address" name="email_address" value="<?php echo $user['email_address'] ?>">

                    <input type="submit" value="Update">
                    
                </form>

                <form method="post" action="user_edit.php">
                    <input type="hidden" id="user_id" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            <?php else: ?>
                <p>No user selected. <a href="admin.php">Manage users</a></p>
            <?php endif ?>

        <?php else: ?>
            <p>You don't have permission to edit this page.</p>
        <?php endif; ?>

        <?php include('footer.php'); ?>

    </div>
</body>
</html>

