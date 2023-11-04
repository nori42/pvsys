@php
    if ($book) {
        $bookingLabels = ['Session Type', 'Session Category', 'Event Services', 'Date', 'Time', 'Event Location', 'Status'];
        $time = Str::upper(date('g:i a', strtotime($book->start_time))) . ' - ' . Str::upper(date('g:i a', strtotime($book->end_time)));
        $bookingData = [$book->session_type, $book->session_category, $book->service_type, date('F d, Y', strtotime($book->session_date)), $time, $book->event_location, Str::ucfirst($book->status)];
    }
@endphp

@extends('layout.main')
@section('stylesheets')
@endsection

@section('maincontent')
    <main>
        <a href="/services">Back to services</a>
        <div class="d-flex justify-content-center">
            <div class="bg-secondary-subtle" style="min-width: 720px;">
                <div class="fs-2 fw-bold bg-primary-subtle p-2">Current Booking</div>
                <div class="p-4">
                    <div class="d-flex justify-content-end">
                        <div>
                            <button class="btn btn-secondary rounded-0">Current Booking</button>
                            <button class="btn btn-secondary rounded-0">Past Booking</button>
                        </div>
                    </div>
                    <div style="min-height: 180px">
                        @if ($book)
                            <div class="my-4">
                                @foreach ($bookingLabels as $label)
                                    <div class="row">
                                        <div class="fw-bold col-3">{{ $label }}</div>
                                        <div class="col-6">{{ $bookingData[$loop->index] }}</div>
                                    </div>
                                @endforeach

                                @if ($book->message && $book->status != 'rescheduled')
                                    <div class="row">
                                        <div class="fw-bold col-3">Message</div>
                                        <div class="col-6">
                                            {{ $book->message }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="fs-5 text-secondary">
                                You have no booking
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        @if ($book)
                            @if ($book->status == 'pending' || $book->status == 'cancelled' || $book->status == 'declined')
                                <a class="btn btn-success rounded-0" href="/services?bookNew=true">Book New Session</a>
                            @endif

                            @if ($book->status == 'accepted')
                                <a class="btn btn-secondary rounded-0"
                                    href="/book/{{ $book->id }}/reschedule">Reschedule</a>

                                <form action="/book/cancel?bookingId={{ $book->id }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger rounded-0">Cancel Book</button>
                                </form>
                            @endif

                            @if ($book->status == 'rescheduled')
                                <form action="/book/cancel?bookingId={{ $book->id }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger rounded-0">Cancel Book</button>
                                </form>
                            @endif
                        @else
                            <a class="btn btn-success rounded-0" href="/services?bookNew=true">Book New Session</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
@endsection
