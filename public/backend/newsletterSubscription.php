<?php
include(__DIR__ . '/../../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $stmt = $conn->prepare("SELECT email FROM newsletter_subscribers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            echo json_encode(['success' => false, 'message' => 'This Email is already Subscribed!']);
        } else {

            $conn->begin_transaction();

            try {

                $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->close();

                $log_owner = 'Subscription';
                $log_description = 'New Newsletter Subscription';
                $log_type = 'Subscription';

                $subscription_log = $conn->prepare("INSERT INTO logs (log_owner, log_description, log_type) VALUES (?, ?, ?)");
                $subscription_log->bind_param("sss", $log_owner, $log_description, $log_type);
                $subscription_log->execute();
                $subscription_log->close();

                $conn->commit();

                echo json_encode(['success' => true, 'message' => 'Subscription Successful.']);
            } catch (Exception $e) {

                $conn->rollback();

                echo json_encode(['success' => false, 'message' => 'Database error']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
