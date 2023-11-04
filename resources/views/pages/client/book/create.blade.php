@extends('layout.main')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/pages/calendar.css') }}">
@endsection

@section('maincontent')
    <main class="pb-5">
        <h1>Book</h1>
        <a href="/services">Back To Services</a>
        <div class="d-flex justify-content-center gap-5">
            <form action="/book" id="bookingForm" class="bg-secondary-subtle p-5 rounded-3 overflow-y-auto" autocomplete="off"
                style="width: 580px;" method="post">
                @csrf

                {{-- Hidden Inputs --}}
                <input type="text" hidden name="session" id="session" value="{{ Str::lower(request('session')) }}">
                <input type="text" hidden name="sessionType" id="sessionType"
                    value="{{ Str::lower(request('sessionType')) }}">
                <input type="text" hidden name="userId" id="userId" value="{{ auth()->user()->id }}">

                <div class="d-flex justify-content-center mb-3">
                    <div class="card" style="width:350px;">
                        <img src="{{ asset('images/services/test1.png') }}" class="card-img-top" alt="service_pic">
                        <div class="card-body text-center bg-dark">
                            <div class="fw-bold text-white">{{ $service }}</div>
                        </div>
                    </div>
                </div>


                <div id="datePickContainer">
                    <label for="datePicked" class="fs-5 fw-bold">Date Picked</label>
                    {{-- <div id="datePicked"></div> --}}
                </div>
                <div class="position-relative">
                    <input class="position-absolute" type="date" name="datePicked" id="datePickForm" value=""
                        required style="z-index: -1; top: 8px;">
                    <button class="w-100 text-start btn btn-dark" type="button" data-bs-toggle="modal"
                        data-bs-target="#calendarModal"><span id="datePicked">Pick A Date </span><i
                            class="bi bi-calendar3 float-end"></i></button>
                </div>
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

                <div>
                    <label for="startTime" class="fw-bold fs-5">Event Location</label>
                    <input class="form-control " type="text" name="eventLocation" id="eventLocation" value=""
                        required>
                </div>

                <legend class="fw-bold fs-5 mt-2">Event Service</legend>
                <div class="d-flex gap-3 align-items-center">
                    <label for="photo" class="fw-bold fs-5">Photo</label>
                    <input id="photo" name="isPhoto" type="checkbox" value="Photo">


                    <label for="video" class="fw-bold fs-5">Video</label>
                    <input id="video" name="isVideo" type="checkbox" value="Video">
                </div>

                <textarea class="form-control" name="moreDetails" id="" cols="30" rows="6"
                    placeholder="More details of the session" style="resize: none;"></textarea>

                <button class="btn btn-dark mt-3 float-end">Book</button>
            </form>
        </div>

        <div id="calendarModal" class="modal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="mx-auto" style="width: 80%;">
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

                            <button class="btn btn-dark" data-bs-dismiss="modal">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        // Insert the list of booked date here
        const bookedDate = @json($bookedDates)

        // Insert the list of not available date here
        const notAvailDate = @json($notAvailDates);

        // Insert the holday date here
        const holidayDate = []
    </script>

    <script src="{{ asset('js/pages/book.js') }}"></script>
@endsection
