<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    <p>Your email: {{ auth()->user()->email }}</p>
    <img src="{{ auth()->user()->avatar }}" alt="Your Avatar" width="100" />
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
