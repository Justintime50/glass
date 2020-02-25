@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Create Post</h1>
        <form action="{{ route('create-post') }}" method="POST">
        @csrf

        <label for="title">Title</label>
        <input type="text" class="form-control title" name="title" id="title" value="{{ old('title') }}">

        <label for="slug">Slug (URL) - Must be a single string (eg: "my-new-post" OR "mynewpost")</label>
        <input type='text' class='form-control slug' name='slug' id="slug" value="{{ old('slug') }}">

        <label for="published">Post Status</label>
        <select class="form-control" name="published">
            <option value="1">Published</option>
            <option value="0">Draft</option>
        </select>

        <label for="banner-image">Banner Image (eg: 1234567890.png) <i class="fas fa-chevron-right"></i> <a href="{{ route('images') }}">Image Library</a></label>
        <input type="text" class="form-control" name="banner_image_url" value="{{ old('banner_image_url') }}">

        <label for="reading_time">Reading Time (number of minutes)</label>
        <input type="text" class="form-control" name="reading_time" value="{{ old('reading_time') }}">

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
        <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">Markdown Cheat Sheet</a>

        <br /><br />
        <input type="submit" class="btn btn-primary" value="Create Post">

    </div>

    <script src="js/slugify/index.js"></script>
    <script>
        slugifyField(".title", ".slug");
    </script>
    
@endsection
