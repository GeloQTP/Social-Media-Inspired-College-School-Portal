<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ?? 'Laragon College University'; ?></title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Modern Student Portal/styles/style.css">
</head>

<body>

    <!-- SPINNER -->
    <div class="spinner-wrapper">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

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

    <!-- NAVBAR -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-light fixed-top">
            <div class="container my-1">
                <a href="/Modern Student Portal/public/visitors/LandingPage.php" class="navbar-brand fw-bold d-flex align-items-center">
                    <span class="px-2">
                        <img src="/Modern Student Portal/src/img/TRC_LOGO.png" alt="Laragon logo" style="width: 50px; border-radius: 100px;">
                    </span>
                    <span class="d-none d-sm-block text-success">
                        <span class="text-success lead">Tomas Del Rosario</span> College
                    </span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navmenu">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-success"
                                href="/Modern Student Portal/public/visitors/routes/AboutPage.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-success"
                                href="/Modern Student Portal/public/visitors/routes/AdmissionPage.php">Admission</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-success"
                                href="/Modern Student Portal/public/visitors/routes/EventsPage.php">Events</a>
                        </li>
                        <button type="button" class="btn btn-success bg-light text-success ms-lg-3"
                            onclick="window.location.href='/Modern Student Portal/public/visitors/LoginPage.php'">
                            Login
                        </button>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main id="content">