<?php
include __DIR__ . '/../../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);


if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode(['success' => false, 'message' => 'Invalid HTTP Request']);
}

$stmt = $conn->prepare("DELETE FROM logs");

if (!$stmt->execute()) {
    echo json_encode(['success' => false]);
    exit();
}

echo json_encode(['success' => true]);
exit();
