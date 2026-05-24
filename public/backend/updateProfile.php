<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false]);
    exit();
}

// PROFILE INFORMATION
$account_email = $_POST['account_email'];
$account_username = $_POST['account_username'];
$recovery_email = $_POST['recovery_email'];
$badge_visibility = isset($_POST['badge_visibility']) ? (int)$_POST['badge_visibility'] : 0;
$badge_visibility = $badge_visibility === 1 ? 1 : 0;
$quote = $_POST['quote'];
$quote_author = $_POST['quote_author'];
$user_id = $_SESSION['user_id'];

// CAREER INFORMATION
$EmploymentStatus = $_POST['EmploymentStatus'] ?? 'N/A';
$CompanyName = $_POST['CompanyName'] ?? 'N/A';
$JobTitle = $_POST['JobTitle'] ?? 'N/A';
$WorkLocation = $_POST['WorkLocation'] ?? 'N/A';

if (
    empty($account_email) ||
    empty($account_username) ||
    empty($recovery_email)
) {
    echo json_encode(['success' => false]);
    exit();
}

$stmt = $conn->prepare("UPDATE users INNER JOIN user_information ON
                        users.student_id = user_information.student_id
                        SET 
                        account_email = ?, 
                        account_username = ?, 
                        recovery_email = ?, 
                        quote = ?, 
                        quote_author = ?, 
                        badge_visibility = ?, 
                        EmploymentStatus = ?, 
                        CompanyName = ?, 
                        JobTitle = ?, 
                        WorkLocation = ?
                        WHERE 
                        users.user_id = ?");

$stmt->bind_param(
    "sssssissssi",
    $account_email,
    $account_username,
    $recovery_email,
    $quote,
    $quote_author,
    $badge_visibility,
    $EmploymentStatus,
    $CompanyName,
    $JobTitle,
    $WorkLocation,
    $user_id
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
}
