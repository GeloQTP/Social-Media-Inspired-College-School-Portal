<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['message' => 'Invalid Request Method']);
}

$Program = $_SESSION['Program'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$searchQueue = '%' . (string)($_POST['searchQueueString'] ?? '') . '%';

$stmt = $conn->prepare("SELECT * FROM user_information LEFT JOIN users ON user_information.student_id = users.student_id WHERE FirstName LIKE ? AND Program = ? AND (role = ? OR role = 'Teacher' OR role = 'Admin') AND current_status != 'rejected'  AND user_id != ?");
$stmt->bind_param("sssi", $searchQueue, $Program, $role, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$profiles = [];

while ($row = $result->fetch_assoc()) {
    $profiles[] = $row;
}

echo json_encode($profiles);
