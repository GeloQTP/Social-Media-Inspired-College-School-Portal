<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $email = $_POST['email'] ?? '';
    $passcode = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT FirstName, user_id, account_email, account_username, account_password, activationStatus, current_status, role FROM users INNER JOIN user_information ON users.account_email = user_information.Email WHERE account_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['current_status'] === 'pending') {
            echo json_encode(['success' => false, 'message' => 'Account not yet Verified.']);
            exit();
        }

        if ($row['activationStatus'] !== 'active') {
            echo json_encode(['success' => false, 'message' => 'Account is Disabled']);
            exit();
        }

        if (!password_verify($passcode, $row['account_password'])) {
            echo json_encode(['success' => false, 'message' => 'Incorrect Email or Password']);
            exit();
        }

        $FirstName = $row['FirstName'];
        $account_username = $row['account_username'];
        $user_id = $row['user_id'];
        $role = $row['role'];

        $_SESSION['FirstName'] = $FirstName;
        $_SESSION['account_username'] = $account_username;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;

        echo json_encode(['success' => 'true', 'account_username' => $account_username, 'account_role' => $role]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Account not Found. Please Consider Registering']);
    }
}
