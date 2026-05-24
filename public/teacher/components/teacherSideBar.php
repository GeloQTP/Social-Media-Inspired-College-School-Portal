<div class="overflow-auto" style="max-height: 90.7vh;">
    <div class="card mb-3 border d-none d-lg-flex">
        <div class="card-header bg-info bg-gradient border-0 text-center text-light">
            <small>PROFILE</small>
        </div>
        <div class="card-body p-4 pb-0 pt-3">
            <img src="/../Modern Student Portal/src/img/Screenshot 2026-01-06 013627.png" alt="profile_picture" style="width:120px; height:110px; border-radius:50%" class="mb-3 d-flex mx-auto">
            <hr>
            <div class="d-flex">
                <p class="mb-1">Username:</p>
                <span class="ms-auto"><?= htmlspecialchars($_SESSION['account_username'] ?? '') ?></span>
            </div>
            <div class="d-flex">
                <p class="mb-1">Role:</p>
                <span class="ms-auto"><?= $_SESSION['role'] ?? 'undefined role' ?></span>
            </div>
            <div class="d-flex">
                <p>Account Status:</p>
                <i class="bi bi-circle-fill text-info ms-auto"></i>
            </div>
        </div>
    </div>

    <div class="d-flex d-none d-lg-flex mt-2">
        <h6 class="mx-auto">-- PAGES--</h6>
    </div>

    <div class="list-group mb-3 d-none d-lg-block">
        <button type="button" class="list-group-item list-group-item-action" onclick="window.location.href='/Modern%20Student%20Portal/public/teacher/TeacherDashboard.php'"><i class="bi bi-house pe-2 text-info"></i>Home</button>
        <button type="button" class="list-group-item list-group-item-action" onclick="window.location.href='/Modern%20Student%20Portal/public/teacher/mySchedule.php'"><i class="bi bi-calendar pe-2 text-info"></i>My Schedule</button>
        <button type="button" class="list-group-item list-group-item-action" onclick="window.location.href='/Modern%20Student%20Portal/public/teacher/grades.php'"><i class="bi bi-envelope pe-2 text-info"></i>Grades</button>
        <button type="button" class="list-group-item list-group-item-action" onclick="window.location.href='/Modern%20Student%20Portal/public/teacher/myMessages.php'"><i class="bi bi-envelope pe-2 text-info"></i>Messages</button>
        <button type="button" class="list-group-item list-group-item-action"><i class="bi bi-people pe-2 text-info"></i>My Students</button>
    </div>

    <div class="d-flex d-none d-lg-flex mt-2">
        <h6 class="mx-auto">--ACCOUNT--</h6>
    </div>

    <div class="list-group mb-3 d-none d-lg-block">
        <button type="button" class="list-group-item list-group-item-action"><i class="bi bi-person pe-2 text-info"></i>Profile</button>
        <button type="button" class="list-group-item list-group-item-action" onclick="logoutConfirmation()"><i class="bi bi-box-arrow-left pe-2 text-info"></i></i>Log out</button>
    </div>

    <script>
        function logoutConfirmation() {
            Swal.fire({
                title: "Log out Confirmation",
                text: "Are you sure you want to Log out?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                cancelButtonText: "I will stay",
                confirmButtonText: "Let me out!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/Modern Student Portal/public/backend/logout.php";
                }
            });

        }
    </script>
</div>