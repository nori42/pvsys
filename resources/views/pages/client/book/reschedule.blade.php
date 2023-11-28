@extends('layout.client')

@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/calendar.css') }}">
    <style>
        input {
            background-color: #424242 !important;
            color: white !important;
        }
    </style>
@endsection

@section('pagecontent')
    <main class="text-white">
        <div class="mx-auto" style="width: 60%;">
            <h1>Reschedule</h1>

            <div class="d-flex justify-content-between gap-3" style="width: 70%;">
                <div>
                    <span class="fs-3" id="monthLabel"></span>
                    <span class="fs-4" id="yearLabel"></span>
                </div>
                <div class="d-flex">
                    <div class="d-flex align-items-center">
                        <div class="mx-2">Booked</div>
                        <div class="date-legend booked"></div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="mx-2">Not Available</div>
                        <div class="date-legend notavail"></div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="mx-2">Holiday</div>
                        <div class="date-legend holiday"></div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-5">
                <div class="calendar" id="calendar" style="width:100%; height:380px;"></div>
                <form class="d-flex flex-column " action="/book/{{ $book->id }}/reschedule" method="post"
                    autocomplete="off">
                    @csrf

                    <span>Booking ID:{{ $book->id }}</span>

                    <input hidden type="date" name="datePicked" id="datePickForm" required>
                    <div class="d-flex gap-3 my-3">
                        <div>
                            <label for="startTime" class="fw-bold fs-5">Start Time</label>
                            <input class="form-control " type="time" name="startTime" id="startTime" value="08:00">
                        </div>

                        <div>
                            <label for="endTime" class="fw-bold fs-5">End Time</label>
                            <input class="form-control " type="time" name="endTime" id="endTime" value="12:00">
                        </div>
                    </div>

                    <textarea class="p-2" name="rescheduleReason" id="rescheduleReason" cols="30" rows="8"
                        style="resize: none;" placeholder="Reason for reschedule" required></textarea>
                    <button class="btn btn-dark mt-3" data-bs-dismiss="modal" name="action"
                        value="reschedule">Reschedule</button>
                </form>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <div>
                    <button class="btn btn-secondary" btn-nav-month="previous">
                        <i class="bi bi-chevron-left z-0"></i>
                    </button>
                    <button class="btn btn-secondary" btn-nav-month="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                {{-- <form class="d-flex gap-3" action="/book/{{ $book->id }}/reschedule" method="post" autocomplete="off">
                    @csrf
                    <input hidden type="date" name="datePicked" id="datePickForm" required>
                    <button class="btn btn-dark" data-bs-dismiss="modal" name="action"
                        value="reschedule">Reschedule</button>
                </form> --}}
            </div>
        </div>
    </main>
@endsection

@section('pagescript')
    <script>
        // Insert the list of booked date here
        const bookedDate = @json($bookedDates)

        // Insert the list of not available date here
        const notAvailDate = @json($notAvailDates);
        const notAvailDateMessage = @json($notAvailDateMssg);

        // Insert the holday date here
        const holidayDate = [
            "01-01",
            "04-09",
            "04-13",
            "04-14",
            "05-01",
            "06-12",
            "08-21",
            "08-28",
            "11-01",
            "12-25",
            "12-30"
        ]
    </script>

    <script src="{{ asset('js/pages/calendar.js') }}"></script>
@endsection
