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

        <label for="banner-image">Banner Image URL</label>
        <input type="text" class="form-control" name="banner_image_url" value="{{ old('banner_image_url') }}">

        <label for="reading_time">Reading Time (number of minutes)</label>
        <input type="text" class="form-control" name="reading_time" value="{{ old('reading_time') }}">

        <label for="category">Category</label>
        <select class="form-control" name="category">
            <option value="Uncategorized">Uncategorized</option>
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
