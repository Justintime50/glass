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

        <hr>

        <!-- UPLOAD BUTTONS -->
        <form action="/update-profile-pic" method="post" enctype="multipart/form-data" id="submit_profile_pic">
            @csrf
            <label>Profile Picture</label>
            <input type="text" name="id" value="{{Auth::user()->id}}" hidden>
            @php
                if (!file_exists("/storage/avatars/".Auth::user()->id.".png")) {
                    echo '<img src="/storage/avatars/user-icon.png" class="profile-thumbnail">';
                } else {
                    echo '<img src="/storage/avatars/'.Auth::user()->id.'.png" class="profile-thumbnail">';
                }
            @endphp
            <br>
            <small>Picture must be a jpg or png no bigger than 2mb.</small>
            <br><br>

            <label for="upload" class="btn btn-primary">Update Profile Picture</label>
            <input type="file" id="upload" name="Upload Picture" hidden>

            <br><br>
            <input type="submit" name="Submit" id="submit" class="btn btn-primary">
        </form>

    </div>

@endsection
