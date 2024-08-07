@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>
        <form action="/update-profile" method="POST">
            @csrf
            @method('PATCH')

            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">

            <label for="bio">Bio</label>
            <textarea class="form-control" rows="6" name="bio">{{ old('bio', Auth::user()->bio) }}</textarea>

            <input type="submit" class="btn btn-primary mb-4 mt-2" value="Update Profile">
        </form>

        <form action="/update-password" method="POST">
            @csrf

            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" required>

            <input type="submit" class="btn btn-primary mt-2" value="Update Password">
        </form>

        <hr>

        <form action="/update-profile-pic" method="POST" enctype="multipart/form-data" id="submit_profile_pic">
            @csrf
            <label>Profile Picture</label>
            <small class="avatar-upload-criteria">Picture must be a jpg or png no bigger than 2mb.</small>
            @if (
                \App\Http\Controllers\ImageController::getImagePublicPath(Auth::user()->image?->subdirectory,
                    Auth::user()->image?->filename) !== null)
                <img src="{{ \App\Http\Controllers\ImageController::getImageAssetPath(Auth::user()->image->subdirectory, Auth::user()->image->filename) }}"
                    class="avatar">
            @else
                <i class="bi bi-person-fill pa-font-xl avatar"></i>
            @endif
            <br />
            <label for="profile_pic" class="btn btn-primary">Update Profile Picture</label>
            <input type="file" name="image" id="profile_pic" onchange="this.form.submit()" hidden>
        </form>

    </div>
@endsection
