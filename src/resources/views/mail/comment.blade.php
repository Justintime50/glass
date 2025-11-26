<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Someone left a comment!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            color: #222;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #e0e0e0;
            padding: 32px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Someone left a comment!</h1>

        <p>{{ $user->name }} left a comment on your post titled "<strong>{{ $post->title }}</strong>":</p>

        <blockquote style="border-left: 4px solid #007bff; padding-left: 16px; color: #555;">
            {{ $comment }}
        </blockquote>
    </div>
</body>

</html>
