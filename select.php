<?php
require 'config.php';

$stmt = $pdo->query(" SELECT users.*, orders.product, orders.amount
    FROM users
    LEFT JOIN orders ON users.users_id = orders.users_id");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
