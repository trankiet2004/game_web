<?php
require("DBConnect.php");

$SQL = "SELECT * FROM developers";
$query = $connect->query($SQL);

while($row = $query->fetch_assoc()) {
    
}

var_dump($_SERVER["REQUEST_URI"]);