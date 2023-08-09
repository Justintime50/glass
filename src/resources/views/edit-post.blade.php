@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ strtolower(url('/' . $post->user->name . '/' . $post->slug)) }}">
            <i class="fas fa-chevron-left"></i> Back to Post
        </a>
        <h1>Edit Post</h1>

        <form action="/posts/{{ $post->id }}" method="POST">
            @csrf
            @method('PATCH')

            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $post->title) }}"
                oninput="app.slugifyField('title', 'slug')">

            <label for="slug">Slug (URL) - Must be a single string (eg: "my-new-post" OR "mynewpost")</label>
            <input type='text' class='form-control' name='slug' id="slug" value="{{ old('slug', $post->slug) }}">

            <label for="published">Post Status</label>
            <select class="form-select" name="published">
                <option value="1" @if ($post->published == 1 || old('published') == '1') {{ 'selected' }} @endif>
                    Published
                </option>
                <option value="0" @if ($post->published == 0 || old('published') == '0') {{ 'selected' }} @endif>
                    Draft
                </option>
            </select>

            <label for="banner_image_url">Banner Image</label>
            <input type="text" class="form-control" name="banner_image_url" id="banner_image_url"
                value="{{ old('banner_image_url', $post->banner_image_url) }}" hidden>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#imageGallery">
                Select Banner Image
            </button>

            @if (file_exists(\App\Http\Controllers\PostController::getImagePublicPath($post->banner_image_url)) &&
                    $post->banner_image_url != null)
                <img src="{{ \App\Http\Controllers\PostController::getImageAssetPath($post->banner_image_url) }}"
                    id="banner-image-preview">
            @else
                <img src="{{ asset('pics/banner.jpg') }}" id="banner-image-preview">
            @endif

            <div class="modal fade" id="imageGallery" tabindex="-1" aria-labelledby="imageGallery" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageGallery">Select Banner Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Go to the <a href="/images">Image Library</a> to manage images.</p>
                            @include('partials.image-gallery')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <label for="category_id">Category</label>
            <select class="form-select" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" <?php if ($post->category_id == $category->id) {
                        echo 'selected';
                    } ?>>{{ $category->category }}</option>
                @endforeach
            </select>

            <label for="keywords">Keywords (separated by commas)</label>
            <input type="text" class="form-control" name="keywords" value="{{ old('keywords', $post->keywords) }}">

            <label for="post">Post</label>
            <textarea name="post" class="form-control" id="post" rows="6">{{ old('post', $post->post) }}</textarea>

            <p>
                <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">
                    Markdown Cheat Sheet
                </a>
            </p>

            <input type="submit" class="btn btn-primary" value="Update Post">
        </form>
    </div>
@endsection
