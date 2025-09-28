import { AppConfig } from "../app.js";
import { validateEmail } from "../auth-functions.js";
import { spinnerIcon } from "../constants.js";
import { clearError, displayError } from "../functions.js";
import { authService } from "../services/auth-service.js";
import { toastManager } from "../toast-manager.js";
const loginForm = document.getElementById("login-form");
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
    // TODO: tạo hệ thống hoặc gì đó giúp tối ưu handle loading
    const submitButton = loginForm.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = `${spinnerIcon} Đang đăng nhập...`;
    }
    try {
        const formData = new FormData(loginForm);
        const result = await authService.login(formData);
        if (result.success && result.data) {
            toastManager.createToast({
                message: result.message,
                type: "success",
            });
            window.location.href = `${AppConfig.production ? "/" : AppConfig.projectName}`;
            loginForm.reset();
        }
        else {
            toastManager.createToast({
                message: result.message,
                type: "error",
            });
        }
    }
    catch (error) {
        console.log(error);
        toastManager.createToast({
            message: "Lỗi kết nối máy chủ!",
            type: "error",
        });
    }
    finally {
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = "Đăng nhập";
        }
    }
});
