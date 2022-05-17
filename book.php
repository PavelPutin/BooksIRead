<?php
session_start();
require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
require_once getURI("config.php");

function getShortName($name, $surname, $patronymic) {
    return $surname . " " . mb_substr($name, 0, 1) . "." . mb_substr($patronymic, 0, 1) . ".";
}
if (isset($_GET['book'])) {
    $bookId = $_GET['book'];
}
else {
    $bookID = 0;
}

$_SESSION['bookId'] = $bookId;

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

if (!$book) {
    $title = "Книга не найдена";
} else {
    $title = $book['title'];
}

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

function number($n, $titles) {
    $cases = array(2, 0, 1, 1, 1, 2);
    return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
}

function time2str($ts)
{
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return 'только что';
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return 'меньше минуты назад';
            if($diff < 120) return 'минуту назад';
            if($diff < 3600) return floor($diff / 60) . ' ' . number(floor($diff / 60), ['минуту', 'минуты', 'минут']) . ' назад';
            if($diff < 7200) return 'час назад';
            if($diff < 86400) return floor($diff / 3600) . ' ' . number(floor($diff / 60), ['час', 'часа', 'часов']) . ' назад';
        }
        if($day_diff == 1) return 'вчера';
        if($day_diff < 7) return $day_diff . ' дней назад';
        if($day_diff < 31) return ceil($day_diff / 7) . ' ' . number(ceil($diff / 60), ['день', 'дня', 'дней']) . ' назад';
        if($day_diff < 60) return 'в этом месяце';
        return date('F Y', $ts);
    }
    else {
        return '-';
    }
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
                            <?php
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
                            <?php
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
            <textarea name="text" id="comment_textarea" cols="30" rows="10"
                <?php
                    if (!isset($_SESSION['user_id'])) echo 'disabled';
                ?>></textarea>
            <div class="comment_text_error"><? if(isset($_SESSION['error_text_len'])) echo $_SESSION['error_text_len']?></div>
            <input type="submit" name="commentSubmit" value="Написать комментарий"<?php
                if (!isset($_SESSION['user_id'])) echo 'disabled';
            ?>>
            </form>

            <?php
                $query = "SELECT
                    comments.id,
                    comments.text,
                    comments.dateTime,
                    comments.userId,
                    users.name
                FROM comments
                INNER JOIN users ON comments.userId = users.id
                WHERE comments.bookId = :bookId";
                $comments = $booksIReadDB->prepare($query);
                $comments->bindParam('bookId', $bookId);
                $comments->execute();

                if ($comments->rowCount() == 0) {
                    echo "Нет комментариев";
                }

                $first = true;
                while ($comment = $comments->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div>
                            <div class='row'>
                                <span class='user_name'>" . $comment['name'] . "</span>
                                <span class='userId'>#" . $comment['userId'] . "</span>
                                <span class='creationTime'>" . date('d.m.Y', strtotime($comment['dateTime'])) . "</span>
                                <span class='relativeTime'>" . time2str(strtotime($comment['dateTime'])) . "</span>
                            </div>
                            <div class='row'>
                                <p class='comment_text'>" . $comment['text'] . "</p>
                            </div>
                        </div>";
                    if ($first) echo '<hr>';
                    $first = false;
                }
            ?>
        </div>
    </section>
</main>

<script src=<?php echo getURI("../slider.js"); ?>></script>
<?php
require_once getURI("components/footer.php");
?>