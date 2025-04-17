<?php
require_once('../Model/GameDeveloperModel.php');

$URIPart = explode("/", $_SERVER["REQUEST_URI"]);
$fetch = new GameDeveloperModel();
$id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
$fetch->fetch($_SERVER["REQUEST_METHOD"], "game_developer", $id, "game_id");