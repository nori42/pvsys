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
        <form action="/forgot-password" method="post">
            @csrf
            <div class="notice p-5">
                <h1 class="text-white fs-4 mb-4">Email</h1>
                <input class="w-100" type="text" name="email" id="email">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="text-danger">{{ $error }}</div>
                    @endforeach
                @endif
                @if (session('status'))
                    <div class="text-success">{{ session('status') }}</div>
                @endif
                <button class="btn btn-primary-nb mt-3">Request Link</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
@endsection
