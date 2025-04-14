<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$databaseName = "game_website";

$connect = new mysqli($serverName, $userName, $password, $databaseName);

if($connect->connect_error) {
    http_response_code(500);
    die("Connect Failed: " . $connect->connect_error);    
}

// echo "Connect Successfully";