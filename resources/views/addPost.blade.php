<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('createPost') }}" method="POST">
        @csrf
        <input name="title" id="title" type="text" placeholder="enter title here ..."><br>
        <textarea name="content" id="content" placeholder="enter content here ..."></textarea><br>
        <input type="submit" value="add Post">
    </form>
</body>
</html>