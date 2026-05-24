<?php
include __DIR__ . '/../../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if ($action === 'broadcast') {

        // $broadcastTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $broadcastTitle = $_POST['title'];
        $broadcastTitle = $broadcastTitle !== '' ? $broadcastTitle : 'N/A';

        $announcement_message = $_POST['announcement_message'];
        $announcement_message = $announcement_message !== '' ? $announcement_message : 'N/A';

        $theme_color = (string)($_POST['theme_color'] ?? '');
        $expires_at = $_POST['expires_at'];
        $status = (string)($_POST['status'] ?? '');
        $createdBy = 'Admin';
        $createdAt = date("Y-m-d");

        $log_description = 'Admin posted an Announcement';
        $log_type = 'Announcement';
        $log_owner = 'Broadcast Posted';

        $conn->begin_transaction();

        try {

            // INSERT ANNOUNCEMENT
            $stmt = $conn->prepare("INSERT INTO broadcasts (title, announcement_message, theme_color, status, expires_at, created_by, created_at)
                                VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $broadcastTitle, $announcement_message, $theme_color, $status, $expires_at, $createdBy, $createdAt);
            $stmt->execute();
            $stmt->close();

            // INSERT LOG
            $stmt = $conn->prepare("INSERT INTO logs (log_owner, log_description, log_type) VALUES (?,?,?)");
            $stmt->bind_param("sss", $log_owner, $log_description, $log_type);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false]);
        }

        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid HTTP Request']);
}
