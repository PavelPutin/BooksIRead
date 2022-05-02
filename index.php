<?php
$title = 'Books I Read';
require_once $_SERVER["HTTP_HOST"] . '/../' . "subFunctions.php";
require_once getURI("components/header.php");
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
                        <option value="Виноградов С.Н.">Виноградов С.Н.</option>
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
                    <tr>
                        <td><a href=<?php echo getURI("book.php"); ?>>Учебник логики для старших классов</a></td>
                        <td>Виноградов С.Н.</td>
                        <td>5.0</td>
                        <td>28.01.2022</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td><a href="books/book2.php">Учебник логики для старших классов</a></td>
                        <td>Виноградов С.Н.</td>
                        <td>5.0</td>
                        <td>28.01.2022</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php
    require_once getURI("components/footer.php");
?>