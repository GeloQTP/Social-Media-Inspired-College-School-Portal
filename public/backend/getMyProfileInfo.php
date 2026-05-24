<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
    exit();
}

$user_id = (int)($_SESSION['user_id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM users LEFT JOIN user_information ON users.student_id = user_information.student_id WHERE users.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$myInfo = $result->fetch_assoc();

$myInfo['success'] = true;

echo json_encode($myInfo);
