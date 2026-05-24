<!-- FORGOT PASSWORD MODAL -->
<div class="modal fade" id="newPasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="newPasswordForm">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">
                        <i class="bi bi-shield-lock me-2"></i>
                        Create New Password
                    </h1>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <input
                            type="password"
                            class="form-control form-control-sm email-input mb-2"
                            name="password"
                            id="password"
                            required>
                        <label for="loginEmail">
                            <i class="bi bi-shield-lock me-1"></i>New Password
                        </label>
                    </div>
                    <div class="form-floating">
                        <input
                            type="password"
                            class="form-control form-control-sm email-input"
                            name=""
                            id="confirmPassword"
                            required>
                        <label for="loginEmail">
                            <i class="bi bi-shield-lock me-1"></i>Confirm Password
                        </label>
                    </div>
                </div>
                <p class="small text-danger ms-4 d-none" id="passNoMatch">Password does not match</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitPassword" class="btn btn-success">Confirm Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const newPasswordForm = document.getElementById("newPasswordForm");
    const submitPassword = document.getElementById("submitPassword");

    document.getElementById("newPasswordModal").addEventListener("submit", async e => {
        e.preventDefault();

        const newPasswordFormData = new FormData(newPasswordForm);

        submitPassword.innerHTML =
            '<span class="spinner-grow spinner-grow-sm" style="margin-bottom:3px" role ="status"> <span class="visually-hidden"> Loading... </span></span>';

        try {
            const updatePasswordResponse = await fetch(`../backend/newPassword.php`, {
                method: 'POST',
                body: newPasswordFormData,
                credentials: "same-origin",
            });

            if (!updatePasswordResponse.ok) {
                toastBootstrap.show();
                return;
            }

            const updatePasswordResponseData = await updatePasswordResponse.json();

            if (!updatePasswordResponseData.success) {
                document.querySelector(".toast-body").textContent =
                    updatePasswordResponseData.message;
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();
                return;
            }
            let newPasswordModal = bootstrap.Modal.getOrCreateInstance(
                document.getElementById("newPasswordModal"),
            );
            newPasswordModal.hide();

            Swal.fire({
                title: "New Password Set",
                text: "Your Password has been updated.",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });

        } catch (err) {
            document.querySelector(".toast-body").textContent =
                'Someting went wrong. Please try again.';
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                document.getElementById("liveToast"),
            );
            toastBootstrap.show();
            return;
        } finally {
            submitPassword.innerHTML =
                'Confirm Password';
            return;
        }

    });
</script>

<script>
    submitPassword.disabled = true;

    newPasswordForm.addEventListener("input", () => {
        submitPassword.disabled = isPasswordValid();
    });

    function isPasswordValid() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        const passNoMatch = document.getElementById("passNoMatch");

        if (password !== confirmPassword) {
            passNoMatch.classList.remove("d-none");
            passNoMatch.classList.add("d-block");
            return true;
        }

        passNoMatch.classList.remove("d-block");
        passNoMatch.classList.add("d-none");
        return false;
    }
</script>