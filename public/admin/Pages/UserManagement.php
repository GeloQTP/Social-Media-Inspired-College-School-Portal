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
    <title>User Management - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../components/sidebar.css">
</head>

<style>
    .table-container thead th {
        position: sticky;
        top: 0;
        z-index: 2;
    }
</style>

<body>

    <?php
    include __DIR__ . '/../components/editUserModal.php'; // EDIT USER MODAL
    include __DIR__ . '/../components/manageBadgesModal.php'; // MANAGE BADGES MODAL
    ?>

    <div class="wrapper">
        <?php
        include __DIR__ . '/../components/sidebar.php'; // SIDEBAR
        ?>

        <div class="main ms-5 ps-4">

            <nav class="navbar navbar-expand-lg bg-light border border-bottom">
                <div class="container-fluid justify-content-center" style="transform: translate(0px, 10px);">
                    <p class="text-success lead">User Management</p>
                </div>
            </nav>

            <div class="p-3">
                <div class="row g-3 mb-4">

                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Total Users</p>
                                        <h3 class="mb-0 fw-bold" id="totalUsers">0</h3>
                                    </div>
                                    <div class="stat-icon text-info">
                                        <i class="bi bi-people h2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Logins this Month</p>
                                        <h3 class="mb-0 fw-bold">0</h3>
                                    </div>
                                    <div class="stat-icon bg-opacity-10 text-success">
                                        <i class="bi bi-circle-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1">Inactive Users</p>
                                        <h3 class="mb-0 fw-bold">0</h3>
                                    </div>
                                    <div class="stat-icon text-secondary">
                                        <i class="bi bi-circle-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- FILTER OPTIONS -->
                <div class="row pt-4">

                    <div class="col-md-4">
                        <div class="input-group mb-2">
                            <span class="input-group-text" id="visible-addon"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control rounded-2" placeholder="Search by Last Name..." aria-label="Username" aria-describedby="visible-addon" name="searchbar" onkeyup="searchUser(this.value)" id="searchInput">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select class="form-select mb-2" aria-label="Large select example" onchange="loadUsers(this.value)" id="filterbyProgram">
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

                <!-- STUDENT ACCOUNT CARDS -->
                <div class="table-container" style="height: 44.4rem; overflow:auto;">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="text-center table-success">
                            <tr>
                                <th scope="col">Role</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Course</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="table_body">
                            <!-- dynamic rows -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="./../scripts/sidebar.js"></script>

<script>
    loadUsers();
    loadDashboardStats();
    setInterval(loadDashboardStats, 5000);

    async function loadDashboardStats() { // LOAD DASHBOARD CARDS

        try {
            const res = await fetch("../../../api/dashboardStats.php", {
                method: "POST",
            });

            if (!res.ok) throw new Error("Network Response was not ok.");

            const data = await res.json();

            document.getElementById("totalUsers").textContent = data.VerifiedUsers;

        } catch (error) {
            document.getElementById("totalStudents").textContent = 0;
        }
    }

    async function loadUsers(filter) { // LOAD USER LIST

        const filterBy = filter || document.getElementById("filterbyProgram").value;
        const searchQueue = document.getElementById("searchInput").value;

        try {
            const response = await fetch(`../../../api/getVerifiedStudents.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    filterBy: filterBy,
                    searchQueue: searchQueue,
                    current_status: 'verified',
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

                return `
                            <tr>
                                <td>
                                    <h6>
                                    <span class="badge bg-${badge_color} text-light" style="transform: translate(0px, 4px);">${data.role}</span>
                                    </h6>
                                </td>
                                <td>${data.FirstName}</td>
                                <td>${data.LastName}</td>
                                <td>${data.account_username}</td>
                                <td>${data.Program}</td>
                                 <td>
                                    <h6>
                                    <span class="badge bg-success text-light" style="transform: translate(0px, 4px);">${data.current_status}</span>
                                    </h6>
                                 </td>
                                <td>
                                    <button type="button" class="btn text-primary" onclick="editUser(${data.student_id})" title="Edit user"><i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn text-warning" onclick="openBadgeManager(${data.student_id})" title="Manage badges"><i class="bi bi-award"></i></button>
                                </td>
                            </tr>
                `;
            }).join('');

            document.getElementById("table_body").innerHTML = list;

        } catch (Error) {} finally {

        }

    }

    async function openBadgeManager(student_id) {
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('manageBadgesModal'));
        document.getElementById('badgeManagerUserId').value = student_id;
        document.getElementById('badgeManagerStudentName').textContent = `User #${student_id}`;
        await loadUserBadges(student_id);
        modal.show();
    }

    async function loadUserBadges(student_id) {
        const badgeList = document.getElementById('badgeList');
        const noBadgeMessage = document.getElementById('noBadgeMessage');
        badgeList.innerHTML = '';
        noBadgeMessage.textContent = 'Loading badges...';

        try {
            const res = await fetch(`../../../api/getUserBadges.php?user_id=${student_id}`);
            if (!res.ok) throw new Error('Network response not ok');
            const data = await res.json();
            console.log(data);
            if (!data.success) throw new Error('Unable to load badges');

            if (data.badges.length === 0) {
                noBadgeMessage.textContent = 'No badges assigned yet.';
                return;
            }

            noBadgeMessage.textContent = '';
            data.badges.forEach(badge => {
                const badgeCard = document.createElement('div');
                badgeCard.className = 'border rounded-3 p-3 text-center';
                badgeCard.style.minWidth = '160px';
                badgeCard.innerHTML = `
                    <div class="mb-2">
                        ${badge.badge_icon.includes('bi-') ? `<i class="bi ${badge.badge_icon} fs-3"></i>` : `<span class="fs-3">${badge.badge_icon}</span>`}
                    </div>
                    <p class="fw-semibold mb-1">${badge.badge_description}</p>
                    <small class="text-muted">${badge.date_given}</small>
                `;
                badgeList.appendChild(badgeCard);
            });
        } catch (error) {
            noBadgeMessage.textContent = 'Unable to load badges.';
        }
    }

    async function assignBadge() {
        const userId = document.getElementById('badgeManagerUserId').value;
        const badgeIcon = document.getElementById('badge_icon').value.trim() || 'bi-award-fill';
        const badgeDescription = document.getElementById('badge_description').value.trim();
        const dateGiven = document.getElementById('date_given').value || new Date().toISOString().slice(0, 10);

        if (!badgeDescription) {
            Swal.fire({
                title: 'Missing description',
                text: 'Please add a badge description.',
                icon: 'warning'
            });
            return;
        }

        try {
            const res = await fetch('../../../api/giveBadge.php', {
                method: 'POST',
                body: new URLSearchParams({
                    user_id: userId,
                    badge_icon: badgeIcon,
                    badge_description: badgeDescription,
                    date_given: dateGiven
                }),
                credentials: 'same-origin'
            });

            if (!res.ok) throw new Error('Network response not ok');
            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Unable to assign badge');

            Swal.fire({
                title: 'Badge Assigned',
                icon: 'success',
                timer: 1600,
                showConfirmButton: false
            });
            document.getElementById('badge_description').value = '';
            document.getElementById('badge_icon').value = '';
            await loadUserBadges(userId);
        } catch (error) {
            Swal.fire({
                title: 'Error',
                text: error.message || 'Unable to assign badge.',
                icon: 'error'
            });
        }
    }

    async function searchUser(searchQueue) { // SEARCH STUDENT MANUALLY

        const filterbyProgram = document.getElementById("filterbyProgram").value || '';

        const searchInputVal = document.getElementById("searchInput").value;
        if (!searchInputVal || searchInputVal === '') { // CHECKS IF SEARCH INPUT IS EMPTY
            loadUsers();
            return;
        }

        try {
            const res = await fetch(`../../../api/searchUsers.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    searchQueue: searchQueue,
                    filterbyProgram: filterbyProgram,
                    current_status: 'verified'
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

                return `
                        <tr>
                                <td>
                                    <h6>
                                    <span class="badge bg-${badge_color} text-light" style="transform: translate(0px, 4px);">${data.role}</span>
                                    </h6>
                                </td>
                                <td>${data.FirstName}</td>
                                <td>${data.LastName}</td>
                                <td>${data.account_username}</td>
                                <td>${data.Program}</td>
                                 <td>
                                    <h6>
                                    <span class="badge bg-success text-light" style="transform: translate(0px, 4px);">${data.current_status}</span>
                                    </h6>
                                 </td>
                                <td>
                                    <button type="button" class="btn text-primary" onclick="editUser(${data.student_id})"><i class="bi bi-pencil"></i></button>
                                      <button type="button" class="btn text-warning" onclick="openBadgeManager(${data.student_id})" title="Manage badges"><i class="bi bi-award"></i></button>
                                </td>
                        </tr>
                `;
            }).join('');

            document.getElementById("table_body").innerHTML = list;

        } catch (error) {

        } finally {

        }

    }

    function populateEditModal(data) { // POPULATE VIEW MODAL 

        document.getElementById("edit_student_name").innerHTML = data.FirstName;

        Object.keys(data).forEach(key => {
            const element = document.getElementById(key);

            if (!element) {
                return;
            }

            if (element.tagName === "INPUT" ||
                element.tagName === "SELECT" ||
                element.tagName === "TEXTAREA") {

                element.value = data[key] || "";

            } else if (element.tagName === "IMG") {
                element.src = data[key] || "";
            } else {
                // For <small>, <div>, <span>, etc.
                element.textContent = data[key] || "N/A";
            }

        });
    }

    async function editUser(user_id) { // SEND VIEW REQUEST 
        const editModal = bootstrap.Modal.getOrCreateInstance(document.getElementById("editUserDetailsModal"));
        const placeholders = document.querySelectorAll(".placeholders");

        placeholders.forEach((el) => {
            el.classList.add("placeholder", "bg-dark");
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

            document.getElementById("update_student").value = user_id;

            placeholders.forEach((el) => {
                el.classList.remove("placeholder", "bg-dark");
            });

            editModal.show();
            populateEditModal(data);

        } catch (error) {
            console.error("View student failed:", error);
        } finally {

        }

    }

    function updateUserVerification(user_id) { // VERIFICATION CONFIRMATION
        Swal.fire({
            title: "Are you sure?",
            text: `Update User?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            confirmButtonText: "Save Changes"
        }).then((result) => {
            if (result.isConfirmed) {
                updateUser(user_id);
            }
        });
    }

    async function updateUser(user_id) {
        const editModal = bootstrap.Modal.getOrCreateInstance(document.getElementById("editUserDetailsModal"));
        const editedForm = new FormData(document.getElementById("editUserForm"));
        editedForm.append('student_id', user_id);

        try {

            const res = await fetch('../../../api/updateUser.php', {
                method: 'POST',
                body: editedForm,
                credentials: "same-origin"
            });

            if (!res.ok) throw new Error('Network Response not ok');

            const data = await res.json();
            if (data.success) {
                editUser(user_id);
                editModal.hide();
                loadUsers();

                Swal.fire({
                    title: "Update Successful",
                    text: "The User's account has been configured.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: "Update Unsuccessful",
                    text: "Configuration Failed.",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }

        } catch {

        } finally {

        }

    }
</script>

</html>