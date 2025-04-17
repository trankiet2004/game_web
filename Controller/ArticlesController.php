<?php
require_once('../Model/ArticlesModel.php');

$URIPart = explode("/", $_SERVER["REQUEST_URI"]);
$fetch = new ArticlesModel();
$id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
$id = isset($_GET["id"]) ? $_GET["id"] : $id;
$fetch->fetch($_SERVER["REQUEST_METHOD"], "articles", $id);