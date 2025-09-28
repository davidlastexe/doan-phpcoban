import { AppConfig } from "../app.js";
import type { DefaultResponse, LoginResponse } from "../type.js";

class AuthService {
  private accessToken: string | null = null;
  private refreshTokenPromise: Promise<any> | null = null;

  constructor() {
    this.accessToken = localStorage.getItem("access_token");
  }

  async checkEmailExists(email: string) {
    const url = `${AppConfig.baseUrl}/api/check-email?email=${email}`;
    try {
      const result: DefaultResponse<{ exists?: boolean }> = await fetch(
        url
      ).then((res) => res.json());
      if (result.data) return result.data.exists;
      return false;
    } catch (error) {
      console.error(error);
    }
  }

  isLoggedIn(): boolean {
    return this.accessToken !== null;
  }

  async register(formData: FormData) {
    const url = `${AppConfig.baseUrl}/api/register`;

    const result: DefaultResponse<{ errors?: string[][] }> = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    return result;
  }

  async login(formData: FormData) {
    const url = `${AppConfig.baseUrl}/api/login`;

    const result: DefaultResponse<LoginResponse> = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    if (result.success && result.data) {
      this.accessToken = result.data.access_token;
      localStorage.setItem("access_token", result.data.access_token);
    }
    return result;
  }

  logout() {
    this.accessToken = null;
    localStorage.removeItem("access_token");
    // NOTE: chưa xây dựng api này
    fetch("/api/logout", { method: "POST" });
  }

  async fetchWithAuth(
    url: string,
    options: RequestInit = {}
  ): Promise<Response> {
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
      } catch (error) {
        console.error("Failed to refresh token. Logging out.", error);
        this.logout();
        window.location.href = "/login";
      }
    }

    return response;
  }

  private async refreshToken(): Promise<string> {
    if (!this.refreshTokenPromise) {
      // NOTE: chưa xây dựng api này
      this.refreshTokenPromise = fetch("/api/refresh-token", { method: "POST" })
        .then(async (res) => {
          if (!res.ok) throw new Error("Refresh token failed");
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
