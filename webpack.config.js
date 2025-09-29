export const entry = {
  app: "./resources/ts/app.ts",
  "auth-function": "./resources/ts/auth-function.ts",
  constants: "./resources/ts/constants.ts",
  functions: "./resources/ts/functions.ts",
  "toast-manager": "./resources/ts/toast-manager.ts",
  login: "./resources/ts/login.ts",
  register: "./resources/ts/register.ts",
  activate: "./resources/ts/activate.ts",
};

export const output = {
  filename: "[name].bundle.js", // Tự động thay name bằng các entry
  path: path.resolve(__dirname, "public/js"),
  clean: true, // Xóa thư mục output trước mỗi lần build
};

export const module = {
  rules: [
    {
      test: /\.ts$/,
      use: "ts-loader",
      exclude: /node_modules/,
    },
  ],
};
export const plugins = [new WebpackObfuscator({}, [])];

export const resolve = {
  extensions: [".ts", ".js"],
};
