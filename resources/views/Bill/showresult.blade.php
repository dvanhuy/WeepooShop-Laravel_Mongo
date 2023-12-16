<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="display: flex; justify-content: center; align-items: center;font-size: 1.5rem;height: 100vh; flex-direction: column;">
    @if(Session::has('status'))
        <h2 class="status">{{ session('status') }}</h2>
    @endif
    <div>
        <a href="{{ route('get_home_page') }}">Trở về</a>
    </div>
</body>
</html>