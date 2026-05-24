<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$user_id = (int)($_SESSION['user_id'] ?? 0);
if ($user_id === 0) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$badge_visibility = (int)($_POST['badge_visibility'] ?? 0);
$badge_visibility = $badge_visibility === 1 ? 1 : 0;

$stmt = $conn->prepare("UPDATE user_information ui INNER JOIN users u ON ui.student_id = u.student_id SET ui.badge_visibility = ? WHERE u.user_id = ?");
$stmt->bind_param("ii", $badge_visibility, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'badge_visibility' => $badge_visibility]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update visibility']);
}

$stmt->close();
