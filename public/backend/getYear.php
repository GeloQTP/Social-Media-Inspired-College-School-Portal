<?php
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

$stmt = $conn->prepare("SELECT * FROM year");
$stmt->execute();
$result = $stmt->get_result();
