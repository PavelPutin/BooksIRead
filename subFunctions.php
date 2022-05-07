<?php
define("ROOT", $_SERVER["HTTP_HOST"] . '/../');

function getURI($path) {
    return ROOT . $path;
}