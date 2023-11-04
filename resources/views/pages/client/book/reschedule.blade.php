@extends('layout.main')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/pages/calendar.css') }}">
@endsection

@section('maincontent')
    <main>
        <h1>Reschedule</h1>
        <div class="mx-auto" style="width: 50%;">
            <div class="d-flex justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="fs-3" id="monthLabel"></div>
                    <div class="fs-4" id="yearLabel"></div>
                </div>
                <div class="d-flex align-items-end gap-3">
                    <div class="d-flex align-items-center">
                        <div class="mx-2">Booked</div>
                        <div style="width: 1rem; height: 1rem; background-color: #305070;"></div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="mx-2">Not Available</div>
                        <div style="width: 1rem; height: 1rem; background-color: #703030;"></div>
                    </div>
                </div>
            </div>
            <div class="calendar" id="calendar" style="width:100%; height:360px;"></div>

            <div class="d-flex justify-content-between mt-3">
                <div>
                    <button class="btn btn-secondary" btn-nav-month="previous">
                        <i class="bi bi-chevron-left z-0"></i>
                    </button>
                    <button class="btn btn-secondary" btn-nav-month="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <form class="d-flex gap-3" action="/book/{{ $book->id }}/reschedule" method="post" autocomplete="off">
                    @csrf
                    <input hidden type="date" name="datePicked" id="datePickForm" required>
                    <button class="btn btn-dark" data-bs-dismiss="modal" name="action"
                        value="reschedule">Reschedule</button>
                </form>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        // Insert the list of booked date here
        const bookedDate = @json($bookedDates)

        // Insert the list of not available date here
        const notAvailDate = []

        // Insert the holday date here
        const holidayDate = []
    </script>

    <script src="{{ asset('js/pages/calendar.js') }}"></script>
@endsection
