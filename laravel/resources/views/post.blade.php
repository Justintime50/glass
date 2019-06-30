@extends('layouts.app')

<!-- TODO: Add keywords database entry to the keywords meta tag -->

@section('content')

    <div class="container">

        <p><a href="/posts">< Back to Posts</a></p>

        @if(Auth::check())
            <p>
                <a href="/edit-post/{{$post->user->name}}/{{$post->slug}}">Edit Post</a>
                <br />
                <form action="/delete-post" method="POST">
                    @csrf
                    <input name="id" value="{{$post->id}}" hidden>
                    <input type="submit" value="Delete Post">
                </form>
            </p>
        @endif

        <h1>{{$post->title}}</h1>
        <h4>{{$post->user->name}}</h4>
        <p>{{date_format($post->updated_at, 'm/d/Y')}}</p>
        <p>{{$post->post}}

        <hr>

        <h4>Comments</h4>
        <p>Comments are disabled.</p>
    </div>

@endsection

