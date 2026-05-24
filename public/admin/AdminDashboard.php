<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

include __DIR__ . '/../../api/recentActivities.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./components/sidebar.css">
</head>

<style>

</style>

<body>

    <!-- TOASTS SECTION -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast bg-light text-dark" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="/Modern Student Portal/src/img/TRC_LOGO.png" style="width: 30px;" class="rounded me-2 img-fluid"
                    alt="...">
                <strong class="me-auto">TRC Notification</strong>
                <small>just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">

            </div>
        </div>
    </div>

    <div class="wrapper">

        <?php
        include __DIR__ . '/components/sidebar.php'; // SIDE BAR
        ?>

        <div class="main ms-5 ps-4">
            <nav class="navbar navbar-expand-lg bg-light border border-bottom">
                <div class="container-fluid justify-content-center" style="transform: translate(0px, 10px);">
                    <p class="text-success lead">Dashboard</p>
                </div>
            </nav>

            <div class="p-3">
                <?php
                include __DIR__ . '/components/statisticsCards.php'; // CARDS
                ?>
                <div class="row g-3">

                    <?php
                    include __DIR__ . '/components/LogsCard.php'; // LOGS
                    ?>

                    <?php
                    include __DIR__ . '/components/MessagesCard.php'; // MESSAGES
                    ?>

                </div>

            </div>
        </div>

    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="./scripts/sidebar.js"></script>
<script src="./scripts/DashboardScript.js"></script>

<script>
    loadDashboardStats(); // initial load
    setInterval(loadDashboardStats, 5000); // refresh every 5s

    async function loadDashboardStats() {
        try {
            const res = await fetch("../../api/dashboardStats.php", {
                method: "POST",
            });

            if (!res.ok) throw new Error("Network Response was not ok.");

            const data = await res.json();

            document.getElementById("totalEnrolledStudents").textContent = data.EnrolledStudents;
            document.getElementById("TotalAlumni").textContent = data.VerifiedAlumni
            document.getElementById("totalVerifiedStudents").textContent = data.VerifiedStudents;
            document.getElementById("pendingRegistrations").textContent = data.totalPendingRegistrations;
            document.getElementById("newsLetterSubscribers").textContent =
                data.NewsSubscribers;
        } catch (error) {
            document.getElementById("totalStudents").textContent = 0;
            document.getElementById("pendingRegistrations").textContent = 0;
        }
    }
</script>

</html>