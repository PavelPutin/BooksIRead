<?php
session_start();
require_once $_SERVER["HTTP_HOST"] . '/../' . "config.php";

unset($_SESSION['error_text_len']);
$text = $_POST['text'];
if (strlen($text) == 0) {
    $_SESSION['error_text_len'] = "Введите текст комментария";
    header('Location:' . getURI('book.php?book=' . $_POST['bookId']));
    exit;
}
$query = "INSERT INTO comments (userId, bookId, text) VALUES (:userId, :bookId, :text)";
$query = $booksIReadDB->prepare($query);
$query->bindParam('userId', $_SESSION['user_id']);
$query->bindParam('bookId', $_SESSION['bookId']);
$query->bindParam('text', $text);
$query->execute();
header('Location:' . getURI('book.php?book=' . $_SESSION['bookId']));
exit;