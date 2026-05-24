<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT user_information.student_id, account_username, profile_picture, Program, YearLevel FROM users LEFT JOIN user_information ON users.student_id = user_information.student_id WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$_SESSION['Program'] = $row['Program'];

$student_id = $row['student_id'];

$badgeStmt = $conn->prepare("SELECT badge_icon, badge_description, date_given FROM badges WHERE student_id = ? ORDER BY badge_id DESC");
$badgeStmt->bind_param("i", $student_id);
$badgeStmt->execute();
$badgeResult = $badgeStmt->get_result();
$badges = $badgeResult->fetch_all(MYSQLI_ASSOC);
$badgeStmt->close();

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
    include __DIR__ . '/components/studentNavbar.php'; // STUDENT NAVBAR
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
                include __DIR__ . '/components/studentSideBar.php'; // STUDENT SIDEBAR
                ?>
            </div>

            <div class="col-lg-7">
                <?php
                include __DIR__ . '/components/shedule.php'; // STUDENT SIDEBAR
                ?>
            </div>

            <div class="col-lg-3 text-center d-flex flex-column">

                <?php
                include __DIR__ . '/components/evenCalendar.php'; // EVENT CALENDAR
                ?>

                <div class="card mt-2 mx-auto" style="width: 100%; max-height: 36.7rem;">
                    <div class="card-header bg-success bg-gradient border-0 text-light text-center">
                        <small>BADGES</small>
                    </div>
                    <div class="card-body" style="overflow:auto">
                        <div class="row g-3" id="userBadgesContainer">
                            <?php if (!empty($badges)): ?>
                                <?php foreach ($badges as $badge): ?>
                                    <div class="col-3 col-md-4 ">
                                        <div class="border rounded-3 p-3 text-center h-100">
                                            <div class="mb-2">
                                                <?php
                                                $icon = htmlspecialchars($badge['badge_icon']);
                                                if (str_contains($icon, 'bi-')) {
                                                    echo "<i class=\"bi $icon fs-2\"></i>";
                                                } else {
                                                    echo "<span class=\"fs-2\">" . $icon . "</span>";
                                                }
                                                ?>
                                            </div>
                                            <p class="fw-semibold mb-1 small"><?= htmlspecialchars($badge['badge_description']) ?></p>
                                            <small class="text-muted"><?= htmlspecialchars($badge['date_given']) ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <p class="text-center text-muted mb-0">No badges have been granted yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>