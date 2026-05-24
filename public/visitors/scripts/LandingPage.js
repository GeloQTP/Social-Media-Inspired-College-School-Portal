document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector(".news-input");
  const emailInput = document.querySelector(".news-input input");
  const submitBtn = document.querySelector(".news-input button");
  const toastNotif = document.getElementById("liveToast");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    submitBtn.disabled = true; // disable the submit button to avoid double submittion.
    submitBtn.innerHTML =
      '<span class="spinner-grow spinner-grow-sm" style="margin-bottom:3px" role ="status"> <span class="visually-hidden"> Loading... </span></span>';

    try {
      const response = await fetch(`../backend/newsletterSubscription.php`, {
        method: "POST",
        body: new FormData(form),
        credentials: "same-origin",
      });

      if (!response.ok) {
        document.querySelector(".toast-body").textContent =
          "Network response was not ok";
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastNotif);
        toastBootstrap.show();
      }

      const result = await response.json();

      document.querySelector(".toast-body").textContent = result.message;
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastNotif);
      toastBootstrap.show();

    } catch (error) {
      document.querySelector(".toast-body").textContent =
        "An error occurred. Please try again.";
      const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastNotif);
      toastBootstrap.show();
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = "Submit";
      emailInput.value = ""; // clear the form input
    }
  });
});
