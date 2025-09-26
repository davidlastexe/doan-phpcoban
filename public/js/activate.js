import { AppConfig } from "./app.js";
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const token = urlParams.get("token");
const activateNoti = document.getElementById("activate-noti");
try {
    if (token) {
        const formData = new FormData();
        formData.append("token", token);
        const url = `${AppConfig.baseUrl}/api/activate`;
        const result = await fetch(url, {
            method: "post",
            body: formData,
        }).then((res) => res.json());
        if (result.success) {
            activateNoti.textContent = result.message;
            const anchorEle = document.createElement("a");
            const btnLogin = document.createElement("button");
            anchorEle.href = `${AppConfig.baseUrl}/login`;
            btnLogin.type = "button";
            btnLogin.classList.add("btn", "w-full");
            btnLogin.textContent = "Đến trang đăng nhập";
            anchorEle.appendChild(btnLogin);
            activateNoti.after(anchorEle);
        }
        else
            activateNoti.textContent = result.message;
    }
    else
        activateNoti.textContent = "Token xác thực không được cung cấp.";
}
catch (error) {
    console.log(error);
}
