@php
    $currentRoute = Route::currentRouteName();
    $currentPortfolio = explode('/', Route::current()->uri)[1];
@endphp
@extends('layout.main')
@section('stylesheets')
    @yield('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/admin/adminlayout.css') }}">
    <style>
        .portfolio-nav a.active {
            border: none !important;
            border-radius: 0;
            border-bottom: 2px solid var(--primary-color) !important;
        }
    </style>
@endsection
@section('maincontent')
    <nav class="d-flex align-items-center justify-content-center">
        <div class="d-flex gap-3 align-items-center">
            <a class="btn text-white py-2 @if ($currentRoute == 'bookings') active @endif"
                href="/bookings?status=pending">Booking Management</a>
            <a class="btn text-white py-2 @if ($currentRoute == 'calendar') active @endif" href="/calendar">Calendar</a>
            <img src="{{ asset('images/logo.png') }}" width="90" height="64" alt="logo">
            <a class="btn text-white py-2 @if ($currentRoute == 'reports') active @endif" href="/reports">Reports and
                Analytics</a>
            <a class="btn text-white py-2 @if ($currentRoute == 'portfolio') active @endif" href="/portfolio/aboutme">My
                Portfolio</a>
        </div>

        <a class="btn btn-primary-nb text-white position-absolute logout" href="/logout">Logout</a>
    </nav>
    <main>
        <div class="w-75 mx-auto mt-4 portfolio-nav">
            <div class="d-flex gap-4">
                <a class="btn text-white fw-semibold @if ($currentPortfolio == 'aboutme') active @endif"
                    href="/portfolio/aboutme">About Me</a>
                <a class="btn text-white fw-semibold @if ($currentPortfolio == 'featuredwork') active @endif"
                    href="/portfolio/featuredwork/photo">Featured Work</a>
            </div>
            @yield('pagecontent')
        </div>
    </main>
@endsection

@section('scripts')
    @yield('pagescript')
@endsection
