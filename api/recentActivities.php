<?php
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);


$start = 0;
$rows_per_page = 49;


//get the total number of logs from the database
$totalLogs = $conn->prepare("SELECT COUNT(*) FROM logs");
$totalLogs->execute();
$totalLogs->bind_result($number_of_logs);
$totalLogs->fetch();
$totalLogs->close();

$pages = ceil($number_of_logs / $rows_per_page);

if (isset($_GET['page-nr'])) {

    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}

$stmt = $conn->prepare("SELECT log_owner, log_description, log_type, log_date FROM logs ORDER BY log_date DESC LIMIT ?, ?");
$stmt->bind_param("ii", $start, $rows_per_page);
$stmt->execute();
$result = $stmt->get_result();
