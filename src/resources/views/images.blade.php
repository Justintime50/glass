@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Images</h1>

        <form id="submit_image"
              action="/images"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            <label>Upload an Image</label>
            <small class="avatar-upload-criteria">Picture must be a jpg or png no bigger than 2mb.</small>
            <label class="btn btn-primary" for="image">Upload Image</label>
            <input id="image"
                   type="file"
                   name="image"
                   onchange="this.form.submit()"
                   hidden>
        </form>
    </div>

    <div class="container">
        <hr />
        <h2>Image Library</h2>

        @include('partials.image-gallery')
    </div>
@endsection
