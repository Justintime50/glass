@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Create Post</h1>
        <form action="/create-post" method="POST">
        @csrf

        <label for="title">Title</label>
        <input type="text" class="form-control" name="title" value="{{ old('title') }}">

        <label for="slug">Slug (URL)</label>
        <input type="text" class="form-control" name="slug" value="{{ old('slug') }}">

        <label for="reading_time">Reading Time (number of minutes)</label>
        <input type="text" class="form-control" name="reading_time" value="{{ old('reading_time') }}">

        <label for="category">Category</label>
        <input type="text" class="form-control" name="category" value="{{ old('category') }}">

        <label for="keywords">Keywords (separated by commas)</label>
        <input type="text" class="form-control" name="keywords" value="{{ old('keywords') }}">

        <label for="post">Post</label>
        <textarea name="post" class="form-control" rows="6" value="{{ old('post') }}"></textarea>
        
        <br />
        <input type="submit" class="btn btn-primary" value="Create Post">
    </div>

@endsection

