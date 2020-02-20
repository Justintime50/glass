@extends('layouts.app')
<title>{{ $post->title }}</title>

@section('content')

    <div class="container post-content">

        @if(!Auth::check())
            <a class="btn btn-primary" style="display:inline-block" href="/"><i class="fas fa-chevron-left"></i> Back to Posts</a>
        @endif

        @if(Auth::check())
            <form action="{{ route('delete-post') }}" method="POST" style="margin-bottom: 30px;">
                <a class="btn btn-primary" style="display:inline-block" href="/"><i class="fas fa-chevron-left"></i> Back to Posts</a>
                <a class="btn btn-primary" style="display:inline-block" href="{{ url('/edit-post/'.$post->user->name.'/'.$post->slug) }}">Edit Post</a>

                @csrf
                <input name="id" value="{{$post->id}}" hidden>
                <input type="submit" style="display:inline-block" class="btn btn-danger" value="Delete Post">
            </form>
        @endif

        <h1 class="post-title">{{ $post->title }}</h1>
        <p class="post-meta">
            <i class="fas fa-calendar"></i>
                {{date_format($post->updated_at, 'm/d/Y')}}
            <i class="fas fa-user"></i>
                {{ $post->user->name }}
            <i class="fas fa-clock"></i>
                {{ $post->reading_time }} minutes
            <i class="fas fa-tag"></i>
                {{ $post->category->category }}
        </p>
        <div class="banner-image-container">
            @if ($post->banner_image_url == null)
                <img src="{{ asset('pics/banner.jpg') }}" class="banner-image">
            @else
                <img src="{{ asset($post->banner_image_url) }}" class="banner-image">
            @endif
        </div>
        <div>
            {!! 
            Parsedown::instance()
                ->setSafeMode(true)
                ->text($post->post); 
            !!}
        </div>

        <hr>

        <div class="row author">
                
            <div class="col-md-1">
                <?php $avatar_path = "/storage/avatars/".$post->user->id.".png"; ?>
                @if (!file_exists($avatar_path))
                    <i class="fas fa-user fa-3x avatar"></i>
                @else
                    <img src="{{$avatar_path}}" class="avatar">
                @endif

            </div>
            <div class="col-md-11">
                <p><b>{{$post->user->name}}</b><br />{{$post->user->bio}}</p>
            </div>

        </div>

        @if ($settings->comments == 1)

            <hr>

            <h4>Comments</h4>
            @if(Auth::check())
                <form action="{{ route('create-comment') }}" method="POST">
                    @csrf

                    <input type="text" name="post_id" value="{{$post->id}}" hidden>
                    <textarea name="comment" class="form-control" rows="3" placeholder="Commenting as {{ Auth::user()->name }}...">{{ old('comment') }}</textarea>
                    <br />
                    <input type="submit" class="btn btn-primary" value="Add Comment">
                </form>
                @else
                <p>Please <a href="{{ route('login') }}">login</a> to leave a comment.</p>
            @endif
            @forelse($comments as $comment)
                <br /><hr /><br />
                <p>{{$comment->comment}}</p>
                <i>{{$comment->user->name}} - {{date_format($comment->updated_at, 'm/d/Y')}}</i>
                @if(Auth::check())
                    <form action="{{ route('delete-comment') }}" method="POST">
                        @csrf
                        <input type="text" name="id" value="{{$comment->id}}" hidden>
                        <button class="btn btn-sm btn-danger" onclick="this.form.submit();">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
                @empty
                <p>No comments yet.</p>
            @endforelse

        @endif

    </div>

@endsection
