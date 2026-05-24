<?php
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $post_id = $_POST['post_id'] ?? '';
    $edit_post_title = $_POST['edit_post_title'] ?? '';
    $edit_post_caption = $_POST['edit_post_caption'] ?? '';
    $edit_current_status = $_POST['edit_current_status'] ?? '';
    $new_status = $_POST['new_status'] ?? '';

    $action = $_POST['action'] ?? '';

    $image_directory = $_POST['image_src'] ?? '';

    $document_root = $_SERVER['DOCUMENT_ROOT'];

    $image_src = $document_root . $image_directory;

    switch ($action) {

        case 'load':
            $stmt = $conn->prepare("SELECT 
            posts.post_id, 
            post_title, 
            posted_by, 
            post_caption, 
            image_src, 
            status, 
            post_date, 
            COUNT(DISTINCT likes.like_id) AS likeCount,
            COUNT(DISTINCT comments.comment_id) AS commentCount
            FROM posts 
            LEFT JOIN likes 
                ON posts.post_id = likes.post_id 
            LEFT JOIN comments 
                ON posts.post_id = comments.post_id
            GROUP BY posts.post_id 
            ORDER BY posts.post_id DESC;");
            $stmt->execute();
            $result = $stmt->get_result();

            $posts = [];

            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }

            echo json_encode($posts);
            break;


        case 'view':
            $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = ?");
            $stmt->bind_param("s", $post_id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $post_info = $result->fetch_assoc();

                echo json_encode($post_info);
            }

            break;


        case 'update':

            $conn->begin_transaction();

            try {

                $stmt =  $conn->prepare("UPDATE posts SET post_title = ?, post_caption = ?, status = ? WHERE post_id = ?");
                $stmt->bind_param("sssi", $edit_post_title, $edit_post_caption, $edit_current_status, $post_id);
                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = ?");
                $stmt->bind_param("i", $post_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                if (!$row) {
                    $post_title = 'Could not fetch Post Title';
                }
                $post_title = $row['post_title'];
                $stmt->close();

                $conn->commit();
                echo json_encode(['success' => true, 'post_title' => $post_title]);
            } catch (Exception $e) {
                $conn->rollback();
                echo json_encode(['success' => false]);
            }

            break;

        case 'archive':

            $stmt = $conn->prepare("UPDATE posts SET status = ? WHERE post_id = ?");
            $stmt->bind_param("ss", $new_status, $post_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }

            break;


        case 'delete':

            if (!empty($image_src) && file_exists($image_src)) {
                unlink($image_src);
            }

            $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ?");
            $stmt->bind_param("s", $post_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }

            break;
    }
}
