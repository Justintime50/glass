@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Post</h1>

        <form action="/posts" method="POST">
            @csrf

            <label for="title">Title</label>
            <input class="form-control"
                   id="title"
                   type="text"
                   name="title"
                   value="{{ old('title') }}"
                   oninput="app.slugifyField('title', 'slugify')">

            <label for="slug">Slug (URL) - Must be a single string (eg: "my-new-post" OR "mynewpost")</label>
            <input class='form-control'
                   id="slugify"
                   type='text'
                   name='slug'
                   value="{{ old('slug') }}">

            <label for="published">Post Status</label>
            <select class="form-select" name="published">
                <option value="1" @if (old('published') == '1') {{ 'selected' }} @endif>Published</option>
                <option value="0" @if (old('published') == '0') {{ 'selected' }} @endif>Draft</option>
            </select>

            <label for="image_id">Banner Image</label>
            <input class="form-control"
                   id="image_id"
                   type="text"
                   name="image_id"
                   value="{{ old('image_id') }}"
                   hidden>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#imageGallery"
                    type="button">
                Select Banner Image
            </button>

            <img id="banner-image-preview" src="{{ asset(\App\Http\Controllers\ImageController::$defaultBannerImage) }}">

            <div class="modal fade"
                 id="imageGallery"
                 tabindex="-1"
                 aria-labelledby="imageGallery"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageGallery">Select Banner Image</h5>
                            <button class="btn-close"
                                    data-bs-dismiss="modal"
                                    type="button"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Go to the <a href="/images">Image Library</a> to manage images.</p>
                            @include('partials.image-gallery')
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                    type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <label for="category_id">Category</label>
            <select class="form-select" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>

            <label for="keywords">Keywords (separated by commas)</label>
            <input class="form-control"
                   type="text"
                   name="keywords"
                   value="{{ old('keywords') }}">

            <label for="post">Post</label>
            <textarea class="form-control"
                      id="post"
                      name="post"
                      rows="6">{{ old('post') }}</textarea>

            <p>
                <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">
                    Markdown Cheat Sheet
                </a>
            </p>

            <input class="btn btn-primary"
                   type="submit"
                   value="Create Post">
        </form>
    </div>
@endsection
