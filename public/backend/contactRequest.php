<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'PHPMailer.env');
$dotenv->load();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['message' => 'Invalid Request Method', 'success' => false]);
    exit();
}

if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid user ID.'
    ]);
    exit();
}

$requestReceiver_id = (int) $_POST['user_id'];
$requestSender_id = (int) $_SESSION['user_id'];

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("SELECT user_id, Email, FirstName FROM user_information 
                        LEFT JOIN users 
                        ON user_information.student_id = users.student_id 
                        WHERE users.user_id = ?");
    $stmt->bind_param("i", $requestReceiver_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) AS requestsToday 
                            FROM contactrequests 
                            WHERE requestSender_id = ? 
                            AND requestReceiver_id = ?
                            AND DATE(contactRequest_date) = CURDATE()");
    $stmt->bind_param("ii", $requestSender_id, $requestReceiver_id);
    $stmt->execute();
    $stmt->bind_result($requestsToday);
    $stmt->fetch();
    $stmt->close();

    if (!$row) {
        throw new Exception('User not found.');
    }

    if ((int)($requestsToday) >= 2) {
        throw new Exception('Max Request Attempt reached. Please try again tomorrow.');
    }

    $requestReceiver_id = $row['user_id'];
    $receivers_Email = $row['Email'];
    $receivers_FirstName = $row['FirstName'];
    $senderName = $_SESSION['FirstName'];
    $Program = $_SESSION['Program'];
    $GraduationYear = $_SESSION['GraduationYear'];
    $message = $_POST['message'];
    $link = 'N/A';

    $mail = new PHPMailer(true);

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
    $mail->addAddress($receivers_Email);

    // Mail
    $mail->isHTML(true);

    $dayToday = date("Y-m-d");
    $stmt = $conn->prepare("INSERT INTO contactrequests (requestSender_id, requestReceiver_id, contactRequest_date) VALUES (?,?,?)");
    $stmt->bind_param("iis", $requestSender_id, $requestReceiver_id, $dayToday);
    $stmt->execute();
    $stmt->close();

    $mail->Subject = "A Batch Mate Wants to Connect with You!";

    $mail->Body = "
            <div style='background-color:#f8f9fa; padding:40px 0; font-family: Arial, sans-serif;'>

                <div style='max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #dee2e6;'>

                    <!-- Header -->
                    <div style='background:#198754; padding:20px; text-align:center;'>
                        <h2 style='color:#ffffff; margin:0;'>ALUMNI CONNECTION REQUEST</h2>
                    </div>

                    <!-- Body -->
                    <div style='padding:30px; color:#333; line-height:1.6;'>

                        <p style='margin-top:0;'>Hello, {$receivers_FirstName}</p>

                        <p>
                            <strong>{$senderName}</strong>, your fellow batch mate from Tomas Del Rosario
                            <strong>{$Program}</strong> (Batch {$GraduationYear}), wants to connect with you!.
                        </p>

                        <!-- Message Box (Success Light) -->
                        <div style='margin:25px 0; padding:15px; background-color:#d1e7dd; border-left:5px solid #198754; border-radius:6px;'>
                            <p style='margin:0; font-weight:bold; color:#0f5132;'>Message:</p>
                            <p style='margin-top:10px; font-style:italic; color:#0f5132;'>
                                {$message}
                            </p>
                        </div>

                        <p>
                            You can log in to your alumni account to view their profile and respond.
                        </p>

                        <!-- Button -->
                        <div style='text-align:center; margin:30px 0; cursor: pointer;'>
                            <a href='{$link}' 
                            style='background-color:#198754; color:#ffffff; padding:12px 24px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;'>
                                View Request
                            </a>
                        </div>

                        <p style='color:#6c757d;'>
                            Stay connected and grow your network!
                        </p>

                    </div>

                    <!-- Footer -->
                    <div style='background:#f8f9fa; padding:20px; text-align:center; font-size:12px; color:#6c757d; border-top:1px solid #dee2e6;'>
                        <p style='margin:5px 0;'>
                            This is an automated message from the Tomas Del Rosario College Alumni System.
                        </p>
                        <p style='margin:5px 0;'>Please do not reply to this email.</p>
                        <p style='margin:5px 0;'>© " . date('Y') . " Tomas Del Rosario College. All rights reserved.</p>
                    </div>

                </div>

            </div>
            ";

    $mail->AltBody = "
                    Alumni Connection Request

                    {$senderName} from {$Program} (Batch {$GraduationYear}) wants to connect with you.

                    Message:
                    {$message}

                    Log in to your alumni account to view and respond.

                    — Tomas Del Rosario College Alumni System
                    ";

    if (!$mail->send()) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send email. Please try again.'
        ]);
        exit();
    }

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Contact Request sent!.'
    ]);
    exit();
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Failed to send email. Please try again.'
    ]);
}
