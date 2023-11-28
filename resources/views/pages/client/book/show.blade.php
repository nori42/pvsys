{{-- @php
    // if ($book) {
    //     $bookingLabels = ['Session Type', 'Session Category', 'Event Services', 'Date', 'Time', 'Event Location', 'Status', 'More Details'];
    //     $time = Str::upper(date('g:i a', strtotime($book->start_time))) . ' - ' . Str::upper(date('g:i a', strtotime($book->end_time)));
    //     $sesionDate = $book->status != 'rescheduled' ? date('F d, Y', strtotime($book->session_date)) : 'Rescheduled';
    //     $bookingData = [$book->session_type, $book->session_category, $book->service_type, $sesionDate, $book->status != 'rescheduled' ? $time : 'Rescheduled', $book->event_location, Str::ucfirst($book->status), $book->more_details];
    // }

@endphp --}}

@extends('layout.client')
@section('pagestyle')
@endsection

@section('pagecontent')
    {{-- @dd(request()->query('pastbooking')) --}}
    <main>
        <div class="d-flex justify-content-center text-white">
            <div class="bg-secondary-subtle" style="width:720px;">
                <div class="fs-2 fw-bold bg-secondary p-2"
                    data-booking-label="{{ request()->query('pastbooking') == 'on' ? 'Past Booking' : 'Current Booking' }}">
                </div>
                <div class="p-4 bg-dark">
                    <div class="d-flex justify-content-between">
                        <div>

                        </div>
                        <div>
                            <a class="btn btn-secondary rounded-0" href="{{ auth()->user()->id }}">Current Booking</a>
                            <a class="btn btn-secondary rounded-0" href="{{ auth()->user()->id }}?pastbooking=on">Past
                                Booking</a>
                            <a class="btn btn-primary-nb rounded-0" href="/services?bookNew=true">Book New Session</a>
                        </div>
                    </div>
                    <div class="my-5">
                        {{-- List of bookings --}}
                        @if (count($books) != 0)
                            @foreach ($books as $book)
                                <div class="d-flex justify-content-between">
                                    <div class="row">
                                        <x-book.data label="Submission Date"
                                            data="{{ date('F d,Y', strtotime($book->booked_date)) }}" />
                                        <div class="mb-3"></div>
                                        <x-book.data label="Book Id" data="{{ $book->id }}" />
                                        <x-book.data label="Service Category" data="{{ $book->session_category }}" />
                                        <x-book.data label="Type of Service" data="{{ $book->session_type }}" />
                                        <x-book.data label="Event Service" data="{{ $book->service_type }}" />

                                        <x-book.data label="Date"
                                            data="{{ $book->status != 'rescheduled' ? date('F d,Y', strtotime($book->session_date)) : 'Rescheduled' }}" />

                                        <x-book.data label="Time"
                                            data="{{ $book->status != 'rescheduled' ? $book->start_time . ' ' . $book->end_time : 'Rescheduled' }}" />

                                        <x-book.data label="Event Location" data="{{ $book->event_location }}" />

                                        @if ($book->more_details)
                                            <x-book.data label="More Details"
                                                data="{{ Str::ucfirst($book->more_details) }}" />
                                        @endif


                                        @if ($book->message)
                                            <x-book.data label="Message" data="{{ $book->message }}" />
                                        @endif

                                        @if ($book->payment_type != null)
                                            <x-book.data label="Payment Type"
                                                data="{{ Str::ucfirst($book->payment_type) }}" />
                                            <x-book.data label="Payment Total" data="₱{{ $book->payment_total }}" />
                                            @if ($book->payment_type == 'Downpayment')
                                                <x-book.data label="Balance" data="₱{{ $book->payment_balance }}" />
                                            @endif
                                        @endif


                                    </div>
                                    <div class="w-50 d-flex flex-column gap-3">
                                        <div class="text-center text-nowrap text-primary-nb fw-bold">
                                            <span class="text-white">Status:</span>
                                            {{ Str::ucfirst($book->status) }}
                                        </div>
                                    </div>

                                </div>
                                @if (session('pastbooking'))
                                @else
                                    <div class="d-flex justify-content-end gap-3 mt-4">
                                        @if ($book->status == 'accepted')
                                            <a class="btn btn-outline-primary-nb"
                                                href="/book/{{ $book->id }}/reschedule">Reschedule</a>
                                        @elseif ($book->status == 'rescheduled')
                                            <button class="btn btn-outline-danger text-nowrap" type="button"
                                                data-bookId ="{{ $book->id }}" data-bs-toggle="modal"
                                                data-bs-target="#cancelReschModal" onclick="passIdToModal(this)">Cancel
                                                Rescuedule</button>
                                        @endif

                                        @if ($book->status == 'accepted' || $book->status == 'pending')
                                            <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal"
                                                data-bookId ="{{ $book->id }}" data-bs-target="#cancelModal"
                                                onclick="passIdToModal(this)">Cancel Booking</button>
                                        @endif

                                        @if ($book->status == 'declined' || $book->status == 'cancelled')
                                            <form action="/book/{{ $book->id }}/delete" method="post">
                                                @csrf
                                                <button class="btn btn-outline-danger"> Remove</button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                                <hr>
                            @endforeach
                        @else
                            <div class="fs-5 text-secondary">No Bookings</div>
                        @endif
                    </div>
                    <div>
                    </div>
                    {{-- <div class="d-flex justify-content-end gap-3">

                        <a class="btn btn-primary-nb rounded-0" href="/services?bookNew=true">Book New Session</a>
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- Cancel Booking Modal --}}
        <x-modal id="cancelModal">
            <div class="p-3 bg-dark">
                <form action="/book/cancel" method="post">
                    @csrf
                    <input type="hidden" id="bookingId" name="bookingId">
                    <div class="fs-5 text-white">Do you want to cancel this booking? <br><span class="text-secondary">This
                            action cannot be undone.</span>
                    </div>
                    <div class="d-flex justify-content-end gap-3 mt-3">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Back</button>
                        <button class="btn btn-danger">Cancel</button>
                    </div>
                </form>
            </div>
        </x-modal>

        {{-- Cancel Reschedule Booking Modal --}}
        <x-modal id="cancelReschModal">
            <div class="p-3 bg-dark">
                <form action="/book/cancel" method="post">
                    @csrf
                    <input type="hidden" id="bookingId" name="bookingId">
                    <div class="fs-6 text-white">Do you want to cancel the reschedule of this booking?</div>
                    <div class="d-flex justify-content-end gap-3 mt-3">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Back</button>
                        <button class="btn btn-danger">Cancel</button>
                    </div>
                </form>
            </div>
        </x-modal>



    </main>
@endsection

@section('pagescript')
    <script src="{{ asset('js/pages/bookshow.js') }}"></script>
@endsection
