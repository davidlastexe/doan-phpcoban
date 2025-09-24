import { AppConfig } from "./app.js";
import type { RegisterResponse } from "./type.js";

const registerForm = document.getElementById(
  "register-form"
) as HTMLFormElement;
const registerToast = document.getElementById(
  "register-toast"
) as HTMLDivElement;
const inputs = registerForm.querySelectorAll<HTMLInputElement>("[data-field]");

function createToast(message: string) {
  const newToast = document.createElement("div");
  const spanText = document.createElement("span");
  spanText.textContent = message;
  newToast.classList.add("alert", "alert-success");
  newToast.appendChild(spanText)

  return newToast;
}

function displayError(fieldName: string, message: string) {
  const errorElement = document.querySelector(
    `.error-log[data-field="${fieldName}"]`
  );
  if (errorElement) {
    message === ""
      ? errorElement.classList.add("hidden")
      : errorElement.classList.remove("hidden");
    errorElement.textContent = message;
  }
}

function clearError(fieldName: string) {
  displayError(fieldName, "");
}

async function checkEmailExists(email: string) {
  const url = `${AppConfig.baseUrl}/api/check-email?email=${email}`;
  try {
    const result: { exists: string | boolean; error: string } = await fetch(
      url
    ).then((res) => res.json());
    return result.exists;
  } catch (error) {
    if (error instanceof Error) {
      console.error(error.message);
    } else {
      console.error(error);
    }
  }
}

function validateEmail(email: string): boolean {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function isPhone(phone: string): boolean {
  let cleaned = phone.replace(/[^0-9+]/g, "");
  if (cleaned.startsWith("+84")) cleaned = "0" + cleaned.slice(3);
  const regex = /^(0)(3[2-9]|5[689]|7[06-9]|8[1-689]|9[0-46-9])[0-9]{7}$/;
  return regex.test(cleaned);
}

async function validateField(input: HTMLInputElement): Promise<boolean> {
  const fieldName = input.name;
  const value = input.value?.trim();
  let errorMessage = "";

  clearError(fieldName);

  switch (fieldName) {
    case "full_name":
      if (!value) errorMessage = "Họ tên không được bỏ trống!";
      else if (value.length < 5)
        errorMessage = "Họ tên phải có ít nhất 5 ký tự!";
      break;

    case "email":
      const resCheckMail = await checkEmailExists(value);
      if (!value) errorMessage = "Email không được bỏ trống!";
      else if (!validateEmail(value)) errorMessage = "Email không hợp lệ!";
      else if (await checkEmailExists(value))
        errorMessage = "Email này đã được sử dụng!";
      break;

    case "phone_number":
      if (value) {
        if (!isPhone(value)) errorMessage = "Số điện thoại không hợp lệ!";
      }
      break;

    case "password":
      if (!value) errorMessage = "Mật khẩu không được để trống!";
      else if (value.length < 6)
        errorMessage = "Mật khẩu phải lớn hơn 6 ký tự!";
      break;

    case "confirm_password":
      const passwordInput =
        registerForm.querySelector<HTMLInputElement>("[name='password']");
      if (!value) errorMessage = "Hãy nhập lại mật khẩu!";
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

registerForm.addEventListener("submit", async (event: SubmitEvent) => {
  event.preventDefault();

  let isFormValid = true;

  const validationPromises = Array.from(inputs).map((input) =>
    validateField(input)
  );
  const results = await Promise.all(validationPromises);

  isFormValid = results.every((isValid) => isValid);

  if (!isFormValid) return;

  try {
    const formData = new FormData(registerForm);
    const url = `${AppConfig.baseUrl}/api/register`;

    const result: RegisterResponse = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    if (result.data) {
      registerToast.appendChild(createToast(result.message));
      window.location.href = result.data.redirect_url;
    }
  } catch (error) {
    console.log(error);
  }
});