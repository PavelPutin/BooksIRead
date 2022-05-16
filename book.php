<?php
$bookId = $_GET['book'];

try {
    $booksIReadDB = new PDO('mysql:host=localhost;dbname=booksireaddb', 'root', '');
    $book = $booksIReadDB->prepare("SELECT
        	books.title,
			books.description,
			books.rating,
			books.dateStartReading,
			books.dateFinishReading,
			books.edition,
			books.yearEdition,
			books.publishingHouse,
			books.review
		FROM
		    books
		WHERE
		    books.id = ?");
    $book->execute([$bookId]);
    $book = $book->fetch();

    $title = $book['title'];
    require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
    require_once getURI("components/header.php");

    $author = $booksIReadDB->prepare("SELECT
            authors.name,
            authors.surname,
            authors.patronymic
        FROM
            authors
        INNER JOIN books ON authors.id = books.authorId
        WHERE
            books.id = ?");
    $author->execute([$bookId]);
    $author = $author->fetch();

    $photos = $booksIReadDB->prepare("SELECT photos.photoURI FROM photos WHERE photos.bookId = ?");
    $photos->execute([$bookId]);
} catch (PDOException $exception) {
    print $exception->getMessage() . "<br>";
    die();
}
?>

<main>
    <section class="book-card">
        <div class="container">
            <div class="img-slider column">
                <?php
                    if ($photos->rowCount() != 0) {
                        echo '<ul class="img-slider-list">';
                        while ($row = $photos->fetch()) {
                            $photoURI = getURI($row['photoURI']);
                            echo '<li class="img-slider-item">';
                            echo '<img class="book-cover" src="' . $photoURI . '" alt="">';
                            echo '</li>';

                        }
                    }
                ?>
<!--                <ul class="img-slider-list">-->
<!--                    <li class="img-slider-item">-->
<!--                        <img class="book-cover" src="--><?php //echo getURI($photoURI) ?><!--" alt="Учебник логики для средней школы С.Н. Виноградова">-->
<!--                    </li>-->
<!--                    <li class="img-slider-item">-->
<!--                        <img class="book-cover" src="--><?php //echo getURI("img/Оглавление1.jpg"); ?><!--" alt="Оглавление1">-->
<!--                    </li>-->
<!--                    <li class="img-slider-item">-->
<!--                        <img class="book-cover" src="--><?php //echo getURI("img/Оглавление2.jpg"); ?><!--" alt="Оглавление2">-->
<!--                    </li>-->
<!--                    <li class="img-slider-item">-->
<!--                        <img class="book-cover" src="--><?php //echo getURI("img/Оглавление3.jpg"); ?><!--" alt="Оглавление3">-->
<!--                    </li>-->
<!--                </ul>-->
            </div>

            <div class="column">
                <h1 class="book-title">"Логика", учебник для средней школы</h1>

                <table class="book-information">
                    <tr>
                        <th>Издание</th>
                        <td>восстановленное с оригинала 1954 года</td>
                    </tr>
                    <tr>
                        <th>Год издания</th>
                        <td>2020</td>
                    </tr>
                    <tr>
                        <th>Автор</th>
                        <td>С.Н. Виноградов</td>
                    </tr>
                    <tr>
                        <th>Издательство</th>
                        <td>Концептуал</td>
                    </tr>
                </table>

                <div class="annotation">
                    <p>ЦК ВКП(б) в постановлении "О преподавании логики и психологии в средней школе" от 3 декабря 1946 года признал совершенно ненормальным, что в средних школах не изучается логика и психология, и счел необходимым ввести в течение 4 лет, начиная с 1947/48 учебного года, преподавание этих предметов во всех школах Советского Союза.</p>
                    <p>В 1959 году преподавание логики в средней школе отменили. Предлагаем восполнить пробел и изучить логику, чтобы уметь правильно формулировать свои мысли. Это нужно каждому - будь то ученик школы или взрослый человек. Понимание логических законов поможет эффективно общаться с другими людьми и принесет успех в труде, карьере, личностном росте.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="my-review">
        <div class="container">
            <div class="comment">
                <h2>Мой комментарий:</h2>
                <p>Книга очень понравилась.</p>
            </div>
            <div class="rating">
                <div>Оценка:</div>
                <div class="value">5</div>
            </div>
        </div>
    </section>
</main>

<script src=<?php echo getURI("../slider.js"); ?>></script>
<?php
require_once getURI("components/footer.php");
?>