<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method. Please try again']);
    exit();
}

$password = $_POST['password'] ?? '';
$email = $_SESSION['email'] ?? '';

$password = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("UPDATE users SET account_password = ? WHERE account_email = ?");
$stmt->bind_param("ss", $password, $email);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method. Please try again']);
}

unset($_SESSION['email']);

echo json_encode(['success' => true, 'session_email' => $email]);
