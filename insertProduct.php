<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'error';
    exit();
}

$name        = $_POST['prod_name']    ?? '';
$weight      = $_POST['prod_weight']  ?? '';
$price       = $_POST['prod_price']   ?? '';
$uploaded_by = $_POST['uploaded_by']  ?? '';

if (empty($name) || $weight === '' || $price === '' || empty($uploaded_by)) {
    echo 'missing fields';
    exit();
}

$conn = getConnection();

$stmt = $conn->prepare(
    'INSERT INTO products (item_name, item_weight, item_price, uploaded_by) VALUES (?, ?, ?, ?)'
);
$stmt->bind_param('siii', $name, $weight, $price, $uploaded_by);

if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'error: ' . $stmt->error;
}

$stmt->close();
$conn->close();
