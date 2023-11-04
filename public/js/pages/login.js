let isShow = false;

function showPassword(elem) {
    isShow = !isShow;
    const type = isShow ? "text" : "password";
    document.querySelector("#password").setAttribute("type", type);

    if (isShow) {
        elem.querySelector("i").classList.add("bi-eye-slash-fill");
        elem.querySelector("i").classList.remove("bi-eye-fill");
    } else {
        elem.querySelector("i").classList.remove("bi-eye-slash-fill");
        elem.querySelector("i").classList.add("bi-eye-fill");
    }
}
