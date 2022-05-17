<?php
session_start();
$title = 'Log in';
require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
require_once getURI("components/header.php");
?>

<main>
    <form class="userForm" action="<?= getURI("checkLogin.php") ?>" method="post">
        <div class="formGroup">
            <label for="email">Ваша почта:</label>
            <input name="email" id ="email" type="email" value="<?php
            if (isset($_SESSION['email'])) {
                echo $_SESSION['email']; } ?>"
                   required>
            <div class="error-box"><?php
                if (isset($_SESSION['error_login'])) {
                    echo $_SESSION['error_login'];
                } ?></div>
        </div>

        <div class="formGroup">
            <label for="password">Пароль:</label>
            <input name="password" id ="password" type="password" required>
        </div>

        <div class="formGroup">
            <input type="submit" value="Войти">
            <a href="<?= getURI('register.php')?>">Зарегистрироваться</a>
        </div>
    </form>
</main>

<?php
require_once getURI("components/footer.php");
?>
