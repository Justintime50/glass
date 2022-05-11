@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Blog Settings</h1>
    <form action="{{ route('update-settings') }}" method="POST">
        @csrf

        <label for="title">Blog Title</label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $settings->title) }}">

        <label for="title">Comments</label>
        <select name="comments" class="form-select">
            <option value="1" <?php if ($settings->comments == 1) { echo "selected"; } ?>>On</option>
            <option value="0" <?php if ($settings->comments == 0) { echo "selected"; } ?>>Off</option>
        </select>

        <label for="title">Blog Theme</label>
        <select name="theme" class="form-select">
            <option value="1" <?php if ($settings->theme == 1) { echo "selected"; } ?>>Light</option>
            <option value="2" <?php if ($settings->theme == 2) { echo "selected"; } ?>>Dark</option>
            <option value="3" <?php if ($settings->theme == 3) { echo "selected"; } ?>>Midnight</option>
            <option value="4" <?php if ($settings->theme == 4) { echo "selected"; } ?>>Amethyst</option>
        </select>

        <input type="submit" class="btn btn-primary mt-3" value="Update Settings">

    </form>

</div>

<div class="container section-space">
    <h2>Categories</h2>

    <table class="table">
        <thead>
            <th>Name</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->category }}</td>
                <td>{{ $category->user->name }}</td>
                <td>{{ $category->created_at }}</td>
                <td>
                    <form action="{{ route('update-category') }}" method="POST" id="updateCategory" class="inline-block">
                        @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <input type="hidden" name="category" value="{{ $category->category }}" id="newCategoryName">
                    </form>
                    <button onclick="updateCategory()" class="btn btn-sm btn-primary inline-block">Update Category</button>
                    <form action="{{ route('delete-category') }}" method="post" class="inline-block">
                        @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <input type="submit" value="Delete Category" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper">
        {{ $categories->links() }}
    </div>

    <h3>Create New Category</h3>
    <form action="{{ route('create-category') }}" method="post">
        @csrf
        <input type="text" class="form-control" name="category" value="{{ old('category') }}"
            placeholder="New category name...">
        <input type="submit" value="Create category" class="btn btn-primary inline-block mt-2">
    </form>

</div>

<div class="container section-space">
    <h2>Blog Posts</h2>

    <table class="table">
        <thead>
            <th>Title</th>
            <th>Status</th>
            <th>Author</th>
            <th>Created At</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>
                    <a href="{{ strtolower(url('/'.str_replace(' ','-',$post->user->name).'/'.$post->slug)) }}">
                        {{ $post->title }}
                    </a>
                </td>
                <td>
                    @php
                        if ($post->published == 1) {
                            echo "Published";
                        } else {
                            echo "Draft";
                        }
                    @endphp
                </td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->created_at }}</td>
                <td>
                    <form action="{{ route('delete-post') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <a class="btn btn-sm btn-primary inline-block"
                            href="{{ strtolower(url('/edit-post/'.$post->user->name.'/'.$post->slug)) }}">Edit Post</a>
                        <input type="submit" value="Delete Post" class="btn btn-sm btn-danger inline-block">
                    </form>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
    <div class="pagination-wrapper">
        {{ $posts->links() }}
    </div>

    <a href="{{ route('create-post') }}" class="btn btn-primary">Create Post</a>

</div>

<div class="container section-space">
    <h2>Blog Users</h2>

    <table class="table">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Signed Up</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($users as $user)
            @php
                if ($user->role == 1) {
                    $role = "Admin";
                } elseif ($user->role == 2) {
                    $role = "User";
                } else {
                    $role = "Undefined";
                }
            @endphp
            <tr>
                <td>
                    @php $avatar_path = public_path("storage/images/avatars/$user->id.png"); @endphp
                    @if (file_exists($avatar_path))
                        <img src="{{ asset("storage/images/avatars/$user->id.png") }}" class="avatar-small">
                    @else
                        <i class="fas fa-user fa-2x avatar-small"></i>
                    @endif
                    {{ $user->name }}
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <form action="{{ route('update-user-role') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <select name="role" onchange="this.form.submit()" class="form-select">
                            <option value="1" <?php if ($user->role == 1) { echo "selected"; } ?>>Admin</option>
                            <option value="2" <?php if ($user->role == 2) { echo "selected"; } ?>>User</option>
                            <select>
                    </form>
                </td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <form action="{{ route('delete-user') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input type="submit" value="Delete User" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>

</div>

<script>
    // Show a prompt to update the category name and replace it in the form as we submit it
    function updateCategory() {
        let newCategoryName = prompt("Enter a new category name:");
        if (newCategoryName != null) {
            document.getElementById("newCategoryName").value = newCategoryName;
            document.getElementById("updateCategory").submit();
        }
    }
</script>

@endsection
