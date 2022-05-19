<?php
session_start();
require_once $_SERVER["HTTP_HOST"] . '/../' . "config.php";

unset($_SESSION['error_login']);
unset($_SESSION['email']);

$email= $_POST['email'];
$_SESSION['email'] = $email;
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
    if (md5($password) ==  $result['pass']) {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['name'];
        header('Location:' . getURI('index.php'));
        exit;
    } else {
        $_SESSION['error_login'] = 'Неверный логин или пароль';
        header('Location: ' . getURI('login.php'));
        exit;
    }
}
?>
