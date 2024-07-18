@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Comments</h1>

        <div class="table-responsive">
            <table class="table-striped table">
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
                            <td>{{ $comment->comment }}</td>
                            <td>
                                @if (
                                    \App\Http\Controllers\ImageController::getImagePublicPath(
                                        $comment->user->image?->subdirectory,
                                        $comment->user->image?->filename) !== null)
                                    <img src="{{ \App\Http\Controllers\ImageController::getImageAssetPath($comment->user->image->subdirectory, $comment->user->image->filename) }}"
                                        class="avatar-small">
                                @else
                                    <i class="bi bi-person-fill pa-font-lg avatar-small"></i>
                                @endif
                                <br />{{ $comment->user->name }}
                            </td>
                            <td>{{ date_format($comment->created_at, 'Y/m/d') }}</td>
                            <td>
                                <a href="/{{ $comment->post->user->name }}/{{ $comment->post->slug }}">
                                    {{ $comment->post->title }}
                                </a>
                            </td>
                            <td>
                                <form action="/comments/{{ $comment->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="this.form.submit();">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <p>No comments yet.</p>
                    @endforelse
                </tbody>
            </table>
            {{ $comments->links() }}
        </div>
    </div>
@endsection
