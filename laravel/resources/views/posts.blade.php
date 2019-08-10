@extends('layouts.app')

@section('content')

    <div class="container">

        @foreach($posts as $post)
            <div class="post-container-feed">
                <a href="/{{str_replace(" ","-",$post->user->name)}}/{{$post->slug}}" class="post-link">
                    <div class="banner-image-container">
                        @if ($post->banner_image_url == null)
                            <img src="/pics/banner.jpg" class="banner-image">
                        @else
                            <img src="<?= $post->banner_image_url; ?> class='banner-image'>">
                        @endif
                    </div>
                    <div class="post-container-content-feed">
                        <h2>
                            {{$post->title}} <i class="fas fa-arrow-right" id="arrow"></i>
                        </h2>
                        <p class="post-meta">
                            <i class="fas fa-calendar"></i>
                                {{date_format($post->updated_at, 'm/d/Y')}}
                            <i class="fas fa-user"></i>
                                {{$post->user->name}}
                            <i class="fas fa-clock"></i>
                                {{$post->reading_time}} minutes
                            <i class="fas fa-tag"></i>
                                {{$post->category}}</p>
                        <p>
                        <?php 
                            $strippedPost = preg_replace("/[^0-9a-zA-Z_.!?' \r\n+]/", "", $post->post);
                        ?>
                        {{ substr($strippedPost, 0, 255) }}
                        ...
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endsection

