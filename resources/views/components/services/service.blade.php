@props(['name', 'type', 'viewOnly' => false])

<div class="card" style="min-width: 25rem; max-width: 25rem;">
    <img src="{{ asset('images/services/test1.png') }}" class="card-img-top" alt="service_pic">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center card-title">
            <div>{{ $name }}</div>
            @if (!$viewOnly)
                <a class="btn btn-success"
                    href="/book/create?session={{ $name }}&sessionType={{ $type }}">Book</a>
            @endif
        </div>
    </div>
</div>
