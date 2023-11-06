@extends('layout.admin')
@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/calendar.css') }}">
@endsection

@section('pagecontent')
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="d-flex gap-3">
            <div style="width: 580px; height:560px;">
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
                            <div class="mx-2">Completed</div>
                            <div style="width: 1rem; height: 1rem; background-color: #449540;"></div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="mx-2">Not Available</div>
                            <div style="width: 1rem; height: 1rem; background-color: #703030;"></div>
                        </div>
                    </div>
                </div>
                <div class="calendar" id="calendar" style="width:560px; height:360px;"></div>

                <div class="text-center mt-3">
                    <button class="btn btn-secondary" btn-nav-month="previous"><i class="bi bi-arrow-left"></i></button>
                    <button class="btn btn-secondary" btn-nav-month="next">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
            <div id="bookedContainer" class="px-3 shadow-lg align-self-stretch d-none bg-white" style="width: 380px;">
                <h1>Booked Detail</h1>
                <div id="loadingStatus" class="d-flex justify-content-center d-none">
                    <div class="spinner-border" role="status">
                    </div>
                </div>
                <iframe id="bookedDetail" src="" frameborder="0" height="85%"></iframe>
            </div>

            <div id="dateMarker"
                class="d-flex justify-content-center align-items-center align-self-stretch shadow-lg px-3 d-none"
                style="width: 380px;">

                <form action="/calendar/markdate" method="post">
                    @csrf
                    <input class="form-control text-center my-2" type="text" name="date" id="date" readonly>
                    <button id="btnDateMark" class="btn btn-danger w-100">Mark Not Available</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script>
        // Insert the list of booked date here
        const bookedDate = @json($bookedDates);
        const completedDate = @json($completedDates);
        const bookedIds = @json($bookedIds);
        const completedIds = @json($completedIds);
        const notAvailDate = @json($notAvailDates);
    </script>
    <script src="{{ asset('js/pages/bookingcalendar.js') }}"></script>
@endsection