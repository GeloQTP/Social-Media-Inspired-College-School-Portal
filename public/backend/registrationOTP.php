<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'PHPMailer.env');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Read action from POST
    $action = $_POST['action'] ?? '';

    // Ensure responses are JSON
    header('Content-Type: application/json; charset=utf-8');

    if ($action === 'send_otp') {
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
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
                $mail->addAddress($email);

                // Mail
                $mail->isHTML(true);

                $mail->Subject = "Your One-Time Password (OTP) from Tomas Del Rosario College";

                $mail->Body =
                    "
                    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: auto;'>
                        <h2 style='color: #2c3e50;'>TRC Registration Verification</h2>

                        <p>Dear Student / Parent,</p>

                        <p>
                            Thank you for starting the registration process.  
                            To continue, please use the One-Time Password (OTP) below to verify your email address.
                        </p>

                        <div style='text-align: center; margin: 30px 0;'>
                            <span style='display: inline-block; font-size: 28px; letter-spacing: 5px; font-weight: bold; color: #2c3e50;'>
                                {$otp}
                            </span>
                        </div>

                        <p>
                            This OTP is valid for <strong>10 minutes</strong>.  
                            Please do not share this code with anyone.
                        </p>

                        <p>
                            If you did not request this registration, you may safely ignore this email.
                        </p>

                        <hr style='margin: 30px 0;'>

                        <p style='font-size: 12px; color: #777;'>
                            This is an automated message from the school registration system.  
                            Please do not reply to this email.
                        </p>

                        <p style='font-size: 12px; color: #777;'>
                            © " . date('Y') . " Tomas Del Rosario College. All rights reserved.
                        </p>
                    </div>
            ";

                $mail->AltBody =
                    "
                        School Registration Verification

                        Thank you for starting the registration process.

                        Your One-Time Password (OTP) is:
                        $otp

                        This OTP is valid for 10 minutes.
                        Do not share this code with anyone.

                        If you did not request this registration, please ignore this email.

                        — Tomas Del Rosario College
            ";

                $mail->send();

                $_SESSION['pending_email'] = $email;

                echo json_encode([
                    'success' => true,
                    'message' => "We have sent an OTP (One Time Password) to your email: {$email}"
                ]);
            } catch (Exception $e) {
                // Log the actual error for debugging
                // error_log("PHPMailer Error: " . $mail->ErrorInfo);

                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again.'
                ]);
            }
            return;
        }
    }

    if ($action === 'verify_otp') {

        $otp = $_POST['otp'] ?? '';
        $email = $_SESSION['pending_email'] ?? null;

        if (!$email || !preg_match('/^\d{6}$/', $otp)) {
            echo json_encode(['success' => false, 'message' => 'Invalid Email']);
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

        unset($_SESSION['pending_email']);

        echo json_encode(['success' => true, 'message' => 'OTP verified']);
        exit;
    }

    // No valid action provided
    echo json_encode(['success' => false, 'message' => 'No action specified']);
    return;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    return;
}
