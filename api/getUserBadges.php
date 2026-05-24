<?php
header('Content-Type: application/json');
session_start();
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : (int)($_POST['user_id'] ?? 0);
$role = $_SESSION['role'] ?? '';

if ($user_id === 0) {
    echo json_encode(['success' => false, 'message' => 'Missing user id']);
    exit();
}

$can_view = false;
$visibility = 0;
if ($role === 'Admin' || $current_user_id === $user_id) {
    $can_view = true;
} else {
    $stmt = $conn->prepare("SELECT badge_visibility FROM user_information WHERE student_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $visibilityRow = $result->fetch_assoc();
    $stmt->close();
    $visibility = !empty($visibilityRow) ? (int)$visibilityRow['badge_visibility'] : 0;
    $can_view = $visibility === 1;
}

if (!$can_view) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized to view badges']);
    exit();
}

$stmt = $conn->prepare("SELECT badge_id, badge_icon, badge_description, date_given FROM badges WHERE student_id = ? ORDER BY badge_id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$badges = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode(['success' => true, 'badges' => $badges]);
