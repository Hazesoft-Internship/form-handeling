document.addEventListener("DOMContentLoaded", function () {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password_confirmation");
    const message = document.getElementById("passwordMessage");
    const submitBtn = document.getElementById("submitBtn");

    function checkPasswordMatch() {
        if (password.value === confirmPassword.value) {
            message.textContent = "Passwords match";
            message.classList.remove("error");
            message.classList.add("success");
            submitBtn.disabled = false;
        } else {
            message.textContent = "Passwords do not match";
            message.classList.remove("success");
            message.classList.add("error");
            submitBtn.disabled = true;
        }
    }

    password.addEventListener("input", checkPasswordMatch);
    confirmPassword.addEventListener("input", checkPasswordMatch);
});
