<!-- FORGOT PASSWORD MODAL -->
<div class="modal fade" id="forgotPasswordEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="emailSubmissionModal">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Please Enter your Email</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <input
                            type="email"
                            class="form-control form-control-sm email-input"
                            name="email"
                            placeholder="name@example.com"
                            autocomplete="email"
                            required>
                        <label for="loginEmail">
                            <i class="bi bi-envelope me-1"></i>Email address
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submitBtn" class="btn btn-success">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>