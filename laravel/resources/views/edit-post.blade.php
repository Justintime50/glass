@extends('layouts.app')

@section('content')

    <div class="container">

        <a class="btn btn-primary" style="margin-bottom: 30px;" href="/{{$post->user->name}}/{{$post->slug}}">< Back to Post</a>
        <h1>Edit Post</h1>
        <form action="/update-post" method="POST">
        @csrf

        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}">

        <label for="slug">Slug (URL)</label>
        <input type="text" class="form-control" name="slug" value="{{ old('slug', $post->slug) }}">

        <label for="reading_time">Reading Time (number of minutes)</label>
        <input type="text" class="form-control" name="reading_time" value="{{ old('reading_time', $post->reading_time) }}">

        <label for="category">Category</label>
        <input type="text" class="form-control" name="category" value="{{ old('category', $post->category) }}">

        <label for="keywords">Keywords (separated by commas)</label>
        <input type="text" class="form-control" name="keywords" value="{{ old('keywords', $post->keywords) }}">

        <label for="post">Post</label>
        <textarea name="post" class="form-control" rows="6">{{ old('post', $post->post) }}</textarea>
        
        <br />
        <input type="submit" class="btn btn-primary" value="Update Post">
    </div>

@endsection

