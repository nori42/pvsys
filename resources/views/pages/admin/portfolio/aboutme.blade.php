@extends('layout.portfolio')
@section('pagestyle')
    <link rel="stylesheet" href="">
    <style>
        #aboutMe {
            resize: none;
            width: 100%;
            background-color: #eaeaea;
        }
    </style>
@endsection
@section('pagecontent')
    <div class="p-4 mt-3" style="background-color: #D9D9D9;">
        <form id="aboutMeForm" action="/portfolio/aboutme" method="POST" autocomplete="off">
            @csrf
            <div class="w-75 mx-auto">
                <textarea class="p-3 form-input" name="aboutMe" id="aboutMe" rows="12" wrap="soft">{{ $aboutme['description'] }}</textarea>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-3">
                <button type="submit" class="btn btn-secondary px-3">Update</button>
            </div>
        </form>
    </div>
@endsection

@section('pagescript')
    <script src=""></script>
@endsection
