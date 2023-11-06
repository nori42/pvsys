@props(['name', 'type', 'imagePath' => null, 'viewOnly' => false])

<div class="card" style="min-width: 45rem; max-width: 45rem;">
    <img src="{{ asset($imagePath) }}" class="card-img-top" alt="service_pic">
    @if (!$viewOnly)
        <a class="btn btn-primary-nb btn-book position-absolute"
            href="/book/create?session={{ $name }}&sessionType={{ $type }}&imagePath={{ $imagePath }}">Book</a>
    @endif
</div>
