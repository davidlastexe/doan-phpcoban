import { authService } from "../services/auth-service";
import { Helpers } from "../utils/helpers";

const logoutBtn = document.getElementById("btn-logout");

logoutBtn?.addEventListener("click", async () => {
  await authService.logout();
  Helpers.redirect("/login");
});
