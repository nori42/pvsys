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
                    {{ $aboutme }}
                </p>
            </div>
        </div>
    </section>

    <section class="featurework w-75 mx-auto">
        <h1 class="text-primary-nb"><span class="text-white">My</span> Featured Work</h1>
        <div>
            <button class="btn text-primary-nb" btn-featured="photo">Photo</button>
            <button class="btn text-white" btn-featured="video">Video</button>
        </div>
        <div class="mt-5" id="photo">
            <div class="d-flex flex-wrap gap-3">
                @foreach ($featuredPhoto as $photoPath)
                    <img class="" src="{{ asset($photoPath) }}" alt="featured_photo" height="230" width="230">
                @endforeach
            </div>
        </div>

        <div class="mt-5 d-none" id="video">
            <div class="d-flex flex-wrap gap-3">
                @foreach ($featuredVideo as $videoPath)
                    <video height="380" width="440" controls>
                        <source src="{{ asset($videoPath) }}">
                        Video Format Not Supported
                    </video>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="text-white text-center py-5">
        &copy 2023 NorlitzBatoFilms . All Rights Reserved
    </footer>
@endsection

@section('scripts')
    <script>
        const photo = document.querySelector('#photo');
        const video = document.querySelector('#video');
        const btnPhoto = document.querySelector('[btn-featured=photo]');
        const btnVideo = document.querySelector('[btn-featured=video]');

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
        document.querySelectorAll('[btn-featured]').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                if (e.target.getAttribute('btn-featured') == 'video') {
                    video.classList.remove('d-none');
                    photo.classList.add('d-none');

                    btnVideo.classList.add('text-primary-nb');
                    btnVideo.classList.remove('text-white');

                    btnPhoto.classList.remove('text-primary-nb');
                    btnPhoto.classList.add('text-white');
                } else {
                    video.classList.add('d-none');
                    photo.classList.remove('d-none');

                    btnVideo.classList.remove('text-primary-nb');
                    btnVideo.classList.add('text-white');
                    btnPhoto.classList.add('text-primary-nb');
                    btnPhoto.classList.remove('text-white');
                }
            })
        })
    </script>
@endsection
