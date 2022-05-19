<?php
session_start();
$title = 'Registration';
require_once $_SERVER["HTTP_HOST"] . '/../' . "config.php";
require_once getURI("components/header.php");
?>

<main>
    <form class="userForm" action="<?= getURI("checkRegister.php") ?>" method="post">
        <div class="formGroup">
            <label for="name">Ваш логин:</label>
            <input name="name" id ="name" type="text" pattern="[a-zA-Z0-9а-яА-яЁё]+" value="<?php
            if (isset($_SESSION['username'])) {
                echo $_SESSION['username']; } ?>" required>
        </div>
        <div class="formGroup">
            <label for="email">Ваша почта:</label>
            <input name="email" id ="email" type="email" value="<?php
                if (isset($_SESSION['email'])) {
                    echo $_SESSION['email']; } ?>"
        required>
            <div class="error-box"><?php
                if (isset($_SESSION['error_email'])) {
                    echo $_SESSION['error_email'];
                } ?></div>
        </div>
        <div class="formGroup">
            <label for="password">Пароль:</label>
            <input name="password" id ="password" type="password" required>
        </div>
        <div class="formGroup">
            <label for="password_repeat">Повтор пароля:</label>
            <input name="password_repeat" id ="password_repeat" type="password" required>
            <div class="error-box"><?php
                if (isset($_SESSION['error_password'])) {
                    echo $_SESSION['error_password'];
                } ?></div>
        </div>
        <div class="formGroup">
            <input type="submit" value="Зарегистрироваться">
        </div>
    </form>
</main>

<?php
require_once getURI("components/footer.php");
?>
