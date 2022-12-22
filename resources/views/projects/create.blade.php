<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="/projects" method="POST">
    @csrf
    <div>
        <input type="text" name="title">
    </div>
    <div>
        <textarea name="description" cols="30" rows="10"></textarea>
    </div>
</form>
</body>
</html>
