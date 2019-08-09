@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Blog Settings</h1>
        <form action="/update-settings" method="POST">
        @csrf

        <label for="title">Blog Title</label>
        <input type="text" class="form-control" name="title" value="{{ old('title') }}" disabled>

        <br />
        <input type="submit" class="btn btn-primary" value="Update Settings" disabled>
        <hr />

    </div>
        

    <div class="container">
        <h2>All Blog Users</h2>

        <ul>
        @foreach($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
        </ul>

    </div>

@endsection

