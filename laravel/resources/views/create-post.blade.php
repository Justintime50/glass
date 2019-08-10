@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Create Post</h1>
        <form action="/create-post" method="POST">
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

        <br />
        <input type="submit" class="btn btn-primary" value="Create Post">
    </div>

    <script>
        // slugify the title for a url slug
        function slugify(text) {
            // https://gist.github.com/mathewbyrne/1280286
            return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '')             // Trim - from end of text
            .replace(/[\s_-]+/g, '-');
        }

        $('.title').keyup(function() {
            $slug = slugify($(this).val());
            $('.slug').val($slug);
        })

        // preview input
        // var inputBox = document.getElementById('post');

        //    inputBox.onkeyup = function(){
        //    document.getElementById('postPreview').innerHTML = inputBox.value;
        // }
    </script>

@endsection

