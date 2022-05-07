<?php
$title = "Обо мне";
require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
require_once getURI("components/header.php");
?>

<main>
    <section class="about">
        <div class="container">
            <div class="flex">
                <img class="my-photo" src="<?php echo getURI("img/моя%20фотография.jpg") ?>" alt="автор сайта">

                <div class="column">
                    <h2 class="my-name">Путин Павел Александрович</h2>

                    <div class="whoiam">Студент 1 курса, 5 группы <a href="https://www.cs.vsu.ru/" target="_blank">Факультета компьютерных наук</a> <a href="https://www.vsu.ru/" target="_blank">Воронежского государственного университета</a></div>

                    <div class="contacts">
                        <p>Контакты:</p>

                        <ul class="social-list">
                            <li class="social-item VK"><a href="https://vk.com/pavelputin2003" target="_blank" class="social-link">ВКонтакте</a></li>
                            <li class="social-item Email"><a href="mailto:pavelputin2003@yandex.ru" target="_blank" class="social-link">pavelputin@yandex.ru</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="site-goal">
                <p>Я сделал этот сайт, чтобы выполнить задание по web-теху.</p>

                <p>Основаня тема - книги, которые я читал, читаю и, возможно, захочу прочесть. Может быть, после окончания курса web-теха я продолжу его развивать, чтобы, во-первых, облегчить ведение своей электронной библиотеки и, во-вторых, время о времени освежать в памяти прочитанное мною.</p>
            </div>
        </div>
    </section>
</main>
<?php
require_once getURI("components/footer.php");
?>