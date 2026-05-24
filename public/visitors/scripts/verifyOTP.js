export async function verifyOTP(e) {
  e.preventDefault();

  const otp_form = document.getElementById("OTP_form");
  const verifyOTP_btn = document.getElementById("verifyOTP_btn");
  const recoveryEmailInput = document.getElementById("recoveryEmailInput");
  const confirmPasswordInput = document.getElementById("confirmPassword");

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

  try {
    const res = await fetch("../backend/registrationOTP.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "verify_otp",
        otp: otp,
      }),
      credentials: "same-origin",
    });

    if (!res.ok) {
      document.querySelector(".toast-body").textContent =
        "Network Response Error. Please try again.";
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
        document.getElementById("liveToast"),
      );
      toastBootstrap.show();
      throw new Error("Request failed");
    }

    const response = await res.json(); // * JSON RESPONSE

    if (response.success) {
      // IF OTP VERIFICATION IS A SUCCESS
      const form = document.getElementById("registrationForm");

      const registerRes = await fetch(`../backend/registerUser.php`, {
        method: "POST",
        body: new FormData(form),
        credentials: "same-origin",
      });

      if (!registerRes.ok) {
        document.querySelector(".toast-body").textContent =
          "Network Response Error. Please try again.";
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
          document.getElementById("liveToast"),
        );
        toastBootstrap.show();
      }

      const registerResponse = await registerRes.json(); // * JSON RESPONSE

      if (registerResponse.success) {
        // IF REGISTRATION IS A SUCCESS
        document.querySelector(".toast-body").textContent =
          registerResponse.message;
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
          document.getElementById("liveToast"),
        );
        let OTP_Modal = bootstrap.Modal.getOrCreateInstance(
          document.getElementById("otpModal"),
        );

        OTP_Modal.hide();
        toastBootstrap.show();
        form.reset();

        recoveryEmailInput.classList.remove("border-danger", "border-success");

        confirmPasswordInput.classList.remove(
          "border-danger",
          "border-success",
        );

        otp_form.reset();
        window.scrollTo(0, 0);
      } else {
        // IF REGISTRATION FAILED
        document.querySelector(".toast-body").textContent =
          registerResponse.message;
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
          document.getElementById("liveToast"),
        );
        toastBootstrap.show();
      }
    } else {
      // IF OTP VERIFICATION FAILED
      document.querySelector(".toast-body").textContent = response.message;
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
        document.getElementById("liveToast"),
      );
      toastBootstrap.show();
    }
  } catch (error) {
    document.querySelector(".toast-body").textContent =
      "An Error Occured. Please try again...";
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
      document.getElementById("liveToast"),
    );
    toastBootstrap.show();
  } finally {
    verifyOTP_btn.disabled = false;
    verifyOTP_btn.textContent = "Verify";
  }
}
