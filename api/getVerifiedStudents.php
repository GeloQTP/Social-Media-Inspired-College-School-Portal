<?php
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $filterBy = (string)($_POST['filterBy'] ?? '');
    $searchQueue = (string)($_POST['searchQueue'] ?? '');
    $current_status = (string)($_POST['current_status'] ?? '');
    $searchQuery = '%' . $searchQueue . '%';

    if (
        empty($filterBy) || $filterBy === "undefined" || $filterBy === "show_all" && $searchQueue === '' // NO FILTER AND NO SEARCH
    ) {
        $stmt = $conn->prepare("SELECT * FROM user_information INNER JOIN users ON user_information.student_id = users.student_id WHERE (current_status = ? OR current_status = 'enrolled')");
        $stmt->bind_param("s", $current_status);
    } else if (empty($filterBy) || $filterBy === "undefined" || $filterBy === "show_all" && $searchQueue !== '') { // NO FILTER BUT THERE'S SEARCH
        $stmt = $conn->prepare("SELECT * FROM user_information INNER JOIN users ON user_information.student_id = users.student_id WHERE (current_status = ? OR current_status = 'enrolled') AND LastName LIKE ?");
        $stmt->bind_param("ss", $current_status, $searchQuery);
    } else if ($filterBy && $searchQueue === '') { // THERE'S FILTER BUT NO SEARCH
        $stmt = $conn->prepare("SELECT * FROM user_information INNER JOIN users ON user_information.student_id = users.student_id WHERE (current_status = ? OR current_status = 'enrolled') AND Program = ?");
        $stmt->bind_param("ss", $current_status, $filterBy);
    } else if ($filterBy && $searchQueue !== '') { // THERE'S FILTER AND SEARCH
        $stmt = $conn->prepare("SELECT * FROM user_information INNER JOIN users ON user_information.student_id = users.student_id WHERE (current_status = ? OR current_status = 'enrolled') AND Program = ? AND LastName LIKE ?");
        $stmt->bind_param("sss", $current_status, $filterBy, $searchQuery);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $list = [];

    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }

    echo json_encode($list);
}
