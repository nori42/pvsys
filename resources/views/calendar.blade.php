<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    @vite('resources/sass/bootstrap.scss')
    @vite('resources/css/calendar.css')
    <title>PVSYS</title>
</head>

<body>
    <div class="container">
        <div class="calendar">
            <div class="legends">
                <div class="legend-item available"></div>
                <div class="legend-text ">Available</div>
                <div class="legend-item not-available"></div>
                <div class="legend-text">Not Available</div>
                <div class="legend-item holiday"></div>
                <div class="legend-text">Holiday</div>
            </div>
            <div class="month">
                <div class="prev" onclick="previousMonth()">&#8249;</div>
                <div class="current-month"></div>
                <div class="next" onclick="nextMonth()">&#8250;</div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <thead>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </thead>
                </thead>
                <tbody class="days">
                </tbody>
            </table>
        </div>
    </div>

    <form action="../../script/process_booking.php" method="POST">
        <div id="booking-form" class="booking-form">
            <span id="close-button" onclick="closeBookingForm()">&times;</span>
            <h2>SESSION INFORMATION</h2>
            <label for="session-type">Session Type</label>
            <select id="session-type" required>
                <option value="" disabled selected>Select Type</option>
                <option value="corporate events">Corporate Events</option>
                <option value="portraits">Portraits</option>
                <option value="commercial shoots">Commercial Shoots</option>
                <option value="weddings">Weddings</option>
                <option value="social events">Social Events</option>
            </select><br><br>

            <label for="session-category">Session Category</label>
            <select class="select" id="session-category" name="SessionCategory" required>
            </select><br><br>

            <label for="session-date">Session Date</label>
            <input type="date" id="session-date" name="SessionDate" class="booking-input" required disabled><br><br>

            <label for="start-time">Start Time</label>
            <input type="time" id="start-time" name="StartTime" class="booking-input" required><br><br>

            <label for="end-time">End Time</label>
            <input type="time" id="end-time" name="EndTime" class="booking-input" required><br><br>

            <label for="service-selection">ServiceSelection</label>
            <select class="select" id="service-type" name="ServiceSelection" required>
                <option value="" disbaled selected>Select Type</option>
                <option value="photo">Photo</option>
                <option value="video">Video</option>
                <option value="photoandvideo">Photo and Video</option>
            </select><br><br>

            <label for="event-location">Event Location:</label>
            <div>
                <div class="location-inputs">
                    <input type="text" id="street-address" name="StreetAddress" placeholder="Street Address"
                        class="booking-input" required style="width: 30%;">
                    <input type="text" id="city" name="City" placeholder="City" class="booking-input"
                        required style="width: 30%;">
                </div>

                <label for="payment-method">How would you like to do the payment?</label>
                <div>
                    <input type="radio" id="cash-payment" name="PaymentMethod" value="cash" required>
                    <label for="cash-payment">Cash</label><br>
                </div>
                <div>
                    <input type="radio" id="online-payment" name="PaymentMethod" value="online" required>
                    <label for="online-payment">GCash</label><br>
                </div>

                <!-- Small Booking Form for GCash -->
                <!-- <div id="gcash-booking-form" style="display: none;"> -->
                <!-- Add your GCash-specific form fields here -->
                <!-- For example, input fields for account name and mobile number -->
                <!-- <label for="gcash-account-name">Account Name:</label>
        <input type="text" id="gcash-account-name" name="GCashAccountName" class="booking-input" required><br><br>

        <label for="gcash-mobile-number">Mobile Number:</label>
        <input type="text" id="gcash-mobile-number" name="GCashMobileNumber" class="booking-input" required><br><br>
    </div> -->

                <button type="book-now">Book</button>
            </div>
    </form>
    <script>
        const daysElement = document.querySelector(".days");
        const currentMonthElement = document.querySelector(".current-month");
        const bookingForm = document.getElementById("booking-form");
        const bookingButton = document.getElementById("booking-button");
        const sessionTypeSelect = document.getElementById("session-type");
        const sessionCategorySelect = document.getElementById("session-category");
        const philippinesHolidays = [
            "2024-01-01", // New Year's Day
            "2024-04-06", // Maundy Thursday
            "2024-04-07", // Good Friday
            "2023-12-25", // Christmas Eve
            "2023-12-24", // Christmas Eve
            "2024-08-21", // Ninoy Aquino Day
            "2023-12-30", // Rizal Day
            "2023-11-01", // All Saint's Day
            "2024-04-09", // Araw ng Kagintingan
            "2024-04-21", // Eid al-Fitr
            "2024-04-08", // Black Saturday
            "2023-08-12", // Feast of the Immaculate Conception
            "2024-01-05", // Labor Day
            "2024-06-12", // Philippine Independence Day
            "2024-06-28", // National Heroes' Day
            "2023-11-27", // Bonifacio Day
        ];
        const onlinePaymentRadio = document.getElementById("online-payment");
        // const gcashOptions = document.getElementById("gcash-options");
        // const gcashBookingForm = document.getElementById("gcash-booking-form");

        const selectedDate = new Date();

        const MONTHS = {
            "JAN": 0,
            "FEB": 1,
            "MAR": 2,
            "APR": 3,
            "MAY": 4,
            "JUN": 5,
            "JUL": 6,
            "AUG": 7,
            "SEPT": 8,
            "OCT": 9,
            "NOV": 10,
            "DEC": 11,
        }

        const categories = {
            corporate_events: [
                'Conference',
                'Corporate Parties',
                'Product Launches',
                'Seminars',
                'Team-Building Activities'
            ],
            commercial_shoots: [
                'Advertising Campaigns',
                'Fashion Shoots'
            ],
            portraits: [
                'Family Portraits',
                'Lifestyle Photography',
                'Professional Headshots',
                'Senior Portraits'
            ],
            social_events: [
                'Anniversaries',
                'Baby Showers',
                'Birthdays',
                'Graduations',
            ],
            weddings: [
                'Bridal Showers',
                'Ceremonies',
                'Engagement Parties',
                'Reception',
            ],
        }

        sessionTypeSelect.addEventListener("change", (e) => {
            switch (e.target.value) {
                case "corporate events": {
                    const options = categories.corporate_events;
                    sessionCategorySelect.innerHTML = "";
                    options.forEach(opt => {
                        optionEl = document.createElement("option");
                        optionEl.setAttribute('value', opt)
                        optionEl.innerHTML = opt;
                        sessionCategorySelect.appendChild(optionEl);
                    });
                }
                break;
                case "portraits": {
                    const options = categories.portraits;
                    sessionCategorySelect.innerHTML = "";
                    options.forEach(opt => {
                        optionEl = document.createElement("option");
                        optionEl.setAttribute('value', opt)
                        optionEl.innerHTML = opt;
                        sessionCategorySelect.appendChild(optionEl);
                    });
                }
                break;
                case "commercial shoots": {
                    const options = categories.commercial_shoots;
                    sessionCategorySelect.innerHTML = "";
                    options.forEach(opt => {
                        optionEl = document.createElement("option");
                        optionEl.setAttribute('value', opt)
                        optionEl.innerHTML = opt;
                        sessionCategorySelect.appendChild(optionEl);
                    });
                }
                break;
                case "weddings": {
                    const options = categories.weddings;
                    sessionCategorySelect.innerHTML = "";
                    options.forEach(opt => {
                        optionEl = document.createElement("option");
                        optionEl.setAttribute('value', opt)
                        optionEl.innerHTML = opt;
                        sessionCategorySelect.appendChild(optionEl);
                    });
                }
                break;
                case "social events": {
                    const options = categories.social_events;
                    sessionCategorySelect.innerHTML = "";
                    options.forEach(opt => {
                        optionEl = document.createElement("option");
                        optionEl.setAttribute('value', opt)
                        optionEl.innerHTML = opt;
                        sessionCategorySelect.appendChild(optionEl);
                    });
                }
                break;
            }
        })

        function generateCalendar(date) {
            daysElement.innerHTML = "";
            const year = date.getFullYear();
            const month = date.getMonth();

            currentMonthElement.textContent = date.toLocaleDateString("en-US", {
                month: "long",
                year: "numeric"
            });

            const today = new Date();
            const firstDayOfMonth = new Date(year, month, 1);
            const lastDayOfMonth = new Date(year, month + 1, 0);
            const totalDays = lastDayOfMonth.getDate();

            let currentDay = 1;

            let currentRow = document.createElement("tr");
            daysElement.appendChild(currentRow);

            for (let i = 0; i < firstDayOfMonth.getDay(); i++) {
                const dayElement = document.createElement("td");
                dayElement.classList.add("past-date");
                currentRow.appendChild(dayElement);
            }

            while (currentDay <= totalDays) {
                const currentDate = new Date(year, month, currentDay);
                const dayOfWeek = currentDate.getDay();
                const dayElement = document.createElement("td");
                const isHoliday = isPhilippinesHoliday(currentDate);

                const dateTextContainer = document.createElement("div");
                dateTextContainer.className = "date-text-container";

                if (currentDate.toDateString() === today.toDateString()) {
                    dateTextContainer.classList.add("today");
                    dateTextContainer.addEventListener("click", () => openBookingForm(currentDate));
                } else if (currentDate < today) {
                    dayElement.classList.add("past-date");
                    dateTextContainer.style.pointerEvents = "none";
                } else if (isHoliday) {
                    dayElement.classList.add("holiday");
                } else {
                    dateTextContainer.addEventListener("click", () => openBookingForm(currentDate));
                }

                const dateSpan = document.createElement("span");
                dateSpan.textContent = currentDay;

                dateTextContainer.appendChild(dateSpan);
                dayElement.appendChild(dateTextContainer);
                currentRow.appendChild(dayElement);

                // Add an event listener to toggle the GCash options and form
                // onlinePaymentRadio.addEventListener("change", function () {
                //     if (this.checked) {
                //         gcashOptions.style.display = "block";
                //         gcashBookingForm.style.display = "block";
                //     } else {
                //         gcashOptions.style.display = "none";
                //         gcashBookingForm.style.display = "none";
                //     }
                // });

                // Add an event listener to close the booking form when clicking anywhere on the screen
                //     window.addEventListener("click", function (event) {
                //     if (event.target !== bookingForm) {
                //         closeBookingForm();
                //     }
                // });

                if (dayOfWeek === 6) {
                    currentRow = document.createElement("tr");
                    daysElement.appendChild(currentRow);
                }

                currentDay++;
            }
        }

        function toggleBookingForm() {
            if (bookingForm.style.display === "block") {
                bookingForm.style.display = "none";
            } else {
                bookingForm.style.display = "block";
            }
        }

        function openBookingForm(date) {
            toggleBookingForm();
            const sessionDateInput = document.getElementById("session-date");
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            sessionDateInput.value = `${year}-${month}-${day}`;
        }

        function closeBookingForm() {
            bookingForm.style.display = "none";
        }

        function nextMonth() {
            const nextMonth = selectedDate.getMonth() + 1;
            selectedDate.setMonth(nextMonth);
            generateCalendar(selectedDate);
        }

        function previousMonth() {
            const prevMonth = selectedDate.getMonth() - 1;
            if (prevMonth < new Date().getMonth() && selectedDate.getFullYear() == new Date().getFullYear())
                return;
            selectedDate.setMonth(prevMonth);
            generateCalendar(selectedDate);
        }

        function isPhilippinesHoliday(date) {
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const day = date.getDate();
            const formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            return philippinesHolidays.includes(formattedDate);
        }

        function populateSessionCategoryOptions() {
            const selectedSessionType = sessionTypeSelect.value;
            const options = categories[selectedSessionType] || [];
            sessionCategorySelect.innerHTML = "";
            options.forEach((opt) => {
                const optionEl = document.createElement("option");
                optionEl.value = opt;
                optionEl.textContent = opt;
                sessionCategorySelect.appendChild(optionEl);
            });
        }
        generateCalendar(selectedDate);
    </script>
</body>

</html>
