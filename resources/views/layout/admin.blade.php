@extends('layout.main')


@section('stylesheets')
    @yield('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/admin/adminlayout.css') }}">
@endsection
@section('maincontent')
    <nav class="d-flex align-items-center justify-content-between">
        <div>
            <img src="{{ asset('images/logo.png') }}" width="72" height="64" alt="logo" style="margin-right: 1rem;">
            <a class="btn btn-primary-nb text-white py-2" href="/bookings?status=pending">Booking Management</a>
            <a class="btn btn-primary-nb text-white py-2" href="/calendar">Calendar</a>
            <a class="btn btn-primary-nb text-white py-2" href="/reports">Reports and Analytics</a>
            <a class="btn btn-primary-nb text-white py-2" href="#">My Portfolio</a>

        </div>

        <a class="btn btn-primary-nb text-white py-2" href="/logout">Logout</a>
    </nav>
    <main>
        @yield('pagecontent')
    </main>
@endsection

@section('scripts')
    @yield('pagescript')
@endsection
