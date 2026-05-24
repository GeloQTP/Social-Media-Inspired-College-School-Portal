<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: /Modern%20Student%20Portal/public/student/StudentDashboard.php');
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header('Location: /Modern%20Student%20Portal/public/student/StudentDashboard.php');
    exit();
}

$user_id = $_GET['user_id'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users INNER JOIN user_information ON users.student_id = user_information.student_id WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$canSeeBadges = false;
$current_user_id = (int)($_SESSION['user_id'] ?? 0);
if ($current_user_id === (int)$user_id) {
    $canSeeBadges = true;
} elseif (isset($row['badge_visibility']) && (int)$row['badge_visibility'] === 1) {
    $canSeeBadges = true;
}

$student_id = $row['student_id'];

$badges = [];
if ($canSeeBadges) {
    $badgeStmt = $conn->prepare("SELECT badge_icon, badge_description, date_given FROM badges WHERE student_id = ? ORDER BY badge_id DESC");
    $badgeStmt->bind_param("i", $student_id);
    $badgeStmt->execute();
    $badgeResult = $badgeStmt->get_result();
    $badges = $badgeResult->fetch_all(MYSQLI_ASSOC);
    $badgeStmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $row['FirstName'] ?>'s Profile - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./components/style.css">
</head>

<body>

    <?php
    include __DIR__ . '/components/studentNavbar.php';
    ?>

    <div class="container mt-5 pt-5 bg-">

        <?php
        include __DIR__ . '/components/collapsedSidebar.php';
        ?>

        <div class="main">

            <div class="d-flex bg-dark rounded rounded-4 mb-3" style="height: 300px;"> <!--BANNER-->
                <img src="<?= $row['profile_banner'] ?>" class="img-fluid mx-auto" alt="...">
            </div>

            <div class="position-relative d-flex align-items-center align-items-lg-start flex-lg-row flex-column ">
                <div class="ms-lg-5" style="transform: translateY(-90px);"> <!--PROFILE PICTURE-->
                    <img src="<?= $row['profile_picture'] ?>"
                        alt="profile picture"
                        style="border-radius: 50%; width:200px; height: 200px;  object-fit: cover;"
                        class="border border-5 border-light">
                </div>

                <div id="student_fullname" class="ms-lg-3">
                    <div class="d-flex flex-column flex-lg-row">
                        <p class="text-center text-lg-start h3" style=""><?= $row['FirstName'] . " " . $row['LastName'] ?><span class="small ms-2 text-success">(<?= $row['account_username'] ?>)</span></p>
                    </div>

                </div>

            </div>

            <div class="text-center d-flex flex-column text-lg-start">
                <p class="h5 mx-auto"><?= $row['Program'] ?></p>

                <div class="d-flex mx-auto">
                    <p class="me-1 badge border text-dark">Student ID: <span class="ms-2 text-success"><?= $row['student_id'] ?></span></p>
                    <p class="me-1 badge border text-dark">Honors: <span class="ms-2 text-success"><?= $row['Honors'] ?></span></p>
                </div>
            </div>

            <hr style="width: 20%;" class="mx-auto mb-5 text-dark">

            <div class="mt-2 mx-auto mb-5" style="width: 60%;">

                <p class="text-center">
                    <?= $row['quote']; ?>
                </p>

                <div class="d-flex">
                    <div class="mx-auto mt-4">
                        <span>-</span>
                        <span> <?= $row['quote_author']; ?></span>
                    </div>
                </div>

            </div>

            <hr style="width: 20%;" class="mx-auto mb-3 text-dark">

            <div class="card mt-2 mx-auto" style="width: 100%;">
                <div class="card-header bg-success bg-gradient border-0 text-light text-center">
                    <small">BADGES</small>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php if ($canSeeBadges && !empty($badges)): ?>
                            <?php foreach ($badges as $badge): ?>
                                <div class="col-12 col-md-6 col-lg-3">
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
                                        <p class="fw-semibold mb-1"><?= htmlspecialchars($badge['badge_description']) ?></p>
                                        <small class="text-muted"><?= htmlspecialchars($badge['date_given']) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php elseif (!$canSeeBadges): ?>
                            <div class="col-12">
                                <p class="text-center text-muted mb-0">This user's badges are private.</p>
                            </div>
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
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>