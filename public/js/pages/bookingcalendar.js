const calendar = document.getElementById("calendar");
const btnNavMonth = document.querySelectorAll("[btn-nav-month]");
const bookedDetail = document.querySelector("#bookedDetail");
const dateMarker = document.querySelector("#dateMarker");
const btnDateMark = document.querySelector("#btnDateMark");
const message = document.querySelector("#message");
const date = document.querySelector("#date");
const bookedContainer = document.querySelector("#bookedContainer");

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

        const dateValue = `${year}-${month + 1}-${String(day).padStart(
            2,
            "0"
        )}`;

        dateElement.setAttribute("dateValue", dateValue);

        if (
            bookedDate.includes(dateElement.getAttribute("dateValue")) ||
            completedDate.includes(dateElement.getAttribute("dateValue"))
        ) {
            if (bookedDate.includes(dateElement.getAttribute("dateValue"))) {
                dateElement.setAttribute(
                    "bookedId",
                    Object.keys(bookedIds).find(
                        (key) => bookedIds[key] === dateValue
                    )
                );
            } else {
                dateElement.setAttribute(
                    "bookedId",
                    Object.keys(completedIds).find(
                        (key) => completedIds[key] === dateValue
                    )
                );
            }

            if (bookedDate.includes(dateElement.getAttribute("dateValue"))) {
                dateElement.classList.add("booked");
            } else {
                dateElement.classList.add("completed");
            }

            dateElement.addEventListener("click", function (e) {
                dateMarker.classList.add("d-none");

                document.querySelectorAll(".selected").forEach((item) => {
                    item.classList.remove("selected");
                });

                e.target.classList.add("selected");

                document
                    .querySelector("#loadingStatus")
                    .classList.remove("d-none");

                bookedDetail.classList.add("d-none");
                bookedContainer.classList.remove("d-none");

                bookedDetail.src = `/bookingcalendar/${e.target.getAttribute(
                    "dateValue"
                )}/show`;

                bookedDetail.addEventListener("load", () => {
                    bookedDetail.classList.remove("d-none");
                    document
                        .querySelector("#loadingStatus")
                        .classList.add("d-none");
                });
            });
        } else if (
            notAvailDate.includes(dateElement.getAttribute("dateValue"))
        ) {
            dateElement.classList.add("notavail");
            dateElement.addEventListener("click", function (e) {
                bookedContainer.classList.add("d-none");
                dateMarker.classList.remove("d-none");
                btnDateMark.textContent = "Mark as Available";
                btnDateMark.classList.add("btn-success");
                btnDateMark.classList.remove("btn-danger");

                date.value = dateElement.getAttribute("dateValue");

                message.setAttribute("readonly", true);
                message.textContent = notAvailDateMessage.find(
                    (dateObj) => dateObj.date == dateValue
                ).message;

                document.querySelectorAll(".selected").forEach((item) => {
                    item.classList.remove("selected");
                });

                e.target.classList.add("selected");
            });
        } else {
            dateElement.addEventListener("click", function (e) {
                bookedContainer.classList.add("d-none");
                dateMarker.classList.remove("d-none");
                btnDateMark.textContent = "Mark as Not Available";
                btnDateMark.classList.add("btn-danger");
                btnDateMark.classList.remove("btn-success");

                date.value = dateElement.getAttribute("dateValue");

                message.textContent = "";
                message.removeAttribute("readonly");

                document.querySelectorAll(".selected").forEach((item) => {
                    item.classList.remove("selected");
                });

                e.target.classList.add("selected");
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

btnNavMonth.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const button = e.target.closest("button");

        if (button.getAttribute("btn-nav-month") == "next") {
            currentDate.setMonth(currentDate.getMonth() + 1);
            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }
        if (button.getAttribute("btn-nav-month") == "previous") {
            currentDate.setMonth(currentDate.getMonth() - 1);

            generateCalendar(currentDate.getFullYear(), currentDate.getMonth());

            // if (currentDate.getFullYear() > new Date().getFullYear()) {
            //     generateCalendar(
            //         currentDate.getFullYear(),
            //         currentDate.getMonth()
            //     );
            // } else {
            //     if (currentDate.getMonth() >= new Date().getMonth()) {
            //         generateCalendar(
            //             currentDate.getFullYear(),
            //             currentDate.getMonth()
            //         );
            //     } else {
            //         currentDate.setMonth(currentDate.getMonth() + 1);
            //     }
            // }
        }
    });
});

generateCalendar(currentDate.getFullYear(), currentDate.getMonth());
