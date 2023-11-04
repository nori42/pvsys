const calendar = document.getElementById("calendar");
const photoCheckBox = document.querySelector("#photo");
const bookingForm = document.querySelector("#bookingForm");
const btnNavMonth = document.querySelectorAll("[btn-nav-month]");

const currentDate = new Date();

// This is important
currentDate.setDate(1);

function generateCalendar(year, month) {
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();
    const monthLabel = document.querySelector("#monthLabel");
    const yearLabel = document.querySelector("#yearLabel");
    calendar.innerHTML = "";

    const dayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    dayNames.forEach((day) => {
        const dayElement = document.createElement("div");
        dayElement.className = "day-name";
        dayElement.textContent = day;
        calendar.appendChild(dayElement);
    });

    for (let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement("div");
        emptyDay.className = "day";
        calendar.appendChild(emptyDay);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        const dateElement = document.createElement("div");
        dateElement.className = "day";
        dateElement.textContent = day;

        // Set Attribute Of the date
        dateElement.setAttribute("date", `${month + 1}/${day}/${year}`);
        dateElement.setAttribute(
            "dateValue",
            `${year}-${month + 1}-${String(day).padStart(2, "0")}`
        );

        if (
            day <= new Date().getDate() &&
            month == new Date().getMonth() &&
            year == new Date().getFullYear()
        ) {
            dateElement.classList.add("notavail");
        } else if (bookedDate.includes(dateElement.getAttribute("dateValue"))) {
            dateElement.classList.add("booked");
        } else if (
            notAvailDate.includes(dateElement.getAttribute("dateValue")) ||
            holidayDate.includes(dateElement.getAttribute("dateValue"))
        ) {
            dateElement.classList.add("notavail");
        } else {
            // Click Event
            dateElement.addEventListener("click", function (e) {
                if (bookingForm.classList.contains("d-none")) {
                    bookingForm.classList.remove("d-none");
                }

                document.querySelectorAll(".selected").forEach((item) => {
                    item.classList.remove("selected");
                });

                e.target.classList.add("selected");

                const datePickContainer =
                    document.querySelector("#datePickContainer");
                const datePicked = document.querySelector("#datePicked");
                const datePickedForm = document.querySelector("#datePickForm");

                datePicked.textContent = e.target.getAttribute("date");
                datePickedForm.value = e.target.getAttribute("datevalue");

                if (datePickContainer.classList.contains("d-none")) {
                    datePickContainer.classList.remove("d-none");
                }
            });
        }

        monthLabel.textContent = getMonthName(month);
        yearLabel.textContent = currentDate.getFullYear();
        calendar.appendChild(dateElement);
    }
}

function getMonthName(monthIndex) {
    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    return months[monthIndex];
}

photoCheckBox.addEventListener("change", (e) => {
    const photoQuantity = document.querySelector("#photoQuantity");
    if (e.target.value) {
        photoQuantity.classList.toggle("d-none");
        photoQuantity.disabled = false;
    } else {
        photoQuantity.classList.toggle("d-none");
        photoQuantity.disabled = true;
    }
});

btnNavMonth.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const button = e.target.closest("button");
        if (button.getAttribute("btn-nav-month") == "next") {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }
        if (button.getAttribute("btn-nav-month") == "previous") {
            currentDate.setMonth(currentDate.getMonth() - 1);
            if (currentDate.getFullYear() > new Date().getFullYear()) {
                generateCalendar(
                    currentDate.getFullYear(),
                    currentDate.getMonth()
                );
            } else {
                if (currentDate.getMonth() >= new Date().getMonth()) {
                    generateCalendar(
                        currentDate.getFullYear(),
                        currentDate.getMonth()
                    );
                } else {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                }
            }
        }
    });
});

generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
