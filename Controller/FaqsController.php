<?php
require_once('../Model/FaqsModel.php');

$URIPart = explode("/", $_SERVER["REQUEST_URI"]);
$fetch = new FaqsModel();
$id = substr($URIPart[count($URIPart) - 1], strlen($URIPart[count($URIPart) - 1]) - 3) === "php" ? null : $URIPart[count($URIPart) - 1];
if($_SERVER["REQUEST_METHOD"] === "POST" && !(isset($_POST["questionTitle"]) && isset($_POST["questionContent"]))) {
    var_dump(isset($_POST["questionTitle"]));
    var_dump(isset($_POST["questionContent"]));
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu yêu cầu"]);
    exit;
}

$json = $_SERVER["REQUEST_METHOD"] === "POST" ? Array(
    trim($_POST["questionTitle"]),
    trim($_POST["questionContent"]),
    "Admin"
) : NULL;

$fetch->fetch($_SERVER["REQUEST_METHOD"], "faqs", $id, "faq_id", $json);