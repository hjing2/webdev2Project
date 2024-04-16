<?php
    session_start();
    require('connect.php');


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 首先检查验证码是否输入正确
        $_SESSION['captcha_error'] = Null;
        $_SESSION['input_values']['comment'] = $_POST['comment'];
        $_SESSION['input_values']['user_name'] = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        
        if ($_POST['captcha_input'] !== $_SESSION['captcha']) {
            $_SESSION['captcha_error'] = 'Incorrect CAPTCHA. Please try again.';
            header("Location: show_animal.php?animal_id={$_POST['animal_id']}");
            exit;
        }
        
        // 验证码正确后，处理用户提交的评论
        else {

            $_SESSION['input_values'] = array();


            if (isset($_POST['comment'], $_POST['animal_id']) && !empty($_POST['comment'])) {
                $comment = filter_var($_POST['comment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $animal_id = filter_var($_POST['animal_id'], FILTER_SANITIZE_NUMBER_INT);
                $user_name = null;
                $user_id = null; 

                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                } elseif (isset($_POST['user_name'])) {
                    $user_name = filter_var($_POST['user_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                } else {
                    header("Location: show_animal.php?animal_id=" . $animal_id);
                    exit;
                }

                $query = "
                    INSERT INTO comments (animal_id, user_id, user_name, content) 
                    VALUES (:animal_id, :user_id, :user_name, :comment)
                ";
                $statement = $db->prepare($query);
                $statement->bindValue(':animal_id', $animal_id);
                $statement->bindValue(':user_id', $user_id);
                $statement->bindValue(':user_name', $user_name);
                $statement->bindValue(':comment', $comment);
                $statement->execute();

                header("Location: show_animal.php?animal_id=" . $animal_id);
                exit;
            }
        }
    }
?>