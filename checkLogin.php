<?php
session_start();
require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
require_once getURI("config.php");

unset($_SESSION['error_login']);

$email= $_POST['email'];
$password = $_POST['password'];

$query = $booksIReadDB->prepare("SELECT * FROM users WHERE email=:email");
$query->bindParam("email", $email);
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);
if (!$result) {
    $_SESSION['error_login'] = 'Неверный логин или пароль';
    header('Location:' . getURI('login.php'));
    exit;
} else {
    if (password_verify($password, $result['password'])) {
        $_SESSION['user_id'] = $result['id'];
        header('Location:' . getURI('index.php'));
        exit;
    } else {
        $_SESSION['error_login'] = 'Неверный логин или пароль';
        header('Location: ' . getURI('login.php'));
        exit;
    }
}
?>
