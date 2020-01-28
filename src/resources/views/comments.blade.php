@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Comments</h1>
    @forelse($comments as $comment)
        <br /><hr /><br />
        <p>{{$comment->comment}}</p>
        <i>{{$comment->user->name}} - {{date_format($comment->updated_at, 'm/d/Y')}} | On: {{$comment->post->title}}</i>
        @empty
        <p>No comments yet.</p>
    @endforelse
</div>

@endsection
