<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f3f3f3;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">List of Posts</h1>
    <a href="{{ route('redirectToCreatePost') }}">
        <button >Add Post</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>
                    <td>
                        @if ($post->created_at == NULL)
                            without Date
                        @else
                            {{ $post->created_at }}
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('editPost',$post->id) }}">
                            <button>Edit</button>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('deletePost', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
