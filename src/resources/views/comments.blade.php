@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Comments</h1>

        @foreach($comments as $comment)
            <br /><hr /><br />
            <p>{{$comment->comment}}</p>
            <i>{{$comment->user->name}} - {{date_format($comment->updated_at, 'm/d/Y')}} | On: {{$comment->post->title}}</i>
        @endforeach
    </div>

@endsection

