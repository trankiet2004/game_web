<?php
require_once('../Model/DevelopersModel.php');

$URIPart = explode("/", $_SERVER["REQUEST_URI"]);
$fetch = new DevelopersModel();
$id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
$fetch->fetch($_SERVER["REQUEST_METHOD"], "developers", $id);

