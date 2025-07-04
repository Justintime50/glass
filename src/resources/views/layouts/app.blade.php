<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if (isset($post->keywords))
        <meta name="keywords" content="{{ $post->keywords }}">
    @else
        <meta name="keywords" content="{{ $settings->title }}">
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->title }}</title>

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @if ($settings->theme == 2)
        @vite(['resources/sass/themes/dark.scss'])
    @elseif ($settings->theme == 3)
        @vite(['resources/sass/themes/midnight.scss'])
    @elseif ($settings->theme == 4)
        @vite(['resources/sass/themes/amethyst.scss'])
    @elseif ($settings->theme == 5)
        @vite(['resources/sass/themes/golf.scss'])
    @endif
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    {{ $settings->title }}
                </a>
                <button class="navbar-toggler"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbar"
                        type="button"
                        aria-controls="navbar"
                        aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbar">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/posts">Posts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="/register">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (Auth::user()->role == 1)
                                <a class="nav-link" href="/create-post">Create Post</a>
                            @endif
                            <a class="nav-link" href="/posts">Posts</a>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle"
                                   id="navbarDropdown"
                                   data-bs-toggle="dropdown"
                                   href="#"
                                   role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false"
                                   v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/profile">Profile</a>
                                    @if (Auth::user()->role == 1)
                                        <a class="dropdown-item" href="/images">Images</a>
                                        <a class="dropdown-item" href="/comments">Comments</a>
                                        <a class="dropdown-item" href="/admin">Admin</a>
                                    @endif
                                    <a class="dropdown-item"
                                       href="/logout"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form class="pa-display-none"
                                          id="logout-form"
                                          action="/logout"
                                          method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <section>
            {{-- $errors are validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger rounded-0 alert-dismissible fade show" role="alert">
                    <div class="container">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="btn-close"
                                data-bs-dismiss="alert"
                                type="button"
                                aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-info rounded-0 alert-dismissible fade show" role="alert">
                    <div class="container">
                        {{ Session::get('message') }}
                        <button class="btn-close"
                                data-bs-dismiss="alert"
                                type="button"
                                aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger rounded-0 alert-dismissible fade show" role="alert">
                    <div class="container">
                        {{ Session::get('error') }}
                        <button class="btn-close"
                                data-bs-dismiss="alert"
                                type="button"
                                aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </section>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
