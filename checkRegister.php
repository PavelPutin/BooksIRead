<?php
    session_start();

    unset($_SESSION['error_email']);
    unset($_SESSION['error_password']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);


require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
    require_once getURI("config.php");

    $username = $_POST['name'];
    $_SESSION['username'] = $username;

    $email = $_POST['email'];
    $_SESSION['email'] = $email;

    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    $password_hash = md5($password);

    $query = $booksIReadDB->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam('email', $email,  PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $_SESSION['error_email'] = 'Такой адрес уже существует';
        header('Location: register.php');
        exit;
    }
    if ($password != $password_repeat) {
        $_SESSION['error_password'] = 'Вы неправильно повторили пароль';
        header('Location: register.php');
        exit;
    }
    if ($query->rowCount() == 0) {
        $query = $booksIReadDB->prepare("INSERT INTO users(name, pass, email) VALUES (:name, :pass, :email)");
        $query->bindParam('name', $username, PDO::PARAM_STR);
        $query->bindParam('pass', $password_hash, PDO::PARAM_STR);
        $query->bindParam('email', $email, PDO::PARAM_STR);
        $result = $query->execute();
        header('Location: index.php');
        exit;
    }
