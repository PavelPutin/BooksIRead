<?php
function getShortName($name, $surname, $patronymic) {
    return $surname . " " . mb_substr($name, 0, 1) . "." . mb_substr($patronymic, 0, 1) . ".";
}
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
            </div>

            <div class="column">
                <h1 class="book-title"><?= $book['title']; ?></h1>

                <table class="book-information">
                    <tr>
                        <th>Издание</th>
                        <td>
                            <?
                            if ($book['edition']) {
                                echo $book['edition'];
                            } else {
                                echo '-';
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Год издания</th>
                        <td><?= $book['yearEdition'] ?></td>
                    </tr>
                    <tr>
                        <th>Автор</th>
                        <td><?= getShortName($author['name'], $author['surname'], $author['patronymic']) ?></td>
                    </tr>
                    <tr>
                        <th>Издательство</th>
                        <td>
                            <?
                            if ($book['publishingHouse']) {
                                echo $book['publishingHouse'];
                            } else {
                                echo '-';
                            } ?>
                        </td>
                    </tr>
                </table>

                <div class="annotation">
                    <?= $book['description'] ?>
                </div>
            </div>
        </div>
    </section>

    <section class="my-review">
        <div class="container">
            <div class="comment">
                <h2>Мой комментарий:</h2>
                <p><?= $book['review'] ?></p>
            </div>
            <div class="rating">
                <div>Оценка:</div>
                <div class="value"><?= $book['rating'] ?></div>
            </div>
        </div>
    </section>
</main>

<script src=<?php echo getURI("../slider.js"); ?>></script>
<?php
require_once getURI("components/footer.php");
?>