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
    <div class="d-flex vh-100 justify-content-center align-items-center w-25 mx-auto">
        <form class="w-100" action="/reset-password" method="post" autocomplete="off">
            @csrf
            <input type="hidden" name="token" value={{ $token }}>
            <legend class="text-white">Reset Password</legend>
            <div class="d-flex flex-column gap-3">
                <input class="py-2 px-1" type="email" name="email" placeholder="Email">
                <input class="py-2 px-1" type="password" name="password" placeholder="Password">
                <input class="py-2 px-1" type="password" name="password_confirmation" placeholder="Confirm Password">
                <button class="btn btn-primary-nb" id="btnChangePassword">Change Password</button>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="text-danger">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const btnChangePassword = document.querySelector("#btnChangePassword");

        btnChangePassword.addEventListener("click", () => {
            const inputPass = document.querySelector("#password");
            const inputConfPass = document.querySelector("#confirmPassword");
            if (inputPass.value != inputConfPass.value) {
                inputConfPass.setCustomValidity("Password must match");
            } else {
                inputConfPass.setCustomValidity("");
            }
        });
    </script>
@endsection
