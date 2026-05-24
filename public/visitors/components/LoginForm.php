    <?php
    include __DIR__ . '/forgotPasswordModal.php';
    include __DIR__ . '/OTPModal.php';
    include __DIR__ . '/updatePasswordModal.php';
    ?>

    <form id="loginForm">
        <!-- Email -->
        <div class="form-floating mb-3">
            <input
                type="email"
                class="form-control form-control-sm"
                name="email"
                placeholder="name@example.com"
                autocomplete="email"
                required>
            <label for="loginEmail">
                <i class="bi bi-envelope me-1"></i>Email Address
            </label>
        </div>

        <!-- Password -->
        <div class="form-floating mb-3">
            <input
                type="password"
                class="form-control"
                name="password"
                placeholder="Password"
                required>
            <label for="loginPassword">
                <i class="bi bi-lock me-1"></i>Password
            </label>
            <div class="d-flex">
                <small class="text-success ms-auto" data-bs-toggle="modal" data-bs-target="#forgotPasswordEmailModal" style="cursor: pointer;">Forgot Password?</small>
            </div>
        </div>

        <!-- Button -->
        <div class="d-flex">
            <button
                type="submit"
                class="btn btn-success mx-auto w-100 py-2 fw-semibold">
                Login
            </button>
        </div>
    </form>

    <script>
        document.getElementById('emailSubmissionModal').addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!this.checkValidity()) {
                this.reportValidity();
                return;
            }

            const submitBtn = document.getElementById("submitBtn");
            const formData = new FormData(this);
            formData.append('action', 'emailExists');

            submitBtn.innerHTML = `<div class="spinner-border spinner-border-sm text-light" role="status">
                                   <span class="visually-hidden">Loading...</span>
                                   </div>`;

            try {
                const emailExists = await fetch(`../backend/forgotPasswordController.php`, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                });

                if (!emailExists.ok) {
                    document.querySelector(".toast-body").textContent =
                        `Network response Error. Please try again.`;
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                        document.getElementById("liveToast"),
                    );
                    toastBootstrap.show();
                }

                const emailExistsData = await emailExists.json();

                if (!emailExistsData.success) {
                    document.querySelector(".toast-body").textContent =
                        emailExistsData.message;
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                        document.getElementById("liveToast"),
                    );
                    toastBootstrap.show();
                    submitBtn.innerHTML = `Confirm`;
                    return;
                }

                document.querySelector(".toast-body").textContent =
                    emailExistsData.message;
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();

                let recoveryEmail = emailExistsData.recoveryEmail;
                let email = emailExistsData.email;

                sendOTP(recoveryEmail, email);
                return;
            } catch {
                document.querySelector(".toast-body").textContent =
                    `Something went wrong. Please Try again.`;
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();
                return;
            }
        });
        async function sendOTP(recoveryEmail, email) {

            try {
                const sendOTP = await fetch(`../backend/forgotPasswordController.php`, {
                    method: 'POST',
                    body: new URLSearchParams({
                        recoveryEmail: recoveryEmail,
                        email: email,
                        action: 'sendOTP',
                    }),
                    credentials: 'same-origin',
                });


                if (!sendOTP.ok) {
                    document.querySelector(".toast-body").textContent =
                        `Network response Error. Please try again.`;
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                        document.getElementById("liveToast"),
                    );
                    toastBootstrap.show();
                    return;
                }

                const sendOTPData = await sendOTP.json();

                if (!sendOTPData.success) {
                    document.querySelector(".toast-body").textContent =
                        sendOTPData.message;
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                        document.getElementById("liveToast"),
                    );
                    toastBootstrap.show();
                    return;
                }

                document.querySelector(".toast-body").textContent =
                    sendOTPData.message;
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();

                let forgotPasswordEmailModal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById("forgotPasswordEmailModal"),
                );
                forgotPasswordEmailModal.hide();

                let OTP_Modal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById("otpModal"),
                );
                OTP_Modal.show();

            } catch (err) {
                document.querySelector(".toast-body").textContent =
                    `Can not send OTP. Please Try again.`;
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();
            } finally {
                submitBtn.innerHTML = `Submit`;
            }
        }

        document.getElementById("OTP_form").addEventListener("submit", async e => {
            e.preventDefault();

            const otp_form = document.getElementById("OTP_form");
            const verifyOTP_btn = document.getElementById("verifyOTP_btn");

            const digit1 = document.querySelector('input[name="Digit1"]').value;
            const digit2 = document.querySelector('input[name="Digit2"]').value;
            const digit3 = document.querySelector('input[name="Digit3"]').value;
            const digit4 = document.querySelector('input[name="Digit4"]').value;
            const digit5 = document.querySelector('input[name="Digit5"]').value;
            const digit6 = document.querySelector('input[name="Digit6"]').value;

            const otp = digit1 + digit2 + digit3 + digit4 + digit5 + digit6; // Concatenate the digits to form the OTP

            verifyOTP_btn.disabled = true;
            verifyOTP_btn.innerHTML =
                '<span class="spinner-grow spinner-grow-sm text-dark" role ="status"> <span class="visually-hidden"> Loading... </span></span>';

            const verifyOTP = await fetch(`../backend/forgotPasswordController.php`, {
                method: "POST",
                body: new URLSearchParams({
                    action: "verifyOTP",
                    otp: otp,
                }),
                credentials: "same-origin",
            });

            if (!verifyOTP.ok) {
                document.querySelector(".toast-body").textContent =
                    'Network response Error. Please try again';
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();
                return;
            }

            const verifyOTPData = await verifyOTP.json();

            if (!verifyOTPData.success) {
                document.querySelector(".toast-body").textContent =
                    verifyOTPData.message;
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                    document.getElementById("liveToast"),
                );
                toastBootstrap.show();
                return;
            }

            document.querySelector(".toast-body").textContent =
                verifyOTPData.message;
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
                document.getElementById("liveToast"),
            );
            toastBootstrap.show();

            let OTP_Modal = bootstrap.Modal.getOrCreateInstance(
                document.getElementById("otpModal"),
            );
            let newPasswordModal = bootstrap.Modal.getOrCreateInstance(
                document.getElementById("newPasswordModal"),
            );
            OTP_Modal.hide();
            newPasswordModal.show();
            return;

        });
    </script>