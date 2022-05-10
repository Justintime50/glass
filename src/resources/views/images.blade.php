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

    @php $images = File::allFiles(public_path("storage/images/posts")); @endphp
    @foreach(array_values($images) as $index => $image)
        @php $image_name = basename($image); @endphp
        @if ($index == 0)
            <div class="row image-row-container">
        @endif

        <div class="col text-center">
            <div class="flex-center-container">
                <img src='{{ asset("storage/images/posts/$image_name") }}' class="img-thumbnail image-preview">
            </div>
            <p>{{ $image_name }}</p>
            <form action="{{ route('delete-image') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $image_name }}">
                <a class="btn btn-primary btn-sm" href="{{ asset("storage/images/posts/$image_name") }}" download>Download</a>
                <input type="submit" value="Delete" class="btn btn-sm btn-danger">
            </form>
        </div>

        @if (($index + 1) % 3 == 0)
            </div>
            <div class="row image-row-container">
        @elseif ($index == count($images) - 1)
            </div>
        @endif
    @endforeach
</div>

@endsection
