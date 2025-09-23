import { changeThemeBtn } from "./constants.js";
export function changeTheme(themeName) {
    document.documentElement.setAttribute("data-theme", themeName);
    localStorage.setItem("theme", themeName);
}
changeThemeBtn?.addEventListener("change", (e) => {
    const target = e.target;
    const newTheme = target.checked ? "dark" : "light";
    changeTheme(newTheme);
});
