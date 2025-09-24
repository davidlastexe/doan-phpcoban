import { AppConfig } from "./app.js";
import { showToast } from "./functions.js";
const registerForm = document.getElementById("register-form");
const registerToast = document.getElementById("register-toast");
const inputs = registerForm.querySelectorAll("[data-field]");
function displayError(fieldName, message) {
    const errorElement = document.querySelector(`.error-log[data-field="${fieldName}"]`);
    if (errorElement) {
        message === ""
            ? errorElement.classList.add("hidden")
            : errorElement.classList.remove("hidden");
        errorElement.textContent = message;
    }
}
function clearError(fieldName) {
    displayError(fieldName, "");
}
async function checkEmailExists(email) {
    const url = `${AppConfig.baseUrl}/api/check-email?email=${email}`;
    try {
        const result = await fetch(url).then((res) => res.json());
        return result.exists;
    }
    catch (error) {
        if (error instanceof Error) {
            console.error(error.message);
        }
        else {
            console.error(error);
        }
    }
}
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
function isPhone(phone) {
    let cleaned = phone.replace(/[^0-9+]/g, "");
    if (cleaned.startsWith("+84"))
        cleaned = "0" + cleaned.slice(3);
    const regex = /^(0)(3[2-9]|5[689]|7[06-9]|8[1-689]|9[0-46-9])[0-9]{7}$/;
    return regex.test(cleaned);
}
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
            const resCheckMail = await checkEmailExists(value);
            if (!value)
                errorMessage = "Email không được bỏ trống!";
            else if (!validateEmail(value))
                errorMessage = "Email không hợp lệ!";
            else if (await checkEmailExists(value))
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
        if (result.data) {
            showToast({ toastContainer: registerToast, message: result.message, type: "success", duration: 5000 });
            registerForm.reset();
        }
    }
    catch (error) {
        console.log(error);
    }
});
