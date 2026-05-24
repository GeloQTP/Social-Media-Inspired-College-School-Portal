<?php
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $action = $_POST['action'];
    $student_id = (int)$_POST['student_id'];

    switch ($action) {

        case 'verify':
            $conn->begin_transaction();

            try {
                //UPDATE STUDENT STATUS
                $newStatus = 'verified';
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
                $log_description = 'Verified by Admin';
                $log_type = 'Verified';
                $stmt = $conn->prepare("INSERT INTO logs (student_id, log_owner, log_description, log_type) VALUES (?,?,?,?)");
                $stmt->bind_param("isss", $student_id, $log_owner, $log_description, $log_type);
                $stmt->execute();
                $stmt->close();

                // ACTIVATE ACCOUNT
                $activationStatus = 'active';
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

        case 'view':
            $stmt = $conn->prepare("SELECT * FROM user_information INNER JOIN users ON user_information.student_id = users.student_id WHERE user_information.student_id = ?");
            $stmt->bind_param("i", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $student = $result->fetch_assoc(); // only one student

            echo json_encode($student); // directly the object
            break;

        case 'reject':
            $conn->begin_transaction();

            try {
                //UPDATE STUDENT STATUS
                $newStatus = 'rejected';
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

                //INSERT LOG
                $log_description = 'Rejected by Admin';
                $log_type = 'Rejected';
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
