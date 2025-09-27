export function showToast({ toastContainer, message, type = "success", duration = 5000, }) {
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
export const displayError = (fieldName, message) => {
    const errorElement = document.querySelector(`.error-log[data-field="${fieldName}"]`);
    if (errorElement) {
        message === ""
            ? errorElement.classList.add("hidden")
            : errorElement.classList.remove("hidden");
        errorElement.textContent = message;
    }
};
export const clearError = (fieldName) => {
    displayError(fieldName, "");
};
