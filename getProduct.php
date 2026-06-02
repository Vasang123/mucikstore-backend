<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo '[]';
    exit();
}

$user_id   = $_GET['user_id']   ?? '';
$user_role = $_GET['user_role'] ?? 'user';

if (empty($user_id)) {
    echo '[]';
    exit();
}

$conn = getConnection();

// Admins see all products; users see only their own uploads
if ($user_role === 'admin') {
    $result = $conn->query('SELECT item_id, item_name, item_weight, item_price, uploaded_by FROM products');
} else {
    $stmt = $conn->prepare(
        'SELECT item_id, item_name, item_weight, item_price, uploaded_by FROM products WHERE uploaded_by = ?'
    );
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);

$conn->close();
