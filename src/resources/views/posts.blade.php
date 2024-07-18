@extends('layouts.app')

@section('content')
    <div class="container">
        @if (isset($categoryRecord))
            <h1>{{ $categoryRecord->category }} Posts</h1>
        @endif

        @forelse($posts as $post)
            <div class="post-container-feed">
                <a href="{{ strtolower(url('/' . str_replace(' ', '-', $post->user->name) . '/' . $post->slug)) }}"
                    class="post-link">
                    <div class="banner-image-container">
                        @if (
                            \App\Http\Controllers\ImageController::getImagePublicPath($post->image?->subdirectory, $post->image?->filename) !==
                                null)
                            <img src="{{ \App\Http\Controllers\ImageController::getImageAssetPath($post->image->subdirectory, $post->image->filename) }}"
                                class="banner-image">
                        @else
                            <img src="{{ asset(\App\Http\Controllers\ImageController::$defaultBannerImage) }}"
                                class="banner-image">
                        @endif
                    </div>
                    <div class="post-container-content-feed">
                        <h2>
                            {{ $post->title }} <i class="bi bi-arrow-right" id="arrow"></i>
                        </h2>
                        <p class="post-meta">
                            <i class="bi bi-calendar"></i>
                            {{ date_format($post->created_at, 'Y/m/d') }}
                            <i class="bi bi-person-fill"></i>
                            {{ $post->user->name }}
                            <i class="bi bi-clock"></i>
                            {{ \App\Http\Controllers\PostController::generateReadingTime($post) }} minutes
                            <i class="bi bi-tag"></i>
                            {{ $post->category->category }}
                        </p>
                        <p>
                            <?php $strippedPost = preg_replace("/[^0-9a-zA-Z_.!?' \r\n+]/", '', $post->post); ?>
                            {{ substr($strippedPost, 0, 255) }}
                            ...
                        </p>
                    </div>
                </a>
            </div>
        @empty
            <h2>No posts yet.</h2>
            <p>If you are the owner of this blog, you should <a href="/create-post">create your first
                    post</a>!</p>
        @endforelse
        <div class="pagination-wrapper">
            {{ $posts->links() }}
        </div>

        <h3>Categories</h3>
        <a href="/posts" class="btn btn-sm btn-primary category-button">All Posts</a>
        @foreach ($categories as $category)
            <a href="/posts/category/{{ $category->category }}"
                class="btn btn-sm btn-primary category-button">{{ $category->category }}</a>
        @endforeach

        <h3 class="mt-3">Users</h3>
        <a href="/posts" class="btn btn-sm btn-primary category-button">All Users</a>
        @foreach ($authors as $author)
            <a href="/posts/user/{{ $author->name }}"
                class="btn btn-sm btn-primary category-button">{{ $author->name }}</a>
        @endforeach
    </div>
@endsection
