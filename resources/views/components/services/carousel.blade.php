{{-- <div class="d-flex justify-content-center mt-3 gap-3">
    <button class="btn btn-outline-dark align-self-center" type="button" data-carousel-slide="prev"
        data-carousel-target="">
        <i class="bi bi-arrow-left"></i>
        <span class="visually-hidden">Previous</span>
    </button>

    <div data-carousel id="carousels">
        <div class="carousel-item-nbs active">
            <img src="{{ asset('images/services/test1.png') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item-nbs">
            <img src="{{ asset('images/services/test2.png') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item-nbs">
            <img src="{{ asset('images/services/test1.png') }}" class="d-block w-100" alt="...">
        </div>
    </div>

    <button class="btn btn-outline-dark align-self-center rounded-circle" type="button" data-carousel-slide="next"
        data-carousel-target="">
        <i class="bi bi-arrow-right"></i>
        <span class="visually-hidden">Next</span>
    </button>
</div> --}}

<div id="carouselExample" class="carousel slide" style="height: 450px; width: 450px;">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/services/test1.png') }}" class="d-block w-100" alt="test">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/services/test2.png') }}" class="d-block w-100" alt="test">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/services/test1.png') }}" class="d-block w-100" alt="test">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
