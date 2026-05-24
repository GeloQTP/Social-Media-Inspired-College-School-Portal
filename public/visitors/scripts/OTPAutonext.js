//OTP AUTO NEXT
document.addEventListener("DOMContentLoaded", function () {
  const otpInputs = document.querySelectorAll('#otpModal input[type="text"]');

  otpInputs.forEach((input, index) => {
    // Move to next input on input
    input.addEventListener("input", function (e) {
      if (this.value.length === 1 && index < otpInputs.length - 1) {
        otpInputs[index + 1].focus();
      }
    });

    // Handle backspace to move to previous input
    input.addEventListener("keydown", function (e) {
      if (e.key === "Backspace" && this.value === "" && index > 0) {
        otpInputs[index - 1].focus();
      }
    });

    // Prevent typing more than 1 character
    input.addEventListener("input", function (e) {
      if (this.value.length > 1) {
        this.value = this.value.slice(0, 1);
      }
    });

    // Only allow numbers
    input.addEventListener("keypress", (e) => {
      if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
      }
    });
  });

  // Auto-focus first input when modal opens
  const modal = document.getElementById("otpModal");
  modal.addEventListener("shown.bs.modal", () => {
    otpInputs[0].focus();
  });
});
