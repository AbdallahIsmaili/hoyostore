<?php


$path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['PHP_SELF'];
$path = str_replace("index.php", "", $path);

define('ROOT', $path);
define('ASSETS', $path . "./app/theme/assets/");
