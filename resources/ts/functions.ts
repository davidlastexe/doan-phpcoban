import type { ToastType } from "./type.js";

export function showToast({
  toastContainer,
  message,
  type = "success",
  duration = 3000,
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
