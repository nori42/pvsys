@extends('layout.admin')
@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/admin/reports.css') }}">
@endsection

@section('pagecontent')
    <div style="padding: 2rem 5rem;">
        <div class="d-flex justify-content-between">
            <div class="fs-3 text-white">Quick Stats</div>
            <select name="" id="" class="form-select w-25 text-white"
                style="background-color: var(--dark-color); margin-right: 3rem;">
                @for ($i = 1; $i <= date('m'); $i++)
                    @php
                        $month = date('F', strtotime("2023-{$i}-01"));
                        $monthNum = date('m', strtotime("2023-{$i}-01"));
                    @endphp
                    <option value="{{ $monthNum }}">{{ $month }}</option>
                @endfor
            </select>
        </div>
        <div class="px-5 mt-3">
            {{-- Popular Services --}}
            <div>
                <div class="text-white px-5 py-2" style="background-color: #353637;">Popular Services</div>
                <div class="d-flex justify-content-around" style="background-color: #C3BCBE;">
                    @for ($i = 0; $i < 5; $i++)
                        <div>
                            <div class="fw-semibold">Fun Shoots</div>
                            <div class="text-center fw-bold fs-4">3</div>
                        </div>
                    @endfor
                </div>
            </div>
            {{-- Overall and Income --}}
            <div class="d-flex gap-3 mt-3">
                {{-- Overall --}}
                <div class="w-100">
                    <div class="text-white px-4 py-3" style="background-color: #353637;">Overall Bookings</div>

                    @for ($x = 0; $x < 5; $x++)
                        <div>
                            <div class="d-flex px-5 py-2" style="background-color: #A1A4A7;">
                                <div class="w-100 fw-semibold fs-5">Corporate Events</div>
                                <div class="text-end w-100 fs-5">3</div>
                            </div>
                            @for ($i = 0; $i < 3; $i++)
                                <div style="background-color: #D9D9D9;">
                                    <div class="d-flex px-5">
                                        <div class="w-100 fw-semibold fs-5">Conferences</div>
                                        <div class="text-end w-100 fs-5">0</div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @endfor

                </div>

                {{-- Income --}}
                <div class="w-100">
                    <div class="text-white px-4 py-3" style="background-color: #353637;">Income Overview</div>
                    <div class="py-3" style="background-color: #D9D9D9;">


                        <div class="px-5 pb-5">
                            <div class="fw-semibold fs-5">Due Total:</div>
                            <div class="text-center fs-1 mt-4">PHP {{ number_format($dueTotal) }}</div>

                            <div class="mt-5 fw-semibold fs-5">Receive This Month:</div>
                            <div class="text-center fs-1 mt-4">PHP {{ number_format($receiveThisMonth) }}</div>
                        </div>
                    </div>

                    <p class="text-white my-5">The <span class="text-primary-nb">"Due Total"</span> It shows the
                        remaining
                        due
                        for downpayments on
                        scheduled services overall.</p>
                    <p class="text-white my-5">The <span class="text-primary-nb">"Received This Month"</span> It includes
                        all
                        payments received for scheduled services this month.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagescript')
    <script src="{{ asset('js/pages/bookings.js') }}"></script>
@endsection
