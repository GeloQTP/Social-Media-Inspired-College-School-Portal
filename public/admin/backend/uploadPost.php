<?php
include __DIR__ . '/../../../includes/db_connect.php';

mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postTitle = trim($_POST['postTitle'] ?? '');
    $posted_by = 'Admin';

    $postCaption = trim($_POST['postCaption'] ?? '');
    $postCaption = htmlspecialchars($postCaption, ENT_QUOTES, 'UTF-8');

    $status = trim($_POST['status'] ?? '');
    $post_date = date("F j, Y");

    $log_owner = 'Admin';
    $log_description = 'Admin Posted an Announcement';
    $log_type = 'Post';

    if (!isset($_FILES['postImage']) || $_FILES['postImage']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Please upload a valid file']);
        exit;
    }

    $targetDir = __DIR__ .  '/../../Uploads/';

    $maxSize = 5; // size limit 
    $maxSize = $maxSize * 1024 * 1024;
    if ($_FILES['postImage']['size'] > $maxSize) {
        echo json_encode(['success' => false, 'message' => 'File is too Large.']);
        exit;
    }

    $allowedTypes = [ // array of valid or acceptable file types.
        'jpeg',
        'png',
        'pdf',
        'jpg'
    ];

    $filename = $_FILES['postImage']['name']; // only gets the base name (image.png).
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // pathinfo gets the file extension from the filename and converts it to lowercases.

    if (!in_array($extension, $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Invalid File Type.']);
        exit;
    }

    $allowedMimeTypes = [ // list of allowed mime types
        'image/jpeg',
        'image/png',
    ];

    $mimeType = mime_content_type($_FILES['postImage']['tmp_name']);

    if (!in_array($mimeType, $allowedMimeTypes)) { // mime type checking
        echo json_encode(['success' => false, 'message' => 'Invalid File Type.']);
        exit;
    }

    // create a (new) Unique filename
    $filename = bin2hex(random_bytes(16)) . '.' . $extension; // variable that holds the new base name (file name) (3scxouwhrg5svo.png or whatever)
    $targetPath = $targetDir . $filename; // transfer the target folder or directory with the new file name (in this case - uploads/3scxouwhrg5svo.png)

    if (!move_uploaded_file($_FILES['postImage']['tmp_name'], $targetPath)) {
        echo json_encode(['success' => false, 'message' => 'Uploading Failed. Please try again.']);
        exit;
    }

    $imagePathForDB = '/Modern Student Portal/public/Uploads/' . $filename; // directory for database

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO posts (post_title, posted_by, post_caption, image_src, status, post_date) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $postTitle, $posted_by, $postCaption, $imagePathForDB, $status, $post_date);
        $stmt->execute();
        $stmt->close();

        // INSERT LOG
        $stmt = $conn->prepare("INSERT INTO logs (log_owner, log_description, log_type) VALUES (?,?,?)");
        $stmt->bind_param("sss", $log_owner, $log_description, $log_type);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Type']);
    exit;
}
