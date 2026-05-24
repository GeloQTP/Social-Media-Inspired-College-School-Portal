function validateInputs() {
  const registrationForm = {
    // Personal Information
    firstName: document.getElementById("firstNameInput").value,
    lastName: document.getElementById("lastNameInput").value,
    middleName: document.getElementById("middleNameInput").value,
    extensionName: document.getElementById("extensionName").value,
    birthDate: document.getElementById("birthdateInput").value,
    age: document.getElementById("ageInput").value,
    nationality: document.getElementById("nationalityInput").value,
    civilStatus: document.getElementById("civilStatusInput").value,
    gender: document.getElementById("genderInput").value,

    // Contact Information
    email: document.getElementById("emailInput").value,
    phoneNumber: document.getElementById("phoneNumberInput").value,
    address: document.getElementById("addressInput").value,
    barangay: document.getElementById("barangayInput").value,
    city: document.getElementById("cityInput").value,
    province: document.getElementById("provinceInput").value,
    zipCode: document.getElementById("zipcodeInput").value,

    // Academic Information
    program: document.getElementById("programInput").value,
    graduationYear: document.getElementById("graduationYear").value,

    // Account Information
    accountUsername: document.getElementById("accountUsernameInput").value,
    password: document.getElementById("passwordInput").value,
    confirmPassword: document.getElementById("confirmPassword").value,
    recoveryEmail: document.getElementById("recoveryEmailInput").value,
  };

  const hasEmptyField = Object.values(registrationForm).some(
    (value) => value === "" || value === null || value === undefined,
  );

  if (hasEmptyField) {
    return false;
  } else {
    return true;
  }
}

function validateEmail() {
  const recoveryEmailInput = document.getElementById("recoveryEmailInput");
  const emailStatus = document.getElementById("emailStatus");

  const recoveryEmail = recoveryEmailInput.value.trim();
  const email = document.getElementById("emailInput").value.trim();

  // Empty check
  if (!recoveryEmail || !email) {
    recoveryEmailInput.classList.remove("border-danger", "border-success");
    emailStatus.innerHTML = "";
    return false;
  }

  // EMAIL CHECKING
  if (recoveryEmail === email) {
    recoveryEmailInput.classList.add("border-danger");
    recoveryEmailInput.classList.remove("border-success");
    emailStatus.innerHTML = "Can't be the same as Email";
    return false;
  }

  // Valid
  recoveryEmailInput.classList.add("border-success");
  recoveryEmailInput.classList.remove("border-danger");
  emailStatus.innerHTML = "";
  return true;
}

function validatePassword() {
  const password = document.getElementById("passwordInput").value,
    confirmPassword = document.getElementById("confirmPassword").value;

  const confirmPasswordInput = document.getElementById("confirmPassword");
  const passwordStatus = document.getElementById("passwordStatus");

  if (!password || !confirmPassword) {
    passwordStatus.innerHTML = "";
    confirmPasswordInput.classList.remove("border-danger", "border-success");
    return false;
  }

  if (password !== confirmPassword) {
    passwordStatus.innerHTML = "Password mismatch";
    confirmPasswordInput.classList.add("border-danger");
    return false;
  }

  passwordStatus.innerHTML = "";
  confirmPasswordInput.classList.remove("border-danger");
  confirmPasswordInput.classList.add("border-success");
  return true;
}

window.addEventListener("DOMContentLoaded", () => {
  const registerBtn = document.getElementById("registerBtn"),
    understoodEULAButton = document.getElementById("acceptEULA"),
    eulaCheckBox = document.getElementById("termsCheck");
  registerBtn.disabled = true;
  understoodEULAButton.disabled = true;

  document.getElementById("registrationForm").addEventListener("input", () => {
    const isValid = validateInputs() && validateEmail() && validatePassword();

    registerBtn.disabled = !isValid;
    understoodEULAButton.disabled = !eulaCheckBox.checked;
  });
});
