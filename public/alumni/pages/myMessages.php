<?php
session_start();
include __DIR__ . '/../../../includes/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Alumni') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    My Messages
</body>

</html>