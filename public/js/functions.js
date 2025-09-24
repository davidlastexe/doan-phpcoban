export function showToast({ toastContainer, message, type = "success", duration = 3000, }) {
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
