@extends('layout.main')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <style>
        body {
            background-color: var(--dark-color) !important;
            height: 100vh;
        }

        .notice {
            background-color: var(--dark-subtle);
        }
    </style>
@endsection

@section('maincontent')
    <div class="d-flex vh-100 justify-content-center align-items-center">
        <form action="/email/verification-notification" method="post">
            @csrf
            <h1 class="text-white p-5 fs-4 notice">Check Your Email To Verify Your Account</h1>
            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-link">Resend Email</button>
                <div class="text-white">
                    @if (session('message'))
                        {{ session('message') }}
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
