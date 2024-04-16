<?php
    require('connect.php');
    require('header.php');

    define('ADMIN_LOGIN', 'Wally');
    define('ADMIN_PASSWORD', 'mypass');

    if ($_POST && isset($_POST['user_name']) && isset($_POST['password'])) {
        $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($user_name === ADMIN_LOGIN && $password === ADMIN_PASSWORD) {
            $_SESSION['is_admin'] = true; 
            header("Location: login_message.php");
            exit;
        }

        $query = "SELECT * FROM users WHERE user_name = :user_name";
        $statement = $db->prepare($query);
        $statement->execute(array(':user_name' => $user_name));

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['message'] = 'Login successfully';
            
            header("Location: login_message.php");
            exit;
        } else {
            $login_error = "Invalid username or password. Please try again.";
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
    <title>User Login</title>
</head>
<body>
    <div id="wrapper">
        
        <h3>Login</h3>
        <?php if (isset($login_error)): ?>
            <p><?= $login_error ?></p>
        <?php endif; ?>
        
        <form method="post" action="login.php">
            <label for="user_name">Username</label>
            <input type="text" id="user_name" name="user_name" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>

        <p class="register_notice">If you don't have an user account, please click <a href="user_register.php">here</a> to register a new account.</p>

        <?php include('footer.php'); ?>

    </div>
</body>
</html>