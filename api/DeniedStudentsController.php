<?php
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $action = $_POST['action'];
    $student_id = (int)$_POST['student_id'];

    switch ($action) {

        case 'reEnroll':
            $conn->begin_transaction();

            try {
                //UPDATE STUDENT STATUS
                $newStatus = 'pending';
                $stmt = $conn->prepare("UPDATE user_information SET current_status = ? WHERE student_id = ?");
                $stmt->bind_param("si", $newStatus, $student_id);
                $stmt->execute();
                $stmt->close();

                //GET STUDENT NAME
                $stmt = $conn->prepare("SELECT FirstName, LastName FROM user_information WHERE student_id = ?");
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $log_owner = $row['FirstName'] . ' ' .  $row['LastName'];
                $stmt->close();

                // INSERT LOG
                $log_description = 'Re-Enrolled by Admin';
                $log_type = 'Re-Enroll';
                $stmt = $conn->prepare("INSERT INTO logs (student_id, log_owner, log_description, log_type) VALUES (?,?,?,?)");
                $stmt->bind_param("isss", $student_id, $log_owner, $log_description, $log_type);
                $stmt->execute();
                $stmt->close();

                // ACTIVATE ACCOUNT
                $activationStatus = 'disabled';
                $activateAccount = $conn->prepare("UPDATE users SET activationStatus = ? WHERE student_id = ?");
                $activateAccount->bind_param("si", $activationStatus, $student_id);
                $activateAccount->execute();
                $activateAccount->close();

                //COMMIT ALL QUERIES
                $conn->commit();

                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['success' => false, 'error' => $e]);
            }

            break;

        case 'delete':
            $conn->begin_transaction();

            try {
                //GET STUDENT NAME
                $stmt = $conn->prepare("SELECT FirstName, LastName FROM user_information WHERE student_id = ?");
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $log_owner = $row['FirstName'] . ' ' .  $row['LastName'];
                $stmt->close();

                //DELETE STUDENT INFORMATION
                $newStatus = 'rejected';
                $stmt = $conn->prepare("DELETE FROM user_information WHERE student_id = ?");
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $stmt->close();

                //DELETE STUDENT ACCOUNT
                $newStatus = 'rejected';
                $stmt = $conn->prepare("DELETE FROM users WHERE student_id = ?");
                $stmt->bind_param("i", $student_id);
                $stmt->execute();
                $stmt->close();

                //INSERT LOG
                $log_description = 'Deleted by Admin';
                $log_type = 'Deleted';
                $stmt = $conn->prepare("INSERT INTO logs (student_id, log_owner, log_description, log_type) VALUES (?,?,?,?)");
                $stmt->bind_param("isss", $student_id, $log_owner, $log_description, $log_type);
                $stmt->execute();
                $stmt->close();

                //COMMIT ALL QUERIES
                $conn->commit();

                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['success' => false]);
            }

            break;
    }
}
