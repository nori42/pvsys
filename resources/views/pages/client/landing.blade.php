@extends('layout.admin')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/pages/client/landing.css') }}">
@endsection

@section('maincontent')
    <section class="banner d-flex flex-column">
        <div class="d-flex justify-content-between w-75 mx-auto">
            <div>
                <img src="{{ asset('images/logo.png') }}" height="128" width="128" alt="">
            </div>
            <a class="btn text-white align-self-center" href="/login">SIGN IN</a>
        </div>

        <div class="d-flex flex-column align-items-center h-100" style="margin-top: 7rem">
            <h1 class="text-white text-center">
                Transform your vision into reality:<br> <span class="text-primary-nb">REGISTER NOW! </span>to Book
                Unforgetable <br>
                Photo and Video Experiences.
            </h1>

            <a class="btn btn-primary-nb rounded-5 px-4 py-2 fs-5 mt-5" href="/register">REGISTER</a>
        </div>
    </section>
    <section class="services py-5">
        <h1 class="text-white fw-semibold text-center">Services Offer</h1>
        <p class="text-center w-50 mx-auto text-white">
            At Norlitz Bato Films, we understand the importance of life's special occasions. Our dedicated photo and video
            booking services are designed to capture the essence of your most treasured events. Whether it's a dream
            wedding, a memorable celebration, or an intimate gathering, we're here to turn your vision into stunning
            reality. Cherish your priceless moments with us.
        </p>
        <div class="d-flex justify-content-center gap-2 my-3">
            <x-services.button text="Corporate Events" :active="true" onclick="showServices('#corporate_events',this)" />
            <x-services.button text="Commercial Shoots" onclick="showServices('#commercial_shoots',this)" />
            <x-services.button text="Potraits" onclick="showServices('#portraits',this)" />
            <x-services.button text="Social Events" onclick="showServices('#social_events',this)" />
            <x-services.button text="Weddings" onclick="showServices('#weddings',this)" />
        </div>

        @foreach ($services as $key => $value)
            <div id="{{ str_replace(' ', '', $key) }}" serviceCategory
                class="{{ $key == 'corporate_events' ? '' : 'd-none' }}">
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    @foreach ($value as $service)
                        <img src="{{ $service['imagePath'] }}" alt="services" height="340" width="640">
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>
    <section class="aboutme py-5">

        <h1 class="text-white w-50 text-end mx-auto fs-2 fw-light" style="padding-right: 8%">About Me</h1>

        <div class="d-flex align-items-center gap-5 mx-auto" style="width: 60%">
            <img src="{{ asset('images/landing/about_me_profile.png') }}" height="360px" alt="">
            <div>
                <div class="text-white mx-3">who am I</div>
                <div class="text-primary-nb fw-bold fs-5">HELLO</div>
                <p class="text-white">
                    I am Norlitz Bato, a seasoned filmmaker with over 6 years of professional experience. Through my
                    creative lens, I craft compelling visual narratives that resonate with audiences. I am dedicated to
                    going above and beyond for my clients, consistently delivering visually appealing productions. My
                    expertise spans various genres, including weddings, debutante films, corporate shoots, and creative
                    videos. With a keen eye for detail in editing and extensive experience in event videography, I bring
                    stories to life on screen. My passion for storytelling through film has earned me respect within the
                    industry, and I take pride in my work.
                </p>
            </div>
        </div>
    </section>

    <section class="featurework">
        <h1 class="text-primary-nb w-75 mx-auto"><span class="text-white">My</span> Featured Work</h1>

        <div class="w-75 mx-auto mt-5">
            <div class="row gap-3">
                @for ($i = 1; $i <= 16; $i++)
                    <img class="col-auto" src="{{ asset("images/landing/featured_work/{$i}.png") }}" alt=""
                        height="230px">
                @endfor
            </div>
        </div>
    </section>

    <footer class="text-white text-center py-5">
        &copy 2023 NorlitzBatoFilms . All Rights Reserved
    </footer>
@endsection

@section('scripts')
    <script>
        function showServices(category, elem) {
            const categories = document.querySelectorAll("[serviceCategory]");
            const btnServices = document.querySelectorAll(".btn-service");

            btnServices.forEach((btn) => {
                btn.classList.remove("active");
            });
            categories.forEach((item) => {
                item.classList.add("d-none");
            });
            document.querySelector(category).classList.remove("d-none");

            elem.classList.add("active");
        }
    </script>
@endsection
