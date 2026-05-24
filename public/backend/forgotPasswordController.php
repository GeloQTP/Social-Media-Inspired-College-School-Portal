<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

header('Content-Type: application/json; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'PHPMailer.env');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    return;
}

$action = $_POST['action'] ?? '';

if ($action === 'emailExists') {
    $email = $_POST['email'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM users WHERE account_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'Could not find Email. Please try Again.']);
        exit();
    }
    echo json_encode(['success' => true, 'recoveryEmail' => $row['recovery_email'], 'email' => $row['account_email'], 'message' => 'Email found. Please wait']);
}

if ($action === 'sendOTP') {
    $email = $_POST['email'] ?? '';
    $recoveryEmail = $_POST['recoveryEmail'] ?? '';

    $phone = filter_var($_POST['phoneNumber'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $otp = random_int(100000, 999999); // 6-digit OTP
    $otpHash = password_hash($otp, PASSWORD_BCRYPT);
    $otp_expiration = time() + 600; // For 10-minute expiration

    $stmt = $conn->prepare("INSERT INTO pending_registrations (email, phone, otp_hash, otp_expires_at) VALUES (?,?,?,?)");
    $stmt->bind_param("sisi", $email, $phone, $otpHash, $otp_expiration);

    if ($stmt->execute()) {

        $mail = new PHPMailer(true);

        try {

            // Server Settings
            $mail->isSMTP();
            $mail->Host = $_ENV["SMTP_HOST"];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV["SMTP_USER"];
            $mail->Password = $_ENV["SMTP_PASS"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV["SMTP_PORT"];

            // Recipients
            $mail->setFrom($_ENV["SMTP_USER"], "Tomas Del Rosario College");
            $mail->addAddress($recoveryEmail);

            // Mail
            $mail->isHTML(true);

            $mail->Subject = "Your One-Time Password (OTP) from Tomas Del Rosario College";

            $mail->Body =
                "
            <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto;'>
                <h2 style='color: #2c3e50;'>TRC PASSWORD RESET VERIFICATION</h2>

                <p>Dear Student,</p>

                <p>
                    We received a request to reset your account password.  
                    To continue with the password reset process, please use the One-Time Password (OTP) below.
                </p>

                <div style='text-align: center; margin: 30px 0;'>
                    <span style='display: inline-block; font-size: 28px; letter-spacing: 5px; font-weight: bold; color: #2c3e50;'>
                        {$otp}
                    </span>
                </div>

                <p>
                    This OTP is valid for <strong>10 minutes</strong>.  
                    Please do not share this code with anyone for security reasons.
                </p>

                <p>
                    If you did not request a password reset, you may safely ignore this email.  
                    Your account will remain secure.
                </p>

                <hr style='margin: 30px 0;'>

                <p style='font-size: 12px; color: #777;'>
                    This is an automated message from the school account system.  
                    Please do not reply to this email.
                </p>

                <p style='font-size: 12px; color: #777;'>
                    © " . date('Y') . " Tomas Del Rosario College. All rights reserved.
                </p>
            </div>
            ";

            $mail->AltBody =
                "
            TRC Password Reset Verification

            We received a request to reset your account password.

            Your One-Time Password (OTP) is:
            $otp

            This OTP is valid for 10 minutes.
            Do not share this code with anyone.

            If you did not request a password reset, please ignore this email.

            — Tomas Del Rosario College
            ";

            $mail->send();

            $_SESSION['email'] = $email;

            echo json_encode([
                'success' => true,
                'message' => "We have sent an OTP (One Time Password) to your email: {$email}",
                'recoveryEmail' => $recoveryEmail,
            ]);
        } catch (Exception $e) {
            // Log the actual error for debugging
            // error_log("PHPMailer Error: " . $mail->ErrorInfo);

            echo json_encode([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ]);
        }
    }
}

if ($action === 'verifyOTP') {
    $otp = $_POST['otp'] ?? '';
    $email = $_SESSION['email'];

    if (!$email || !preg_match('/^\d{6}$/', $otp)) {
        echo json_encode(['success' => false, 'message' => 'Invalid Email', 'email' => $email]);
        exit;
    }

    $stmt = $conn->prepare("SELECT otp_hash, otp_expires_at FROM pending_registrations WHERE email = ? ORDER BY  otp_expires_at DESC LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'OTP not found']);
        exit;
    }

    if (!password_verify($otp, $row['otp_hash'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
        exit;
    }

    if ($row['otp_expires_at'] < time()) {
        echo json_encode(['success' => false, 'message' => 'OTP expired']);
        exit;
    }

    //  OTP SUCCESS - invalidate it
    $del = $conn->prepare("DELETE FROM pending_registrations WHERE email = ?");
    $del->bind_param("s", $email);
    $del->execute();

    echo json_encode(['success' => true, 'message' => 'OTP verified', 'session_email' => $email]);
    exit;
}

if ($action === 'updatePassword') {
    echo json_encode(['success' => true, 'message' => 'sendOTP']);
}
