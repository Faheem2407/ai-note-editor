<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AI Note Editor - Welcome</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="text-center shadow p-5 rounded bg-white">
        <h1 class="mb-4">📝 AI Note Editor</h1>
        <p class="lead mb-4">Login to start creating, editing, and summarizing notes with AI!</p>
        <a href="{{ route('google.redirect') }}" class="btn btn-danger btn-lg">
            <i class="bi bi-google me-2"></i> Login with Google
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
