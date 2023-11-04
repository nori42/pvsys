@extends('layout.main')

@section('stylesheets')
@endsection

@section('maincontent')
    <main>
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div class="bg-dark p-5" style="width:720px;">

                @if (request('messageType') == 'submit')
                    <div class="fw-bold text-white">Book Submitted</div>
                    <p class="text-white">
                        Thank you for choosing Norlitz Bato Films for your event photography needs! Your booking request has
                        been received. The photographer will either call you or send a text message via SMS or email to
                        confirm
                        their availability for the time you've chosen. Expect an update within 24 hours or less.To ensure a
                        smooth process, kindly keep your phone nearby, and check your messages and emails regularly. Your
                        patience is appreciated.
                    </p>
                @endif

                @if (request('messageType') == 'rescheduled')
                    <div class="fw-bold text-white">Book Reschedule Submitted</div>
                    <p class="text-white">
                        Expect an update within 24 hours or less.To ensure a
                        smooth process, kindly keep your phone nearby, and check your messages and emails regularly. Your
                        patience is appreciated.
                    </p>
                @endif

                @if (request('messageType') == 'cancelled')
                    <div class="fw-bold text-white">Book Cancelled</div>
                    <p class="text-white">
                        Your booking has been cancelled.
                    </p>
                @endif
                <a class="float-end" href="/book/{{ auth()->user()->id }}">View My Bookings</a>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
@endsection
