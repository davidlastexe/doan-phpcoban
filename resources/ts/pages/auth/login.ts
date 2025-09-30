import { FULL_URL } from "../../app";
import { spinnerIcon } from "../../utils/constants";
import { authService } from "../../services/auth-service";
import { toastManager } from "../../toast-manager";
import { helpers } from "../../utils/helpers";

const loginForm = document.getElementById("login-form") as HTMLFormElement;
const inputs = loginForm.querySelectorAll<HTMLInputElement>("[data-field]");

// TODO: hàm được dùng nhiều nơi nên xây dựng thành class helper
async function validateField(input: HTMLInputElement): Promise<boolean> {
  const fieldName = input.name;
  const value = input.value?.trim();
  let errorMessage = "";

  helpers.clearError(fieldName);

  switch (fieldName) {
    case "email":
      if (!value) errorMessage = "Email không được bỏ trống!";
      else if (!helpers.validateEmail(value))
        errorMessage = "Email không hợp lệ!";
      break;

    case "password":
      if (!value) errorMessage = "Mật khẩu không được để trống!";
      break;
  }

  if (errorMessage) {
    helpers.displayError(fieldName, errorMessage);
    return false;
  }
  return true;
}

inputs.forEach((input) => {
  input.addEventListener("blur", () => {
    validateField(input);
  });
});

loginForm.addEventListener("submit", async (event: SubmitEvent) => {
  event.preventDefault();

  let isFormValid = true;

  const validationPromises = Array.from(inputs).map((input) =>
    validateField(input)
  );
  const results = await Promise.all(validationPromises);

  isFormValid = results.every((isValid) => isValid);

  if (!isFormValid) return;

  // TODO: tạo hệ thống hoặc gì đó giúp tối ưu handle loading
  const submitButton = loginForm.querySelector<HTMLButtonElement>(
    'button[type="submit"]'
  );
  if (submitButton) {
    submitButton.disabled = true;
    submitButton.innerHTML = `${spinnerIcon} Đang đăng nhập...`;
  }

  try {
    const formData = new FormData(loginForm);
    const result = await authService.login(formData);

    if (result.success) {
      toastManager.createToast({
        message: result.message,
        type: "success",
      });
      window.location.href = `${FULL_URL}`;
      loginForm.reset();
    } else if (result.errors) {
      Object.keys(result.errors).forEach((key) => {
        helpers.displayError(key, result.errors![key]![0]!);
      });
    } else {
      toastManager.createToast({
        message: result.message,
        type: "error",
      });
    }
  } catch (error) {
    console.log(error);
    toastManager.createToast({
      message: "Lỗi kết nối máy chủ!",
      type: "error",
    });
  } finally {
    if (submitButton) {
      submitButton.disabled = false;
      submitButton.innerHTML = "Đăng nhập";
    }
  }
});
