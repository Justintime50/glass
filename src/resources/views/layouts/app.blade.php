<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (isset($post->keywords))
    <meta name="keywords" content="<?= $post->keywords; ?>">
    @else
    <meta name="keywords" content="{{ $settings->title }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->title }}</title>

    <!-- Styles -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/default.min.css" rel="stylesheet">
    <!-- Syntax highlighting -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if ($settings->theme == 2)
    <link href="{{ asset('css/themes/dark.css') }}" rel='stylesheet'>
    @elseif ($settings->theme == 3)
    <link href="{{ asset('css/themes/midnight.css') }}" rel='stylesheet'>
    @elseif ($settings->theme == 4)
    <link href="{{ asset('css/themes/amethyst.css') }}" rel='stylesheet'>
    @endif

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ $settings->title }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
                    aria-controls="navbar" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts') }}">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        @if (Auth::user()->role == 1)
                        <a class="nav-link" href="{{ route('create-post') }}">Create Post</a>
                        @endif
                        <a class="nav-link" href="{{ route('posts') }}">Posts</a>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                @if (Auth::user()->role == 1)
                                <a class="dropdown-item" href="{{ route('images') }}">Images</a>
                                <a class="dropdown-item" href="{{ route('comments') }}">Comments</a>
                                <a class="dropdown-item" href="{{ route('admin') }}">Admin</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="display-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- LARAVEL ERRORS -->
        <div class="container-fluid padding-0">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session()->has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            @if(session()->has('error'))
            <p class="alert alert-danger {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}
            </p>
            @endif
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/0dd4ecd465.js"></script>
    <!-- Syntax highlighting for posts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>
    <script>
        hljs.initHighlightingOnLoad();
    </script>
</body>

</html>
