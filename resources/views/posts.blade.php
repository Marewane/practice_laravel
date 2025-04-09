<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        h1 {
            text-align: center;
            padding: 20px;
            background-color: #007BFF;
            color: white;
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 8px 16px;
            margin: 10px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        input[type="text"] {
            padding: 8px;
            margin: 10px 0;
            width: 60%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        td button {
            background-color: #ffc107;
            border-radius: 5px;
            padding: 6px 12px;
        }

        td button:hover {
            background-color: #e0a800;
        }

        .pagination {
            display: flex;
            justify-content: center; /* Center items horizontally */
            align-items: center; /* Align items vertically */
            gap: 10px; /* Add spacing between items */
            margin-top: 20px;
        }

        .pagination-item {
            display: flex;
            align-items: center; /* Ensure icons are vertically aligned */
        }

        .pagination-info {
            font-size: 14px;
            color: #333;
        }

        .page-link,
        .disabled-icon {
            display: flex; /* Use flexbox for consistent alignment */
            align-items: center; /* Vertically align content */
            justify-content: center; /* Horizontally align content */
            width: 30px; /* Fixed width for consistency */
            height: 30px; /* Fixed height for consistency */
            border-radius: 50%; /* Circular shape for better aesthetics */
            background-color: transparent; /* Transparent background */
            transition: transform 0.2s ease, background-color 0.3s ease;
        }

        .page-link:hover {
            background-color: #e0f0ff; /* Light blue hover effect */
            transform: scale(1.1); /* Slightly enlarge icon on hover */
        }

        .disabled-icon {
            opacity: 0.5; /* Gray out disabled icons */
            cursor: not-allowed; /* Indicate that it's not clickable */
            pointer-events: none; /* Disable click events */
        }

        .icon {
            width: 16px; /* Set a fixed size for the icons */
            height: 16px; /* Set a fixed size for the icons */
            transition: transform 0.2s ease;
        }

        .disabled-icon .icon:hover {
            transform: none; /* Prevent scaling on hover for disabled icons */
        }

        /* Pagination icon styles */
         .pagination svg {
            width: 16px;  /* Set the size of the icon */
            height: 16px; /* Set the height of the icon */
            margin: 0 5px;
            vertical-align: middle;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .pagination svg:hover {
            transform: scale(1.2); /* Slightly enlarge icon on hover */
        }

        .actions-form {
            text-align: center;
            margin-top: 30px;
        }

        .actions-form button {
            background-color: #dc3545;
            font-size: 14px;
            margin: 5px 0;
        }

        .actions-form button:hover {
            background-color: #c82333;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>List of Posts</h1>

        <div style="text-align: center;">
            <a href="{{ route('redirectToCreatePost') }}">
                <button>Add Post</button>
            </a>
            <a href="{{ route('getPosts') }}">
                <button>Get All Posts</button>
            </a>
        </div>

        <form action="{{ route('searchPosts') }}" method="POST" style="text-align: center;">
            @csrf
            <input type="text" placeholder="Looking for posts..." name="title">
            <input type="submit" value="Search">
        </form>

        @php
            $isSearch = isset($searchedPosts);
            $posts = $isSearch ? $searchedPosts : $postsData;
            $totalPosts = $isSearch ? count($searchedPosts) : $totPosts;
        @endphp

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>{{ $post->created_at ?? 'Without Date' }}</td>
                        <td>{{ $post->updated_at ?? 'Does not updated' }}</td>
                        <td>
                            <a href="{{ route('editPost', $post->id) }}">
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

        @if (!$isSearch)
            <div class="pagination">
                <!-- Previous Page Link -->
                <div class="pagination-item">
                    @if ($postsData->previousPageUrl())
                        <a href="{{ $postsData->previousPageUrl() }}" class="page-link" title="Previous">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    @else
                        <span class="disabled-icon">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    @endif
                </div>

                <!-- Current Page and Total Pages -->
                <div class="pagination-info">
                    <span>Page {{ $postsData->currentPage() }} of {{ $postsData->lastPage() }} (Total Posts: {{ $totalPosts }})</span>
                </div>

                <!-- Next Page Link -->
                <div class="pagination-item">
                    @if ($postsData->nextPageUrl())
                        <a href="{{ $postsData->nextPageUrl() }}" class="page-link" title="Next">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    @else
                        <span class="disabled-icon">
                            <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif

        <div class="actions-form">
            <form action="{{ route('deleteAllPosts') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete All Posts</button>
            </form>

            <form action="{{ route('deleteAllPostsWithBackUp') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete All Posts with Backup</button>
            </form>

            <form action="{{ route('restorePosts') }}" method="POST">
                @csrf
                <button type="submit">Reset Origin Table</button>
            </form>
        </div>
    </div>

</body>
</html>