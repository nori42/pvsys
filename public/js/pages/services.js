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
