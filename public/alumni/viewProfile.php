<?php
session_start();
include __DIR__ . '/../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: /Modern%20Student%20Portal/public/student/StudentDashboard.php');
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Alumni') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

$user_id = $_GET['user_id'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users INNER JOIN user_information ON users.student_id = user_information.student_id WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

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
    include __DIR__ . '/components/alumniNavbar.php';
    ?>

    <div class="container mt-5 pt-5 bg-">

        <?php
        include __DIR__ . '/components/collapsedSidebar.php';
        ?>

        <div class="main">

            <div class="d-flex bg-dark rounded rounded-4 mb-3" style="height: 300px;"> <!--BANNER-->
                <img src="/../Modern Student Portal/src/img/college computer room.jpg" class="img-fluid mx-auto" alt="...">
            </div>

            <div class="position-relative d-flex align-items-center align-items-lg-start flex-lg-row flex-column ">
                <div class="ms-lg-5" style=" transform: translateY(-90px);"> <!--PROFILE PICTURE-->
                    <img src="<?= $row['profile_picture'] ?>"
                        alt="profile picture"
                        style="border-radius: 50%; max-width:200px; height: 200px;"
                        class="border border-5 border-light">
                </div>

                <div id="student_fullname" class="ms-lg-3">
                    <div class="d-flex flex-column flex-lg-row">
                        <p class="text-center text-lg-start h3" style=""><?= $row['FirstName'] . " " . $row['LastName'] ?><span class="small ms-2 text-primary">(<?= $row['account_username'] ?>)</span></p>

                        <div class="mx-auto ms-lg-4">
                            <button class="btn btn-sm btn-primary" onclick="sendContactRequestConfirmation(<?= $row['user_id'] ?>)">
                                <i class="bi bi-envelope-at h4 text-light"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>

            <div class="text-center d-flex flex-column text-lg-start">
                <p class="h5 mx-auto"><?= $row['Program'] ?></p>

                <div class="d-flex mx-auto">
                    <p class="mb-1 badge border text-dark">Student ID: <span class="ms-2 text-primary"><?= $row['student_id'] ?></span></p>
                    <p class="mb-1 badge border text-dark">Batch: <span class="ms-2 text-primary"><?= $row['GraduationYear'] ?></span></p>
                    <p class="mb-1 badge border text-dark">Honors: <span class="ms-2 text-primary"><?= $row['Honors'] ?></span></p>
                </div>
                <div class="d-flex mx-auto">
                    <p class="mb-1 badge border text-dark">Job Title: <span class="ms-2 text-primary"><?= $row['JobTitle'] ?></span></p>
                    <p class="mb-1 badge border text-dark">Employment Status: <span class="ms-2 text-primary"><?= $row['EmploymentStatus'] ?></span></p>
                    <p class="mb-1 badge border text-dark">Company Name: <span class="ms-2 text-primary"><?= $row['CompanyName'] ?></span></p>
                    <p class="mb-1 badge border text-dark">Work Location: <span class="ms-2 text-primary"><?= $row['WorkLocation'] ?></span></p>
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
                <div class="card-header bg-primary bg-gradient border-0 text-light text-center">
                    <small">BADGES</small>
                </div>
                <div class="card-body d-flex flex-md-row">
                    <div class="col-3 text-center">
                        <i class="bi bi-trophy-fill text-warning h3">
                        </i>
                        <p style="font-size: 13px;">2026 Esports Champion</p>
                    </div>
                    <div class="col-3 text-center">
                        <i class="bi bi-mortarboard-fill text-primary h3">
                        </i>
                        <p style="font-size: 13px;">Dean's Lister</p>
                    </div>
                    <div class="col-3 text-center">
                        <i class="bi bi-briefcase-fill h3">
                        </i>
                        <p style="font-size: 13px;">Internship Award</p>
                    </div>
                    <div class="col-3 text-center">
                        <i class="bi bi-patch-check h3"></i>
                        <p style="font-size: 13px;">Verified User</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    sendContactRequestConfirmation = user_id => {
        Swal.fire({
            title: "Send Contact Request?",
            text: "This will send them an email.",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed)
                sendContactRequest(user_id);
        });
    }

    sendContactRequest = async user_id => {

        Swal.fire({
            title: "Say something...",
            input: "text",
            inputAttributes: {
                autocapitalize: "off"
            },
            showCancelButton: true,
            confirmButtonText: "Send Request",
            showLoaderOnConfirm: true,
            preConfirm: async (message) => {
                try {

                    Swal.fire({
                        title: "Sending Request...",
                        text: "Please wait",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const res = await fetch(`./../backend/contactRequest.php`, {
                        method: 'POST',
                        body: new URLSearchParams({
                            user_id: user_id,
                            message: message,
                        }),
                        credentials: 'same-origin',
                    });

                    if (!res.ok) throw new Error("Network response error");

                    const data = await res.json();

                    if (!data || !data.success) {
                        Swal.fire({
                            title: "Request Failed",
                            text: data?.message || "Unable to send contact request. Please try again.",
                            icon: "error"
                        });
                        return;
                    }

                    Swal.fire({
                        title: "Contact Request Sent!",
                        text: "Your request has been sent.",
                        icon: "success"
                    });

                } catch (error) {
                    console.error(error);

                    Swal.fire({
                        title: "Error",
                        text: "Something went wrong. Please try again later.",
                        icon: "error"
                    });
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>