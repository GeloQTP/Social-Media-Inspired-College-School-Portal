<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false]);
    exit();
}

if (empty($_FILES['profileBanner']) || $_FILES['profileBanner']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false]);
    exit();
}

$targetDir = __DIR__ .  '/../Uploads/profile_banners/';

$maxSize = 5; // size limit 
$maxSize = $maxSize * 1024 * 1024;
if ($_FILES['profileBanner']['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'File is too Large.']);
    exit;
}

$allowedTypes = [ // array of valid or acceptable file types.
    'jpeg',
    'png',
    'jpg'
];

$filename = $_FILES['profileBanner']['name']; // only gets the base name (image.png).
$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // pathinfo gets the file extension from the filename and converts it to lowercases.

if (!in_array($extension, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Invalid File Type.']);
    exit;
}

$allowedMimeTypes = [ // list of allowed mime types
    'image/jpeg',
    'image/png',
];

$mimeType = mime_content_type($_FILES['profileBanner']['tmp_name']);

if (!in_array($mimeType, $allowedMimeTypes)) { // mime type checking
    echo json_encode(['success' => false, 'message' => 'Invalid File Type.']);
    exit;
}

$filename = bin2hex(random_bytes(16)) . '.' . $extension; // variable that holds the new base name (file name) (3scxouwhrg5svo.png or whatever)
$targetPath = $targetDir . $filename; // transfer the target folder or directory with the new file name (in this case - uploads/3scxouwhrg5svo.png)

if (!move_uploaded_file($_FILES['profileBanner']['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'message' => 'Uploading Failed. Please try again.']);
    exit;
}

$imagePathForDB = '/Modern Student Portal/public/Uploads/profile_banners/' . $filename; // directory for database

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE users SET profile_banner = ?  WHERE user_id = ?");
$stmt->bind_param("si", $imagePathForDB, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
}
