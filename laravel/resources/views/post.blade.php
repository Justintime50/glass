@extends('layouts.app')

@section('content')

    <div class="container">

        @if(Auth::check())
            <form action="/delete-post" method="POST" style="margin-bottom: 30px;">
                <a class="btn btn-primary" style="display:inline-block" href="/edit-post/{{$post->user->name}}/{{$post->slug}}">Edit Post</a>

                @csrf
                <input name="id" value="{{$post->id}}" hidden>
                <input type="submit" style="display:inline-block" class="btn btn-danger" value="Delete Post">
            </form>
        @endif

        <h1 class="post-title">{{$post->title}}</h1>
        <p class="post-meta">
            <i class="fas fa-calendar"></i>
                {{date_format($post->updated_at, 'm/d/Y')}}
            <i class="fas fa-user"></i>
                {{$post->user->name}}
            <i class="fas fa-clock"></i>
                {{$post->reading_time}} minutes
            <i class="fas fa-tag"></i>
                {{$post->category}}
        </p>
        <div class="banner-image-container">
            @if ($post->banner_image_url == null)
                <img src="/pics/banner.jpg" class="banner-image">
            @else
                <img src="<?= $post->banner_image_url; ?> class='banner-image'>">
            @endif
        </div>
        <p>
            {!! 
            Parsedown::instance()
                ->setSafeMode(true)
                ->text($post->post); 
            !!}
        </p>

        <hr>

        <h4>Author</h4>

        <p class="text-center">{{$post->user->name}}</p>

        <hr>

        <h4>Comments</h4>
        @if(Auth::check())
            <form action="/create-comment" method="POST">
                @csrf

                <input type="text" name="post_id" value="{{$post->id}}" hidden>
                <textarea name="comment" class="form-control" rows="3" placeholder="Commenting as {{ Auth::user()->name }}...">{{ old('comment') }}</textarea>
                <br />
                <input type="submit" class="btn btn-primary" value="Add Comment">
            </form>
            @else
            <p>Please <a href="/login">login</a> to leave a comment.</p>
        @endif
        @foreach($comments as $comment)
            <br /><hr /><br />
            <p>{{$comment->comment}}</p>
            <i>{{$comment->user->name}} - {{date_format($comment->updated_at, 'm/d/Y')}}</i>
            @if(Auth::check())
                <form action="/delete-comment" method="POST">
                    @csrf
                    <input type="text" name="id" value="{{$comment->id}}" hidden>
                    <button class="btn btn-sm btn-danger" onclick="this.form.submit();">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            @endif
        @endforeach
    </div>

@endsection

