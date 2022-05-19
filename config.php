<?php
define("ROOT", $_SERVER["HTTP_HOST"] . '/../');
define('USER', 'root');
define('PASSWORD', '');
define('HOST', 'localhost');
define('DATABASE', 'booksireaddb');

try {
    $booksIReadDB = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);;
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

function getURI($path) {
    return ROOT . $path;
}

function getShortName($name, $surname, $patronymic) {
    return $surname . " " . mb_substr($name, 0, 1) . "." . mb_substr($patronymic, 0, 1) . ".";
}

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
            if($diff < 3600) return floor($diff / 60) . ' ' . number(floor($diff / 60), ['минуту', 'минут', 'минуты']) . ' назад';
            if($diff < 7200) return 'час назад';
            if($diff < 86400) return floor($diff / 3600) . ' ' . number(floor($diff / 3600), ['час', 'часов', 'часа']) . ' назад';
        }
        if($day_diff == 1) return 'вчера';
        if($day_diff < 7) return $day_diff . ' дней назад';
        if($day_diff < 31) return ceil($day_diff / 7) . ' ' . number(ceil($day_diff / 7), ['день', 'дней', 'дня']) . ' назад';
        if($day_diff < 60) return 'в этом месяце';
        return date('F Y', $ts);
    }
    else {
        return '-';
    }
}

function getImgSliderItem($photoURI) {
    return '<li class="img-slider-item">'.
        '<img class="book-cover" src="' . $photoURI . '" alt="">'.
    '</li>';
}

function getStrOrPlaceholder($str) {
    return ($str ? $str : '-');
}

function returnStrIf($condition, $str) {
    return ($condition ? $str : '');
}

function getComment($comment) {
    $name = $comment['name'];
    $userId = $comment['userId'];
    $creationTime = date('d.m.Y', strtotime($comment['dateTime']));
    $relativeTime = time2str(strtotime($comment['dateTime']));
    $text = $comment['text'];
    return "<div>.
        <div class='row'>.
            <span class='user_name'>" . $name . "</span>.
            <span class='userId'>#" . $userId . "</span>.
            <span class='creationTime'>" . $creationTime . "</span>.
            <span class='relativeTime'>" . $relativeTime . "</span>.
        </div>.
        <div class='row'>.
            <p class='comment_text'>" . $text . "</p>.
        </div>.
    </div>";
}