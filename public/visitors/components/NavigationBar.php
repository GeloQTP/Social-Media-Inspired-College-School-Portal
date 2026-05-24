    <nav class="navbar navbar-expand-lg navbar-dark bg-light fixed-top">
        <div class="container my-1">
            <a href="./LandingPage.php" class="navbar-brand fw-bold d-flex align-items-center">
                <span class="px-2">
                    <img src="/Modern Student Portal/src/img/TRC_LOGO.png" alt="Laragon logo" style="width: 50px; border-radius: 100px;">
                </span>
                <span class="d-none d-sm-block">
                    <span class="text-success lead">Tomas Del Rosario</span><span class="text-success"> College</span>
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-success" href="./routes/AboutPage.php">About</a></li>
                    <li class="nav-item"><a class="nav-link text-success" href="./routes/AdmissionPage.php">Admission</a></li>
                    <li class="nav-item"><a class="nav-link text-success" href="./routes/EventsPage.php">Events</a></li>
                    <button type="button" class="btn btn-success bg-light text-success ms-lg-3"
                        onclick="window.location.href='./LoginPage.php'">
                        Login
                    </button>
                </ul>
            </div>
        </div>
    </nav>