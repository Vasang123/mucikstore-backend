<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo 'error';
    exit();
}

$id = $_GET['prod_id'] ?? '';

if (empty($id)) {
    echo 'missing prod_id';
    exit();
}

$conn = getConnection();

$stmt = $conn->prepare('DELETE FROM products WHERE item_id = ?');
$stmt->bind_param('i', $id);

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
