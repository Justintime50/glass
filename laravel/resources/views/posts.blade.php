@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Posts</h1>

        @foreach($posts as $post)
            <br /><hr><br />
            <img src="#">
            <h2>
                <a href="/{{$post->user->name}}/{{$post->slug}}">{{$post->title}}</a>
            </h2>
            <p><i class="fas fa-calendar"></i>&nbsp;&nbsp;{{date_format($post->updated_at, 'm/d/Y')}}&nbsp;&nbsp;<i class="fas fa-user"></i>&nbsp;&nbsp;{{$post->user->name}}&nbsp;&nbsp;<i class="fas fa-tag"></i>&nbsp;&nbsp;{{$post->category}}</p>
            <p>
                {!! 
                    str_limit(Parsedown::instance()
                        ->setSafeMode(true)
                        ->text($post->post), 255); 
                !!}
            </p>
        @endforeach
    </div>

@endsection

