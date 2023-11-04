@extends('layout.main')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
@endsection

@section('maincontent')
    <main class="d-flex justify-content-center align-items-center overflow-y-auto">
        <form class="login-form d-flex flex-column align-items-center justify-content-center"
            action="/authenticate?loginas=customer" method="post">
            @method('post')
            @csrf

            <h1 class="text-white fw-bold">Welcome</h1>
            <p class="text-center text-white my-3 fw-light">
                To keep connected with us <br>
                please log in with your personal info
            </p>

            <div class="d-flex flex-column gap-4 my-3 align-self-stretch">
                <div class="d-flex position-relative">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input class="form-input w-100" type="email" id="username" name="email" placeholder="Email"
                        required>
                </div>
                <div class="d-flex position-relative">
                    <i class="bi bi-key-fill input-icon"></i>
                    <input class="form-input w-100" type="password" id="password" name="password" placeholder="Password"
                        required>
                    <button class="btn btn-show-password" type="button" onclick="showPassword(this)"><i
                            class="bi bi-eye-fill" style="font-size:1rem;"></i></button>
                </div>
            </div>

            @if (session('invalidCred'))
                <div class="fs-6 text-danger my-2">Incorrect password or username</div>
            @endif

            <div class="text-danger">
                @if (session('incorrectRoleLogin'))
                    {{ session('incorrectRoleLogin') }}
                @endif
            </div>

            <button class="btn btn-primary-nb rounded-0 my-3 px-5">Login</button>
            <div class="text-white fw-light">
                Not a member? <a class="text-primary-nb fw-normal" href="/register">Register Now</a>
            </div>
        </form>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/pages/login.js') }}"></script>
@endsection
