<?php
session_start();
require_once getURI("subFunctions.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?php echo $title; ?></title>
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
                <li class="nav-item"><a href="<?php echo getURI('index.php');?>" class="nav-anchor nav-anchor_active">Каталог</a></li>
                <li class="nav-item"><a href="<?php echo getURI('about.php');?>" class="nav-anchor">Обо мне</a></li>
                <li class="nav-item"><a href="<?php echo getURI('register.php');?>" class="nav-anchor">Зарегистрироваться</a></li>
                <li class="nav-item"><a href="<?php echo getURI('login.php');?>" class="nav-anchor"><?
                        if ($_SESSION['user_id']) {
                            echo $_SESSION['username'];
                        }
                        else {
                            echo 'Войти';
                        }
                        ?></a></li>
            </ul>
        </nav>
    </div>
</header>
