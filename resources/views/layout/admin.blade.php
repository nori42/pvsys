@php
    $currentRoute = Route::currentRouteName();
@endphp
@extends('layout.main')
@section('stylesheets')
    @yield('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/admin/adminlayout.css') }}">
@endsection
@section('maincontent')
    <nav class="d-flex align-items-center justify-content-center">
        <div class="d-flex justify-content-between align-items-center w-100">
            <a class="btn text-white py-2 @if ($currentRoute == 'bookings') active @endif"
                href="/bookings?status=pending">Booking Management</a>
            <a class="btn text-white py-2 @if ($currentRoute == 'calendar') active @endif" href="/calendar">Calendar</a>
            <img src="{{ asset('images/logo.png') }}" width="90" height="64" alt="logo">
            <a class="btn text-white py-2 @if ($currentRoute == 'reports') active @endif"
                href="/reports?month={{ date('m') }}">Reports and
                Analytics</a>
            <a class="btn text-white py-2 @if ($currentRoute == 'portfolio') active @endif" href="/portfolio/aboutme">My
                Portfolio</a>
        </div>

        <a class="btn btn-primary-nb text-white position-absolute logout" href="/logout">Logout</a>
    </nav>
    <main>
        @yield('pagecontent')
    </main>
@endsection

@section('scripts')
    @yield('pagescript')
@endsection
