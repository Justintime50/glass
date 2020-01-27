@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Profile</h1>
        <form action="{{ route('update-profile') }}" method="POST">
        @csrf

        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" disabled>

        <label for="name">Password</label>
        <input type="password" class="form-control" name="password" value="" disabled>
        <input type="password" class="form-control" name="password" value="" disabled>

        <label for="bio">Bio</label>
        <textarea class="form-control" rows="6" name="bio">{{ old('bio', Auth::user()->bio) }}</textarea>

        <br />
        <input type="submit" class="btn btn-primary" value="Update Profile">

    </div>

@endsection
