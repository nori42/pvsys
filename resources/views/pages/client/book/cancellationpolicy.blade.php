@extends('layout.client')

@section('pagecontent')
    <main>
        <div class="w-50 mx-auto mt-5" style="color:#d0d0d0;">
            <div class="d-flex align-items-center">
                <a href="{{ url()->previous() }}"><i class="bi bi-arrow-left-circle-fill text-white fs-1"></i></a>
                <h1 class="mx-5"><span class="text-center">Cancellation Policy</span></h1>
            </div>
            <ol>
                <li>Cancellation request will be applied if you submit your request at maximum 96 hours (4 days) before your
                    initial photoshoot date.</li>
                <li>Cancellation within 24 hours of booking: Clients can cancel their booking within 24 hours of making the
                    reservation and receive a full refund of their down payment.</li>
                <li>Cancellation within 96 hours (4 days) before the scheduled shoot: If a client needs to cancel their
                    booking within 96 hours (4 days) before the scheduled photo shoot, a cancellation fee of [X]% of the
                    total service cost will be deducted from the down payment, which is equivalent to half of the total
                    service cost. The remaining balance will be refunded.</li>
                <li>No- show or cancellation on the day of the shoot: If a client fails to show up for the scheduled photo
                    shoot or cancels on the day of the shoot, the full service cost will be charged, and the down payment
                    will not be refunded.</li>
                <li>Photographer cancellation: In the unlikely event that our photographer needs to cancel the booking due
                    to unforeseen circumstances, clients will receive a full refund of their down payment, and we will
                    assist in rescheduling the shoot at their convenience.</li>
            </ol>
        </div>
    </main>
@endsection
