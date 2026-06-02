<?php
require_once 'config/database.php';

$email    = $_POST['user_email']    ?? '';
$password = $_POST['user_password'] ?? '';

$conn = getConnection();

// Setup vuln for sql injection
$query = "SELECT user_id, user_email, user_password, user_role FROM users WHERE user_email = '$email' AND user_password = '$password'";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    echo '0 results';
} else {
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
}

$conn->close();
