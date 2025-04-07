<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="{{ route('updatePost',$post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input name="title" id="title" value="{{ $post->title }}" type="text" placeholder="enter title here ..."><br>
        <textarea name="content" id="content" placeholder="enter content here ..." >
            {{ $post->content }}
        </textarea><br>
        <input type="submit" value="Edit Post">
    </form>
</body>
</html>