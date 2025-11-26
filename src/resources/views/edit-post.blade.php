@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ strtolower(url('/' . $post->user->name . '/' . $post->slug)) }}">
            <i class="bi bi-chevron-left"></i> Back to Post
        </a>
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Edit Post</h1>

                <form action="/posts/{{ $post->id }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <label for="title">Title</label>
                    <input class="form-control"
                           id="title"
                           type="text"
                           name="title"
                           value="{{ old('title', $post->title) }}">

                    <label for="slug">Slug (URL) - Must be a single string (eg: "my-new-post" OR "mynewpost")</label>
                    <input class='form-control'
                           type='text'
                           name='slug'
                           value="{{ old('slug', $post->slug) }}">

                    <label for="published">Post Status</label>
                    <select class="form-select" name="published">
                        <option value="1" @if ($post->published == 1 || old('published') == '1') {{ 'selected' }} @endif>
                            Published
                        </option>
                        <option value="0" @if ($post->published == 0 || old('published') == '0') {{ 'selected' }} @endif>
                            Draft
                        </option>
                    </select>

                    <label for="image_id">Banner Image</label>
                    <input class="form-control"
                           id="image_id"
                           type="text"
                           name="image_id"
                           value="{{ old('image_id', $post->image?->id) }}"
                           hidden>

                    <button class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#imageGallery"
                            type="button">
                        Select Banner Image
                    </button>

                    @if (isset($post->image))
                        <img id="banner-image-preview"
                             src="{{ \App\Http\Controllers\ImageController::getImageAssetPath($post->image->subdirectory, $post->image->filename) }}">
                    @else
                        <img id="banner-image-preview"
                             src="{{ asset(\App\Http\Controllers\ImageController::$defaultBannerImage) }}">
                    @endif

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
                            <option value="{{ $category->id }}" <?php if ($post->category_id == $category->id) {
                                echo 'selected';
                            } ?>>{{ $category->category }}</option>
                        @endforeach
                    </select>

                    <label for="keywords">Keywords (separated by commas)</label>
                    <input class="form-control"
                           type="text"
                           name="keywords"
                           value="{{ old('keywords', $post->keywords) }}">

                    <label for="post">Post</label>
                    <input id="post"
                           type="hidden"
                           name="post"
                           value="{{ old('post', $post->post) }}">

                    <trix-editor input="post" aria-labelledby="post-label"></trix-editor>

                    <input class="btn btn-primary mt-3"
                           type="submit"
                           value="Update Post">
                </form>
            </div>
        </div>
    </div>
@endsection
