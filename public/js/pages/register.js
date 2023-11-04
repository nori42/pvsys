const btnRegister = document.querySelector("#btnRegister");

btnRegister.addEventListener("click", () => {
    const inputPass = document.querySelector("#password");
    const inputConfPass = document.querySelector("#confPassword");
    if (inputPass.value != inputConfPass.value) {
        inputConfPass.setCustomValidity("Password must match");
    } else {
        inputConfPass.setCustomValidity("");
    }
});
