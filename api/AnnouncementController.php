<?php
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $action = $_POST['action'];
    $filter = $_POST['filter'] ?? '';
    $date_today = date("Y-m-d");

    if ($action === 'load') {

        if ($filter !== 'undefined' || $filter === '') {
            $stmt = $conn->prepare("SELECT * FROM broadcasts WHERE status = ?");
            $stmt->bind_param("s", $filter);
        } else {
            $stmt = $conn->prepare("SELECT * FROM broadcasts");
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $announcements = [];

        while ($row = $result->fetch_assoc()) {
            $announcements[] = $row;
        }

        echo json_encode($announcements);
        exit;
    }

    if ($action === 'view') {
        $announcement_id = (int)($_POST['announcement_id']);

        $stmt = $conn->prepare("SELECT * FROM broadcasts WHERE broadcast_id = ?");
        $stmt->bind_param("i", $announcement_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            echo json_encode($row);
        }

        exit;
    }

    if ($action === 'edit') {

        $announcement_id = (int)($_POST['announcement_id'] ?? 0);

        // $broadcastTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $broadcastTitle = $_POST['title'];
        $broadcastTitle = $broadcastTitle !== '' ? $broadcastTitle : 'N/A';

        $announcement_message = $_POST['announcement_message'];

        $theme_color = (string)($_POST['theme_color'] ?? '');
        $expires_at = $_POST['expires_at'];
        $status = (string)($_POST['status'] ?? '');

        $log_description = 'Admin edited an Announcement';
        $log_type = 'Announcement Edit';
        $log_owner = 'Broadcast Edited';

        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("UPDATE broadcasts SET title = ?, 
                                    announcement_message = ?, 
                                    theme_color = ?, 
                                    status = ?, 
                                    expires_at = ?
                                    WHERE broadcast_id = ?");

            $stmt->bind_param("sssssi", $broadcastTitle, $announcement_message, $theme_color, $status, $expires_at, $announcement_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO logs (log_owner, log_description, log_type) VALUES (?,?,?)");
            $stmt->bind_param("sss", $log_owner, $log_description, $log_type);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $conn->rollback();
            echo json_encode(['success' => false, 'error' => $e]);
        }
    }

    if ($action === 'archive') {

        $announcement_id = $_POST['announcement_id'];
        $status = 'archived';

        $stmt = $conn->prepare("UPDATE broadcasts SET status = ? WHERE broadcast_id = ?");
        $stmt->bind_param("si", $status, $announcement_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }

    if ($action === 'delete') {

        $announcement_id = $_POST['announcement_id'];

        $stmt = $conn->prepare("DELETE FROM broadcasts WHERE broadcast_id = ?");
        $stmt->bind_param("i", $announcement_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
    }
}
