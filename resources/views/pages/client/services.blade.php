@php

    $viewOnly = $userHasBooking || $hasPending;

    if ($bookNew) {
        $viewOnly = false;
    }
@endphp

@extends('layout.client')

@section('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/services.css') }}">
@endsection

@section('pagecontent')
    {{-- @dd($services) --}}
    <p class="text-center text-white fw-bold mt-5">
        BOOK YOUR MEMORIES WITH <span class="text-primary-nb">NORLITZ BATO FILMS</span><br>
        More than just photographs. More than just films. <br>
        More of why memories are treasures. <br>
        Capture your essence here!
    </p>

    <div class="d-flex justify-content-center gap-2 my-3">
        <x-services.button text="Corporate Events" :active="true" onclick="showServices('#corporateevents',this)" />
        <x-services.button text="Commercial Shoots" onclick="showServices('#commercialshoots',this)" />
        <x-services.button text="Potraits" onclick="showServices('#portraits',this)" />
        <x-services.button text="Social Events" onclick="showServices('#socialevents',this)" />
        <x-services.button text="Weddings" onclick="showServices('#weddings',this)" />
    </div>

    @foreach ($services as $key => $value)
        <div id="{{ str_replace(' ', '', $key) }}" serviceCategory
            class="p-5 gap-3 justify-content-center {{ $loop->index == 0 ? '' : 'd-none' }}">
            <div class="d-flex overflow-x-auto gap-3 py-3">
                @foreach ($value as $service)
                    <x-services.service name="{{ $service->name }}" type="{{ $service->type }}"
                        imagePath="{{ $service->imagePath }}" :viewOnly="$viewOnly" />
                @endforeach
            </div>
        </div>
    @endforeach
@endsection

@section('pagescript')
    <script src="{{ asset('js/pages/services.js') }}"></script>
@endsection
