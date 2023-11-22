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
    <p class="text-center text-white fw-bold mt-5">
        BOOK YOUR MEMORIES WITH <span class="text-primary-nb">NORLITZ BATO FILMS</span><br>
        More than just photographs. More than just films. <br>
        More of why memories are treasures. <br>
        Capture your essence here!
    </p>

    <div class="d-flex justify-content-center gap-2 my-3">
        <x-services.button text="Corporate Events" :active="true" onclick="showServices('#corporate_events',this)" />
        <x-services.button text="Commercial Shoots" onclick="showServices('#commercial_shoots',this)" />
        <x-services.button text="Potraits" onclick="showServices('#portraits',this)" />
        <x-services.button text="Social Events" onclick="showServices('#social_events',this)" />
        <x-services.button text="Weddings" onclick="showServices('#weddings',this)" />
    </div>

    @foreach ($services as $key => $value)
        <div id="{{ str_replace(' ', '', $key) }}" serviceCategory
            class="p-5 gap-3 justify-content-center {{ $key == 'corporate_events' ? '' : 'd-none' }}">
            <div class="d-flex overflow-x-auto gap-3 py-3">
                @foreach ($value as $service)
                    <x-services.service name="{{ $service['name'] }}" type="{{ $service['type'] }}"
                        imagePath="{{ $service['imagePath'] }}" />
                @endforeach
            </div>


            <div class="photo-album p-3 mt-5">
                <h1 class="text-white fw-bold fs-4"><i class="bi bi-images" style="font-size: 2rem"></i>
                    {{ ucwords(str_replace('_', ' ', $key)) }}'s photo album</h1>
                <p class="text-white">Every moment has a story, see their happy moment captured by us.</p>
                <div class="row justify-content-center row-gap-4 column-gap-0">
                    @foreach ($albums[$key] as $imagePath)
                        <img class="col-auto" src="{{ asset($imagePath) }}" width="370" height="240" alt="album_photo"
                            album-photo data-bs-target="#albumPhotoModal" data-bs-toggle="modal"
                            style="cursor: pointer !important;">
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <x-modal id="albumPhotoModal" size="modal-xl">
        <button class="btn btn-outline-primary-nb position-absolute text-gray-300 fs-5" data-bs-dismiss="modal"
            style="right: 1rem; top: 1rem;">X</button>
        <img id="albumPhoto" class="col-auto" src="" width="770" height="640" alt="album_photo">
    </x-modal>
@endsection

@section('pagescript')
    <script src="{{ asset('js/pages/services.js') }}"></script>
@endsection
