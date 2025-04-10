document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("registerForm")
    .addEventListener("submit", function (e) {
      let password = document.getElementById("password").value;
      let confirmPassword = document.getElementById("confirmPassword").value;
      let passwordError = document.getElementById("passwordError");

      passwordError.innerHTML = "";

      if (password !== confirmPassword) {
        passwordError.innerHTML = "Passwords do not match.<br>";
        e.preventDefault();
        return;
      }

      if (!/^[A-Za-z0-9]+$/.test(password)) {
        passwordError.innerHTML = "Password must be alphanumeric.<br>";
        e.preventDefault();
        return;
      }

      if (password.length < 5 || password.length > 30) {
        passwordError.innerHTML =
          "Password must be between 5 and 30 characters.<br>";
        e.preventDefault();
        return;
      }
    });
});
