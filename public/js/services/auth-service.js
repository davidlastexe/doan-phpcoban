import { FULL_URL } from "../app.js";
class AuthService {
    accessToken = null;
    refreshTokenPromise = null;
    constructor() {
        this.accessToken = localStorage.getItem("access_token");
    }
    async checkEmailExists(email) {
        const url = `${FULL_URL}/api/check-email?email=${email}`;
        try {
            const result = await fetch(url).then((res) => res.json());
            if (result.success)
                return result.data.exists;
            return false;
        }
        catch (error) {
            console.error(error);
        }
    }
    isLoggedIn() {
        return this.accessToken !== null;
    }
    async register(formData) {
        const url = `${FULL_URL}/api/register`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        return result;
    }
    async activateAccount(formData) {
        const url = `${FULL_URL}/api/activate`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        return result;
    }
    async login(formData) {
        const url = `${FULL_URL}/api/login`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        if (result.success && result.data) {
            this.accessToken = result.data.access_token;
            localStorage.setItem("access_token", result.data.access_token);
        }
        return result;
    }
    async forgotPassword(formData) {
        const url = `${FULL_URL}/api/forgot-password`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        return result;
    }
    async resetPassword(formData) {
        const url = `${FULL_URL}/api/reset-password`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        return result;
    }
    logout() {
        this.accessToken = null;
        localStorage.removeItem("access_token");
        // NOTE: chưa xây dựng api này
        fetch("/api/logout", { method: "POST" });
    }
    async fetchWithAuth(url, options = {}) {
        let token = this.accessToken;
        const headers = new Headers(options.headers || {});
        if (token) {
            headers.set("Authorization", `Bearer ${token}`);
        }
        options.headers = headers;
        let response = await fetch(url, options);
        if (response.status === 401) {
            try {
                const newAccessToken = await this.refreshToken();
                headers.set("Authorization", `Bearer ${newAccessToken}`);
                options.headers = headers;
                console.log("Token refreshed. Retrying the original request...");
                response = await fetch(url, options);
            }
            catch (error) {
                console.error("Failed to refresh token. Logging out.", error);
                this.logout();
                window.location.href = "/login";
            }
        }
        return response;
    }
    async refreshToken() {
        if (!this.refreshTokenPromise) {
            // NOTE: chưa xây dựng api này
            this.refreshTokenPromise = fetch("/api/refresh-token", { method: "POST" })
                .then(async (res) => {
                if (!res.ok)
                    throw new Error("Refresh token failed");
                const data = await res.json();
                this.login(data.access_token);
                return data.access_token;
            })
                .finally(() => {
                this.refreshTokenPromise = null;
            });
        }
        return this.refreshTokenPromise;
    }
}
export const authService = new AuthService();
