<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: /Modern%20Student%20Portal/public/student/StudentDashboard.php');
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Student') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

$user_id = $_SESSION['user_id'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users INNER JOIN user_information ON users.student_id = user_information.student_id WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

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
    <title><?= $row['FirstName'] ?>'s Profile - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./components/style.css">
</head>

<body>

    <?php
    include __DIR__ . '/components/edit_myProfileModal.php'; // EDIT PROFILE INFO MODAL
    ?>

    <?php
    include __DIR__ . '/components/editProfilePicture.php'; // EDIT PROFILE PICTURE MODAL
    ?>

    <?php
    include __DIR__ . '/components/editProfileBanner.php'; // EDIT PROFILE BANNER MODAL
    ?>

    <?php
    include __DIR__ . '/components/studentNavbar.php'; // MY PROFILE - STUDENT NAVBAR
    ?>

    <div class="container mt-5 pt-5 bg-">

        <?php
        include __DIR__ . '/components/collapsedSidebar.php';
        ?>

        <div class="main">

            <div class="position-relative">

                <div class="position-absolute bottom-0 end-0 me-1 mb-1">
                    <button class="btn bg-success text-light border border-light border-3 d-flex align-items-center justify-content-center shadow"
                        style="border-radius: 50%; width: 45px; height: 45px;"
                        data-bs-toggle="modal"
                        data-bs-target="#editProfileBanner">

                        <i class="bi bi-image"></i>

                    </button>
                </div>

                <div class="d-flex bg-dark rounded rounded-4 mb-3" style="height: 300px; object-fit: cover;"> <!--BANNER-->
                    <img src="<?= $row['profile_banner'] ?>" class="img-fluid mx-auto" alt="...">
                </div>

            </div>

            <div class="position-relative d-flex align-items-center align-items-lg-start flex-lg-row flex-column">

                <!-- PROFILE PICTURE -->
                <div class="ms-lg-5 position-relative d-flex"
                    style="transform: translateY(-90px); width: fit-content;">

                    <img src="<?= $row['profile_picture'] ?>"
                        alt="profile picture"
                        class="border border-5 border-light"
                        style="border-radius: 50%; width: 200px; height: 200px; object-fit: cover;">

                    <!-- UPDATE PROFILE BUTTON -->
                    <div class="position-absolute bottom-0 end-0">
                        <button class="btn bg-success text-light border border-light border-3 d-flex align-items-center justify-content-center shadow"
                            style="border-radius: 50%; width: 45px; height: 45px;"
                            data-bs-toggle="modal"
                            data-bs-target="#editProfilePicture">

                            <i class="bi bi-image"></i>

                        </button>
                    </div>

                </div>

                <!-- FULL NAME -->
                <div id="student_fullname" class="ms-lg-3">

                    <div class="d-flex flex-column flex-lg-row align-items-center align-items-lg-start">

                        <p class="text-center text-lg-start h3 mb-2 mb-lg-0">
                            <?= $row['FirstName'] . " " . $row['LastName'] ?>

                            <span class="small ms-2 text-success">
                                (<?= $row['account_username'] ?>)
                            </span>
                        </p>

                        <div class="mx-auto ms-lg-4">

                            <button class="btn btn-sm btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#edit_myProfileModal"
                                onclick="getMyProfile()">

                                <i class="bi bi-pencil-square h5 mb-0"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <div class="text-center d-flex flex-column text-lg-start">
                <p class="h5 mx-auto"><?= $row['Program'] ?></p>

                <div class="d-flex mx-auto">
                    <p class="me-1 badge border text-dark">Student ID: <span class="ms-2 text-success"><?= $row['student_id'] ?></span></p>
                    <p class="me- badge border text-dark">Year Level: <span class="ms-2 text-success"><?= $row['YearLevel'] ?></span></p>
                    <p class="me-1 badge border text-dark">Program: <span class="ms-2 text-success"><?= $row['Program'] ?></span></p>
                    <p class="me-1 badge border text-dark">Email: <span class="ms-2 text-success"><?= $row['Email'] ?></span></p>
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
                        <span><?= $row['quote_author']; ?></span>
                    </div>
                </div>

            </div>

            <hr style="width: 20%;" class="mx-auto mb-5 text-dark">

            <div class="card mt-2 mx-auto" style="width: 100%;">
                <div class="card-header bg-success bg-gradient border-0 text-light text-center">
                    <small">BADGES</small>
                </div>
                <div class="card-body">
                    <div class="row g-3" id="userBadgesContainer">
                        <?php if (!empty($badges)): ?>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>