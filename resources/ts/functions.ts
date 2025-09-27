import type { ToastType } from "./type.js";

export function showToast({
  toastContainer,
  message,
  type = "success",
  duration = 5000,
}: {
  toastContainer: HTMLDivElement;
  message: string;
  type?: ToastType;
  duration?: number;
}): void {
  const toastElement = document.createElement("div");
  toastElement.classList.add("custom-toast", type);
  toastElement.textContent = message;

  toastContainer.appendChild(toastElement);

  setTimeout(() => {
    toastElement.classList.add("show");
  }, 10);

  setTimeout(() => {
    toastElement.classList.remove("show");

    toastElement.addEventListener("transitionend", () => {
      toastElement.remove();
    });
  }, duration);
}

export const displayError = (fieldName: string, message: string) => {
  const errorElement = document.querySelector(
    `.error-log[data-field="${fieldName}"]`
  );
  if (errorElement) {
    message === ""
      ? errorElement.classList.add("hidden")
      : errorElement.classList.remove("hidden");
    errorElement.textContent = message;
  }
};

export const clearError = (fieldName: string) => {
  displayError(fieldName, "");
};
