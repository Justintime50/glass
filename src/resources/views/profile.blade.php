@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>
        <form action="/update-profile" method="POST">
            @csrf
            @method('PATCH')

            <label for="name">Name</label>
            <input class="form-control"
                   type="text"
                   name="name"
                   value="{{ Auth::user()->name }}">

            <label for="bio">Bio</label>
            <textarea class="form-control"
                      rows="6"
                      name="bio">{{ old('bio', Auth::user()->bio) }}</textarea>

            <input class="btn btn-primary mb-4 mt-2"
                   type="submit"
                   value="Update Profile">
        </form>

        <form action="/update-password" method="POST">
            @csrf

            <label for="password">Password</label>
            <input class="form-control"
                   type="password"
                   name="password"
                   required>

            <label for="password_confirmation">Confirm Password</label>
            <input class="form-control"
                   type="password"
                   name="password_confirmation"
                   required>

            <input class="btn btn-primary mt-2"
                   type="submit"
                   value="Update Password">
        </form>

        <hr>

        <form id="submit_profile_pic"
              action="/update-profile-pic"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            <label>Profile Picture</label>
            <small class="avatar-upload-criteria">Picture must be a jpg or png no bigger than 2mb.</small>
            @if (isset(Auth::user()->image))
                <img class="avatar"
                     src="{{ \App\Http\Controllers\ImageController::getImageAssetPath(Auth::user()->image->subdirectory, Auth::user()->image->filename) }}">
            @else
                <i class="bi bi-person-fill pa-font-xl avatar"></i>
            @endif
            <br />
            <label class="btn btn-primary" for="profile_pic">Update Profile Picture</label>
            <input id="profile_pic"
                   type="file"
                   name="image"
                   onchange="this.form.submit()"
                   hidden>
        </form>

    </div>
@endsection
