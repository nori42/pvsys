const btnAccept = document.querySelectorAll("[data-btn-accept]");
const btnComplete = document.querySelectorAll("[data-btn-complete]");
const btnCancel = document.querySelectorAll("[data-btn-cancel]");
const btnDecline = document.querySelectorAll("[data-btn-decline]");
const btnDeclineResch = document.querySelectorAll("[data-btn-declineResch]");
const bookingFilter = document.querySelector("#bookingFilter");

btnAccept.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        let inputBookingId;

        if (document.querySelector("#acceptForm") != null) {
            const inputPaymentMethod = document.querySelector("#paymentAmount");
            const inputMethod = document.querySelector("#method");

            inputBookingId = document
                .querySelector("#acceptForm")
                .querySelector("[data-bookId]");

            inputPaymentMethod.value = "";
            inputMethod.selectedIndex = 0;
        }

        if (document.querySelector("#rescheduledForm") != null) {
            inputBookingId = document
                .querySelector("#rescheduledForm")
                .querySelector("[data-bookId]");
        }

        inputBookingId.value = e.target.getAttribute("data-bookingId");
    });
});

btnComplete.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const inputBookingId = document
            .querySelector("#completedForm")
            .querySelector("[data-bookId]");

        inputBookingId.value = e.target.getAttribute("data-bookingId");
    });
});

btnCancel.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const inputBookingId = document
            .querySelector("#cancelForm")
            .querySelector("[data-bookId]");

        inputBookingId.value = e.target.getAttribute("data-bookingId");
    });
});

btnDecline.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const inputBookingId = document
            .querySelector("#declineForm")
            .querySelector("[data-bookId]");

        inputBookingId.value = e.target.getAttribute("data-bookingId");
    });
});

btnDeclineResch.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const inputBookingId = document
            .querySelector("#declineReschedForm")
            .querySelector("[data-bookId]");

        inputBookingId.value = e.target.getAttribute("data-bookingId");
    });
});
bookingFilter.addEventListener("change", (e) => {
    location.href = `/bookings?status=${e.target.value}`;
});
