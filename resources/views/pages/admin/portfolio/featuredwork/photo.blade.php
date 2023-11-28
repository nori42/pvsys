@extends('layout.portfolio')
@section('pagestyle')
    <link rel="stylesheet" href="">
    <style>
        .ft-photo {
            cursor: pointer;
        }
    </style>
@endsection

@section('pagecontent')
    <div class="mt-4 p-4" style="background-color: #D9D9D9;">
        <div class="d-flex justify-content-between">
            <div>
                <a href="photo" class="btn text-primary-nb">Photo</a>
                <a href="video" class="btn">Video</a>
            </div>

            <div>
                <button class="btn btn-primary-nb" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">Add
                    Photo</button>
            </div>
        </div>
        <div class="mt-3">
            <div class="d-flex flex-wrap gap-3">
                @foreach ($featuredPhoto as $photoPath)
                    <img class="ft-photo" src="{{ asset($photoPath) }}" alt="" height="190" width="190"
                        featured-photo data-bs-target="#previewPhotoModal" data-bs-toggle="modal">
                @endforeach
            </div>
        </div>
    </div>

    <x-modal id="uploadPhotoModal" size="modal-lg">
        <div class="p-3">
            <div class="p-5 d-flex flex-wrap gap-3" id="imagePreview">
            </div>
            <form action="/portfolio/featuredwork/photo" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between">
                    <input id="imageUpload" type="file" name="imageUpload[]" accept="image/*" multiple>
                    <button class="btn btn-primary-nb">Upload Image</button>
                </div>
            </form>
        </div>
        <button class="btn btn-outline-primary-nb position-absolute text-gray-300 fs-5" data-bs-dismiss="modal"
            style="right: 1rem; top: 1rem;">X</button>
    </x-modal>

    <x-modal id="previewPhotoModal" size="modal-md">
        <button class="btn btn-outline-primary-nb position-absolute text-gray-300 fs-5" data-bs-dismiss="modal"
            style="right: 1rem; top: 1rem;">X</button>
        <img id="previewPhoto" class="col-auto" src="" width="670" height="470" alt="preview_photo">
    </x-modal>
@endsection

@section('pagescript')
    <script src="{{ asset('js/pages/featuredwork.js') }}"></script>
@endsection
