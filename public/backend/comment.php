<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
header("Content-Type: application/json");


$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        $post_id = (int)($_POST['post_id'] ?? 0);
        $comment = (string)($_POST['comment'] ?? '');
        $comment_unix = time();

        $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment, comment_unix) VALUES (?,?,?,?)");
        $stmt->bind_param("iisi", $post_id, $user_id, $comment, $comment_unix);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;


    case 'GET':
        $post_id = (int)($_GET['post_id'] ?? 0);

        $stmt = $conn->prepare("SELECT comment_id, post_id, profile_picture, account_username, role, comment, comment_unix FROM comments JOIN users ON comments.user_id = users.user_id JOIN user_information ON users.student_id = user_information.student_id WHERE post_id = ? AND users.activationStatus = 'active' ORDER BY comment_unix DESC;");
        $stmt->bind_param('i', $post_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $comments = []; // HOLDS ALL THE COMMENTS

            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }

            echo json_encode($comments);
        }
        break;


    case 'DELETE':
        // $input = json_decode(file_get_contents('php://input'), true); // ONLY WORKS IF FRONTEND SENDS JSON.
        parse_str(file_get_contents("php://input"), $input); // ONLY WORKS IF FRONTEND SENDS new URLSearchParams().
        $comment_id = $input['comment_id'];

        $stmt = $conn->prepare("DELETE FROM comments WHERE comment_id = ?");
        $stmt->bind_param("i", $comment_id);

        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'method' => 'DELETE', 'comment_id' => $comment_id]);
        }

        echo json_encode(['success' => true, 'method' => 'DELETE', 'comment_id' => $comment_id]);
        break;


    default:
        echo json_encode(["message" => "Invalid request method"]);
        break;
}
