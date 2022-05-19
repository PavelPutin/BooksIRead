<?php
session_start();
require_once $_SERVER["HTTP_HOST"] . '/../' . "config.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $title ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo getURI('style.css');?>">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="<?php echo getURI('index.php');?>">BooksIRead</a>
        </div>

        <nav class="site-navigation">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="<?= getURI('index.php') ?>" class="nav-anchor nav-anchor_active">Каталог</a>
                </li>
                <li class="nav-item">
                    <a href="<?= getURI('about.php') ?>" class="nav-anchor">Обо мне</a>
                </li>
                <li class="nav-item">
                    <a href="<?= getURI('register.php') ?>" class="nav-anchor">Зарегистрироваться</a>
                </li>
                <li class="nav-item">
                    <a href="<?= getURI('login.php') ?>" class="nav-anchor">
                        <?= (isset($_SESSION['user_id']) ? $_SESSION['username'] : 'Войти') ?>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
