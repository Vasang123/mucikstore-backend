<?php
require_once 'config/database.php';

$conn = getConnection();

$total_products = $conn->query('SELECT COUNT(*) AS count FROM products')->fetch_assoc()['count'];
$total_users    = $conn->query('SELECT COUNT(*) AS count FROM users')->fetch_assoc()['count'];

echo json_encode([
    (string)$total_products,
    (string)$total_users
]);

$conn->close();
