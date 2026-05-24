<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Teacher') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT FirstName, profile_picture, LastName, Program FROM users LEFT JOIN user_information ON users.student_id = user_information.student_id WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$_SESSION['Program'] = $row['Program'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./components/style.css">
</head>

<body>

    <?php
    include __DIR__ . '/components/teacherNavbar.php'; // STUDENT NAVBAR
    ?>

    <?php
    include __DIR__ . '/components/commentsModal.php'; // COMMENT SECTION MODAL
    ?>

    <div class="main p-md-2 p-1" style="margin-top: 4rem;">

        <?php
        include __DIR__ . '/components/collapsedSidebar.php';
        ?>

        <div class="row g-3">

            <div class="col-lg-2">
                <?php
                include __DIR__ . '/components/teacherSideBar.php'; // STUDENT SIDEBAR
                ?>
            </div>

            <div class="col-lg-7">
                <?php
                include __DIR__ . '/components/studentGrades.php'; // STUDENT SIDEBAR
                ?>
            </div>

            <div class="col-lg-3 text-center d-flex flex-column">

                <?php
                include __DIR__ . '/components/evenCalendar.php'; // EVENT CALENDAR
                ?>

                <div class="card mt-2 mx-auto" style="width: 100%;">
                    <div class="card-header bg-info bg-gradient border-0 text-light">
                        <small>BADGES</small>
                    </div>
                    <div class="card-body d-flex flex-md-row">
                    </div>
                </div>

            </div>

        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>