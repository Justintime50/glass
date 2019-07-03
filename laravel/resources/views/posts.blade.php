@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Posts</h1>

        @foreach($posts as $post)
            <br /><hr><br />
            <h2>
                <a href="/{{$post->user->name}}/{{$post->slug}}">{{$post->title}}</a>
            </h2>
            <h4>{{$post->user->name}}</h4>
            <p>{{date_format($post->updated_at, 'm/d/Y')}}</p>
            <p>
                {!! 
                    Parsedown::instance()
                        ->setSafeMode(true)
                        ->text($post->post); 
                !!}
            </p>
        @endforeach
    </div>

@endsection

