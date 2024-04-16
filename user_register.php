<?php

session_start();

require('connect.php');

if ($_POST && isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Add these new lines
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pet_experience = filter_input(INPUT_POST, 'pet_experience', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email_address = filter_input(INPUT_POST, 'email_address', FILTER_SANITIZE_EMAIL);

    // Simple validation
    if ($password !== $confirm_password) {
        $_SESSION['error_password_not_match'] = 'Password and confirm password do not match.';
        $_SESSION['input_values']['user_name'] = $user_name;
        $_SESSION['input_values']['age'] = $age;
        $_SESSION['input_values']['gender'] = $gender;
        $_SESSION['input_values']['pet_experience'] = $pet_experience;
        $_SESSION['input_values']['contact'] = $contact;
        $_SESSION['input_values']['email_address'] = $email_address;
        header("Location: user_register.php");
        exit;
    }

    // Simple validation
    // if (empty($user_name) || empty($password) || empty($confirm_password)) {
    //     $error_userpassword_empty="Please fill in all required fields.";
    //     exit;
    // }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $query = "INSERT INTO users (user_name, password, age, gender, pet_experience, contact, email_address) VALUES (:user_name, :password, :age, :gender, :pet_experience, :contact, :email_address)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':password', $hashed_password);
    $statement->bindValue(':age', $age);
    $statement->bindValue(':gender', $gender);
    $statement->bindValue(':pet_experience', $pet_experience);
    $statement->bindValue(':contact', $contact);
    $statement->bindvalue(':email_address', $email_address);
    
    if ($statement->execute()) {
        // Get the user_id of the newly inserted user
        $user_id = $db->lastInsertId();

        // if ($user_id) {
        //     // Update jingblog table with the user_id
        //     $updateQuery = "UPDATE jingblog SET user_id = (SELECT id FROM jingblogusers WHERE user_name = :user_name) ";
        //     $updateStatement = $db->prepare($updateQuery);
        //     $updateStatement->bindValue(':user_name', $user_name);
        //     $updateStatement->execute();

        echo "Registration successful! You can now <a href='login.php'>login</a>.";
        header("Location: index1.php");
        exit;
        // } else {
        //     echo "Failed to get user ID. Registration failed.";
        // }
    } else {
        echo "Registration failed. Please try again.";
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
    <title>User Registration</title>
</head>
<body>
    <div id="wrapper">
        <?php include('header.php'); ?>

        <h3>Create Account</h3>
        <form method="post" action="user_register.php">
            <label for="user_name">Username</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo isset($_SESSION['input_values']['user_name']) ? $_SESSION['input_values']['user_name'] : ''; ?>" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <p class="error_add_user">
                <?php if(isset($_SESSION['error_password_not_match'])){ echo $_SESSION['error_password_not_match']; } ?>
            </p>

            <label for="age">Age</label>
            <input type="age" id="age" name="age"  value="<?php echo isset($_SESSION['input_values']['age']) ? $_SESSION['input_values']['age'] : ''; ?>" >

            <label for="gender">Gender</label>
            <input type="gender" id="gender" name="gender"  value="<?php echo isset($_SESSION['input_values']['gender']) ? $_SESSION['input_values']['gender'] : ''; ?>" >

            <label for="pet_experience">Pet Experience</label>
            <input type="pet_experience" id="pet_experience" name="pet_experience" value="<?php echo isset($_SESSION['input_values']['pet_experience']) ? $_SESSION['input_values']['pet_experience'] : ''; ?>" >

            <label for="contact">Contact</label>
            <input type="contact" id="contact" name="contact"  value="<?php echo isset($_SESSION['input_values']['contact']) ? $_SESSION['input_values']['contact'] : ''; ?>" >

            <label for="email_address">Email Address</label>
            <input type="email_address" id="email_address" name="email_address"  value="<?php echo isset($_SESSION['input_values']['email_address']) ? $_SESSION['input_values']['email_address'] : ''; ?>" >

            <input type="submit" value="Register">
        </form>

        <?php include('footer.php'); ?>

    </div>
</body>
</html>
