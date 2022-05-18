@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>
        <form action="{{ route('update-profile') }}" method="POST">
            @csrf

            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">

            <label for="bio">Bio</label>
            <textarea class="form-control" rows="6" name="bio">{{ old('bio', Auth::user()->bio) }}</textarea>

            <input type="submit" class="btn btn-primary mt-2 mb-4" value="Update Profile">
        </form>

        <form action="{{ route('update-password') }}" method="POST">
            @csrf

            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" required>

            <input type="submit" class="btn btn-primary mt-2" value="Update Password">
        </form>

        <hr>

        <!-- UPLOAD BUTTONS -->
        <form action="{{ route('update-profile-pic') }}" method="post" enctype="multipart/form-data"
            id="submit_profile_pic">
            @csrf
            <label>Profile Picture</label>
            <small class="avatar-upload-criteria">Picture must be a jpg or png no bigger than 2mb.</small>
            <?php $avatar_path = public_path('storage/images/avatars/' . Auth::user()->id . '.png'); ?>
            @if (file_exists($avatar_path))
                <img src="{{ asset('storage/images/avatars/' . Auth::user()->id . '.png') }}" class="avatar">
            @else
                <i class="fas fa-user fa-3x avatar"></i>
            @endif
            <br />
            <input type="text" name="id" value="{{ Auth::user()->id }}" hidden>
            <label for="profile_pic" class="btn btn-primary">Update Profile Picture</label>
            <input type="file" name="upload_profile_pic" id="profile_pic" onchange="this.form.submit()" hidden>
        </form>

    </div>
@endsection
