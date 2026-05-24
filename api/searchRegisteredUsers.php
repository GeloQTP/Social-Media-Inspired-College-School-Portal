<?php
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $searchQueue = trim((string)($_POST['searchQueue'] ?? ''));
    $filterbyProgram = (string)($_POST['filterbyProgram'] ?? '');
    $current_status = (string)($_POST['current_status'] ?? '');
    $searchQueue = '%' . $searchQueue . '%';

    if (empty($filterbyProgram) || $filterbyProgram === "undefined" || $filterbyProgram === "show_all") { // NO SELECTION FILTER
        $stmt = $conn->prepare("SELECT * FROM user_information INNER JOIN users ON user_information.student_id = users.student_id WHERE current_status = ? AND LastName LIKE ?");
        $stmt->bind_param("ss", $current_status, $searchQueue);
    } else if ($searchQueue && $filterbyProgram) {
        $stmt = $conn->prepare("SELECT * FROM user_information INNER JOIN users ON user_information.student_id = users.student_id WHERE current_status = ? AND Program = ? AND LastName LIKE ?");
        $stmt->bind_param("sss", $current_status, $filterbyProgram, $searchQueue);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $list = [];

    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }

    echo json_encode($list);
}
