@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Comments</h1>
    @forelse($comments as $comment)
    <hr />
    <p>{{$comment->comment}}</p>
    <i>{{$comment->user->name}} - {{date_format($comment->updated_at, 'm/d/Y')}} | On Post: <a
            href="/{{$comment->post->user->name}}/{{$comment->post->slug}}">{{$comment->post->title}}</a></i>
    <form action="{{ route('delete-comment') }}" method="POST">
        @csrf
        <input type="text" name="id" value="{{$comment->id}}" hidden>
        <button class="btn btn-sm btn-danger" onclick="this.form.submit();">
            <i class="fas fa-trash"></i>
        </button>
    </form>
    @empty
    <p>No comments yet.</p>
    @endforelse
</div>

@endsection
