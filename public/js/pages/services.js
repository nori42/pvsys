function helloWorld(test) {
    console.log(test);
}

function showServices(category, elem) {
    const categories = document.querySelectorAll("[serviceCategory]");
    const btnServices = document.querySelectorAll(".btn-service");

    btnServices.forEach((btn) => {
        btn.classList.remove("active");
    });
    categories.forEach((item) => {
        item.classList.add("d-none");
    });
    document.querySelector(category).classList.remove("d-none");

    elem.classList.add("active");
}

document.querySelectorAll("[album-photo]").forEach((photo) => {
    photo.addEventListener("click", (elem) => {
        document.querySelector("#albumPhoto").src = elem.target.src;
    });
});
