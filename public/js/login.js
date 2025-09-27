import { AppConfig } from "./app.js";
import { validateEmail } from "./auth-functions.js";
import { clearError, displayError, showToast } from "./functions.js";
const loginForm = document.getElementById("login-form");
const loginToast = document.getElementById("login-toast");
const inputs = loginForm.querySelectorAll("[data-field]");
async function validateField(input) {
    const fieldName = input.name;
    const value = input.value?.trim();
    let errorMessage = "";
    clearError(fieldName);
    switch (fieldName) {
        case "email":
            if (!value)
                errorMessage = "Email không được bỏ trống!";
            else if (!validateEmail(value))
                errorMessage = "Email không hợp lệ!";
            break;
        case "password":
            if (!value)
                errorMessage = "Mật khẩu không được để trống!";
            break;
    }
    if (errorMessage) {
        displayError(fieldName, errorMessage);
        return false;
    }
    return true;
}
inputs.forEach((input) => {
    input.addEventListener("blur", () => {
        validateField(input);
    });
});
loginForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    let isFormValid = true;
    const validationPromises = Array.from(inputs).map((input) => validateField(input));
    const results = await Promise.all(validationPromises);
    isFormValid = results.every((isValid) => isValid);
    if (!isFormValid)
        return;
    try {
        const formData = new FormData(loginForm);
        const url = `${AppConfig.baseUrl}/api/login`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        if (result.success && result.data) {
            showToast({
                toastContainer: loginToast,
                message: result.message,
                type: "success",
            });
            localStorage.setItem("access_token", result.data.access_token);
            loginForm.reset();
        }
        else {
            showToast({
                toastContainer: loginToast,
                message: result.message,
                type: "error",
            });
        }
    }
    catch (error) {
        console.log(error);
    }
});
