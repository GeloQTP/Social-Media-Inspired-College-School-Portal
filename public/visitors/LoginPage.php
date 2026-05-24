<?php
include __DIR__ .  '/components/destroySession.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/Modern Student Portal/styles/style.css">
</head>

<style>
    body {
        overflow: hidden;
    }

    #login_main {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100vw;
        height: 100vh;
    }
</style>

<body>
    <!-- TOASTS SECTION -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast bg-light text-dark" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="/Modern Student Portal/src/img/TRC_LOGO.png" style="width: 30px;" class="rounded me-2 img-fluid"
                    alt="...">
                <strong class="me-auto">TRC Notification</strong>
                <i class="bi bi-bell text-dark"></i>
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
                    <span class="d-none d-sm-block">
                        <span class="text-success lead">Tomas Del Rosario</span><span class="text-success"> College</span>
                    </span>
                </a>

            </div>
        </nav>
    </header>

    <main id="login_main" class="mt-5"> <!--ADD BACKGROUND IMAGE-->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="bg-light p-4 p-md-5 rounded-3 shadow-sm">

                        <h2 class="text-center lead display-6 mb-5">LOGIN</h2>

                        <?php
                        include __DIR__ . '/components/LoginForm.php';
                        ?>

                        <!-- Divider -->
                        <hr class="my-4">

                        <!-- Register -->
                        <p class="text-center small mb-0 text-secondary">
                            Don&#39;t have an account?
                            <a href="/Modern Student Portal/public/visitors/RegistrationPage.php" class="text-decoration-none fw-semibold text-success">
                                Register here
                            </a>
                        </p>

                    </div>
                </div>
            </div>
        </div>

    </main>

</body>
<script src="./scripts/OTPAutonext.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const spinner = document.querySelector('.spinner-wrapper');

    window.addEventListener('DOMContentLoaded', () => {
        const loginForm = document.getElementById("loginForm");

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            try {
                const res = await fetch(`../backend/login.php`, {
                    method: 'POST',
                    body: new FormData(loginForm),
                    credentials: 'same-origin',
                });

                if (!res.ok) {
                    document.querySelector(".toast-body").textContent =
                        "Network Response Error, Please Try again.";
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                        document.getElementById("liveToast"),
                    );
                    toastBootstrap.show();
                }

                const data = await res.json();
                console.log(data);

                if (data.success) {
                    let timerInterval;
                    Swal.fire({
                        html: `<img src="/Modern Student Portal/src/img/TRC_LOGO.png" style="width: 50%"> 
                        <p>Login Successful! Please wait</p>
                        <small>Welcome Back, ${data.account_username}!</small>`,

                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {

                            switch (data.account_role) {
                                case 'Admin':
                                    window.location.href = "/Modern%20Student%20Portal/public/admin/AdminDashboard.php"
                                    break;
                                case 'Student':
                                    window.location.href = "/Modern%20Student%20Portal/public/student/StudentDashboard.php"
                                    break;
                                case 'Teacher':
                                    window.location.href = "/Modern%20Student%20Portal/public/teacher/TeacherDashboard.php"
                                    break;
                                case 'Alumni':
                                    window.location.href = "/Modern%20Student%20Portal/public/alumni/AlumniDashboard.php"
                                    break;
                                default:
                                    window.location.href = "/Modern%20Student%20Portal/public/visitors/LoginPage.php";
                            }

                        }
                    });
                } else {
                    document.querySelector(".toast-body").textContent =
                        data.message;
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                        document.getElementById("liveToast"),
                    );
                    toastBootstrap.show();
                }

            } catch (error) {
                document.querySelector(".toast-body").textContent =
                    "Something went wrong. Please try again.";
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();
            }

        });

    });

    document.getElementById("emailSubmissionModal").addEventListener("input", function() {
        const isValid = passwordValid();
    });

    function passwordValid() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (password !== confirmPassword) {
            return false;
        }

        return true;
    }
</script>

</html>