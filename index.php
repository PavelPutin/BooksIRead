<?php
$title = 'Books I Read';
require_once $_SERVER["HTTP_HOST"] . '/../' . "config.php";
require_once getURI("components/header.php");

$query = "SELECT
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
    INNER JOIN authors ON books.authorId = authors.id";
$books = $booksIReadDB->query($query);
?>
<main>
    <section class="catalog">
        <h2 class="catalog-title">Каталог книг</h2>
        <div class="container">

            <table class="catalog-books">
                <thead>
                    <tr>
                        <th id="book-title">Название книги</th>
                        <th id="book-author">Автор</th>
                        <th id="book-rating">
                            Оценка
                        </th>
                        <th id="book-date-start">
                            Дата начала чтения
                        </th>
                        <th id="book-date-end">
                            Дата окончания чтения
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = $books->fetch(PDO::FETCH_ASSOC)) {
                            $linkURL = getURI("book.php?book=" . $row['id']);
                            $dateStart = changeDateTimeFormat($row['dateStartReading']);
                            $authorName = getShortName($row['name'], $row['surname'], $row['patronymic']);
                            if ($row['dateFinishReading']) {
                                $dateFinish = changeDateTimeFormat($row['dateFinishReading']);
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
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php
    require_once getURI("components/footer.php");
?>