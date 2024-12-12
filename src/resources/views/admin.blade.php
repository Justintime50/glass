@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blog Settings</h1>
        <form action="/settings" method="POST">
            @csrf
            @method('PATCH')

            <label for="title">Blog Title</label>
            <input class="form-control"
                   type="text"
                   name="title"
                   value="{{ old('title', $settings->title) }}">

            <label for="title">Comments</label>
            <select class="form-select" name="comments">
                <option value="1" @if ($settings->comments == 1) {{ 'selected' }} @endif>
                    On
                </option>
                <option value="0" @if ($settings->comments == 0) {{ 'selected' }} @endif>
                    Off
                </option>
            </select>

            <label for="title">Blog Theme</label>
            <select class="form-select" name="theme">
                <option value="1" @if ($settings->theme == 1) {{ 'selected' }} @endif>
                    Light
                </option>
                <option value="2" @if ($settings->theme == 2) {{ 'selected' }} @endif>
                    Dark
                </option>
                <option value="3" @if ($settings->theme == 3) {{ 'selected' }} @endif>
                    Midnight
                </option>
                <option value="4" @if ($settings->theme == 4) {{ 'selected' }} @endif>
                    Amethyst
                </option>
                <option value="5" @if ($settings->theme == 5) {{ 'selected' }} @endif>
                    Golf
                </option>
            </select>

            <input class="btn btn-primary mt-3"
                   type="submit"
                   value="Update Settings">
        </form>
    </div>

    <div class="section-space container">
        <h2>Categories</h2>

        <div class="table-responsive">
            <table class="table-striped table">
                <thead>
                    <th>Name</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->category }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>
                                <form class="pa-inline-block"
                                      id="updateCategory{{ $category->id }}"
                                      action="/categories/{{ $category->id }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input id="newCategoryName{{ $category->id }}"
                                           type="hidden"
                                           name="category"
                                           value="{{ $category->category }}">
                                </form>
                                <button class="btn btn-sm btn-primary pa-inline-block"
                                        onclick="updateCategory({{ $category->id }})">Update</button>

                                <form class="pa-inline-block"
                                      action="/categories/{{ $category->id }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden"
                                           name="id"
                                           value="{{ $category->id }}">
                                    <input class="btn btn-sm btn-danger"
                                           type="submit"
                                           value="Delete"
                                           onclick="submitFormAfterPrompt('Are you sure you want to delete this category?');return false;">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $categories->links() }}

        <h3>Create New Category</h3>
        <form action="/categories" method="POST">
            @csrf
            <input class="form-control"
                   type="text"
                   name="category"
                   value="{{ old('category') }}"
                   placeholder="New category name...">
            <input class="btn btn-primary pa-inline-block mt-2"
                   type="submit"
                   value="Create Category">
        </form>
    </div>

    <div class="section-space container">
        <h2>Blog Posts</h2>

        <div class="table-responsive">
            <table class="table-striped table">
                <thead>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                <a
                                   href="{{ strtolower(url('/' . str_replace(' ', '-', $post->user->name) . '/' . $post->slug)) }}">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td>
                                @php
                                    if ($post->published == 1) {
                                        echo 'Published';
                                    } else {
                                        echo 'Draft';
                                    }
                                @endphp
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                <form action="/posts/{{ $post->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-sm btn-primary pa-inline-block"
                                       href="{{ strtolower(url('/posts/edit/' . $post->user->name . '/' . $post->slug)) }}">Edit</a>
                                    <input class="btn btn-sm btn-danger pa-inline-block"
                                           type="submit"
                                           value="Delete"
                                           onclick="submitFormAfterPrompt('Are you sure you want to delete this post?');return false;">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $posts->links() }}

        <a class="btn btn-primary" href="/create-post">Create Post</a>
    </div>

    <div class="section-space container">
        <h2>Blog Users</h2>

        <div class="table-responsive">
            <table class="table-striped table">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Signed Up</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            if ($user->role == 1) {
                                $role = 'Admin';
                            } elseif ($user->role == 2) {
                                $role = 'User';
                            } else {
                                $role = 'Undefined';
                            }
                        @endphp
                        <tr>
                            <td>
                                @if (isset($user->image))
                                    <img class="avatar-small"
                                         src="{{ \App\Http\Controllers\ImageController::getImageAssetPath($user->image->subdirectory, $user->image->filename) }}">
                                @else
                                    <i class="bi bi-person-fill pa-font-lg avatar-small"></i>
                                @endif
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                <form action="/users/{{ $user->id }}/role" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden"
                                           name="id"
                                           value="{{ $user->id }}">
                                    {{-- Don't allow changing your own role (so you don't accidentally remove admin privileges) --}}
                                    <select class="form-select"
                                            name="role"
                                            onchange="this.form.submit()"
                                            @if ($user->id == Auth::user()->id) {{ 'disabled' }} @endif>
                                        <option value="1"
                                                @if ($user->role == 1) {{ 'selected' }} @endif>Admin
                                        </option>
                                        <option value="2"
                                                @if ($user->role == 2) {{ 'selected' }} @endif>
                                            User</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                {{ $user->created_at }}
                            </td>
                            <td>
                                {{-- Don't allow deleting yourself --}}
                                @if ($user->id != Auth::user()->id)
                                    <form action="/users/{{ $user->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden"
                                               name="id"
                                               value="{{ $user->id }}">
                                        <input class="btn btn-sm btn-danger"
                                               type="submit"
                                               value="Delete">
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>

    <script>
        // Show a prompt to update the category name and replace it in the form as we submit it
        function updateCategory(id) {
            let newCategoryName = prompt("Enter a new category name:");
            if (newCategoryName != null) {
                document.getElementById(`newCategoryName${id}`).value = newCategoryName;
                document.getElementById(`updateCategory${id}`).submit();
            }
        }

        // Prompts the user prior to submitting a form
        function submitFormAfterPrompt(message = null) {
            if (confirm(message) == true) {
                this.closest('form').submit();
            }
        }
    </script>
@endsection
