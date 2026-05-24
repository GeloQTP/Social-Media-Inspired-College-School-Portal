export async function sendOTP(e) {
  e.preventDefault();

  const form = document.getElementById("registrationForm");
  const acceptBtn = document.getElementById("acceptEULA");

  acceptBtn.disabled = true;
  acceptBtn.innerHTML =
    '<span class="spinner-border spinner-border-sm text-dark" role ="status"> <span class="visually-hidden"> Loading... </span></span>';

  const formData = new FormData(form);
  formData.append("action", "send_otp");

  try {
    const res = await fetch(`../backend/registrationOTP.php`, {
      method: "POST",
      body: formData,
      credentials: "same-origin",
    });

    if (!res.ok) {
      document.querySelector(".toast-body").textContent =
        "Request Error. Please try again.";
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
        document.getElementById("liveToast"),
      );
      toastBootstrap.show();
    }

    const result = await res.json();

    if (result.success) {
      let OTP_Modal = bootstrap.Modal.getOrCreateInstance(
        document.getElementById("otpModal"),
      );
      OTP_Modal.show();

      document.querySelector(".toast-body").textContent = "OTP Sent.";
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
        document.getElementById("liveToast"),
      );
      toastBootstrap.show();
    }
  } catch (error) {
    document.querySelector(".toast-body").textContent =
      "An error occurred. Please try again.";
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(
      document.getElementById("liveToast"),
    );
    toastBootstrap.show();
  } finally {
    acceptBtn.disabled = false;
    acceptBtn.innerHTML = "Understood";

    let eulaModal = bootstrap.Modal.getOrCreateInstance(
      document.getElementById("eulaModal"),
    );

    eulaModal.hide();
  }
}
