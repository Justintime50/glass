@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Images</h1>

        <form action="{{ route('upload-image') }}" method="post" enctype="multipart/form-data" id="submit_image">
            @csrf
            <label>Upload an Image</label>
            <small class="avatar-upload-criteria">Picture must be a jpg or png no bigger than 2mb.</small>
            <label for="image" class="btn btn-primary">Upload Image</label>
            <input type="file" name="upload_image" id="image" onchange="this.form.submit()" hidden>
        </form>
    </div>

    <div class="container">
        <hr />
        <h2>Image Library</h2>
        <p>Copy the image filename below and paste into the image field when creating/editing a post.</p>

        @include('partials.image-gallery')
    </div>
@endsection
