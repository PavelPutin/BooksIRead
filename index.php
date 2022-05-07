<?php
$title = 'Books I Read';
require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
require_once getURI("components/header.php");
function getShortName($name, $surname, $patronymic) {
    return $surname . " " . mb_substr($name, 0, 1) . "." . mb_substr($patronymic, 0, 1) . ".";
}
?>
    <main>
        <section class="catalog">
        <h2 class="catalog-title">Каталог книг</h2>
        <div class="container">
            <form class="catalog-settings" action="" method="post">
                <label for="is-read">
                    <input type="checkbox" name="is-read" id="is-read">
                    Книга прочитана
                </label>

                <label for="book-author">
                    Автор:
                    <select name="book-author-select" id="book-author-select">
                        <?php
                            $authors = new mysqli('localhost', 'root', '', 'booksireaddb');
                            $authors->query("SET NAMES 'utf8");
                            if ($authors->connect_error) {
                                echo "Возникла ошибка базы данных: #" . $authors->connect_errno . " " . $authors->connect_error;
                            } else {
                                $authorsResult = $authors->query("SELECT * FROM `authors`");
                                while ($row = $authorsResult->fetch_assoc()) {
                                    echo "<option>" . $row['surname'] . ' ' . $row['name'] . ' ' . $row['patronymic'] . "</option>";
                                }
                            }



                            $authors->close();
                        ?>
                    </select>
                </label>

                <button type="submit">Позакать книги</button>
            </form>

            <table class="catalog-books">
                <thead>
                    <tr>
                        <th id="book-title">Название книги</th>
                        <th id="book-author">Автор</th>
                        <th id="book-rating">
                            Оценка
<!--                                    <button type="button">Сортиовать</button>-->
                        </th>
                        <th id="book-date-start">
                            Дата начала чтения
<!--                                    <button type="button">Сортиовать</button>-->
                        </th>
                        <th id="book-date-end">
                            Дата окончания чтения
<!--                                    <button type="button">Сортиовать</button>-->
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $booksIReadDB = new mysqli("localhost", "root", "", "booksireaddb");
                        $booksIReadDB->query("SET NAMES 'utf8'");

                        if ($booksIReadDB->connect_error) {
                            echo "<tr><td colspan='5'> Возникла ошибка базы данных: #" . $booksIReadDB->connect_errno . " " . $booksIReadDB->connect_error . "</td></tr>";
                        } else {
                            $books = $booksIReadDB->query("SELECT
                                books.id,
                                books.title,
                                authors.name,
                                authors.surname,
                                authors.patronymic,
                                books.rating,
                                books.dateStartReading,
                                books.dateFinishReading
                            FROM
                                books
                            INNER JOIN authors ON books.authorId = authors.id;");
                            while ($row = $books->fetch_assoc()) {
                                $linkURL = getURI("book.php?book=" . $row['id']);
                                $dateStart = date('d.m.Y', strtotime($row['dateStartReading']));
                                $authorName = $row['surname'] . " " . mb_substr($row['name'], 0, 1) . "." . mb_substr($row['patronymic'], 0, 1) . ".";
                                if ($row['dateFinishReading']) {
                                     $dateFinish = date('d.m.Y', strtotime($row['dateFinishReading']));
                                } else {
                                     $dateFinish = "-";
                                }

                                echo "<tr>";
                                echo "<td><a href=" . $linkURL . ">" . $row['title'] . "</a></td>";
                                echo "<td>" . $authorName . "</td>";
                                echo "<td>" . $row['rating'] . "</td>";
                                echo "<td>" . $dateStart . "</td>";
                                echo "<td>" . $dateFinish . "</td>";
                                echo "</tr>";
                            }
                        }

                        $booksIReadDB->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php
    require_once getURI("components/footer.php");
?>