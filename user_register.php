<?php
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
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Simple validation
    if ($password !== $confirm_password) {
        die("Password and confirm password do not match.");
    }

    // Simple validation
    if (empty($user_name) || empty($password) || empty($confirm_password)) {
        die("Please fill in all required fields.");
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $query = "INSERT INTO users (user_name, password, age, gender, pet_experience, contact, address) VALUES (:user_name, :password, :age, :gender, :pet_experience, :contact, :address)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':password', $hashed_password);
    $statement->bindValue(':age', $age);
    $statement->bindValue(':gender', $gender);
    $statement->bindValue(':pet_experience', $pet_experience);
    $statement->bindValue(':contact', $contact);
    $statement->bindvalue(':address', $address);
    
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
            <input type="text" id="user_name" name="user_name" value="<?php echo (isset($_GET['user_name']))? htmlspecialchars($_GET['user_name']):"" ?>" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <label for="age">Age</label>
            <input type="age" id="age" name="age">

            <label for="gender">Gender</label>
            <input type="gender" id="gender" name="gender">

            <label for="pet_experience">Pet Experience</label>
            <input type="pet_experience" id="pet_experience" name="pet_experience">

            <label for="contact">Contact</label>
            <input type="contact" id="contact" name="contact">

            <label for="address">Address</label>
            <input type="address" id="address" name="address">

            <input type="submit" value="Register">
        </form>

        <?php include('footer.php'); ?>

    </div>
</body>
</html>
