const imagePreview = document.querySelector("#imagePreview");

document.querySelector("#imageUpload").addEventListener("change", (ev) => {
    imagePreview.innerHTML = "";
    const files = ev.target.files;
    for (let i = 0; i < files.length; i++) {
        if (files[i]) {
            const reader = new FileReader();
            reader.addEventListener("load", function (e) {
                const readerTarget = e.target;
                const imgElem = document.createElement("img");
                imgElem.height = 250;
                imgElem.width = 250;
                imgElem.src = readerTarget.result;
                imagePreview.appendChild(imgElem);
            });

            reader.readAsDataURL(files[i]);
        }
    }
});

document.querySelectorAll("[featured-photo]").forEach((photo) => {
    photo.addEventListener("click", (elem) => {
        document.querySelector("#previewPhoto").src = elem.target.src;
    });
});
