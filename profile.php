<?php
session_start();
require_once $_SERVER["HTTP_HOST"] . '/../' . "config.php";
unset($_SESSION['error_delete']);

if (isset($_POST['deleteProfile'])) {
    $query = 'SELECT users.pass FROM users WHERE id = ?';
    $query = $booksIReadDB->prepare($query);
    $query->execute([$_SESSION['user_id']]);
    $password = $query->fetch(PDO::FETCH_ASSOC);

    if (md5($_POST['password']) ==  $password['pass']) {
        $query = 'DELETE FROM users WHERE id = ?';
        $query = $booksIReadDB->prepare($query);
        $query->execute([$_SESSION['user_id']]);

        unset($_SESSION['user_id']);
        unset($_SESSION['username']);

        header('Location:' . getURI('index.php'));
        exit;
    } else {
        $_SESSION['error_delete'] = 'Неверный пароль';
    }
}

if (isset($_POST['changeUserName'])) {
    $_SESSION['username'] = $_POST['newUserName'];
    $query = 'UPDATE users SET name = ? WHERE id = ?';
    $query = $booksIReadDB->prepare($query);
    $query->execute([$_SESSION['username'], $_SESSION['user_id']]);
    unset($_POST['changeUserName']);
}

$title = 'Профиль ' . $_SESSION['username'];
require_once getURI("components/header.php");
?>

<main>
    <section>
        <div class="container">
            <div class="username">
                <h1><?= $_SESSION['username'] ?></h1>
                <form action="<?= getURI('profile.php') ?>" method="post">
                    <label for="newUserName">Поменять логин:</label>
                    <input id="newUserName" type="text" name="newUserName">
                    <input name="changeUserName" type="submit" value="Изменить">
                </form>

                <h3>Удаление профиля</h3>
                <form action="<?= getURI('profile.php') ?>" method="post">
                    <label for="password">Введите пароль:</label>
                    <input id="password" name="password" type="password" required>
                    <input name="deleteProfile" type="submit" value="Удалить профиль">
                    <div><?= (isset($_SESSION['error_delete']) ? $_SESSION['error_delete'] : '') ?></div>
                </form>
            </div>
        </div>

    </section>
</main>

<?php
require_once getURI("components/footer.php");
?>
