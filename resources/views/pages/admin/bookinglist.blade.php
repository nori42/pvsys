@extends('layout.admin')
@section('pagestyle')
@endsection

@section('pagecontent')
    <div style="padding:2rem 8rem">
        <div class="d-flex gap-2 justify-content-between mt-5">
            <form class="d-flex gap-2 align-items-stretch" action="/bookings/search" method="get">
                <input type="text" placeholder="Booking ID" name="search">
                <button class="btn btn-outline-dark">Search</button>
            </form>
            <select class="form-select fw-bold" name="bookingFilter" id="bookingFilter" style="width: 10rem">
                <option value="pending" @if (request('status') == 'pending') selected @endif>Pending</option>
                <option value="accepted" @if (request('status') == 'accepted') selected @endif>Accepted</option>
                <option value="rescheduled" @if (request('status') == 'rescheduled') selected @endif>Rescheduled</option>
                <option value="completed" @if (request('status') == 'completed') selected @endif>Completed</option>
            </select>
        </div>
        <table class="table table-striped table-sm mt-2">
            <thead class="table-dark">
                <th class="text-center">Booking ID</th>
                <th>Booking Data</th>
                @if (request('status') == 'pending' || request('status') == 'rescheduled')
                    <th></th>
                @endif
                <th></th>
            </thead>
            <tbody>
                @foreach ($bookings as $book)
                    <tr>
                        <td class="align-middle text-center col-1">
                            <div class="bg-secondary d-inline-block rounded-1 px-2">
                                <span class="fw-bold text-white">{{ $book->id }}</span>
                            </div>
                        </td>
                        <td class="col-8 py-3">
                            <div class="row">
                                <x-booking.data label="Name"
                                    data="{{ $book->user->first_name . ' ' . $book->user->last_name }}" />
                                <x-booking.data label="Email" data="{{ $book->user->email }}" />
                                <x-booking.data label="Contact No" data="{{ $book->user->phone_no }}" />
                            </div>

                            <div class="row">
                                <x-booking.data label="Session Type" data="{{ $book->session_category }}" />
                                <x-booking.data label="Session" data="{{ $book->session_type }}" />
                            </div>

                            <div class="row">
                                @if (request('status') == 'rescheduled')
                                    <x-booking.data label="Original Date"
                                        data="{{ date('F d, Y', strtotime($book->original_session_date)) }}" />
                                    <x-booking.data label="Reschedule Date"
                                        data="{{ date('F d, Y', strtotime($book->rescheduled_session_date)) }}" />
                                @else
                                    <x-booking.data label="Date"
                                        data="{{ date('F d, Y', strtotime($book->session_date)) }}" />
                                @endif

                            </div>

                            <div class="row">
                                <x-booking.data label="Start Time" data="{{ $book->start_time }}" />
                                <x-booking.data label="End Time" data="{{ $book->end_time }}" />
                            </div>

                            <div class="row">
                                <x-booking.data label="Service Type" data="{{ $book->service_type }}" />
                            </div>

                            <div class="row">
                                <x-booking.data label="Location" data="{{ $book->event_location }}" />
                            </div>

                            @if ($book->payment_amount)
                                <div class="row">
                                    <x-booking.data label="Payment Method"
                                        data="{{ Str::upper($book->payment_method) }}" />
                                    <x-booking.data label="Payment" data="{{ $book->payment_amount }}" />
                                </div>
                            @endif

                            @if ($book->more_details)
                                <div class="row">
                                    <x-booking.data label="More Details" data="{{ $book->more_details }}" />
                                </div>
                            @endif
                            @if (request('search'))
                                <div class="row">
                                    <x-booking.data label="Status" data="{{ Str::ucfirst($book->status) }}" />
                                </div>
                            @endif
                        </td>
                        <td class="align-middle col-3">
                            @if (request('status') == 'pending' || request('status') == 'rescheduled')
                                <div>
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="{{ request('status') == 'pending' ? '#acceptModal' : '#rescheduledModal' }}"
                                        data-btn-accept data-bookingId={{ $book->id }} accept-modal>Accept</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="{{ request('status') == 'pending' ? '#declineModal' : '#declineReschedModal' }}"
                                        data-btn-declineResch data-btn-decline
                                        data-bookingId={{ $book->id }}>Decline</button>
                                </div>
                            @endif
                            @if (request('status') == 'accepted')
                                <div>

                                    @if ($book->session_date <= date('Y-m-d'))
                                        <button class="btn btn-success" data-bs-toggle="modal" data-btn-complete
                                            data-bs-target="#completedModal" data-bookingId={{ $book->id }}>Complete
                                            Session</button>
                                    @endif
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal"
                                        data-btn-cancel data-bookingId={{ $book->id }}>Cancel Session</button>
                                </div>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (request('search') == 'null')
            <div class="text-secondary fs-4">No Result</div>
        @endif

        @if (request('status') == 'pending')
            <div class="modal" id="acceptModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="acceptForm" action="/bookings/accept" autocomplete="off" method="post">
                            @csrf

                            <div class="modal-body">
                                <input type="hidden" name="bookingId" value="" data-bookId>
                                <legend>Payment</legend>
                                <div class="d-flex gap-2">
                                    <div>
                                        <label for="paymentAmount">Amount</label>
                                        <input class="form-control" type="number" name="paymentAmount" id="paymentAmount"
                                            value="0" required>
                                    </div>
                                    <div>

                                        <label for="method">Method</label>
                                        <select class="form-select" name="method" id="method" required>
                                            <option value="" disabled selected>Select Method</option>
                                            <option value="gcash">GCASH</option>
                                            <option value="cash">CASH</option>
                                        </select>
                                    </div>
                                </div>

                                <textarea class="form-control mt-3" name="message" cols="30" rows="6"
                                    placeholder="Message to the user (You can leave this blank)" style="resize: none;"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="declineModal">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <form id="declineForm" action="/bookings/decline" autocomplete="off" method="post"
                            autocomplete="off">
                            @csrf
                            <input type="hidden" name="bookingId" value="" data-bookId>
                            <div class="modal-body">
                                <div class="fs-5 ">Do you want to decline this booking?</div>
                                <textarea class="form-control" name="message" cols="30" rows="6"
                                    placeholder="Message to the user (You can leave this blank)" style="resize: none;"></textarea>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-danger">Decline</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if (request('status') == 'rescheduled')
            <div class="modal" id="rescheduledModal">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <form id="rescheduledForm" action="/bookings/reschedule" autocomplete="off" method="post">
                            @csrf
                            <input type="hidden" name="bookingId" value="" data-bookId>
                            <div class="modal-body">
                                <div class="fs-5 ">Do you want to accept this rescheduled session?</div>
                                <textarea class="form-control mt-3" name="message" cols="30" rows="6"
                                    placeholder="Message to the user (You can leave this blank)" style="resize: none;"></textarea>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success">Accept</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="declineReschedModal">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <form id="declineReschedForm" action="/bookings/declinereschedule" autocomplete="off"
                            method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="bookingId" value="" data-bookId>
                            <div class="modal-body">
                                <div class="fs-5 ">Do you want to decline this reschedule?</div>
                                <textarea class="form-control" name="message" cols="30" rows="6"
                                    placeholder="Message to the user (You can leave this blank)" style="resize: none;"></textarea>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-danger">Decline</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if (request('status') == 'accepted')
            <div class="modal" id="completedModal">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">

                        <form id="completedForm" action="/bookings/complete" autocomplete="off" method="post">
                            @csrf
                            <input type="hidden" name="bookingId" value="" data-bookId>
                            <div class="modal-body">
                                <div class="fs-5 ">Do you want to complete this session?</div>
                                <div></div>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success">Complete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal" id="cancelModal">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <form id="cancelForm" action="/bookings/cancel" autocomplete="off" method="post">
                            @csrf
                            <input type="hidden" name="bookingId" value="" data-bookId>
                            <div class="modal-body">
                                <div class="fs-5 ">Do you want to cancel this session?</div>
                                <textarea class="form-control mt-3" name="message" cols="30" rows="6"
                                    placeholder="Message to the user (You can leave this blank)" style="resize: none;"></textarea>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button class="btn btn-secondary" type="button"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-danger">Confirm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('pagescript')
    <script src="{{ asset('js/pages/bookings.js') }}"></script>
@endsection
