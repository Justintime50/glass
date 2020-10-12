@extends('layouts.app')

@section('content')

    <div class="container">

        <a class="btn btn-primary" style="margin-bottom: 30px;" href="{{ url('/'.$post->user->name.'/'.$post->slug) }}"><i class="fas fa-chevron-left"></i> Back to Post</a>
        <h1>Edit Post</h1>
        <form action="{{ route('update-post') }}" method="POST">
        @csrf

        <input name="id" value="{{$post->id}}" hidden>

        <label for="title">Title</label>
        <input type="text" class="form-control title" name="title" id="title" value="{{ old('title', $post->title) }}">

        <label for="slug">Slug (URL) - Must be a single string (eg: "my-new-post" OR "mynewpost")</label>
        <input type='text' class='form-control slug' name='slug' id="slug" value="{{ old('slug', $post->slug) }}">

        <label for="published">Post Status</label>
        <select class="form-control" name="published">
            <option value="1" <?php if ($post->published == 1) echo "selected"; ?>>Published</option>
            <option value="0" <?php if ($post->published == 0) echo "selected"; ?>>Draft</option>
        </select>
        
        <label for="banner-image">Banner Image (eg: 1234567890.png) <i class="fas fa-chevron-right"></i> <a href="{{ route('images') }}">Image Library</a></label>
        <input type="text" class="form-control" name="banner_image_url" value="{{ old('banner_image_url', $post->banner_image_url) }}">
        @if (!file_exists("storage/post-images/$post->banner_image_url") || $post->banner_image_url == null)
            <p class="text-danger">Warning: The image provided could not be found. The default placeholder image will be used.</p>
        @endif

        <label for="reading_time">Reading Time (number of minutes)</label>
        <input type="text" class="form-control" name="reading_time" value="{{ old('reading_time', $post->reading_time) }}">

        <label for="category_id">Category</label>
        <select class="form-control" name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" <?php if ($post->category_id == $category->id) echo "selected"; ?>>{{ $category->category }}</option>
            @endforeach
        </select>

        <label for="keywords">Keywords (separated by commas)</label>
        <input type="text" class="form-control" name="keywords" value="{{ old('keywords', $post->keywords) }}">

        <label for="post">Post</label>
        <textarea name="post" class="form-control" id="post" rows="6">{{ old('post', $post->post) }}</textarea>
        <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">Markdown Cheat Sheet</a>

        <br />
        <input type="submit" class="btn btn-primary" value="Update Post">
    </div>

    <script src="js/slugify/index.js"></script>
    <script>
        slugifyField(".title", ".slug");
    </script>

@endsection
