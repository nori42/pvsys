@extends('layout.main')
@section('maincontent')
    <main>
        @foreach ($bookings as $book)
            <div>
                <x-booking.data label="Name" data="{{ $book->user->first_name . ' ' . $book->user->last_name }}" />
                <x-booking.data label="Email" data="{{ $book->user->email }}" />
                <x-booking.data label="Contact No" data="{{ $book->user->phone_no }}" />

                <x-booking.data label="Session Type" data="{{ $book->session_category }}" />
                <x-booking.data label="Session" data="{{ $book->session_type }}" />


                <x-booking.data label="Date" data="{{ date('F d, Y', strtotime($book->session_date)) }}" />
                <x-booking.data label="Start Time" data="{{ Str::upper(date('g:i a', strtotime($book->start_time))) }}" />
                <x-booking.data label="End Time" data="{{ Str::upper(date('g:i a', strtotime($book->end_time))) }}" />

                <div class="fw-bold">Service Selected:</div>
                <div>
                    @if ($book->service_is_photo)
                        <div>
                            <span>Photo</span>
                        </div>
                    @endif
                    @if ($book->service_is_video)
                        <div>Video</div>
                    @endif
                </div>


                <x-booking.data label="Location" data="{{ $book->event_location }}" />

                @if ($book->payment_amount)
                    <x-booking.data label="Payment Method" data="{{ Str::ucfirst($book->payment_method) }}" />
                    <x-booking.data label="Payment" data="{{ $book->payment_amount }}" />
                @endif

                <div><span class="fw-bold">Status: </span><span
                        class="@if ($book->status == 'accepted' || $book->status == 'completed') text-success @else text-secondary @endif">{{ Str::ucfirst($book->status) }}</span>
                </div>

            </div>
            <hr>
        @endforeach
    </main>
@endsection
