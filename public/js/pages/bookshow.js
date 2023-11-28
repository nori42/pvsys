function passIdToModal(elem) {
    const bookIdInput = document
        .querySelector(elem.getAttribute("data-bs-target"))
        .querySelector("#bookingId");
    bookIdInput.value = elem.getAttribute("data-bookId");
}

const bookingLabel = document.querySelector("[data-booking-label");
bookingLabel.textContent = bookingLabel.getAttribute("data-booking-label");
