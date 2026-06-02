<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'error';
    exit();
}

$id     = $_POST['prod_id']     ?? '';
$name   = $_POST['prod_name']   ?? '';
$weight = $_POST['prod_weight'] ?? '';
$price  = $_POST['prod_price']  ?? '';

if (empty($id) || empty($name) || $weight === '' || $price === '') {
    echo 'missing fields';
    exit();
}

$conn = getConnection();

$stmt = $conn->prepare(
    'UPDATE products SET item_name = ?, item_weight = ?, item_price = ? WHERE item_id = ?'
);
$stmt->bind_param('siii', $name, $weight, $price, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo 'success';
    } else {
        echo 'no product found with that id';
    }
} else {
    echo 'error: ' . $stmt->error;
}

$stmt->close();
$conn->close();
