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
                <a href="photo" class="btn">Photo</a>
                <a href="video" class="btn text-primary-nb">Video</a>
            </div>

            <div>
                <button class="btn btn-primary-nb" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">Add
                    Video</button>
            </div>
        </div>
        <div class="mt-3">
            <div class="d-flex flex-wrap gap-3">
                @foreach ($featuredVideo as $videoPath)
                    <video src="{{ asset($videoPath) }}" height="450" width="440" controls>
                        Video Format Not Supported
                    </video>
                @endforeach
            </div>
        </div>
    </div>

    <x-modal id="uploadPhotoModal" size="modal-lg">
        <div class="p-3">
            <div class="p-5 d-flex flex-wrap gap-3" id="imagePreview">
            </div>
            <form action="/portfolio/featuredwork/video" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="d-flex justify-content-between">
                    <input id="videoUpload" type="file" name="videoUpload[]" accept="video/*">
                    <button class="btn btn-primary-nb">Upload Video</button>
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
    {{-- <script src="{{ asset('js/pages/featuredwork.js') }}"></script>
     --}}
    <script>
        document.querySelector("#videoUpload").addEventListener("change", (ev) => {
            imagePreview.innerHTML = "";
            const files = ev.target.files;
            for (let i = 0; i < files.length; i++) {
                if (files[i]) {
                    const reader = new FileReader();
                    reader.addEventListener("load", function(e) {
                        const readerTarget = e.target;
                        const imgElem = document.createElement("video");
                        imgElem.height = 540;
                        imgElem.width = 640;
                        imgElem.src = readerTarget.result;
                        imgElem.controls = true
                        imagePreview.appendChild(imgElem);
                    });

                    reader.readAsDataURL(files[i]);
                }
            }
        });
    </script>
@endsection
