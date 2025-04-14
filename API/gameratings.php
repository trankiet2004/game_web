<?php
require("DBConnect.php");

spl_autoload_register(function($class) {
    require __DIR__ . "\\controllers\\$class.php";
});

$URIPart = explode("/", $_SERVER["REQUEST_URI"]);
$fetch = new FetchController($connect);
$id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
$fetch->fetch($_SERVER["REQUEST_METHOD"], "gameratings", $id, "game_id");