@props(['text', 'onclick' => null, 'active' => false])

<button class="btn btn-service @if ($active) active @endif"
    onclick="{{ $onclick }}">{{ $text }}</button>
