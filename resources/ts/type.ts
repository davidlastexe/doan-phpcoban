export interface RegisterFormData {
  full_name: string;
  email: string;
  password: string;
  confirm_password: string;
  phone_number?: string;
}

export interface RegisterResponse {
  success: boolean;
  message: string;
  data?: {
    redirect_url: string;
  };
}

export type ToastType = "success" | "error" | "info" | "warning";
