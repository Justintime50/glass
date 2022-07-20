@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Post</h1>
        <form action="{{ route('create-post') }}" method="POST">
            @csrf

            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}"
                oninput="slugifyField('title', 'slug')">

            <label for="slug">Slug (URL) - Must be a single string (eg: "my-new-post" OR "mynewpost")</label>
            <input type='text' class='form-control' name='slug' id="slug" value="{{ old('slug') }}">

            <label for="published">Post Status</label>
            <select class="form-control" name="published">
                <option value="1" @if (old('published') == '1') {{ 'selected' }} @endif>Published</option>
                <option value="0" @if (old('published') == '0') {{ 'selected' }} @endif>Draft</option>
            </select>

            <label for="banner_image_url">Banner Image (eg: 1234567890.png) <i class="fas fa-chevron-right"></i> <a
                    href="{{ route('images') }}">Image Library</a></label>
            <input type="text" class="form-control" name="banner_image_url" value="{{ old('banner_image_url') }}">

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

    </div>

    <script>
        // slugifyField slugs the title field to create a url slug
        // slugify imported in "resources/js/app.js"
        function slugifyField(textfield, slugField) {
            let textFieldValue = document.getElementById(textfield).value
            let slug = slugify(textFieldValue)
            document.getElementById(slugField).value = slug
        }
    </script>
@endsection
