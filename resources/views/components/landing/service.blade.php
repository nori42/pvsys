@props(['name', 'description', 'imgPath' => null])

<div class="px-3 pb-5" style="width: 22rem; background-color:#353637;">
    <div>
        <img src="{{ asset('images/services/test1.png') }}" class="card-img-top" alt="service_pic">
        <div class="text-white text-center bg-dark py-2 fw-light">{{ $name }}</div>
    </div>

    <p class="text-white text-center mt-3">
        {{ $description }}
    </p>
</div>
