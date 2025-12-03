@extends('layouts.app')
<title>{{ $post->title }}</title>

@section('content')
    <div class="post-content container">

        @if (Auth::check() && Auth::user()->role == 1)
            <a class="btn btn-primary pa-inline-block" href="{{ url('/posts?page=' . request('page', 1)) }}">
                <i class="bi bi-chevron-left"></i> Back to Posts
            </a>
            <a class="btn btn-primary pa-inline-block"
               href="{{ strtolower(url('/posts/edit/' . str_replace(' ', '-', $post->user->name) . '/' . $post->slug)) }}">
                Edit Post
            </a>
            <form class="pa-inline-block mb-3"
                  action="/posts/{{ $post->id }}"
                  method="POST">
                @csrf
                @method('DELETE')
                <input name="id"
                       value="{{ $post->id }}"
                       hidden>
                <input class="btn btn-danger pa-inline-block"
                       type="submit"
                       value="Delete Post"
                       onclick="if (confirm('Are you sure you want to delete this post?')) { this.closest('form').submit(); } return false">
            </form>
        @else
            <a class="btn btn-primary pa-inline-block" href="/posts">
                <i class="bi bi-chevron-left"></i> Back to Posts
            </a>
        @endif

        <h1 class="post-title">{{ $post->title }}</h1>
        <p class="post-meta">
            <i class="bi bi-calendar"></i>
            {{ date_format($post->created_at, 'Y/m/d') }}
            <i class="bi bi-person-fill"></i>
            <a href="{{ '/posts/user/' . $post->user->name }}">{{ $post->user->name }}</a>
            <i class="bi bi-clock"></i>
            {{ \App\Http\Controllers\PostController::generateReadingTime($post) }} minutes
            <i class="bi bi-tag"></i>
            <a href="{{ '/posts/category/' . $post->category->category }}">{{ $post->category->category }}</a>
        </p>
        <div class="banner-image-container">
            @if (isset($post->image))
                <img class="banner-image"
                     src="{{ \App\Http\Controllers\ImageController::getImageAssetPath($post->image->subdirectory, $post->image->filename) }}">
            @else
                <img class="banner-image" src="{{ asset(\App\Http\Controllers\ImageController::$defaultBannerImage) }}">
            @endif
        </div>
        <div id="trix-content">
            {!! $post->post !!}
        </div>

        <div class="social">

            <?php $url = config('app.url') . '/' . str_replace(' ', '-', $post->user->name) . '/' . $post->slug; ?>
            <!-- https://sharingbuttons.io -->
            <!-- Sharingbutton Facebook -->
            <a class="resp-sharing-button__link"
               href="https://facebook.com/sharer/sharer.php?u={{ $url }}"
               target="_blank"
               rel="noopener"
               aria-label="">
                <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--small">
                    <div class="resp-sharing-button__icon resp-sharing-button__icon--solid" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                  d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Sharingbutton Twitter -->
            <a class="resp-sharing-button__link"
               href="https://twitter.com/intent/tweet/?text={{ $post->title }}&nbsp;|&nbsp;{{ $settings->title }}&amp;url={{ $url }}"
               target="_blank"
               rel="noopener"
               aria-label="">
                <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--small">
                    <div class="resp-sharing-button__icon resp-sharing-button__icon--solid" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                  d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Sharingbutton Pinterest -->
            <a class="resp-sharing-button__link"
               href="https://pinterest.com/pin/create/button/?url={{ $url }}&amp;media={{ $url }}&amp;description={{ $post->title }}&nbsp;|&nbsp;{{ $settings->title }}"
               target="_blank"
               rel="noopener"
               aria-label="">
                <div class="resp-sharing-button resp-sharing-button--pinterest resp-sharing-button--small">
                    <div class="resp-sharing-button__icon resp-sharing-button__icon--solid" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                  d="M12.14.5C5.86.5 2.7 5 2.7 8.75c0 2.27.86 4.3 2.7 5.05.3.12.57 0 .66-.33l.27-1.06c.1-.32.06-.44-.2-.73-.52-.62-.86-1.44-.86-2.6 0-3.33 2.5-6.32 6.5-6.32 3.55 0 5.5 2.17 5.5 5.07 0 3.8-1.7 7.02-4.2 7.02-1.37 0-2.4-1.14-2.07-2.54.4-1.68 1.16-3.48 1.16-4.7 0-1.07-.58-1.98-1.78-1.98-1.4 0-2.55 1.47-2.55 3.42 0 1.25.43 2.1.43 2.1l-1.7 7.2c-.5 2.13-.08 4.75-.04 5 .02.17.22.2.3.1.14-.18 1.82-2.26 2.4-4.33.16-.58.93-3.63.93-3.63.45.88 1.8 1.65 3.22 1.65 4.25 0 7.13-3.87 7.13-9.05C20.5 4.15 17.18.5 12.14.5z" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Sharingbutton E-Mail -->
            <a class="resp-sharing-button__link"
               href="mailto:?subject={{ $post->title }}&nbsp;|&nbsp;{{ $settings->title }}&amp;body={{ $url }}"
               target="_self"
               rel="noopener"
               aria-label="">
                <div class="resp-sharing-button resp-sharing-button--email resp-sharing-button--small">
                    <div class="resp-sharing-button__icon resp-sharing-button__icon--solid" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                  d="M22 4H2C.9 4 0 4.9 0 6v12c0 1.1.9 2 2 2h20c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM7.25 14.43l-3.5 2c-.08.05-.17.07-.25.07-.17 0-.34-.1-.43-.25-.14-.24-.06-.55.18-.68l3.5-2c.24-.14.55-.06.68.18.14.24.06.55-.18.68zm4.75.07c-.1 0-.2-.03-.27-.08l-8.5-5.5c-.23-.15-.3-.46-.15-.7.15-.22.46-.3.7-.14L12 13.4l8.23-5.32c.23-.15.54-.08.7.15.14.23.07.54-.16.7l-8.5 5.5c-.08.04-.17.07-.27.07zm8.93 1.75c-.1.16-.26.25-.43.25-.08 0-.17-.02-.25-.07l-3.5-2c-.24-.13-.32-.44-.18-.68s.44-.32.68-.18l3.5 2c.24.13.32.44.18.68z" />
                        </svg>
                    </div>
                </div>
            </a>

        </div>

        <hr>

        <div class="row author">
            <div class="col-md-2">
                @if (isset($post->user->image))
                    <img class="avatar"
                         src="{{ \App\Http\Controllers\ImageController::getImageAssetPath($post->user->image->subdirectory, $post->user->image->filename) }}">
                @else
                    <i class="bi bi-person-fill pa-font-xl avatar"></i>
                @endif
            </div>

            <div class="col-md-10">
                <p><b>{{ $post->user->name }}</b><br />{{ $post->user->bio }}</p>
            </div>
        </div>

        @if ($settings->comments == 1)
            <hr>
            <h4>Comments</h4>

            @if (Auth::check())
                <form action="/comments" method="POST">
                    @csrf

                    <input type="text"
                           name="post_id"
                           value="{{ $post->id }}"
                           hidden>
                    <textarea class="form-control"
                              name="comment"
                              rows="3"
                              placeholder="Commenting as {{ Auth::user()->name }}...">{{ old('comment') }}</textarea>
                    <input class="btn btn-primary"
                           type="submit"
                           value="Add Comment">
                </form>
            @else
                <p>Please <a href="/login">login</a> to leave a comment.</p>
            @endif

            <div class="table-responsive">
                <table class="table-striped table">
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    <p>{{ $comment->comment }}</p>
                                    @if (isset($comment->user->image))
                                        <img class="avatar-small"
                                             src="{{ \App\Http\Controllers\ImageController::getImageAssetPath($comment->user->image->subdirectory, $comment->user->image->filename) }}">
                                    @else
                                        <i class="bi bi-person-fill pa-font-lg avatar-small"></i>
                                    @endif

                                    <i>&nbsp;{{ $comment->user->name }} -
                                        {{ date_format($comment->created_at, 'Y/m/d') }}</i>

                                    @if (Auth::check())
                                        <form action="/comments/{{ $comment->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <br />
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="this.form.submit();">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $comments->links() }}
            </div>
        @endif
    </div>
@endsection
