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
