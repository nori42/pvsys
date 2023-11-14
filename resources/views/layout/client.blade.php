@extends('layout.main')

@section('stylesheets')
    @yield('pagestyle')
    <link rel="stylesheet" href="{{ asset('css/pages/client/clientlayout.css') }}">
@endsection
@section('maincontent')
    <nav class="d-flex align-items-center justify-content-between w-75 mx-auto">
        <a href="/services"><img src="{{ asset('images/logo.png') }}" width="72" height="64" alt="logo"
                style="margin-right: 1rem;">
        </a>
        <div>
            {{-- <a href="/services">Services</a> --}}
        </div>
        <div class="text-center">
            <div class="text-white d-flex align-items-center gap-2">
                <span class="fw-bold">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                <div class="dropdown-nb position-relative" dropdown>
                    <button class="btn text-white p-0 dropdown-btn" dropdown-btn><i
                            class="bi bi-caret-down-fill fs-4"></i></button>
                    <div class="dropdown-menu-nb position-absolute text-start p-3 rounded-2 d-none" dropdown-menu>
                        <a class="text-white btn text-nowrap w-100 text-end" href="/mybook/{{ auth()->user()->id }}"><i
                                class="bi bi-card-list"></i> My Bookings</a>
                        <a class="text-white btn text-nowrap w-100 text-start" href="/logout"> <i
                                class="bi bi-box-arrow-right"></i>
                            Sign
                            Out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main>
        @yield('pagecontent')
    </main>
@endsection

@section('scripts')
    @yield('pagescript')
    <script>
        const dropdownBtns = document.querySelectorAll('[dropdown-btn]');

        window.addEventListener('click', (e) => {
            const menus = document.querySelectorAll('[dropdown-menu]');
            menus.forEach(menu => {

                dropdownBtns.forEach(btn => {
                    if (e.target.closest('[dropdown]') == null) {
                        menu.classList.add('d-none');
                    }
                })

            })
        })

        dropdownBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const menu = e.target.closest('[dropdown]').querySelector('[dropdown-menu]');
                menu.classList.remove('d-none');
            })

        });
    </script>
@endsection
