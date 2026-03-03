<?php

$host = "local host";
$dbname = "pdo";
$username = "root";
$password = "";


try {

    $pdo = new PDO("mysql:hosts=$host;dbname=$dbname",
    $username,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


?>