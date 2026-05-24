<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../../styles/style.css
    ">
</head>

<body>

    <?php
    include __DIR__ . '/components/Spinner&Toast.php'; // SPINNER AND TOAST NOTIFICATION
    ?>
    <header>
        <?php
        include __DIR__ . '/components/NavigationBar.php'; // NAVIGATION BAR
        ?>
    </header>

    <main>
        <section class="bg-light py-5 p-lg-5 mt-5">
            <div class="container">

                <h1 class="lead display-5 mb-3 w-100 text-dark text-center mb-4" style="border-bottom:1px solid green">
                    Student Registration
                </h1>

                <!-- STUDENT / ALUMNI SELECTION -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn btn-outline-success active" onclick="window.location.href='/Modern Student Portal/public/visitors/RegistrationPage.php'">Student</button>
                        <button type="button" class="btn btn-outline-success disabled">or</button>
                        <button type="button" class="btn btn-outline-success" onclick="window.location.href='/Modern Student Portal/public/visitors/AlumniRegistrationPage.php'">Alumni</button>
                    </div>
                </div>

                <?php
                include __DIR__ . '/components/RegistrationForm.php'; // REGISTRATION FORM
                ?>

                <?php
                include __DIR__ . '/components/OTPModal.php'; // OTP MODAL
                ?>

            </div>
        </section>
    </main>

    <footer>
        <div class="bg-light text-dark text-center p-3">
            <p class="mb-0">&copy; 2026 Tomas Del Rosario College. All rights reserved.</p>
        </div>
    </footer>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="./scripts/RegistrationPage.js"></script>
<script src="./scripts/autoAgeCalc.js"></script>
<script src="./scripts/OTPAutonext.js"></script>
<script src="./scripts/checkEmptyInputs.js"></script>
<script>
    // LOADER ANIMATION
    const spinner = document.querySelector(".spinner-wrapper");
    window.addEventListener("load", () => {
        setTimeout(() => (spinner.style.display = "none"), 1000);
    });
</script>

</html>