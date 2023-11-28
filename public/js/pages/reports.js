const monthFilter = document.querySelector("#monthFilter");

monthFilter.addEventListener("change", (e) => {
    location.href = `/reports?month=${e.target.value}`;
});
