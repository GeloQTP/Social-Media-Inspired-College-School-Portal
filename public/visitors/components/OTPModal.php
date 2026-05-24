    <div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class=" modal-content bg-light text-dark">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5 display-5" id="staticBackdropLabel">OTP Verification</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="OTP_form" autocomplete="off">
                    <div class="modal-body">

                        <div class="text-center text-secondary">
                            <p>We&#39;ve sent a <strong>6-digit code</strong> to your email.
                                Enter it below to continue.</p>
                        </div>

                        <div class="row g-2 text-center">
                            <div class="col-2">
                                <input type="text" class="form-control text-center fs-2" name="Digit1" maxlength="1">
                            </div>
                            <div class=" col-2">
                                <input type="text" class="form-control text-center fs-2" name="Digit2" maxlength="1">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control text-center fs-2" name="Digit3" maxlength="1">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control text-center fs-2" name="Digit4" maxlength="1">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control text-center fs-2" name="Digit5" maxlength="1">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control text-center fs-2" name="Digit6" maxlength="1">
                            </div>
                        </div>

                        <br>

                        <div class="text-center text-secondary">
                            <small>Didn&#39;t receive it? Check your spam folder.</small>
                        </div>

                        <div class="text-center mt-2">
                            <a href="#" class="text-success text-decoration-none fw-semibold" id="resendOTP_link">
                                Resend OTP
                            </a>
                        </div>

                    </div>


                    <div class="modal-footer border-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success" id="verifyOTP_btn">Verify</button>
                    </div>

                </form>
            </div>
        </div>
    </div>