@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Post</h1>
        <form action="{{ route('create-post') }}" method="POST">
            @csrf

            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}"
                oninput="app.slugifyField('title', 'slug')">

            <label for="slug">Slug (URL) - Must be a single string (eg: "my-new-post" OR "mynewpost")</label>
            <input type='text' class='form-control' name='slug' id="slug" value="{{ old('slug') }}">

            <label for="published">Post Status</label>
            <select class="form-control" name="published">
                <option value="1" @if (old('published') == '1') {{ 'selected' }} @endif>Published</option>
                <option value="0" @if (old('published') == '0') {{ 'selected' }} @endif>Draft</option>
            </select>

            <label for="banner_image_url">Banner Image</label>
            <input type="text" class="form-control" name="banner_image_url" id="banner_image_url"
                value="{{ old('banner_image_url') }}" hidden>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageGallery">
                Select Banner Image
            </button>

            <img src="{{ asset('pics/banner.jpg') }}" id="banner-image-preview">

            <div class="modal fade" id="imageGallery" tabindex="-1" aria-labelledby="imageGallery" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageGallery">Select Banner Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Go to the <a href="{{ route('images') }}">Image Library</a> to manage images.</p>
                            @include('partials.image-gallery')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <label for="category_id">Category</label>
            <select class="form-control" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>

            <label for="keywords">Keywords (separated by commas)</label>
            <input type="text" class="form-control" name="keywords" value="{{ old('keywords') }}">

            <label for="post">Post</label>
            <textarea name="post" class="form-control" id="post" rows="6">{{ old('post') }}</textarea>

            <p>
                <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">
                    Markdown Cheat Sheet
                </a>
            </p>

            <input type="submit" class="btn btn-primary" value="Create Post">
        </form>
    </div>
@endsection
