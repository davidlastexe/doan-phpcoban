import { AppConfig } from "../app.js";
import { isPhone, validateEmail } from "../auth-functions.js";
import { clearError, displayError, showToast } from "../functions.js";
import { authService } from "../services/auth-service.js";
const registerForm = document.getElementById("register-form");
const registerToast = document.getElementById("register-toast");
const inputs = registerForm.querySelectorAll("[data-field]");
async function validateField(input) {
    const fieldName = input.name;
    const value = input.value?.trim();
    let errorMessage = "";
    clearError(fieldName);
    switch (fieldName) {
        case "full_name":
            if (!value)
                errorMessage = "Họ tên không được bỏ trống!";
            else if (value.length < 5)
                errorMessage = "Họ tên phải có ít nhất 5 ký tự!";
            break;
        case "email":
            if (!value)
                errorMessage = "Email không được bỏ trống!";
            else if (!validateEmail(value))
                errorMessage = "Email không hợp lệ!";
            else if (await authService.checkEmailExists(value))
                errorMessage = "Email này đã được sử dụng!";
            break;
        case "phone_number":
            if (value) {
                if (!isPhone(value))
                    errorMessage = "Số điện thoại không hợp lệ!";
            }
            break;
        case "password":
            if (!value)
                errorMessage = "Mật khẩu không được để trống!";
            else if (value.length < 6)
                errorMessage = "Mật khẩu phải lớn hơn 6 ký tự!";
            break;
        case "confirm_password":
            const passwordInput = registerForm.querySelector("[name='password']");
            if (!value)
                errorMessage = "Hãy nhập lại mật khẩu!";
            else if (passwordInput && value !== passwordInput.value)
                errorMessage = "Mật khẩu không khớp!";
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
registerForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    let isFormValid = true;
    const validationPromises = Array.from(inputs).map((input) => validateField(input));
    const results = await Promise.all(validationPromises);
    isFormValid = results.every((isValid) => isValid);
    if (!isFormValid)
        return;
    try {
        const formData = new FormData(registerForm);
        const url = `${AppConfig.baseUrl}/api/register`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        if (result.success) {
            showToast({
                toastContainer: registerToast,
                message: result.message,
                type: "success",
            });
            registerForm.reset();
        }
        else if (result.data) {
            console.log(result.data);
        }
    }
    catch (error) {
        console.log(error);
    }
});
