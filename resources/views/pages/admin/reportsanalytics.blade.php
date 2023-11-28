@extends('layout.admin')
@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/admin/reports.css') }}">
@endsection

@section('pagecontent')
    <div style="padding: 2rem 10%;">
        <div class="d-flex justify-content-between">
            <div class="fs-3 text-white">Quick Stats</div>
            <select name="monthFilter" id="monthFilter" class="form-select w-25"
                style="bacakground-color: var(--dark-color); margin-right: 3rem;">
                @for ($i = 1; $i <= date('m'); $i++)
                    @php
                        $month = date('F', strtotime("2023-{$i}-01"));
                        $monthNum = date('m', strtotime("2023-{$i}-01"));
                        $selectedMonthNum = request()->query('month');
                        $selectedMonth = date('F', strtotime("2023-{$selectedMonthNum}-01"));
                    @endphp
                    <option value="{{ $monthNum }}" @if ($month == $selectedMonth) selected @endif>{{ $month }}
                    </option>
                @endfor
            </select>

        </div>
        <div class="px-5 mt-3">
            {{-- Popular Services --}}
            <div>
                <div class="text-white px-5 py-2" style="background-color: #353637;">Popular Services</div>
                <div class="d-flex justify-content-around" style="background-color: #C3BCBE;">

                    @foreach ($topServices as $service)
                        <div>
                            <div class="fw-semibold">{{ $service->session_type }}</div>
                            <div class="text-center fw-bold fs-4">{{ $service->count }}</div>
                        </div>
                    @endforeach
                    {{-- @for ($i = 0; $i < 5; $i++)
                        <div>
                            <div class="fw-semibold">Fun Shoots</div>
                            <div class="text-center fw-bold fs-4">3</div>
                        </div>
                    @endfor --}}
                </div>
            </div>
            {{-- Overall and Income --}}
            <div class="d-flex gap-3 mt-3">
                {{-- Overall --}}
                <div class="w-100">
                    <div class="text-white px-4 py-3" style="background-color: #353637;">Overall Bookings</div>

                    @php
                        $bookingsLabel = [
                            'corporate_events' => ['Corporate Events', 'Conferences', 'Corporate Parties', 'Prodcut Launches', 'Seminars', 'Team-Buiding Activities'],
                            'commercial_shoots' => ['Commercial Shoots', 'Advertising Campaigns', 'Funshoots'],
                            'portraits' => ['Portraits', 'Family Portraits', 'Senior Portraits', 'Professional Headshots', 'Lifestyle Photography'],
                            'social_events' => ['Social Events', 'Anniversaries', 'Baby Showers', 'Birthdays', 'Christineng', 'Graduations'],
                            'weddings' => ['Weddings', 'Bridal Showers', 'Ceremonies', 'Engagement Parties', 'Reception', 'Ultimate Wedding'],
                        ];
                    @endphp

                    @foreach ($bookingsLabel as $bookingsCategory => $bookings)
                        <div>
                            <div class="d-flex px-5 py-2" style="background-color: #A1A4A7;">
                                <div class="w-100 fw-semibold fs-5">{{ $bookings[0] }}</div>
                                <div class="text-end w-100 fs-5">0</div>
                            </div>

                            @foreach ($bookings as $bookingSub)
                                @if ($loop->index == 0)
                                    @continue
                                @endif

                                <div style="background-color: #D9D9D9;">
                                    <div class="d-flex px-5">
                                        <div class="w-100 fw-semibold fs-5">{{ $bookingSub }}</div>
                                        <div class="text-end w-100 fs-5">
                                            {{ $sessionCounts[$bookingsCategory][$loop->index - 1]['count'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

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
    <script src="{{ asset('js/pages/reports.js') }}"></script>
@endsection
