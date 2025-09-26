export interface RegisterFormData {
  full_name: string;
  email: string;
  password: string;
  confirm_password: string;
  phone_number?: string;
}

export interface DefaultResponse<T> {
  success: boolean;
  message: string;
  data?: T;
}

export type ToastType = "success" | "error" | "info" | "warning";
