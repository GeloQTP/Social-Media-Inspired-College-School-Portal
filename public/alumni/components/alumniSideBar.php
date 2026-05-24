<div class="overflow-auto" style="max-height: 90.7vh;">
    <div class=" card mb-3 border d-none d-lg-flex">
        <div class="card-header bg-primary bg-gradient border-0 text-center text-light">
            <small>PROFILE</small>
        </div>
        <div class="card-body p-4 pb-0 pt-3">
            <img src="<?= $row['profile_picture'] ?>" alt="profile_picture" style="width:120px; height:110px; border-radius:50%" class="mb-3 d-flex mx-auto">
            <hr>
            <div class="d-flex">
                <p class="mb-1">Username:</p>
                <span class="ms-auto"><?= htmlspecialchars($row['account_username'] ?? '') ?></span>
            </div>
            <div class="d-flex">
                <p class="mb-1">Program:</p>
                <span class="ms-auto"><?= htmlspecialchars($row['Program'] ?? '') ?></span>
            </div>
            <div class="d-flex">
                <p class="mb-1">Batch:</p>
                <span class="ms-auto"><?= htmlspecialchars($row['GraduationYear'] ?? 'YYYY') ?></span>
            </div>
            <div class="d-flex">
                <p>Account Status:</p>
                <i class="bi bi-circle-fill text-success ms-auto"></i>
            </div>
        </div>
    </div>

    <div class="d-flex d-none d-lg-flex mt-2">
        <h6 class="mx-auto">-- PAGES--</h6>
    </div>

    <div class="list-group mb-3 d-none d-lg-block">
        <button type="button" class="list-group-item list-group-item-action active bg-primary border border-0" aria-current="true">
            <i class="bi bi-house pe-2 text-light"></i>Home
        </button>
        <button type="button" class="list-group-item list-group-item-action" onclick="window.location.href='/Modern%20Student%20Portal/public/alumni/pages/myMessages.php'"><i class="bi bi-envelope pe-2 text-primary"></i>Messages</button>
    </div>

    <div class="d-flex d-none d-lg-flex mt-2">
        <h6 class="mx-auto">--ACCOUNT--</h6>
    </div>

    <div class="list-group mb-3 d-none d-lg-block">
        <button type="button" class="list-group-item list-group-item-action" onclick="window.location.href='/Modern%20Student%20Portal/public/alumni/pages/myProfile.php'"><i class="bi bi-person pe-2 text-primary"></i>Profile</button>
        <button type="button" class="list-group-item list-group-item-action" onclick="logoutConfirmation()"><i class="bi bi-box-arrow-left pe-2 text-primary"></i></i>Log out</button>
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
                    window.location.href = "/Modern%20Student%20Portal/public/backend/logout.php";
                }
            });

        }
    </script>
</div>