@extends('layout.client')

@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/client/book/create.css') }}">
@endsection

@section('pagecontent')
    <main class="py-5">
        <div class="d-flex justify-content-center gap-5">
            <form class="rounded-0 text-white" action="/book" id="bookingForm" class="pb-5 rounded-3 overflow-y-auto"
                autocomplete="off" style="width: 580px;" method="post">
                @csrf

                {{-- Hidden Inputs --}}
                <input type="text" hidden name="session" id="session" value="{{ Str::lower(request('session')) }}">
                <input type="text" hidden name="sessionType" id="sessionType"
                    value="{{ Str::lower(request('sessionType')) }}">
                <input type="text" hidden name="userId" id="userId" value="{{ auth()->user()->id }}">

                <div class="d-flex justify-content-center">
                    <div class="card rounded-0 border-0">
                        <img src="{{ asset(request('imagePath')) }}" alt="service_pic">
                        <div class="card-body text-center bg-dark">
                            <div class="fw-bold text-white">{{ $service }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-create p-5">
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
                            <input class="form-control" type="time" name="startTime" id="startTime" value="08:00">
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

                    @if (session('inputError'))
                        <div class="text-danger">{{ session('inputError') }}</div>
                    @endif

                    <textarea class="form-control" name="moreDetails" id="" cols="30" rows="6"
                        placeholder="More details of the session" style="resize: none;"></textarea>


                    <div class="mt-3">
                        <input type="checkbox" style="height: 1.2rem; width: 1.2rem;" id="acknowledgement">
                        <label class="d-inline"><span class="text-primary-nb" for="acknowledgement">I acknowledge and agree
                                to the cancellation
                                and
                                rescheduling policies.</span>
                            (For a detailed
                            understanding, please click Reschedule and Cancellaion button to read our policies).</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-dark mt-4" id="btnSubmit" disabled>Submit</button>
                    </div>
                </div>
            </form>
            <div class="text-white" style="width: 30%">

                <div class=" p-4" style="background-color: #282829">

                    <h1 class="fs-3">Booking and Payment Proccess:</h1>
                    <div>To book your photoshoot session, follow these simple steps:</div>

                    <ul class="m-0 process">
                        <li><span class="fw-bold text-white">Booking Process:</span> Submit your
                            request
                            through our online form to express
                            your interest in our
                            photography services. </li>
                        <li><span class="fw-bold text-white">Availability Confirmation:</span> Our
                            photographer will call you to confirm their availability on the requested date. If they are
                            available, we will proceed to discuss the pricing details.</li>
                        <li><span class="fw-bold text-white">Customized Quote:</span> During the
                            call,
                            you will receive a personalized quote based on your specific requirements. This ensures that you
                            get
                            a fair and accurate price tailored to the services you need.</li>
                        <li><span class="fw-bold text-white">Transparent Pricing:</span> We believe
                            in
                            transparency. The quoted price will include all applicable fees, ensuring that there are no
                            hidden
                            costs.</li>
                        <li><span class="fw-bold text-white">Payment Options:</span> To secure your
                            booking, our photographer requires a downpayment/full payment (whichever is applicable based on
                            your
                            <br>
                            booking terms) before the session date.
                            <ul>
                                <li><span class="text-white">GCash:</span> The photographer's GCash details will be
                                    provided
                                    for a secure and convenient digital
                                    payment option. Kindly ensure you have a GCash account ready for the transaction.</li>
                                <li><span class="text-white">Cash:</span> If you prefer cash payments, the downpayment/full
                                    payment must be made in cash. Please
                                    arrange to provide the exact amount to the photographer before the session date.</li>
                            </ul>
                            You have two payment options:
                        </li>
                        <li><span class="fw-bold text-white">Confirmation:</span> Once you agree to
                            the
                            quoted price, your booking will be confirmed, and we will proceed with the necessary
                            arrangements
                            for your photo shoot session.</li>
                    </ul>
                </div>

                <div class="mt-3">
                    <div class="d-flex justify-content-around" style="background-color: #27292B;">
                        <a class="btn text-primary-nb" href="/policy/reschedule"><i
                                class="bi bi-calendar2-week-fill"></i>
                            Reschedule Policy
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a class="btn text-primary-nb" href="/policy/cancellation">
                            <i class="bi bi-x-octagon-fill"></i>
                            Cancellation Policy
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="p-3 border border-1 border-gray-800">
                        Reschedule and Cancellation is only applicable if you submit the request 96 hours (4 days) before
                        the photoshoot date. Click the buttons above to view the complete policy.
                    </div>
                </div>
            </div>

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
                                    <div class="mx-2">Fully Booked</div>
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

@section('pagescript')
    <script>
        // Insert the list of booked date here
        const bookedDate = @json($bookedDates)

        // Insert the list of not available date here
        const notAvailDate = @json($notAvailDates);
        const notAvailDateMessage = @json($notAvailDateMssg);

        document.querySelector('#acknowledgement').addEventListener('change', (ev) => {
            if (ev.target.checked)
                document.querySelector('#btnSubmit').disabled = false;
            else
                document.querySelector('#btnSubmit').disabled = true;
        })

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

    <script src="{{ asset('js/pages/book.js') }}"></script>
@endsection
