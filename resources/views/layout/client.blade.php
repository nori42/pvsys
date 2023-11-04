@extends('layout.main')

@section('stylesheets')
    @yield('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/client/clientlayout.css') }}">
@endsection
@section('maincontent')
    <nav class="d-flex align-items-center justify-content-between w-75 mx-auto">
        <img src="{{ asset('images/logo.png') }}" width="72" height="64" alt="logo" style="margin-right: 1rem;">

        <div>
            <a href="/book/{{ auth()->user()->id }}">My Bookings</a>
            <a href="#">Norlitz Portfolio</a>
        </div>
        <div class="text-center">
            <div class="fw-bold text-white">
                {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
            </div>
            <a href="/logout">Logout</a>
        </div>
    </nav>
    <main>
        @yield('pagecontent')
    </main>
@endsection

@section('scripts')
    @yield('pagescript')
@endsection
