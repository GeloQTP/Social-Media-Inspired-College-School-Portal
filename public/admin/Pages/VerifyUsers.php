<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

include __DIR__ . '/../../backend/getCourses.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Users - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../components/sidebar.css">
</head>

<style>
    .table-container {
        max-height: calc(100vh - 290px);
        /* adjust height */
        overflow-y: auto;
    }

    .table-container thead th {
        position: sticky;
        top: 0;
        /* important so it doesn't become transparent */
        z-index: 2;
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
                <small>just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">

            </div>
        </div>
    </div>
    <!-- TOASTS SECTION -->

    <div class="wrapper">

        <?php
        include __DIR__ . '/../components/sidebar.php';
        ?>

        <div class="main ms-5 ps-4">
            <nav class="navbar navbar-expand-lg bg-light border border-bottom">
                <div class="container-fluid justify-content-center" style="transform: translate(0px, 10px);">
                    <p class="text-success lead">Verify Users</p>
                </div>
            </nav>

            <div class="p-3">

                <?php
                include __DIR__ . '/../components/pendingStatisticsCards.php'; // STATISTICS CARDS
                ?>

                <?php
                include __DIR__ . '/../components/viewUserModal.php'; // MODAL
                ?>

                <!-- FILTER -->
                <div class="row pt-4">

                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="visible-addon"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control rounded-2" placeholder="Search by Last Name..." aria-label="Username" aria-describedby="visible-addon" name="searchbar" onkeyup="searchUser(this.value)" id="searchInput">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select class="form-select mb-2" aria-label="Large select example" onchange="loadUserRegistration(this.value)" id="filterbyProgram">
                            <option value="" disabled selected>Filter by Program</option>
                            <option value="show_all">Show All</option>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <option value="<?= $row['program_name'] ?>"><?= $row['program_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-success" onclick="location.reload()">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>

                </div>
                <!-- FILTER -->

                <!-- TABLE -->
                <div class="table-container">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="text-center table-primary">
                            <tr>
                                <th scope="col">Role</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Course</th>
                                <th scope="col">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="table_body">
                            <!-- dynamic rows -->
                        </tbody>
                    </table>
                </div>
                <!-- TABLE -->

            </div>
        </div>

    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="../scripts/sidebar.js"></script>
<script src="../scripts/VerifyUsers.js"></script>

<script>
    loadDashboardStats();
    loadUserRegistration();
    setInterval(loadDashboardStats, 5000);

    async function loadDashboardStats() { // LOAD DASHBOARD CARDS

        try {
            const res = await fetch("../../../api/dashboardStats.php", {
                method: "POST",
            });

            if (!res.ok) throw new Error("Network Response was not ok.");

            const data = await res.json();

            document.getElementById("totalPending").textContent = data.totalPendingRegistrations;
            document.getElementById("totalPendingStudents").textContent = data.StudentRegistrations;
            document.getElementById("totalPendingAlumni").textContent = data.AlumniRegistrations;

        } catch (error) {
            document.getElementById("totalPending").textContent = 0;
            document.getElementById("totalPendingStudents").textContent = 0;
            document.getElementById("totalPendingAlumni").textContent = 0;
        }
    }

    async function loadUserRegistration(filter) { // LOAD STUDENT REGISTRATION LIST

        const filterBy = filter || document.getElementById("filterbyProgram").value;
        const searchQueue = document.getElementById("searchInput").value;

        try {
            const response = await fetch(`../../../api/getRegistrationList.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    filterBy: filterBy,
                    searchQueue: searchQueue,
                    current_status: 'pending',
                }),
                credentials: "same-origin"
            });

            if (!response.ok) throw new Error

            const data = await response.json();

            const list = data.map(data => {

                const role = data.role;

                const badgeColors = {
                    Student: "info",
                    Alumni: "primary",
                };

                const badge_color = badgeColors[role] || "secondary";


                const FirstName = data.FirstName;
                const LastName = data.LastName;

                return `
                        <tr>
                            <td>
                                <h6><span class="badge bg-${badge_color} text-light" style="transform: translate(0px, 4px);">${role}</span></h6>
                            </td>
                                <td>${FirstName}</td>
                                <td>${LastName}</td>
                                <td>${data.Program}</td>
                             <td>
                                <button type="button" class="btn text-success" onclick="verificationConfirmation(${data.student_id})"><i class="bi bi-check2-circle h5"></i></button>
                                <button type="button" class="btn text-primary" onclick="viewUser(${data.student_id})"><i class="bi bi-eye h5"></i></button>
                                <button type="button" class="btn text-danger" onclick="deletionConfirmation(${data.student_id})"><i class="bi bi-trash h5"></i></button>
                            </td>
                        </tr>

                `;
            }).join('');

            document.getElementById("table_body").innerHTML = list;

        } catch (Error) {} finally {

        }

    }

    async function searchUser(searchQueue) { // SEARCH STUDENT MANUALLY

        const filterbyProgram = document.getElementById("filterbyProgram").value || '';

        const searchInputVal = document.getElementById("searchInput").value;
        if (!searchInputVal || searchInputVal === '') { // CHECKS IF SEARCH INPUT IS EMPTY
            loadUserRegistration();
            return;
        }

        try {
            const res = await fetch(`../../../api/searchRegisteredUsers.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    searchQueue: searchQueue,
                    filterbyProgram: filterbyProgram,
                    current_status: 'pending'
                }),
                credentials: 'same-origin'
            });

            const data = await res.json();

            const list = data.map(data => {

                const role = data.role;

                const badgeColors = {
                    Student: "info",
                    Alumni: "primary",
                };

                const badge_color = badgeColors[role] || "secondary";


                const FirstName = data.FirstName;
                const LastName = data.LastName;

                return `
                        <tr>
                            <td>
                                <h6><span class="badge bg-${badge_color} text-light" style="transform: translate(0px, 4px);">${role}</span></h6>
                            </td>
                                <td>${FirstName}</td>
                                <td>${LastName}</td>
                                <td>${data.Program}</td>
                             <td>
                                <button type="button" class="btn text-success" onclick="verificationConfirmation(${data.student_id})"><i class="bi bi-check2-circle h5"></i></button>
                                <button type="button" class="btn text-primary" onclick="viewUser(${data.student_id})"><i class="bi bi-eye h5"></i></button>
                                <button type="button" class="btn text-danger" onclick="deletionConfirmation(${data.student_id})"><i class="bi bi-trash h5"></i></button>
                            </td>
                        </tr>

                `;
            }).join('');

            document.getElementById("table_body").innerHTML = list;

        } catch (error) {

        } finally {

        }

    }



    function verificationConfirmation(user_id) { // VERIFICATION CONFIRMATION
        Swal.fire({
            title: "Are you sure?",
            text: `Verify User?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            confirmButtonText: "Confirm User"
        }).then((result) => {
            if (result.isConfirmed) {
                verifyUser(user_id);
            }
        });
    }

    async function verifyUser(user_id) { // SEND VERIFY REQUEST

        const toastBootstrap = bootstrap.Modal.getOrCreateInstance(document.getElementById("viewUserDetailsModal"));

        try {

            const res = await fetch(`../../../api/AdminVerificationController.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    student_id: user_id,
                    action: 'verify',
                }),
                credentials: 'same-origin',
            });

            if (!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
            }

            const data = await res.json();

            if (data.success) {
                loadUserRegistration();
                toastBootstrap.hide();

                Swal.fire({
                    title: "Verification Successful",
                    text: "The User's account has been verified.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: "Verification Unsuccessful",
                    text: "Verification Failed.",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }


        } catch (error) {
            console.error("View student failed:", error);
        } finally {

        }
    }




    function populateViewModal(data) { // POPULATE MODAL FIELDS

        document.getElementById("student_name").innerHTML = data.FirstName;

        Object.keys(data).forEach(key => {
            const element = document.getElementById(key);
            if (element) {
                element.textContent = data[key] || "N/A";
            }
        });
    }

    async function viewUser(user_id) { // SEND VIEW REQUEST 
        const viewModal = bootstrap.Modal.getOrCreateInstance(document.getElementById("viewUserDetailsModal"));
        const placeholders = document.querySelectorAll(".placeholders");

        placeholders.forEach((el) => {
            el.classList.add("placeholder", "bg-dark"); // ADD PLACE LOADING PLACEHOLDER
        });

        try {

            const res = await fetch(`../../../api/AdminVerificationController.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    student_id: user_id,
                    action: 'view'
                }),
                credentials: 'same-origin',
            });

            if (!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
            }

            const data = await res.json();

            document.getElementById("verify_student").value = user_id; // POPULATE MODAL BUTTON WITH STUDENT ID

            placeholders.forEach((el) => {
                el.classList.remove("placeholder", "bg-dark"); // REMOVE WHEN LOADED
            });

            viewModal.show();
            populateViewModal(data);

        } catch (error) {
            console.error("View student failed:", error);
        } finally {

        }

    }



    function deletionConfirmation(user_id) { // DELETION CONFIRMATION
        Swal.fire({
            title: "Are you sure?",
            text: `Reject User?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DC3545",
            confirmButtonText: "Reject User"
        }).then((result) => {
            if (result.isConfirmed) {
                rejectUser(user_id);
            }
        });
    }

    async function rejectUser(user_id) { // SEND REJECT REQUEST

        try {

            const res = await fetch(`../../../api/AdminVerificationController.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    student_id: user_id,
                    action: 'reject',
                }),
                credentials: 'same-origin',
            });

            if (!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
            }

            const data = await res.json();

            if (data.success) {
                loadUserRegistration();

                Swal.fire({
                    title: "Rejection Successful",
                    text: "The User's account has been rejected.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else {
                Swal.fire({
                    title: "Rejection Unsuccessful",
                    text: "Rejection Failed.",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }

        } catch (error) {
            console.error("View student failed:", error);
        } finally {

        }
    }
</script>

</html>