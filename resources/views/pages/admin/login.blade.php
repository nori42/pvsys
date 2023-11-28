@extends('layout.main')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/pages/admin/login.css') }}">
@endsection

@section('maincontent')
    <main class="d-flex">
        <div class="left-panel">
            <img src="{{ asset('images/logo.png') }}" height="330" width="330" alt="">
        </div>
        <div class="right-panel d-flex justify-content-center align-items-center">
            <form class="login-form d-flex flex-column align-items-center" action="/authenticate" method="post"
                autocomplete="off">
                @csrf
                <div class="text-white fs-3 mb-4">LOGIN IN ADMIN</div>

                @if (session('invalidCred'))
                    <div class="text-danger">Incorrect Credentials</div>
                @endif

                <div class="text-danger">
                    @if (session('incorrectRoleLogin'))
                        {{ session('incorrectRoleLogin') }}
                    @endif
                </div>

                <div class="align-self-stretch">
                    <label class="text-white" for="email">Email</label><br>
                    <input class="form-input w-100" type="email" name="email" id="email">
                </div>
                <div class="my-2"></div>
                <div class="align-self-stretch">
                    <label class="text-white" for="password">Password</label><br>
                    <input class="form-input w-100" type="password" name="password" id="password">
                </div>
                <a class="text-white text-decoration-none mt-1" href="/forgot-password">Forgot Password?</a>


                <button class="btn btn-primary-nb mt-4 rounded-0 px-5">LOGIN</button>
            </form>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/pages/login.js') }}"></script>
@endsection
