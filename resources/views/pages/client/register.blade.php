@extends('layout.main')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/pages/register.css') }}">
@endsection

@section('maincontent')
    <main class="d-flex justify-content-center align-items-start overflow-y-auto">
        <form class="login-form d-flex flex-column justify-content-center mt-5" action="/register" method="POST"
            autocomplete="off" id="registerForm">
            @csrf
            <h1 class="text-white text-center">Registration Form</h1>
            <p class="text-white text-center my-3">
                Provide your details below to complete your registration and start connecting with us
            </p>

            @if (session('emailExist'))
                <div class="text-danger text-center">Email Already Exist</div>
            @endif
            <div class="d-flex flex-column gap-3 mt-3">
                <input class="form-input" type="email" id="username" name="email" placeholder="Email" required>
                <input class="form-input" type="password" id="password" name="password" placeholder="Password" required>
                <input class="form-input" type="password" id="confPassword" name="confPassword"
                    placeholder="Confirm Password" required>
                <div class="d-flex gap-3">
                    <input class="form-input w-100" type="text" id="firstname" name="firstname" placeholder="First Name"
                        required>
                    <input class="form-input w-100" type="text" id="lastname" name="lastname" placeholder="Last Name"
                        required>
                </div>
                <input class="form-input" type="text" id="phoneno" name="phoneno" placeholder="Phone No" required>
            </div>

            <input type="hidden" name="role" value="CUSTOMER">

            <button class="btn btn-primary-nb rounded-0 my-3 align-self-center fw-bold mt-5" style="padding: 0.625rem 6rem;"
                id="btnRegister">Register</button>

            <div class="text-danger d-none" id="confPassError">Confirm password must match with password</div>
            <div class="text-center text-white">
                Already have an account?
                <a class="text-primary-nb" href="/login">Login now</a>
            </div>
        </form>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/pages/register.js') }}"></script>
@endsection
