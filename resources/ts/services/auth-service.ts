import { FULL_URL } from "../app";
import type { ApiResponse, LoginResponse } from "../type";
import { Helpers } from "../utils/helpers";

class AuthService {
  private accessToken: string | null = null;
  private refreshTokenPromise: Promise<any> | null = null;

  constructor() {
    this.accessToken = localStorage.getItem("access_token");
  }

  async checkEmailExists(email: string) {
    const formData = new FormData();
    formData.append("email", email);
    const url = `${FULL_URL}/api/check-email`;
    try {
      const result: ApiResponse<{ exists: boolean }> = await fetch(url, {
        method: "post",
        body: formData,
      }).then((res) => res.json());
      if (result.success) return result.data.exists;
      return false;
    } catch (error) {
      console.error(error);
    }
  }

  async checkPhoneNumberExists(phoneNumber: string) {
    const formData = new FormData();
    formData.append("phone_number", phoneNumber);
    const url = `${FULL_URL}/api/check-phone-number`;
    try {
      const result: ApiResponse<{ exists: boolean }> = await fetch(url, {
        method: "post",
        body: formData,
      }).then((res) => res.json());
      if (result.success) return result.data.exists;
      return false;
    } catch (error) {
      console.error(error);
    }
  }

  isLoggedIn(): boolean {
    return this.accessToken !== null;
  }

  async register(formData: FormData) {
    const url = `${FULL_URL}/api/register`;

    const result: ApiResponse<null> = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    return result;
  }

  async activateAccount(formData: FormData) {
    const url = `${FULL_URL}/api/activate`;

    const result: ApiResponse<null> = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    return result;
  }

  async login(formData: FormData) {
    const url = `${FULL_URL}/api/login`;

    const result: ApiResponse<LoginResponse> = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    if (result.success) {
      this.accessToken = result.data.access_token;
      localStorage.setItem("access_token", result.data.access_token);
    }
    return result;
  }

  async forgotPassword(formData: FormData) {
    const url = `${FULL_URL}/api/forgot-password`;

    const result: ApiResponse<null> = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    return result;
  }

  async resetPassword(formData: FormData) {
    const url = `${FULL_URL}/api/reset-password`;

    const result: ApiResponse<null> = await fetch(url, {
      method: "post",
      body: formData,
    }).then((res) => res.json());

    return result;
  }

  async logout() {
    const accessToken = this.accessToken;

    this.accessToken = null;
    localStorage.removeItem("access_token");

    try {
      const url = `${FULL_URL}/api/logout`;
      await fetch(url, {
        method: "post",
        headers: {
          Authorization: `Bearer ${accessToken}`,
        },
      }).then((res) => res.json());
    } catch (error) {
      console.error("Lỗi khi gọi API logout:", error);
    }
    Helpers.redirect("/login");
  }

  async fetchWithAuth(
    url: string,
    options: RequestInit = {}
  ): Promise<Response> {
    const token = this.accessToken;

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
        console.error("Lấy token thất bại. Đăng xuất.", error);
        this.logout();
        Helpers.redirect("/login");
      }
    }

    return response;
  }

  private async refreshToken(): Promise<string> {
    if (!this.refreshTokenPromise) {
      const url = `${FULL_URL}/api/refresh-token`;
      this.refreshTokenPromise = fetch(url, { method: "POST" })
        .then(async (res) => {
          if (!res.ok) throw new Error("Lấy refresh token thất bại!");
          const result = await res.json();
          if (result.success) {
            this.accessToken = result.data.access_token;
            localStorage.setItem("access_token", this.accessToken!);
            return this.accessToken;
          } else {
            throw new Error("Đã xảy ra lỗi từ refresh token API");
          }
        })
        .finally(() => {
          this.refreshTokenPromise = null;
        });
    }
    return this.refreshTokenPromise;
  }
}

export const authService = new AuthService();
