<?php
session_start();
require_once $_SERVER["HTTP_HOST"] . '/../' . "config.php";

if (isset($_GET['book'])) {
    $bookId = $_GET['book'];
}
else {
    $bookID = 0;
}

$_SESSION['bookId'] = $bookId;

$query = "SELECT
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
        books.id = ?";
$book = $booksIReadDB->prepare($query);
$book->execute([$bookId]);
$book = $book->fetch();
if (!$book) {
    $title = "Книга не найдена";
} else {
    $title = $book['title'];
}
require_once getURI("components/header.php");

$query = "SELECT
        authors.name,
        authors.surname,
        authors.patronymic
    FROM
        authors
    INNER JOIN books ON authors.id = books.authorId
    WHERE
        books.id = ?";
$author = $booksIReadDB->prepare($query);
$author->execute([$bookId]);
$author = $author->fetch();

$query = "SELECT photos.photoURI FROM photos WHERE bookId = ?";
$photos = $booksIReadDB->prepare($query);
$photos->execute([$bookId]);

$query = "SELECT
        comments.id,
        comments.text,
        comments.dateTime,
        comments.userId,
        users.name
    FROM comments
    INNER JOIN users ON comments.userId = users.id
    WHERE comments.bookId = ?";
$comments = $booksIReadDB->prepare($query);
$comments->execute([$bookId]);
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
                            echo getImgSliderItem($photoURI);
                        }
                        echo '</ul>';
                    }
                ?>
            </div>

            <div class="column">
                <h1 class="book-title"><?= $book['title']; ?></h1>

                <table class="book-information">
                    <tr>
                        <th>Издание</th>
                        <td><?= getStrOrPlaceholder($book['edition']) ?></td>
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
                        <td><?= getStrOrPlaceholder($book['publishingHouse']) ?></td>
                    </tr>
                </table>

                <div class="annotation"><?= $book['description'] ?></div>
            </div>
        </div>
    </section>

    <section class="my-review">
        <div class="container">
            <div class="my-comment">
                <h2>Мой комментарий:</h2>
                <p><?= $book['review'] ?></p>
            </div>
            <div class="rating">
                <div>Оценка:</div>
                <div class="value"><?= $book['rating'] ?></div>
            </div>
        </div>
    </section>

    <section class="comments">
        <div class="container">
            <h3>Комментарии</h3>
            <form class="userForm" action="<?= getURI("checkComment.php") ?>" method="post">
                <textarea name="text" id="comment_textarea" cols="30" rows="10" <?= returnStrIf(!isset($_SESSION['user_id']), 'disabled') ?>></textarea>
                <div class="comment_text_error"><?= returnStrIf(isset($_SESSION['error_text_len']), $_SESSION['error_text_len']) ?></div>
                <input type="submit" name="commentSubmit" value="Написать комментарий" <?= returnStrIf(!isset($_SESSION['user_id']), 'disabled') ?>>
            </form>

            <?php
                if ($comments->rowCount() == 0) {
                    echo "Нет комментариев";
                }

                $first = true;
                while ($comment = $comments->fetch(PDO::FETCH_ASSOC)) {
                    if (!$first) echo '<hr>';
                    $first = false;
                    echo getComment($comment);
                }
            ?>
        </div>
    </section>
</main>

<script src=<?php echo getURI("../slider.js"); ?>></script>
<?php
require_once getURI("components/footer.php");
?>