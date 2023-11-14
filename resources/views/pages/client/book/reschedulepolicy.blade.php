@extends('layout.client')

@section('pagecontent')
    <main>
        <div class="text-white w-50 mx-auto mt-5">
            <div class="d-flex align-items-center">
                <a href="{{ url()->previous() }}"><i class="bi bi-arrow-left-circle-fill text-white fs-1"></i></a>
                <h1 class="mx-5">Reschedule Policy</h1>
            </div>
            <ol>
                <li>Reschedule requests will only be considered if submitted within a maximum of 96 hours (4 days) before
                    your initial photoshoot date. If it is over within 96 hours (4 days) of your initial photoshoot date, it
                    is not possible to send a reschedule request.</li>
                <li>Rescheduling within 48 hours before the scheduled shoot: Clients can request a one-time rescheduling of
                    their booking at least 48 hours before the scheduled photo shoot at no additional cost, subject to
                    photographer availability. We will make our best effort to accommodate the new date and time
                    preferences.</li>
                <li>Rescheduling more than 48 hours before the scheduled shoot: If you need to reschedule your booking more
                    than 48 hours of the scheduled photo shoot, a rescheduling fee of [X]% of the total service cost will be
                    applicable. This fee helps us cover immediate costs associated with rearranging our schedule at short
                    notice.</li>
                <li>Photographer’s availability: All rescheduling requests are subject to the availability of our
                    photographers. We will do our best to accommodate your preferred rescheduled date and time, but it
                    cannot be guaranteed, especially during peak seasons. We recommend notifying us as early as possible to
                    increase the chances of securing your desired rescheduled slot.</li>
                <li>Photographer-Initiated Rescheduling: In the unlikely event that our photographer needs to reschedule the
                    booking due to unforeseen circumstances, we will work with the client to find an alternative date and
                    time at no additional cost. If no suitable alternative is available, the client will receive a full
                    refund of their down payment.</li>
            </ol>
        </div>
    </main>
@endsection
