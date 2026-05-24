<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
    exit();
}

header('Content-Type: application/json');

$post_id = $_POST['post_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $result->close();

    $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);

    if ($stmt->execute()) {
        $stmt->close();

        $stmt = $conn->prepare("SELECT COUNT(*) AS likes FROM likes WHERE post_id = ?");
        $stmt->bind_param("i", $post_id);

        if (!$stmt->execute()) {
            exit();
        }

        $stmt->bind_result($likeCount);
        $stmt->fetch();
        $stmt->close();
        echo json_encode(['success' => true, 'class' => 'bi-heart', 'status' => 'unliked', 'likeCount' => $likeCount]);
    } else {
        echo json_encode(['success' => false]);
        exit();
    }
} else {
    $result->close();

    $stmt = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?,?)");
    $stmt->bind_param("ii", $post_id, $user_id);

    if ($stmt->execute()) {
        $stmt->close();

        $stmt = $conn->prepare("SELECT COUNT(*) AS likes FROM likes WHERE post_id = ?");
        $stmt->bind_param("i", $post_id);

        if (!$stmt->execute()) {
            exit();
        }

        $stmt->bind_result($likeCount);
        $stmt->fetch();
        $stmt->close();
        echo json_encode(['success' => true, 'class' => 'bi-heart-fill', 'status' => 'liked', 'likeCount' => $likeCount]);
    } else {
        echo json_encode(['success' => false]);
        exit();
    }
}
