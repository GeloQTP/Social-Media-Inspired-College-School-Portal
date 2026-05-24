<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Content & Posts - Tomas Del Rosario College</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./../components/sidebar.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .post-image {
            height: 200px;
            object-fit: cover;
        }

        .stat-box {
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <?php include __DIR__ . '/../components/editBroadcastModal.php'; ?> <!--EDIT BROADCAST MODAL-->
    <?php include __DIR__ . '/../components/createBroadcastModal.php';  ?> <!--CREATE BROADCAST MODAL-->
    <?php include __DIR__ . '/../components/createPostModal.php';  ?> <!--CREATE POST MODAL-->
    <?php include __DIR__ . '/../components/editPostModal.php'; ?> <!-- EDIT POST MODAL-->
    <?php include __DIR__  . '/../components/commentsModal.php'; ?> <!-- COMMENTS MODAL-->

    <div class="wrapper">

        <?php include __DIR__ . '/../components/sidebar.php'; ?> <!--SIDEBAR-->

        <div class="main ms-5 ps-4">

            <nav class="navbar navbar-expand-lg bg-light border border-bottom fixed-top z-1 ms-5">
                <div class="container-fluid justify-content-center" style="transform: translate(0px, 10px);">
                    <p class="text-success lead">Content and Posts</p>
                </div>

                <div class="pe-2">

                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-plus-lg me-1"></i> Create
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button class="btn dropdown-item"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createBroadcastModal">
                                    <i class="bi bi-megaphone me-2"></i>
                                    Create Broadcast
                                </button>
                            </li>

                            <li>
                                <button class="btn dropdown-item"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createPostModal">
                                    <i class="bi bi-file-earmark-plus me-2"></i>
                                    Create Post
                                </button>
                            </li>

                        </ul>
                    </div>

                </div>
            </nav>

            <div class="p-3 pt-5 mt-4">

                <ul class="nav nav-tabs mb-4"> <!--TAB LIST-->
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#broadcastTab">
                            Broadcasts
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#postsTab">
                            Posts
                        </button>
                    </li>
                </ul>

                <div class="tab-content"> <!--TAB CONTENTS-->

                    <!-- ================= BROADCAST LIST ================= -->
                    <?php include __DIR__ . '/../components/BroadcastList.php'; ?>

                    <!-- ================= POSTS ================= -->
                    <?php include __DIR__ . '/../components/PostsList.php'; ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./../scripts/sidebar.js"></script>

</body>

</html>