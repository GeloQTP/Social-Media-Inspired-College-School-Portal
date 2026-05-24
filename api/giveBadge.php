<?php
header('Content-Type: application/json');
session_start();
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = (int)($_POST['user_id'] ?? 0);
$badge_icon = trim($_POST['badge_icon'] ?? 'bi-award-fill');
$badge_description = trim($_POST['badge_description'] ?? '');
$date_given = trim($_POST['date_given'] ?? date('Y-m-d'));

if ($user_id === 0 || $badge_description === '') {
    echo json_encode(['success' => false, 'message' => 'Missing required badge values']);
    exit();
}

$stmt = $conn->prepare("INSERT INTO badges (badge_icon, student_id, badge_description, date_given) VALUES (?,?,?,?)");
$stmt->bind_param("siss", $badge_icon, $user_id, $badge_description, $date_given);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Unable to create badge']);
}

$stmt->close();
