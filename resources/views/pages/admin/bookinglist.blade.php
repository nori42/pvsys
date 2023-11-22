@extends('layout.admin')
@section('pagestyle')
    <style>
        .bookinglist {
            background-color: #C3BCBE;

        }

        .table td {
            background-color: #C3BCBE;
        }

        .table thead th {
            background-color: #464748 !important;
            color: white;
            padding: 0.725rem 0rem;
        }

        .quick-stat {}

        .stat-icon {
            background-color: #3f3f3f;
        }

        .stat {
            background-color: #C3BCBE;
        }
    </style>
@endsection

@section('pagecontent')
    <div style="padding:2rem 8rem">
        <div>
            <div class="fs-2 text-white mb-3">Quick Stats</div>
            <div class="d-flex justify-content-around gap-3">
                @foreach ($statusBookings as $status => $value)
                    <div class="d-flex quick-stat">
                        <div class="stat-icon py-4 px-4 text-primary-nb"><i class="bi bi-clipboard-data fs-2"></i></div>
                        <div class="text-center stat py-3 px-4">
                            <div>{{ Str::ucfirst($status) }}</div>
                            <div class="fs-3 fw-semibold">{{ $value }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="d-flex gap-2 justify-content-between mt-5">
            <form class="d-flex gap-2 align-items-stretch" action="/bookings/search" method="get">
                <input type="text" placeholder="Booking ID" name="search">
                <button class="btn btn-secondary">Search</button>
            </form>
            <div class="d-flex">
                <label for="bookingFilter" class="text-white px-2 bg-secondary d-flex align-items-center">Status
                    Filter</label>
                <select class="form-select fw-bold rounded-0" name="bookingFilter" id="bookingFilter" style="width: 10rem">
                    <option value="pending" @if (request('status') == 'pending') selected @endif>Pending</option>
                    <option value="accepted" @if (request('status') == 'accepted') selected @endif>Accepted</option>
                    <option value="rescheduled" @if (request('status') == 'rescheduled') selected @endif>Rescheduled</option>
                    <option value="completed" @if (request('status') == 'completed') selected @endif>Completed</option>
                </select>
            </div>
        </div>
        <div class="bookinglist mt-3">
            <div class="text-primary-nb fw-semibold fs-4 px-5 py-3">Booking List</div>
            <table class="table table-striped table-sm mt-2">
                <thead class="align-middle">
                    <th class="text-center">ID</th>
                    <th>Booking Data</th>
                    @if (request('status') == 'pending' || request('status') == 'rescheduled' || request('status') == 'accepted')
                        <th>Action</th>
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
                                            data="{{ date('F d, Y', strtotime($book->session_date)) }}" />
                                        <x-booking.data label="Reschedule Date"
                                            data="{{ date('F d, Y', strtotime($book->rescheduled_session_date)) }}" />
                                    @else
                                        <x-booking.data label="Date"
                                            data="{{ date('F d, Y', strtotime($book->session_date)) }}" />
                                    @endif

                                </div>

                                @if (request('status') == 'rescheduled')
                                    <div class="row">
                                        <x-booking.data label="Original Start Time" data="{{ $book->start_time }}" />
                                        <x-booking.data label="Original End Time" data="{{ $book->end_time }}" />
                                    </div>
                                    <div class="row">
                                        <x-booking.data label="Rescheduled Start Time"
                                            data="{{ $book->rescheduled_start_time }}" />
                                        <x-booking.data label="Rescheduled End Time"
                                            data="{{ $book->rescheduled_end_time }}" />
                                    </div>
                                @else
                                    <x-booking.data label="Start Time" data="{{ $book->start_time }}" />
                                    <x-booking.data label="End Time" data="{{ $book->end_time }}" />
                                @endif

                                <div class="row">
                                    <x-booking.data label="Service Type" data="{{ $book->service_type }}" />
                                </div>

                                <div class="row">
                                    <x-booking.data label="Location" data="{{ $book->event_location }}" />
                                </div>

                                @if ($book->payment_total)
                                    <div class="row">
                                        <x-booking.data label="Payment Type"
                                            data="{{ Str::upper($book->payment_type) }}" />
                                        <x-booking.data label="Payment Total" data="₱{{ $book->payment_total }}" />
                                        <x-booking.data label="Balance" data="₱{{ $book->payment_balance }}" />

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

                                        @if ($book->session_date <= date('Y-m-d') && $book->payment_balance <= 0)
                                            <button class="btn btn-success" data-bs-toggle="modal" data-btn-complete
                                                data-bs-target="#completedModal"
                                                data-bookingId={{ $book->id }}>Complete
                                                Session</button>
                                        @endif

                                        @if ($book->payment_balance > 0)
                                            <button class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#paymentModal" data-btn-payment
                                                data-bookingId={{ $book->id }}>Add Payment</button>
                                        @endif

                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#cancelModal" data-btn-cancel
                                            data-bookingId={{ $book->id }}>Cancel Session</button>
                                    </div>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (request('search') == 'null')
            <div class="text-white   fs-4">No Result</div>
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
                                <div class="row">
                                    <div class="col-4">
                                        <label for="paymentAmount">Amount to be Paid</label>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-control" type="number" name="paymentAmount"
                                            id="paymentAmount" value="0" required>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-4">
                                        <label for="method">Payment Type</label>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select" name="paymentType" id="paymentType" required>
                                            <option value="" disabled selected>Select Payment Type</option>
                                            <option value="Full Amount">Pay in Full Amount</option>
                                            <option value="Downpayment">Downpayment</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row d-none" id="downpayment">
                                    <div class="col-4">
                                        <label for="downpaymentpaymentAmount">Downpayment</label>

                                    </div>
                                    <div class="col-auto">
                                        <input class="form-control" type="number" name="downpaymentAmount"
                                            id="downpaymentAmount" value="0" required>
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

            <div class="modal" id="paymentModal">
                <div class="modal-dialog  modal-dialog-centered">
                    <div class="modal-content">
                        <form id="paymentForm" action="/bookings/addpayment" autocomplete="off" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="bookingId" value="" data-bookId>
                                <legend>Add Payment</legend>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="amount">Amount</label>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-control" type="number" name="amount" id="amount"
                                            value="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success">Confirm</button>
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
