<?php
require_once('../Model/GameGenreModel.php');

$URIPart = explode("/", $_SERVER["REQUEST_URI"]);
$fetch = new GameGenreModel();
$id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
$fetch->fetch($_SERVER["REQUEST_METHOD"], "game_genre", $id, "game_id");