@props(['id', 'size' => null])
<div class="modal" id="{{ $id }}">
    <div class="modal-dialog modal-dialog-centered {{ $size }}">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
