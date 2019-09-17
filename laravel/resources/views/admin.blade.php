@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Blog Settings</h1>
        <form action="{{ route('update-settings') }}" method="POST">
        @csrf

        <label for="title">Blog Title</label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $settings->title) }}" disabled>

        <label for="title">Comments</label><br>

        <label for="title">Theme</label><br>
        <br />
        <input type="submit" class="btn btn-primary" value="Update Settings">
        <hr />

        <h2>Categories</h2>

        <hr />

    </div>
        
    <div class="container">
        <h2>All Blog Users</h2>

        <ul>
            @foreach($users as $user)
                <?php
                    // TODO: Cleanup, there's a better way.
                    if ($user->role == 1) $role = "Admin";
                    if ($user->role == 2) $role = "User";
                ?> 
                <li>{{ $user->name }} | {{ $role }} | {{ $user->created_at }}</li>
            @endforeach
        </ul>

    </div>

@endsection
