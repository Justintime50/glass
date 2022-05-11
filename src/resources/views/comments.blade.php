@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Comments</h1>

    <table class="table">
        <thead>
            <th>Comment</th>
            <th>Author</th>
            <th>Timestamp</th>
            <th>Post</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @forelse($comments as $comment)
            <tr>
                <td>{{$comment->comment}}</td>
                <td>{{$comment->user->name}}</td>
                <td>{{date_format($comment->updated_at, 'm/d/Y')}}</td>
                <td><a href="/{{$comment->post->user->name}}/{{$comment->post->slug}}">{{$comment->post->title}}</a></td>
                <td>
                    <form action="{{ route('delete-comment') }}" method="POST">
                        @csrf
                        <input type="text" name="id" value="{{$comment->id}}" hidden>
                        <button class="btn btn-sm btn-danger" onclick="this.form.submit();">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
                <p>No comments yet.</p>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrapper">
        {{ $comments->links() }}
    </div>
</div>

@endsection
