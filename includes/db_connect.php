<?php

mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);

require __DIR__ . '/../public/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'database.env');
$dotenv->load();

$db_host = $_ENV['DB_HOST'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$db_name = $_ENV['DB_NAME'];

try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception) {
    echo '<p style="color:red;">Database Connection Error. Please Try again Later.</p>';
    exit();
}
