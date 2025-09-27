export const validateEmail = (email) => {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
};
export const isPhone = (phone) => {
    let cleaned = phone.replace(/[^0-9+]/g, "");
    if (cleaned.startsWith("+84"))
        cleaned = "0" + cleaned.slice(3);
    const regex = /^(0)(3[2-9]|5[689]|7[06-9]|8[1-689]|9[0-46-9])[0-9]{7}$/;
    return regex.test(cleaned);
};
