<?php
    require('connect.php');
    session_start();

    if ($_POST && isset($_POST['user_name']) && isset($_POST['password'])) {
        $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM users WHERE user_name = :user_name";
        $statement = $db->prepare($query);
        $statement->execute(array(':user_name' => $user_name));
        // $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        // var_dump(password_verify($password, $user['password']));

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['message'] = 'Login successfully';
            echo $_SESSION['message'];
            header("Location: index1.php");
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
        <?php include('header.php'); ?>

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

        <?php include('footer.php'); ?>

    </div>
</body>
</html>