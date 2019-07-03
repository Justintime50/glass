@extends('layouts.app')

<!-- TODO: Add keywords database entry to the keywords meta tag -->

@section('content')

    <div class="container">

        <a class="btn btn-primary" style="margin-bottom: 30px;" href="/posts">< Back to Posts</a>

        @if(Auth::check())
                <form action="/delete-post" method="POST" style="margin-bottom: 30px;">
                    <a class="btn btn-primary" style="display:inline-block" href="/edit-post/{{$post->user->name}}/{{$post->slug}}">Edit Post</a>

                    @csrf
                    <input name="id" value="{{$post->id}}" hidden>
                    <input type="submit" style="display:inline-block" class="btn btn-danger" value="Delete Post">
                </form>
        @endif

        <h1>{{$post->title}}</h1>
        <h4>{{$post->user->name}}</h4>
        <p>{{date_format($post->updated_at, 'm/d/Y')}}</p>
        <p>{!! 
            Parsedown::instance()
                ->setSafeMode(true)
                ->text($post->post); 
            !!}
        </p>

        <hr>

        <h4>Comments</h4>
        <p>Comments are disabled.</p>
    </div>

@endsection

